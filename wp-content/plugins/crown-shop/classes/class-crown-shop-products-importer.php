<?php

use Crown\AdminPage;
use Crown\Form\Field;
use Crown\Form\Input\Media as MediaInput;
use Crown\Form\Input\Text as TextInput;
use Crown\Form\Input\Textarea;
use Crown\ListTableColumn;
use Crown\Post\Type as PostType;

use GuzzleHttp\HandlerStack;

define('AMPLIFI_SYNC_STORED_LOG_FILES_LIMIT', 20);
define('AMPLIFI_TO_COLLECTION_IMPORT_TIMEOUT', 180); // 3 minutes
define('AMPLIFI_COLLECTION_TO_DB_IMPORT_TIMEOUT', 720); // 12 minutes
define('AMPLIFI_AUTO_COLLECTION_TO_DB_IMPORT_TIMEOUT', 420); // 7 minutes 
define('AMPLIFI_AUTO_SYNC_TO_COLLECTION_IMPORT_TIMEOUT', 3000); // 50 minutes


if ( ! class_exists( 'Crown_Shop_Products_Import' ) ) {
	class Crown_Shop_Products_Import {

        const AMPLIFI_IMPORT_REACHED_TIME_LIMIT = 'AMPLIFI TO COLLECTION IMPORT PROCESS REACHED TIME LIMIT';
        public static $init = false;
        public static string $manual_sync_products_from_collections_to_db_recurrence = '15min';
        public static int $auto_sync_products_from_collections_to_db_batch = 50;

		public static $product_collection_import_admin_page = null;
		public static $products_import_admin_page = null;
		public static $product_import_post_type = null;

        public static $amplifi_log_file_name = null;

        /**
         * Products background cleanup class.
         *
         * @var Crown_Products_Background_Cleanup
         */
        protected static $product_background_cleanup = null;
        public static string $amplifi_pick_list_attributes_table_name;

		public static function init() {
			if( self::$init ) return;
			self::$init = true;
            if ( defined( 'AMPLIFI_MANUAL_SYNC_PRODUCTS_FROM_COLLECTIONS_TO_DB_RECURRENCE' ) ) {
                self::$manual_sync_products_from_collections_to_db_recurrence = AMPLIFI_MANUAL_SYNC_PRODUCTS_FROM_COLLECTIONS_TO_DB_RECURRENCE;
            }
            if ( defined( 'AUTO_SYNC_PRODUCTS_FROM_COLLECTIONS_TO_DB_BATCH' ) ) {
                self::$auto_sync_products_from_collections_to_db_batch = AUTO_SYNC_PRODUCTS_FROM_COLLECTIONS_TO_DB_BATCH;
            }
			require_once plugin_dir_path( __FILE__ ) . '../inc/common.php';
            self::set_table_names();
            self::create_amplifi_attributes_table();
			add_action( 'init', array( __CLASS__, 'create_amplifi_auto_synced_products_table' ), 10 );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_product_import_post_type' ), 10 );

			add_action( 'after_setup_theme', array( __CLASS__, 'register_product_collection_import_admin_page' ) );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_products_import_admin_page' ) );

			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'register_admin_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'register_admin_styles' ) );

			add_action( 'wp_ajax_start_product_import', array( __CLASS__, 'ajax_start_product_import' ) );
			add_action( 'wp_ajax_product_import_page', array( __CLASS__, 'ajax_product_import_page' ) );

			add_action( 'init', array( __CLASS__, 'init_data_sync_schedule' ) );
			add_action( 'crown_auto_sync_amplifi_to_collections_import', array( __CLASS__, 'cron_auto_sync_amplifi_to_collections_import') );
			add_action( 'crown_auto_sync_amplifi_clear_synced_products_list', array( __CLASS__, 'cron_auto_sync_amplifi_clear_synced_products_list') );
			add_action( 'init', array( __CLASS__, 'handle_auto_sync_amplifi_to_collections_import' ), 1000 );
            add_action( 'crown_auto_sync_products_from_collections_to_db', array( __CLASS__, 'cron_auto_import_from_collections_to_db' ) );
			add_action( 'init', array( __CLASS__, 'handle_auto_sync_products_from_collections_to_db_request' ), 1000 );
			add_action( 'woocommerce_loaded', array( __CLASS__, 'init_product_background_cleanup' ), 1000 );

			add_action('acf/save_post', array( __CLASS__, 'request_to_product_category_import' ), 10, 2);
			add_action('acf/save_post', array( __CLASS__, 'request_to_manual_sync_ns_price_products_func' ), 10, 2);
			add_action('acf/save_post', array( __CLASS__, 'acs_safe_options_page_autosync_amplify' ), 10, 2);
            add_action('start_crown_manual_sync_amplifi_to_collections_import', array( __CLASS__, 'setup_schedule_manual_sync_amplifi_to_collections_import' ));
            add_action('crown_manual_sync_amplifi_to_collections_import', array( __CLASS__, 'manual_sync_amplifi_to_collections_import' ));
            add_action('start_crown_manual_sync_products_from_collections_to_db', array( __CLASS__, 'setup_schedule_manual_import_from_collections_to_db'));
            add_action('crown_manual_sync_products_from_collections_to_db', array( __CLASS__, 'manual_sync_products_amplify'));
			add_action('crown_amplify_products_clean_up', array( __CLASS__, 'cron_amplify_products_clean_up' ));
			add_action( 'init', array( __CLASS__, 'init_amplify_category_cleanup' ) );
            add_action( 'init', array( __CLASS__, 'init_amplify_attributes_sync' ) );
            add_action('crown_amplify_category_cleanup', array( __CLASS__, 'cron_amplify_category_cleanup' ));
            add_action('crown_amplify_attributes_sync', array( __CLASS__, 'cron_amplify_attributes_sync' ));
            add_action('rest_api_init', array( __CLASS__, 'register_rest_api_amplifi_category_import' ), 40);
            add_action('rest_api_init', array( __CLASS__, 'register_rest_api_amplifi_collection_import' ), 30);
			add_action('rest_api_init', array( __CLASS__, 'register_rest_api_amplifi_auto_sync_collections' ), 30);
			add_action('rest_api_init', array( __CLASS__, 'register_rest_api_manual_sync_ns_price_products' ), 20);

			add_filter( 'upload_mimes', array( __CLASS__, 'filter_allowed_upload_mimes' ) );
			add_filter( 'wp_check_filetype_and_ext', array( __CLASS__, 'validate_file_ext_and_type' ), 10, 4 );
			add_filter( 'acf/load_field', array( __CLASS__, 'disabled_acf_field_parent_id' ));
			add_filter( 'acf/load_field', array( __CLASS__, 'disabled_acf_field_nsi_default_region_id' ));
			add_filter('cron_schedules', array( __CLASS__, 'cron_add_interval'));

            self::init_settings_for_cron_manual_sync_amplifi_to_collections_import();

			add_action( 'init', array( __CLASS__, 'init_settings_for_cron_auto_sync_amplifi_to_collections_import' ) );
			add_action( 'init', array( __CLASS__, 'acf_update_settings_for_auto_sync_amplify' ) );

            if(is_admin()){
				add_action( 'init', array( __CLASS__, 'set_default_date_acf' ) );
			}

			if ( class_exists( 'WP_CLI' ) ) {
				/**
				 * WP_CLI background cleanup products allows to disable/delete products not in Default region.
				 *
				 * Usage:
				 * wp background cleanup products
				 * wp background cleanup products --force-delete
				 */
				WP_CLI::add_command( 'background cleanup products', function( $args, $assoc_args ) {
					$force = !empty( $assoc_args['force-delete'] );
					self::push_products_to_clean_up_queue($force);
					WP_CLI::log( 'Products pushed to cleanup queue.' );
				} );

				/**
				 * WP_CLI products status update allows to update products status.
				 *
				 * Usage:
				 * wp products status update --products=prodid1,prodid2,prodid3 --status=publish --purchasable=true
				 * wp products status update --skus=sku1,sku2 --status=publish --purchasable=false
				 * wp products status update --skus=sku1,sku2 --products=prodid1,prodid2,prodid3 --status=draft
				 */
				WP_CLI::add_command( 'products status update', function( $args, $assoc_args ) {
					$products = isset($assoc_args['products']) ? array_map('trim', explode(',', $assoc_args['products'])) : array();
					$skus = isset($assoc_args['skus']) ? array_map('trim', explode(',', $assoc_args['skus'])) : array();

					// Validate presence of product IDs or SKUs
					if( empty( $products ) && empty( $skus ) ) {
						WP_CLI::log( 'Product IDs or SKUs have to be provided!' );
						return;
                    }

                    // Extract status and purchasable from assoc_args with default values
				    $status = $assoc_args['status'] ?? '';
					$purchasable = isset( $assoc_args['purchasable'] ) ? filter_var( $assoc_args['purchasable'], FILTER_VALIDATE_BOOLEAN ) : TRUE;

					// Validate status
					if (!in_array($status, array('publish', 'draft'))) {
						WP_CLI::log( 'Status \'publish\' or \'draft\' should be provided.' );
						return;
                    }

                    // Process status update for products
                    WP_CLI::log( 'Processing status update for products...' );
                    foreach ( $skus as $sku ) {
                        $product_by_sku = self::get_product_id_by_sku( $sku );
                        if ( $product_by_sku && ! in_array( $product_by_sku, $products ) ) {
                            $products[] = $product_by_sku;
                        }
                    }

                    // Update product status based on the provided status
                    foreach ( $products as $product_id ) {
                        if ( $status === 'publish' ) {
                            enable_product( $product_id, $purchasable );
                        } elseif ( $status === 'draft' ) {
                            disable_product( $product_id );
                        }
                    }

                    WP_CLI::log( 'Finished processing status change for products.' );
                } );
            }

            if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'product_cat cleanup', function( $args ) {

					$post_ids = get_posts( array( 'post_type' => 'product', 'posts_per_page' => -1, 'fields' => 'ids' ) );
					foreach ( $post_ids as $i => $post_id ) {
						WP_CLI::log( 'Cleaning up post ' . $post_id . ' terms (' . $i . '/' . count( $post_ids ) . ')' );
						$category_tree = array(
							get_post_meta( $post_id, 'product_category', true ),
							get_post_meta( $post_id, 'product_line', true ),
							get_post_meta( $post_id, 'product_group', true )
						);
						$term = null;
						foreach ( $category_tree as $j => $name ) {
							$term_data = (object) array( 'taxonomy' => 'product_cat', 'name' => $name, 'slug' => sanitize_title( $name ), 'parent' => $term ? $term->term_id : 0 );
							$existing_terms = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $term ? $term->term_id : 0, 'fields' => 'id=>name', 'orderby' => 'term_id', 'order' => 'ASC' ) );
							if ( ( $exising_term_id = array_search( $name, $existing_terms ) ) ) {
								$term = get_term( $exising_term_id, $term_data->taxonomy );
							} else {
								$result = wp_insert_term( $term_data->name, $term_data->taxonomy, array( 'slug' => $term_data->slug, 'parent' => $term_data->parent ) );
								if ( ! is_wp_error( $result ) ) {
									$term = get_term( $result['term_id'], $term_data->taxonomy );
								}
							}
						}
						wp_set_object_terms( $post_id, $term ? array( $term->term_id ) : array(), $term->taxonomy );
					}

					// // reassign duplicate categories
					// WP_CLI::log( 'Cleaning up product category terms...' );
					// $terms = get_terms( array( 'taxonomy' => 'product_cat', 'orderby' => 'term_id', 'order' => 'ASC' ) );
					// $duplicate_term_ids_store = array();
					// foreach ( $terms as $i => $term ) {
					// 	if ( in_array( $term->term_id, $duplicate_term_ids_store ) ) continue;
					// 	WP_CLI::log( 'Cleaning up ' . $term->name . ' product category term (' . $i . '/' . count( $terms ) . ')' );
					// 	$duplicate_term_ids = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $term->parent, 'name' => $term->name, 'fields' => 'ids' ) );
					// 	if ( count( $duplicate_term_ids ) > 1 ) {
					// 		sort( $duplicate_term_ids );
					// 		$primary_term_id = array_shift( $duplicate_term_ids );
					// 		$product_ids = get_posts( array( 'post_type' => 'product', 'posts_per_page' => -1, 'fields' => 'ids', 'tax_query' => array( array( 'taxonomy' => 'product_cat', 'terms' => $duplicate_term_ids ) ) ) );
					// 		foreach( $product_ids as $product_id ) {
					// 			wp_remove_object_terms( $product_id, $duplicate_term_ids, 'product_cat' );
					// 			wp_add_object_terms( $product_id, $primary_term_id, 'product_cat' );
					// 		}
					// 		$duplicate_term_ids_store = array_merge( $duplicate_term_ids_store, $duplicate_term_ids );
					// 	}
					// }

					// delete unused categories
					WP_CLI::log( 'Deleting unused product category terms...' );
					$terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'pad_counts' => true ) );
					foreach ( $terms as $i => $term ) {
						WP_CLI::log( 'Deleting ' . $term->name . ' specialty term (' . $i . '/' . count( $terms ) . ') (count: ' . $term->count . ')' );
						if ( $term->count == 0 ) {
							wp_delete_term( $term->term_id, 'product_cat' );
						}
					}

				} );

                WP_CLI::add_command( 'product nocat-uncat', function() {
                    $uncategorized = get_term_by( 'slug', 'uncategorized', 'product_cat' );
                    if ( ! $uncategorized ) {
                        WP_CLI::error( 'Uncategorized category not found.' );
                        return;
                    }
                    $uncat_id = $uncategorized->term_id;

                    $args = array(
                        'post_type'      => 'product',
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                        'fields'         => 'ids',
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'operator' => 'NOT EXISTS',
                            ),
                        ),
                    );
                    $products = get_posts( $args );
                    $count = 0;
                    foreach ( $products as $product_id ) {
                        wp_set_post_terms( $product_id, array( $uncat_id ), 'product_cat', false );
                        $count++;
                    }
                    WP_CLI::success( "Assigned 'Uncategorized' to {$count} products." );
                } );

			}

			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'product cleanup', function( $args ) {

					$post_ids = get_posts( array( 'post_type' => 'product', 'posts_per_page' => -1, 'fields' => 'ids' ) );
					foreach ( $post_ids as $i => $post_id ) {
						WP_CLI::log( 'Cleaning up post ' . $post_id . ' (' . ( $i + 1 ) . '/' . count( $post_ids ) . ')' );

						// $term_ids = wp_get_object_terms( $post_id, 'product_cat', array( 'fields' => 'ids' ) );
						// if ( empty( $term_ids ) ) {
						// 	wp_set_object_terms( $post_id, array(), 'product_cat' );
						// }

						// update_post_meta( $post_id, '_stock', null );
						// update_post_meta( $post_id, '_stock_status', 'instock' );

						update_post_meta( $post_id, '_backorders', 'yes' );

					}

				} );
			}

			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'product cleanup_imports', function( $args ) {

					print_r( self::get_product_id_by_sku( 'IT-600' ) ); die;

					$post_ids = get_posts( array( 'post_type' => 'product_import', 'posts_per_page' => -1, 'fields' => 'ids' ) );
					foreach ( $post_ids as $i => $post_id ) {
						WP_CLI::log( 'Cleaning up post ' . $post_id . ' (' . ( $i + 1 ) . '/' . count( $post_ids ) . ')' );

						// $collection = get_post_meta( $post_id, 'collection_data', true );
						// $sku_attrs = array_values( array_filter( $collection->attributes, function( $n ) { return isset( $n->label ) && $n->label == 'SKU'; } ) );
						// $sku = ! empty( $sku_attrs ) && isset( $sku_attrs[0]->value ) ? $sku_attrs[0]->value : '';
						// update_post_meta( $post_id, 'collection_sku', $sku );

						$sku = get_post_meta( $post_id, 'collection_sku', true );
						if ( ! empty( $sku ) ) {
							$postarr = array(
								'ID' => $post_id,
								'post_title' => '[' . $sku . '] ' . get_the_title( $post_id )
							);
							wp_update_post( $postarr );
						}

					}

				} );
			}

			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'product delete_all', function( $args ) {
					$post_ids = get_posts( array( 'post_type' => 'product', 'posts_per_page' => -1, 'fields' => 'ids' ) );
					foreach ( $post_ids as $i => $post_id ) {
						WP_CLI::log( 'Deleting post ' . $post_id . ' (' . ( $i + 1 ) . '/' . count( $post_ids ) . ')' );
						wp_delete_post( $post_id, true );
					}
					$term_ids = get_terms( array( 'taxonomy' => 'product_cat', 'fields' => 'ids', 'hide_empty' => false ) );
					foreach ( $term_ids as $i => $term_id ) {
						WP_CLI::log( 'Deleting term ' . $term_id . ' (' . ( $i + 1 ) . '/' . count( $term_ids ) . ')' );
						wp_delete_term( $term_id, 'product_cat' );
					}
					$term_ids = get_terms( array( 'taxonomy' => 'product_brand', 'fields' => 'ids', 'hide_empty' => false ) );
					foreach ( $term_ids as $i => $term_id ) {
						WP_CLI::log( 'Deleting term ' . $term_id . ' (' . ( $i + 1 ) . '/' . count( $term_ids ) . ')' );
						wp_delete_term( $term_id, 'product_brand' );
					}
					if ( class_exists( 'WC_Install' ) ) WC_Install::create_terms();
				} );
			}

			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'product delete_all_imports', function( $args ) {
					$post_ids = get_posts( array( 'post_type' => 'product_import', 'posts_per_page' => -1, 'fields' => 'ids', 'post_status' => 'all' ) );
					foreach ( $post_ids as $i => $post_id ) {
						WP_CLI::log( 'Deleting post ' . $post_id . ' (' . ( $i + 1 ) . '/' . count( $post_ids ) . ')' );
						wp_delete_post( $post_id, true );
					}
				} );
			}

			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'product delete_all_categories', function( $args ) {
					$term_ids = get_terms( array( 'taxonomy' => 'product_cat', 'fields' => 'ids', 'hide_empty' => false ) );
					foreach ( $term_ids as $i => $term_id ) {
						WP_CLI::log( 'Deleting term ' . $term_id . ' (' . ( $i + 1 ) . '/' . count( $term_ids ) . ')' );
						wp_delete_term( $term_id, 'product_cat' );
					}
					if ( class_exists( 'WC_Install' ) ) WC_Install::create_terms();
				} );
			}

			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'product_cat sync', function( $args ) {
					self::import_categories();
				} );
			}

            /**
             * WP_CLI product import force call the stage 'collection import queue to db'.
             *
             * Usage:
             * wp trigger product_import processing - process everything until end from the collection to db queue
             * wp trigger product_import processing 500|1231|3|n - process n collections from the collection to db queue
             */
			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'trigger product_import processing', function( $args ) {
				    $batch_size = (!empty($args[0]))? $args[0] : '';
                    self::sync_products_from_collections( $batch_size );
                    WP_CLI::success( 'Product import processing triggered.' );
				} );
			}

			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'product collection import', function( $args ) {
					if ( count( $args ) < 1 ) return;
					$collection_id = $args[0];
					self::import_categories();
					$success = self::sync_product_data( $collection_id );
					if ( $success === true ) {
						WP_CLI::success( 'Complete' );
					} else {
						WP_CLI::error( $success );
					}
				} );
			}

			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'product category import', function( $args ) {
					if ( count( $args ) < 1 ) return;
					$category_id = $args[0];
					$batch_size = (!empty($args[1]))? $args[1] : 50;
					$count_page = 0;
					$count = 0;
					$max_page_count = 500;
						for ($count_page; $count_page < $max_page_count; $count_page++) {

							WP_CLI::log( 'count_page processing - ' . $count_page);
							$nsi_default_region_id 	= get_amplify_region_id();
							$params = [
								'parent_id' => $category_id,
								'folder_level' => 'leaf',
								'limit' => $batch_size,
								'minified' => 'true',
                                'region_ids' => $nsi_default_region_id,
								'offset' => ($batch_size * $count_page)
							];
							$attributes = self::get_amplifi_pick_list_attributes();
							if (!empty($attributes)) {
								update_option('amplifi_attributes_mapping', $attributes, false);
							}
							
							$collections = Crown_Amplifi_Api::get_collections( $params );
							
							WP_CLI::log( 'parent_id - ' . $params['parent_id'] . '; offset - ' . $params['offset']);

							if(!empty($collections)){
								foreach ( $collections as $collection ) {
									$count++;
									$sku = self::get_product_sku_from_collection_data( $collection );

									$collection_region_ids = property_exists( $collection, 'region_ids' ) && is_array( $collection->region_ids ) ? $collection->region_ids : array();
									// skip if not NSI default
									$is_nsi_default = in_array( $nsi_default_region_id, $collection_region_ids );

									WP_CLI::log($count .') colection ID - ' . $collection->id . '; colection name - ' . $collection->name . '; is_nsi_default - ' . $is_nsi_default .'; SKU - ' . $sku);

									if ( ! $is_nsi_default ) {
										self::disable_products_without_nsi_region($sku, $collection_region_ids);
										continue;
									}

									$postarr = array(
										'post_type' => 'product_import',
										'post_status' => 'publish',
										'post_title' => $collection->name
									);
									if ( property_exists( $collection, 'additional_title' ) && ! empty( $collection->additional_title ) ) $postarr['post_title'] = $collection->additional_title;
									if ( ! empty( $sku ) ) $postarr['post_title'] = '[' . $sku . '] ' . $postarr['post_title'];
					
									$import_id = self::get_product_import_id_by_collection_id( $collection->id );
									if ( ! $import_id ) {
										$import_id = wp_insert_post( $postarr );
										update_post_meta( $import_id, 'collection_id', $collection->id );
										WP_CLI::log('import ID product - ' .$import_id);
									} else {
										wp_update_post( array_merge( $postarr, array( 'ID' => $import_id ) ) );
									}
									update_post_meta( $import_id, 'collection_data', $collection );
									update_post_meta( $import_id, 'collection_sku', $sku );
								}
							} else {
								$count_page = $max_page_count;
								break;
							}
							
						}

						WP_CLI::success( 'Complete - ' . $params['offset'] );
				} );
			}

			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'product sku import', function( $args ) {
					if ( count( $args ) < 1 ) return;
                        if ( defined( 'TMWNI_DIR' ) ) {
                            require_once(TMWNI_DIR . 'inc/item.php');
                            $netsuiteClient = new ItemClient();
                        }
						if ( count( $args ) == 1 ){
								$sku = $args[0];
								$product_id = self::get_product_id_by_sku( $sku );
								$netsuiteClient->searchItemBySkuUpdateInventory( get_post_meta( $product_id, '_sku', true ), $product_id, 'all' );
								WP_CLI::success( 'SKU - '  . $sku . '; Product ID - ' . $product_id);
						} else {
							foreach ($args as $sku) {
								$product_id = self::get_product_id_by_sku( $sku );
								$netsuiteClient->searchItemBySkuUpdateInventory( get_post_meta( $product_id, '_sku', true ), $product_id, 'all' );
								WP_CLI::success( 'SKU - '  . $sku . '; Product ID - ' . $product_id);
							}
						}
					 WP_CLI::success( 'Complete' );
				} );
			}

			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'products lookup table update', function( $args ) {
				    $product_ids = get_posts( array( 'post_type' => 'product', 'posts_per_page' => -1, 'fields' => 'ids' ) );
					foreach ($product_ids as $i => $product_id) {
						WP_CLI::log( 'Updating lookup data for product ' . $product_id . ' (' . ( $i + 1 ) . '/' . count( $product_ids ) . ')' );
						self::update_lookup_table( $product_id, 'wc_product_meta_lookup' );
                    }
				} );
			}

		}

        private static function set_table_names() {
            global $wpdb;
            self::$amplifi_pick_list_attributes_table_name = $wpdb->prefix . 'amplifi_pick_list_attributes';
        }

        public static function create_amplifi_attributes_table() {
            global $wpdb;

            $amplifi_attributes_table_created = get_option( 'amplifi_attributes_table_created' );
            if( !$amplifi_attributes_table_created ) {
                $charset_collate = $wpdb->get_charset_collate();

                $sql = "CREATE TABLE IF NOT EXISTS " . self::$amplifi_pick_list_attributes_table_name . " (
                    `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `amplifi_id` varchar(100) NOT NULL,
                    `label` varchar(255) NOT NULL,
                    `options` longtext DEFAULT NULL,
                    `value_type` varchar(50) NOT NULL,
                    PRIMARY KEY (id)
                ) $charset_collate;";

                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
                update_option( 'amplifi_attributes_table_created', true );
            }
        }

		/**
		 * Requests a manual synchronization of NS price products.
		 *
		 * This function is triggered when the user visits the 'acf-options-manual-sync-ns' page.
		 * It sends a GET request to the '/wp-json/netsuite/v2/manual-sync-ns-price-products' endpoint
		 * to initiate the synchronization process.
		 *
		 * @return void
		 */
		public static function request_to_manual_sync_ns_price_products_func() {

			$screen = $_GET['page'];

			if ($screen == 'acf-options-manual-sync-ns') {
                $type = get_field('sync_type', 'option');
				$request_url = get_site_url() . '/wp-json/netsuite/v2/manual-sync-ns-price-products?type=' . $type;

                $response = wp_remote_get( $request_url, array(
					'headers' => array(
						'Accept-Language' => 'en-US'
					),
					'timeout' => 30,
					'redirection' => 5,
					'httpversion' => '1.1',
					'sslverify' => false
				));
			}
		}

		/**
		 * ACF Save Options Page Manual Sync NS Price Products
		 *
		 * This method is responsible for performing a manual synchronization of NS price products.
		 * It creates a log file to track the synchronization process and updates the inventory of the specified products.
		 * If the 'sync_all_products' option is enabled, it clears the scheduled hooks for inventory processing and triggers the 'tm_ns_process_inventories' action.
		 * 
		 * @return void
		 */
		public static function acf_save_options_page_manual_sync_ns_price_products( WP_REST_Request $request ) {
            $params = $request->get_query_params();
            $type = $params['type'] ?? 'all';

			$file_dir 		= wp_upload_dir();
			$date_current 	= date("Y-m-d");
			$folder_name 	= 'manual-sync-ns-logs';
			$path_folder 	= $file_dir['basedir'] . '/' . $folder_name;
			$log_file 		= $path_folder . '/manual-sync-ns-products-'.$date_current.'.log';
			
			if ( !file_exists($path_folder)) {
				mkdir( $path_folder, 0755 );       
			} 

			if(!file_exists($log_file)) {
				fopen($log_file, 'w');
				chmod($log_file, 0777);
			} 

			$sync_all_products = get_field('sync_all_products', 'option');

			if(!$sync_all_products) {

				$skus = get_field('sku_product_acf', 'option');

				if(!empty($skus)) {
					$data_ns = explode(' ', $skus);
				}

				if ( count( $data_ns ) < 1 ) return;

				if ( defined( 'TMWNI_DIR' ) ) {
					require_once(TMWNI_DIR . 'inc/item.php');
					$netsuiteClient = new ItemClient();
				}

				if ( count( $data_ns ) == 1 ) {
					$sku = $data_ns[0];
					$product_id = self::get_product_id_by_sku( $sku );
					$netsuiteClient->searchItemBySkuUpdateInventory( get_post_meta( $product_id, '_sku', true ), $product_id, $type );
					self::update_lookup_table( $product_id, 'wc_product_meta_lookup' );

					$output = "\n" . date( 'Y-m-d H:i:s' ) . '; SKU - '  . $sku . '; Product ID - ' . $product_id . '; manual by sku; Update type - ' . $type;
					file_put_contents( $log_file, $output, FILE_APPEND );
				} else {
					foreach ($data_ns as $sku) {
						$product_id = self::get_product_id_by_sku( $sku );
						$netsuiteClient->searchItemBySkuUpdateInventory( get_post_meta( $product_id, '_sku', true ), $product_id, $type );
						self::update_lookup_table( $product_id, 'wc_product_meta_lookup' );

						$output = "\n" . date( 'Y-m-d H:i:s' ) . '; SKU - '  . $sku . '; Product ID - ' . $product_id . '; manual by sku; Update type - ' . $type;
						file_put_contents( $log_file, $output, FILE_APPEND );
					}
				}
			} else {
                if ( $type === 'price' ) {
                    wp_clear_scheduled_hook( 'tm_ns_process_inventories_price' );
                    do_action( 'tm_ns_process_inventories_price' );
                } else if ( $type === 'inventory' ) {
                    wp_clear_scheduled_hook( 'tm_ns_process_inventories_stock_quant' );
                    do_action( 'tm_ns_process_inventories_stock_quant' );
                } else {
                    wp_clear_scheduled_hook( 'tm_ns_process_inventories_price' );
                    do_action( 'tm_ns_process_inventories_price' );
                    wp_clear_scheduled_hook( 'tm_ns_process_inventories_stock_quant' );
                    do_action( 'tm_ns_process_inventories_stock_quant' );
                }
			}
		}


		public static function register_product_import_post_type() {
			self::$product_import_post_type = new PostType( array(
				'name' => 'product_import',
				'singularLabel' => 'Product Collection',
				'pluralLabel' => 'Products Collections',
				'settings' => array(
					'supports' => array( 'title' ),
					'public' => false,
					'show_ui' => true,
					'show_in_menu' => 'edit.php?post_type=product',
					'labels' => array(
						'all_items' => 'Collections to Import'
					)
				),
				'fields' => array(
					new Field( array(
						'getOutputCb' => function( $field, $args ) {
							echo '<div class="crown-field"><div class="input-wrap"><textarea rows=40>';
							print_r( get_post_meta( $args['objectId'], 'collection_data', true ) );
							echo '</textarea></div></div>';
						}
					) )
				),
				'listTableColumns' => array(
					new ListTableColumn( array(
						'key' => 'collection-id',
						'title' => 'Collection ID',
						'position' => 2,
						'outputCb' => function( $post_id, $args ) {
							$collection_id = get_post_meta( $post_id, 'collection_id', true );
							echo ( !empty( $collection_id ) ) ? $collection_id : 'N/A';
						}
					) ),
					new ListTableColumn( array(
						'key' => 'sku',
						'title' => 'SKU',
						'position' => 3,
						'outputCb' => function( $post_id, $args ) {
							$collection_sku = get_post_meta( $post_id, 'collection_sku', true );
							echo ( !empty( $collection_sku ) ) ? $collection_sku : 'N/A';
						}
					) ),
					new ListTableColumn( array(
						'key' => 'sync-time',
						'title' => 'Sync Time',
						'position' => 4,
						'outputCb' => function( $post_id, $args ) {
							// $timezone = get_option( 'timezone_string' );
							// $timezone = ! empty( $timezone ) ? new DateTimeZone( $timezone ) : $timezone;
							// $timezone_offset_hours = is_a( $timezone, 'DateTimeZone' ) ? floatval( $timezone->getOffset( new DateTime() ) / 60 / 60 ) : -floatval( get_option( 'gmt_offset', 0 ) );
							$sync_time = new DateTime( get_the_modified_time( 'Y-m-d H:i:s', $post_id ) );
							// $sync_time->modify( $timezone_offset_hours.' hours' );
							echo $sync_time->format( 'n/j/Y g:i:sA' );
						},
						'sortCb' => function ( $args ) {
							$args['orderby'] = 'modified';
							return $args;
						}
					) )
				)
			) );
		}


		public static function register_product_collection_import_admin_page() {

			if ( ! class_exists( 'woocommerce' ) ) return;

			self::$product_collection_import_admin_page = new AdminPage( array(
				'key' => 'crown-shop-product-collection-import',
				'parent' => 'edit.php?post_type=product',
				'title' => 'Product Collection Import',
				'menuTitle' => 'Import Collection',
				'fields' => array(
					new Field( array(
						'label' => 'Import Collection ID',
						'description' => 'Provide the Amplifi ID of the individual collection to import.',
						'input' => new Textarea( ['name' => 'cspi_import_collection_id', 'rows' => 16, 'mode' => 'text', 'atts' => array( 'style' => 'font-family: monospace; font-size: 16px;' ) ] )
					) )
				),
				'saveMetaCb' => function($input, $args, $fields ){
					$request_url = get_site_url() . '/wp-json/amplify/v2/product-collection-import';

					$response = wp_remote_get( $request_url, [
						'headers' 		=> array('Accept-Language' => 'en-US'),
						'timeout' 		=> 30,
						'redirection' 	=> 5,
						'httpversion' 	=> '1.1',
						'sslverify' 	=> false
					]);
				}
			) );

		}

		public static function process_imported_collections($request) {
			$collection_ids = get_option( 'cspi_import_collection_id' );
			if ( ! empty( $collection_ids ) ) {
				$collection_ids = explode(" ", $collection_ids);
                foreach($collection_ids as $collection_id){
					if(!empty($collection_id)){
						$success = self::sync_product_data( $collection_id );

						if ( $success === true ) {
							$product_id = self::get_product_id_by_collection_id( $collection_id );

							if ( defined( 'TMWNI_DIR' ) ) {
								require_once(TMWNI_DIR . 'inc/item.php');
								$netsuiteClient = new ItemClient();
								$netsuiteClient->searchItemBySkuUpdateInventory( get_post_meta( $product_id, '_sku', true ), $product_id, 'all' );
							}
						}
					}
				}
				update_option( 'cspi_import_collection_id', '' );
			}
		}

		public static function register_products_import_admin_page() {

			if ( ! class_exists( 'woocommerce' ) ) return;

			self::$products_import_admin_page = new AdminPage( array(
				'key' => 'crown-shop-products-import',
				'parent' => 'edit.php?post_type=product',
				'title' => 'Products Import',
				'menuTitle' => 'Import Product Data',
				'fields' => array(
					new Field( array(
						'label' => 'Import Data File',
						'description' => 'Upload a CSV export from Amplifi using the "NSi WooCommerce" mapping.',
						'input' => new MediaInput( array( 'name' => 'cspi_import_file', 'mimeType' => 'text/csv' ) )
					) )
				),
				'outputCb' => function( $args ) {

					// self::auto_sync_products_from_collections_to_db();
					// self::import_categories();
					// self::delete_unsynced_products();

					$timezone = get_option( 'timezone_string' );
					$timezone = ! empty( $timezone ) ? new DateTimeZone( $timezone ) : $timezone;
					$timezone_offset_hours = is_a( $timezone, 'DateTimeZone' ) ? floatval( $timezone->getOffset( new DateTime() ) / 60 / 60 ) : -floatval( get_option( 'gmt_offset', 0 ) );
					
					$current_sync_time = new DateTime( get_option( 'crown_product_api_sync_start_time', 0 ) );
					$current_sync_time->modify( $timezone_offset_hours.' hours' );
                    $datenow = new DateTime( date( 'Y-m-d H:i:s' ) );
					echo '<br><strong>DateTime now:</strong> ' . $datenow->format( 'n/j/Y g:ia' );
					echo '<br><strong>Current Sync Start:</strong> ' . $current_sync_time->format( 'n/j/Y g:ia' );

					echo '<br><strong>Current Page Synced:</strong> ' . get_option( 'crown_product_api_sync_page', 0 );

					if ( wp_next_scheduled( 'crown_auto_sync_amplifi_to_collections_import' ) ) {
						$next_sync_time = new DateTime( date( 'Y-m-d H:i:s', wp_next_scheduled( 'crown_auto_sync_amplifi_to_collections_import' ) ) );
						$next_sync_time->modify( $timezone_offset_hours.' hours' );
						echo '<br><strong>Next Scheduled Sync:</strong> ' . $next_sync_time->format( 'n/j/Y g:ia' );
					} else {
						echo '<br><strong>Next Scheduled Sync:</strong> Unscheduled';
					}

					echo '<br>';
					if ( ! empty( get_option( 'crown_product_api_import_start_time', '' ) ) ) {
						$current_import_time = new DateTime( get_option( 'crown_product_api_import_start_time', 0 ) );
						$current_import_time->modify( $timezone_offset_hours.' hours' );
						echo '<br><strong>Current Import Start:</strong> ' . $current_import_time->format( 'n/j/Y g:ia' );
					}

					if ( wp_next_scheduled( 'crown_auto_sync_products_from_collections_to_db' ) ) {
						$next_sync_time = new DateTime( date( 'Y-m-d H:i:s', wp_next_scheduled( 'crown_auto_sync_products_from_collections_to_db' ) ) );
						$next_sync_time->modify( $timezone_offset_hours.' hours' );
						echo '<br><strong>Next Scheduled Import:</strong> ' . $next_sync_time->format( 'n/j/Y g:ia' );
					} else {
						echo '<br><strong>Next Scheduled Import:</strong> Unscheduled';
					}

					echo '<br><br><br><br>';
					if ( wp_next_scheduled( 'tm_ns_process_inventories' ) ) {
						$next_sync_time = new DateTime( date( 'Y-m-d H:i:s', wp_next_scheduled( 'tm_ns_process_inventories' ) ) );
						$next_sync_time->modify( $timezone_offset_hours.' hours' );
						echo '<strong>Next Scheduled Inventory Sync #1:</strong> ' . $next_sync_time->format( 'n/j/Y g:ia' );
					} else {
						echo '<strong>Next Scheduled Inventory Sync #1:</strong> Unscheduled';
					}
					echo '<br>';
					if ( wp_next_scheduled( 'tm_ns_process_inventories_2' ) ) {
						$next_sync_time = new DateTime( date( 'Y-m-d H:i:s', wp_next_scheduled( 'tm_ns_process_inventories_2' ) ) );
						$next_sync_time->modify( $timezone_offset_hours.' hours' );
						echo '<strong>Next Scheduled Inventory Sync #2:</strong> ' . $next_sync_time->format( 'n/j/Y g:ia' );
					} else {
						echo '<strong>Next Scheduled Inventory Sync #2:</strong> Unscheduled';
					}
					echo '<br>';
					if ( wp_next_scheduled( 'tm_ns_process_inventories_3' ) ) {
						$next_sync_time = new DateTime( date( 'Y-m-d H:i:s', wp_next_scheduled( 'tm_ns_process_inventories_3' ) ) );
						$next_sync_time->modify( $timezone_offset_hours.' hours' );
						echo '<strong>Next Scheduled Inventory Sync #3:</strong> ' . $next_sync_time->format( 'n/j/Y g:ia' );
					} else {
						echo '<strong>Next Scheduled Inventory Sync #3:</strong> Unscheduled';
					}
					echo '<br>';echo '<br><br><br><br>';
					if ( wp_next_scheduled( 'tm_ns_process_inventories_price' ) ) {
						$next_sync_time = new DateTime( date( 'Y-m-d H:i:s', wp_next_scheduled( 'tm_ns_process_inventories_price' ) ) );
						$next_sync_time->modify( $timezone_offset_hours.' hours' );
						echo '<strong>Next Scheduled Inventory Price Sync #1:</strong> ' . $next_sync_time->format( 'n/j/Y g:ia' );
					} else {
						echo '<strong>Next Scheduled Inventory Price Sync #1:</strong> Unscheduled';
					}
                    echo '<br><br>';
					if ( wp_next_scheduled( 'tm_ns_process_inventories_stock_quant' ) ) {
						$next_sync_time = new DateTime( date( 'Y-m-d H:i:s', wp_next_scheduled( 'tm_ns_process_inventories_stock_quant' ) ) );
						$next_sync_time->modify( $timezone_offset_hours.' hours' );
						echo '<strong>Next Scheduled Inventory Quantity/Stock Sync #1:</strong> ' . $next_sync_time->format( 'n/j/Y g:ia' );
					} else {
						echo '<strong>Next Scheduled Inventory Quantity/Stock Sync #1:</strong> Unscheduled';
					}
					echo '<br>';

					// echo '<br><br>';
					// $timezone = get_option( 'timezone_string' );
					// $timestamp1 = new DateTime( 'now', new DateTimeZone( $timezone ) );
					// $timestamp2 = new DateTime( 'now', new DateTimeZone( $timezone ) );
					// $timestamp3 = new DateTime( 'now', new DateTimeZone( $timezone ) );
					// $timestamp1->modify( 'tomorrow 6am' );
					// $timestamp2->modify( 'tomorrow 10am' );
					// $timestamp3->modify( 'tomorrow 3pm' );
					// echo $timestamp1->format( 'n/j/Y g:ia' ).'<br>';
					// echo $timestamp2->format( 'n/j/Y g:ia' ).'<br>';
					// echo $timestamp3->format( 'n/j/Y g:ia' ).'<br>';

					return;

					$file_id = get_option( 'cspi_import_file' );
					$file = get_attached_file( $file_id );
					if ( $file && file_exists( $file ) ) {
						self::output_product_import_ui();
						return;
					}

					?>
						<form method="post">

							<div id="crown-admin-page-fields">
								<?php
									foreach ( self::$products_import_admin_page->getFields() as $field ) {
										$fieldValue = $field->getValue( 'blog' );
										$field->output( array( 'value' => $fieldValue ) );
									}
								?>
							</div>

							<p class="submit">
								<button type="submit" name="action" class="button button-primary" value="update">Begin Import</button>
							</p>

							<?php wp_nonce_field( 'crown_save_admin_page_' . self::$products_import_admin_page->getKey(), 'nonce_admin_page_' . self::$products_import_admin_page->getKey() ); ?>

						</form>
					<?php

				}
			) );

		}


		public static function filter_allowed_upload_mimes( $mimes ) {
			$mimes = array_merge( $mimes, array(
				'csv' => 'text/csv'
			) );
			return $mimes;
		}
	
	
		public static function validate_file_ext_and_type( $check, $file, $filename, $mimes ) {
			if ( $check['ext'] && $check['type'] ) {
				return $check;
			}
			return array_merge( $check, wp_check_filetype( $filename, apply_filters( 'upload_mimes', array() ) ) );
		}


		public static function output_product_import_ui() {

			$data = self::get_import_data();
			if ( empty( $data ) ) return;

			?>
				<div id="cspi-progress-bar"><div class="progress"></div></div>
			<?php

		}


		protected static function get_import_data() {

			$import_file_id = get_option( 'cspi_import_file' );
			$import_file = get_attached_file( $import_file_id );
			if ( ! $import_file || ! file_exists( $import_file ) ) return array();

			$data_keys = array();
			$data = array();
			if ( ( $fp = fopen( $import_file, 'r' ) ) !== FALSE ) {
				for ( $i = 0; ( $row_data = fgetcsv( $fp ) ) !== FALSE; $i++ ) {
					if ( $i == 0 ) {
						$data_keys = $row_data;
					} else {
						$data[] = array_combine( $data_keys, $row_data );
					}
				}
				fclose( $fp );
			}
			
			return $data;

		}

		public static function register_admin_scripts( $hook ) {
			
			$screen = get_current_screen();
			if ( $screen->id == 'product_page_crown-shop-products-import' ) {
				ob_start();
				?>
					<script>
						(function($) {

						var recordsToSync = false;
						var recordsSynced = false;

						$(document).ready(function() {

							updateProgressBar(0, 1);
							var url = '<?php echo admin_url('admin-ajax.php'); ?>';
							var data = { action: 'start_product_import' };
							$.get(url, data, function(response) {
								// console.log(response);
								if(response.success) {
									recordsToSync = response.record_count;
									recordsSynced = 0;
									importRecordsPage(1);
								}
							}, 'JSON');

						});

						var importRecordsPage = function(page) {
							var url = '<?php echo admin_url('admin-ajax.php'); ?>';
							var data = { action: 'product_import_page', page: page };
							$.get(url, data, function(response) {
								// console.log(response);
								if(response.success) {
									if(!response.records_synced) {
										recordsSynced = recordsToSync;
										updateProgressBar(recordsSynced, recordsToSync);
									} else {
										recordsSynced += response.records_synced;
										updateProgressBar(recordsSynced, recordsToSync);
										importRecordsPage(response.page + 1);
									}
								}
							}, 'JSON');
						};

						var updateProgressBar = function(complete, total) {
							var progressBar = $('#cspi-progress-bar .progress');
							progressBar.parent().show();
							progressBar.css({ width: ((complete / total) * 100) + '%' });
							if(complete == total && total > 0) {
								progressBar.parent().addClass('complete');
							}
						};

						})(jQuery);
					</script>
				<?php
				$js = preg_replace( array('/^<script>/', '/<\/script>$/' ), '', trim( ob_get_clean() ) );
				wp_add_inline_script('common', $js);

			}

		}


		public static function register_admin_styles( $hook ) {
			
			$screen = get_current_screen();
			if ( $screen->id == 'product_page_crown-shop-products-import' ) {
				ob_start();
				?>
					<style>
						#cspi-progress-bar {
							margin: 10px 0 0;
							background-color: #e3e3e3;
							height: 20px;
							border-radius: 3px;
							overflow: hidden;
							display: none;
						}
						#cspi-progress-bar.active {
							display: block;
						}
						#cspi-progress-bar .progress {
							height: 20px;
							background-color: #0073aa;
							width: 0%;
							transition: width .2s ease-out, background-color .2s .2s;
						}
						#cspi-progress-bar.complete .progress {
							background-color: #00a32a;
						}
					</style>
				<?php
				$css = preg_replace( array( '/^<style>/', '/<\/style>$/' ), '', trim( ob_get_clean() ) );
				wp_add_inline_style( 'common', $css );

			}

		}


		public static function ajax_start_product_import() {

			$response = (object) array(
				'success' => true,
				'record_count' => 0
			);

			$data = self::get_import_data();
			$response->record_count = count( $data );

			wp_send_json( $response );

		}


		public static function ajax_product_import_page() {

			$page = isset( $_GET['page'] ) ? intval( $_GET['page'] ) : 10;
			$page_size = 1;

			$response = (object) array(
				'success' => true,
				'page' => $page,
				'records_synced' => 0
			);

			$data = self::get_import_data();
			$page_data = array_slice( $data, ( $page - 1 ) * $page_size, $page_size );

            $date_current = date('Y-m-d');
            self::$amplifi_log_file_name = self::get_amplifi_log_file_path('', $date_current,
                'amplify-logs/amplify-products-import-manual-by-sku',
                'auto_sync_collections_to_db');

			foreach ( $page_data as $record ) {
				self::import_record( $record );
			}

			if ( empty( $page_data ) ) { // finished importing

				// unset import file
				delete_option( 'cspi_import_file' );

			}

			$response->records_synced = count( $page_data );
			wp_send_json( $response );

		}

		protected static function import_record( $record , $id_collection_to_import = null) {
			$sku = self::get_record_prop( $record, 'SKU' );
			if ( empty( $sku ) ) {
				wp_delete_post( $id_collection_to_import, true );
                return false;
            }

			$settings_cron 	= get_option('settings_for_cron_manual_sync_amplifi_from_collections_to_db');

			if($settings_cron['start_time'] !== 0) {
				$date_current = $settings_cron['start_time'];
			} else {
				$date_current = date('Y-m-d-H-i-s');
				$settings_cron['start_time'] = $date_current;
			}

			$amplifi_log_file_path = self::$amplifi_log_file_name ?? self::get_amplifi_log_file_path('', $date_current,
                'amplify-logs/amplify-products-import-auto',
                'auto_sync_collections_to_db');

			// create or retrieve post ID
			$post_id = 0;
			$result = self::find_product_by_sku( $sku );
			if ( empty( $result ) ) {
				$title = self::get_record_prop( $record, 'TITLE' );
				if ( empty( $title ) ) $title = self::get_record_prop( $record, 'Additional Title' );
				if ( empty( $title ) ) {
					wp_delete_post( $id_collection_to_import, true );
					$output = "[ " . date('Y-m-d-H-i-s') . ' ]; Product SKU: ' . $sku . ' is not imported as it doesn\'t have title provided; ' . "\n";
					file_put_contents( $amplifi_log_file_path, $output, FILE_APPEND );

					// updated settings time for name log file
					update_option('settings_for_cron_manual_sync_amplifi_from_collections_to_db', $settings_cron, false);

					return false;
				}
				$post_id = wp_insert_post( array(
					'post_type' => 'product',
					'post_status' => 'publish',
					'post_title' => $title
				) );
				update_post_meta( $post_id, '_sku', $sku );

				$status_product = 'create';

				self::update_lookup_table( $post_id, 'wc_product_meta_lookup', TRUE );
			} else {
				$post_id = $result['id'];
				$status_product = 'update';
			}

			if (get_post_status($post_id) === 'draft') {
				wp_update_post( array(
					'ID'            => $post_id,
					'post_status'   => 'publish',
				) );

				if ( defined( 'TMWNI_DIR' ) ) {
					require_once(TMWNI_DIR . 'inc/item.php');
					$netsuiteClient = new ItemClient();
					$netsuiteClient->searchItemBySkuUpdateInventory( $sku, $post_id, 'all' );
				}
			}

			// map all post meta data
            $parsed_record = self::parse_record_data( $record );
            $data = $parsed_record['data'];
            $taxonomy_new = $parsed_record['taxonomy'];

			$meta_data = array_merge( $data, array(
				'_sku' => $data['product_sku'],
				'_weight' => $data['product_pack_weight'],
				'_width' => $data['product_pack_width'],
				'_length' => $data['product_pack_length'],
				'_height' => $data['product_pack_height'],
				'_backorders' => 'yes'
			) );

			// update core post data
            $post_args = self::parse_post_args( $data );
			if ( ! empty( $post_args ) ) {
                wp_update_post( array_merge( $post_args, array( 'ID' => $post_id ) ) );
			}

			// set product category
			if ( ! empty( $data['product_collection_parent_id'] ) ) {
				$parent_category_id = self::get_category_id_by_amplifi_id( $data['product_collection_parent_id'] );
				if ( $parent_category_id ) {
					wp_set_object_terms( $post_id, array( $parent_category_id ), 'product_cat' );
				} else {
                    $uncategorized = get_term_by( 'slug', 'uncategorized', 'product_cat' );
                    $uncategorized_term_id = $uncategorized ? $uncategorized->term_id : null;
                    wp_set_object_terms( $post_id, array( $uncategorized_term_id ), 'product_cat' );
				}
			}

			// update taxonomy terms & attributes
			$taxonomy_terms = $taxonomy_new;

            add_filter( 'woocommerce_product_recount_terms', '__return_false' );
            $parsed_taxonomies = self::parse_record_taxonomies_and_attributes( $post_id, $taxonomy_terms );
            $attributes = $parsed_taxonomies['attributes'];
            $new_attributes = $parsed_taxonomies['new_attributes'];
            $output_brand = $parsed_taxonomies['output_brand'];

			if ( $output_brand === '' ) {
				disable_product( $post_id );
				wp_delete_post( $id_collection_to_import, true );
				$output = "[ " . date('Y-m-d-H-i-s') . ' ]; Product SKU: ' . $sku . ' could not be synced as it doesn\'t have brand provided. Product ID: ' . $post_id . " set to Draft status. \n";
				file_put_contents( $amplifi_log_file_path, $output, FILE_APPEND );

				// updated settings time for name log file
				update_option(' settings_for_cron_manual_sync_amplifi_from_collections_to_db', $settings_cron, false );
                remove_filter( 'woocommerce_product_recount_terms', '__return_false' );
				return false;
			}

			// remove attributes that are not present in new record
			$attributes = array_filter(
				$attributes, 
				function( $key ) use ( $new_attributes ) {
					return in_array( $key, $new_attributes );
				},
				ARRAY_FILTER_USE_KEY
			);

			$position = 1;
			foreach ( $attributes as $k => $v ) {
				$attributes[ $k ]['position'] = $position;
				$position++;
			}
            update_post_meta( $post_id, '_product_attributes', $attributes );

			// import images & docs
            $meta_data = self::parse_record_media( $meta_data, $data );

			// update meta data
			foreach ( $meta_data as $k => $v ) {
				if ( $v === null ) continue;
				if ( is_array( $v ) ) {
					delete_post_meta( $post_id, '__' . $k );
					foreach ( $v as $av ) {
						add_post_meta( $post_id, '__' . $k, $av );
					}
				}
                update_post_meta( $post_id, $k, $v );
			}

            remove_filter('woocommerce_product_recount_terms', '__return_false');
			self::delete_collection_to_import_record($id_collection_to_import, $post_id, $attributes);

			$output = "[ " . date('Y-m-d-H-i-s') . ' ]; Product ID: ' . $post_id . '; SKU: ' . $sku . '; Status: ' . $status_product . '; ' . $output_brand . ' Count attributes: ' . count($attributes) . '; ' . "\n";
			file_put_contents( $amplifi_log_file_path, $output, FILE_APPEND );

			wc_delete_product_transients( $post_id );

			// updated settings time for name log file
			update_option('settings_for_cron_manual_sync_amplifi_from_collections_to_db', $settings_cron, false);

			return $post_id;
		}

        private static function parse_record_data( $record ) {
            $data = [];
            $taxonomy = [];
            foreach ( $record as $label => $record_row ) {
                $label_tmp = $label;
                $label_tmp = preg_replace( '~\([^()]*\)~', '', $label_tmp );
                $label_tmp = str_replace( [' ', '/', '\\', '-'], '_', $label_tmp );
                $label_tmp = str_replace( ['&'], '', $label_tmp );
                $label_tmp = strtolower( $label_tmp );
                $label_tmp = preg_replace( '/_+/', '_', $label_tmp );
                $label_tmp = rtrim( $label_tmp, '_' );
                if ( !str_starts_with($label_tmp, 'product') ) {
                    $label_tmp = 'product_' . $label_tmp;
                }

                if ( $label_tmp == 'product_collection_data' ) {
                    $data[$label_tmp] = $record_row;
                    continue;
                }

                if ( isset($data[$label_tmp]) ) {
                    $label_tmp = self::bump_parameter_number( $data, $label );
                }

                if ( is_array($record_row) ) {
                    $data[$label_tmp] = $record_row['value'] ?? '';
                    if ( str_starts_with($label_tmp, 'product_') ) {
                        $taxonomy_label = substr($label_tmp, 8);
                        $taxonomy_name = 'pa_' . $taxonomy_label;
                    } else {
                        $taxonomy_label = $label_tmp;
                        $taxonomy_name = 'pa_' . $taxonomy_label;
                    }

                    if ( $taxonomy_name == 'pa_brand' ) {
                        $taxonomy_name = 'product_brand';
                    }
                    if ( !empty($record_row['value']) ) {
                        $taxonomy[$taxonomy_name][] = $record_row['value'] ?? '';
                    }
                } else {
                    $data[$label_tmp] = $record_row ?? '';
                }
            }

            unset( $taxonomy['pa_category'] );
            unset( $taxonomy['pa_line'] );
            unset( $taxonomy['pa_group'] );

            return array(
                'data' => $data,
                'taxonomy' => $taxonomy
            );
        }

        private static function parse_post_args( $data ) {
            $post_args = array();
            if ( ! empty( $data['product_title'] ) ) {
                $post_args['post_title'] = $data['product_title'];
                $post_args['post_name'] = sanitize_title( $data['product_title'] );
            } else if ( ! empty( $data['product_title_alt'] ) ) {
                $post_args['post_title'] = $data['product_additional_title'];
                $post_args['post_name'] = sanitize_title( $data['product_additional_title'] );
            }

            if ( $data['product_short_description'] !== null ) {
                $post_args['post_excerpt'] = $data['product_short_description'];
            }

            if ( $data['product_marketing_copy'] !== null ) {
                $post_args['post_content'] = $data['product_marketing_copy'];
            }

            return $post_args;
        }

        private static function parse_record_taxonomies_and_attributes( $post_id, $taxonomy_terms ) {
            $attributes = get_post_meta( $post_id, '_product_attributes', true );
            $attributes = ! empty( $attributes ) ? $attributes : array();

            $new_attributes = [];
            $output_brand = '';

            foreach ( $taxonomy_terms as $taxonomy => $term_names ) {
                $term_ids = array();
                if ( empty( $term_names ) ) {
                    continue;
                }
                foreach ( $term_names as $term_name ) {
                    $names = explode( '|', $term_name );
                    $term = null;
                    foreach ( $names as $name ) {
                        $term_data = (object) array('taxonomy' => $taxonomy, 'name' => $name, 'slug' => sanitize_title( $name ), 'parent' => $term ? $term->term_id : 0 );
                        $existing_term = self::search_existing_terms_by_name( $term_data->name, $term_data->taxonomy, $term ? $term->term_id : 0 );
                        if ( ! $existing_term ) {
                            if ( !taxonomy_exists($term_data->taxonomy) ) {
                                $slug = preg_replace('/^pa_/', '', $term_data->taxonomy);
                                self::register_product_attribute( $slug );
                            }
                            $result = wp_insert_term( $term_data->name, $term_data->taxonomy, array( 'slug' => $term_data->slug, 'parent' => $term_data->parent ) );
                            if ( ! is_wp_error( $result ) ) {
                                $term = get_term( $result['term_id'], $taxonomy );
                            }
                        } else {
                            $term = $existing_term;
                        }
                    }

                    if ( ! empty( $term ) ) {
                        $term_ids[] = $term->term_id;
                        if($taxonomy === 'product_brand'){
                            $output_brand = 'Brand: ' . $term->name . ' - ' . $term->term_id . ';';
                        }
                    }
                }
                wp_set_object_terms( $post_id, $term_ids, $taxonomy );

                if ( preg_match( '/^pa_/', $taxonomy ) ) {
                    $attributes[ $taxonomy ] = array(
                        'name' => $taxonomy,
                        'value' => $term_ids,
                        'is_visible' => 1,
                        'is_variation' => 0,
                        'is_taxonomy' => 1
                    );

                    $new_attributes[] = $taxonomy;
                }
            }

            return array(
                'attributes' => $attributes,
                'new_attributes' => $new_attributes,
                'output_brand' => $output_brand
            );
        }

        private static function parse_record_media( $meta_data, $data ) {
            $images = null;
            $image_srcs = null;
            $videos = null;
            $video_data = null;
            $docs = null;
            $doc_srcs = null;
            $doc_data = null;
            foreach ( $data as $k => $v ) {
                //Image Master File 1
                if ( preg_match( '/^product_image_master_file_(\d+)$/', $k, $matches ) ) {
                    if ( $images === null ) $images = array();
                    if ( $image_srcs === null ) $image_srcs = array();
                    if ( ! empty( $v ) ) {
                        $image_srcs[] = $v;
                    }
                    //Video Master File 1
                } else if ( preg_match( '/^product_video_master_file_(\d+)$/', $k, $matches ) ) {
                    if ( $videos === null ) $videos = array();
                    if ( $video_data === null ) $video_data = array();
                    if ( ! empty( $v ) ) {
                        //Video Filename 1
                        $file_name = array_key_exists( 'product_video_filename_' . $matches[1], $data ) ? $data[ 'product_video_filename_' . $matches[1] ] : '';
                        $video_data[] = array( 'src' => $v, 'filename' => $file_name );
                    }
                    //Document Master File 1
                } else if ( preg_match( '/^product_document_master_file_(\d+)$/', $k, $matches ) ) {
                    if ( $docs === null ) $docs = array();
                    if ( $doc_srcs === null ) $doc_srcs = array();
                    if ( $doc_data === null ) $doc_data = array();
                    if ( ! empty( $v ) ) {
                        $doc_srcs[] = $v;
                        //Document Filename 1
                        $file_name = array_key_exists( 'product_document_filename_' . $matches[1], $data ) ? $data[ 'product_document_filename_' . $matches[1] ] : '';
                        $doc_data[] = array( 'src' => $v, 'filename' => $file_name );
                    }
                }
            }
            if ( $image_srcs !== null ) {
                $meta_data['product_image_srcs'] = $image_srcs;
            }
            if ( $video_data !== null ) {
                $meta_data['product_video_data'] = $video_data;
            }
            if ( $doc_srcs !== null ) {
                $meta_data['product_doc_srcs'] = $doc_srcs;
            }
            if ( $doc_data !== null ) {
                $meta_data['product_doc_data'] = $doc_data;
            }

            return $meta_data;
        }

        public static function bump_parameter_number( $data, $param, $number = 2 ) {
            if ( isset($data[$param . '_' . $number]) ) {
                return self::bump_parameter_number( $data, $param, ($number + 1) );
            } else {
                return $param . '_' . $number;
            }
        }

		protected static function delete_collection_to_import_record($id_collection_to_import, $post_id, $attributes){
			// check if product has all attributes and brand
			if( !empty( $id_collection_to_import ) ){
				// get terms brand for product
				$terms_brand = wp_get_post_terms( $post_id, 'product_brand', array( 'fields' => 'ids' ) );

				// get attributes for product
				$attributes_for_check = get_post_meta( $post_id, '_product_attributes', true );
				

				$attribute_names_collection = [];
				if ( is_array( $attributes_for_check ) ) {
					$attribute_names_collection = array_keys( $attributes );
					$attributes_for_check = array_keys( $attributes_for_check );

					// check if all attributes are present in new record
					$diff = array_diff( $attribute_names_collection, $attributes_for_check );

					if( empty( $diff ) && !empty( $terms_brand ) ){
						
						// Delete post if it's already imported
						wp_delete_post( $id_collection_to_import, true );
					}
                    else {
						$collection_id = get_post_meta( $post_id, 'product_collection_id', true );
						if ( $collection_id ) {
							$collection = Crown_Amplifi_Api::get_collection( $collection_id );
							if ( is_object( $collection )  && property_exists( $collection, 'id' ) ) {
								return;
							}
							disable_product($post_id);
							wp_delete_post( $id_collection_to_import, true );
                        }
                    }
				}
			}
		}


		protected static function search_existing_terms_by_name( $name, $taxonomy, $parent = 0 ) {
			$name = _wp_specialchars( wp_filter_kses( sanitize_text_field( $name ) ) );
			$term_names = get_terms( array(
				'taxonomy' => $taxonomy,
				'hide_empty' => false,
				'fields' => 'id=>name',
				'parent' => $parent,
				'update_term_meta_cache' => false
			) );
			if ( ! is_array( $term_names ) ) return false;
			$term_id = array_search( $name, $term_names );
			return $term_id ? get_term( $term_id, $taxonomy ) : false;
		}


		protected static function get_mapped_meta_data( $map_file, $record ) {
			if ( ! file_exists( $map_file ) ) return false;
			$config = json_decode( file_get_contents( $map_file ), true );
			$fields_map = is_array( $config ) && array_key_exists( 'fields', $config ) ? $config['fields'] : null;
			if ( ! $fields_map ) return false;
			
			$data = array();
			foreach ( $fields_map as $field_map ) {
				$field_map = array_merge( array(
					'column' => '',
                    'id' => null,
					'meta_key' => '',
					'type' => 'string',
					'delimiter' => ','
				), $field_map );
				if ( empty( $field_map['column'] ) || empty( $field_map['meta_key'] ) ) continue;

				$data[ $field_map['meta_key'] ] = self::get_record_prop( $record, $field_map['column'], $field_map['id'], $field_map['type'], $field_map['delimiter'] );
			}
			return $data;
		}


		protected static function get_mapped_taxonomy_terms( $map_file, $record ) {
			if ( ! file_exists( $map_file ) ) return false;
			$config = json_decode( file_get_contents( $map_file ), true );
			$fields_map = is_array( $config ) && array_key_exists( 'fields', $config ) ? $config['fields'] : null;
			if ( ! $fields_map ) return false;
			
			$taxonomy_terms = array();
			foreach ( $fields_map as $field_map ) {
				$taxonomy = array_key_exists( 'taxonomy', $field_map ) && array_key_exists( 'name', $field_map['taxonomy'] ) ? $field_map['taxonomy']['name'] : null;
				if ( empty( $taxonomy ) ) continue;
				$field_map = array_merge( array(
					'column' => '',
					'id' => null,
					'type' => 'string',
					'delimiter' => ',',
					'taxonomy' => array()
				), $field_map );
				if ( empty( $field_map['column'] ) || empty( $field_map['meta_key'] ) ) continue;

				$term_name = self::get_record_prop( $record, $field_map['column'], $field_map['id'], $field_map['type'], $field_map['delimiter'] );
				if ( $term_name === null ) continue;
				if ( ! array_key_exists( $taxonomy, $taxonomy_terms ) ) $taxonomy_terms[ $taxonomy ] = array();
				if ( ! empty( $term_name ) ) $taxonomy_terms[ $taxonomy ] = array_merge( $taxonomy_terms[ $taxonomy ], is_array( $term_name ) ? $term_name : array( $term_name ) );
			}
			return $taxonomy_terms;
		}


		protected static function get_record_prop( $record, $label, $key = null, $format = 'string', $delimiter = ',' ) {
			$prop = null;
            if (!is_null($key)) {
				$prop = get_value_by_key_ci($key, $record);
            }
			if (is_null($prop)) {
				$prop = get_value_by_label_ci($label, $record);
			}
			if (is_null($prop)) {
				return null;
			}
			if ( ! in_array( $format, array( 'array', 'object' ) ) ) $prop = trim( $prop );
			if ( $format == 'int' ) $prop = intval( $prop );
			if ( $format == 'float' ) $prop = floatval( $prop );
			if ( $format == 'bool' ) $prop = boolval( $prop );
			if ( $format == 'array' ) $prop = array_filter( array_map( 'trim', explode( $delimiter, $prop ) ), function( $n ) { return ! empty( $n ); } );
			return $prop;
		}

		public static function set_default_date_acf() {
			if ( !isset($_GET['page']) ) {
				return;
			}
			$screen = $_GET['page'];
		
			if ($screen == 'acf-options-product-category-import') {
				$current_date = date('Y-m-d');
		
				update_field('updated_end_date', $current_date, 'option');
			}

		}

		public static function acf_update_settings_for_auto_sync_amplify(){
			// set default region
			update_field('get_collections_parameters', ['nsi_default_region_id' => get_amplify_region_id()], 'option');

			$current_date 		= date('Y-m-d');
			$updated_start_date = date("Y-m-d", strtotime("-1 days"));

			// set default date
			update_field('get_collections_parameters', [
				'updated_end_date' 		=> $current_date,
				'updated_start_date' 	=> $updated_start_date,
			],
				'option'
			);
		}

		public static function disabled_acf_field_parent_id($field){
			if( 'parent_id' === $field['name'] ) {
				$field['disabled'] = true;	
			}
			
			return $field;
		}

		public static function disabled_acf_field_nsi_default_region_id($field){
			if( 'nsi_default_region_id' === $field['name'] ) {
				$field['default_value'] = get_amplify_region_id();
			}
			
			return $field;
		}

		public static function request_to_product_category_import($post_id){

			$screen = $_GET['page'];
			$notice = '';

			update_field('notice', '', 'option');

			if ($screen == 'acf-options-product-category-import') {

				$request_url = get_site_url() . '/wp-json/amplify/v2/product-category-import?postID=' . $post_id;

				$response = wp_remote_get( $request_url, array(
					'headers' => array(
						'Accept-Language' => 'en-US'
					),
					'timeout' => 30,
					'redirection' => 5,
					'httpversion' => '1.1',
					'sslverify' => false
				));
			}

		}

		public static function acs_safe_options_page_autosync_amplify($post_id){

			$screen = $_GET['page'];

			update_field('notice', '', 'option');

			if ($screen == 'acf-options-setting-import-with-aplifi') {
				$enabled_sync_cron = get_field('enabled__auto_sync', 'option');

				if(!$enabled_sync_cron) return;

				if ( defined( 'CROWN_PRODUCT_API_SYNC_DISABLED' ) && CROWN_PRODUCT_API_SYNC_DISABLED ) {
					wp_clear_scheduled_hook( 'crown_auto_sync_amplifi_to_collections_import' );
				}
			    else {
					if ( ! wp_next_scheduled( 'crown_auto_sync_amplifi_to_collections_import' ) ) {
						wp_schedule_event( time(), 'hourly', 'crown_auto_sync_amplifi_to_collections_import' );
					}
				}
			}

		}

		public static function acf_save_options_page_category_import($request) {
			update_option('settings_for_cron_manual_sync_amplifi_to_collections_import', [
				'offset' => 0,
				'start_time' => 0,
                'not_default_reg_col' => 0
			], false);

			update_option('settings_for_cron_manual_sync_amplifi_from_collections_to_db', [
				'start_time' => 0,
			], false);

			do_action('start_crown_manual_sync_amplifi_to_collections_import');
		}

		protected static function find_product_by_sku( $sku ) {
			global $wpdb;
			$result = $wpdb->get_row( $wpdb->prepare( "SELECT
					p.ID AS id
				FROM $wpdb->posts p
				LEFT JOIN $wpdb->wc_product_meta_lookup pm1 ON (pm1.product_id = p.ID)
				WHERE p.post_type = 'product'
				AND pm1.sku = %s
			", $sku ), ARRAY_A );
			if ( ! empty( $result ) ) $result['id'] = intval( $result['id'] );
			return $result;
		}

        /**
         * get logfile path for Amplifi sync
         * @param string $category_id
         * @param mixed $date_current
         * @return string
         */
        public static function get_amplifi_log_file_path(string $category_id, mixed $date_current, string $folder_name, string $name_file): string
        {
            $file_dir = wp_upload_dir();
            $path_folder = $file_dir['basedir'] . '/' . $folder_name;
            if ( !empty($category_id) ) {
                $log_file_path = $path_folder . '/' . $name_file . '-' . $category_id . '-' . $date_current . '.log';
            } else {
                $log_file_path = $path_folder . '/' . $name_file . '-' . $date_current . '.log';
            }

            if (!file_exists($path_folder)) {
                mkdir($path_folder, 0755, true);
            }

            if (!file_exists($log_file_path)) {
                $log_file_stream = fopen($log_file_path, 'w');
                chmod($log_file_path, 0644);
                fclose($log_file_stream);
            }

			$files = scandir($path_folder);
			$files = array_filter($files, function($file) use ($path_folder) {
				return is_file($path_folder . '/' . $file);
			});

			usort($files, function($a, $b) use ($path_folder) {
				return filemtime($path_folder . '/' . $a) > filemtime($path_folder . '/' . $b);
			});

			while (count($files) > AMPLIFI_SYNC_STORED_LOG_FILES_LIMIT) {
			    unlink($path_folder . '/' . $files[0]);
				array_shift($files);
			}
            return $log_file_path;
        }

        public static function init_settings_for_cron_manual_sync_amplifi_to_collections_import(): void
        {
            if (!get_option('settings_for_cron_manual_sync_amplifi_to_collections_import')) {
                add_option('settings_for_cron_manual_sync_amplifi_to_collections_import', [
                    'offset' => 0,
                    'start_time' => 0,
                    'not_default_reg_col' => 0
                ]);
            }

			if (!get_option('settings_for_cron_manual_sync_amplifi_from_collections_to_db')) {
				add_option('settings_for_cron_manual_sync_amplifi_from_collections_to_db', [
					'start_time' => 0
				]);
			}
        }

		public static function init_settings_for_cron_auto_sync_amplifi_to_collections_import(): void
        {
			$name_option 	= 'settings_for_cron_auto_sync_amplifi_to_collections_import';
			$settings 		= get_option( $name_option );
			$date_current 	= (string)date( 'Y-m-d' );

            if ( !$settings ) {
				$settings = [
					'date' => $date_current,
					'sequence_number' => 0,
                    'runs_number' => 0,
					'not_default_counter' => 0,
					'first_collection_id' => '',
					'stop_sync' => false,
				];
                add_option( $name_option, $settings );
            } else {
				// reset sequence number if date is different and reset stop sync
				if( $date_current != $settings['date'] ){

					$settings['sequence_number'] = 0;
					$settings['runs_number'] = 0;
					$settings['not_default_counter'] = 0;
					$settings['first_collection_id'] = '';
					$settings['stop_sync'] = false;
					$settings['date'] = $date_current;

					update_option( $name_option, $settings );
				}
			}
        }

        public static function get_updated_by_acf_fields_params(array $params): array
        {
            $get_collections_parameters = get_field('get_collections_parameters', 'option');

            if (!empty($get_collections_parameters)) {
                $acf_fields = [
                    'parent_id',
                    'created_start_date',
                    'created_end_date',
                    'updated_start_date',
                    'updated_end_date'
                ];

                foreach ($acf_fields as $field) {
                    if (!empty($get_collections_parameters[$field])) {
                        $params[$field] = $get_collections_parameters[$field];
                    }
                }
            }
            return $params;
        }


        protected static function get_post_id_by_meta_value( $post_type, $key, $value ) {
			global $wpdb;
			$result = $wpdb->get_var( $wpdb->prepare( "SELECT
						p.ID AS id
					FROM $wpdb->posts p
					LEFT JOIN $wpdb->postmeta pm1 ON (pm1.post_id = p.ID AND pm1.meta_key = %s)
					WHERE p.post_type = %s
					AND pm1.meta_value = %s
				", $key, $post_type, $value ) );
			return $result ? intval( $result ) : $result;
		}


		protected static function get_product_id_by_sku( $sku ) {
			global $wpdb;
			$result = $wpdb->get_var( $wpdb->prepare( "SELECT
						p.ID AS id
					FROM $wpdb->posts p
					LEFT JOIN $wpdb->wc_product_meta_lookup pm1 ON (pm1.product_id = p.ID)
					WHERE p.post_type = 'product'
					AND pm1.sku = %s
				", $sku ) );
			return $result ? intval( $result ) : $result;
		}


		protected static function import_attachment_from_url( $url, $name = '' ) {
			$upload = self::get_upload_from_url( trim( $url ), trim( $name ) );
			if ( ! $upload ) return $upload;
			$attachment_id = self::import_upload( $upload );
			return $attachment_id;
		}


		protected static function get_upload_from_url( $url, $name = '' ) {

			$file_name = ! empty( $name ) ? $name : basename( $url );

			$upload = wp_upload_bits( $file_name, 0, '' );
			if ( $upload['error'] ) {
				// WP_CLI::warning( 'Upload dir error: ' . $upload['error'] . ' (' . $url . ')' );
				return false;
			}

			$request = new WP_Http();
			$headers = $request->get( $url, array( 'stream' => true, 'filename' => $upload['file'], 'timeout' => 1000 ) );
			if ( ! $headers ) {
				@unlink( $upload['file'] );
				// WP_CLI::warning( 'Remote server did not respond (' . $url . ')' );
				return false;
			}
			if ( is_wp_error( $headers ) ) {
				@unlink( $upload['file'] );
				// WP_CLI::warning( 'HTTP request error: ' . $headers->get_error_message() . ' (' . $url . ')' );
				return false;
			}
			if ( $headers['response']['code'] != '200' ) {
				@unlink( $upload['file'] );
				// WP_CLI::warning( 'Remote server returned error response ' . esc_html( $headers['response']['code'] ) . ' ' . get_status_header_desc( $headers['response']['code'] ) . ' (' . $url . ')' );
				return false;
			}

			$file_size = filesize( $upload['file'] );
			// if(isset($headers['content-length']) && $fileSize != $headers['content-length']) {
			// 	@unlink($upload['file']);
			// 	\WP_CLI::warning('Remote file is incorrect size');
			// 	return false;
			// }
			if ( 0 == $file_size ) {
				@unlink( $upload['file'] );
				// WP_CLI::warning( 'Zero size file downloaded (' . $url . ')' );
				return false;
			}

			$max_size = 0; // unlimited
			if ( ! empty( $max_size ) && $file_size > $max_size ) {
				@unlink( $upload['file'] );
				// WP_CLI::warning( 'Remote file is too large, limit is ' . size_format( $max_size ) . ' (' . $url . ')' );
				return false;
			}

			return $upload;

		}


		protected static function import_upload( $upload ) {

			$attachment = array(
				'post_author' => 1
			);

			if ( $info = wp_check_filetype( $upload['file'] ) ) {
				$attachment['post_mime_type'] = $info['type'];
			} else {
				// WP_CLI::warning( 'Invalid file type' );
				return false; // 'Invalid file type'
			}

			$attachment['guid'] = $upload['url'];

			$attachment_id = wp_insert_attachment( $attachment, $upload['file'] );
			if( $attachment_id ) {
				wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $upload['file'] ) );
			} else {
				// WP_CLI::warning( 'Failed attachment import' );
			}

			return $attachment_id;
		}


		public static function init_data_sync_schedule() {

			if ( defined( 'CROWN_PRODUCT_API_SYNC_DISABLED' ) && CROWN_PRODUCT_API_SYNC_DISABLED ) {
				wp_clear_scheduled_hook( 'crown_auto_sync_amplifi_to_collections_import' );
				wp_clear_scheduled_hook( 'crown_auto_sync_amplifi_clear_synced_products_list' );
			} else {
				if ( ! wp_next_scheduled( 'crown_auto_sync_amplifi_to_collections_import' ) ) {
					wp_schedule_event( time(), 'hourly', 'crown_auto_sync_amplifi_to_collections_import' );
				}
                if ( ! wp_next_scheduled( 'crown_auto_sync_amplifi_clear_synced_products_list' ) ) {
					wp_schedule_event( time(), 'daily', 'crown_auto_sync_amplifi_clear_synced_products_list' );
				}
			}

			if ( defined( 'CROWN_PRODUCT_API_IMPORT_DISABLED' ) && CROWN_PRODUCT_API_IMPORT_DISABLED ) {
				wp_clear_scheduled_hook( 'crown_auto_sync_products_from_collections_to_db' );
			}
		}

        public static function init_amplify_category_cleanup() {
			if ( defined( 'AMPLIFY_CATEGORIES_CLEANUP_ENABLED' ) &&  AMPLIFY_CATEGORIES_CLEANUP_ENABLED ) {
				if ( ! wp_next_scheduled( 'crown_amplify_category_cleanup' ) ) {
					wp_schedule_event( time(), 'monthly', 'crown_amplify_category_cleanup' );
				}
			} elseif (wp_next_scheduled('crown_amplify_category_cleanup')) {
				wp_clear_scheduled_hook( 'crown_amplify_category_cleanup' );
			}
        }

        public static function init_amplify_attributes_sync() {
            if ( ! wp_next_scheduled( 'crown_amplify_attributes_sync' ) ) {
				$next_sync_time = self::get_next_sync_time(6, 2);
                wp_schedule_event( intval( $next_sync_time->format( 'U' ) ), 'weekly', 'crown_amplify_attributes_sync' );
            }
        }

		/**
		 * Creates the amplifi_auto_synced_products table in the WordPress database.
		 *
		 * This function creates a table named 'amplifi_auto_synced_products' if it doesn't already exist.
		 * The table has the following columns:
		 * - id: mediumint(9) NOT NULL AUTO_INCREMENT
		 * - collection_id: VARCHAR(255) NOT NULL
		 * - synced_date: DATETIME NOT NULL
		 *
		 * @global wpdb $wpdb The WordPress database object.
		 */
		public static function create_amplifi_auto_synced_products_table(){
			global $wpdb;
			$table_name = $wpdb->prefix . 'amplifi_auto_synced_products';
			$charset_collate = $wpdb->get_charset_collate();
			$sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				collection_id VARCHAR(255) NOT NULL,
				synced_date DATETIME NOT NULL,
				PRIMARY KEY  (id),
				UNIQUE INDEX idx_collection_id (collection_id)
			) $charset_collate;";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}

		/**
		 * Deletes the synced products from the amplifi_auto_synced_products table
		 * that have a synced date older than 7 days.
		 *
		 * @return void
		 */
		public static function cron_auto_sync_amplifi_clear_synced_products_list() {
			global $wpdb;
			$table_name = $wpdb->prefix . 'amplifi_auto_synced_products';

			$query = $wpdb->prepare(
				"DELETE FROM $table_name WHERE synced_date <= %s",
				date('Y-m-d H:i:s', strtotime('-7 days'))
			);

			$wpdb->query($query);
		}

		public static function cron_auto_sync_amplifi_to_collections_import($force = false ) {
			$transient_key = 'auto_sync_products_amplifi_to_collections_lock';
			if (get_transient($transient_key)) {
				return;
			}

			if ( ! wp_next_scheduled( 'crown_auto_sync_amplifi_to_collections_import' ) ) {
				wp_schedule_event( time(), 'hourly', 'crown_auto_sync_amplifi_to_collections_import' );
			}

            if ( ! $force ) {
                $imports = get_posts( array(
					'post_type'         => 'product_import',
					'posts_per_page'    => 50,
					'fields' => 'ids',
					'meta_query' => array(
						array(
							'key' => 'manual_sync_amplify',
							'compare' => 'NOT EXISTS',
						),
					),
				) );

				if ( ! empty( $imports ) ) {
					if (! wp_next_scheduled ( 'crown_auto_sync_products_from_collections_to_db' )) {
						wp_schedule_event( time(), '10min', 'crown_auto_sync_products_from_collections_to_db' );
					}
					$import_start_time = get_option( 'crown_product_api_import_start_time', '' );
					if ( empty( $import_start_time ) ) {
						$prev_sync_page_time = strtotime( get_option( 'crown_product_api_sync_page_time', '2000-01-01' ) );
						$current_time = time();
						if ( ( $current_time - $prev_sync_page_time ) / 60 > 60 ) {
							$sync_start_time = get_option( 'crown_product_api_sync_start_time', '' );
							$page = get_option( 'crown_product_api_sync_page', 1 );
							self::request_product_sync( $sync_start_time, $page );
						}
					}
					return;
				}
			}
			update_option( 'crown_product_api_import_start_time', '', false );

			$prev_sync_start_time = get_option( 'crown_product_api_sync_start_time', '' );
			update_option( 'crown_product_api_sync_start_time_prev', $prev_sync_start_time, false );

			$sync_start_time = date( 'Y-m-d H:i:s' );
			update_option( 'crown_product_api_sync_start_time', $sync_start_time, false );

			update_option( 'crown_product_api_sync_count', 0, false );
			update_option( 'crown_product_api_sync_page', 0, false );

			self::request_product_sync( $sync_start_time );
		}


		public static function request_product_sync( $sync_start_time, $page = 1 ) {
			if ( defined( 'CROWN_PRODUCT_API_SYNC_DISABLED' ) && CROWN_PRODUCT_API_SYNC_DISABLED ) return;
			$request_url = get_site_url() . '/wp-json/amplify/v2/auto-sync-to-collection';

			$request_url = add_query_arg( array(
				'crown_sync_products' => 1,
				'page' => $page,
				'_wpnonce' => wp_create_nonce( 'crown_sync_products-' . md5( $sync_start_time ) . '-page_' . $page )
			), $request_url );

			$request_args = array(
				'headers' => array(
					'Accept-Language' => 'en-US'
				),
				'timeout' => 30,
				'redirection' => 5,
				'httpversion' => '1.1',
				'sslverify' => false
			);
			wp_remote_get( $request_url, $request_args );
		}


		public static function handle_auto_sync_amplifi_to_collections_import() {
			if ( ! isset( $_GET['crown_sync_products'] ) || ! boolval( $_GET['crown_sync_products'] ) ) return;
			$page = isset( $_GET['page'] ) ? intval( $_GET['page'] ) : null;

			if ( empty( $page ) ) return;

            $enabled_sync_cron 	= get_field('enabled__auto_sync', 'option');
			if(!$enabled_sync_cron) return;

			$sync_start_time = get_option( 'crown_product_api_sync_start_time', '' );
			if ( empty( $sync_start_time ) ) return;

			if ( ! wp_verify_nonce( $_GET[ '_wpnonce' ], 'crown_sync_products-' . md5( $sync_start_time ) . '-page_' . $page ) ) return;

			$settings_cron 		= get_option('settings_for_cron_auto_sync_amplifi_to_collections_import');
			if($settings_cron['stop_sync']) return;

			$transient_key = 'auto_sync_products_amplifi_to_collections_lock';
			if (get_transient($transient_key)) {
				return;
			}
			set_transient($transient_key, true, AMPLIFI_AUTO_SYNC_TO_COLLECTION_IMPORT_TIMEOUT);

			$total_count = intval( get_option( 'crown_product_api_sync_count', 0 ) );
			update_option( 'crown_product_api_sync_page', $page, false );
			update_option( 'crown_product_api_sync_page_time', date( 'Y-m-d H:i:s' ), false );
			$count = self::auto_sync_amplifi_to_collections_import( $page );
			$total_count += $count;
			update_option( 'crown_product_api_sync_count', $total_count, false );

			delete_transient($transient_key);
			if ( $count ) {
				self::request_product_sync( $sync_start_time, $page + 1 );
			}
		}

		public static function disable_products_without_nsi_region($sku, $collection_region_ids) {
		    if ( empty($sku) ){
			    return;
            }

			$result = self::find_product_by_sku( $sku );

			if( is_array($result) && isset($result['id']) ){
				$product_id_woo = $result['id'];
				self::update_product_region_ids($product_id_woo, $collection_region_ids);
				disable_product($product_id_woo);
			}
		}

		public static function update_product_region_ids($product_id_woo, $collection_region_ids) {
			$product_collection_data = (array)get_post_meta( $product_id_woo, 'product_collection_data');

			if( !empty($product_collection_data) && !empty($product_collection_data[0]->region_ids) && is_array($product_collection_data[0]->region_ids) ){
			    $product_collection_data[0]->region_ids = $collection_region_ids;
				update_post_meta( $product_id_woo, 'product_collection_data', $product_collection_data );
			}
		}

		protected static function auto_sync_amplifi_to_collections_import( $page ) {
			$cron_job_start_time    = microtime(true);
			$batch_size 			= 50;
			$url_site 				= get_site_url();
			$date_current 			= date( 'Y-m-d' );
			$settings_cron 		    = get_option( 'settings_for_cron_auto_sync_amplifi_to_collections_import' );
			$output 				= '';
			$amplifi_region_id_in_scope  = get_amplify_region_id();
			$enable_disabling_products_auto_sync = ( !empty( get_field( 'enable_disabling_products_auto_sync', 'option' ) ) )? 'Yes' : 'No';
			$enabled__auto_sync 	= ( !empty( get_field( 'enabled__auto_sync', 'option' ) ) )? 'Yes' : 'No';
			$params = [
				'folder_level' 	=> 'leaf',
				'limit' 		=> $batch_size,
				'minified'      => 'true',
				'offset' 		=> ( $batch_size * ( $page - 1 ))
			];

            $params = self::get_updated_by_acf_fields_params($params);

            // get current page of collections
			$amplifi_response = Crown_Amplifi_Api::get_collections( $params );

			// reset sequence number if date is different and reset stop sync
			if( $date_current != $settings_cron['date'] ){
				$settings_cron['sequence_number'] = 0;
                $settings_cron['runs_number'] = 0;
				$settings_cron['not_default_counter'] = 0;
				$settings_cron['first_collection_id'] = '';
				$settings_cron['stop_sync'] = false;
				update_option( 'settings_for_cron_auto_sync_amplifi_to_collections_import', $settings_cron, false );

				$updated_start_date = date( "Y-m-d", strtotime( "-1 days" ) );

				// updated settings time for auto sync
				update_field('get_collections_parameters', [
					'updated_end_date' 		=> $date_current,
					'updated_start_date' 	=> $updated_start_date,
				],
					'option'
				);
			}

			$settings_cron[ 'date' ] = $date_current;

			$amplifi_log_file_path = self::get_amplifi_log_file_path( '', $date_current, 'amplify-logs/amplify-products-import-auto' , 'auto_sync_to_collections' );
			$key = $settings_cron[ 'sequence_number' ];
            $key_of_runs = $settings_cron[ 'runs_number' ];
			$not_default_counter = $settings_cron[ 'not_default_counter' ] ?? 0;

			if( $key_of_runs == 0 ){
				$output .= "\n" . '[' . date( 'Y-m-d H:i:s' ) . '] Sync parameters:' . "\n"
                    . 'Parent id - ' . $params['parent_id'] . "\n" . 'Updated end date - '. $params['updated_end_date']
                    . "\n" . 'Updated start date - '. $params['updated_start_date']
					. "\n" . 'Enable disabling products - ' . $enable_disabling_products_auto_sync
					. "\n" . 'Enabled auto sync - ' . $enabled__auto_sync;
                $key_of_runs++;
			}

            $output .= !empty($params['created_end_date']) ? "\n" . 'Created end date - ' . $params['created_end_date'] : '';
            $output .= !empty($params['created_start_date']) ? "\n" . 'Created start date - ' . $params['created_start_date'] : '';

			if ( is_object( $amplifi_response ) ) {
                $output .= property_exists( $amplifi_response, 'message' )
                    ? "\n" . '[' . date('Y-m-d H:i:s') . '] Collections load failed. Message (reason): "' . $amplifi_response->message . '".'
                    : "\n" . '[' . date('Y-m-d H:i:s') . '] Collections load failed. Message (reason) is absent.';
			} elseif ( is_array( $amplifi_response ) && !empty( $amplifi_response ) ) {
				$synced_products = self::get_all_synced_products();
                if ( $page == 1) {
                    self::import_categories();
                }
				foreach ( $amplifi_response as $collection ) {

					if ( isset( $synced_products[ $collection->id ] ) ) {
						$collection_update_date = property_exists( $collection, 'updated_date' ) ? $collection->updated_date : date( 'Y-m-d\TH:i:s.000\Z' );
						$collection_update_date = self::get_formatted_date( $collection_update_date );
						$synced_product_date = self::get_formatted_date( $synced_products[$collection->id] );

                        if ( $collection_update_date > $synced_product_date ) {
							unset( $synced_products[ $collection->id ] );
							self::delete_from_synced_products($collection->id);
						} else {
							continue;
						}
					}
                    $sku = self::get_product_sku_from_collection_data( $collection );

					if ( empty( $sku ) ) {
						$key++;
						$sku_output =  'SKU_NOT_FOUND ';
						$output .= "\n" . $key . ', [' . date( 'Y-m-d H:i:s' ) . '] ' . $sku_output . 'Title - ' . $collection->name . ' , Collection ID - ' . $collection->id . ';';
						self::add_to_synced_products( $collection );
                        continue;
					} else {
						$sku_output =  'SKU - ' . $sku . ', ';
					}

					$collection_region_ids = property_exists( $collection, 'region_ids' ) && is_array( $collection->region_ids ) ? $collection->region_ids : array();
					// skip if not NSI default
					$is_nsi_default = in_array( $amplifi_region_id_in_scope, $collection_region_ids );
					if ( ! $is_nsi_default ) {
						self::disable_products_without_nsi_region( $sku, $collection_region_ids );
						$key++;
						$output .= "\n" . $key . ', [' . date( 'Y-m-d H:i:s' ) . '] NOT IN DEFAULT REGION, ' . $sku_output . 'Title - ' . $collection->name . ' , Collection ID - ' . $collection->id . ';';
						self::add_to_synced_products( $collection );
                        $not_default_counter++;
						continue;
					}

					if( !empty( $settings_cron['first_collection_id'] ) && $settings_cron['first_collection_id'] == $collection->id ){
						$settings_cron['stop_sync'] = true;
						update_option( 'settings_for_cron_auto_sync_amplifi_to_collections_import', $settings_cron, false );
						$output .= "\n" . 'Stop sync. Duplicated Collection ID: ' . $collection->id;
					}

					// Flag to stop sync
					if( $settings_cron[ 'stop_sync' ] ) continue;

					if( empty( $settings_cron['first_collection_id'] ) ){
						$settings_cron['first_collection_id'] = $collection->id;
						update_option( 'settings_for_cron_auto_sync_amplifi_to_collections_import', $settings_cron, false );
					}

					$key++;

					$postarr = array(
						'post_type' => 'product_import',
						'post_status' => 'publish',
						'post_title' => $collection->name
					);

					if ( property_exists( $collection, 'additional_title' ) && ! empty( $collection->additional_title ) ) $postarr['post_title'] = $collection->additional_title;
					if ( ! empty( $sku ) ) $postarr['post_title'] = '[' . $sku . '] ' . $postarr['post_title'];

					$import_id = self::get_product_import_id_by_collection_id( $collection->id );
					$date_create_post = date( 'Y-m-d H:i:s' );

					if ( ! $import_id ) {
						$import_id = wp_insert_post( $postarr );
						update_post_meta( $import_id, 'collection_id', $collection->id );
						$output_url_message = 'Product Collection to import URL CREATED - ' . $url_site . '/wp-admin/post.php?post=' . $import_id . '&action=edit, ';
					} else {
						wp_update_post( array_merge( $postarr, array( 'ID' => $import_id ) ) );
						$output_url_message = 'Product Collection to import URL UPDATED - ' . $url_site . '/wp-admin/post.php?post=' . $import_id . '&action=edit, ';
					}

					$output .= "\n" . $key . ', [' . date( 'Y-m-d H:i:s' ) . '] ' . $output_url_message . $sku_output . 'Title - ' . $postarr['post_title'] . ' , Collection ID - ' . $collection->id . ';';

					update_post_meta( $import_id, 'collection_data', $collection );
					update_post_meta( $import_id, 'collection_sku', $sku );

					$cron_job_current_time = microtime(true);
					$cron_job_elapsed_time = $cron_job_current_time - $cron_job_start_time;

					if ($cron_job_elapsed_time >= AMPLIFI_TO_COLLECTION_IMPORT_TIMEOUT) {
						$output .= "\n" . self::AMPLIFI_IMPORT_REACHED_TIME_LIMIT;
						break;
					}
				}
                if ($key != $settings_cron['sequence_number']) {
                    if (! wp_next_scheduled ( 'crown_auto_sync_products_from_collections_to_db' )) {
                        wp_schedule_event( time(), '10min', 'crown_auto_sync_products_from_collections_to_db' );
                    }
				    $output .= "\n" . '*** New batch from Amplifi started, current handled items (offset): ' . $key . ', incl. not in default region (skipped): '
                        . ($not_default_counter) . ' ***';
                }

			} elseif ( is_array( $amplifi_response ) ) {
				$output .= "\n" . '[' . date( 'Y-m-d H:i:s' ) . '] There are no new/updated collections in Amplifi for used parameters.' . "\n";
			} elseif ( is_string( $amplifi_response ) ) {
				$output .= "\n" . '[' . date( 'Y-m-d H:i:s' ) . '] Error message: ' . $amplifi_response;
			} else {
				$output .= "\n" . '[' . date( 'Y-m-d H:i:s' ) . '] There is an issue with connection to Amplifi.';
			}
            $key_of_runs++;

			// update sequence number
			$settings_cron['sequence_number'] 		= $key;
			$settings_cron['runs_number'] 		    = $key_of_runs;
			$settings_cron['not_default_counter'] 	= $not_default_counter;
			$settings_cron['first_collection_id'] 	= '';
			$settings_cron['stop_sync'] 			= false;
			
			update_option( 'settings_for_cron_auto_sync_amplifi_to_collections_import', $settings_cron, false );

			file_put_contents( $amplifi_log_file_path, $output, FILE_APPEND );

			return count( $amplifi_response );
		}


		public static function sync_product_data( $collection_id ) {
		    $collection = Crown_Amplifi_Api::get_collection( $collection_id );
            $date_current = date('Y-m-d');
            self::$amplifi_log_file_name = self::get_amplifi_log_file_path('', $date_current,
                'amplify-logs/amplify-products-import-manual-by-sku',
                'auto_sync_collections_to_db');

			if ( is_object( $collection ) && property_exists( $collection, 'id' ) ) {
				$nsi_default_region_id = get_amplify_region_id();
				$sku = self::get_product_sku_from_collection_data( $collection );

				$collection_region_ids = property_exists( $collection, 'region_ids' ) && is_array( $collection->region_ids ) ? $collection->region_ids : array();
				// skip if not NSI default
				$is_nsi_default = in_array( $nsi_default_region_id, $collection_region_ids );
				if ( ! $is_nsi_default ) {
					self::disable_products_without_nsi_region($sku, $collection_region_ids);
					return __("Product is not in default region.");
				}
				self::import_product_collection( $collection );
				return true;
			} else {
				if ( is_object( $collection ) && property_exists( $collection, 'message' ) ) {
					return $collection->message;
				}
			}
			return false;
		}


		protected static function get_product_import_id_by_collection_id( $collection_id ) {
			global $wpdb;
			$result = $wpdb->get_var( $wpdb->prepare( "SELECT
						p.ID AS id
					FROM $wpdb->posts p
					LEFT JOIN $wpdb->postmeta pm1 ON (pm1.post_id = p.ID AND pm1.meta_key = 'collection_id')
					WHERE p.post_type = 'product_import'
					AND pm1.meta_value = %s
				", $collection_id ) );
			return $result ? intval( $result ) : $result;
		}


		protected static function get_product_id_by_collection_id( $collection_id ) {
			global $wpdb;
			$result = $wpdb->get_var( $wpdb->prepare( "SELECT
						p.ID AS id
					FROM $wpdb->posts p
					LEFT JOIN $wpdb->postmeta pm1 ON (pm1.post_id = p.ID AND pm1.meta_key = 'product_collection_id')
					WHERE p.post_type = 'product'
					AND pm1.meta_value = %s
				", $collection_id ) );
			return $result ? intval( $result ) : $result;
		}


		protected static function delete_unsynced_products() {
			if ( defined( 'CROWN_PRODUCT_API_DELETE_UNSYNCED_DISABLED' ) && CROWN_PRODUCT_API_DELETE_UNSYNCED_DISABLED ) return;
			global $wpdb;

			$existing_collection_ids = $wpdb->get_col( "SELECT
						pm1.meta_value AS id
					FROM $wpdb->posts p
					LEFT JOIN $wpdb->postmeta pm1 ON (pm1.post_id = p.ID AND pm1.meta_key = 'product_collection_id')
					WHERE p.post_type = 'product'
				" );

			$synced_collection_ids = $wpdb->get_col( "SELECT
						pm1.meta_value AS id
					FROM $wpdb->posts p
					LEFT JOIN $wpdb->postmeta pm1 ON (pm1.post_id = p.ID AND pm1.meta_key = 'collection_id')
					WHERE p.post_type = 'product_import'
				" );

			$collection_ids_to_delete = array_values( array_diff( $existing_collection_ids, $synced_collection_ids ) );
			foreach ( $collection_ids_to_delete as $collection_id ) {
				$product_id = self::get_product_id_by_collection_id( $collection_id );
				wp_delete_post( $product_id, false );
			}

		}


		public static function cron_auto_import_from_collections_to_db() {
			$transient_key = 'auto_sync_products_from_collections_to_db_lock';
			if (get_transient($transient_key)) {
				return;
			}

			if (! wp_next_scheduled ( 'crown_auto_sync_products_from_collections_to_db' )) {
				wp_schedule_event( time(), '10min', 'crown_auto_sync_products_from_collections_to_db' );
			}

			$import_start_time = date( 'Y-m-d H:i:s' );
			update_option( 'crown_product_api_import_start_time', $import_start_time, false );

			self::request_product_import( $import_start_time );
		}


		public static function request_product_import( $import_start_time ) {
			if ( defined( 'CROWN_PRODUCT_API_IMPORT_DISABLED' ) && CROWN_PRODUCT_API_IMPORT_DISABLED ) return;
			$request_url = get_site_url() . '/wp-json/amplify/v2/auto-sync-collection-to-db';

			$request_url = add_query_arg( array(
				'crown_import_products' => 1,
				'_wpnonce' => wp_create_nonce( 'crown_import_products-' . md5( $import_start_time ) )
			), $request_url );

			$request_args = array(
				'headers' => array(
					'Accept-Language' => 'en-US'
				),
				'timeout' => 30,
				'redirection' => 5,
				'httpversion' => '1.1',
				'sslverify' => false
			);
			wp_remote_get( $request_url, $request_args );
		}


		public static function handle_auto_sync_products_from_collections_to_db_request() {
			if ( ! isset( $_GET['crown_import_products'] ) || ! boolval( $_GET['crown_import_products'] ) ) return;

			$import_start_time = get_option( 'crown_product_api_import_start_time', '' );
			if ( empty( $import_start_time ) ) return;
			if ( ! wp_verify_nonce( $_GET[ '_wpnonce' ], 'crown_import_products-' . md5( $import_start_time ) ) ) return;
			$transient_key = 'auto_sync_products_from_collections_to_db_lock';
			if (get_transient($transient_key)) {
				return;
			}
			set_transient($transient_key, true, AMPLIFI_AUTO_COLLECTION_TO_DB_IMPORT_TIMEOUT);
			$count = self::auto_sync_products_from_collections_to_db( self::$auto_sync_products_from_collections_to_db_batch );
			delete_transient($transient_key);
			if ( ! $count ) {
				$draft_ids = get_posts( array(
					'post_type' => 'product_import',
					'posts_per_page' => -1,
					'post_status' => array( 'draft' ),
					'fields' => 'ids'
				) );
				foreach ( $draft_ids as $draft_id ) {
					wp_delete_post( $draft_id, true );
				}
                if ( wp_next_scheduled ( 'crown_auto_sync_products_from_collections_to_db' ) ) {
                    wp_clear_scheduled_hook( 'crown_auto_sync_products_from_collections_to_db' );
                }
                update_option( 'settings_for_cron_manual_sync_amplifi_from_collections_to_db', [
                    'start_time' => 0,
                ], false );
				update_option( 'crown_product_api_import_start_time', '', false );
			}
		}

		public static function cron_add_interval($schedules) {
			$schedules['5min'] = array(
				'interval' => 300, // seconds
				'display' => __('Every 5 minutes')
			);
			$schedules['10min'] = array(
				'interval' => 600, // seconds
				'display' => __('Every 10 minutes')
			);
			$schedules['15min'] = array(
				'interval' => 900, // seconds
				'display' => __('Every 15 minutes')
			);
			$schedules['30min'] = array(
				'interval' => 1800, // seconds
				'display' => __('Every 30 minutes')
			);
			return $schedules;
		}

		// Sync product with Amplifi to collection import
		public static function setup_schedule_manual_sync_amplifi_to_collections_import() {
			if ( !wp_next_scheduled ( 'crown_manual_sync_amplifi_to_collections_import' )) {
				wp_schedule_event(time() + 60, '5min', 'crown_manual_sync_amplifi_to_collections_import');
			}
		}

		public static function manual_sync_amplifi_to_collections_import() {
			$post_id 		 = 'options';
			$category_id 	 = get_field('id_category', $post_id);
			if(empty($category_id)){

				if (wp_next_scheduled('crown_manual_sync_amplifi_to_collections_import')) {
					wp_clear_scheduled_hook('crown_manual_sync_amplifi_to_collections_import');
				}

				return;
			}

			$transient_key = 'manual_sync_amplifi_to_collections_import_running';
			if (get_transient($transient_key)) {
				return;
			}
			set_transient($transient_key, true, AMPLIFI_TO_COLLECTION_IMPORT_TIMEOUT);

			$cron_job_start_time        = microtime(true);
			$all_items_processed        = true;
            $batch_size 		        = get_field('batch_size', $post_id);
            $created_start_date         = get_field('created_start_date', $post_id);
            $created_end_date 	        = get_field('created_end_date', $post_id);
            $updated_start_date         = get_field('updated_start_date', $post_id);
            $updated_end_date 	        = get_field('updated_end_date', $post_id);
            $offset_manual_input 		= get_field('offset', $post_id);
			$settings_cron 				= get_option('settings_for_cron_manual_sync_amplifi_to_collections_import');
            $offset 					= $settings_cron['offset'];
            $not_default_reg_col        = $settings_cron['not_default_reg_col'];

			if($settings_cron['start_time'] !== 0) {
				$date_current = $settings_cron['start_time'];
			} else {
				$date_current = date('Y-m-d-H-i-s');
				$settings_cron['start_time'] = $date_current;
			}

            $amplifi_log_file_path = self::get_amplifi_log_file_path($category_id, $date_current, 'amplify-logs/amplify-products-import-manual-by-category' , 'auto_sync_to_collections');

            $batch_size = (!empty($batch_size))? $batch_size : 100;
			$output = "\n" . 'Sync parameters:' . "\n" . 'Import by ID category - ' . $category_id . "\n" . 'Batch size - '. $batch_size;
			if(!empty($created_start_date))	{$output .= "\n" . 'Created start date - ' . $created_start_date;}
			if(!empty($created_end_date))	{$output .= "\n" . 'Created end date - ' . $created_end_date;}
			if(!empty($updated_start_date))	{$output .= "\n" . 'Updated start date - ' . $updated_start_date;}
			if(!empty($updated_end_date))	{$output .= "\n" . 'Updated end date - ' . $updated_end_date;}
			if(!empty($offset_manual_input)){$output .= "\n" . 'Offset manually input - ' . $offset_manual_input;}

			$current_date 		= date('Y-m-d');
			$url_site 			= get_site_url();
			$key 				= 0;
            $not_default_counter = 0;

			if( $offset == 0 ){
                if (!empty($offset_manual_input)) {
                    $offset = $offset_manual_input;
                }
                file_put_contents( $amplifi_log_file_path, $output, FILE_APPEND );
                update_option('settings_for_cron_manual_sync_amplifi_to_collections_import', $settings_cron, false);

                $enabled_categories_sync = get_field('enabled_categories_sync', $post_id);
                if ($enabled_categories_sync) {
					self::import_categories();
					$output = "\n" . 'Amplifi categories updated.';
					file_put_contents( $amplifi_log_file_path, $output, FILE_APPEND );
				}
			}
			$nsi_default_region_id 	= get_amplify_region_id();
			$params = [
				'parent_id' => $category_id,
				'folder_level' => 'leaf',
				'limit' => $batch_size,
				'offset' => $offset,
				'minified' => 'true',
				'region_ids' => $nsi_default_region_id,
			];

			if(!empty($created_start_date))	{$params['created_start_date'] = $created_start_date;}
			if(!empty($created_end_date))	{$params['created_end_date'] = $created_end_date;}

			if(!empty($updated_start_date)){
				$params['updated_start_date'] = $updated_start_date;
			} else {
				$params['updated_start_date'] = date("Y-m-d", strtotime("-2 days"));
			}

			if(!empty($updated_end_date)){
				$params['updated_end_date'] = $updated_end_date;
			} else {
				$params['updated_end_date'] = $current_date;
			}

			$amplifi_response = Crown_Amplifi_Api::get_collections( $params );

			if ( is_object( $amplifi_response ) ) {
                $output = property_exists($amplifi_response, 'message')
                    ? "\n" . '[' . date('Y-m-d H:i:s') . '] Collections load failed. Message (reason): "' . $amplifi_response->message . '".'
                    : "\n" . '[' . date('Y-m-d H:i:s') . '] Collections load failed. Message (reason) is absent.';
				file_put_contents( $amplifi_log_file_path, $output, FILE_APPEND );
				self::delete_cron_manual_sync_amplifi_to_collections_import($post_id, $amplifi_log_file_path, $offset, false, false );
			} elseif ( is_array($amplifi_response) && !empty($amplifi_response) ) {
                foreach ( $amplifi_response as $collection ) {
					$sku = self::get_product_sku_from_collection_data( $collection );
					$key++;
                    if ( empty( $sku ) ) {
						$sku_output =  'SKU_NOT_FOUND ';
						$output = "\n" . $offset + $key . ', [' . date( 'Y-m-d H:i:s' ) . '] ' . $sku_output . 'Title - ' . $collection->name . ' , Collection ID - ' . $collection->id . ';';
						file_put_contents( $amplifi_log_file_path, $output, FILE_APPEND );
						continue;
					} else {
						$sku_output =  'SKU - ' . $sku . ', ';
					}
					$collection_region_ids = property_exists( $collection, 'region_ids' ) && is_array( $collection->region_ids ) ? $collection->region_ids : array();
					// skip if not NSI default
					$is_nsi_default = in_array( $nsi_default_region_id, $collection_region_ids );

                    $postarr = array(
                        'post_type' => 'product_import',
                        'post_status' => 'publish',
                        'post_title' => $collection->name
                    );

					if ( ! $is_nsi_default ) {
						self::disable_products_without_nsi_region($sku, $collection_region_ids);
                        $output = "\n" . $offset + $key . ', [' . date( 'Y-m-d H:i:s' ) . '] NOT IN DEFAULT REGION, ' . $sku_output . 'Title - ' . $postarr['post_title'] . ' , Collection ID - ' . $collection->id . ';';
                        file_put_contents( $amplifi_log_file_path, $output, FILE_APPEND );
                        $not_default_counter++;
                        continue;
                    }

					if ( property_exists( $collection, 'additional_title' ) && ! empty( $collection->additional_title ) ) $postarr['post_title'] = $collection->additional_title;

					$import_id = self::get_product_import_id_by_collection_id( $collection->id );
					if ( ! $import_id ) {
						$import_id = wp_insert_post( $postarr );
						update_post_meta( $import_id, 'collection_id', $collection->id );
						$output_url = 'Product Collection to import URL CREATED - ' . $url_site . '/wp-admin/post.php?post=' . $import_id . '&action=edit, ';
					} else {
						wp_update_post( array_merge( $postarr, array( 'ID' => $import_id ) ) );
						$output_url = 'Product Collection to import URL UPDATED - ' . $url_site . '/wp-admin/post.php?post=' . $import_id . '&action=edit, ';
					}
					$output = "\n" . $offset + $key . ', [' . date( 'Y-m-d H:i:s' ) . '] ' . $output_url . $sku_output . 'Title - ' . $postarr['post_title'] . ' , Collection ID - ' . $collection->id . ';';
					file_put_contents( $amplifi_log_file_path, $output, FILE_APPEND );

					update_post_meta( $import_id, 'collection_data', $collection );
					update_post_meta( $import_id, 'collection_sku', $sku );
					update_field('manual_sync_amplify', true, $import_id);

					$cron_job_current_time = microtime(true);
					$cron_job_elapsed_time = $cron_job_current_time - $cron_job_start_time;

					if ($cron_job_elapsed_time >= AMPLIFI_TO_COLLECTION_IMPORT_TIMEOUT) {
						$output = "\n" . self::AMPLIFI_IMPORT_REACHED_TIME_LIMIT;
						file_put_contents( $amplifi_log_file_path, $output, FILE_APPEND );
						$all_items_processed = false;
						break;
					}
				}

                do_action('start_crown_manual_sync_products_from_collections_to_db');
                $not_default_reg_col += $not_default_counter;
                $output = "\n" . '*** New batch from Amplifi started, current handled items (offset): ' . ($offset + $key) . ', incl. not in default region (skipped): ' . ($not_default_reg_col) . ' ***';
                file_put_contents( $amplifi_log_file_path, $output, FILE_APPEND );

				$settings_cron['offset'] = $offset + $key;
				$settings_cron['not_default_reg_col'] = $not_default_reg_col;
				update_option('settings_for_cron_manual_sync_amplifi_to_collections_import', $settings_cron, false);

				if( $key < $batch_size && $all_items_processed ){
					self::delete_cron_manual_sync_amplifi_to_collections_import($post_id, $amplifi_log_file_path, $offset, $key, $not_default_reg_col);
				}

			} else {
			    if ( is_string($amplifi_response) ) {
					$output = "\n" . '[' . date( 'Y-m-d H:i:s' ) . '] Error message: ' . $amplifi_response;
				} else {
					$output = "\n" . '[' . date( 'Y-m-d H:i:s' ) . '] There is an issue with connection to Amplifi. Collections load failed or zero collections loaded.';
				}
				file_put_contents( $amplifi_log_file_path, $output, FILE_APPEND );
				self::delete_cron_manual_sync_amplifi_to_collections_import($post_id, $amplifi_log_file_path, $offset, false, false);
			}
			delete_transient($transient_key);
		}

		public static function delete_cron_manual_sync_amplifi_to_collections_import($post_id, $log_file_path, $offset, $key, $not_default_reg_col){
			if (wp_next_scheduled('crown_manual_sync_amplifi_to_collections_import')) {
				wp_clear_scheduled_hook('crown_manual_sync_amplifi_to_collections_import');

				update_option('settings_for_cron_manual_sync_amplifi_to_collections_import', [
					'offset' => 0,
					'start_time' => 0,
                    'not_default_reg_col' => 0
				], false);

				update_field('id_category', '', $post_id);
				update_field('enabled_categories_sync', false, $post_id);
				update_field('batch_size', '', $post_id);
				update_field('offset', '', $post_id);
				update_field('created_start_date', '', $post_id);
				update_field('created_end_date', '', $post_id);

			}
			if ( is_int($key) ) {
				$result_message = $key === 0
                    ? "Not found collections in the Amplifi for used parameters"
                    : 'Import of ' . $offset + $key . ' products finished, incl. not default region (skipped): ' . ($not_default_reg_col ?? 0);
				file_put_contents( $log_file_path, "\n" . $result_message, FILE_APPEND );
            }
		}

		// Product import from collection import to woocomerce wp_product table
		public static function setup_schedule_manual_import_from_collections_to_db() {
			if (! wp_next_scheduled ( 'crown_manual_sync_products_from_collections_to_db' )) {
				wp_schedule_event(time(), self::$manual_sync_products_from_collections_to_db_recurrence, 'crown_manual_sync_products_from_collections_to_db');
			}
		}

		public static function manual_sync_products_amplify() {
			$transient_key = 'manual_sync_products_amplify_lock';
			if (get_transient($transient_key)) {
				return;
			}
			set_transient($transient_key, true, AMPLIFI_COLLECTION_TO_DB_IMPORT_TIMEOUT);
			$posts = get_posts( array(
				'post_type' 		=> 'product_import',
				'posts_per_page' 	=> 50,
				'meta_key'          => 'manual_sync_amplify',
				'orderby'           => 'meta_value',
				'order'             => 'DESC'
			) );

            $date_current = date('Y-m-d');
            self::$amplifi_log_file_name = self::get_amplifi_log_file_path('', $date_current,
                'amplify-logs/amplify-products-import-manual-by-sku',
                'auto_sync_collections_to_db');

			if(!empty($posts)){
				foreach ( $posts as $post ) {
					$collection = get_post_meta( $post->ID, 'collection_data', true );
					self::import_product_collection( $collection , $post->ID );
				}
			} else {
                update_option( 'settings_for_cron_manual_sync_amplifi_from_collections_to_db', [
                    'start_time' => 0,
                ], false );
				if (wp_next_scheduled('crown_manual_sync_products_from_collections_to_db')) {
					wp_clear_scheduled_hook('crown_manual_sync_products_from_collections_to_db');
				}
			}
			delete_transient($transient_key);
		}

		protected static function auto_sync_products_from_collections_to_db( $batch_size = 1 ) {
			$posts = get_posts( array(
				'post_type' 		=> 'product_import',
				'posts_per_page' 	=> $batch_size,
				'orderby'           => 'date',
				'order'             => 'ASC',
				'meta_query' => array(
			        array(
				        'key' => 'manual_sync_amplify',
				        'compare' => 'NOT EXISTS',
			        ),
			       ),
			) );

            $settings_cron 	= get_option('settings_for_cron_manual_sync_amplifi_from_collections_to_db');

            if ( $settings_cron['start_time'] !== 0 ) {
                $date_current = $settings_cron['start_time'];
            } else {
                $date_current = date('Y-m-d');
                $settings_cron['start_time'] = $date_current;
            }

            self::$amplifi_log_file_name = self::get_amplifi_log_file_path('', $date_current,
                'amplify-logs/amplify-products-import-auto',
                'auto_sync_collections_to_db');

			$synced_products = self::get_all_synced_products();
            foreach ( $posts as $post ) {
				$collection = get_post_meta( $post->ID, 'collection_data', true );
				if ( !empty( $collection->id ) ) {
					self::import_product_collection( $collection );
					if (!isset($synced_products[$collection->id])) {
						self::add_to_synced_products($collection);
					}
				}
				wp_delete_post( $post->ID, true );
			}

			return count( $posts );
		}

        private static function sync_products_from_collections( $batch_size ): void
        {
            $posts_per_page = ( $batch_size === '' ) ? 100 : $batch_size;
            $posts = get_posts( array(
                'post_type'      => 'product_import',
                'posts_per_page' => $posts_per_page,
                'orderby'        => 'date',
                'order'          => 'ASC',
            ) );
			$synced_products = self::get_all_synced_products();
            $date_current = date('Y-m-d');
            self::$amplifi_log_file_name = self::get_amplifi_log_file_path('', $date_current,
                'amplify-logs/amplify-products-import-manual-by-sku',
                'auto_sync_collections_to_db');
            foreach ( $posts as $post ) {
                $collection = get_post_meta( $post->ID, 'collection_data', true );
                if ( !empty( $collection->id ) ) {
                    self::import_product_collection( $collection );
					if (!isset($synced_products[$collection->id])) {
						self::add_to_synced_products($collection);
					}
                }
                wp_delete_post( $post->ID, true );
            }
        }

		static protected function import_product_collection( $collection, $id_collection_to_import = null) {
			if ( ! $collection || empty( $collection ) ) return;

			$record = array(
				'Collection Data' => $collection,
				'Collection ID' => $collection->id,
				'Collection Parent ID' => property_exists( $collection, 'parent_id' ) ? $collection->parent_id : '',
				'Collection Last Updated' => property_exists( $collection, 'updated_date' ) ? $collection->updated_date : date( 'Y-m-d\TH:i:s.000\Z' ),
				'Additional Title' => property_exists( $collection, 'additional_title' ) ? $collection->additional_title : '',
				'Image Master File 1' => property_exists( $collection, 'display_file' ) && ! empty( trim( $collection->display_file ) ) ? 'https://fs.amplifi.io/file?id=' . trim( $collection->display_file ) : ''
			);

            $indexed_attributes = self::get_amplifi_attributes_from_db();
            if ( !$indexed_attributes ) {
                $indexed_attributes = self::get_amplifi_attributes();
                if ( !empty($indexed_attributes) ) {
                    self::save_amplifi_attributes( $indexed_attributes );
                }
            }

			foreach ( $collection->attributes as $attr ) {
				$key = property_exists( $attr, 'label' ) ? trim( $attr->label ) : '';
				if ( empty( $key ) ) continue;
				if ( $key == 'Pack Type' ) continue;
				$value = property_exists( $attr, 'value' ) ? $attr->value : '';
				$attribute_id = property_exists( $attr, 'id' ) ? $attr->id : null;
				if ( $attribute_id && is_array( $value ) ) {
					self::get_attribute_value($attribute_id, $value, $indexed_attributes);

					if ( ! empty( $value ) && is_object( $value[0] ) ) {
						$value = implode( ', ', array_map( function( $n ) { return property_exists( $n, 'value' ) ? $n->value : ''; }, $value ) );
					} else {
						$value = implode( ', ', $value );
					}
                }

				$record[ $key ] = array(
                        'id' => $attribute_id,
                        'value' => $value,
                );
			}

			$sku = self::get_record_prop( $record, 'SKU' );
			if ( ! empty( $sku ) ) {
				$files = self::get_collection_files( $collection->id );
				$primary_image_id = property_exists( $collection, 'display_file' ) ? $collection->display_file : '';
				if ( array_key_exists( $primary_image_id, $files['images'] ) ) {
					$primary_image = $files['images'][ $primary_image_id ];
					unset( $files['images'][ $primary_image_id ] );
					$files['images'] = array_merge( array( $primary_image_id => $primary_image ), $files['images'] );
				}
				foreach ( array_values( $files['images'] ) as $i => $file ) {
					$record[ 'Image Master File ' . ( $i + 1 ) ] = 'https://cdn.amplifi.pattern.com/' . $file['id'];
					$record[ 'Filename ' . ( $i + 1 ) ] = $file['file_name'];
				}
                foreach ( array_values( $files['videos'] ) as $i => $file ) {
					$record[ 'Video Master File ' . ( $i + 1 ) ] = 'https://cdn.amplifi.pattern.com/' . $file['id'];
					$record[ 'Video Filename ' . ( $i + 1 ) ] = $file['file_name'];
				}
    			foreach ( array_values( $files['docs'] ) as $i => $file ) {
					$record[ 'Document Master File ' . ( $i + 1 ) ] = 'https://cdn.amplifi.pattern.com/' . $file['id'];
					$record[ 'Document Filename ' . ( $i + 1 ) ] = $file['file_name'];
				}

				self::import_record( $record , $id_collection_to_import);
			} else {
				wp_delete_post( $id_collection_to_import, true );
            }

		}

		static protected function get_attribute_value( $attribute_id, &$value, $attributes ) {
			$attr = $attributes[$attribute_id];
		    if ( $attr->value_type == 'Pick List' && property_exists( $attr, 'options' ) && is_array( $attr->options ) ) {
				foreach ( $value as $i => $v ) {
					if ( is_array( $v ) && ! empty( $v ) ) {
						$v = $v[0];
					}
                    if ( array_key_exists($v, $attributes[$attribute_id]->options) ) {
                        $value[$i] = $attributes[$attribute_id]->options[$v]->label ?? '';
                    }
				}
		    }
        }

		static protected function get_collection_files( $collection_id ) {

			$files = array(
				'images' => array(),
				'videos' => array(),
				'docs' => array()
			);

			$response = Crown_Amplifi_Api::get_collection_files( $collection_id );

            if ( !empty($response) ) {
			    foreach ( $response as $file_data ) {
				    $id = property_exists( $file_data, 'id' ) ? trim( $file_data->id ) : '';
				    if ( empty( $id ) ) continue;
				    $is_nsi_default = property_exists( $file_data, 'region_ids' ) && is_array( $file_data->region_ids ) && in_array( get_amplify_region_id(), $file_data->region_ids );
				    if ( ! $is_nsi_default ) continue;
	    			$file_name = property_exists( $file_data, 'file_name' ) ? trim( $file_data->file_name ) : '';
		    		$file = array(
			    		'id' => $id,
				    	'file_name' => $file_name
    				);
	    			$type = property_exists( $file_data, 'type' ) ? trim( $file_data->type ) : '';
		    		if ( $type == 'image' ) {
			    		$files['images'][ $id ] = $file;
				    } else if ( $type == 'video' ) {
					    $files['videos'][ $id ] = $file;
			    	} else if ( $type == 'document' ) {
					    $files['docs'][ $id ] = $file;
			    	}
			    }
            }

			return $files;

		}


		static protected function import_categories() {
			$get_collections_parameters = get_field( 'get_collections_parameters', 'option' );
			if( !empty( $get_collections_parameters ) && isset($get_collections_parameters['parent_id'])){
				$products_by_category_id = $get_collections_parameters['parent_id'];
			} elseif (defined( 'AMPLIFY_DEFAULT_COLLECTIONS_PARENT_ID' ) && AMPLIFY_DEFAULT_COLLECTIONS_PARENT_ID) {
				$products_by_category_id = AMPLIFY_DEFAULT_COLLECTIONS_PARENT_ID;
			} else {
				return;
			}

            $batch_size = 250;
            $categories_total =0;
            $categories_completed = 0;
            $indexed_categories_data = array();
            for ($count_page = 0; ; $count_page++) {
                if (class_exists('WP_CLI')) WP_CLI::log('count_page processing - ' . $count_page);
                $params = [
                    'offset' => ($batch_size * $count_page),
                    'limit' => $batch_size
                ];
                $categories_data = Crown_Amplifi_Api::get_categories($params);
                if (empty($categories_data)) {
                    break;
                }
                $nsi_default_region_id = get_amplify_region_id();
                foreach ($categories_data as $category_data) {
                    $categories_total++;
                    $id = property_exists($category_data, 'id') ? trim($category_data->id) : null;
                    if (empty($id)) continue;
                    $name = property_exists($category_data, 'name') ? trim($category_data->name) : '';
                    if (empty($name)) continue;

                    if (is_array($category_data->region_ids) && in_array($nsi_default_region_id, $category_data->region_ids)) {
                        $cat = (object)[
                            'id' => $id,
                            'name' => $name,
                            'parent_id' => property_exists($category_data, 'parent_id') ? trim($category_data->parent_id) : '',
                            'children' => []
                        ];
                        $indexed_categories_data[$id] = $cat;
                        $categories_completed++;
                    } else {
                        $term_id = self::get_category_id_by_amplifi_id($id);
                        if ($term_id) {
                            wp_delete_term($term_id, 'product_cat');
                        }
                    }
                }
            }
            $category_tree = array();
            foreach ($indexed_categories_data as $root_id => $cat) {
                if (!empty($cat->parent_id) && array_key_exists($cat->parent_id, $indexed_categories_data)) {
                    $indexed_categories_data[$cat->parent_id]->children[$cat->id] = $cat;
                } else {
                    $category_tree[$cat->id] = $cat;
                }
            }
            $category_tree = array_key_exists($products_by_category_id, $category_tree) ? $category_tree[$products_by_category_id]->children : array();

            foreach ($category_tree as $cat) {
                self::import_category($cat);
            }
            if ( class_exists( 'WP_CLI' ) ) WP_CLI::log( 'Import categories done. Categories handled: ' . $categories_completed . "\nCategories total: " . $categories_total );
        }


		static protected function import_category( $cat, $parent_id = 0 ) {

			$file_dir 		= wp_upload_dir();
			$date_current 	= date("Y-m-d");
			$folder_name 	= 'amplify-logs/amplify-categories-import';
			$path_folder 	= $file_dir['basedir'] . '/' . $folder_name;
			$log_file 		= $path_folder . '/categories_import-' . $date_current . '.log';

			if ( !file_exists($path_folder)) {
				mkdir( $path_folder, 0755, true );
			}

			if(!file_exists($log_file)){
				fopen($log_file, 'w');
				chmod($log_file, 0664);
			}

			$output = file_get_contents( $log_file );
            $category_amplifi_id = $cat->id;
		    $term_id = null;
			$term_data = (object) array('taxonomy' => 'product_cat', 'name' => $cat->name, 'slug' => sanitize_title( $cat->name ), 'parent' => $parent_id );
			
			$term_id = self::get_category_id_by_amplifi_id( $category_amplifi_id );
			if ( ! $term_id ) {
				$result = wp_insert_term( $term_data->name, $term_data->taxonomy, array( 'slug' => $term_data->slug, 'parent' => $term_data->parent ) );
				if ( ! is_wp_error( $result ) ) {
					$term_id = $result['term_id'];
					update_term_meta( $term_id, 'amplifi_id', $category_amplifi_id );
					$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Category "' . $term_data->name . '" [id: ' . $category_amplifi_id . '] CREATED.' . "\n";
					file_put_contents( $log_file, $output );
				}
			}

			if ( $term_id ) {
				wp_update_term( $term_id, $term_data->taxonomy, array( 'parent' => $term_data->parent, 'name' =>  $term_data->name, 'slug' => $term_data->slug) );
				$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Category "' . $term_data->name . '" [id: ' . $category_amplifi_id . '] UPDATED.' . "\n";
				file_put_contents( $log_file, $output );
				foreach ( $cat->children as $child ) {
					self::import_category( $child, $term_id );
				}
			}

		}

		/**
		 * Update a lookup table for an object.
		 *
		 * @param int    $id ID of object to update.
		 * @param string $table Lookup table name.
		 *
		 * @return NULL
		 */
		protected static function update_lookup_table( $id, $table, $is_new = FALSE ) {
			global $wpdb;

			$id    = absint( $id );
			$table = sanitize_key( $table );

			if ( empty( $id ) || empty( $table ) ) {
				return false;
			}

			$existing_data = wp_cache_get( 'lookup_table', 'object_' . $id );
			$update_data   = self::get_data_for_lookup_table( $id, $table, $is_new );

			if ( ! empty( $update_data ) && $update_data !== $existing_data ) {
				$wpdb->replace(
					$wpdb->$table,
					$update_data
				);
				wp_cache_set( 'lookup_table', $update_data, 'object_' . $id );
			}
		}

		/**
		 * Get data to save to a lookup table.
		 *
		 * @param int    $id ID of object to update.
		 * @param string $table Lookup table name.
		 * @param bool $is_new Flag identifying if product is new.
		 * @return array
		 */
		protected static function get_data_for_lookup_table( $id, $table, $is_new ) {
			if ( 'wc_product_meta_lookup' === $table ) {
                $data = array(
                    'product_id'     => absint( $id ),
                    'sku'            => get_post_meta( $id, '_sku', true ),
                    'virtual'        => 0,
                    'downloadable'   => 0,
                    'min_price'      => 0,
                    'max_price'      => 0,
                    'onsale'         => 0,
                    'stock_quantity' => null,
                    'stock_status'   => 'instock',
                    'rating_count'   => 0,
                    'average_rating' => 0,
                    'total_sales'    => 0,
                    'tax_status'     => 'taxable',
                    'tax_class'      => '',
                );
                if ( !$is_new ) {
                    $price_meta   = (array) get_post_meta( $id, '_price', false );
                    $manage_stock = get_post_meta( $id, '_manage_stock', true );
                    $stock        = 'yes' === $manage_stock ? wc_stock_amount( get_post_meta( $id, '_stock', true ) ) : null;
                    $price        = wc_format_decimal( get_post_meta( $id, '_price', true ) );
                    $sale_price   = wc_format_decimal( get_post_meta( $id, '_sale_price', true ) );
                    $updated_data = array(
                        'virtual'        => 'yes' === get_post_meta( $id, '_virtual', true ) ? 1 : 0,
                        'downloadable'   => 'yes' === get_post_meta( $id, '_downloadable', true ) ? 1 : 0,
                        'min_price'      => reset( $price_meta ),
                        'max_price'      => end( $price_meta ),
                        'onsale'         => $sale_price && $price === $sale_price ? 1 : 0,
                        'stock_quantity' => $stock,
                        'stock_status'   => get_post_meta( $id, '_stock_status', true ),
                        'rating_count'   => array_sum( (array) get_post_meta( $id, '_wc_rating_count', true ) ),
                        'average_rating' => get_post_meta( $id, '_wc_average_rating', true ),
                        'total_sales'    => get_post_meta( $id, 'total_sales', true ),
                        'tax_status'     => get_post_meta( $id, '_tax_status', true ),
                        'tax_class'      => get_post_meta( $id, '_tax_class', true ),
                    );
                    $data = array_merge($data, $updated_data);
                }

				return $data;
			}
			return array();
		}

        public static function cron_amplify_products_clean_up() {
            $enable_disabling_products 	= get_field('enable_disabling_products_auto_sync', 'option') ?? TRUE;
            if (!$enable_disabling_products) {
                return;
            }

            self::push_products_to_clean_up_queue();
        }

		public static function cron_amplify_attributes_sync() {
			$attributes = self::get_amplifi_pick_list_attributes();
			if (!empty($attributes)) {
				update_option('amplifi_attributes_mapping', $attributes, false);
			}
		}

        public static function cron_amplify_category_cleanup(): void {
            $result = self::generate_log_file_path('amplify-logs/amplify-categories-import', '/categories_cleanup-');

            if (!file_exists($result['path_folder'])) {
                mkdir($result['path_folder'], 0755, true); // Recursive directory creation
            }

            $output = file_get_contents( $result['log_file'] );
            $categories_data = Crown_Amplifi_Api::get_categories();

            if (empty($categories_data)) {
                return;
            }

            $terms = get_terms(array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
            ));

            if (empty($terms)) {
                return;
            }

            $nsi_default_region_id = get_amplify_region_id();
			$proper_categories_data = array();
			foreach ( $categories_data as $category_data ) {
				$id = property_exists( $category_data, 'id' ) ? trim( $category_data->id ) : null;
				if ( empty( $id ) ) continue;
				$name = property_exists( $category_data, 'name' ) ? trim( $category_data->name ) : '';
				if ( empty( $name ) ) continue;

				if (is_array($category_data->region_ids) && in_array($nsi_default_region_id, $category_data->region_ids)) {
					$proper_categories_data[] = $id;
				}
			}

            foreach ($terms as $term) {
                if ($term->name == 'Uncategorized') continue;
                $term_amplifi_id = get_term_meta( $term->term_id, 'amplifi_id', true );
                if (empty($term_amplifi_id) || !in_array($term_amplifi_id, $proper_categories_data)) {
					wp_delete_term($term->term_id, 'product_cat');

					$output .= '[' . date('Y-m-d H:i:s') . '] Category "' . $term->name .
						'"[id: ' . $term->term_id . '] DELETED.' . "\n";
                }

            }

            file_put_contents($result['log_file'], $output);
        }

		public static function push_products_to_clean_up_queue($force = FALSE) {
			$product_ids = get_posts( array( 'post_type' => 'product', 'posts_per_page' => -1, 'fields' => 'ids' ) );
			foreach ( $product_ids as $product_id ) {
				self::$product_background_cleanup->push_to_queue( array( 'product_id' => $product_id, 'force' => $force, 'retry' => false ) );
			}
			self::$product_background_cleanup->save()->dispatch();
        }

        public static function init_product_background_cleanup() {
            $active_plugins = (array) get_option( 'active_plugins', array() );
            if ( in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins ) ) {
                include( dirname( __FILE__ ) . '/class-crown-products-background-cleanup.php' );
                self::$product_background_cleanup = new Crown_Products_Background_Cleanup();

				if ( ! wp_next_scheduled( 'crown_amplify_products_clean_up' ) ) {
					$next_sync_time = self::get_next_sync_time(6, 3);
					wp_schedule_event( intval( $next_sync_time->format( 'U' ) ), 'weekly', 'crown_amplify_products_clean_up' );
				}
            }
        }

		static protected function get_category_id_by_amplifi_id( $amplifi_id ) {
			$term_ids = get_terms( array(
				'taxonomy' => 'product_cat',
				'hide_empty' => false,
				'fields' => 'ids',
				'number' => 1,
				'meta_query' => array(
					array( 'key' => 'amplifi_id', 'value' => $amplifi_id )
				)
			) );
            return ! empty( $term_ids ) ? $term_ids[0] : null ;
		}

        /**
         * @return void
         */
        public static function register_rest_api_amplifi_category_import(): void
        {
            //path=/wp-json/amplify/v2/product-category-import
            register_rest_route('amplify/v2', 'product-category-import', [
                'methods' => 'GET',
                'callback' => array(__CLASS__, 'acf_save_options_page_category_import'),
                'args' => [
                    'postID' => ['options'],
                ],
            ]);
        }

		/**
         * @return void
         */
        public static function register_rest_api_manual_sync_ns_price_products(): void
        {
            //path=/wp-json/netsuite/v2/manual-sync-ns-price-products
            register_rest_route('netsuite/v2', 'manual-sync-ns-price-products', [
                'methods' => 'GET',
                'callback' => array(__CLASS__, 'acf_save_options_page_manual_sync_ns_price_products'),
            ]);
        }

        /**
         * @return void
         */
        public static function register_rest_api_amplifi_collection_import(): void
        {
            //path=/wp-json/amplify/v2/product-collection-import
            register_rest_route('amplify/v2', 'product-collection-import', [
                'methods' => 'GET',
                'callback' => array(__CLASS__, 'process_imported_collections'),
                'args' => [
                    'postID' => ['crown-shop-product-collection-import'],
                ],
            ]);
        }

		/**
		 * @return void
		 */
		public static function register_rest_api_amplifi_auto_sync_collections(): void
		{
			//path=/wp-json/amplify/v2/auto-sync-to-collection
			register_rest_route('amplify/v2', 'auto-sync-to-collection', [
				'methods' => 'GET',
				'callback' => array(__CLASS__, 'handle_auto_sync_amplifi_to_collections_import'),
			]);

			//path=/wp-json/amplify/v2/auto-sync-collection-to-db
			register_rest_route('amplify/v2', 'auto-sync-collection-to-db', [
				'methods' => 'GET',
				'callback' => array(__CLASS__, 'handle_auto_sync_products_from_collections_to_db_request'),
			]);
		}

		protected static function get_amplifi_pick_list_attributes() {
			$indexed_attributes = [];
            $attributes = Crown_Amplifi_Api::get_attributes();
			if ( is_array( $attributes ) ) {
				foreach ( $attributes as $attribute ) {
					if ( $attribute->value_type === 'Pick List' && property_exists( $attribute, 'options' ) && is_array( $attribute->options ) ) {
						$indexed_attributes[$attribute->id] = $attribute;
					}
				}
			}
			return $indexed_attributes;
		}

        public static function get_amplifi_attributes() {
            $indexed_attributes = [];
            $attributes = Crown_Amplifi_Api::get_attributes();
            if ( is_array( $attributes ) ) {
                foreach ( $attributes as $attribute ) {
                    $indexed_attributes[$attribute->id] = $attribute;
                }
            }

            return $indexed_attributes;
        }

        public static function save_amplifi_attributes( $attributes ) {
            global $wpdb;
            $existing_attributes = self::get_amplifi_attributes_from_db();

            $amplifi_pick_list_attributes_table_name = self::$amplifi_pick_list_attributes_table_name;
            foreach ( $attributes as $attr_id => $attr_data ) {
                if ( array_key_exists($attr_id, $existing_attributes) ) {
                    $attribute_options = [];
                    foreach ( $attr_data->options ?? [] as $option ) {
                        $attribute_options[ $option->id ] = $option;
                    }

                    $query = $wpdb->prepare( "UPDATE $amplifi_pick_list_attributes_table_name SET options = '%s' WHERE amplifi_id = '%s'",
                        serialize($attribute_options), $attr_id
                    );
                } else {
                    $attribute_options = [];
                    foreach ( $attr_data->options ?? [] as $option ) {
                        $attribute_options[ $option->id ] = $option;
                    }

                    $query = $wpdb->prepare( "INSERT INTO $amplifi_pick_list_attributes_table_name 
                        (`amplifi_id`, `label`, `options`, `value_type`) 
                        VALUES ('%s', '%s', '%s', '%s')",
                        $attr_id, $attr_data->label, serialize($attribute_options), $attr_data->value_type
                    );

                }

                $wpdb->query( $query );
            }
        }

        public static function get_amplifi_attributes_from_db() {
            global $wpdb;
            $amplifi_pick_list_attributes_table_name = self::$amplifi_pick_list_attributes_table_name;

            $attributes_results = $wpdb->get_results(
                "SELECT * FROM $amplifi_pick_list_attributes_table_name"
            );

            $attributes = array();
            foreach ( $attributes_results as $row ) {
                if ( !empty($row->options) ) {
                    $options = unserialize($row->options);
                    $row->options = $options;
                }

                $attributes[$row->amplifi_id] = $row;
            }

            return $attributes;
        }

		protected static function get_product_sku_from_collection_data( $collection ) {
			$sku_attrs = array_values( array_filter( $collection->attributes, function ( $n ) {
				return isset( $n->label ) && strtolower($n->label) === 'sku';
			} ) );
			$sku = ! empty( $sku_attrs ) && isset( $sku_attrs[0]->value ) ? $sku_attrs[0]->value : '';
			return $sku;
		}

        protected static function generate_log_file_path($folder_name, $file_name_prefix): array
        {
            $file_dir       = wp_upload_dir();
            $date_current   = date("Y-m-d");
            $path_folder    = $file_dir['basedir'] . '/' . $folder_name;
            $log_file       = $path_folder . $file_name_prefix . $date_current . '.log';

            return array(
                'log_file' => $log_file,
                'path_folder' => $path_folder
            );
        }

		protected static function get_next_sync_time($day_number, $hour) {
			$timezone = get_option( 'timezone_string' );
			$next_sync_time = new DateTime( 'now', new DateTimeZone( $timezone ) );
			$day_of_week = $next_sync_time->format( 'w' );
			$days_until_saturday = ( $day_number - $day_of_week ) % 7;
			if ( $days_until_saturday === 0 && $next_sync_time->format( 'H' ) >= $hour ) {
				$days_until_saturday = 7;
			}
			$next_sync_time->modify( "+$days_until_saturday days" );
			$next_sync_time->setTime($hour, 0);

			return $next_sync_time;
		}

		protected static function get_all_synced_products() {
			global $wpdb;
			$table_name = $wpdb->prefix . 'amplifi_auto_synced_products';

			$results = $wpdb->get_results(
				"SELECT * FROM $table_name",
				ARRAY_A
			);

			$synced_products = array();
            if ( $results ) {
			    foreach ($results as $row) {
				    $synced_products[$row['collection_id']] = $row['synced_date'];
			    }
            }

			return $synced_products;
		}

		/**
		 * Adds a collection to the table of synced products.
		 *
		 * @param object $collection The collection object to be added.
		 * @return void
		 */
		protected static function add_to_synced_products( $collection ) {
			if( !empty( $collection->id ) ){
				global $wpdb;

				$table_name = $wpdb->prefix . 'amplifi_auto_synced_products';
				$sync_date 	= property_exists( $collection, 'updated_date' ) ? $collection->updated_date : date( 'Y-m-d\TH:i:s.000\Z' );
                $sync_date = self::get_formatted_date($sync_date);

				$sql = $wpdb->prepare( "
					INSERT INTO $table_name (collection_id, synced_date)
					VALUES (%s, %s)
					ON DUPLICATE KEY UPDATE synced_date = %s
				", $collection->id, $sync_date, $sync_date );

				$wpdb->query( $sql );
			}
		}

		/**
		 * Deletes the product from the amplifi_auto_synced_products table
		 * if it has more recent update.
		 *
		 * @param string $collection_id The collection id to be deleted.
		 * @return void
		 */
		public static function delete_from_synced_products( $collection_id ) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'amplifi_auto_synced_products';

			$query = $wpdb->prepare(
				"DELETE FROM $table_name WHERE collection_id = %s",
				$collection_id
			);

			$wpdb->query($query);
		}

		protected static function get_formatted_date( $date ) {
			return ( new DateTime( $date, new DateTimeZone( 'UTC' ) ) )->format( DateTime::ATOM );
		}

		protected static function register_product_attribute($slug, $type = 'select', $order_by = 'name', $has_archives = false) {
			$attribute_id = wc_create_attribute(array(
				'name'         => $slug,
				'slug'         => $slug,
				'type'         => $type,
				'order_by'     => $order_by,
				'has_archives' => $has_archives,
			));

			if (is_wp_error($attribute_id)) {
				return;
			}

			register_taxonomy(
				wc_attribute_taxonomy_name($slug),
				apply_filters('woocommerce_taxonomy_objects_' . wc_attribute_taxonomy_name($slug), array('product')),
				apply_filters('woocommerce_taxonomy_args_' . wc_attribute_taxonomy_name($slug), array(
					'labels'       => array(
						'name' => $slug,
					),
					'hierarchical' => false,
					'show_ui'      => true,
					'query_var'    => true,
					'rewrite'      => false,
				))
			);

			flush_rewrite_rules();
		}

	}
}
