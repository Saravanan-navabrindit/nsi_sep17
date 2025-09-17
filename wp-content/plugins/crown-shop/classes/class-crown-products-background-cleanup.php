<?php

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'woocommerce' ) ) return;
if ( ! class_exists( 'WP_Async_Request', false ) ) {
	include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-async-request.php';
}

if ( ! class_exists( 'WP_Background_Process', false ) ) {
	include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-background-process.php';
}
require_once plugin_dir_path( __FILE__ ) . '../inc/common.php';

class Crown_Products_Background_Cleanup extends WP_Background_Process {

	
	protected $action = 'crown_products_cleanup';

	
	protected function task( $item ) {
		$log_file = $this->prepare_log_file();
		$output = file_get_contents( $log_file );

		if ( ! is_array( $item ) && ! isset( $item['product_id'] ) ) {
			$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Product ID is empty.' . "\n";
			file_put_contents( $log_file, $output );
			return false;
		}
		$product_id = $item['product_id'];
		$force = $item['force'] ?? FALSE;
		$collection_id = get_post_meta( $product_id, 'product_collection_id', true );
		if ( !$collection_id ) {
			$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Product ID: ' . $product_id . ' does not have collection ID.' . "\n";
			file_put_contents( $log_file, $output );
			$this->process_product($product_id, $force);
			return false;
		}

		$collection = Crown_Amplifi_Api::get_collection( $collection_id );
		if ( is_object( $collection )  && property_exists( $collection, 'id' ) ) {
			$nsi_default_region_id 	= get_amplify_region_id();

			$is_nsi_default = property_exists( $collection, 'region_ids' ) && is_array( $collection->region_ids ) && in_array( $nsi_default_region_id, $collection->region_ids );
			if ( !$is_nsi_default ) {
				$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Collection ' . $collection_id . ' is not in region '. $nsi_default_region_id .'. Product ID: ' . $product_id . "\n";
				file_put_contents( $log_file, $output );
				$this->process_product($product_id, $force);
			} elseif (get_post_status($product_id) === 'draft') {
				wp_update_post( array(
					'ID'            => $product_id,
					'post_status'   => 'publish',
				) );
				if ( defined( 'TMWNI_DIR' ) ) {
					require_once(TMWNI_DIR . 'inc/item.php');
					$netsuiteClient = new ItemClient();
					$netsuiteClient->searchItemBySkuUpdateInventory( get_post_meta( $product_id, '_sku', true ), $product_id, 'all' );
				}
				$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Product ID published and synced with Netsuite: ' . $product_id . "\n";
				file_put_contents( $log_file, $output );
			}
		} else {
			if ( is_object( $collection ) && property_exists( $collection, 'message' ) ) {
				$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Collection ' . $collection_id . ' load failed. Message: "' . $collection->message . '". Product ID: ' . $product_id . "\n";
				file_put_contents( $log_file, $output );
				if ( $collection->message === 'Not Found' ){
					$this->process_product($product_id, $force);
				}
				return false;
			}

			if ( isset( $item['retry'] ) && $item['retry'] === false ) {
				$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Collection ' . $collection_id . ' check failed. Need to retry. Product ID: ' . $product_id . "\n";
				file_put_contents( $log_file, $output );
				return array( 'product_id' => $product_id, 'retry' => true );
			} else {
				$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Collection ' . $collection_id . ' check failed. Product ID: ' . $product_id . "\n";
				file_put_contents( $log_file, $output );
			}
		}

		return false;
	}

	protected function process_product($product_id, $force = FALSE) {
		global $wpdb;
		$enable_disabling_products 	= get_field('enable_disabling_products_auto_sync', 'option') ?? TRUE;
		$log_file = $this->prepare_log_file();
		$output = file_get_contents( $log_file );

		if (!$enable_disabling_products) {
			$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Products are not allowed to be deleted.' . "\n";
			file_put_contents( $log_file, $output );
			return;
		}

		// Check if product is in an order, submittal, or quote
		$in_order = $wpdb->get_var("SELECT COUNT(*) FROM wp_wc_order_product_lookup WHERE product_id = {$product_id}" );
		if ( $in_order ) {
			disable_product($product_id);
			$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Product ID: ' . $product_id . ' is in order. Disabled for purchase and search.' . "\n";
			file_put_contents( $log_file, $output );
			return;
		}
		$in_submittal = $wpdb->get_var(" SELECT COUNT(*) FROM wp_submittal_products WHERE product_id = {$product_id}" );
		if ( $in_submittal ) {
			disable_product($product_id);
			$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Product ID: ' . $product_id . ' is in submittal. Disabled for purchase and search.' . "\n";
			file_put_contents( $log_file, $output );
			return;
		}
		$in_quote = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_key = 'quote_contents' AND meta_value LIKE '%product_id\";i:{$product_id}%'" );
		if ( $in_quote ) {
			disable_product($product_id);
			$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Product ID: ' . $product_id . ' is in quote. Disabled for purchase and search.' . "\n";
			file_put_contents( $log_file, $output );
			return;
		}

		if ($force) {
			wp_delete_post( $product_id, true );
			$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Product ID: ' . $product_id . ' DELETED.' . "\n";
		} else {
			disable_product($product_id);
			$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Product ID: ' . $product_id . ' disabled for purchase and search.' . "\n";
		}
		file_put_contents( $log_file, $output );
	}

	protected function prepare_log_file() {
		$file_dir 		= wp_upload_dir();
		$date_current 	= date("Y-m-d");
		$folder_name 	= 'amplify-logs/amplify-product-cleanup';
		$path_folder 	= $file_dir['basedir'] . '/' . $folder_name;
		$file_name 		= $path_folder . '/products_cleanup-' . $date_current . '.log';

		if ( !file_exists($path_folder)) {
			mkdir( $path_folder, 0755, true );
		}

		if(!file_exists($file_name)){
			$log_file = fopen($file_name, 'w');
			chmod($file_name, 0664);
			fclose($log_file);
		}

		return $file_name;
	}

	protected function complete() {
		parent::complete();
		$log_file = $this->prepare_log_file();
		$output = file_get_contents( $log_file );
		$output .= '[' . date( 'Y-m-d H:i:s' ) . '] Finished processing.' . "\n";
		file_put_contents( $log_file, $output );
	}

}
