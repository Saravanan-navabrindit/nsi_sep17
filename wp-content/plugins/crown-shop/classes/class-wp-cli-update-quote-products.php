<?php

if (defined('WP_CLI') && WP_CLI) {
    /**
     * WP_CLI_Update_Quote_Products Class
     *
     * This class extends the WP_CLI_Command class to provide a custom WP-CLI command
     * that updates quotes product data.
     *
     * The command works by querying the database for quotes with discrepancies in data between product_id
	 * and WC_Product_Simple and then updates data based on product_id value.
	 *
	 * Usage:
     * wp update-quote-products
    */
    class WP_CLI_Update_Quote_Products extends WP_CLI_Command {

        private bool $updated_flag;

    	function __invoke($args, $assoc_args) {
            global $wpdb;

			$file_path = dirname( __FILE__ ) . '/../data/old-products-sku-mapping.csv';
			$data = $this->parse_csv_to_array($file_path);
			if (!$data) {
				WP_CLI::log("No file with mapping data found.");
				return;
			}

            WP_CLI::log("Getting quotes data...");
            $quotes = $wpdb->get_results("
    					SELECT post_id, meta_value
                        FROM {$wpdb->postmeta} 
                        WHERE 
                            meta_key = 'quote_contents'"
			);

            $total = count($quotes);
			$current = 1;
			WP_CLI::log("Found $total quotes.");
			if ( empty($quotes) ) {
				return;
			}

			foreach ( $quotes as $quote ) {
				$this->updated_flag = FALSE;
				$quote_id = $quote->post_id;
				$contents = maybe_unserialize( $quote->meta_value );

				$contents = $this->replace_non_exist_products_with_provided_in_data_set( $contents, $quote_id, $data );

				if ($this->updated_flag) {
					$updated_contents = maybe_serialize( $contents );

					$wpdb->update(
						$wpdb->postmeta,
						array( 'meta_value' => $updated_contents ),
						array( 'post_id' => $quote_id, 'meta_key' => 'quote_contents' )
					);
				}

				WP_CLI::log("$current/$total: Quote with ID: $quote_id processed.");
				$current++;
			}
        }

        private function parse_csv_to_array($file_path) {
			$data = [];
			if (!file_exists($file_path) || !is_readable($file_path)) {
				return false;
			}

			if (($handle = fopen($file_path, 'r')) !== false) {
				while (($row = fgetcsv($handle)) !== false) {
					// Assuming the first column is 'product_id' and the second is 'sku'
					if (!isset($data[$row[0]])) {
						$data[$row[0]] = $row[1];
					}
				}
				fclose($handle);
			}
			return $data;
		}

		private function replace_non_exist_products_with_provided_in_data_set( $contents, $quote_id, array $data ) {
			foreach ( $contents as &$content ) {
				if ( ! isset( $content['product_id'] )
					|| ! isset( $content['data'] )
					|| ! is_a( $content['data'], 'WC_Product_Simple' ) ) {
					continue;
				}

				$product = $content['data'];
				$product_id = $content['product_id'];

				if ( wc_get_product( $product_id ) ) {
					if ( $product->get_id() == $product_id ) {
						continue;
					}
					$updated_product = wc_get_product( $product_id );
					if ( $updated_product ) {
						$content['data'] = $updated_product;
						$this->updated_flag = TRUE;
						WP_CLI::log( "Quote $quote_id: product item updated, current ID: $product_id" );
					}
				} else {
					$sku = $data[$product_id];
					if ( ! $sku ) {
						WP_CLI::log( "SKU for old product ID $product_id not found in dataset, quote $quote_id item skipped." );
						continue;
					}
					$new_product_id = wc_get_product_id_by_sku( $sku );
					if ( ! $new_product_id ) {
						WP_CLI::log( "Product with SKU $sku not found, quote $quote_id item skipped." );
						continue;
					}

					$updated_product = wc_get_product( $new_product_id );
					if ( $updated_product ) {
						$content['data'] = $updated_product;
					}
					$content['product_id'] = $new_product_id;
					$this->updated_flag = TRUE;
					WP_CLI::log( "Quote $quote_id: product item updated, current ID (new): $new_product_id" );
				}

			}
			return $contents;
		}

	}

    WP_CLI::add_command('update-quote-products', 'WP_CLI_Update_Quote_Products');
}