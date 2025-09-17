<?php

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'woocommerce' ) ) return;
if ( ! class_exists( 'WP_Async_Request', false ) ) {
	include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-async-request.php';
}

if ( ! class_exists( 'WP_Background_Process', false ) ) {
	include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-background-process.php';
}

class Crown_Quotes_Background_Export extends WP_Background_Process {

	
	protected $action = 'crown_quotes_export';

	protected $report_date = '';

	protected $quote_data = array();

	protected function task( $item ) {
		$quote_id = $item['quote_id'];
		$this->report_date = $item['date'];
		$customer_info = $this->get_customer_info($quote_id);
		$customer_info['quote_contents'] = $this->get_quote_products_data($quote_id);
		$this->quote_data = $customer_info;
		$this->save_quotes_data_to_csv();
		return false;
	}

	protected function get_customer_info( $quote_id ) {
		$customer_info = array();
		$statuses = array(
			'af_pending'    => __( 'Pending', 'addify_rfq' ),
			'af_in_process' => __( 'In Process', 'addify_rfq' ),
			'af_accepted'   => __( 'Accepted', 'addify_rfq' ),
			'af_converted'  => __( 'Converted to Order', 'addify_rfq' ),
			'af_declined'   => __( 'Declined', 'addify_rfq' ),
			'af_cancelled'  => __( 'Cancelled', 'addify_rfq' ),
			'af_expired'    => __( 'Expired', 'addify_rfq' ),
		);
		$quote_status = get_post_meta( $quote_id, 'quote_status', true );
        $rfq_accepted_date = get_post_meta( $quote_id, 'rfq_accepted_date', true ) ?? '';
        if ( $rfq_accepted_date ) {
            $rfq_accepted_date = gmdate( 'n/j/y g:i a', strtotime( $rfq_accepted_date ) );
        }

		$customer_info['Status'] = $statuses[$quote_status] ?? __( 'Undefined', 'addify_rfq' );
		$customer_info['Quote Number'] = $quote_id;
		$customer_info['Quote Date (Created)'] = gmdate( 'n/j/y g:i a', get_post_time( 'U', false, $quote_id, true ) );
        $customer_info['Quote Updated by'] = get_post_meta( $quote_id, 'rfq_updated_by', true ) ?? '';
        $customer_info['Quote Date (Updated)'] = gmdate( 'n/j/y g:i a', get_post_modified_time( 'U', false, $quote_id, true ) );
		$customer_info['Quote Accepted by'] = get_post_meta( $quote_id, 'rfq_accepted_by', true ) ?? '';
        $customer_info['Quote Date (Accepted)'] = $rfq_accepted_date;

		$quote_fields_obj = new AF_R_F_Q_Quote_Fields();
		$quote_fields    = (array) $quote_fields_obj->afrfq_get_fields_enabled();

		if ( empty( $quote_fields ) ) {
			return $customer_info;
		}

		foreach ( $quote_fields as $key => $field ) {

			$post_id = $field->ID;

			$afrfq_field_name  = get_post_meta( $post_id, 'afrfq_field_name', true );
			$afrfq_field_type  = get_post_meta( $post_id, 'afrfq_field_type', true );
			$afrfq_field_label = get_post_meta( $post_id, 'afrfq_field_label', true );
			$field_data        = get_post_meta( $quote_id, $afrfq_field_name, true );

			if ( is_array( $field_data ) ) {
				$field_data = implode( ', ', $field_data );
			}

			if ( in_array( $afrfq_field_type, array( 'select', 'radio', 'multiselect' ), true ) ) {
				$field_data = ucwords( $field_data );
			}

			if ($afrfq_field_label === 'Distributor' && empty( $field_data ) ) {
				$field_data = $this->get_distributor_name( $quote_id );
			}

			$customer_info[ $afrfq_field_label ] = $field_data;
		}

		return $customer_info;
	}

	protected function get_quote_products_data( $quote_id ) {
        $price_base_type = get_post_meta( $quote_id, '_price_base_type', true );
        if ( empty($price_base_type) ) {
            $price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
        }
		$quote_contents = get_post_meta( $quote_id, 'quote_contents', true );
		$quote_products_data = array();

		if (!$quote_contents) {
			return $quote_products_data;
		}

		foreach ( (array) $quote_contents as $item_id => $item ) {

			if ( isset( $item['data'] ) ) {

				$product = $item['data'];

			} else {

				continue;
			}

			if ( ! is_object( $product ) ) {
				continue;
			}
			$product_id = $product->get_id();
			$price         = empty( $item['addons_price'] ) ? $product->get_price() : $item['addons_price'];
			$price         = empty( $item['role_base_price'] ) ? $price : $item['role_base_price'];
			$qty_display   = $item['quantity'];
			$offered_price = isset( $item['offered_price'] ) ? floatval( $item['offered_price'] ) : $price;
			$approved_price = isset( $item['approved_price'] ) ? floatval( $item['approved_price'] ) : $offered_price;
            if ($price_base_type === 'moq') {
                $price_qty_multiplier = intval( get_post_meta( $product_id, 'min_quantity', true ) );
                $price_qty_multiplier = $price_qty_multiplier < 1 ? 1 : $price_qty_multiplier;
            } else {
                $price_qty_multiplier = get_post_meta( $product_id, 'ns_price_qty_multiplier', true );
                $price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;
            }
            $offered_price_per_each = isset( $item['offered_price_per_each'] ) ? floatval( $item['offered_price_per_each'] ) : $offered_price / $price_qty_multiplier;
            $approved_price_per_each = isset( $item['approved_price_per_each'] ) ? floatval( $item['approved_price_per_each'] ) : $approved_price / $price_qty_multiplier;
			$quote_products_data[$product_id] = array (
				'product_sku' => $product->get_sku(),
				'quantity' => $qty_display,
				'price_base_type' => $price_base_type,
                'role_base_price' => number_format($price, 2, '.', ''),
                'offered_price' => number_format($offered_price, 2, '.', ''),
				'offered_price_per_each' => number_format($offered_price_per_each, 2, '.', ''),
                'approved_price' => number_format($approved_price, 2, '.', ''),
				'approved_price_per_each' => number_format($approved_price_per_each, 2, '.', ''),
				'subtotal_role_base_price' => number_format($price * $qty_display, 2, '.', ''),
				'subtotal_offered_price' => number_format($offered_price * $qty_display / $price_qty_multiplier, 2, '.', ''),
				'subtotal_approved_price' => number_format($approved_price * $qty_display / $price_qty_multiplier, 2, '.', ''),
			);
		}

		return $quote_products_data;
	}

	protected function save_quotes_data_to_csv() {
		$file_name = $this->prepare_quotes_report_file();
		$csv_file = fopen($file_name, 'a');

		if (empty($this->quote_data['quote_contents'])) {
			unset($this->quote_data['quote_contents']);
			fputcsv($csv_file, $this->quote_data);
			fclose($csv_file);
			return;
		}
		foreach ($this->quote_data['quote_contents'] as $product_data) {
			$row_value = array_merge($this->quote_data, $product_data);
			if (isset($row_value['quote_contents'])) {
				unset($row_value['quote_contents']);
			}
			fputcsv($csv_file, $row_value);
		}

		fclose($csv_file);
		return;
	}

	protected function prepare_quotes_report_file() {
		$path_folder = defined('CROWN_QUOTE_EXPORT_FOLDER_PATH') ? CROWN_QUOTE_EXPORT_FOLDER_PATH : '/opt/bitnami/quote-reports/';
		$file_name = $path_folder . 'nsi-quotes-report-' . $this->report_date . '.csv';

		if ( !file_exists($path_folder)) {
			mkdir( $path_folder, 0755 );
		}

		if(!file_exists($file_name)){
			$csv_file = fopen($file_name, 'w');
			chmod($file_name, 0777);
			fputcsv($csv_file, $this->get_headers());
			fclose($csv_file);
		}

		return $file_name;
	}

	protected function get_headers() {
		$headers = array_keys($this->quote_data);
		$key = array_search('quote_contents', $headers);
		if ($key) {
			unset($headers[$key]);
		}
		$product_data_headers = array(
			'Product',
			'Quantity',
			'Price Base Type',
			'Price/Cost (Standard)',
			'Requested Price',
			'Requested Price Per Each',
			'Approved Price',
			'Approved Price Per Each',
			'Subtotal (Standard)',
			'Subtotal (Requested)',
			'Subtotal (Approved)',
		);
		$headers = array_merge($headers, $product_data_headers);

		return $headers;
	}

	protected function get_distributor_name( $quote_id ) {
		$distributor_name = '';
		$customer_user_id = get_post_meta( $quote_id, '_customer_user', TRUE );
		$customer = get_userdata( $customer_user_id );
		if ( $customer ) {
			$distributor_name = $customer->display_name;
		} else {
			$author_id = get_post_field( 'post_author', $quote_id );
			if ( !empty($author_id) ) {
				$distributor_name = get_the_author_meta( 'display_name', $author_id );
			}
		}
		return $distributor_name;
	}

}
