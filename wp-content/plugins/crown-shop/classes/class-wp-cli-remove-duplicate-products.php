<?php

if (defined('WP_CLI') && WP_CLI) {
    /**
     * WP_CLI_Remove_Duplicate_Products Class
     *
     * This class extends the WP_CLI_Command class to provide a custom WP-CLI command
     * that removes duplicate products from a WordPress WooCommerce installation.
     *
     * The command works by querying the database for products with duplicate SKUs,
     * and then deleting all but the most recently modified duplicate for each SKU.
     *
     * The command can be run with a list of SKUs as an argument to only remove
     * duplicates for those specific SKUs.
     *
     * Additionally, a 'force' option can be provided to bypass certain checks when
     * deleting the products. If 'force' is present, the command will delete the
     * products without checking their presence in orders, submittals, or quotes.
     *
	 * ## OPTIONS
	 *
	 * [--scope=<scope>]
	 * : Only process dublicates for the specified scope. Defaults to All. Define multiple scopes as a comma separated string (without spaces), e.g. `--scope=all,orders,quotes,submittals`
     *
	 * Usage:
     * wp remove-duplicates
     * wp remove-duplicates SKU1,SKU2,SKU3
     * wp remove-duplicates --force
     * wp remove-duplicates --scope=orders,submittals
     * wp remove-duplicates SKU1,SKU2,SKU3 --force
    */
    class WP_CLI_Remove_Duplicate_Products extends WP_CLI_Command {

        function __invoke($args, $assoc_args) {
            global $wpdb;
    
            $skus = isset($args[0]) ? array_map('trim', explode(',', $args[0])) : null;
            $force = isset($assoc_args['force']);
			$scope = 'all';
			if ( isset( $assoc_args['scope'] ) ) {
				$scope = $assoc_args['scope'];
			}
			$scope  = explode( ',', $scope );

            WP_CLI::log("Getting duplicate products...");

            $products = $this->get_duplicate_products($skus);

            $total = count($products);

            $products_by_sku = [];
            foreach ($products as $product) {
                $products_by_sku[$product['sku']][] = $product;
            }

            $total = $total - count($products_by_sku);
            $current = 1;

            WP_CLI::log("Found $total duplicate products.");

            foreach ($products_by_sku as $sku => $products) {
                $actual_product = array_pop($products); // Keep the most recently modified product (last in the array)
                $actual_product_id = $actual_product['ID'];
                $duplicate_ids = array_column($products, 'ID');

                foreach ($duplicate_ids as $post_id) {
                    if ( $force ) {
						wp_delete_post($post_id, true);
						WP_CLI::log( "$current/$total: Deleted product with ID: $post_id (SKU: $sku)");
						$current++;
						continue;
					}
                	// Check if product is in an order, submittal, or quote
                   	$orders = $wpdb->get_results("
                        SELECT
                        	order_id,
                            order_item_id
                        FROM wp_wc_order_product_lookup 
                        WHERE 
                            product_id = {$post_id}", ARRAY_A
                    );

                    if ( !empty($orders) ) {
						$order_ids = $order_item_ids = array();
						foreach ($orders as $order) {
							$order_item_ids[] = $order['order_item_id'];
							$order_ids[] = $order['order_id'];
						}
						$formatted_order_item_ids = implode(',', $order_item_ids);
						$formatted_order_ids = implode(',', $order_ids);
						if (in_array('orders', $scope) || in_array('all', $scope)) {
							$this->update_order_items($order_ids, $post_id, $actual_product_id);
							$sql = $wpdb->prepare("UPDATE wp_wc_order_product_lookup SET product_id = {$actual_product_id} WHERE order_item_id IN ({$formatted_order_item_ids})");
							$wpdb->query($sql);
							wp_delete_post($post_id, true);
							WP_CLI::log( "$current/$total: Product with ID: $post_id (SKU: $sku) is in order(s): $formatted_order_ids. Changed to $actual_product_id. Deleted product with ID: $post_id.");
						} else {
							WP_CLI::log( "$current/$total: Product with ID: $post_id (SKU: $sku) is in a orde(s): $formatted_order_ids. Skipping.");
						}
                    }

					$quotes = $wpdb->get_results("
    					SELECT post_id, meta_value
                        FROM {$wpdb->postmeta} 
                        WHERE 
                            meta_key = 'quote_contents' AND
                            meta_value LIKE '%product_id\";i:{$post_id}%'"
					);

					if ( !empty($quotes) ) {
						if (in_array('quotes', $scope) || in_array('all', $scope)) {
							$quote_ids = $this->get_processed_quote_ids( $quotes, $post_id, $actual_product_id );
							$formatted_quote_ids = implode(',', $quote_ids);
							wp_delete_post($post_id, true);
							WP_CLI::log("$current/$total: Product with ID: $post_id (SKU: $sku) is in quote(s): $formatted_quote_ids. Changed to $actual_product_id. Deleted product with ID: $post_id.");
						} else {
							WP_CLI::log( "$current/$total: Product with ID: $post_id (SKU: $sku) is in quote(s). Skipping.");
						}
					}

                    $submittals = $wpdb->get_results("
                        SELECT
                            id,
                            submittal_id
                        FROM wp_submittal_products 
                        WHERE 
                            product_id = {$post_id}", ARRAY_A
                    );

					if ( !empty($submittals) ) {
						$submittal_ids = $submittal_item_ids = array();
						foreach ($submittals as $submittal) {
							$submittal_item_ids[] = $submittal['id'];
							$submittal_ids[] = $submittal['submittal_id'];
						}
						$formatted_submittal_item_ids = implode(',', $submittal_item_ids);
						$formatted_sids = implode(',', $submittal_ids);
						if (in_array('submittals', $scope) || in_array('all', $scope)) {
							$sql = $wpdb->prepare("UPDATE wp_submittal_products SET product_id = {$actual_product_id} WHERE id IN ({$formatted_submittal_item_ids})");
							$wpdb->query($sql);
							wp_delete_post($post_id, true);
							WP_CLI::log( "$current/$total: Product with ID: $post_id (SKU: $sku) is in a submittal(s): $formatted_sids. Changed to $actual_product_id. Deleted product with ID: $post_id.");
						} else {
							WP_CLI::log( "$current/$total: Product with ID: $post_id (SKU: $sku) is in a submittal(s): $formatted_sids. Skipping.");
						}

					}

					if (!empty($orders) || !empty($quotes) || !empty($submittals)) {
						$current++;
						continue;
					}

                    wp_delete_post($post_id, true);
                    WP_CLI::log( "$current/$total: Deleted product with ID: $post_id (SKU: $sku)");
                    $current++;
                }
            }
        }

        private function get_duplicate_products($skus) {
			global $wpdb;

        	$placeholders = $skus ? implode(',', array_fill(0, count($skus), '%s')) : '';

			$query = "
                SELECT
                    meta.sku,
                    posts.ID,
                    posts.post_modified
                FROM {$wpdb->posts} posts
                INNER JOIN (
                    SELECT
                        meta_value AS sku,
                        GROUP_CONCAT(post_id) AS post_ids
                    FROM {$wpdb->postmeta}
                    WHERE meta_key = '_sku'
                    " . ($skus ? "AND meta_value IN ($placeholders)" : "") . "
                    GROUP BY meta_value
                    HAVING COUNT(meta_id) > 1
                ) meta
                ON FIND_IN_SET(posts.ID, meta.post_ids)
                ORDER BY meta.sku, posts.post_modified";

			if ($skus) {
				$query = $wpdb->prepare($query, ...$skus);
			}

			$products = $wpdb->get_results($query, ARRAY_A);

			return $products;
		}

		private function update_order_items($order_ids, $post_id, $actual_product_id) {
			foreach ($order_ids as $order_id) {
				$order = wc_get_order($order_id); // Get the order object
				if ($order) {
					foreach ($order->get_items() as $item_id => $item) {
						// Check if this item matches the old product ID you want to change
						if ($item->get_product_id() == $post_id) {
							// Update to the new product ID
							wc_update_order_item_meta($item_id, '_product_id', $actual_product_id);
						}
					}
				}
			}
		}

		private function get_processed_quote_ids( $quotes, $post_id, $actual_product_id ) {
			global $wpdb;

        	$quote_ids = array();
			foreach ( $quotes as $quote ) {
				$quote_ids[] = $quote->post_id;
				$contents = maybe_unserialize( $quote->meta_value );
				foreach ( $contents as &$content ) {
					if ( isset( $content['product_id'] )
						&& $content['product_id'] == $post_id
						&& isset($content['data'])
						&& is_a($content['data'], 'WC_Product_Simple')) {
						$updated_product = wc_get_product($actual_product_id);
						if ($updated_product) {
							$content['data'] = $updated_product;
						}
						$content['product_id'] = $actual_product_id;
					}
				}
				$updated_contents = maybe_serialize( $contents );

				$wpdb->update(
					$wpdb->postmeta,
					array( 'meta_value' => $updated_contents ),
					array( 'post_id' => $quote->post_id, 'meta_key' => 'quote_contents' )
				);
			}
			return $quote_ids;
		}
	}

    WP_CLI::add_command('remove-duplicates', 'WP_CLI_Remove_Duplicate_Products');
}