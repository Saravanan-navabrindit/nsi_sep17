<?php

defined( 'ABSPATH' ) || exit;

class Bulk_NS_id_Based_Inventory_Update extends WP_Background_Process {

	
	protected $action = 'tm_ns_bulk_process_inventories';

    protected $type = 'all';

    protected ItemClient $netsuiteClient;

    public function __construct() {
        parent::__construct();
        require_once(TMWNI_DIR . 'inc/item.php');
        $this->netsuiteClient = new ItemClient();
    }

	protected function task( $item ) {
        require_once(TMWNI_DIR . 'inc/item.php');
        global $wpdb;
        $products_to_sync = $item['products_to_sync'];
        $this->type = $item['type'];

        $sync_status = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM wp_options WHERE option_name = %s", 'ns_synchronization_status_' . $this->type));
        if ( $sync_status === 'off' ) {
            $is_clear_queue = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM wp_options WHERE option_name = %s", 'ns_clear_sync_queue_' . $this->type));
            if ( $is_clear_queue === 'yes' ) {
                $this->clear_queue( $this->type );
                update_option('ns_woo_inventory_update_in_process', false);
                $this->unlock_process();
                die();
            }
            return $item;
        }

        if (get_option('ns_woo_inventory_update_in_process') != $this->type) {
            update_option('ns_woo_inventory_update_in_process', $this->type);
        }
        $this->netsuiteClient->set_log_file_name($this->type);
        $this->netsuiteClient->searchItemsByInternalIdsUpdateInventory($products_to_sync, $this->type);
        return false;
	}

    public function has_pending_items( $type ) {
        global $wpdb;

        $table  = $wpdb->options;
        $column = 'option_name';
        $value_column = 'option_value';
        $type = '%' . $type . '%';

        if ( is_multisite() ) {
            $table  = $wpdb->sitemeta;
            $column = 'meta_key';
            $value_column = 'meta_value';
        }

        $key = $this->identifier . '_batch_%';

        $count = $wpdb->get_var( $wpdb->prepare( "
			SELECT COUNT(*)
			FROM {$table}
			WHERE {$column} LIKE %s
			AND {$value_column} LIKE %s
		", $key, $type ) );

        return ( $count > 0 );
    }

    public function clear_queue( $type ) {
        global $wpdb;

        if ( empty($type) ) {
            return false;
        }

        $table  = $wpdb->options;
        $column = 'option_name';
        $value_column = 'option_value';
        $type = '%' . $type . '%';

        if ( is_multisite() ) {
            $table  = $wpdb->sitemeta;
            $column = 'meta_key';
            $value_column = 'meta_value';
        }

        $key = $this->identifier . '_batch_%';

        $queue_entries = $wpdb->get_results( $wpdb->prepare( "
			SELECT *
			FROM {$table}
			WHERE {$column} LIKE %s
			AND {$value_column} LIKE %s
		", $key, $type ) );

        foreach ( $queue_entries ?? [] as $queue ) {
            delete_site_option( $queue->option_name );
        }

        return true;
    }

    protected function complete() {
        update_option('ns_woo_inventory_update_in_process', false);
        $this->add_log_summary();
        parent::complete();
    }

    protected function unlock_process() {
        delete_site_transient( $this->identifier . '_process_lock' );
        $this->add_log_summary();

        return $this;
    }

    private function add_log_summary() {
        $processed_skus_info = $this->netsuiteClient->getProcessedSkusInfo();
        $log_content = '<p><b>The batch of ' . $this->type . ' sync has been completed</b></p>' . PHP_EOL;
        $log_content .= '<p><b>Total number of processed SKUs:</b> ' . $processed_skus_info['total'] . '</p>' . PHP_EOL;
        $log_content .= '<p><b>Total number of updated products:</b> ' . $processed_skus_info['success'] . '</p>' . PHP_EOL;
        $log_content .= '<p><b>Total number of skipped products (error):</b> ' . $processed_skus_info['error'] . '</p>' . PHP_EOL;
        file_put_contents($this->netsuiteClient->get_log_file_name(), $log_content, FILE_APPEND);
    }

}
