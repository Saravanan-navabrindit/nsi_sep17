<?php

use Crown\AdminPage;
use Crown\Api\GoogleMaps;
use Crown\Form\Field;
use Crown\Form\FieldGroup;
use Crown\Form\FieldGroupSet;
use Crown\Form\FieldRepeater;
use Crown\Form\FieldRepeaterFlex;
use Crown\Form\Input\CheckboxSet;
use Crown\Form\Input\Media as MediaInput;
use Crown\Form\Input\RadioSet;
use Crown\Form\Input\Select;
use Crown\Form\Input\Date as DateInput;
use Crown\Form\Input\Time as TimeInput;
use Crown\Form\Input\Text as TextInput;
use Crown\Form\Input\Checkbox as CheckboxInput;
use Crown\Form\Input\Color as ColorInput;
use Crown\Form\Input\RichTextarea;
use Crown\Form\Input\Textarea;
use Crown\Form\Input\Gallery as GalleryInput;
use Crown\ListTableColumn;
use Crown\Post\MetaBox;
use Crown\Post\Type as PostType;
use Crown\Post\Taxonomy;
use Crown\Shortcode;
use Crown\UIRule;


if ( ! class_exists( 'Crown_Sales_Reps' ) ) {
	class Crown_Sales_Reps {

		public static $init = false;

		public static $sales_rep_post_type = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			$plugin_file = preg_replace( '/\/classes$/', '', dirname( __FILE__ ) ) . '/plugin.php';
			register_activation_hook( $plugin_file, array( __CLASS__, 'activate' ));
			register_deactivation_hook( $plugin_file, array( __CLASS__, 'deactivate' ));

			add_action( 'after_setup_theme', array( __CLASS__, 'register_sales_rep_post_type' ) );

			add_filter( 'use_block_editor_for_post_type', array( __CLASS__, 'filter_use_block_editor_for_post_type' ), 10, 2 );

		}


		public static function activate() {
			global $wp_roles;
			
			foreach ( $wp_roles->role_objects as $role ) {
				foreach ( array( 'publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private' ) as $cap ) {
					if ( $role->has_cap( $cap . '_posts' ) ) {
						$role->add_cap( $cap . '_sales_reps' );
					}
				}
				// foreach ( array( 'manage', 'edit', 'delete' ) as $cap ) {
				// 	if ( $role->has_cap( 'manage_categories' ) ) {
				// 		$role->add_cap( $cap . '_resource_industries' );
				// 	}
				// }
				// if ( $role->has_cap( 'edit_posts' ) ) {
				// 	$role->add_cap( 'assign_resource_industries' );
				// }
			}

			flush_rewrite_rules();
		}


		public static function deactivate() {
			global $wp_roles;
			
			foreach ( $wp_roles->role_objects as $role ) {
				foreach ( array( 'publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private' ) as $cap ) {
					$role->remove_cap( $cap . '_sales_reps' );
				}
				// foreach ( array( 'manage', 'edit', 'delete', 'assign' ) as $cap ) {
				// 	$role->remove_cap ( $cap . '_resource_industries' );
				// }
			}
			
			flush_rewrite_rules();
		}


		public static function get_regions() {
			$config = json_decode( file_get_contents( dirname( __FILE__ ) . '/../config.json' ) );
			return $config->regions;
		}


		public static function register_sales_rep_post_type() {
            self::register_sales_rep_type_taxonomy();

			$country_abbr = array(
				'US' => 'USA',
				'CA' => 'Canada'
			);

			$region_options = array_map( function( $n ) use ( $country_abbr ) { return array( 'value' => $n->country . '/' . $n->abbreviation, 'label' => $country_abbr[ $n->country ] . ': ' . $n->name ); }, self::get_regions() );
			usort( $region_options, function( $a, $b ) { return strcmp( $a['label'], $b['label'] ); } );

			self::$sales_rep_post_type = new PostType( array(
				'name' => 'sales_rep',
				'singularLabel' => 'Sales Rep',
				'pluralLabel' => 'Sales Reps',
				'settings' => array(
					'supports' => array( 'title', 'revisions' ),
					'rewrite' => array( 'slug' => 'sales-reps', 'with_front' => false ),
					'menu_icon' => 'dashicons-businessperson',
					'has_archive' => false,
					'publicly_queryable' => false,
					'show_in_rest' => true,
					'show_in_nav_menus' => false,
					'capability_type' => array( 'sales_rep', 'sales_reps' ),
					'map_meta_cap' => true,
					'menu_position' => 38
				),
				'metaBoxes' => array(
					new MetaBox( array(
						'id' => 'sales-rep-regions',
						'title' => 'Regions',
						'priority' => 'high',
						'fields' => array(
							new Field( array(
								'description' => 'Select which regions of the map this sales rep should be associated with:',
								'input' => new Select( array( 'name' => 'sales_rep_regions', 'select2' => true, 'multiple' => true, 'options' => $region_options ) )
							) )
						)
					) ),
					new MetaBox( array(
						'id' => 'sales-rep-contact-info',
						'title' => 'Contact Info',
						'priority' => 'high',
						'fields' => array(
							new Field( array(
								'label' => 'Territory',
								'input' => new TextInput( array( 'name' => 'sales_rep_territory' ) )
							) ),
							new Field( array(
								'label' => 'Phone Number',
								'input' => new TextInput( array( 'name' => 'sales_rep_phone', 'class' => 'input-small' ) )
							) ),
							new FieldGroup( array(
								'class' => 'no-border two-column',
								'fields' => array(
									new Field( array(
										'label' => 'E-mail',
										'input' => new TextInput( array( 'name' => 'sales_rep_email' ) )
									) ),
                                ) )
                            ),
							new FieldGroup( array(
								'class' => 'no-border two-column',
								'fields' => array(
									new FieldGroup( array(
										'class' => 'no-border two-column large-left',
										'fields' => array(
											new Field( array(
												'label' => 'City',
												'input' => new TextInput( array( 'name' => 'sales_rep_city' ) )
											) ),
											new Field( array(
												'label' => 'State/Province',
												'input' => new TextInput( array( 'name' => 'sales_rep_state' ) )
											) )
										)
									) ),
									new FieldGroup( array(
										'class' => 'no-border two-column',
										'fields' => array(
											new Field( array(
												'label' => 'Country',
												'input' => new Select( array( 'name' => 'sales_rep_country', 'options' => array(
													array( 'value' => 'USA', 'label' => 'United States' ),
													array( 'value' => 'Canada', 'label' => 'Canada' )
												) ) )
											) ),
											new Field( array(
												'label' => 'Postal Code',
												'input' => new TextInput( array( 'name' => 'sales_rep_zip' ) )
											) )
										)
									) )
								)
							) )
						)
					) )
				),
				'listTableColumns' => array(
					new ListTableColumn( array(
						'key' => 'sales-rep-country',
						'title' => 'Country',
						'position' => 2,
						'outputCb' => function( $post_id, $args ) {
							$country = get_post_meta( $post_id, 'sales_rep_country', true );
							echo $country;
						}
					) ),
					new ListTableColumn( array(
						'key' => 'sales-rep-regions',
						'title' => 'Regions',
						'position' => 3,
						'outputCb' => function( $post_id, $args ) {
							$regions = get_post_meta( $post_id, 'sales_rep_regions', true );
							if ( empty( $regions ) || ! is_array( $regions ) ) return;
							$output = array_map( function( $n ) { return preg_replace( '/.+\//', '', $n ); }, $regions );
							echo implode( ', ', $output );
						}
					) )
				)
			) );

		}


		public static function filter_use_block_editor_for_post_type( $use_block_editor, $post_type ) {
			return in_array( $post_type, array( 'sales_rep' ) ) ? false : $use_block_editor;
		}


		public static function sales_rep_locator($type = '') {
			$queried_zip = isset( $_GET['zip'] ) ? trim( $_GET['zip'] ) : '';

			$queried_country = isset( $_GET['country'] ) ? trim( $_GET['country'] ) : '';
			if ( ! in_array( $queried_country, array( 'us', 'ca' ) ) ) $queried_country = 'us';

			$regions = self::get_regions();
            $args = array( 'fields' => 'ids' );
			if (!empty($type)) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'type',
						'field'    => 'slug',
						'terms'    => $type,
					),
				);
			}
			foreach ( $regions as $i => $region ) {
				$sales_rep_ids = self::get_region_sales_reps( $region->country, $region->abbreviation, $args );
				$region->sales_reps = array_map( function( $n ) {
					return (object) array(
						'name' => get_the_title( $n ),
						'territory' => get_post_meta( $n, 'sales_rep_territory', true ),
						'phone' => get_post_meta( $n, 'sales_rep_phone', true ),
						'email' => get_post_meta( $n, 'sales_rep_email', true ),
						'city' => get_post_meta( $n, 'sales_rep_city', true ),
						'state' => get_post_meta( $n, 'sales_rep_state', true ),
						'country' => get_post_meta( $n, 'sales_rep_country', true ),
						'zip' => get_post_meta( $n, 'sales_rep_zip', true )
					);
				}, $sales_rep_ids );
				$regions[ $i ] = $region;
			}
			
			$us_map_svg = file_get_contents( dirname( __FILE__ ) . '/../assets/img/US.svg' );
			$ca_map_svg = file_get_contents( dirname( __FILE__ ) . '/../assets/img/CA.svg' );

			$search_action = remove_query_arg( array( 'zip' ) );

			$queried_region = '';
			if ( ! empty( $queried_zip ) ) {
				$response = GoogleMaps::getGeocodeData( $queried_zip );
				if ( $response && $response->address_components ) {
					foreach ( $response->address_components as $ac ) {
						if ( in_array( 'administrative_area_level_1', $ac->types ) ) {
							$queried_region = $ac->short_name;
						}
					}
				}
			}

			?>
				<div class="sales-rep-locator">

					<div class="tabs">
						<button class="tab us <?php echo $queried_country == 'us' ? 'active' : ''; ?>" data-country="us">United States</button>
						<button class="tab ca <?php echo $queried_country == 'ca' ? 'active' : ''; ?>" data-country="ca">Canada</button>
					</div>

					<p class="instructions">Select a state or enter your ZIP Code below</p>

					<form class="location-search-form" method="get" action="<?php echo esc_attr( $search_action ); ?>">
						<div class="field">
							<input type="text" name="zip" value="<?php echo esc_attr( $queried_zip ); ?>" placeholder="<?php echo esc_attr( __( 'Enter Zipcode' ), 'crown_champions' ); ?>">
						</div>
						<footer class="form-footer">
							<input type="hidden" name="country" value="<?php echo esc_attr( $queried_country ); ?>">
							<button type="submit" class="btn btn-primary">Search</button>
						</footer>
					</form>

					<div class="map-container">
						<div class="inner">
							<div class="map us <?php echo $queried_country == 'us' ? 'active' : ''; ?>" data-country="us">
								<?php echo $us_map_svg; ?>
							</div>
							<div class="map ca <?php echo $queried_country == 'ca' ? 'active' : ''; ?>" data-country="ca">
								<?php echo $ca_map_svg; ?>
							</div>
						</div>
					</div>

					<div class="regions">
						<?php foreach ( $regions as $region ) { ?>
							<?php //if ( empty( $region->sales_reps ) ) continue; ?>
							<div id="sales-rep-region-<?php echo sanitize_title( $region->country . '-' . $region->abbreviation ); ?>-modal" class="modal fade sales-rep-region <?php echo ! empty( $region->sales_reps ) ? 'has-sales-reps' : ''; ?> <?php echo $queried_region == $region->abbreviation ? 'queried-region' : ''; ?>" tabindex="-1" data-country="<?php echo esc_attr( $region->country ); ?>" data-region="<?php echo esc_attr( $region->abbreviation ); ?>">
								<div class="modal-dialog modal-lg modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h3 class="modal-heading">Local Representation: <?php echo $region->name; ?></h3>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<?php foreach ( $region->sales_reps as $sales_rep ) { ?>
												<div class="sales-rep">
													<h5 class="territory"><?php echo $sales_rep->territory; ?></h5>
													<h4 class="name"><?php echo $sales_rep->name; ?></h4>
													<p class="phone"><a href="tel:<?php echo preg_replace( '/[^0-9]/', '', $sales_rep->phone ); ?>"><?php echo $sales_rep->phone; ?></a></p>
													<p class="email"><a href="mailto:<?php echo $sales_rep->email; ?>"><?php echo $sales_rep->email; ?></a></p>
												</div>
											<?php } ?>
											<?php if ( empty( $region->sales_reps ) ) { ?>
												<p>No sales reps found for this region.</p>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>

				</div>
			<?php
		}


		public static function get_region_sales_reps( $country, $abbreviation, $args = array() ) {
			$args = array_merge( array(
				'post_type' => 'sales_rep',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
				'meta_query' => array(
					array( 'key' => '__sales_rep_regions', 'value' => $country . '/' . $abbreviation )
				)
			), $args );
			return get_posts( $args );
		}

		public static function register_sales_rep_type_taxonomy() {
            $labels = array(
				'name'              => _x('Types', 'taxonomy general name', 'textdomain'),
				'singular_name'     => _x('Type', 'taxonomy singular name', 'textdomain'),
				'search_items'      => __('Search Types', 'textdomain'),
				'all_items'         => __('All Types', 'textdomain'),
				'parent_item'       => __('Parent Type', 'textdomain'),
				'parent_item_colon' => __('Parent Type:', 'textdomain'),
				'edit_item'         => __('Edit Type', 'textdomain'),
				'update_item'       => __('Update Type', 'textdomain'),
				'add_new_item'      => __('Add New Type', 'textdomain'),
				'new_item_name'     => __('New Type Name', 'textdomain'),
				'menu_name'         => __('Type', 'textdomain'),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'public'            => true,
				'show_in_rest'      => true,
				'rewrite'           => array('slug' => 'type'),
			);

			register_taxonomy('type', array('sales_rep'), $args);
		}

	}
}