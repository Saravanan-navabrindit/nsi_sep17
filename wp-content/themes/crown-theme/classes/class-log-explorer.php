<?php

if ( ! class_exists( 'Log_Explorer' ) ) {
class Log_Explorer {
    public static function check_authorized_access(): void {
        if (!current_user_can('manage_options') && !current_user_can('edit_pages')) {
            wp_redirect(home_url());
            exit;
        } else {
            self::apply_styles();
            echo '<article id="log_explorer">';
            echo '<h2 class="warning">Admin only access</h2>';
        }
    }

    public static function get_active_directory(string $current_url): string {
        $upload_dir = wp_upload_dir()['basedir'];
        $manual_sync_ns_logs_directory = $upload_dir . '/manual-sync-ns-logs/';
        $wc_logs_directory = $upload_dir . '/wc-logs/';
        $netsuite_customer_logs_directory = $upload_dir . '/netsuite-customer-logs/';
        $users_actions_logs_directory = $upload_dir . '/users-actions-logs/';
        $amplify_products_import_manual_by_sku_logs_directory = $upload_dir . '/amplify-logs/amplify-products-import-manual-by-sku/';
        $amplify_products_import_auto_logs_directory = $upload_dir . '/amplify-logs/amplify-products-import-auto/';
        $amplify_product_cleanup_logs_directory = $upload_dir . '/amplify-logs/amplify-product-cleanup/';
        $amplify_amplify_categories_logs_directory = $upload_dir . '/amplify-logs/amplify-categories-import/';
        $amplify_products_import_manual_by_category_logs_directory = $upload_dir . '/amplify-logs/amplify-products-import-manual-by-category/';
        $ns_orders_sync_logs_directory = $upload_dir . '/netsuite-sync-logs/';
        $price_files_logs_directory = $upload_dir . '/price-files/';
        $ns_fetch_invoices_logs_directory = $upload_dir . '/netsuite-sync-logs/fetch-invoices/';
        $ns_fetch_orders_logs_directory = $upload_dir . '/netsuite-sync-logs/fetch-orders/';
        $ns_fetch_updates_logs_directory = $upload_dir . '/netsuite-sync-logs/fetch-updates/';
        $ns_import_invoices_logs_directory = $upload_dir . '/netsuite-sync-logs/import-invoices/';
        $ns_import_orders_logs_directory = $upload_dir . '/netsuite-sync-logs/import-orders/';
        $ns_update_orders_logs_directory = $upload_dir . '/netsuite-sync-logs/update-orders/';
        $ns_create_returns_logs_directory = $upload_dir . '/netsuite-sync-logs/create-returns/';
        $ns_update_returns_logs_directory = $upload_dir . '/netsuite-sync-logs/update-returns/';
        $ns_fetch_returns_updates_logs_directory = $upload_dir . '/netsuite-sync-logs/fetch-return-updates/';
        $extra_logs_directory = $upload_dir . '/extra-logs/';
        $dropship_inventory_logs_directory = $upload_dir . '/dropship-inventory-logs/';

        switch (true) {
            case strpos($current_url, 'manual-sync-ns-logs') !== false:
                $directory = $manual_sync_ns_logs_directory;
                break;
            case strpos($current_url, 'netsuite-customer-logs') !== false:
                $directory = $netsuite_customer_logs_directory;
                break;
            case strpos($current_url, 'users-actions-logs') !== false:
                $directory = $users_actions_logs_directory;
                break;
            case strpos($current_url, 'amplify-products-import-manual-by-sku') !== false:
                $directory = $amplify_products_import_manual_by_sku_logs_directory;
                break;
            case strpos($current_url, 'amplify-products-import-auto') !== false:
                $directory = $amplify_products_import_auto_logs_directory;
                break;
            case strpos($current_url, 'amplify-product-cleanup') !== false:
                $directory = $amplify_product_cleanup_logs_directory;
                break;
            case strpos($current_url, 'amplify-categories-import') !== false:
                $directory = $amplify_amplify_categories_logs_directory;
                break;
            case strpos($current_url, 'amplify-products-import-manual-by-category') !== false:
                $directory = $amplify_products_import_manual_by_category_logs_directory;
                break;
            case strpos($current_url, 'fetch-invoices') !== false:
                $directory = $ns_fetch_invoices_logs_directory;
                break;
            case strpos($current_url, 'fetch-orders') !== false:
                $directory = $ns_fetch_orders_logs_directory;
                break;
            case strpos($current_url, 'fetch-updates') !== false:
                $directory = $ns_fetch_updates_logs_directory;
                break;
            case strpos($current_url, 'import-invoices') !== false:
                $directory = $ns_import_invoices_logs_directory;
                break;
            case strpos($current_url, 'import-orders') !== false:
                $directory = $ns_import_orders_logs_directory;
                break;
            case strpos($current_url, 'update-orders') !== false:
                $directory = $ns_update_orders_logs_directory;
                break;
            case strpos($current_url, 'create-returns') !== false:
                $directory = $ns_create_returns_logs_directory;
                break;
            case strpos($current_url, 'update-returns') !== false:
                $directory = $ns_update_returns_logs_directory;
                break;
            case strpos($current_url, 'fetch-return-updates') !== false:
                $directory = $ns_fetch_returns_updates_logs_directory;
                break;
            case strpos($current_url, 'netsuite-sync-logs') !== false:
                $directory = $ns_orders_sync_logs_directory;
                break;
            case strpos($current_url, 'price-files') !== false:
                $directory = $price_files_logs_directory;
                break;
            case strpos($current_url, 'extra-logs') !== false:
                $directory = $extra_logs_directory;
                break;
            case strpos($current_url, 'dropship-inventory-logs') !== false:
                $directory = $dropship_inventory_logs_directory;
                break;
            default:
                $directory = $wc_logs_directory;
                break;
        }
        return $directory;
    }

    public static function listFiles($dir) {
        if (!is_dir($dir)) {
            echo '<p>Directory not found: ' . htmlspecialchars($dir) . '</p>';
            return;
        }

        $files = scandir($dir);
        if ($files === false) {
            echo '<p>Failed to read directory: ' . htmlspecialchars($dir) . '</p>';
            return;
        }

        echo '<ul>';
        foreach ($files as $file) {
            if (in_array(pathinfo($file, PATHINFO_EXTENSION), array('log', 'txt', 'json'))) {
                echo '<li><a href="?file=' . urlencode($file) . '">' . htmlspecialchars($file) . '</a></li>';
            }
        }
        echo '</ul>';
    }

    public static function render_log_dirs($directory): void {

        echo '<p/><a class="home" href="' . home_url() . '">&#10595; Home</a><p/>';
        echo '<h3 class="active-dir">Active logs directory: ' . htmlspecialchars($directory) . '</h3>';

        $log_directories = [
            'manual-sync-ns-logs' => 'manual-sync-ns-logs',
            'wc-logs' => 'wc-logs',
            'netsuite-customer-logs' => 'netsuite-customer-logs',
            'users-actions-logs' => 'users-actions-logs',
            'amplify-logs/amplify-products-import-manual-by-sku' => 'amplify-products-import-manual-by-sku',
            'amplify-logs/amplify-products-import-auto' => 'amplify-products-import-auto',
            'amplify-logs/amplify-product-cleanup' => 'amplify-product-cleanup',
            'amplify-logs/amplify-categories-import' => 'amplify-categories-import',
            'amplify-logs/amplify-products-import-manual-by-category' => 'amplify-products-import-manual-by-category',
            'netsuite-sync-logs' => 'netsuite-sync-logs',
            'price-files' => 'price-files',
            'netsuite-sync-logs/fetch-invoices' => 'fetch-invoices',
            'netsuite-sync-logs/fetch-orders' => 'fetch-orders',
            'netsuite-sync-logs/fetch-updates' => 'fetch-updates',
            'netsuite-sync-logs/import-invoices' => 'import-invoices',
            'netsuite-sync-logs/import-orders' => 'import-orders',
            'netsuite-sync-logs/update-orders' => 'update-orders',
            'netsuite-sync-logs/create-returns' => 'create-returns',
            'netsuite-sync-logs/update-returns' => 'update-returns',
            'netsuite-sync-logs/fetch-return-updates' => 'fetch-return-updates',
            'extra-logs' => 'extra-logs',
            'dropship-inventory-logs' => 'dropship-inventory-logs',
        ];

        foreach ($log_directories as $key => $name) {
            echo '<p/><a href="' . home_url() . '/wp-content/uploads/' . $key . '/">Switch active logs directory to <strong>' . $name . '</strong></a><p/>';
        }

        $log_pages = [
            'push-to-queue-netsuite-inventory-log' => 'Push to Queue Netsuite Inventory Log',
            'price-netsuite-inventory-log' => 'Price Netsuite Inventory Log',
            'inventory-netsuite-inventory-log' => 'Inventory Netsuite Inventory Log',
        ];
        foreach ($log_pages as $key => $name) {
            echo '<p/><a href="' . home_url() . '/wp-content/uploads/' . $key . '.html">Check logs from page <strong>' . $name . '</strong></a><p/>';
        }

        if (isset($_GET['file'])) {
            $file = urldecode($_GET['file']);
            $filePath = $directory . '/' . $file;
            if (file_exists($filePath)) {
                echo '<h2>Contents of ' . htmlspecialchars($file) . ':</h2>';
                echo '<pre>' . htmlspecialchars(file_get_contents($filePath)) . '</pre>';
            } else {
                echo '<p>File not found: ' . htmlspecialchars($file) . '</p>';
            }
        } else {
            echo '<h2>Select a file to read:</h2>';
            Log_Explorer::listFiles($directory);
        }
        echo '</article>';
    }

    private static function apply_styles(): void {
        echo '<style>
           #log_explorer a {
                color: black;
                text-decoration: none;
                margin-bottom: 10px;
                display: inline-block;
                transition: color 0.3s ease;
            }
            
           #log_explorer a:hover {
                color: grey;
            }

           #log_explorer .home {
                font-weight: 800;
                font-size: 1.5em;
            }
            
           #log_explorer p, #log_explorer h3, #log_explorer h2 {
                color: #4B0082;
            }
                        
            #log_explorer .warning {
               color: darkred;
            }
            #log_explorer .active-dir {
                color: green;
            }
    </style>';
    }

}

}