<?php

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'woocommerce' ) ) return;
if ( ! class_exists( 'WP_Async_Request', false ) ) {
    include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-async-request.php';
}

if ( ! class_exists( 'WP_Background_Process', false ) ) {
    include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-background-process.php';
}

class NS_invoices_import extends WP_Background_Process {

    protected $action = 'tm_ns_invoices_fetch';

    public string $tm_ns_invoices_data_table_name;

    public function __construct() {
        parent::__construct();
        global $wpdb;
        $this->tm_ns_invoices_data_table_name = $wpdb->prefix . 'tm_ns_invoices_data';

        if( !get_option( 'tm_ns_invoices_data_table_created' ) ) {
            $this->create_tm_ns_invoices_data_table();
            update_option( 'tm_ns_invoices_data_table_created', true );
        }
    }

    protected function task( $item ) {
        $fetched_invoice_data = $this->get_tm_ns_invoice_data( $item );
        if ( empty($fetched_invoice_data) ) {
            return false;
        }

        $file_name = $this->prepare_log_file();
        $log_file_content = '[' . date('Y-m-d H:i:s') . '] Start import of NS Invoice ID ' . $item . PHP_EOL;
        try {
            $this->import_invoice_data_fetched( $item, $fetched_invoice_data, $file_name, $log_file_content );
        } catch ( \Throwable $e ) {
            $log_file_content .= 'Invoice NS ID ' . $item . ' not synced due to internal error. Error Message: ' . $e->getMessage();
            file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
            $this->remove_tm_ns_invoice_item_data( $item );
            return false;
        }
        return false;
    }

    protected function import_invoice_data_fetched( $item, $fetched_invoice_data, $file_name, &$log_file_content ) {
        $first_row = true;
        foreach ($fetched_invoice_data as $fetched_invoice_item) {
            $sku = '';
            $fetched_invoice_item_array = unserialize($fetched_invoice_item->ns_invoice_data);
            $invoice_tran_id = $fetched_invoice_item_array['basic']['tranId'][0]->searchValue ?? '';

            if ( ! isset($invoice_tran_id) || empty($invoice_tran_id) ) {
                $error_msg = 'Invoice Transition ID missing.';
                $this->handle_error( $item, $error_msg, $file_name, $log_file_content );
                return false;
            }

            if ( $first_row ) {
                $ns_invoice_data = $this->get_ns_invoice_data($invoice_tran_id, $fetched_invoice_item_array);
                if ( empty($ns_invoice_data) ) {
                    $error_msg = 'Order ID not found.';
                    $this->handle_error( $item, $error_msg, $file_name, $log_file_content );
                    return false;
                }
                $first_row = false;
            }
            if ( ! isset( $fetched_invoice_item_array['item_join'] ) ) {
                if ( ! empty( $fetched_invoice_item_array['basic']['amountPaid'][0]->searchValue ) ) {
                    $ns_invoice_data['invoice_info']['amount_paid'] = $fetched_invoice_item_array['basic']['amountPaid'][0]->searchValue;
                }
                if ( ! empty( $fetched_invoice_item_array['basic']['amountRemaining'][0]->searchValue ) ) {
                    $ns_invoice_data['invoice_info']['amount_remaining'] = $fetched_invoice_item_array['basic']['amountRemaining'][0]->searchValue;
                }
                $ns_invoice_data['invoice_info']['custbody_amtdue'] = $this->get_custom_field_value($fetched_data['basic'], 'custbody_amtdue') ?? 0;
            }
            if ( ! empty($fetched_invoice_item_array['item_join']['itemId'][0]->searchValue) ) $sku = $fetched_invoice_item_array['item_join']['itemId'][0]->searchValue;
            if ( isset( $fetched_invoice_item_array['item_join'] ) && empty($sku) ) {
                $error_msg = 'SKU is empty.';
                $this->handle_error( $item, $error_msg, $file_name, $log_file_content );
                return false;
            } elseif ( ! empty( $sku ) ) {
                $ns_invoice_items_data[$sku] = $this->get_ns_invoice_items_data($sku, $fetched_invoice_item_array);
            }
        }
        if ( ! empty ( $ns_invoice_items_data ) ) {
            $ns_invoice_data['items_info'] = maybe_serialize( $ns_invoice_items_data );
        }
        $ns_invoice_data['invoice_info'] = maybe_serialize( $ns_invoice_data['invoice_info'] );
        $this->update_order_invoice_ids($ns_invoice_data);
        $invoice_data[$invoice_tran_id] = array_values($ns_invoice_data);
        $placeholders[$invoice_tran_id][] = "(%s, %d, %d, %d, %s, %s, %s)";

        if ( ! empty($invoice_data) ) {
            $invoice_data = array_merge(...array_values($invoice_data));
            $placeholders = array_merge( ...array_values($placeholders) );
            $this->save_invoice_data($invoice_data, $placeholders);
            Crown_Order_Types::update_ns_order_custbody_values( $item, $ns_invoice_data['order_id'], FALSE, '', 'invoice' );
            $this->remove_tm_ns_invoice_item_data( $item );
            $log_file_content .= '[' . date('Y-m-d H:i:s') . '] Invoice ' . $item . ' successfully imported.' . PHP_EOL;
        }
        file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
    }

    protected function get_ns_invoice_data($invoice_tran_id, $fetched_data) {
        $current_date = new DateTime();
        $current_date = $current_date->format("Y-m-d H:i:s");
        $invoice_data = array(
            'tran_id' => $invoice_tran_id,
            'order_id' => 0,
            'ns_order_internal_id' => 0,
            'ns_invoice_internal_id' => 0,
            'invoice_last_modified_date' => $current_date,
            'invoice_info' => array(),
            'items_info' => array(),
        );
        if ( !empty($fetched_data['basic']['createdFrom'][0]->searchValue->internalId) ) {
            $ns_order_internal_id = $fetched_data['basic']['createdFrom'][0]->searchValue->internalId;
            $invoice_data['order_id'] = $this->get_order_id_by_ns_order_internal_id($ns_order_internal_id);
            $invoice_data['ns_order_internal_id'] = $ns_order_internal_id;
        }
        if ( empty($invoice_data['order_id']) ) {
            return array();
        }
        if ( !empty($fetched_data['basic']['internalId'][0]->searchValue->internalId) ) $invoice_data['ns_invoice_internal_id'] = $fetched_data['basic']['internalId'][0]->searchValue->internalId;
        if ( !empty($fetched_data['basic']['lastModifiedDate'][0]->searchValue) ) $invoice_data['invoice_last_modified_date'] = $fetched_data['basic']['lastModifiedDate'][0]->searchValue;
        $currency_id = !empty($fetched_data['basic']['currency'][0]->searchValue->internalId) ? $fetched_data['basic']['currency'][0]->searchValue->internalId : 1;
        $invoice_info['billing_address'] = !empty($fetched_data['basic']['billAddress'][0]->searchValue) ? $fetched_data['basic']['billAddress'][0]->searchValue : '';
        $invoice_info['shipping_address'] = !empty($fetched_data['basic']['shipAddress'][0]->searchValue) ? $fetched_data['basic']['shipAddress'][0]->searchValue : '';
        $invoice_info['invoice_date'] = !empty($fetched_data['basic']['tranDate'][0]->searchValue) ? $fetched_data['basic']['tranDate'][0]->searchValue : $current_date;
        $invoice_info['due_date'] = !empty($fetched_data['basic']['dueDate'][0]->searchValue) ? $fetched_data['basic']['dueDate'][0]->searchValue : $current_date;
        $invoice_info['discount_date'] = $this->get_invoice_discount_date ( $fetched_data['basic'], $invoice_info['due_date'], $invoice_info['invoice_date'] );
        $invoice_info['discount_label'] = !empty($fetched_data['basic']['transactionDiscount'][0]->customLabel) ? $fetched_data['basic']['transactionDiscount'][0]->customLabel : '';
        $invoice_info['gross_total'] = !empty($fetched_data['basic']['total'][0]->searchValue) ? $fetched_data['basic']['total'][0]->searchValue : 0;
        $invoice_info['shipping_cost'] = !empty($fetched_data['basic']['shippingAmount'][0]->searchValue) ? $fetched_data['basic']['shippingAmount'][0]->searchValue : 0;
        $invoice_info['currency_name'] = $this->get_currency_label_by_id( $currency_id ) ?? 'US Dollar';
        $invoice_info['discount_total'] = $this->get_invoice_discount_total ( $fetched_data['basic'] );
        $invoice_info['amount_paid'] = 0;
        $invoice_info['amount_remaining'] = 0;
        $invoice_info['custbody_amtdue'] = 0;
        $invoice_data['invoice_info'] = $invoice_info;
        return $invoice_data;
    }

    protected function get_ns_invoice_items_data($sku, $fetched_data) {
        $item_data = array(
            'sku' => $sku,
            'description' => '',
            'qty_shipped' => 0,
            'qty_ordered' => 0,
            'rate' => 1,
            'nsi_multiplier' => 1,
            'item_amount' => 0,
        );
        if ( !empty( $fetched_data['item_join']['salesDescription'][0]->searchValue ) ) $item_data['description'] = $fetched_data['item_join']['salesDescription'][0]->searchValue;
        if ( !empty( $fetched_data['basic']['quantity']) && is_array( $fetched_data['basic']['quantity'] ) ) {
            foreach ( $fetched_data['basic']['quantity'] as $quantity ) {
                if ( isset($quantity->customLabel) && $quantity->customLabel === 'Qty Shipped' ) {
                    $item_data['qty_shipped'] = isset($quantity->searchValue) ? $quantity->searchValue : 0;
                } elseif ( isset($quantity->customLabel) && $quantity->customLabel === 'Qty Ordered' ) {
                    $item_data['qty_ordered'] = isset($quantity->searchValue) ? $quantity->searchValue : 0;
                }
            }
        }
        if ( !empty( $fetched_data['basic']['rate'][0]->searchValue ) ) $item_data['rate'] = $fetched_data['basic']['rate'][0]->searchValue;

        $item_data['nsi_multiplier'] = $this->get_custom_field_value($fetched_data['basic'], 'custcol_serp_nsi_amount_multiplier') ?? 1;

        if ( !empty( $fetched_data['basic']['grossAmount'][0]->searchValue ) ) $item_data['item_amount'] = $fetched_data['basic']['grossAmount'][0]->searchValue;
        return $item_data;
    }

    protected function get_invoice_discount_date ( $data, $invoice_due_date, $invoice_date ) {
        $discount_date = '';
        if ( !empty($data['terms'][0]->searchValue->internalId) ) {
            $ns_terms_id = $data['terms'][0]->searchValue->internalId;
            global $wpdb;
            $table_name = $wpdb->prefix . 'ns_terms_labels';
            $terms_data = $wpdb->get_row( $wpdb->prepare("SELECT terms_discount_date, terms_discount_expire FROM `{$table_name}` WHERE ns_terms_id = %s",
                $ns_terms_id ), ARRAY_A );
            if ( ! empty( $terms_data['terms_discount_date'] ) && ! empty( $invoice_due_date ) ) {
                $date = new DateTime($invoice_due_date);
                $timezone = $date->getTimezone();
                $discount_date = new DateTime($date->format('Y-m') . '-' . str_pad($terms_data['terms_discount_date'], 2, '0', STR_PAD_LEFT) . 'T' . $date->format('H:i:s'), $timezone);
                $discount_date = $discount_date->format('c');
            } elseif ( ! empty( $terms_data['terms_discount_expire'] ) && ! empty( $invoice_date ) ) {
                $date = new DateTime($invoice_date);
                $date->add(new DateInterval('P' . $terms_data['terms_discount_expire'] . 'D'));
                $discount_date = $date->format('c');
            }
        }

        return $discount_date;
    }

    protected function get_invoice_discount_total ( $data ) {
        $discount_total = 0;
        if ( !empty($data['transactionDiscount']) ) {
            foreach ( $data['transactionDiscount'] as $item ) {
                if ( isset($item->customLabel) && $item->customLabel === 'Discount Total' && isset($item->searchValue) && $item->searchValue ) {
                    $discount_total = !empty($data['amount'][0]->searchValue) ? $data['amount'][0]->searchValue : 0;
                    break;
                }
            }
        }

        return $discount_total;
    }

    protected function update_order_invoice_ids($invoice_data) {
        $order_id = $invoice_data['order_id'];
        if ( empty( $order_id ) ) {
            return;
        }
        $invoice_tran_ids = maybe_unserialize( get_post_meta( $order_id, 'ns_invoice_tran_ids', true ) );
        $invoice_tran_ids = is_array( $invoice_tran_ids ) ? $invoice_tran_ids : array();
        if ( ! in_array( $invoice_data['tran_id'], $invoice_tran_ids ) ) {
            $invoice_tran_ids[] = $invoice_data['tran_id'];
            update_post_meta( $order_id, 'ns_invoice_tran_ids', $invoice_tran_ids );
        }
    }

    protected function get_order_id_by_ns_order_internal_id($ns_order_internal_id) {
        global $wpdb;
        $order_id = $wpdb->get_var( $wpdb->prepare("SELECT post_id FROM `wp_postmeta` WHERE meta_key = 'ns_order_internal_id' and meta_value = %s",
            $ns_order_internal_id,
        ) );

        return $order_id;
    }

    protected function create_tm_ns_invoices_data_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $this->tm_ns_invoices_data_table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
                tran_id VARCHAR(255) NOT NULL,
				order_id int(12) NOT NULL,
				ns_order_internal_id int(12) NOT NULL,
				ns_invoice_internal_id int(12) NOT NULL,
				invoice_last_modified_date DATETIME NOT NULL,
                invoice_info LONGTEXT NOT NULL,
                items_info LONGTEXT NOT NULL,
				PRIMARY KEY (id),
                UNIQUE INDEX idx_tran_id (tran_id),
                KEY order_id (order_id),
                KEY ns_order_internal_id (ns_order_internal_id)
			) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    protected function get_tm_ns_invoice_data( $ns_invoice_id ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tm_ns_fetch_invoices';
        $invoice_items = $wpdb->get_results( $wpdb->prepare("SELECT ns_invoice_data FROM `{$table_name}` WHERE ns_invoice_id = %s",
            $ns_invoice_id ) );

        return $invoice_items;
    }

    protected function get_custom_field_value($data, $field_name) {
        $value = null;
        if (isset($data['customFieldList']) && isset($data['customFieldList']->customField) && is_array($data['customFieldList']->customField)) {
            foreach ($data['customFieldList']->customField as $custom_field) {
                if (isset($custom_field->scriptId) && $custom_field->scriptId == $field_name) {
                    $value = $custom_field->searchValue ?? null;
                    break;
                }
            }
        }
        return $value;
    }

    protected function get_currency_label_by_id( $currency_id ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_currency_labels';

        $currency_label = $wpdb->get_var( $wpdb->prepare("SELECT currency_name FROM `{$table_name}` WHERE ns_currency_id = %s",
            $currency_id ) );

        return $currency_label;
    }

    protected function save_invoice_data($invoice_data, $placeholders) {
        global $wpdb;
        $invoice_data_insert = $wpdb->prepare( "REPLACE INTO `{$this->tm_ns_invoices_data_table_name}` 
                (`tran_id`, `order_id`, `ns_order_internal_id`, `ns_invoice_internal_id`, `invoice_last_modified_date`, `invoice_info`, `items_info`) 
                VALUES " . implode(', ', $placeholders),
            $invoice_data
        );

        $wpdb->query( $invoice_data_insert );
    }

    protected function remove_tm_ns_invoice_item_data( $ns_invoice_id ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tm_ns_fetch_invoices';
        $wpdb->query( $wpdb->prepare( "DELETE FROM `{$table_name}` WHERE ns_invoice_id = %s ", $ns_invoice_id ) );
    }

    protected function handle_error( $item, $error_msg, $file_name, &$log_file_content ) {
        $log_file_content .= 'NS Invoice (' . $item . ') could not be imported - ' . $error_msg . PHP_EOL;
        Crown_Order_Types::update_ns_order_custbody_values( $item, '', FALSE, $error_msg, 'invoice' );
        file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
        $this->remove_tm_ns_invoice_item_data( $item );
    }

    public function is_queue_has_items() {
        return false === $this->is_queue_empty();
    }

    public function is_running() {
        return $this->is_process_running();
    }

    protected function prepare_log_file() {
        $files_limit = defined( 'NS_SYNC_STORED_LOG_FILES_LIMIT' ) ? NS_SYNC_STORED_LOG_FILES_LIMIT : 20;
        $file_dir 		= wp_upload_dir();
        $date 	        = date("Y-m-d");
        $folder_name 	= 'netsuite-sync-logs/import-invoices';
        $folder_path 	= $file_dir['basedir'] . '/' . $folder_name;
        $file_name 		= $folder_path . '/import-invoices-' . $date . '.log';

        if ( !file_exists($folder_path)) {
            mkdir( $folder_path, 0755, true );
        }

        if(!file_exists($file_name)){
            $log_file = fopen($file_name, 'w');
            chmod($file_name, 0664);
            fclose($log_file);
        }

        $files = scandir($folder_path);
        $files = array_filter($files, function($file) use ($folder_path) {
            return is_file($folder_path . '/' . $file);
        });

        usort($files, function($a, $b) use ($folder_path) {
            return filemtime($folder_path . '/' . $a) > filemtime($folder_path . '/' . $b);
        });

        while (count($files) > $files_limit) {
            unlink($folder_path . '/' . $files[0]);
            array_shift($files);
        }

        return $file_name;
    }

}
