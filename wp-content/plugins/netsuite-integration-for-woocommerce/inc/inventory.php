<?php

class NS_Inventory {

	private $logger;
    public $sku_based_update_inventory;
    public $bulk_ns_id_based_inventory_update;
    private $log_file_name;
    protected $inventory_sku_lot_limit;
    protected $empty_internal_ids = array();
    protected $excluded_brands_products = array();

	/**
	 * Construct function
	 */
	public function __construct() {
		global $TMWNI_OPTIONS;

        $this->inventory_sku_lot_limit = defined('NS_INVENTORY_SKU_LOT_LIMIT') ? NS_INVENTORY_SKU_LOT_LIMIT : TMWNI_Settings::$inventory_sku_lot_limit;
		if (TMWNI_Settings::areCredentialsDefined()) {
			if (( isset($TMWNI_OPTIONS['enableInventorySync']) && 'on' == $TMWNI_OPTIONS['enableInventorySync'] ) || ( isset($TMWNI_OPTIONS['enablePriceSync']) && 'on' == $TMWNI_OPTIONS['enablePriceSync'] )) {
				add_action('wp_ajax_fetch_inventory_progress', array($this,'fetchInventoryUpdateStatus'));
				require_once( 'background-process/class-manual-BasedUpdate-inventory.php' );
				require_once( 'background-process/class-bulk-NSidBasedInventory-update.php' );

				$this->sku_based_update_inventory = new Sku_Based_Update_Inventory();
				$this->bulk_ns_id_based_inventory_update = new Bulk_NS_id_Based_Inventory_Update();

				add_action( 'init', array( $this, 'register_inventory_cron'));
                add_action('tm_ns_process_inventories_price', array($this, 'updateWooInventory_Prices'));
                add_action('tm_ns_process_inventories_stock_quant', array($this, 'updateWooInventory_StockQuant'));
                add_action( 'tm_ns_sync_products_without_ns_id', array($this, 'updateWooInventoryBySku'), 10, 2 );
			}
		}
		add_filter('cron_schedules', array($this,'custom_cron_schedules'));
	}

    public function set_log_file_name( $name )
    {
        $file_dir = wp_upload_dir();
        $log_file = $file_dir['basedir'] . '/' . $name . '-' . TMWNI_Settings::$ns_inventory_log_file;
        $this->log_file_name = $log_file;
    }

    public function get_log_file_name() {
        if ( isset( $this->log_file_name ) ) {
            $log_file = $this->log_file_name;
        } else {
            $file_dir = wp_upload_dir();
            $log_file = $file_dir['basedir'] . '/' . TMWNI_Settings::$ns_inventory_log_file;
        }

        return $log_file;
    }

	public function fetchInventoryUpdateStatus() {
		if (isset($_POST['nonce']) && !empty($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field($_POST['nonce']), 'security_nonce') ) {
			die('Nonce Error'); 
		}
		if (!empty($_POST['action'])) {
			$processed_count = get_option('processed_products');
			$empty_skus = get_option('empty_skus');

			$updated_count = get_option('updated_products_count');
			$file_dir = wp_upload_dir();

			$log_file = $file_dir['basedir'] . '/' . TMWNI_Settings::$ns_inventory_log_file;
			
			$logs = file_get_contents($log_file);
			wp_send_json(array('success' => true, 'processed_count' => $processed_count, 'skus' => 'not found skus is NOT UPDATED - NSI-1382', 'updated_count' => $updated_count, 'logs' => $logs, 'empty_skus' => $empty_skus));
			die();
		}
	}

	/**
	 * Custom cron function
	 */
	public function custom_cron_schedules( $schedules) {
		if (!isset($schedules['10min'])) {
			$schedules['10min'] = array(
				'interval' => 600,
				'display' => __('Once every 10 minutes'));
		}
			
		return $schedules;
	}

	/**
	 * Register inventory cron
	 */
	public function register_inventory_cron() {
		global $TMWNI_OPTIONS;
		if ( get_option( 'ns_inventory_sync_disabled', false ) ) return;
		$inventorySyncFrequency = $TMWNI_OPTIONS['inventorySyncFrequency'];
		$timezone = get_option( 'timezone_string' );
        if ( !wp_next_scheduled( 'tm_ns_process_inventories_price' ) ) {
			$timestamp = new DateTime( 'now', new DateTimeZone( $timezone ) );
			$timestamp->modify( 'tomorrow 6am' );
			wp_schedule_event( intval( $timestamp->format('U') ), $inventorySyncFrequency, 'tm_ns_process_inventories_price' );
		}

        if ( !wp_next_scheduled( 'tm_ns_process_inventories_stock_quant' ) ) {
			$timestamp = new DateTime( 'now', new DateTimeZone( $timezone ) );
			$timestamp->modify( 'tomorrow 6am' );
			wp_schedule_event( intval( $timestamp->format('U') ), $inventorySyncFrequency, 'tm_ns_process_inventories_stock_quant' );
		}

        if ( !wp_next_scheduled( 'tm_ns_sync_products_without_ns_id', array( false, 'ns_ids' ) ) ) {
			$timestamp = new DateTime( 'now', new DateTimeZone( $timezone ) );
			$timestamp->modify( 'tomorrow 2am' );
			wp_schedule_event( intval( $timestamp->format('U') ), 'daily', 'tm_ns_sync_products_without_ns_id', array( false, 'ns_ids' ) );
		}
	}

	/**
	 * Assign NetSuite Internal id
	 */
	public function assignInternalID() {
		set_time_limit(0);
		wp_raise_memory_limit(-1);

		 // echo date("Y-m-d H:i:s");die;
		global $wpdb;
		$product_count = $wpdb->get_row("SELECT COUNT(*) as total_products FROM {$wpdb->posts} WHERE (post_type='product' OR post_type='product_variation') AND post_status='publish'");



		$total_count = $product_count->total_products;

		$total_loop_pages = ceil($total_count/$this->inventory_sku_lot_limit);

		require_once(TMWNI_DIR . 'inc/item.php');
		$netsuiteClient = new ItemClient();
			
		for ($i=0; $i<=$total_loop_pages; $i++) { 
			$sku_lot = $this->getProductSKULot($i);

			foreach ($sku_lot as $product_id => $woo_product_sku) {
			   
				$netsuiteClient->searchItemUpdateInternalID($woo_product_sku, $product_id);
				usleep(500000);
			}
			  
			sleep(2);
		}
	}

	/**
	 * Update Inventory
	 */
	public function updateWooInventory($type = 'all') {
		$updateInventoryDateTime = gmdate('Y-m-d H:i:s a');

        if ( $type == 'price' ) {
            $excluded_brands = get_option('ns_price_settings_excluded_brands', []);
		    update_option('ns_woo_inventory_update_prices', $updateInventoryDateTime);
        } else {
            $excluded_brands = get_option('ns_inventory_settings_excluded_brands', []);
		    update_option('ns_woo_inventory_update', $updateInventoryDateTime);
        }

		set_time_limit(0);
		wp_raise_memory_limit('-1');

		global $wpdb;
		$product_count = $wpdb->get_row("SELECT COUNT(*) as total_products FROM {$wpdb->posts} WHERE (post_type='product' OR post_type='product_variation') AND post_status='publish'");

		$product_count = apply_filters('tm_netsuite_get_woo_product', $product_count);

		$total_count = $product_count->total_products;

        $log_file = $this->get_log_file_name();
		file_put_contents($log_file, '');

		$sync_all_products = get_field('sync_all_products', 'option');
	
		if($sync_all_products){
            $file_dir = wp_upload_dir();
			$date_current 	= date("Y-m-d");
			$folder_name 	= 'manual-sync-ns-logs';
			$path_folder 	= $file_dir['basedir'] . '/' . $folder_name;
			$log_file_custom = $path_folder . '/sync-ns-all-products-'.$date_current.'.log';
			
			if ( !file_exists($path_folder)) {
				mkdir( $path_folder, 0755 );       
			} 

			if(!file_exists($log_file_custom)){
				fopen($log_file_custom, 'w');
				chmod($log_file_custom, 0777);
			} 
		}

		$total_loop_pages = ceil($total_count/$this->inventory_sku_lot_limit);
        update_option( 'ns_all_item_sync_total_pages', $total_loop_pages );
		require_once(TMWNI_DIR . 'inc/item.php');
		$netsuiteClient = new ItemClient();
        $netsuiteClient->set_log_file_name($type);
        $start_from_page = get_option( 'ns_all_products_sync_current_page_' . $type, 0 );
		for ($i=$start_from_page; $i<=$total_loop_pages; $i++) {
            //value in get_option is cached, getting value from database to prevent that
            $sync_status = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM wp_options WHERE option_name = %s", 'ns_synchronization_status_' . $type));
            if ( $sync_status === 'off' ) {
                return;
            }
            update_option( 'ns_all_products_sync_current_page_' . $type, $i );
			$sku_lot = $this->getProductSKULot($i, $excluded_brands);

			//$sku_lot  = apply_filters('tm_woo_products_skus',$i);
			$sku_lot = apply_filters('tm_woo_products_skus', $sku_lot);

			foreach ($sku_lot as $product_id => $woo_product_sku) {
				$netsuiteClient->searchItemBySkuUpdateInventory($woo_product_sku, $product_id, $type);

				if($sync_all_products){
					$output = file_get_contents( $log_file_custom );
					$output .= "\n" . date( 'Y-m-d H:i:s' ) . '; SKU - '  . $woo_product_sku . '; Product ID - ' . $product_id . '; manual sync all products';
				
					file_put_contents( $log_file_custom, $output );
				}
				usleep(100000);
			}
			sleep(2);
		}
        update_option( 'ns_all_products_sync_current_page_' . $type, 0 );
	}

    public function updateWooInventoryBulkRequest($type = 'all') {
        global $wpdb;
        $sync_status = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM wp_options WHERE option_name = %s", 'ns_synchronization_status_' . $type));
        if ( $sync_status === 'off' ) {
            return;
        }
        $updateInventoryDateTime = gmdate('Y-m-d H:i:s a');

        if ( $type == 'price' ) {
            $excluded_brands = get_option('ns_price_settings_excluded_brands', []);
            update_option('ns_woo_inventory_update_prices', $updateInventoryDateTime);
        } else {
            $excluded_brands = get_option('ns_inventory_settings_excluded_brands', []);
            update_option('ns_woo_inventory_update', $updateInventoryDateTime);
        }

        set_time_limit(0);
        wp_raise_memory_limit('-1');
        $product_count = $wpdb->get_row("SELECT COUNT(*) as total_products FROM {$wpdb->posts} WHERE (post_type='product' OR post_type='product_variation') AND post_status='publish'");
        $product_count = apply_filters('tm_netsuite_get_woo_product', $product_count);
        $total_count = $product_count->total_products;

        $log_file = $this->get_log_file_name();
        $this->add_log_message($log_file, '<p>[' . gmdate('Y-m-d H:i:s a') . '] ' . $type . ' sync started.</p>');
        $this->add_log_message($log_file, '<p>Excluded brands: ' . implode(', ', $excluded_brands) . '</p>');

        if ( $type == 'inventory' || $type == 'all' ) {
            global $TMWNI_OPTIONS;
            if ( isset($TMWNI_OPTIONS['inventoryDefaultLocation']) ) {
                $inventoryLocation = $TMWNI_OPTIONS['inventoryDefaultLocation'];
                if ( $inventoryLocation == 1 ) {
                    $this->add_log_message($log_file, '<p>Locations setting: All Locations</p>');
                } else if ( $inventoryLocation == 2 ) {
                    $this->add_log_message($log_file, '<p>Locations setting: Default Locations</p>');
                } else if ( $inventoryLocation == 3 ) {
                    $this->add_log_message($log_file, '<p>Locations setting: Selected locations (' . implode(', ', $TMWNI_OPTIONS['netstuite_locations']) . ')</p>');
                } else {
                    if ( is_array($inventoryLocation) || is_object($inventoryLocation) ) {
                        $this->add_log_message($log_file, '<p>Locations setting: ' . print_r($inventoryLocation, true) . '</p>');
                    } else {
                        $this->add_log_message($log_file, '<p>Locations setting: Default Locations</p>');
                    }
                }
            }
        }

        $all_products_to_sync = $this->getAllProductsToSync();
        $this->add_log_message($log_file, '<p>Found products amount: ' . count($all_products_to_sync) .  '</p>');
        $limit = TMWNI_Settings::$inventory_sku_lot_limit;
        $all_products_to_sync = array_chunk($all_products_to_sync, $limit, true);
        $total_loop_pages = count($all_products_to_sync);
        $count_batch_items = 0;
        $bulk_inventory_update = new Bulk_NS_id_Based_Inventory_Update();
        $count_products = 0;
        for ( $i=0; $i<=$total_loop_pages; $i++ ) {
            if ($count_batch_items == 100) {
                $bulk_inventory_update = new Bulk_NS_id_Based_Inventory_Update();
                $count_batch_items = 0;
            }

            $products_to_sync = $all_products_to_sync[$i] ?? array();

            if ( !empty($excluded_brands) ) {
                foreach ($products_to_sync as $internal_id => $product) {
                    $product_id = $product['wp_product_id'];
                    $product_brands = wp_get_post_terms(
                        $product_id,
                        'product_brand',
                        ['fields' => 'slugs']
                    );

                    if ( array_intersect($excluded_brands, $product_brands) ) {
                        $this->excluded_brands_products[] = $product_id;
                        unset($products_to_sync[$internal_id]);
                    }
                }
            }

            $count_products += count($products_to_sync);
            if ( !empty($products_to_sync) ) {
                $bulk_inventory_update->push_to_queue(array('type' => $type, 'products_to_sync' => $products_to_sync));
                $count_batch_items++;
            }
            if ($count_batch_items == 100) {
                $bulk_inventory_update->save()->dispatch();
            }
        }
        if ($count_batch_items < 100) {
            $bulk_inventory_update->save()->dispatch();
            $this->add_log_message($log_file, '<p>[' . gmdate('Y-m-d H:i:s a') . '] ' . $count_products .' out of ' . $total_count . ' products pushed to ' . $type . ' sync queue. ' . count($this->excluded_brands_products) . ' products from excluded brands and ' . count($this->empty_internal_ids) . ' products without NS internal ID skipped.</p>');
            if ( !empty( $this->empty_internal_ids ) ) {
                update_option('empty_internal_ids', array_unique($this->empty_internal_ids));
            }
        }
    }

    public function updateWooInventory_Prices() {
        if ( $this->bulk_ns_id_based_inventory_update->has_pending_items('price') ) {
            return;
        }
        $this->set_log_file_name('push-to-queue');
        $this->updateWooInventoryBulkRequest('price');
    }

    public function updateWooInventory_StockQuant() {
        if ( $this->bulk_ns_id_based_inventory_update->has_pending_items('inventory') ) {
            return;
        }
        $this->set_log_file_name('push-to-queue');
        $this->updateWooInventoryBulkRequest('inventory');
    }

	/**
	 * Update Inventory By SKU
	 */
	public function updateWooInventoryBySku($is_manual_sync = true, $type = 'all') {
		set_time_limit(0);
		wp_raise_memory_limit('-1');
		global $wpdb;
        $excluded_brands = [];
        if (!$is_manual_sync && $type == 'ns_ids') {
            $product_count = $wpdb->get_row("SELECT count(pm2.meta_value) as total_products FROM wp_posts p
                                                    LEFT JOIN wp_postmeta pm1 ON p.ID = pm1.post_id AND pm1.meta_key = 'ns_product_internal_id'
                                                    LEFT JOIN wp_postmeta pm2 ON p.ID = pm2.post_id AND pm2.meta_key = 'product_sku'
                                                    WHERE (p.post_type='product' OR p.post_type='product_variation') AND p.post_status = 'publish'
                                                    AND (pm1.meta_value = '' OR pm1.meta_value IS NULL)");
        } else {
            return;
        }

		$total_count = $product_count->total_products;

		add_option('total_product_count', $total_count);
		update_option('processed_products', 0);
		update_option('updated_products_count', 0);
		update_option('empty_skus', array());
		$file_dir = wp_upload_dir();
		$log_file = $file_dir['basedir'] . '/' . TMWNI_Settings::$ns_inventory_log_file;

		file_put_contents($log_file, '');

		$total_loop_pages = ceil($total_count/$this->inventory_sku_lot_limit);
		
		require_once(TMWNI_DIR . 'inc/item.php');
		for ($i=0; $i<=$total_loop_pages; $i++) {
            if (!$is_manual_sync && $type == 'ns_ids') {
                $sku_lot = $this->getProductSKULot($i, $excluded_brands, true);
            } else {
                $sku_lot = $this->getProductSKULot($i, $excluded_brands, false);
            }

            if ( !empty($sku_lot) ) {
                $this->sku_based_update_inventory->push_to_queue(array('products_to_sync' => $sku_lot));
            }
		}

        //dispatch function schedules cron: tm_ns_manual_process_inventories (wp_tm_ns_manual_process_inventories_cron)
        $log_content = '<p><b>Sync of SKUs without NS ID: ' . $total_count . ' products added to the queue</b></p>';
        file_put_contents($log_file, $log_content . PHP_EOL, FILE_APPEND);
		$this->sku_based_update_inventory->save()->dispatch();
		wp_send_json(array('success' => true, 'total_count' => $total_count));
		die();
	}


	/**
	 * Get Product Sku
	 */
	private function getProductSKULot($page = 0, $excluded_brands = [], $missing_ns_ids_only = false) {
		global $wpdb;

		$limit = $this->inventory_sku_lot_limit;

		if (0 == $page) {
			$offset = 0;
		} else {
			$offset = $limit * $page;
		}

        if ( $missing_ns_ids_only ) {
            $products = $wpdb->get_results($wpdb->prepare(
                "SELECT p.ID, pm2.meta_value as _sku 
                FROM {$wpdb->posts} as p
                LEFT JOIN wp_postmeta pm1 ON p.ID = pm1.post_id AND pm1.meta_key = 'ns_product_internal_id'
                LEFT JOIN wp_postmeta pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_sku'
                WHERE (p.post_type='product' OR p.post_type='product_variation') AND p.post_status = 'publish'
                AND (pm1.meta_value = '' OR pm1.meta_value IS NULL) LIMIT %d,%d",
                $offset, $limit));
        } else {
            $products = $wpdb->get_results($wpdb->prepare(
                "SELECT posts.ID, meta.meta_value as _sku 
    FROM {$wpdb->posts} as posts
    LEFT JOIN wp_postmeta as meta on posts.ID = meta.post_id
    WHERE (posts.post_type='product' OR posts.post_type='product_variation')
    AND posts.post_status='publish' AND meta.meta_key = '_sku' LIMIT %d,%d",
                $offset, $limit));
        }

		$products = apply_filters('tm_netsuite_get_all_woo_product', $products, $offset, $limit);

		$sku_lot = array();
        $excluded_product_ids = array();
        if ( ! empty( $excluded_brands ) ) {
            $excluded_product_ids = $this->get_product_ids_by_excluded_brands( $excluded_brands );
        }

        foreach ($products as $product) {
            $product_id = $product->ID;
            if (!empty($excluded_product_ids) && in_array($product_id, $excluded_product_ids)) {
                continue;
            }
			$sku_lot[$product_id] = $product->_sku;
		}

		return $sku_lot;
	}

    private function getAllProductsToSync() {
        global $wpdb;

        $products = $wpdb->get_results($wpdb->prepare(
            "SELECT posts.ID, meta.meta_value as _sku, meta2.meta_value as internal_id 
FROM {$wpdb->posts} as posts
LEFT JOIN wp_postmeta as meta on posts.ID = meta.post_id AND meta.meta_key = '_sku'
LEFT JOIN wp_postmeta as meta2 on posts.ID = meta2.post_id AND meta2.meta_key =  'ns_product_internal_id'
WHERE (posts.post_type='product' OR posts.post_type='product_variation')
AND posts.post_status='publish'"));

        $internal_ids = [];
        foreach ( $products as $product ) {
            if (empty($product->internal_id)) {
                $this->empty_internal_ids[] = $product->ID;
            } else {
                $internal_ids[$product->internal_id] = [
                    'wp_product_id' => $product->ID,
                    'internal_id' => $product->internal_id,
                    'sku' => $product->_sku,
                ];
            }
        }
        return $internal_ids;
    }

    public function add_log_message($log_file, $message) {
        $log_contents = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $log_contents[] = $message;

        if (count($log_contents) > 250) {
            $log_contents = array_slice($log_contents, -250);
        }
        file_put_contents($log_file, implode(PHP_EOL, $log_contents) . PHP_EOL);
    }

    public function get_product_ids_by_excluded_brands($excluded_brands) {
        global $wpdb;
        $excluded_product_ids = array();

        $excluded_brand_ids = get_terms([
            'taxonomy' => 'product_brand',
            'slug' => $excluded_brands,
            'fields' => 'ids',
        ]);

        if (!empty($excluded_brand_ids) && !is_wp_error($excluded_brand_ids)) {
            $placeholders = implode(',', array_fill(0, count($excluded_brand_ids), '%d'));

            $excluded_product_ids = $wpdb->get_col($wpdb->prepare(
                "SELECT tr.object_id
                    FROM {$wpdb->term_relationships} tr
                    JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                    WHERE tt.taxonomy = 'product_brand'
                    AND tt.term_id IN ($placeholders)",
                ...$excluded_brand_ids
            ));
        }
        return $excluded_product_ids;
    }

}

	new NS_Inventory();
