<?php
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'woocommerce' ) ) return;
if ( ! class_exists( 'WP_Async_Request', false ) ) {
    include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-async-request.php';
}

if ( ! class_exists( 'WP_Background_Process', false ) ) {
    include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-background-process.php';
}

class NS_Returns_Updates_Import extends WP_Background_Process {

    protected $action = 'ns_returns_update';
    protected int $user_id;

    protected function task( $item ) {
        $file_name = $this->prepare_log_file('/update-returns-', 'update-returns');
        $datetime = date( 'Y-m-d H:i:s' );
        $log_file_content = '[' . $datetime . '] Start update of NS Return ID ' . $item . PHP_EOL;

        $returns_data = $this->get_returns_update_data( $item );
        if ( empty($returns_data) ) {
            $log_file_content .= 'Return update data not found' . PHP_EOL;
            file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
            return false;
        }

        $return_id = $this->get_wc_return_id_for_ns_return_id( $item );
        if ( !$return_id ) {
            $log_file_content .= 'Return NS ID ' . $item . ' not found in WordPress.';
            file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
            $this->remove_tm_ns_return_update_item_data( $item );
            Crown_Order_Types::update_ns_order_custbody_values( $item, null, FALSE, null, 'return_authorization' );
            return false;
        }

        $is_first_row = true;
        $wc_return_items = maybe_unserialize( get_post_meta($return_id, 'items', true) ) ?? array();
        $ns_return_skus = array();
        foreach ( $returns_data as $return_data ) {
            $ns_data = unserialize($return_data->ns_return_data);

            if ( $is_first_row ) {
                $is_first_row = false;
                $status = $ns_data['basic']['status'][0]->searchValue;
                if ( key_exists( $status, NSI_RMA_Post_Type::$rma_statuses ) ) {
                    update_post_meta($return_id, 'rma_status', $status);
                }
            }
            if ( $this->is_restocking_fees_item( $ns_data ) ) {
                $restocking_fees = $ns_data['basic']['amount'][0]->searchValue ?? 0;
                update_post_meta($return_id, 'restocking_fees', $restocking_fees);
                continue;
            }
            $item_sku = $ns_data['item_join']['itemId'][0]->searchValue ?? '';
            $ns_return_skus[] = $item_sku;
            $item_found = false;
            $wc_return_items = $this->update_return_items_data_if_exist($wc_return_items, $item_sku, $ns_data['basic'], $item_found);

            if ( !$item_found ) {
                $wc_return_items = $this->add_return_item($wc_return_items, $item_sku, $ns_data['basic']);
            }
        }

        foreach ( $wc_return_items as $item_id => $return_item ) {
            if ( !in_array($return_item['sku'], $ns_return_skus) ) {
                unset( $wc_return_items[$item_id] );
            }
        }
        update_post_meta( $return_id, 'items', $wc_return_items );

        $rma_pdf = get_post_meta( $return_id, 'ns_rma_doc', true );
        if ( !empty($rma_pdf) ) {
            $file_dir = wp_upload_dir();
            $folder_name = 'rma-pdf';
            $folder_path = $file_dir['basedir'] . '/' . $folder_name;
            $pdf_file_path = $folder_path . '/' . $rma_pdf;

            if ( file_exists($pdf_file_path) ) {
                unlink( $pdf_file_path );
            }
            delete_post_meta( $return_id, 'ns_rma_doc' );
        }

        $log_file_content .= 'Return ID ' . $return_id . ' successfully updated' . PHP_EOL;
        file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
        $this->remove_tm_ns_return_update_item_data( $item );
        Crown_Order_Types::update_ns_order_custbody_values( $item, null, FALSE, null, 'return_authorization' );
        return false;
    }

    protected function get_returns_update_data( $ns_return_id ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tm_ns_fetch_returns_updates';
        $return_data = $wpdb->get_results( $wpdb->prepare("SELECT ns_return_data FROM `{$table_name}` WHERE ns_return_id = %s",
            $ns_return_id
        ) );

        return $return_data;
    }

    public function is_restocking_fees_item($ns_data) {
        $fees_item = FALSE;
        if ( isset( $ns_data['item_join']['customFieldList'] )
            && isset( $ns_data['item_join']['customFieldList']->customField )
            && is_array( $ns_data['item_join']['customFieldList']->customField ) ) {
            foreach ( $ns_data['item_join']['customFieldList']->customField as $custom_field ) {
                if ( isset( $custom_field->scriptId )
                    && isset( $custom_field->searchValue )
                    && $custom_field->scriptId === 'custitem_nsi_restocking_fees' ) {
                    $fees_item = $custom_field->searchValue;
                    break;
                }
            }
        }
        return $fees_item;
    }

    public function update_return_items_data_if_exist($wc_return_items, $item_sku, $ns_data_basic, &$item_found) {
        foreach ($wc_return_items as $item_id => $return_item) {
            if ($return_item['sku'] === $item_sku) {
                $item_found = true;
                $ns_return_total = $ns_data_basic['amount'][0]->searchValue ?? false;
                if ($ns_return_total !== false) {
                    $ns_return_total = abs($ns_return_total);
                    if ($return_item['subtotal'] != $ns_return_total) {
                        $wc_return_items[$item_id]['subtotal'] = $ns_return_total;
                    }
                }

                $ns_return_qty = $ns_data_basic['quantity'][0]->searchValue ?? false;
                if ($ns_return_qty !== false) {
                    $ns_return_qty = abs($ns_return_qty);
                    if ($return_item['qty'] != $ns_return_qty) {
                        $wc_return_items[$item_id]['qty'] = $ns_return_qty;
                    }
                }

                $ns_return_rate = $ns_data_basic['rate'][0]->searchValue ?? false;
                if ($ns_return_rate !== false && $return_item['rate'] != $ns_return_rate) {
                    $wc_return_items[$item_id]['rate'] = $ns_return_rate;
                }

                break;
            }
        }
        return $wc_return_items;
    }

    public function add_return_item ($wc_return_items, $item_sku, $ns_data_basic) {
        $product_id = wc_get_product_id_by_sku($item_sku);
        $prod = wc_get_product($product_id);
        $wc_return_items[$product_id] = array(
            'sku' => $item_sku,
            'name' => $prod->get_name(),
            'qty' => abs($ns_data_basic['quantity'][0]->searchValue),
            'rate' => $ns_data_basic['rate'][0]->searchValue,
            'subtotal' => abs($ns_data_basic['amount'][0]->searchValue),
            'product_id' => $product_id,
        );
        return $wc_return_items;
    }

    protected function get_wc_return_id_for_ns_return_id( $ns_return_id ) {
        global $wpdb;
        $return_id_query = $wpdb->get_results( $wpdb->prepare("SELECT post_id FROM `wp_postmeta` WHERE meta_key = 'ns_return_internal_id' and meta_value = %s",
            $ns_return_id,
        ) );

        return $return_id_query[0]->post_id ?? false;
    }

    protected function remove_tm_ns_return_update_item_data( $ns_return_id ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tm_ns_fetch_returns_updates';
        $wpdb->query( $wpdb->prepare("DELETE FROM `{$table_name}` WHERE ns_return_id = %s ", $ns_return_id) );
    }

    protected function prepare_log_file($file_prefix, $sub_folder) {
        $files_limit = defined( 'NS_SYNC_STORED_LOG_FILES_LIMIT' ) ? NS_SYNC_STORED_LOG_FILES_LIMIT : 20;
        $file_dir 		= wp_upload_dir();
        $date 	        = date("Y-m-d");
        $folder_name 	= 'netsuite-sync-logs/' . $sub_folder;
        $folder_path 	= $file_dir['basedir'] . '/' . $folder_name;
        $file_name 		= $folder_path . $file_prefix . $date . '.log';

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
