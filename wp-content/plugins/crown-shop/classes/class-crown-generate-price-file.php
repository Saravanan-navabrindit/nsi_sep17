<?php
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'woocommerce' ) ) return;
if ( ! class_exists( 'WP_Async_Request', false ) ) {
    include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-async-request.php';
}

if ( ! class_exists( 'WP_Background_Process', false ) ) {
    include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-background-process.php';
}

use Automattic\WooCommerce\Enums\ProductStatus;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Generate_Price_File extends WP_Background_Process {

	protected $action = 'generate_price_file';
    protected $user_id = null;
    protected string $filename;
    protected int $row_number;
    protected bool $additional_logs_enabled = false;
    protected string $log_file_name;

    public function __construct() {
        if ( defined('USER_PRICE_FILE_ADDITIONAL_LOGS_ENABLED') ) {
            $this->additional_logs_enabled = USER_PRICE_FILE_ADDITIONAL_LOGS_ENABLED;
        }

        add_filter( 'wp_generate_price_file_default_time_limit', array($this, 'extend_process_time_limit') );

        parent::__construct();
    }

    public function extend_process_time_limit() {
        return 60;
    }

    protected function task( $item ) {
        $products_for_pricefile = $item['products_for_pricefile'];
        $user_id = $item['user_id'];
        $filename = $item['filename'];

        $this->user_id = $user_id;
        $this->filename = $filename;

        $this->prepare_log_file();
        $datetime = date('Y-m-d H:i:s');

        file_put_contents( $this->log_file_name, '[' . $datetime . '] Start task for user: ' . $user_id . PHP_EOL, FILE_APPEND );

        //XLS
        /*$spreadsheet = IOFactory::load( $filename );
        $spreadsheet->setActiveSheetIndex(1);
        $worksheet = $spreadsheet->getActiveSheet();

        foreach( $products_for_pricefile as $product_id ) {
            $this->parse_product_data_for_price_file( $product_id, $user_id, $worksheet );
        }

        $writer = new Xlsx( $spreadsheet );
        $writer->save( $filename );*/

        //CSV
        $fp = fopen( $filename, 'a' );
        foreach( $products_for_pricefile as $product_id ) {
            $this->parse_product_data_for_price_file_csv( $product_id, $user_id, $fp );
        }
        fclose( $fp );

		return false;
	}

    public function update_data_after_file_generation( $user_id, $xls_path ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_price_file_queue';
        $date = date('Y-m-d H:i:s');

        $xls_path_parts = explode( '/', $xls_path );
        $xls_file_name = end( $xls_path_parts );

        $update_query = $wpdb->prepare(
            "UPDATE $table_name SET finished_at = %s, price_file_name = %s WHERE user_id = %d AND finished_at IS NULL",
            $date, $xls_file_name, $user_id
        );
        $wpdb->query( $update_query );
    }

    public function parse_product_data_for_price_file( $prod_id, $user_id, &$sheet1 ) {
        $product = wc_get_product( $prod_id );

        if ( ! $this->is_product_purchasable_for_user( $product, $user_id ) ) {
            return;
        }
        $row_number = $sheet1->getHighestRow();
        $row_number++;

        $pricing_group_name = get_post_meta( $prod_id, 'ns_item_pricing_group_name', true );
        $sheet1->setCellValue( 'A' . $row_number, $pricing_group_name );

        $terms = get_the_terms( $prod_id,  'product_cat' );
        $category = $terms[0]->name ?? '';
        $description = get_post_meta( $prod_id, 'ns_sales_desc', true );
        $sheet1->setCellValue( 'B' . $row_number, $category );
        $sheet1->setCellValue( 'C' . $row_number, $product->get_sku() );
        $sheet1->setCellValue( 'D' . $row_number, $description );

        $regular_price = floatval( $product->get_regular_price() );
        $bbd_eee_price = floatval( $this->get_customer_bbd_eee_price( $regular_price, $product, $user_id ) );
        $customer_price = floatval( Crown_Shop_Customers::filter_wc_get_product_price( $regular_price, $product, $user_id ) );
        $qty_multiplier = get_post_meta( $product->get_id(), 'ns_price_qty_multiplier', true );
        $qty_multiplier = $qty_multiplier > 0 ? floatval( $qty_multiplier ) : 1;

        $sheet1->setCellValue( 'E' . $row_number, $regular_price * $qty_multiplier );
        $sheet1->setCellValue( 'F' . $row_number, $bbd_eee_price * $qty_multiplier );
        $sheet1->setCellValue( 'G' . $row_number, $customer_price * $qty_multiplier );

        $sheet1->setCellValue( 'H' . $row_number, $qty_multiplier );
        $sheet1->setCellValue( 'I' . $row_number, get_post_meta($product->get_id(), 'min_quantity', true) );
        $sheet1->setCellValue( 'J' . $row_number, $regular_price ); //regular price for 1 piece
        $sheet1->setCellValue( 'K' . $row_number, $customer_price ); // customer price per 1 piece

        $product_upc = get_post_meta( $prod_id, 'ns_upc_code', true ); //UPC from netsuite
        if ( empty($product_upc) ) {
            $product_upc = get_post_meta($product->get_id(), 'product_upc', true); //UPC from amplify
        }
        $sheet1->setCellValueExplicit( 'L' . $row_number, $product_upc, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2 ); //fix cell formatting
    }

    public function parse_product_data_for_price_file_csv( $prod_id, $user_id, &$fp ) {
        $product = wc_get_product( $prod_id );

        if ( ! $this->is_product_purchasable_for_user( $product, $user_id ) ) {
            return;
        }

        $row = array();

        $pricing_group_name = get_post_meta( $prod_id, 'ns_item_pricing_group_name', true );
        $row[] = $pricing_group_name;

        $terms = get_the_terms( $prod_id,  'product_cat' );
        $category = $terms[0]->name ?? '';
        $description = get_post_meta( $prod_id, 'ns_sales_desc', true );
        $row[] = $category;
        $row[] = $product->get_sku();
        $row[] = $description;

        $regular_price = floatval( $product->get_regular_price() );
        $bbd_eee_price = floatval( $this->get_customer_bbd_eee_price( $regular_price, $product, $user_id ) );
        $customer_price = floatval( Crown_Shop_Customers::filter_wc_get_product_price( $regular_price, $product, $user_id ) );
        $qty_multiplier = get_post_meta( $product->get_id(), 'ns_price_qty_multiplier', true );
        $qty_multiplier = $qty_multiplier > 0 ? floatval( $qty_multiplier ) : 1;
        $row[] = ($regular_price * $qty_multiplier);
        $row[] = ($bbd_eee_price * $qty_multiplier);
        $row[] = ($customer_price * $qty_multiplier);
        $row[] = $qty_multiplier;
        $row[] = get_post_meta($product->get_id(), 'min_quantity', true);
        $row[] = $regular_price;
        $row[] = $customer_price;

        $product_upc = get_post_meta( $prod_id, 'ns_upc_code', true ); //UPC from netsuite
        if ( empty($product_upc) ) {
            $product_upc = get_post_meta($product->get_id(), 'product_upc', true); //UPC from amplify
        }
        $product_upc_formatted = '="' . $product_upc . '"';

        $row[] = $product_upc_formatted;
        fputcsv( $fp, $row );
        unset( $row );
    }

    public function is_product_purchasable_for_user( $product, $user_id ) {
        $is_purchasable = true;
        if ( ! $this->is_product_purchasable( $product, $user_id ) ) {
            return false;
        }

        $user = get_user_by( 'id', $user_id );
        if ( Crown_Shop_Display::is_product_in_manual_restricted_brands_for_sales_rep_domains_list($product, $user) ||
            ! is_allowed_restricted_product_purchase($is_purchasable, $product, $user_id) ) {
            return false;
        }

        return $is_purchasable;
    }

    public function get_customer_bbd_eee_price( $price, $product, $current_user_id ) {
        $discount_pct = 0;
        $discount_price = null;
        $price_qty_multiplier = 1;

        //1. Get currency ID
        $currency_id = get_user_meta( $current_user_id, 'ns_currency_id', true );
        if ( empty( $currency_id ) ) $currency_id = 1;

        //2. Get pricing levels for product
        $item_pricing_levels = get_post_meta( $product->get_id(), 'ns_pricing_levels', true );
        if ( empty( $item_pricing_levels ) || ! is_array( $item_pricing_levels ) ) {
            $item_pricing_levels = array();
        }

        //3. get price level id for the user
        $price_level_id = intval( get_user_meta( $current_user_id, 'ns_price_level_id', true ) ); //BBD/EEE price level ID = 87

        // adjust price to primary currency
        if ( $currency_id != 1 ) {
            if ( array_key_exists( $currency_id . '_' . $price_level_id, $item_pricing_levels ) ) {
                $price = $item_pricing_levels[ $currency_id . '_'. $price_level_id ]['price_list'][0]['value'];
            } elseif ( array_key_exists( $currency_id . '_1', $item_pricing_levels ) ) {
                $price = $item_pricing_levels[ $currency_id . '_1' ]['price_list'][0]['value'];
            }
        }

        if ( array_key_exists( $currency_id . '_' . $price_level_id, $item_pricing_levels ) ) {
            $price_level = $item_pricing_levels[ $currency_id . '_' . $price_level_id ];
            if ( ! empty( $price_level['discount_pct'] ) && $discount_pct == 0 ) {
                $discount_pct = floatval($price_level['discount_pct'] );
            }
            if ( ! empty( $price_level['price_list'] ) && $discount_price == null ) {
                $current_price = current( $price_level['price_list'] );
                $discount_price = $current_price['value'];
            }
        }

        if ( $discount_price !== null ) {
            return $discount_price * $price_qty_multiplier;
        }

        if ( $discount_pct > 0 ) {
            $discount_pct *= -1;
        }

        return ( floatval( $price ) + ( floatval( $price ) * ( $discount_pct / 100 ) ) ) * $price_qty_multiplier;
    }

    public function is_product_purchasable( $product, $user_id ) {
        if ( $product->exists() && ( $product->get_status() === ProductStatus::PUBLISH || user_can( $user_id, 'edit_post', $product->get_id() ) ) && $product->get_meta('_disable_purchase') != 'yes') {
            return true;
        }
        return false;
    }

    public function is_zero_product_price( $product ) {
        return $product->get_price() == 0;
    }

    public function is_product_restricted( $product ) {
        return $product->get_meta('ns_restricted_item_flag') === 'yes';
    }

    public function is_product_restricted_for_current_user( $product, $user_id ) {
        return $product->get_meta('ns_restricted_item_flag') === 'yes'
            && !(get_user_meta( $user_id, 'ns_allow_restricted_items', true ) === '1');
    }

    public function is_product_manually_allowed( $product, $user_id ) {
        return self::is_product_in_manual_restricted_list( $product ) && self::is_customer_in_manual_allow_list( $user_id );
    }

    public function is_product_in_manual_restricted_list( $product ) {
        return in_array( $product->get_meta('product_brand'), Crown_Shop_Display::$manual_restricted_brands );
    }

    public function is_customer_in_manual_allow_list( $user_id ) {
        return in_array( get_user_meta($user_id, 'ns_division_name', true), Crown_Shop_Display::$manual_allow_restricted_customer_divisions );
    }

    protected function prepare_log_file() {
        $file_dir 		= wp_upload_dir();
        $date 	        = date("Y-m-d");
        $folder_name 	= 'price-files';
        $folder_path 	= $file_dir['basedir'] . '/' . $folder_name;
        $file_name 		= $folder_path . '/generate-pricefile-' . $date . '.log';

        if ( !file_exists($folder_path) ) {
            mkdir( $folder_path, 0755, true );
        }

        if( !file_exists($file_name) ) {
            $log_file = fopen( $file_name, 'w' );
            chmod( $file_name, 0664 );
            fclose( $log_file );
        }

        $this->log_file_name = $file_name;
    }

    protected function send_price_file_email( $user_id, $price_file ) {
        $user = get_user_by( 'id', $user_id );
        $user_email = $user->user_email;

        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_price_file_queue';

        $query = $wpdb->prepare(
            "SELECT * FROM `{$table_name}` WHERE `started_at` IS NOT NULL AND `finished_at` IS NULL AND email_sent IS NULL and user_id = %d",
            $user_id
        );
        $is_user_valid_for_email = $wpdb->get_results( $query );

        if ( empty( $is_user_valid_for_email ) ) {
            return;
        }

        if ( $is_user_valid_for_email[0]->email_address ) {
            $user_email = explode( ',', $is_user_valid_for_email[0]->email_address );
        }

        $email_subject = 'Your price file has been generated';
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo( 'name' ) . ' <' . get_option( 'afrfq_admin_email' ) . '>',
        );

        $pricefile_email = $this->get_pricefile_email_header();
        $pricefile_email .= '<p>Please see attached for your generated price file.</p>';
        $pricefile_email .= $this->get_pricefile_email_footer();

        ob_start();
        wc_get_template( 'emails/email-styles.php' );
        $email_styles = ob_get_clean();

        $pricefile_email_full = '<style type="text/css">' . $email_styles . '</style>' . $pricefile_email;

        $email_attachments[] = $price_file;

        wp_mail( $user_email, $email_subject, $pricefile_email_full, $headers, $email_attachments );

        if ( is_array($user_email) ) {
            $user_email = implode( ',', $user_email );
        }
        file_put_contents( $this->log_file_name, '[' . date('Y-m-d H:i:s') . '] email sent ' . $user_email . ' (user ID: ' . $user->ID . ')' . PHP_EOL, FILE_APPEND );
        file_put_contents( $this->log_file_name, '[' . date('Y-m-d H:i:s') . '] Price file: ' . $price_file . PHP_EOL, FILE_APPEND );

        $update_query = $wpdb->prepare(
            "UPDATE $table_name SET email_sent = 1 WHERE user_id = %d AND started_at IS NOT NULL AND finished_at IS NULL AND email_sent IS NULL",
            $user_id
        );
        $wpdb->query( $update_query );
    }

    protected function get_pricefile_email_header() {
        $img = get_option( 'woocommerce_email_header_image' );
        $email_header = '<!DOCTYPE html>
<html ' . get_language_attributes() . '>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=' . get_bloginfo( 'charset', 'display' ) . '" />
    <title>' . esc_html( get_bloginfo( 'name', 'display' ) ) . '</title>
    <style>
        /* Styles for wrapper */
        #wrapper,
        .quote-wrapper {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            background-color: #f9f9f9;
        }
        /* Styles for container */
        #template_container,
        .quote-template_container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 4px;
            overflow: hidden;
        }
        /* Styles for header */
        #template_header,
        .quote-template_container .quote-template_header {
            text-align: left;
            background-color: #f0f0f0;
            color: black;
            padding: 10px;
            width: 100%;
        }

        #template_header img,
        .quote-template_container .quote-template_header img{
            display: inline-block;
            max-width: 40px;
            margin-right: 16px;
        }

        table#template_header h1,
        table#template_header h1 a,
        .quote-template_container table.quote-template_header h1,
        .quote-template_container table.quote-template_header h1 a {
            color: black;
            display: inline;
            vertical-align: middle;
            font-size: 22px;
        }

        /* Styles for body */
        #template_body,
        .quote-template_container .quote-template_body {
            padding: 20px;
        }

        #template_body #body_content table td,
        .quote-template_container .quote-template_body .quote-body_content table td {
            padding: 0 10px 0;
            min-width: 65px;
        }

        #template_body #body_content table th,
        .quote-template_container .quote-template_body .quote-body_content table th {
            padding: 0 10px 0;
        }

        #template_body #body_content table.quote-contents td,
        .quote-template_container .quote-template_body .quote-body_content table.quote-contents td {
            padding: 10px;
        }

        #template_body #body_content table.quote-contents th,
        .quote-template_container .quote-template_body .quote-body_content table.quote-contents th {
            padding: 12px 12px 12px 10px;
        }

        /* Styles for footer */
        #template_footer,
        .quote-template_container .quote-template_footer {
            background-color: #f0f0f0;
            padding: 20px;
            text-align: center;
        }
        /* Styles for footer text */
        #credit,
        .quote-template_container .quote-template_footer .quote-credit {
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div id="wrapper" class="quote-wrapper">
    <div id="template_container" class="quote-template_container">
        <table id="template_header" class="quote-template_header">
            <tr>'.
            ( $img ? wp_kses_post( '<td style="width: 56px;"><img src="' . esc_url( $img ) . '" alt="' . esc_html( get_bloginfo( 'name', 'display' ) ) . '" /></td>' ) : '' ) .
                '<td>
                    <h1>Price file generated</h1>
                </td>
            </tr>
        </table>
        <div id="template_body" class="quote-template_body">
            <div id="body_content" class="quote-body_content">
                <!-- Content -->
                <div id="body_content_inner" style="text-align: left;">';

        return $email_header;
    }

    protected function get_pricefile_email_footer() {
        $email_footer = '</div>
                    <!-- End Content -->
                    </div>
                </div>
                <div id="template_footer" class="quote-template_footer">
                    <div id="credit" class="quote-credit">' .
                        wp_kses_post( wpautop( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) )
                    . '</div>
                </div>
            </div>
        </div>
    </body>
</html>';

        return $email_footer;
    }

    protected function complete() {
        $datetime = date('Y-m-d H:i:s');
        if ( $this->additional_logs_enabled === true ) {
            file_put_contents( $this->log_file_name, '[' . $datetime . '] PROCESS COMPLETE' . PHP_EOL, FILE_APPEND );
        }
        if ( $this->user_id != null && !$this->is_user_still_in_queue() ) {
            $this->send_price_file_email( $this->user_id, $this->filename );
            $this->update_data_after_file_generation( $this->user_id, $this->filename );
        }

        parent::complete();
    }

    protected function unlock_process() {
        delete_site_transient( $this->identifier . '_process_lock' );

        $datetime = date('Y-m-d H:i:s');
        if ( $this->additional_logs_enabled === true ) {
            file_put_contents( $this->log_file_name, '[' . $datetime . '] PROCESS UNLOCK' . PHP_EOL, FILE_APPEND );
        }
        if ( $this->user_id != null && !$this->is_user_still_in_queue() ) {
            $this->send_price_file_email( $this->user_id, $this->filename );
            $this->update_data_after_file_generation( $this->user_id, $this->filename );
        }

        return $this;
    }

    protected function is_queue_empty()
    {
        if ( $this->user_id != null && !$this->is_user_still_in_queue() ) {
            $this->send_price_file_email( $this->user_id, $this->filename );
            $this->update_data_after_file_generation( $this->user_id, $this->filename );
        }

        return parent::is_queue_empty();
    }

    protected function is_user_still_in_queue() {
        global $wpdb;

        $table = $wpdb->options;
        $column = 'option_name';

        if (is_multisite()) {
            $table = $wpdb->sitemeta;
            $column = 'meta_key';
        }

        $key = $this->identifier . '_batch_%';

        $batches = $wpdb->get_results($wpdb->prepare("
			SELECT option_value
			FROM {$table}
			WHERE {$column} LIKE %s
		", $key));

        $user_still_in_queue = false;
        foreach( $batches as $batch ) {
            $batch_data = unserialize( $batch->option_value );
            $first_batch_arr_key = array_key_first( $batch_data );
            $batch_user_id = $batch_data[$first_batch_arr_key]['user_id'] ?? false;

            if ( $batch_user_id == $this->user_id ) {
                $user_still_in_queue = true;
                break;
            }
        }

        return $user_still_in_queue;
    }
}
