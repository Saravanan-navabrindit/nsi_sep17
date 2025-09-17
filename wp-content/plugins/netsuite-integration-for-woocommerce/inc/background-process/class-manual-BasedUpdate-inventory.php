<?php

// require_once TMWNI_DIR . 'inc/wp-background-processing/classes/wp-background-process.php';

class Sku_Based_Update_Inventory extends WP_Background_Process {

	
	protected $action = 'tm_ns_manual_process_inventories';

	
	protected function task( $data ) {
		// Actions to perform
		require_once(TMWNI_DIR . 'inc/item.php');
		$netsuiteClient = new ItemClient();
        $logfile = $netsuiteClient->get_log_file_name();
        $log_content = '<p><b>New batch of sync SKUs without NS Internal ID started</b></p>';
        file_put_contents($logfile, $log_content . PHP_EOL, FILE_APPEND);
        if ( isset($data['products_to_sync']) ) {
            foreach( $data['products_to_sync'] as $product_id => $product_sku ) {
                $netsuiteClient->searchItemBySkuUpdateInventory($product_sku, $product_id, 'all');
            }
            $increment = count( $data['products_to_sync'] );
        } else {
            $netsuiteClient->searchItemBySkuUpdateInventory($data['product_sku'], $data['product_id'], 'all');
            $increment = 1;
        }
		$old_count = get_option('processed_products');
		error_log(print_r($old_count), true);
		$new_count = $old_count + $increment;
		error_log(print_r($new_count), true);
        $log_content = '<p><b>Batch ended, total products processed so far: ' . $new_count . '</b></p>';
        file_put_contents($logfile, $log_content . PHP_EOL, FILE_APPEND);
		update_option('processed_products', $new_count);
		return false;
	}

	
	protected function complete() {
		parent::complete();

		// Show notice to user or perform some other arbitrary task...
	}

}
