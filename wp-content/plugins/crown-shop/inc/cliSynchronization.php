<?php

/**
 * Commands for Action Synchronization with Net Suite.
 */
if ( defined( 'WP_CLI' ) && WP_CLI ) {
    /**
     * Sync orders to Netsuite manually.
     *
     * ## OPTIONS
     *
     * [<days>]
     * : Number of days to consider for syncing (default is 1).
     *
     * [<orders>]
     * : List of order IDs separated by commas.
     *
     * ## EXAMPLES
     *
     *     wp order_ns_sync 2 23948923,23423423,234234233
     *     wp order_ns_sync 2
     *     wp order_ns_sync 23948923,23423423,234234233
     *     wp order_ns_sync
     */
    class cliSynchronization extends WP_CLI_Command
    {
        /**
         * Sync Orders to Netsuite manually.
         *
         * ## OPTIONS
         *
         * [<days>]
         * : Number of days to consider for syncing (default is 1).
         *
         * [<orders>]
         * : List of order IDs separated by commas.
         *
         * ## EXAMPLES
         *
         *     wp order_ns_sync 2 23948923,23423423,234234233
         *     wp order_ns_sync 2
         *     wp order_ns_sync 23948923,23423423,234234233
         *     wp order_ns_sync
         *
         * @when after_wp_load
         *
         * @throws Exception
         */
        public function sync_to_netsuite_bulk($days_or_orders = null, $orders = null)
        {
            global $TMWNI_OPTIONS;

            $status = true;
            $args = array();

            if (empty($days_or_orders)) {
                $args['date_created'] = date( 'Y-m-d' );
            } elseif (is_numeric($days_or_orders)) {
                $date = new DateTime();
                $date->sub( new DateInterval( 'P' . $days_or_orders . 'D' ) );

                $args['limit'] = -1;
                $args['date_created'] = '>' . $date->format( 'Y-m-d' );
            }

            if (!empty($orders)) {
                $args['orderby'] = 'post__in';
                $args['post__in'] = explode(',', $orders);
            }

            $orders = wc_get_orders($args);

            if (isset($TMWNI_OPTIONS['enableOrderSync']) && 'on' == $TMWNI_OPTIONS['enableOrderSync']) {
                foreach ($orders as $order) {
                    $order_created_date = new DateTime( $order->get_date_created()->date( 'Y-m-d' ) );

                    if ( isset( $args['date_created'] ) && $order_created_date < $args['date_created'] ) {
                        continue;
                    }

                    $order_id = $order->get_id();

                    $status = apply_filters('tm_add_netsuite_order', $status, $order_id);

                    if ($status) {
                        $loader = new TMWNI_Loader();
                        $response = $loader->addNetsuiteOrder($order_id);
                        esc_attr_e($response);

                        /** Push orders to queue. */
                        $loader->push_orders_to_queue($order_id);
                        $netsuiteCommonIntegrationFunctions = new CommonIntegrationFunctions();

                        $netsuiteCommonIntegrationFunctions->handleLog(1, $order_id, 'order');
                    }
                }
            }

            WP_CLI::success('Orders synced to NetSuite successfully.');
        }
    }

    /**
     * WP CLI Command for syncing orders to NetSuite in bulk.
     *
     * @throws Exception
     */
    function cli_order_ns_sync($args, $assoc_args)
    {
        $order_netsuite_sync = new cliSynchronization();
        $days_or_orders = null;
        $orders = null;

        if ( isset( $args[0] ) ) {
            if ((str_contains($args[0], ',')) || preg_match_all("/\d/", $args[0]) > 4) {
                $orders = $args[0];
            } else {
                $days_or_orders = $args[0];
            }
        }

        if ( isset( $args[1] ) ) {
            $orders = $args[1];
        }

        $order_netsuite_sync->sync_to_netsuite_bulk( $days_or_orders, $orders );
    }

    WP_CLI::add_command('order_ns_sync', 'cli_order_ns_sync');
}
