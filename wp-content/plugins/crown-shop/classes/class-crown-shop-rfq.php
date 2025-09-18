<?php

use Crown\AdminPage;
use Crown\Form\Field;
use Crown\Form\FieldGroup;
use Crown\Form\FieldGroupSet;
use Crown\Form\FieldRepeater;
use Crown\Form\FieldRepeaterFlex;
use Crown\Form\Input\CheckboxSet;
use Crown\Form\Input\Media as MediaInput;
use Crown\Form\Input\RadioSet;
use Crown\Form\Input\Select;
use Crown\Form\Input\Date as DateInput;
use Crown\Form\Input\Time as TimeInput;
use Crown\Form\Input\Text as TextInput;
use Crown\Form\Input\Checkbox as CheckboxInput;
use Crown\Form\Input\Color as ColorInput;
use Crown\Form\Input\RichTextarea;
use Crown\Form\Input\Textarea;
use Crown\Form\Input\Gallery as GalleryInput;
use Crown\ListTableColumn;
use Crown\Post\MetaBox;
use Crown\Post\Type as PostType;
use Crown\Post\Taxonomy;
use Crown\Shortcode;
use Crown\UIRule;
use Crown\UserSettings;
use Crown\Exceptions\DuplicatePONumberException;
use Crown\Exceptions\EmptyPONumberException;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


/*
	TODO:
		* Update email template color, add logo
		* Make quote number in email a link to manage that quote in admin
		* Expiration date 30 days from original request
		* Make quote number in email a link to manage that quote on front end
		* Find if there's a way to re-convert to order (multiple orders per quote)
		* Map quote ID to field in Netsuite when converting to order
*/



if ( ! class_exists( 'Crown_Shop_Rfq' ) ) {
	class Crown_Shop_Rfq {

        private const CREATE_QUOTE_URI = '/request-a-quote/';
        private const PO_NUMBER_QOUTE_META_KEY = 'afrfq_field_6453540';
        private const PO_NUMBER_ORDER_META_KEY = 'af_c_f_4432739';
        private const ERROR_MESSAGE_PO_NUMBER_EXISTS = 'This <b>PO number</b> already exists. <br>Please enter a unique number.';
        private const ERROR_MESSAGE_PO_NUMBER_REQUIRED = 'Please enter <b>PO number</b> before converting to order.';
        private const ADMIN_NOTICE_KEY_QOUTE_PO_NUMBER_EXISTS = '_admin_qoute_po_number_exists';
        private const ADMIN_NOTICE_KEY_QOUTE_PO_NUMBER_REQUIRED = '_admin_qoute_po_number_required';

		public static $init = false;

		public static $rfqEmailMappingSettingsPage;
        private static $temporary_files_by_quote = array();
        private static $current_quote_id = null;
        private static $skipped_sku_items = array();
        private static $skipped_group_items = array();

        public static int $afrfq_max_rows_allowed = 200;
        // Separate limit for pricing groups
        private static $afrfq_pricing_max_rows = 50;

		/**
		 * Quotes background export class.
		 *
		 * @var Crown_Quotes_Background_Export
		 */
		protected static $quotes_background_export = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

            if ( defined('AFRFQ_MAX_ROWS_ALLOWED') ) {
                self::$afrfq_max_rows_allowed = AFRFQ_MAX_ROWS_ALLOWED;
            }
			$plugin_file = preg_replace( '/\/classes$/', '', dirname( __FILE__ ) ) . '/plugin.php';
			register_activation_hook( $plugin_file, array( __CLASS__, 'activate' ));
			register_deactivation_hook( $plugin_file, array( __CLASS__, 'deactivate' ));

			add_filter( 'afrfq_admin_email', array( __CLASS__, 'filter_afrfq_admin_email' ), 10, 2 );
			add_filter( 'afrfq_get_user_email', array( __CLASS__, 'filter_afrfq_get_user_email' ), 10, 3 );
			add_filter( 'afrfq_display_field_input', array( __CLASS__, 'filter_afrfq_display_field_input' ), 10, 2 );
			add_action( 'addify_quote_created', array( __CLASS__, 'quote_created' ), 10, 1 );
			add_action( 'addify_discount_quote_created', array( __CLASS__, 'discount_quote_created' ), 10, 1 );
			add_action( 'addify_rfq_quote_status_updated', array( __CLASS__, 'quote_status_updated' ), 10, 3 );

			add_action( 'init', array( __CLASS__, 'init_update_quote_statuses_schedule' ) );
			add_action( 'init', array( __CLASS__, 'init_quote_data_export_schedule' ) );
			add_action( 'crown_update_quote_statuses', array( __CLASS__, 'update_quote_statuses' ) );
			add_action( 'crown_quote_data_export', array( __CLASS__, 'cron_quote_data_export' ) );

			add_action( 'addify_rfq_quote_converted_to_order', array( __CLASS__, 'quote_converted_to_order' ), 10, 2 );

			add_action( 'after_setup_theme', array( __CLASS__, 'register_admin_pages' ) );

			add_filter( 'afrfq_user_rfq_enabled', array( __CLASS__, 'filter_afrfq_user_rfq_enabled' ), 10, 2 );

			add_action( 'parse_request', array( __CLASS__, 'process_rfq_po_number_update' ) );

            add_filter('addify_quote_session_changed', array(__CLASS__, 'filter_afrfq_create_quote'));

            add_action('wp_loaded', array(__CLASS__, 'check_po_number_presence'), 9);
			add_action( 'woocommerce_loaded', array( __CLASS__, 'init_quotes_background_export' ), 1000 );

            add_action( 'pre_get_posts', array( __CLASS__, 'filter_admin_quotes_query' ), 10, 1 );
            add_action('save_post_addify_quote', array(__CLASS__, 'admin_qoute_update'), 9);

            add_action('admin_notices', array(__CLASS__, 'admin_notices'));

			add_action('phpmailer_init', array(__CLASS__, 'attach_pdf_to_email'));

			add_filter('woocommerce_loop_add_to_cart_link', array(__CLASS__, 'remove_add_to_quote_not_purchasable'), 30, 2 );

			add_action('admin_menu', array(__CLASS__, 'init_admin_page_quote_data_extraction'));
			add_action('admin_menu', array(__CLASS__, 'init_admin_page_rfq_notifications'));
			add_action( 'admin_init', array( __CLASS__, 'rfq_notifications_settings_init' ) );
            add_action( 'wp_mail_succeeded', array( __CLASS__, 'cleanup_temporary_files') );
            add_action('wp_footer', array(__CLASS__, 'afrfq_add_import_modal'));
            add_action('wp_footer', array(__CLASS__, 'afrfq_add_import_pricing_modal'));
            add_action('admin_footer', array(__CLASS__, 'afrfq_admin_add_import_modal'));
            add_action('admin_footer', array(__CLASS__, 'afrfq_admin_add_import_pricing_modal'));
            add_action('wp_ajax_afrfq_parse_xls', array(__CLASS__, 'afrfq_process_xls_file_to_quote'));
            add_action('wp_ajax_afrfq_parse_pricing_xls', array(__CLASS__, 'afrfq_process_pricing_xls_file_to_quote'));
            add_action('wp_ajax_import_quote_copypaste', array(__CLASS__, 'import_quote_copypaste'));

            // detail page import hooks
            add_action('wp_footer', array(__CLASS__, 'afrfq_add_import_detail_pricing_modal'));
            add_action('admin_footer', array(__CLASS__, 'afrfq_admin_add_import_detail_pricing_modal'));
            add_action('wp_ajax_afrfq_parse_detail_pricing_xls', array(__CLASS__, 'afrfq_process_detail_pricing_xls_file_to_quote'));
            add_action('wp_ajax_afrfq_import_groups_for_html_preview', array(__CLASS__, 'afrfq_import_groups_for_html_preview'));
            add_action('wp_ajax_nopriv_afrfq_import_groups_for_html_preview', array(__CLASS__, 'afrfq_import_groups_for_html_preview'));

            add_action('admin_notices', [__CLASS__, 'display_admin_error_notice']);
            add_action('wp_ajax_clear_quotes_cart', array(__CLASS__, 'handle_clear_quotes_cart_button'));


            if ( class_exists( 'WP_CLI' ) ) {
				/**
				 * WP_CLI quotes export allows to export quotes data to CSV file.
				 *
				 * Usage:
				 * wp quotes export
				 * wp quotes export --start=2023-09-01 --end=2024-03-26
				 */
				WP_CLI::add_command( 'quotes export', function( $args, $assoc_args ) {
					$start_date = $assoc_args['start'] ?? date('Y-m-d H:i:s', strtotime('-1 week', current_time('timestamp')));
					$end_date = $assoc_args['end'] ?? current_time('mysql');
					self::generate_quotes_report($start_date, $end_date);
				} );

                /**
				 * WP_CLI quotes rebase allows to rebase quotes prices according to chosen base.
				 *
				 * Usage:
				 * wp quotes rebase --base=moq --start=2023-09-01 --end=2024-03-26
				 * wp quotes rebase --base=industry --start=2023-09-01 --end=2024-03-26
				 * wp quotes rebase --base=industry --limit=250 --offset=250
				 * wp quotes rebase --base=industry --ids=123,456
				 * wp quotes rebase --base=moq --excluded=789,2673
				 * wp quotes rebase --base=industry --excluded=789,2673 --recalculate
				 */
				WP_CLI::add_command( 'quotes rebase', function( $args, $assoc_args ) {
					$start_date = $assoc_args['start'] ?? '';
					$end_date = $assoc_args['end'] ?? '';
                    $base = (!empty($assoc_args['base']) && $assoc_args['base'] === 'moq') ? 'moq' : 'industry';
                    $recalculate = isset($assoc_args['recalculate']);
                    $limit = $assoc_args['limit'] ?? '';
                    $offset = $assoc_args['offset'] ?? '';
                    $quote_ids = isset($assoc_args['ids']) ? explode(',', $assoc_args['ids']) : array();
                    $excluded_ids = isset($assoc_args['excluded']) ? explode(',', $assoc_args['excluded']) : array();
                    if ( empty( $quote_ids ) ) {
                        global $wpdb;
                        if( empty( $start_date ) && empty( $end_date ) ) {
                            $query = "SELECT ID id
    					FROM {$wpdb->posts} wp
                        WHERE wp.post_type = 'addify_quote'";
                        } elseif( !empty( $start_date ) && !empty( $end_date ) ) {
                            $query = "SELECT ID id
    					FROM {$wpdb->posts} wp
                        WHERE wp.post_type = 'addify_quote' AND wp.post_date > '{$start_date}' AND wp.post_date < '{$end_date}'";
                        } else {
                            WP_CLI::log( 'Either provide start and end date or don\'t specify both of them.');
                            return;
                        }
                        if (!empty($limit)) {
                            $query .= " LIMIT " . intval($limit);
                            if (!empty($offset)) {
                                $query .= " OFFSET " . intval($offset);
                            }
                        }
                        $quote_ids = $wpdb->get_col($query);
                    }
                    foreach ( $quote_ids as $key => $quote_id ) {
                        if ( in_array( $quote_id, $excluded_ids ) ) {
                            unset( $quote_ids[ $key ] );
                        }
                    }
                    $quote_ids = array_values($quote_ids);
                    $total_count = count($quote_ids);
                    $key = 1;
                    foreach ( $quote_ids as $quote_id ) {
                        $changed = FALSE;
                        $quote_contents = get_post_meta( $quote_id, 'quote_contents', true );
                        $price_base_type = get_post_meta( $quote_id, '_price_base_type', true );
                        if ( !empty($price_base_type) && $price_base_type == $base ) {
                            WP_CLI::log( $key . '/' . $total_count . ' quotes processed.');
                            $key++;
                            continue;
                        } elseif (empty($price_base_type) || $recalculate) {
                            update_post_meta( $quote_id, '_price_base_type', $base );
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
                            $offered_price = isset( $item['offered_price'] ) ? floatval( $item['offered_price'] ) : '';
                            $offered_price_per_each = isset( $item['offered_price_per_each'] ) ? floatval( $item['offered_price_per_each'] ) : '';
                            $approved_price = isset( $item['approved_price'] ) ? floatval( $item['approved_price'] ) : '';
                            $approved_price_per_each = isset( $item['approved_price_per_each'] ) ? floatval( $item['approved_price_per_each'] ) : '';
                            if ( empty( $offered_price) && empty( $approved_price) ) {
                                continue;
                            }

                            $min_qty = intval( get_post_meta( $product_id, 'min_quantity', true ) );
                            $min_qty = $min_qty < 1 ? 1 : $min_qty;
                            $price_qty_multiplier = get_post_meta( $product_id, 'ns_price_qty_multiplier', true );
                            $price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;
                            $price_base_qty = $base === 'moq' ? $min_qty : $price_qty_multiplier;
                            if ( $min_qty == $price_qty_multiplier  || !$recalculate ) {
                                if (empty($offered_price_per_each) && !empty($offered_price)) {
                                    $quote_contents[$item_id]['offered_price_per_each'] = floatval( $offered_price / $price_base_qty );
                                    $changed = TRUE;
                                }
                                if (empty($approved_price_per_each) && !empty($approved_price)) {
                                    $quote_contents[$item_id]['approved_price_per_each'] = floatval( $approved_price / $price_base_qty );
                                    $changed = TRUE;
                                }
                                continue;
                            }
                            if ( !empty( $offered_price) ) {
                                if ( $base === 'industry' ) {
                                    $offered_price_per_each = $offered_price / $min_qty;
                                    $offered_price = $offered_price_per_each * $price_qty_multiplier;
                                } elseif ($base === 'moq') {
                                    $offered_price_per_each = $offered_price / $price_qty_multiplier;
                                    $offered_price = $offered_price_per_each * $min_qty;
                                }
                                $quote_contents[$item_id]['offered_price'] = floatval( $offered_price );
                                $quote_contents[$item_id]['offered_price_per_each'] = floatval( $offered_price_per_each );
                                $changed = TRUE;
                            }

                            if ( !empty( $approved_price ) ) {
                                if ( $base === 'industry' ) {
                                    $approved_price_per_each = $approved_price / $min_qty;
                                    $approved_price = $approved_price_per_each * $price_qty_multiplier;
                                } elseif ($base === 'moq') {
                                    $approved_price_per_each = $approved_price / $price_qty_multiplier;
                                    $approved_price = $approved_price_per_each * $min_qty;
                                }
                                $quote_contents[$item_id]['approved_price'] = floatval( $approved_price );
                                $quote_contents[$item_id]['approved_price_per_each'] = floatval( $approved_price_per_each );
                                $changed = TRUE;
                            }

                        }
                        if ( $changed ) {
                            update_post_meta( $quote_id, 'quote_contents', $quote_contents );
                        }
                        WP_CLI::log( $key . '/' . $total_count . ' quotes processed.');
                        $key++;
                    }

				} );
			}
		}

		public static function attach_pdf_to_email($phpmailer) {
			$available_quote_subjects = array();
			$email_values  = (array) get_option( 'afrfq_emails' );
			foreach ( $email_values as $email_value ) {
				if (!empty($email_value['subject'])) {
					$available_quote_subjects[] = $email_value['subject'];
				}
			}
            $found = false;
            foreach ($available_quote_subjects as $subject) {
				$subject = trim($subject);
				if ($subject === '') continue;
				if (stripos($phpmailer->Subject, $subject) !== false) {
					$found = true;
					break;
				}
			}

			if($found) {
				$file_name = 'quote_status.pdf';
                $attachment_format = 'pdf';

				if (preg_match('/(?:request-quote\/|post=)(\d+)/', $phpmailer->Body, $matches)) {
                    self::$current_quote_id = intval( $matches[1] );
                    if ( ! isset( self::$temporary_files_by_quote[ self::$current_quote_id ] ) ) {
                        self::$temporary_files_by_quote[ self::$current_quote_id ] = array();
                    }
                    $attachment_field_id = self::get_field_by_label('Email attachment format');
                    if (!empty($attachment_field_id)) {
                        $field_name = get_post_meta($attachment_field_id, 'afrfq_field_name', true);
                        $attachment_format = get_post_meta((int)self::$current_quote_id, $field_name, true) ?: $attachment_format;
                    }
					$quote = get_post( self::$current_quote_id );
					if ( is_a( $quote, 'WP_Post' ) ) {
						$file_name = get_the_title(self::$current_quote_id);
                        if (in_array($attachment_format, array('xls', 'pdf and xls'))) {
                            $xls_file_path = self::generate_xls($file_name . '.xlsx');
                            $phpmailer->addAttachment($xls_file_path);
                            self::$temporary_files_by_quote[self::$current_quote_id][] = $xls_file_path;
                        }
					}
				}
                if (in_array($attachment_format, array('pdf', 'pdf and xls'))) {
				    $pdf_file_path = self::generate_pdf($phpmailer->Body, $file_name . '.pdf');
				    $phpmailer->addAttachment($pdf_file_path);
                    self::$temporary_files_by_quote[self::$current_quote_id][] = $pdf_file_path;
                }
			}
		}

		/**
		 * Generate pdf document to attach to email.
		 *
		 * @param string $email_html Email html to be converted to pdf.
		 *
		 * @return string
		 */
		private static function generate_pdf( string $email_html, string $file_name = 'quote_status.pdf') {
			$options = new Options();
			$options->set('isRemoteEnabled', true);

			$dompdf = new Dompdf($options);
			$dompdf->loadHtml($email_html);
			$dompdf->render();

            $temp_dir = get_temp_dir();
            if (!file_exists($temp_dir)) {
                mkdir($temp_dir, 0777, true);
            }
			$pdf_file_path = $temp_dir . $file_name;
			file_put_contents($pdf_file_path, $dompdf->output());

			return $pdf_file_path;
		}

		private static function generate_xls( $file_name = 'quote_status.xlsx') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle( 'Quote_' . self::$current_quote_id );

            $email_values  = (array) get_option( 'afrfq_emails' );
            $quote_status   = get_post_meta( (int) self::$current_quote_id, 'quote_status', true );

            $customer_field_values = self::get_quote_customer_field_values( $email_values, $quote_status );
            $row = 1;
            foreach ( $customer_field_values as $key => $value ) {
                $sheet->setCellValue('A' . $row, $key);
                $sheet->setCellValue('B' . $row, $value);
                $row++;
            }
            $sheet->getStyle('A1:A' . $row )->getFont()->setBold(true);

            $row++;
            $start_table_row = $row;
            $sheet->setCellValue('A' . $row, 'SKU');
            $sheet->setCellValue('B' . $row, 'Product Name');
            $sheet->setCellValue('C' . $row, 'Price');
            if (in_array($quote_status, array('af_accepted', 'af_in_process', 'af_converted'), true)) {
                $sheet->setCellValue('D' . $row, 'Approved Price');
            } else {
                $sheet->setCellValue('D' . $row, 'Requested Price');
            }
            $sheet->setCellValue('E' . $row, 'Industry Standard');
            $sheet->setCellValue('F' . $row, 'Quantity');
            $sheet->setCellValue('G' . $row, 'Subtotal');
            if (in_array($quote_status, array('af_accepted', 'af_in_process', 'af_converted'), true)) {
                $sheet->setCellValue('H' . $row, 'Approved Subtotal');
            } else {
                $sheet->setCellValue('H' . $row, 'Requested Subtotal');
            }
            $sheet->getStyle('A' . $row . ':H' . $row)->getFont()->setBold(true);

            $row++;
            $quote_contents = get_post_meta( (int) self::$current_quote_id, 'quote_contents', true );
            if (!empty($quote_contents) && is_array($quote_contents)) {
                $price_base_type = get_post_meta( (int) self::$current_quote_id, '_price_base_type', true );
                if ( empty($price_base_type) ) {
                    $price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
                }
                self::get_quote_items_table_data($quote_contents, $sheet, $row, $quote_status, $price_base_type);
                $quote_totals = self::get_quote_totals($quote_contents, $quote_status);
                foreach ( $quote_totals as $key => $value ) {
                    $sheet->setCellValue('G' . $row, $key);
                    $sheet->setCellValue('H' . $row, $value);
                    $row++;
                }
            }

            foreach (range('A', 'H') as $column_id) {
                $sheet->getColumnDimension($column_id)->setAutoSize(true);
            }
            $sheet->getStyle('A' . $start_table_row . ':H' . ($row-1) )->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle('A:B' )->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('C:H' )->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            $writer = new Xlsx($spreadsheet);
            $temp_dir = get_temp_dir();
            if (!file_exists($temp_dir)) {
                mkdir($temp_dir, 0777, true);
            }
            $file_path = $temp_dir . $file_name;
            $writer->save($file_path);

			return $file_path;
		}

        public static function get_quote_customer_field_values ($email_values, $quote_status) {
            $status = isset( $email_values[ $quote_status ]['heading'] ) ? $email_values[ $quote_status ]['heading'] : '';
            if (empty($status) && $quote_status === 'af_pending') {
                $status = 'New Quote';
            }
            $customer_field_values = array(
                'Status' => $status,
                'Quote Number' => self::$current_quote_id,
                'Quote Date' => gmdate( 'F j, Y, g:i a', get_post_time( 'U', false, self::$current_quote_id, true ) ),
            );
            $quote_fiels_obj = new AF_R_F_Q_Quote_Fields();
            $quote_fields = (array) $quote_fiels_obj->afrfq_get_fields_enabled();

            if (!empty($quote_fields)) {
                foreach ($quote_fields as $field) {

                    $post_id = $field->ID;

                    $afrfq_field_name = get_post_meta($post_id, 'afrfq_field_name', true);
                    $afrfq_field_type = get_post_meta($post_id, 'afrfq_field_type', true);
                    $afrfq_field_label = get_post_meta($post_id, 'afrfq_field_label', true);
                    $field_data = get_post_meta((int)self::$current_quote_id, $afrfq_field_name, true);

                    if (in_array($afrfq_field_type, array('terms_cond', 'file')) || empty($field_data) || $afrfq_field_label === 'Email attachment format') {
                        continue;
                    }

                    if (is_array($field_data)) {
                        $field_data = implode(', ', $field_data);
                    }

                    if (in_array($afrfq_field_type, array('select', 'radio', 'mutliselect'), true)) {
                        $field_data = ucwords($field_data);
                    }

                    $customer_field_values[$afrfq_field_label] = $field_data;

                }
            }
            return $customer_field_values;
        }

        public static function get_field_by_label( $label = '') {
            $quote_fiels_obj = new AF_R_F_Q_Quote_Fields();
            $quote_fields = (array) $quote_fiels_obj->afrfq_get_fields_enabled();

            foreach ($quote_fields as $key => $field ) {
                $field_id = $field->ID;
                $field_label = get_post_meta($field_id, 'afrfq_field_label', true);

                if ( $label === $field_label ) {
                    return $field_id;
                }
            }
        }

        public static function get_quote_items_table_data($quote_contents, &$sheet, &$row, $quote_status, $price_base_type) {
            foreach ($quote_contents as $item) {
                $product = $item['data'];
                if (!is_object($product)) {
                    continue;
                }
                $price_qty_multiplier = self::get_price_qty_multiplier($price_base_type, $product->get_id());
                $price = empty($item['addons_price']) ? $product->get_price() : $item['addons_price'];
                $price = empty($item['role_base_price']) ? $price : $item['role_base_price'];
                $price = $price * $price_qty_multiplier;
                $offered_price = isset( $item['offered_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $item['offered_price'] ) ) : $price;
                $approved_price = isset( $item['approved_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $item['approved_price'] ) ) : $price;

                $sheet->setCellValue('A' . $row, $product->get_sku());
                $sheet->setCellValue('B' . $row, $product->get_name());
                $sheet->setCellValue('C' . $row, self::get_formatted_price( $price ) );
                if (in_array($quote_status, array('af_accepted', 'af_in_process', 'af_converted'), true)) {
                    $sheet->setCellValue('D' . $row, self::get_formatted_price( $approved_price ) );
                } else {
                    $sheet->setCellValue('D' . $row, self::get_formatted_price( $offered_price ) );
                }
                $sheet->setCellValue('E' . $row, $price_qty_multiplier <= 1 ? 'Each' : 'per ' . $price_qty_multiplier );
                $sheet->setCellValue('F' . $row, $item['quantity']);
                $sheet->setCellValue('G' . $row, self::get_formatted_price( $price * $item['quantity'] / $price_qty_multiplier ) );
                if (in_array($quote_status, array('af_accepted', 'af_in_process', 'af_converted'), true)) {
                    $sheet->setCellValue('H' . $row, self::get_formatted_price( $approved_price * $item['quantity'] / $price_qty_multiplier ) );
                } else {
                    $sheet->setCellValue('H' . $row, self::get_formatted_price( $offered_price * $item['quantity'] / $price_qty_multiplier ) );
                }
                $row++;
            }
        }

        public static function get_quote_totals($quote_contents, $quote_status) {
            $af_quote = new AF_R_F_Q_Quote($quote_contents);
            $totals = $af_quote->get_calculated_totals($quote_contents, self::$current_quote_id);

            $quote_total = isset($totals['_total']) ? $totals['_total'] : 0;
            $offered_total = isset($totals['_offered_total']) ? $totals['_offered_total'] : 0;
            $approved_total = isset($totals['_approved_total']) ? $totals['_approved_total'] : $offered_total;

            $quote_totals = array(
                'Total (Standard)' => self::get_formatted_price( $quote_total ),
            );

            if (in_array($quote_status, array('af_accepted', 'af_in_process', 'af_converted'), true)) {
                $quote_totals['Total (Approved)'] = self::get_formatted_price( $approved_total );
            } else {
                $quote_totals['Total (Requested)'] = self::get_formatted_price( $offered_total );
            }

            return $quote_totals;
        }

        public static function get_formatted_price($price) {
            return html_entity_decode( get_woocommerce_currency_symbol() ) . $price;
        }

        public static function cleanup_temporary_files( $mail_data ) {
            $quote_id = self::$current_quote_id;
            if ( isset( self::$temporary_files_by_quote[ $quote_id ] ) ) {
                foreach ( self::$temporary_files_by_quote[ $quote_id ] as $file ) {
                    if ( file_exists( $file ) ) {
                        unlink( $file );
                    }
                }
                unset( self::$temporary_files_by_quote[ $quote_id ] );
            }

            self::$current_quote_id = null;
        }

		public static function order_exists($customer_id, $po_number) {
            $query = new WC_Order_Query([
                'limit' 		=> -1,
                'orderby' 		=> 'date',
                'order' 		=> 'DESC',
                'customer_id'   => $customer_id,
                'meta_key'      => self::PO_NUMBER_ORDER_META_KEY, 
                'meta_value'    => $po_number,
                'meta_compare'  => '=',
                'return'        => 'ids'
            ]);

            return !empty($query->get_orders());
        }

        public static function admin_qoute_update($quote_id) {
            $user = wp_get_current_user();
            if ( empty( $user) ) {
                return;
            }

            if ( in_array( 'dual_shop_manager', (array) $user->roles, true ) ) {
                $current_user_email = $user->user_email;
                $current_user_email_domain = '';
                if ( preg_match( '/(@[^,;\s]+)/', $current_user_email, $matches ) ) {
                    $current_user_email_domain = $matches[1];
                }
                update_post_meta( $quote_id, '_created_by_dual_shop_manager', true );
                update_post_meta( $quote_id, '_sales_rep_domain', $current_user_email_domain );
            } else {
                $admin_id = isset( $_COOKIE['sac_admin_id'] ) ? $_COOKIE['sac_admin_id'] : 0;
                $admin_user = get_user_by( 'id', $admin_id );
                if (
                    isset( $_SESSION['admin'] ) && 'adminisloggedin' == $_SESSION['admin']
                    && $user->ID != $admin_id && $admin_id != 0
                    && isset( $admin_user->roles[0] ) && $admin_user->roles[0] === 'dual_shop_manager'
                ) {
                    $user_email = $admin_user->user_email;
                    $user_email_domain = '';
                    if ( preg_match( '/(@[^,;\s]+)/', $user_email, $matches ) ) {
                        $user_email_domain = $matches[1];
                    }
                    update_post_meta( $quote_id, '_created_by_dual_shop_manager', true );
                    update_post_meta( $quote_id, '_sales_rep_domain', $user_email_domain );
                }
            }

            $switched_user = Crown_Shop_Display::get_original_switched_user( $user->ID );
            $user_rfq_updated_by = $switched_user && $switched_user instanceof WP_User ? $switched_user->ID : $user->ID;
            update_post_meta( $quote_id, 'rfq_updated_by', $user_rfq_updated_by );

            if (!is_admin()) {
                return;
            }

            $screen = get_current_screen();

            if ($screen->post_type !== 'addify_quote') {
                return;
            }

            $po_number = trim(filter_input(INPUT_POST, self::PO_NUMBER_QOUTE_META_KEY));
            $customer_id = get_post_field('post_author', $quote_id);
            $current_po_number = trim(get_post_meta($quote_id, self::PO_NUMBER_QOUTE_META_KEY, true));
            $current_user_id = get_current_user_id();

            if (
                !empty($po_number) && 
                $po_number !== $current_po_number &&
                self::order_exists($customer_id, $po_number)
            ) {
                set_transient($current_user_id . self::ADMIN_NOTICE_KEY_QOUTE_PO_NUMBER_EXISTS, true, 10);
                wp_safe_redirect(wp_get_referer());
                exit;
            }

            if (isset($_POST['addify_convert_to_order'])) {
                if (empty($po_number)) {
                    set_transient($current_user_id . self::ADMIN_NOTICE_KEY_QOUTE_PO_NUMBER_REQUIRED, true, 10);
                    wp_safe_redirect(wp_get_referer());
                    exit;
                }
            }
        }

        public static function filter_admin_quotes_query($query) {
            if ( ! $query->is_main_query() ) return;
            if ( ! is_admin() ) return;
            if ( basename( $_SERVER['SCRIPT_FILENAME'] ) != 'edit.php' ) return;
            if ( $query->get('post_type') != 'addify_quote' ) return;

            $current_user = wp_get_current_user();
            $roles = ( array ) $current_user->roles;
            if ( ! in_array( 'dual_shop_manager', $roles ) ) return;

            $current_user_email = $current_user->user_email;
            $current_user_email_domain = '';
            if ( preg_match( '/(@[^,;\s]+)/', $current_user_email, $matches ) ) {
                $current_user_email_domain = $matches[1];
            }
            $customer_ids = Crown_Shop_Custom_Roles::get_sales_rep_customer_ids( $current_user_email_domain );

            $queried_customer_user = isset( $_GET['_customer_user'] ) ? intval( $_GET['_customer_user'] ) : 0;
            if ( ! empty( $queried_customer_user ) && in_array( $queried_customer_user, $customer_ids ) ) {
                $customer_ids = array( $queried_customer_user );
            }
            $current_user_id = $current_user->ID;
            $customer_ids[] = $current_user_id;
            if ( ! empty( $customer_ids ) ) {
                $results = Crown_Shop_Custom_Roles::get_dual_shop_managers_allowed_quotes($customer_ids, 'ids', $current_user_email_domain, true);
                if ( empty( $results ) ) {
                    $results = array(0);
                }
                $query->set( 'post__in', $results );

            } else {
                $query->set( 'meta_query', array( array( 'key' => '_customer_user', 'value' => 0 ) ) );
            }
        }

        public static function admin_notices() {
            $current_user_id = get_current_user_id();

            if (get_transient($current_user_id . self::ADMIN_NOTICE_KEY_QOUTE_PO_NUMBER_EXISTS)) {
                echo '<div class="notice notice-error is-dismissible"><p>' . 
                    self::ERROR_MESSAGE_PO_NUMBER_EXISTS . 
                '</p></div>';
                delete_transient(self::ADMIN_NOTICE_KEY_QOUTE_PO_NUMBER_EXISTS);
            }

            if (get_transient($current_user_id . self::ADMIN_NOTICE_KEY_QOUTE_PO_NUMBER_REQUIRED)) {
                echo '<div class="notice notice-error is-dismissible"><p>' . 
                    self::ERROR_MESSAGE_PO_NUMBER_REQUIRED . 
                '</p></div>';
                delete_transient(self::ADMIN_NOTICE_KEY_QOUTE_PO_NUMBER_REQUIRED);
            }
        }

        public static function check_po_number_presence() {
            if (!isset($_POST['addify_convert_to_order_customer'])) {
                return;
            }

            $quote_id = sanitize_text_field(wp_unslash($_POST['addify_convert_to_order_customer']));

            if (empty($quote_id)) {
                return;
            }

            $po_number = get_post_meta($quote_id, self::PO_NUMBER_QOUTE_META_KEY, true);

            if (empty($po_number)) {
                wc_add_notice(self::ERROR_MESSAGE_PO_NUMBER_REQUIRED, 'error');
                wp_safe_redirect($_POST['_wp_http_referer']);
                exit;
            }
        }

        public static function filter_afrfq_create_quote() {
            if (
                isset($_POST['_wp_http_referer']) && 
                $_POST['_wp_http_referer'] === self::CREATE_QUOTE_URI
            ) {
                $po_number = trim(filter_input(INPUT_POST, self::PO_NUMBER_QOUTE_META_KEY));
                $current_user_id = get_current_user_id();

                if (!empty($po_number) && self::order_exists($current_user_id, $po_number)) {
                    wc_add_notice(self::ERROR_MESSAGE_PO_NUMBER_EXISTS, 'error');
                    wp_safe_redirect(self::CREATE_QUOTE_URI);
                    exit;
                }
            }
        }

		public static function activate() {}


		public static function deactivate() {
			wp_clear_scheduled_hook( 'crown_update_quote_statuses' );
		}


		public static function filter_afrfq_admin_email( $email, $quote_id ) {
			$quote_contents = get_post_meta( $quote_id, 'quote_contents', true );
			$quote = new AF_R_F_Q_Quote( $quote_contents );
			$totals = $quote->get_calculated_totals( $quote_contents, $quote_id );
			$offered_total = isset( $totals['_subtotal'] ) ? $totals['_subtotal'] : 0;
			$rfq_custom_money_threshold_rvp = get_option( 'rfq_custom_money_threshold_rvp', 5000 );
			if ( $offered_total >= $rfq_custom_money_threshold_rvp ) {
				$customer_user_id = get_post_meta( $quote_id, '_customer_user', true );
				$contacts = self::get_user_contacts( $customer_user_id );
				if ( ! empty( $contacts ) ) {
					$email .= ', ' . implode( ', ', $contacts );
				}
			}
			$rfq_custom_money_threshold_rsm = get_option( 'rfq_custom_money_threshold_evp', 50000 );
            if ( $offered_total >= $rfq_custom_money_threshold_rsm ) {
				$rfq_extra_recipients = get_option( 'rfq_extra_recipients', 'Tom.wallace@nsiindustries.com' );
				$email .= ', ' . $rfq_extra_recipients;
			}

			return $email;
		}


		public static function filter_afrfq_get_user_email( $email, $quote_id, $billing ) {
			$af_fields_obj = new AF_R_F_Q_Quote_Fields();
			$fields = (array) $af_fields_obj->afrfq_get_fields_enabled();
			foreach ($fields as $key => $field ) {
				$field_id = $field->ID;
				$field_label = get_post_meta( $field_id, 'afrfq_field_label', true );
				if ( $field_label === 'Your Email Address' ) {
					$field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
					$field_value = get_post_meta( $quote_id, $field_name, true );
					if ( !empty( $field_value ) && is_email( $field_value ) ) {
						$email = $field_value;
					}
				}
			}
			return $email;
		}


		public static function filter_afrfq_display_field_input( $display, $field_id ) {
			$field_label = get_post_meta( $field_id, 'afrfq_field_label', true );
			if ( in_array( $field_label, array( 'NSI Notes', 'Expiration Date' ) ) ) {
				$display = false;
			}
			return $display;
		}


		public static function quote_created( $quote_id ) {
            $price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
            add_post_meta( $quote_id, '_price_base_type', $price_base_type );
			$af_fields_obj = new AF_R_F_Q_Quote_Fields();
			$fields = (array) $af_fields_obj->afrfq_get_fields_enabled();
			$nsi_notes_field_name = '';
			foreach ($fields as $key => $field ) {
				$field_id = $field->ID;
				$field_label = get_post_meta( $field_id, 'afrfq_field_label', true );
				if ( $field_label === 'NSI Notes' ) {
					$nsi_notes_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				}
			}

			$quote_contents = get_post_meta( $quote_id, 'quote_contents', true );
			$quote = new AF_R_F_Q_Quote( $quote_contents );
			$totals = $quote->get_calculated_totals( $quote_contents, $quote_id );
			$offered_total = isset( $totals['_subtotal'] ) ? $totals['_subtotal'] : 0;

			$old_status = get_post_meta( $quote_id, 'quote_status', true );
			$new_status = $old_status;

            global $post;

                $min_value_required = 0;
                $context_key = get_current_user_contextual_quote_type_key();
                $quote_type = WC()->session->get( $context_key ) ?: array();
                $quote_type_id = $quote_type['id'];
                if ($quote_type_id) {
                    if ('yes' === get_post_meta($quote_type_id, 'quote_type_min_value_restrictions', true)) {
                        $min_value_required = floatval(get_post_meta($quote_type_id, 'quote_type_min_value_number', true));
                    }
                }
                if ($offered_total < $min_value_required) {
                    $new_status = 'af_declined';
                    $notes = sprintf(
                        'Quote declined due to not meeting the minimum required total of %s.',
                        wc_price($min_value_required)
                    );

                    if (!empty($nsi_notes_field_name)) {
                        update_post_meta($quote_id, $nsi_notes_field_name, $notes);
                    }
                }

			if ( $new_status != $old_status ) {
				update_post_meta( $quote_id, 'old_status', $old_status );
				update_post_meta( $quote_id, 'quote_status', $new_status );
			}

			do_action('addify_rfq_quote_status_updated', $quote_id, $new_status, $old_status );
		}

        public static function discount_quote_created( $quote_id ) {
            $price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
            add_post_meta($quote_id, '_price_base_type', $price_base_type);
        }

        // expiry date update
        public static function quote_status_updated( $quote_id, $new_status, $current_status ) {
            $af_fields_obj = new AF_R_F_Q_Quote_Fields();
            $fields = (array) $af_fields_obj->afrfq_get_fields_enabled();
            $exp_date_field_name = '';

                foreach ( $fields as $field ) {
                $field_label = get_post_meta( $field->ID, 'afrfq_field_label', true );
                if ( $field_label === 'Expiration Date' ) {
                    $exp_date_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
                    break;
                }
            }

            if ( ! empty( $exp_date_field_name ) ) {
                $expiration_date = get_post_meta( $quote_id, $exp_date_field_name, true );

                if ( empty( $expiration_date ) ) {
                    $quote_type_id = get_post_meta( $quote_id, 'quote_type', true );

                    if ( $quote_type_id && 'yes' === get_post_meta( $quote_type_id, 'default_quote_expiry_date', true ) ) {
                        // Save expiry as 31 Dec of current year (Y-m-d format for ACF compatibility)
                        $expiration_date = date( 'Y-m-d', mktime( 0, 0, 0, 12, 31, date( 'Y' ) ) );
                    } else {
                        // Regular logic → created date + option days (still Y-m-d)
                        $create_quote_date     = get_the_date( 'Y-m-d', $quote_id );
                        $expired_to_quote_days = (int) get_field( 'acf_expired_to_quote', 'options' );
                        $expiration_date       = date( 'Y-m-d', strtotime( $create_quote_date . ' + ' . $expired_to_quote_days . ' days' ) );
                    }

                    update_post_meta( $quote_id, $exp_date_field_name, $expiration_date );
                }
            }
            $user = wp_get_current_user();
            $switched_user = Crown_Shop_Display::get_original_switched_user( $user->ID );
            if ( $switched_user && $switched_user instanceof WP_User ) {
                $user = $switched_user;
            }
            if ( ! empty( $user ) && $new_status === 'af_accepted' ) {
                update_post_meta( $quote_id, 'rfq_accepted_by', $user->ID );
                update_post_meta( $quote_id, 'rfq_accepted_date', date( 'Y-m-d H:i:s' ) );
            }
        }

		public static function init_update_quote_statuses_schedule() {
			if ( ! wp_next_scheduled( 'crown_update_quote_statuses' ) ) {
				wp_schedule_event( time(), 'hourly', 'crown_update_quote_statuses' );
			}
		}

		public static function init_quote_data_export_schedule() {
			if ( ! wp_next_scheduled( 'crown_quote_data_export' ) ) {
				$timezone = get_option( 'timezone_string' );
				$next_sync_time = new DateTime( 'now', new DateTimeZone( $timezone ) );
				$next_sync_time->modify( 'next Monday 6am' );
				wp_schedule_event( intval( $next_sync_time->format( 'U' ) ), 'weekly', 'crown_quote_data_export' );
			}
		}

		/**
		 * Updates the expiration date of quotes with empty expiration date.
		 *
		 * @param string $exp_date_field_name The meta field name for the expiration date.
		 * @return void
		 */
		public static function update_quote_expiration_date( $exp_date_field_name ){
			if ( ! class_exists( 'AF_R_F_Q_Quote_Fields' ) ) return;

			$quotes_with_empty_exp_date_ids = get_posts( [
				'post_type' => 'addify_quote',
				'posts_per_page' => -1,
				'fields' => 'ids',
				'meta_query' => [
					'relation' => 'OR',
					[
						'key' => $exp_date_field_name,
						'value' => '',
						'compare' => '='
					],
					[
						'key' => $exp_date_field_name,
						'compare' => 'NOT EXISTS'
					]
				]
			] );

			if ( empty( $quotes_with_empty_exp_date_ids ) ) return;

			foreach ( $quotes_with_empty_exp_date_ids as $quote_id ) {
				$create_quote_date 		= get_the_date( 'Y-m-d', $quote_id );
				$expired_to_quote_days 	= get_field( 'acf_expired_to_quote', 'options' );
				$expiration_date 		= date( 'Y-m-d', strtotime( $create_quote_date . ' + ' . $expired_to_quote_days . ' days' ) );
				
				update_post_meta( $quote_id, $exp_date_field_name, $expiration_date );
			}
		}


		/**
		 * Updates the statuses of quotes in the Crown Shop RFQ class.
		 * This function checks for the existence of the AF_R_F_Q_Quote_Fields class and retrieves the enabled fields.
		 * It then searches for the field with the label "Expiration Date" and retrieves its field name.
		 * If no expiration date field is found, the function returns.
		 * The function updates the expiration date of quotes with empty expiration dates.
		 * It also updates expired accepted quotes to cancelled status.
		 * The function triggers the 'addify_rfq_quote_status_updated' action after updating each quote's status.
		 */
		public static function update_quote_statuses() {
			if ( ! class_exists( 'AF_R_F_Q_Quote_Fields' ) ) return;

			$af_fields_obj = new AF_R_F_Q_Quote_Fields();
			$fields = (array) $af_fields_obj->afrfq_get_fields_enabled();
			$exp_date_field_name = '';
			foreach ($fields as $key => $field ) {
				$field_id = $field->ID;
				$field_label = get_post_meta( $field_id, 'afrfq_field_label', true );
				if ( $field_label === 'Expiration Date' ) {
					$exp_date_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				}
			}

			if ( empty( $exp_date_field_name ) ) return;

			// update expiration date of quotes with empty expiration date
			self::update_quote_expiration_date( $exp_date_field_name );

			// update expired accepted quotes to cancelled
			$accepted_quote_ids = get_posts( array(
				'post_type' => 'addify_quote',
				'posts_per_page' => -1,
				'fields' => 'ids',
				'meta_query' => array(
					array( 'key' => 'quote_status', 'value' => 'af_accepted' ),
					array( 'key' => $exp_date_field_name, 'value' => date( 'Y-m-d' ), 'compare' => '<' )
				)
			) );

			foreach ( $accepted_quote_ids as $quote_id ) {
				update_post_meta( $quote_id, 'old_status', 'af_accepted' );
				update_post_meta( $quote_id, 'quote_status', 'af_expired' );
				self::send_email_to_customer( $quote_id );
			}
		}

		public static function cron_quote_data_export() {
			$start_date = date('Y-m-d H:i:s', strtotime('-1 week', current_time('timestamp')));
			$end_date = current_time('mysql');
			self::generate_quotes_report($start_date, $end_date);
		}
		
		/**
		 * Sends an email to the customer regarding the status of a quote.
		 *
		 * @param int $quote_id The ID of the quote.
		 * @return void
		 */
		public static function send_email_to_customer( $quote_id ) {

			// Email to customer.
			$af_fields_obj = new AF_R_F_Q_Quote_Fields();
			$user_name     = $af_fields_obj->afrfq_get_user_name( $quote_id );
			$user_email    = $af_fields_obj->afrfq_get_user_email( $quote_id, true );
			$quote_status  = get_post_meta( $quote_id, 'quote_status', true );
			$title_quoted  = get_the_title( $quote_id );
	
			$email_subject =  'Your Quote has been transferred to the status Expired.';
			
			if ( ! is_email( $user_email ) ) {
				return;
			}
			$file_name = get_the_title($quote_id) . '.pdf';

			$headers = array(
				'Content-Type: text/html; charset=UTF-8',
				'From: ' . get_bloginfo( 'name' ) . ' <' . get_option( 'afrfq_admin_email' ) . '>',
			);
	
			$customer_email_html = "<p>Hi $user_name, <br> your Quote $title_quoted has been transferred to the status Expired.</p>";
			$customer_email_html .= '<p>Quote ID: ' . $quote_id . '</p>';
			$customer_email_html .= '<p>User Name: ' . $user_name . '</p>';
			$customer_email_html .= '<p>User Email: ' . $user_email . '</p>';
			$customer_email_html .= '<p>Quote Status: ' . $quote_status . '</p>';

			$pdf_file_path = self::generate_pdf($customer_email_html, $file_name);
			$attachments[] = $pdf_file_path;

			wp_mail( $user_email, $email_subject, $customer_email_html, $headers, $attachments );
		}
		


		public static function quote_converted_to_order( $order_id, $quote_id ) {

            $af_checkout = new AF_C_F_Checkout();
			global $post;
            $finalised_checkout_fields = [];
			$checkout_fields = $af_checkout->get_checkout_fields();
            foreach($checkout_fields as $field_id){
                $finalised_checkout_fields[$field_id] = get_the_title($field_id);
            }
        	$order = $order_id ? wc_get_order( $order_id ) : null;

			$af_fields_obj = new AF_R_F_Q_Quote_Fields();
			$fields = (array) $af_fields_obj->afrfq_get_fields_enabled();
			$nsi_notes_field_name = '';
			$po_number_field_name = '';
			$ship_to_company_name_field_name = '';
			$shipping_street_address_1_field_name = '';
			$shipping_street_address_2_field_name = '';
			$shipping_city_field_name = '';
			$shipping_state_field_name = '';
			$shipping_zip_field_name = '';
            $customer_field_name = '';
            $email_field_name = '';
			foreach ($fields as $key => $field ) {
				$field_id = $field->ID;
				$field_label = get_post_meta( $field_id, 'afrfq_field_label', true );
				if ( $field_label === 'NSI Notes' ) {
					$nsi_notes_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'PO Number' ) {
					$po_number_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'Ship to Company Name' ) {
					$ship_to_company_name_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'Address line 1' ) {
					$shipping_street_address_1_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'Address line 2' ) {
					$shipping_street_address_2_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'City' ) {
					$shipping_city_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'State/Province' ) {
					$shipping_state_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'Postcode' ) {
					$shipping_zip_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'Distributor' ) {
                    $customer_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
                } else if ( $field_label === 'Your Email Address' ) {
                    $email_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
                }
			}

			update_post_meta( $order_id, 'converted_quote_id', $quote_id );

			if ( ! empty( $nsi_notes_field_name ) ) {
				$notes = get_post_meta( $quote_id, $nsi_notes_field_name, true );
				update_post_meta( $order_id, 'converted_quote_notes', $notes );
				if ( $order ) $order->set_customer_note( $notes );
			}
			if ( ! empty( $po_number_field_name ) ) {
				$po_number = trim( get_post_meta( $quote_id, $po_number_field_name, true ) );
				update_post_meta( $order_id, 'af_c_f_4432739', $po_number );
			}
			if ( ! empty( $ship_to_company_name_field_name ) ) {
				$ship_to_company_name = get_post_meta( $quote_id, $ship_to_company_name_field_name, true );
				update_post_meta( $order_id, '_ship_to_company_name', $ship_to_company_name );
        	}
			if ( ! empty( $shipping_street_address_1_field_name ) ) {
				$shipping_street_address_1 = get_post_meta( $quote_id, $shipping_street_address_1_field_name, true );
				update_post_meta( $order_id, '_shipping_address_1', $shipping_street_address_1 );
			}
			if ( ! empty( $shipping_street_address_2_field_name ) ) {
				$shipping_street_address_2 = get_post_meta( $quote_id, $shipping_street_address_2_field_name, true );
				update_post_meta( $order_id, '_shipping_address_2', $shipping_street_address_2 );
			}
			if ( ! empty( $shipping_city_field_name ) ) {
				$shipping_city = get_post_meta( $quote_id, $shipping_city_field_name, true );
				update_post_meta( $order_id, '_shipping_city', $shipping_city );
			}
			if ( ! empty( $shipping_state_field_name ) ) {
				$shipping_state = get_post_meta( $quote_id, $shipping_state_field_name, true );
				update_post_meta( $order_id, '_shipping_state', $shipping_state );
			}
			if ( ! empty( $shipping_zip_field_name ) ) {
				$shipping_zip = get_post_meta( $quote_id, $shipping_zip_field_name, true );
				update_post_meta( $order_id, '_shipping_postcode', $shipping_zip );
			}
            if(isset($ship_to_company_name) && !empty($ship_to_company_name)){
                $customer = $ship_to_company_name;
            }else {
                $customer = get_post_meta($quote_id, $customer_field_name, true);
            }
            if (!empty($customer)) {
                update_post_meta($order_id, '_shipping_company', $customer);
                update_post_meta($order_id, '_shipping_first_name', '');
                update_post_meta($order_id, '_shipping_last_name', '');
            }
            foreach($fields as $key => $field){
                $field_id = $field->ID;
				$field_label = get_post_meta( $field_id, 'afrfq_field_label', true );
                if(in_array($field_label, $finalised_checkout_fields)){
                    $custom_field_key = array_search($field_label, $finalised_checkout_fields);
                    $field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
                    $field_value = get_post_meta( $quote_id, $field_name, true );
                    if($field_value){
                        update_post_meta($order_id, 'af_c_f_' . $custom_field_key, $field_value);
                    }
                }
            }
			if ( $order ) {
				// Set to 'on hold' so that to enable NS auto sync.
				$order->set_status( 'on-hold' );
				$order_id = $order->save();
			}

		}

        public static function validate_po_number($customer_id, $po_number) {
                if (!empty($po_number) && self::order_exists($customer_id, $po_number)) {
                    throw new DuplicatePONumberException();
                } else if (empty($po_number))  {
                    throw new EmptyPONumberException() ;
                }
        }

        public static function render_error_exception($error_message, $area) {
            if (is_admin()) {
                set_transient('admin_error_notice', __($error_message, $area), 30);
            } else {
                wc_add_notice(__($error_message, $area), 'error');
            }
        }

        public static function display_admin_error_notice() {
            $error_message = get_transient('admin_error_notice');
            if ($error_message) {
                printf('<div class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html($error_message));
                delete_transient('admin_error_notice');
            }
        }


		public static function register_admin_pages() {

			self::$rfqEmailMappingSettingsPage = new AdminPage( array(
				'key' => 'crown-shop-rfq-email-mapping',
				'parent' => 'options',
				'title' => 'Request for Quote Email Mapping',
				'menuTitle' => 'Quote Email Mapping',
				'fields' => array(
					new FieldRepeater( array(
						'name' => 'csrfq_contacts',
						'addNewLabel' => 'Add Contact',
						'fields' => array(
							new FieldGroup( array(
								'class' => 'no-border two-column small-left',
								'fields' => array(
									new Field( array(
										'label' => 'Email Address',
										'description' => 'Sales manager email address',
										'input' => new TextInput( array( 'name' => 'email' ) )
									) ),
									new Field( array(
										'label' => 'States/Provinces',
										'description' => 'Comma-separated list of state/province abbreviations which this sales manager represents',
										'input' => new TextInput( array( 'name' => 'states' ) )
									) )
								)
							) )
						)
					) )
				)
			) );

		}


		public static function get_user_contacts( $user_id = null ) {
			if ( empty( $user_id ) ) $user_id = get_current_user_id();

			$customer = new WC_Customer( $user_id );
			$rfq_address_preference = get_option('rfq_address_preference', array( 'selected_option' => 'billing' ));
            switch ($rfq_address_preference['selected_option']) {
                case 'both':
                    $billing_state = strtolower( $customer->get_billing_state() );
                    $shipping_state = strtolower( $customer->get_shipping_state() );
                    if ( $billing_state != $shipping_state ) {
                        $state = array( $billing_state, $shipping_state );
                    } else {
                        $state = $billing_state;
                    }
					break;

                case 'shipping':
					$state = strtolower( $customer->get_shipping_state() );
					break;

                case 'billing':
				default:
					$state = strtolower( $customer->get_billing_state() );
					break;
            }

			if ( empty( $state ) ) return array();

			$contacts = get_repeater_entries( 'blog', 'csrfq_contacts' );
			$contacts = array_filter( $contacts, function( $n ) use ( $state ) {
				$contact_states = array_filter( array_map( 'strtolower', array_map( 'trim', explode( ',', $n['states'] ) ) ), function( $m ) { return ! empty( $m ); } );
				if ( is_array( $state ) ) {
                    foreach ($state as $s) {
						if ( in_array( $s, $contact_states ) ) return TRUE;
                    }
                    return FALSE;
                } else {
					return in_array( $state, $contact_states );
                }
			} );
			
			return array_map( function( $n ) { return $n['email']; }, $contacts );

		}


        //todo: replace hardcode with acf fields or options
		public static function filter_afrfq_user_rfq_enabled( $enabled, $user_id ) {
			$enabled = true;

			$allowed_user_ids = array(
                10450, // vitalii.nikitchyn@elekc.com
				10236, // Kari.Pandilidis@nsiindustries.com
				10445, // David.Parker@nsiindustries.com
				10446  // chris.swanson@nsiindustries.com
			);

			$allowed_rep_agent_domains = array(
				'@hawkinssales.com'
			);

			if ( in_array( $user_id, $allowed_user_ids ) ) $enabled = true;

			$admin_id = isset( $_COOKIE['sac_admin_id'] ) ? $_COOKIE['sac_admin_id'] : 0;
			// if ( in_array( $admin_id, $allowed_user_ids ) ) $enabled = true;

			if ( ! $enabled ) {
				$user_data = get_userdata( $user_id );
				$user_email = $user_data->data->user_email;
				$user_email_domain = '';
				if ( preg_match( '/(@[^,;\s]+)/', $user_email, $matches ) ) {
					$user_email_domain = $matches[1];
				}
				if ( in_array( $user_email_domain, $allowed_rep_agent_domains ) ) $enabled = true;
			}

			if ( ! $enabled && $admin_id ) {
				$user_data = get_userdata( $admin_id );
				$user_email = $user_data->data->user_email;
				$user_email_domain = '';
				if ( preg_match( '/(@[^,;\s]+)/', $user_email, $matches ) ) {
					$user_email_domain = $matches[1];
				}
				if ( in_array( $user_email_domain, $allowed_rep_agent_domains ) ) $enabled = true;
			}

			return $enabled;
		}


		public static function process_rfq_po_number_update() {

			$nonce = isset( $_POST['_wpnonce'] ) ? $_POST['_wpnonce'] : null;
			if ( ! wp_verify_nonce( $nonce, 'update-rfq-fields' ) ) return;

			if ( ! isset( $_REQUEST['po_number'] ) ) return;

			$afrfq_id = null;
			if ( preg_match( '/\/my-account\/request-quote\/(\d+)\//', isset( $_REQUEST['_wp_http_referer'] ) ? $_REQUEST['_wp_http_referer'] : '', $matches ) ) {
				$afrfq_id = intval( $matches[1] );
			}
			$quote = get_post( $afrfq_id );
			if ( empty( $afrfq_id ) || ! is_a( $quote, 'WP_Post' ) ) return;

			$po_number = trim( $_REQUEST['po_number'] );
            $ship_to_company_name = $_REQUEST['ship_to_company_name'];
			$shipping_street_address_1 = $_REQUEST['address_line_1'];
			$shipping_street_address_2 = $_REQUEST['address_line_2'];
			$shipping_city = $_REQUEST['city'];
			$shipping_state = $_REQUEST['state_province'];
			$shipping_zip = $_REQUEST['postcode'];
            $customer = $_REQUEST['distributor'];
            $email = $_REQUEST['your_email_address'];
            $customer_shipping_account_number = $_REQUEST['customer_shipping_account_number'];
            $shipping_method = $_REQUEST['shipping_options'];
            $distributor_contact_name = $_REQUEST['distributor_contact_name'];
            $distributor_contact_number_or_email = $_REQUEST['distributor_contact_number_or_email'];

            $current_user_id = get_current_user_id();
            $current_po_number = trim( get_post_meta($quote->ID, self::PO_NUMBER_QOUTE_META_KEY, true) );

            if (
                !empty($po_number) && 
                $po_number !== $current_po_number &&
                self::order_exists($current_user_id, $po_number)
            ) {
                wc_add_notice(self::ERROR_MESSAGE_PO_NUMBER_EXISTS, 'error');
                wp_safe_redirect($_POST['_wp_http_referer']);
                exit;
            }
			
			$af_fields_obj = new AF_R_F_Q_Quote_Fields();
			$fields = (array) $af_fields_obj->afrfq_get_fields_enabled();
			$po_number_field_name = '';
			$ship_to_company_name_field_name = '';
			$shipping_street_address_1_field_name = '';
			$shipping_street_address_2_field_name = '';
			$shipping_city_field_name = '';
			$shipping_state_field_name = '';
			$shipping_zip_field_name = '';
            $customer_field_name = '';
            $email_field_name = '';
            $customer_shipping_account_number_field_name = '';
            $shipping_method_field_name = '';
            $distributor_contact_name_field_name = '';
            $distributor_contact_number_or_email_field_name = '';
			foreach ($fields as $key => $field ) {
				$field_id = $field->ID;
				$field_label = get_post_meta( $field_id, 'afrfq_field_label', true );
				if ( $field_label === 'PO Number' ) {
					$po_number_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'Ship to Company Name' ) {
					$ship_to_company_name_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'Address line 1' ) {
					$shipping_street_address_1_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'Address line 2' ) {
					$shipping_street_address_2_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'City' ) {
					$shipping_city_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'State/Province' ) {
					$shipping_state_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'Postcode' ) {
					$shipping_zip_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
				} else if ( $field_label === 'Distributor' ) {
                    $customer_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
                } else if ( $field_label === 'Your Email Address' ) {
                    $email_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
                } else if ( $field_label === 'Customer Shipping Account Number' ) {
                    $customer_shipping_account_number_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
                } else if ( $field_label === 'Shipping options' ) {
                    $shipping_method_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
                } if ( $field_label === 'Distributor Contact Name' ) {
                    $distributor_contact_name_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
                } else if ( $field_label === 'Distributor Contact Number or Email' ) {
                    $distributor_contact_number_or_email_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
                }
			}

            $fields_to_update = [
                $po_number_field_name => $po_number,
                $ship_to_company_name_field_name => $ship_to_company_name,
                $shipping_street_address_1_field_name => $shipping_street_address_1,
                $shipping_street_address_2_field_name => $shipping_street_address_2,
                $shipping_city_field_name => $shipping_city,
                $shipping_state_field_name => $shipping_state,
                $shipping_zip_field_name => $shipping_zip,
                $customer_field_name => $customer,
                $email_field_name => $email,
                $customer_shipping_account_number_field_name => $customer_shipping_account_number,
                $shipping_method_field_name => $shipping_method,
                $distributor_contact_name_field_name => $distributor_contact_name,
                $distributor_contact_number_or_email_field_name => $distributor_contact_number_or_email,
            ];

            foreach ($fields_to_update as $field_name => $value) {
                self::update_meta_values_from_arqf_fields($field_name, $value, $quote->ID);
            }

		}

        public static function update_meta_values_from_arqf_fields ($field_name, $value, $post_id): void {
            if (!empty($field_name) && !empty($value)) {
                update_post_meta($post_id, $field_name, $value);
            }
        }

		public static function remove_add_to_quote_not_purchasable( $html, $product ) {
			if ( !$product->is_purchasable() ){
				$handeled_html = explode( '<a', $html );
				if ( is_array($handeled_html) && isset($handeled_html[1]) ) {
					$html = '<a' . $handeled_html[1];
				}
			}
			return $html;
		}

		public static function generate_quotes_report($start_date, $end_date) {
			global $wpdb;
		    $quotes = $wpdb->get_results("
    					SELECT ID id
    					FROM {$wpdb->posts} wp
                        WHERE wp.post_type = 'addify_quote' AND wp.post_date > '{$start_date}' AND wp.post_date <= '{$end_date}'
			");
			$date_current = date("Y-m-d-H-i-s");
			foreach ( $quotes as $quote ) {
				self::$quotes_background_export->push_to_queue( array( 'quote_id' => $quote->id, 'date' => $date_current ) );
            }
			self::$quotes_background_export->save()->dispatch();
        }

		public static function init_quotes_background_export() {
			$active_plugins = (array) get_option( 'active_plugins', array() );
			if ( in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins ) ) {
				include( dirname( __FILE__ ) . '/class-crown-quotes-background-export.php' );
				self::$quotes_background_export = new Crown_Quotes_Background_Export();
			}
		}

		/**
		 * Initializes the admin page for quote data extraction.
		 *
		 * This function checks if the current user has access to the quote data extraction feature.
		 * If the user has access, it adds a submenu page under the 'woocommerce' menu.
		 *
		 * @since 1.0.0
		 */
		public static function init_admin_page_quote_data_extraction() {
			$current_user = wp_get_current_user();

			if ( $current_user->exists() ) {
				$email          = $current_user->user_email;
				$access_emails  = self::get_access_emails_to_quote_data_extraction();

				if( in_array( $email, $access_emails ) ) {
					if($_GET['page'] == 'quote_data_extraction' && $_GET['tab'] == 'view_report_files') {
						wp_enqueue_style('datatables-admin-style', '//cdn.datatables.net/2.0.5/css/dataTables.dataTables.css');
						wp_enqueue_style('jquery-ui-admin-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css');				
						wp_enqueue_script('datatables-admin-script', '//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js', array('jquery'), null, true);
						wp_enqueue_script('jquery-ui-admin-script', '//cdn.datatables.net/1.13.7/js/dataTables.jqueryui.min.js', array('jquery'), null, true);
	
						wp_enqueue_script('dataTables-buttons', 'https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js', array('jquery'), null, true);
						wp_enqueue_script('jszip', 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js', array('jquery'), null, true);
						wp_enqueue_script('vfs_fonts', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js', array('jquery'), null, true);
						wp_enqueue_script('buttons-html5', 'https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js', array('jquery'), null, true);
						wp_enqueue_script('buttons-csv', 'https://cdn.datatables.net/buttons/1.7.1/js/buttons.csv.min.js', array('jquery'), null, true);
						wp_enqueue_script('buttons-excel', 'https://cdn.datatables.net/buttons/1.7.1/js/buttons.excel.min.js', array('jquery'), null, true);
						wp_enqueue_script('buttons-colvis', 'https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js', array('jquery'), null, true);
	
	
						$inline_script = 'jQuery(document).ready(function ($) {
							$(".list-report-files").DataTable({
								pageLength: 50,
								fixedHeader: true,
								responsive: true,
								select: true,
								colReorder: true,
								dom: "Bfrtip",
								buttons: [
									{
										extend: "collection",
										text: "Export",
										buttons: ["csvHtml5", "excelHtml5"]
									},
									"colvis",
								],
							});
						});';
					
						wp_add_inline_script('datatables-admin-script', $inline_script);
					}
	
					add_submenu_page(
						'woocommerce',
						'Quote Data Extraction', 
						'Quote Data Extraction', 
						'edit_posts', 
						'quote_data_extraction', 
						array(__CLASS__, 'quote_data_extraction_callback'),
						6
					);
				}
			}
		}

		public static function init_admin_page_rfq_notifications() {
			add_submenu_page(
				'woocommerce',
				'Quote Notifications Settings',
				'Quote Notifications Settings',
				'administrator',
				'rfq-notifications-settings',
				array(__CLASS__, 'rfq_notifications_settings_callback'),
				7
			);
		}

		/**
		 * Retrieves the list of email addresses for users with the 'administrator' role and additional manual email addresses.
		 *
		 * @return array The array of email addresses.
		 */
		public static function get_access_emails_to_quote_data_extraction() {
			$args = array(
				'role__in' => array ('administrator', 'pricing' ),
				'fields'   => 'user_email'
			);

			$user_emails = get_users( $args );

			$manual_emails_with_tab = get_option( 'access_email_users_option' );

			if( !empty( $manual_emails_with_tab ) ) {
				$manual_emails_with_tab = explode( ",", $manual_emails_with_tab );
				$manual_emails_with_tab = array_map( 'trim', $manual_emails_with_tab );
			} else {
				$manual_emails_with_tab = [];
			}
			
			$all_emails = array_merge( $manual_emails_with_tab, $user_emails );
		
			return $all_emails;
		}

		/**
		 * Displays the quote data extraction page and handles the tab navigation.
		 *
		 * This method is responsible for rendering the quote data extraction page and handling the tab navigation.
		 * It checks the 'tab' parameter in the URL to determine the active tab and displays the corresponding content.
		 *
		 * @return void
		 */
		public static function quote_data_extraction_callback() {
			$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab_extractions';
			?>
			<div class="wrap">
				<h1>Quote data extraction</h1>

				<h2 class="nav-tab-wrapper">
					<a href="?page=quote_data_extraction&tab=tab_extractions" 
						class="nav-tab <?= $active_tab == 'tab_extractions' ? 'nav-tab-active' : ''; ?>">
						Extractions
					</a>
					<a href="?page=quote_data_extraction&tab=view_report_files" 
						class="nav-tab <?= $active_tab == 'view_report_files' ? 'nav-tab-active' : ''; ?>">
						View report files
					</a>
					<a href="?page=quote_data_extraction&tab=access_to_extractions" 
						class="nav-tab <?= $active_tab == 'access_to_extractions' ? 'nav-tab-active' : ''; ?>">
						Access to extractions
					</a>
				</h2>

				<?php 
					if ($active_tab == 'tab_extractions'){
						self::content_for_tab_extractions();
					} elseif ($active_tab == 'access_to_extractions') {
						self::content_for_tab_access_to_extractions();
					} elseif ($active_tab == 'view_report_files') {
						self::content_for_tab_view_report_files();
					}
				?>
				
			</div>
			<?php
		}

		public static function rfq_notifications_settings_init(): void {
			add_settings_section(
				'rfq_notifications_settings_section',
				'Main Settings',
				array( __CLASS__, 'rfq_notifications_settings_section_cb' ),
				'rfq-notifications-settings'
			);

			add_settings_field(
				'rfq_custom_money_threshold_rvp',
				'Quote approved value threshold RVP:',
				array( __CLASS__, 'rfq_custom_money_threshold_rvp_field_cb' ),
				'rfq-notifications-settings',
				'rfq_notifications_settings_section'
			);
			register_setting( 'rfq_notifications_settings', 'rfq_custom_money_threshold_rvp' );

			add_settings_field(
				'rfq_address_preference',
				'Quote address preference to use for RVP and RSM state check:',
				array( __CLASS__, 'rfq_address_preference_field_cb' ),
				'rfq-notifications-settings',
				'rfq_notifications_settings_section',
				array(
					'label_for' => 'rfq_address_preference',
					'class' => 'rfq_address_preference',
				)
			);

			register_setting( 'rfq_notifications_settings', 'rfq_address_preference' );

			add_settings_field(
				'rfq_custom_money_threshold_evp',
				'Quote approved value threshold for EVP:',
				array( __CLASS__, 'rfq_custom_money_threshold_rsm_field_cb' ),
				'rfq-notifications-settings',
				'rfq_notifications_settings_section'
			);
			register_setting( 'rfq_notifications_settings', 'rfq_custom_money_threshold_evp' );

			add_settings_field(
				'rfq_extra_recipients',
				'Quote additional recipients:',
				array( __CLASS__, 'rfq_extra_recipients_field_cb' ),
				'rfq-notifications-settings',
				'rfq_notifications_settings_section'
			);
			register_setting( 'rfq_notifications_settings', 'rfq_extra_recipients' );

		}

        public static function rfq_notifications_settings_callback() {
			if ( !defined( 'ABSPATH' ) ) { exit; }

			?>
            <div class="wrap">
                <h2><?php esc_html_e('Quote Notifications Settings'); ?></h2>
                <form method="post" action="options.php">
					<?php
					settings_fields('rfq_notifications_settings');
					do_settings_sections('rfq-notifications-settings');
					submit_button();
					?>
                </form>
            </div>
			<?php
		}

		/**
		 * Renders the content for the tab "Extractions" in the Crown Shop RFQ class.
		 *
		 * This method displays a form with two date inputs for selecting the start and end dates of the extraction.
		 * It also includes a submit button for triggering the data extraction process.
		 * If the form is submitted, it calls the generate_quotes_report method to create the report using the selected dates.
		 *
		 * @return void
		 */
		public static function content_for_tab_extractions() {
			echo '<form method="post" action="">';
				echo '<p>Select Date Start: <input type="date" name="start_extraction" value="' . date( 'Y-m-d', strtotime( '-1 week' ) ) . '"></p>';
				echo '<p>Select Date End: <input type="date" name="end_extraction" value="' . date( 'Y-m-d' ) . '"></p>';
				submit_button( 'Data extraction' );
			echo '</form>';

			if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['start_extraction'] ) && isset( $_POST['end_extraction'] ) ) {
                $start_date_time = $_POST['start_extraction'] . ' 00:00:00';
                $end_date_time = $_POST['end_extraction'] . ' 23:59:59';
				// Create the report
				self::generate_quotes_report( $start_date_time, $end_date_time );
			}
			
			// Display the list of files in the folder
			$files = self::get_reports_csv_files();

			echo '<div class="reports-files-quote">';

				if(!empty($files)){
					echo '<h2>Reports</h2>';
					echo '<ul>';
					foreach($files as $file) {
						$file_name = basename($file);
						$file_url = $file_dir['baseurl'] . '/' . $folder_name . '/' . $file_name;
						echo '<li>' . $key + 1 . '] <a href="/wp-admin/admin.php?page=quote_data_extraction&tab=view_report_files" title="View">' . $file_name . '</a> - [ ' . date('Y-m-d H:i:s', filectime($file)) . ' ]<br><hr></li>';
					}
					echo '</ul>';
				} else {
					echo '<p>No reports available</p>';
				}

			echo '</div>';
		}

		/**
		 * Retrieves an array of CSV files in the reports folder.
		 *
		 * @return array An array of CSV file paths.
		 */
		public static function get_reports_csv_files() {
			$folder_path = defined('CROWN_QUOTE_EXPORT_FOLDER_PATH') ? CROWN_QUOTE_EXPORT_FOLDER_PATH : '/opt/bitnami/quote-reports/';
			// $file_dir       = wp_upload_dir();
			// $folder_name    = 'reports';
			// $folder_path    = $file_dir['basedir'] . '/' . $folder_name;

			// Get all files in the folder
			$files = glob( $folder_path . '/*' );

			// Exclude . and .. directories
			$files = array_diff( $files, array('.', '..') );

			usort( $files, function( $a, $b ) {
				return filemtime( $b ) - filemtime( $a );
			});

			return $files;
		}

		/**
		 * Renders the content for the "Access to Extractions" tab in the Crown Shop RFQ class.
		 * This page is available to all users with the administrator role, as well as to those users who are listed in the "access_email_users_option" option.
		 * Users can enter a list of email addresses in the "access-email-users" textarea and save them using the "Save emails" button.
		 * The entered email addresses are then sanitized and saved in the "access_email_users_option" option.
		 *
		 * @return void
		 */
		public static function content_for_tab_access_to_extractions() {
			echo "<p>This page is available to all users with the administrator role, as well as to those users who are listed in this field:</p>";
			
			$emails = get_option( 'access_email_users_option' );

			if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['access-email-users'] ) ) {
				$emails = sanitize_textarea_field( $_POST['access-email-users'] );
				$emails = str_replace( ' ', '', $emails );

				update_option( 'access_email_users_option', $emails );
			}

			$emails = get_option( 'access_email_users_option' );

			echo '<form method="post" action="">';
				echo '<p>Email users: <textarea id="access_email_users" name="access-email-users" rows="4" cols="50">' . $emails . '</textarea></p>';
				submit_button( 'Save emails' );
			echo '</form>';

		}

		public static function content_for_tab_view_report_files() {
			// Display the list of files in the folder
			$files = self::get_reports_csv_files();

			echo '<form method="post" action="">';
				echo '<p>Select report file: <select id="view_file" name="view-file">';
					foreach( $files as $file ) {
						$file_name = basename( $file );
						echo '<option value="' . $file_name . '">' . $file_name . '</option>';
					}
				echo '</select></p>';
				submit_button( 'View file' );
			echo '</form>';

			if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['view-file'] ) ) {

				$path_folder = defined('CROWN_QUOTE_EXPORT_FOLDER_PATH') ? CROWN_QUOTE_EXPORT_FOLDER_PATH : '/opt/bitnami/quote-reports/';
				$file_path = $path_folder . $_POST['view-file'];

				// $file_name = sanitize_text_field( $_POST['view-file'] );
				// $file_dir = wp_upload_dir();
				// $folder_name = 'reports';
				// $file_path = $file_dir['basedir'] . '/' . $folder_name . '/' . $file_name;
	
				if ( file_exists( $file_path ) ) {
					$file = fopen( $file_path, 'r' );

					while ( ( $line = fgetcsv( $file ) ) !== FALSE) {
						$csv_data[] = $line;
					}
					
					fclose($file);

					$thead = $csv_data[0];

					// Remove the first element of the array
					array_shift($csv_data);

					echo '<table class="list-report-files display hover compact" style="width:100%">';
						echo '<thead>';
							echo '<tr>';
							foreach ( $thead as $cell ) {
								echo '<th>' . htmlspecialchars( $cell ) . '</th>';
							}
							echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
						foreach ( $csv_data as $row ) {
							echo '<tr>';
							for ($i = 0; $i < count($thead); $i++) {
                                if ( DateTime::createFromFormat('n/j/y g:i a', $row[$i]) !== false ) {
								    echo '<td data-sort="' . strtotime($row[$i]) . '">' . htmlspecialchars($row[$i]) . '</td>';
                                } else {
                                    echo '<td>' . htmlspecialchars($row[$i] ?? '') . '</td>';
                                }
							}
							echo '</tr>';
						}
						echo '</tbody>';
					echo '</table>';
				}
			}
		}

        public static function rfq_notifications_settings_section_cb() {
			echo '<p>Specify custom settings for quotes notifications.</p>';
        }

        public static function rfq_custom_money_threshold_rvp_field_cb() {
			$rfq_custom_money_threshold_rvp = get_option( 'rfq_custom_money_threshold_rvp', 5000 );
			$rfq_custom_money_threshold_rvp = esc_attr( $rfq_custom_money_threshold_rvp );

			echo '<div class="custom-settings-rfq-custom-money-threshold">';
			echo "<input type='number' name='rfq_custom_money_threshold_rvp' value='$rfq_custom_money_threshold_rvp' />";
			echo '</div>';
        }

        public static function rfq_custom_money_threshold_rsm_field_cb() {
			$rfq_custom_money_threshold_rsm = get_option( 'rfq_custom_money_threshold_evp', 50000 );
			$rfq_custom_money_threshold_rsm = esc_attr( $rfq_custom_money_threshold_rsm );

			echo '<div class="custom-settings-rfq-custom-money-threshold">';
			echo "<input type='number' name='rfq_custom_money_threshold_evp' value='$rfq_custom_money_threshold_rsm' />";
			echo '</div>';
        }

        public static function rfq_extra_recipients_field_cb() {
			$rfq_extra_recipients = get_option( 'rfq_extra_recipients', 'Tom.wallace@nsiindustries.com' );
			$rfq_extra_recipients = esc_textarea( $rfq_extra_recipients );

			echo '<div class="custom-settings-rfq-extra-recipients">';
			echo "<textarea name='rfq_extra_recipients' rows='5' cols='50' data-textarea-mode='text'>$rfq_extra_recipients</textarea>";
			echo '</div>';
        }

        public static function rfq_address_preference_field_cb() {
			$rfq_address_preference = get_option('rfq_address_preference', array( 'selected_option' => 'billing' ));
			?>
            <label for="rfq_address_preference_billing">
                <input type="radio" id="rfq_address_preference_billing" name="rfq_address_preference[selected_option]" value="billing" <?php checked('billing', $rfq_address_preference['selected_option']); ?> />
                Billing address
            </label><br />
            <label for="rfq_address_preference_shipping">
                <input type="radio" id="rfq_address_preference_shipping" name="rfq_address_preference[selected_option]" value="shipping" <?php checked('shipping', $rfq_address_preference['selected_option']); ?> />
                Shipping address
            </label><br />
            <label for="rfq_address_preference_both">
                <input type="radio" id="rfq_address_preference_both" name="rfq_address_preference[selected_option]" value="both" <?php checked('both', $rfq_address_preference['selected_option']); ?> />
                Check both addresses
            </label>
			<?php
        }

        public static function afrfq_add_import_modal() {
            if ( is_page('request-a-quote') ) {
                echo self::afrfq_admin_add_import_modal_render();
            }
        }

        public static function afrfq_admin_add_import_modal() {
            if ( is_admin() ) {
                global $post;
                if (isset($_GET['post_type']) && $_GET['post_type'] === 'addify_quote') {
                    echo self::afrfq_admin_add_import_modal_render($post->ID);
                } elseif (isset($_GET['post']) && get_post_type($_GET['post']) === 'addify_quote') {
                    echo self::afrfq_admin_add_import_modal_render($post->ID, 'edit');
                }
            }
        }

        public static function afrfq_admin_add_import_modal_render($post_id = 0, $type = '') {
            ob_start();
            ?>
            <div id="afrfq_import_modal" class="afrfq-modal" style="display: none;">
                <div class="afrfq-modal-content">
                    <span class="afrfq-close">&times;</span>
                    <h3><?php echo 'Import Product List from XLS'; ?></h3>

                    <form id="afrfq_import_form" enctype="multipart/form-data">
                        <label for="import_xls_file"><?php echo 'Choose file'; ?></label>
                        <input type="file" id="import_xls_file" name="import_xls_file" accept=".xls,.xlsx">
                        <button type="button" id="afrfq_parse_btn" <?php if ( !empty($post_id) ) echo('value="' . intval( $post_id ) . '"'); ?> <?php if ( !empty($type) ) echo('data-type="' . $type . '"'); ?> class="button"><?php echo 'Start Import'; ?></button>
                    </form>

                    <div id="afrfq_import_status" style="display: none;"></div>
                </div>
            </div>
            <?php
            $quote_modal = ob_get_clean();
            return $quote_modal;
        }

        //import pricing group list popup modal
        public static function afrfq_add_import_pricing_modal() {
            if ( is_page('request-a-quote') ) {
                echo self::afrfq_admin_add_import_pricing_modal_render();
            }
        }

        public static function afrfq_admin_add_import_pricing_modal() {
            if ( is_admin() ) {
                global $post;
                if (isset($_GET['post_type']) && $_GET['post_type'] === 'addify_quote') {
                    echo self::afrfq_admin_add_import_pricing_modal_render($post->ID);
                } elseif (isset($_GET['post']) && get_post_type($_GET['post']) === 'addify_quote') {
                    echo self::afrfq_admin_add_import_pricing_modal_render($post->ID, 'edit');
                }
            }
        }

        public static function afrfq_admin_add_import_pricing_modal_render($post_id = 0, $type = '') {
            ob_start();
            ?>
            <div id="afrfq_pricing_import_modal" class="afrfq-modal" style="display: none;">
                <div class="afrfq-modal-content">
                    <span class="afrfq-close">&times;</span>
                    <h3><?php echo 'Import Pricing Group List from XLS'; ?></h3>

                    <form id="afrfq_pricing_import_form" enctype="multipart/form-data">
                        <label for="import_pricing_xls_file"><?php echo 'Choose file'; ?></label>
                        <input type="file" id="import_pricing_xls_file" name="import_pricing_xls_file" accept=".xls,.xlsx">
                        <button type="button" id="afrfq_pricing_parse_btn"
                            <?php if ( !empty($post_id) ) echo('value="' . intval( $post_id ) . '"'); ?>
                            <?php if ( !empty($type) ) echo('data-type="' . $type . '"'); ?>
                            class="button">
                            <?php echo 'Start Import'; ?>
                        </button>
                    </form>

                    <div id="afrfq_pricing_import_status" style="display: none;"></div>
                </div>
            </div>
            <?php
            $pricing_modal = ob_get_clean();
            return $pricing_modal;
        }

        //import detail page pricing group list popup modal
        public static function afrfq_add_import_detail_pricing_modal() {
            if ( is_singular('addify_quote') && !is_admin() ) {
                global $post;
                echo self::afrfq_admin_add_import_detail_pricing_modal_render($post->ID, 'profile');
            }
            if ( is_page('request-a-quote') ) {
                echo self::afrfq_admin_add_import_detail_pricing_modal_render();
            } else {
                echo self::afrfq_admin_add_import_detail_pricing_modal_render();
            }
        }

        public static function afrfq_admin_add_import_detail_pricing_modal() {
            if ( is_admin() ) {
                global $post;
                if (isset($_GET['post_type']) && $_GET['post_type'] === 'addify_quote') {
                    echo self::afrfq_admin_add_import_detail_pricing_modal_render($post->ID);
                } elseif (isset($_GET['post']) && get_post_type($_GET['post']) === 'addify_quote') {
                    echo self::afrfq_admin_add_import_detail_pricing_modal_render($post->ID, 'edit');
                }
            }
        }

        public static function afrfq_admin_add_import_detail_pricing_modal_render($post_id = 0, $type = '') {
            ob_start();

            if ( 'profile' === $type ) {
                $nonce_name  = 'afrfq-profile-quote';
                $context_type = 'profile';
            } else {
                $nonce_name  = 'afquote-ajax-nonce';
                $context_type = 'edit';
            }

            $nonce_value = wp_create_nonce( $nonce_name );
            ?>
            <div id="afrfq_detail_pricing_import_modal" class="afrfq-modal" style="display: none;">
                <div class="afrfq-modal-content">
                    <span class="afrfq-close">&times;</span>
                    <h3><?php echo 'Import Pricing Group List from XLS'; ?></h3>
                    <form id="afrfq_pricing_import_form" enctype="multipart/form-data">
                        <label for="import_pricing_xls_file"><?php echo 'Choose file'; ?></label>
                        <input type="file" id="import_pricing_xls_file" name="import_pricing_xls_file" accept=".xls,.xlsx">
                        <button type="button" id="afrfq_detail_pricing_parse_btn"
                            value="<?php echo intval( $post_id ); ?>"
                            data-type="<?php echo esc_attr( $context_type ); ?>"
                            data-nonce="<?php echo esc_attr( $nonce_value ); ?>"
                            class="button">
                            <?php echo 'Start Import'; ?>
                        </button>
                    </form>
                    <div id="afrfq_pricing_import_status" style="display: none;"></div>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }

        public static function afrfq_import_groups_for_html_preview() {
            if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
                $nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
            } else {
                $nonce = 0;
            }
            $nonce_name = (isset( $_POST['type'] ) && 'profile' === $_POST['type']) ? 'afrfq-profile-quote' : 'afquote-ajax-nonce';
            if ( ! wp_verify_nonce( $nonce, $nonce_name ) ) {
                wp_send_json_error( array( 'message' => 'Failed ajax security check!' ) );
            }

            if ( isset( $_POST['form_data'] ) ) {
                parse_str( wp_unslash( $_POST['form_data'] ), $form_data );
            } else {
                $form_data = array();
            }
            $current_groups = $form_data['pricing_groups'] ?? array();

            if ( empty( $_FILES['import_file']['tmp_name'] ) ) {
                wp_send_json_error( array( 'message' => 'No file was provided.' ) );
            }

            $file = $_FILES['import_file'];
            $file_type = wp_check_filetype( $file['name'] );

            if ( ! in_array( $file_type['ext'], array( 'xls', 'xlsx' ), true ) ) {
                wp_send_json_error( array( 'message' => 'Invalid file format. Only XLS or XLSX files are allowed.' ) );
            }

            $warning_messages = array();
            $parsed_data = self::afrfq_parse_pricing_xls( $file['tmp_name'], $warning_messages );

            if ( ! is_array($parsed_data) ) {
                wp_send_json_error( array( 'message' => 'The file could not be parsed.', 'warnings' => $warning_messages ) );
            }

            global $wpdb;
            $new_groups_added_count = 0;
            $existing_group_names   = !empty($current_groups) ? array_column( $current_groups, 'group_name' ) : array();

            foreach ( $parsed_data as $row ) {
                if ( empty( $row['product pricing group'] ) ) {
                    continue;
                }
                $group_name_from_file = sanitize_text_field( $row['product pricing group'] );
                if ( in_array( $group_name_from_file, $existing_group_names, true ) ) {
                    $warning_messages[] = 'Skipped duplicate group: ' . esc_html($group_name_from_file);
                    continue;
                }

                $new_group_details = $wpdb->get_row( $wpdb->prepare(
                    "SELECT id, group_name, price_name FROM {$wpdb->prefix}ns_groups_pricings WHERE group_name = %s",
                    $group_name_from_file
                ) );

                if ( $new_group_details ) {
                    $group_id_to_add = $new_group_details->id;
                    $group_key       = 'group_' . $group_id_to_add;

                    $current_groups[ $group_key ] = array(
                        'group_id'   => $group_id_to_add,
                        'ns_group_id'=> $group_id_to_add,
                        'group_name' => $new_group_details->group_name,
                        'price_name' => $new_group_details->price_name,
                    );
                    $existing_group_names[] = $new_group_details->group_name;
                    $new_groups_added_count++;
                } else {
                    $warning_messages[] = 'Group not found in database: ' . esc_html($group_name_from_file);
                }
            }

            ob_start();

            if ( ! empty( $current_groups ) ) {
                foreach ( $current_groups as $group_id_key => $group_data ) {
                    ?>
                    <tr class="woocommerce-cart-form__quote-item cart_item" data-group-key="<?php echo esc_attr( $group_id_key ); ?>">
                        <td class="product-remove">
                            <a href="#" class="remove remove-pricing-group" aria-label="<?php esc_attr_e( 'Remove this item', 'addify_rfq' ); ?>" data-group-key="<?php echo esc_attr( $group_id_key ); ?>">&times;</a>
                        </td>
                        <td class="product-name" data-title="<?php esc_attr_e( 'Product Pricing Group', 'addify_rfq' ); ?>">
                            <?php echo esc_html( $group_data['group_name'] ); ?>
                        </td>
                        <td class="product-price" data-title="<?php esc_attr_e( 'Discount Level', 'addify_rfq' ); ?>">
                            <?php echo esc_html( $group_data['price_name'] ); ?>
                        </td>

                        <input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][group_name]" value="<?php echo esc_attr( $group_data['group_name'] ); ?>">
                        <input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][price_name]" value="<?php echo esc_attr( $group_data['price_name'] ); ?>">
                        <input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][group_id]" value="<?php echo esc_attr( $group_data['group_id'] ); ?>">
                        <input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][ns_group_id]" value="<?php echo esc_attr( $group_data['ns_group_id'] ); ?>">
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr class="quote-empty-pricing-groups">
                    <td colspan="3"><?php esc_html_e( 'No pricing groups have been added to this quote yet.', 'addify_rfq' ); ?></td>
                </tr>
                <?php
            }

            $all_rows_html = ob_get_clean();

            wp_send_json_success( array(
                'quote_details_table' => $all_rows_html,
                'message'             => sprintf( 'Import complete. Added %d new pricing group(s).', $new_groups_added_count ),
                'warnings'            => $warning_messages,
            ) );
        }

        public static function afrfq_process_xls_file_to_quote() {
            if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'afrfq_import_nonce')) {
                wp_send_json_error(array('message' => 'Nonce verification failed.', 'code' => 'nonce_error'));
            }
            $is_profile = isset($_POST['is_profile']) && $_POST['is_profile'] == 'true';
            $is_admin = isset($_POST['is_admin']) && $_POST['is_admin'] == 'true';
            $warning_messages = array();
            $file = isset($_FILES['import_xls_file']) ? $_FILES['import_xls_file'] : null;
            if (!$file || empty($file['name'])) {
                wp_send_json_error(array('message' => 'No file uploaded.', 'code' => 'no_file_error'));
            }

            $tmp_file_path = $file['tmp_name'];
            $file_type = wp_check_filetype($file['name']);
            if (!in_array($file_type['ext'], array('xls', 'xlsx'))) {
                wp_send_json_error(array('message' => 'Invalid file type. Please upload a valid XLS or XLSX file.', 'code' => 'invalid_file_type'));
            }

            $tmp_file_path = $_FILES['import_xls_file']['tmp_name'];

            if (!$tmp_file_path) {
                wp_send_json_error(array('message' => 'Failed to access uploaded file.', 'code' => 'file_access_error'));
            }

            $parsed_quote_data = self::afrfq_parse_xls($tmp_file_path, $warning_messages);

            if (empty($parsed_quote_data)) {
                wp_send_json_error(array('message' => 'Failed to parse the file data.', 'code' => 'file_parsing_error'));
            }

            $current_product_ids = array();
            $post_id    = isset( $_POST['post_id'] ) ? intval( wp_unslash( $_POST['post_id'] ) ) : 0;
            if ($post_id) {
                // Need this to be not empty array to not fetch quote data from session when creating quote from admin panel.
                $quote_contents = get_post_meta( $post_id, 'quote_contents', true ) ?: array('');
                $price_base_type = get_post_meta( $post_id, '_price_base_type', true );
                if ( $is_profile || $is_admin ) {
                    if ( isset( $_POST['form_data'] ) ) {
                        parse_str( sanitize_meta('', wp_unslash( $_POST['form_data'] ), '' ), $form_data );
                    } else {
                        $form_data = '';
                    }

                    foreach ( $quote_contents ?? [] as $quote_item_key => $quote_content ) {
                        if ( !isset($form_data['quote_qty'][$quote_item_key]) ) {
                            unset($quote_contents[$quote_item_key]);
                        }
                    }

                    $af_quote = new AF_R_F_Q_Quote( $quote_contents );
                    if ( empty($quote_contents) && !empty($af_quote->quote_contents) ) {
                        $af_quote->quote_contents = array();
                    }

                    foreach ( $form_data['quote_qty'] ?? [] as $quote_item_key => $value ) {
                        if ( !isset($quote_contents[$quote_item_key]) ) {
                            $quote_contents = $af_quote->add_to_quote(
                                $form_data,
                                $form_data['added_product_id'][$quote_item_key],
                                $form_data['quote_qty'][$quote_item_key],
                                0, array(), array(), true
                            );
                        }
                    }
                }
            } else {
                $quote_contents = WC()->session->get( 'quotes' ) ?: array();
            }
            if ( empty($price_base_type) ) {
                $price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
            }

            if ( isset($form_data) && !empty($form_data) ) {
                foreach ( $quote_contents as $quote_item_key => $quote_item ) {
                    $product = apply_filters( 'addify_quote_item_product', $quote_item['data'], $quote_item, $quote_item_key );
                    if ( $price_base_type === 'moq' ) {
                        $quote_price_base = intval(get_post_meta($product->get_id(), 'min_quantity', true));
                        $quote_price_base = $quote_price_base < 1 ? 1 : $quote_price_base;
                    } else {
                        $quote_price_base = get_post_meta($product->get_id(), 'ns_price_qty_multiplier', true);
                        $quote_price_base = floatval($quote_price_base) > 0 ? floatval($quote_price_base) : 1;
                    }

                    if ( isset( $form_data['offered_price'][ $quote_item_key ] ) ) {
                        $offered_price = floatval( $form_data['offered_price'][ $quote_item_key ]);
                        $quote_contents[ $quote_item_key ]['offered_price'] = number_format( $offered_price, 2 );
                        $quote_contents[ $quote_item_key ]['offered_price_per_each'] = $offered_price /  $quote_price_base;
                    }

                    if ( isset( $form_data['approved_price'][ $quote_item_key ] ) ) {
                        $approved_price = floatval( $form_data['approved_price'][ $quote_item_key ]);
                        $quote_contents[ $quote_item_key ]['approved_price'] = number_format( $approved_price, 2 );
                        $quote_contents[ $quote_item_key ]['approved_price_per_each'] = $approved_price /  $quote_price_base;
                    }

                    if ( isset( $form_data['quote_qty'][ $quote_item_key ] ) ) {
                        $quote_contents[ $quote_item_key ]['quantity'] = $form_data['quote_qty'][ $quote_item_key ];
                    }
                }
            }

            foreach ( $quote_contents as $quote_item_key => $quote_item ) {
                if (  isset( $quote_item['data'] ) && is_object( $quote_item['data'] ) ) {
                    $current_product_ids[] = apply_filters( 'addify_quote_item_product_id', $quote_item['product_id'], $quote_item, $quote_item_key );
                }
            }

            $imported_count = 0;
            $line_items_count = count($quote_contents);
            $imported_skus = [];
            $imported_quote_keys = [];
            foreach ($parsed_quote_data as $item) {
                if ( $line_items_count + $imported_count >= self::$afrfq_max_rows_allowed ) {
                    break;
                }
                $sku = isset($item['sku']) ? sanitize_text_field(wp_unslash($item['sku'])) : '';
                $offered_price = $item['offered_price'];
                $quantity = $item['quantity'];
                $product_id = wc_get_product_id_by_sku($sku);
                $product       = wc_get_product($product_id);

                $current_user = wp_get_current_user();
                $allowed_roles = [ 'shop_manager', 'dual_shop_manager' ];
                $context_key = get_current_user_contextual_quote_type_key();
                $selected_quote_type = WC()->session->get($context_key);

                $selected_quote_type_id = 0;
                $user_selected_quote_type = get_user_meta(get_current_user_id(), $context_key);
                $session_selected_quote_type = WC()->session->get( $context_key );
                if(!null == $user_selected_quote_type){
                    $selected_quote_type = $user_selected_quote_type[0]['id'];
                } else {
                    !empty($session_selected_quote_type) === $selected_quote_type = $session_selected_quote_type['id'] ? : 0;
                }
                $selected_quote_type_id = $selected_quote_type;
                $quote_type_bridgeport_req = get_post_meta($selected_quote_type_id, 'quote_type_bridgeport_brand', true);

                $allow_product = true;
                $admin_id = get_original_admin_id();
                $admin_user = $admin_id ? get_userdata($admin_id) : null;
                $is_manager = in_array( $current_user->roles[0], $allowed_roles, true );
                $is_switched_manager = is_switched_customer() && $admin_user && in_array( $admin_user->roles[0], $allowed_roles, true );

                if ( ( $is_manager || $is_switched_manager ) && $quote_type_bridgeport_req === 'yes' ) {
                    $allow_product = false;

                    if ($product) {
                        $product_brand_meta = $product->get_meta('product_brand');

                        if (!empty($product_brand_meta)) {
                            $product_brands = array_map('trim', explode(',', strtolower($product_brand_meta)));

                            if (in_array('bridgeport', $product_brands, true)) {
                                $allow_product = true;
                            }
                        }
                    }
                    if (!$allow_product) {
                        $warning_messages[] = sprintf(
                            __('SKU: %s is not a Bridgeport product and was skipped.', 'addify_rfq'),
                            $sku
                        );
                        continue;
                    }
                }

                $data_validated = self::validate_parsed_quote_data($sku,$product_id,$current_product_ids,$offered_price,$quantity,$imported_skus);

                if ($data_validated && $allow_product) {
                    $quote_item_key = self::add_product_to_quote($product_id,$quantity,$offered_price,$post_id,$quote_contents,$price_base_type);

                    if (!$quote_item_key) {
                        self::$skipped_sku_items['skus_failed'][] = $sku;
                        continue;
                    }

                    $imported_skus[] = $sku;
                    $imported_quote_keys[] = $quote_item_key;
                    $imported_count++;
                }
            }

            self::get_xls_to_quote_messages($warning_messages);
            if ( !$is_profile && !$is_admin ) {
                if (!empty($warning_messages)) {
                    WC()->session->set( 'warning_messages',  $warning_messages);
                }

                WC()->session->set( 'notice_message',  'File processed successfully. ' . $imported_count . '/' . count($parsed_quote_data) . ' products added to quote.');
            }

            if ( $post_id && is_array( $quote_contents ) && (!empty( $quote_contents ) || !empty( $warning_messages )) ) {
                if ( $af_quote ) {
                    //if quote_contents is empty, function takes quote from session - clear it before & restore after the function
                    $quotes_session_tmp = WC()->session->get( 'quotes' );
                    WC()->session->set( 'quotes', array() );
                    $quote_totals = $af_quote->get_calculated_totals( $quote_contents, $post_id );
                    WC()->session->set( 'quotes', $quotes_session_tmp );
                    ob_start();
                    if ( $is_admin ) {
                        wc_get_template(
                            'quote/quote-table-totals.php',
                            array(
                                'quote_totals' => $quote_totals,
                                'price_base_type' => $price_base_type,
                                'quote_contents' => $quote_contents
                            ),
                            '/woocommerce/addify/rfq/',
                            AFRFQ_PLUGIN_DIR . 'templates/'
                        );
                    } else { ?>
                        <tr class="cart-subtotal">
                            <th><?php esc_html_e( 'Subtotal (Standard)', 'addify_rfq' ); ?></th>
                            <td data-title="<?php esc_attr_e( 'Subtotal', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_subtotal'] ) ); ?></td>
                        </tr>

                        <tr class="cart-subtotal cart-requested-subtotal">
                            <th><?php esc_html_e( 'Requested Price Subtotal', 'addify_rfq' ); ?></th>
                            <td data-title="<?php esc_attr_e( 'Offered Price Subtotal', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_offered_total'] ) ); ?></td>
                        </tr>
                        <?php
                    }
                    $quote_totals_html = ob_get_clean();
                } else {
                    $quote_totals_html = '';
                }

                ob_start();
                if ( $is_admin ) {
                    include AFRFQ_PLUGIN_DIR . 'admin/meta-boxes/quotes/quote-details-table-row.php';
                } else {
                    wc_get_template(
                        'quote/quote-table-profile-row.php',
                        array(
                            'quote_contents' => $quote_contents,
                            'quote_post_id' => $post_id,
                        ),
                        '/woocommerce/addify/rfq/',
                        AFRFQ_PLUGIN_DIR . 'templates/'
                    );
                }

                $quote_table = ob_get_clean();
                if ( empty($quote_table) ) {
                    $quote_table = "placeholder";
                }
                wp_send_json(
                    array(
                        'success'             => true,
                        'quote-details-table' => $quote_table,
                        'warnings'            => $warning_messages,
                        'quote-totals'        => $quote_totals_html,
                    )
                );
            } else {
                wp_send_json_success();
            }
        }

        public static function afrfq_process_pricing_xls_file_to_quote() {
            // Validate nonce
            if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'afrfq_import_nonce')) {
                wp_send_json_error([
                    'message' => 'Security verification failed.',
                    'code'    => 'nonce_error'
                ]);
            }

            // Check file exists
            if (empty($_FILES['import_pricing_xls_file']['name'])) {
                wp_send_json_error([
                    'message' => 'No file selected. Please choose a file to import.',
                    'code'    => 'no_file_error'
                ]);
            }

            $file = $_FILES['import_pricing_xls_file'];
            $file_type = wp_check_filetype($file['name']);

            // Validate file type
            if (!in_array($file_type['ext'], ['xls', 'xlsx'])) {
                wp_send_json_error([
                    'message' => 'Invalid file format. Only XLS or XLSX files are allowed.',
                    'code'    => 'invalid_file_type'
                ]);
            }

            $tmp_file_path = $file['tmp_name'];
            if (!$tmp_file_path || !file_exists($tmp_file_path)) {
                wp_send_json_error([
                    'message' => 'Failed to process uploaded file.',
                    'code'    => 'file_process_error'
                ]);
            }

            // Parse XLS file
            $warning_messages = [];
            self::$skipped_group_items = [];
            $parsed_data = self::afrfq_parse_pricing_xls($tmp_file_path, $warning_messages);

            if (empty($parsed_data)) {
                wp_send_json_error([
                    'message' => 'The file is empty or could not be parsed.',
                    'code'    => 'empty_file_error'
                ]);
            }

            global $wpdb;
            $is_profile = isset($_POST['is_profile']) && 'true' === $_POST['is_profile'];

            if ($is_profile) {
                $saved_groups = WC()->session->get('quote_pricing_groups', []);
                if(!empty(get_user_meta(get_current_user_id(), 'quote_pricing_groups'))) {
                    $saved_groups = get_user_meta(get_current_user_id(), 'quote_pricing_groups')[0];
                }

            } else {
                $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
                $saved_groups = $post_id ? get_post_meta($post_id, 'quote_pricing_groups', true) : [];
            }
            $saved_groups = is_array($saved_groups) ? $saved_groups : [];

            $matched_groups = [];

            foreach ($parsed_data as $row) {
                if (empty($row['product pricing group'])) {
                    continue;
                }

                $group_name = sanitize_text_field($row['product pricing group']);

                if (strlen($group_name) > 100) {
                    self::$skipped_group_items['invalid'][] = $group_name;
                    continue;
                }

                if (in_array($group_name, array_column($matched_groups, 'group_name'))) {
                    self::$skipped_group_items['duplicate'][] = $group_name;
                    continue;
                }

                if (in_array($group_name, array_column($saved_groups, 'group_name'))) {
                    self::$skipped_group_items['duplicate'][] = $group_name;
                    continue;
                }

                $group = $wpdb->get_row($wpdb->prepare(
                    "SELECT id, group_name, price_name 
                    FROM {$wpdb->prefix}ns_groups_pricings 
                    WHERE group_name = %s",
                    $group_name
                ));

                if (!$group) {
                    self::$skipped_group_items['not_found'][] = $group_name;
                    continue;
                }

                $exists_in_quote = false;
                foreach ($saved_groups as $saved) {
                    if ($saved['group_name'] === $group->group_name) {
                        $exists_in_quote = true;
                        self::$skipped_group_items['duplicate'][] = $group_name;
                        break;
                    }
                }

                if ($exists_in_quote) {
                    continue;
                }

                $new_group = [
                    'group_id'   => $group->id,
                    'group_name' => $group->group_name,
                    'price_name' => $group->price_name
                ];

                $matched_groups[] = $new_group;
                $saved_groups[] = $new_group;
            }

            ob_start();
            if ($is_profile) {
                WC()->session->set('quote_pricing_groups', $saved_groups);
                update_user_meta(get_current_user_id(), 'quote_pricing_groups', $saved_groups);

                if (!empty($saved_groups)) {
                    foreach ($saved_groups as $group_id => $group_data) {
                        ?>
                        <tr class="woocommerce-cart-form__quote-item cart_item" data-group_id_row="<?php echo esc_attr($group_id); ?>">
                            <td class="product-remove">
                                <a href="#" class="remove remove_pricing_group_from_quote" aria-label="<?php esc_attr_e('Remove this item', 'addify_rfq'); ?>" data-group_id="<?php echo esc_attr($group_id); ?>">&times;</a>
                            </td>
                            <td class="product-name" data-title="<?php esc_attr_e('Product Pricing Group', 'addify_rfq'); ?>">
                                <?php echo esc_html($group_data['group_name']); ?>
                            </td>
                            <td class="product-price" data-title="<?php esc_attr_e('Discount Level', 'addify_rfq'); ?>">
                                <?php echo esc_html($group_data['price_name']); ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
            } else {
                if ($post_id && !empty($matched_groups)) {
                    update_post_meta($post_id, 'quote_pricing_groups', $saved_groups);
                }

                if (!empty($saved_groups)) {
                    foreach ($saved_groups as $group) {
                        ?>
                        <tr data-group_id="<?php echo esc_attr($group['group_id']); ?>">
                            <td class="group-name"><?php echo esc_html($group['group_name']); ?></td>
                            <td class="price-name"><?php echo esc_html($group['price_name']); ?></td>
                            <td>
                                <a href="#" class="delete-pricing-group delete-quote-item tips" title="Delete <?php echo esc_attr($group['group_name']); ?>" data-group_id="<?php echo esc_attr($group['group_id']); ?>"></a>
                            </td>
                        </tr>
                        <?php
                    }
                }
            }

            if (empty($saved_groups)) {
                $colspan = $is_profile ? 3 : 3;
                ?>
                <tr class="no-items">
                    <td colspan="<?php echo $colspan; ?>" style="text-align:center;">
                        <?php esc_html_e('No pricing groups have been added to this quote.', 'addify_rfq'); ?>
                    </td>
                </tr>
                <?php
            }

            $pricing_groups_html = ob_get_clean();

            self::get_pricing_xls_to_quote_messages($warning_messages);
            WC()->session->set('pricing_import_warnings', $warning_messages);

            wp_send_json_success([
                'pricing_groups_html' => $pricing_groups_html,
                'matched_count'       => count($matched_groups),
                'warnings'            => $warning_messages,
                'message'             => 'Imported ' . count($matched_groups) . ' pricing groups successfully.'
            ]);
        }

        public static function afrfq_process_detail_pricing_xls_file_to_quote() {
            // Validate nonce
            if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'afrfq_import_nonce')) {
                wp_send_json_error([
                    'message' => 'Security verification failed.',
                    'code'    => 'nonce_error'
                ]);
            }

            // Check file exists
            if (empty($_FILES['import_pricing_xls_file']['name'])) {
                wp_send_json_error([
                    'message' => 'No file selected. Please choose a file to import.',
                    'code'    => 'no_file_error'
                ]);
            }

            $file = $_FILES['import_pricing_xls_file'];
            $file_type = wp_check_filetype($file['name']);

            // Validate file type
            if (!in_array($file_type['ext'], ['xls', 'xlsx'])) {
                wp_send_json_error([
                    'message' => 'Invalid file format. Only XLS or XLSX files are allowed.',
                    'code'    => 'invalid_file_type'
                ]);
            }

            $tmp_file_path = $file['tmp_name'];
            if (!$tmp_file_path || !file_exists($tmp_file_path)) {
                wp_send_json_error([
                    'message' => 'Failed to process uploaded file.',
                    'code'    => 'file_process_error'
                ]);
            }

            // Parse XLS file
            $warning_messages = [];
            self::$skipped_group_items = [];
            $parsed_data = self::afrfq_parse_detail_pricing_xls($tmp_file_path, $warning_messages);

            if (empty($parsed_data)) {
                wp_send_json_error([
                    'message' => 'The file is empty or could not be parsed.',
                    'code'    => 'empty_file_error'
                ]);
            }

            global $wpdb;
            $is_profile = isset($_POST['is_profile']) && 'true' === $_POST['is_profile'];

            if ($is_profile) {
                $saved_groups = WC()->session->get('quote_pricing_groups', []);
                if(!empty(get_user_meta(get_current_user_id(), 'quote_pricing_groups'))) {
                    $saved_groups = get_user_meta(get_current_user_id(), 'quote_pricing_groups')[0];
                }
            } else {
                $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
                $saved_groups = $post_id ? get_post_meta($post_id, 'quote_pricing_groups', true) : [];
            }
            $saved_groups = is_array($saved_groups) ? $saved_groups : [];

            $matched_groups = [];

            foreach ($parsed_data as $row) {
                if (empty($row['product pricing group'])) {
                    continue;
                }

                $group_name = sanitize_text_field($row['product pricing group']);

                if (strlen($group_name) > 100) {
                    self::$skipped_group_items['invalid'][] = $group_name;
                    continue;
                }

                if (in_array($group_name, array_column($matched_groups, 'group_name'))) {
                    self::$skipped_group_items['duplicate'][] = $group_name;
                    continue;
                }

                if (in_array($group_name, array_column($saved_groups, 'group_name'))) {
                    self::$skipped_group_items['duplicate'][] = $group_name;
                    continue;
                }

                $group = $wpdb->get_row($wpdb->prepare(
                    "SELECT id, group_name, price_name 
                    FROM {$wpdb->prefix}ns_groups_pricings 
                    WHERE group_name = %s",
                    $group_name
                ));

                if (!$group) {
                    self::$skipped_group_items['not_found'][] = $group_name;
                    continue;
                }

                $exists_in_quote = false;
                foreach ($saved_groups as $saved) {
                    if ($saved['group_name'] === $group->group_name) {
                        $exists_in_quote = true;
                        self::$skipped_group_items['duplicate'][] = $group_name;
                        break;
                    }
                }

                if ($exists_in_quote) {
                    continue;
                }

                $new_group = [
                    'group_id'   => $group->id,
                    'group_name' => $group->group_name,
                    'price_name' => $group->price_name
                ];

                $matched_groups[] = $new_group;
                $saved_groups[] = $new_group;
            }

            ob_start();
            if ($is_profile) {
                WC()->session->set('quote_pricing_groups', $saved_groups);
                update_user_meta(get_current_user_id(), 'quote_pricing_groups', $saved_groups);
                if (!empty($saved_groups)) {
                    foreach ($saved_groups as $group_id => $group_data) {
                        ?>
                        <tr class="woocommerce-cart-form__quote-item cart_item" data-group_id_row="<?php echo esc_attr($group_id); ?>">
                            <td class="product-remove">
                                <a href="#" class="remove remove-pricing-group" aria-label="<?php esc_attr_e('Remove this item', 'addify_rfq'); ?>" data-group_id="<?php echo esc_attr($group_id); ?>">&times;</a>
                            </td>
                            <td class="product-name" data-title="<?php esc_attr_e('Product Pricing Group', 'addify_rfq'); ?>">
                                <?php echo esc_html($group_data['group_name']); ?>
                            </td>
                            <td class="product-price" data-title="<?php esc_attr_e('Discount Level', 'addify_rfq'); ?>">
                                <?php echo esc_html($group_data['price_name']); ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
            } else {
                if ($post_id && !empty($matched_groups)) {
                    update_post_meta($post_id, 'quote_pricing_groups', $saved_groups);
                }

                if (!empty($saved_groups)) {
                    foreach ($saved_groups as $group) {
                        ?>
                        <tr data-group_id="<?php echo esc_attr($group['group_id']); ?>">
                            <td class="group-name"><?php echo esc_html($group['group_name']); ?></td>
                            <td class="price-name"><?php echo esc_html($group['price_name']); ?></td>
                            <td>
                                <a href="#" class="delete-pricing-group delete-quote-item tips" title="Delete <?php echo esc_attr($group['group_name']); ?>" data-group_id="<?php echo esc_attr($group['group_id']); ?>"></a>
                            </td>
                        </tr>
                        <?php
                    }
                }
            }

            if (empty($saved_groups)) {
                $colspan = $is_profile ? 3 : 3;
                ?>
                <tr class="no-items">
                    <td colspan="<?php echo $colspan; ?>" style="text-align:center;">
                        <?php esc_html_e('No pricing groups have been added to this quote.', 'addify_rfq'); ?>
                    </td>
                </tr>
                <?php
            }

            $pricing_groups_html = ob_get_clean();

            self::get_pricing_xls_to_quote_messages($warning_messages);
            WC()->session->set('pricing_import_warnings', $warning_messages);

            wp_send_json_success([
                'pricing_groups_html' => $pricing_groups_html,
                'matched_count'       => count($matched_groups),
                'warnings'            => $warning_messages,
                'message'             => 'Imported ' . count($matched_groups) . ' pricing groups successfully.'
            ]);
        }

        public static function import_quote_copypaste() {
            if ( !isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'afrfq_import_nonce') ) {
                wp_send_json_error( array('message' => 'Nonce verification failed.', 'code' => 'nonce_error') );
            }

            if ( !isset($_POST['import_data']) || empty($_POST['import_data']) ) {
                wp_send_json_error( array('message' => 'Import data missing.') );
            }

            $warning_messages = $import_data = array();
            $lines = preg_split( '/\r\n|\r|\n/', $_POST['import_data'] );
            foreach( $lines as $line ) {
                $line = trim( preg_replace('/\s+/', ' ', $line) );
                if ( empty($line) ) {
                    continue;
                }
                $line_parts = explode( ' ', $line );
                $import_data[] = [
                    'sku' => $line_parts[0] ?? '',
                    'quantity' => intval( $line_parts[1] ) ?? 0,
                ];
            }

            if ( empty($import_data) ) {
                wp_send_json_error( array('message' => 'Failed to parse the data.', 'code' => 'copypaste_parsing_error') );
            }

            $price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
            $quote_contents = WC()->session->get( 'quotes' ) ?: array();
            $current_product_ids = array();
            foreach ( $quote_contents as $quote_item_key => $quote_item ) {
                if (  isset( $quote_item['data'] ) && is_object( $quote_item['data'] ) ) {
                    $current_product_ids[] = apply_filters( 'addify_quote_item_product_id', $quote_item['product_id'], $quote_item, $quote_item_key );
                }
            }

            $current_user   = wp_get_current_user();
            $allowed_roles = [ 'shop_manager', 'dual_shop_manager' ];
	        $selected_quote_type_id = 0;
            $context_key = get_current_user_contextual_quote_type_key();
            $user_selected_quote_type = get_user_meta(get_current_user_id(), $context_key);
            $session_selected_quote_type = WC()->session->get( $context_key );
            if(!null == $user_selected_quote_type){
                $selected_quote_type = $user_selected_quote_type[0]['id'];
            } else {
                !empty($session_selected_quote_type) === $selected_quote_type = $session_selected_quote_type['id'] ? : 0;
            }
            $selected_quote_type_id = $selected_quote_type;

            $quote_type_bridgeport_req = get_post_meta($selected_quote_type_id, 'quote_type_bridgeport_brand', true);

            $require_bridgeport = false;
            $admin_id = get_original_admin_id();
            $admin_user = $admin_id ? get_userdata($admin_id) : null;
            $is_manager = in_array( $current_user->roles[0], $allowed_roles, true );
            $is_switched_manager = is_switched_customer() && $admin_user && in_array( $admin_user->roles[0], $allowed_roles, true );

            if ( ( $is_manager || $is_switched_manager ) && $quote_type_bridgeport_req === 'yes' ) {
                $require_bridgeport = true;
            }

            $imported_count = 0;
            $line_items_count = count( $quote_contents );
            $imported_skus = [];
            foreach ( $import_data as $item ) {
                if ( $line_items_count + $imported_count >= self::$afrfq_max_rows_allowed ) {
                    $warning_messages[] = '<p><b>Warning</b>: Only ' . self::$afrfq_max_rows_allowed . ' valid items can be displayed in the Quote.</p>';
                    break;
                }

                $sku = isset( $item['sku'] ) ? sanitize_text_field( wp_unslash($item['sku']) ) : '';
                $quantity = $item['quantity'];
                $offered_price = 1;
                $product_id = wc_get_product_id_by_sku( $sku );

                if ( $product_id ) {
                    $product = wc_get_product( $product_id );
                    $offered_price = $product->get_price();

                    $price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
                    if ($price_base_type === 'moq') {
                        $min_qty = intval( get_post_meta( $product_id, 'min_quantity', true ) );
                        $price_qty_multiplier = $min_qty;
                        $price_qty_multiplier = $price_qty_multiplier < 1 ? 1 : $price_qty_multiplier;
                    } else {
                        $price_qty_multiplier = get_post_meta( $product_id, 'ns_price_qty_multiplier', true );
                        $price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;
                    }

                    $offered_price = $offered_price * $price_qty_multiplier;

                    if ( $require_bridgeport ) {
                        $brands_raw = $product->get_meta('product_brand');
                        $brands = array_map( 'strtolower', array_map( 'trim', explode(',', (string) $brands_raw ) ) );

                        if ( ! in_array('bridgeport', $brands, true) ) {
                            $warning_messages[] = '<p><b>Warning</b>: SKU <b>' . esc_html($sku) . '</b> skipped. Not a Bridgeport product.</p>';
                            continue;
                        }
                    }
                }

                $data_validated = self::validate_parsed_quote_data( $sku, $product_id, $current_product_ids, $offered_price, $quantity, $imported_skus );
                if ( $data_validated ) {
                    $quote_item_key = self::add_product_to_quote( $product_id, $quantity, $offered_price, '', $quote_contents, $price_base_type );
                    if ( !$quote_item_key ) {
                        self::$skipped_sku_items['skus_failed'][] = $sku;
                        continue;
                    }

                    $imported_skus []= $sku;
                    $imported_count++;
                }
            }

            if ( isset(self::$skipped_sku_items['empty_values']) ) {
                self::$skipped_sku_items['empty_values_copypaste'] = self::$skipped_sku_items['empty_values'];
                unset(self::$skipped_sku_items['empty_values']);
            }
            self::get_xls_to_quote_messages( $warning_messages );
            if ( !empty($warning_messages) ) {
                WC()->session->set( 'warning_messages',  $warning_messages);
            }

            WC()->session->set( 'notice_message',  'Data processed successfully. ' . $imported_count . '/' . count($import_data) . ' products added to quote.');
            wp_send_json_success();
        }

        public static function afrfq_parse_xls($file_path, &$warning_messages) {
            try {
                $spreadsheet = IOFactory::load($file_path);
                $worksheet = $spreadsheet->getActiveSheet();

                $parsed_data = array();
                $isFirstRow = true;
                $rowCount = 0;

                $maxRows = defined('AFRFQ_MAX_XLS_ROWS') ? AFRFQ_MAX_XLS_ROWS : 1000;
                foreach ($worksheet->getRowIterator() as $row) {
                    if ($isFirstRow) {
                        $isFirstRow = false;
                        continue;
                    }
                    if ($rowCount >= $maxRows) {
                        $warning_messages[] = '<p><b>Warning</b>: Processing the first ' . $maxRows . ' rows. Only ' . self::$afrfq_max_rows_allowed . ' valid items can be displayed in the Quote.</p>';
                        break;
                    }
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    $rowData = array();
                    foreach ($cellIterator as $cell) {
                        $value = $cell->getValue();
                        $rowData[] = sanitize_text_field($value);
                    }

                    if (empty($rowData[0])) {
                        break;
                    }

                    $offered_price = floatval($rowData[1]);
                    $quantity = intval($rowData[2]);

                    $parsed_data[] = [
                        'sku' => $rowData[0],
                        'offered_price' => $offered_price,
                        'quantity' => $quantity
                    ];
                    $rowCount++;
                }
                return $parsed_data;
            } catch (Exception $e) {
                return array();
            }
        }

        public static function afrfq_parse_pricing_xls($file_path, &$warning_messages) {
            try {
                $spreadsheet = IOFactory::load($file_path);
                $worksheet = $spreadsheet->getActiveSheet();

                $parsed_data = array();
                $isFirstRow = true;
                $rowCount = 0;

                $maxRows = defined('AFRFQ_MAX_XLS_ROWS') ? AFRFQ_MAX_XLS_ROWS : 1000;
                foreach ($worksheet->getRowIterator() as $row) {
                    if ($isFirstRow) {
                        $isFirstRow = false;
                        continue;
                    }
                    if ($rowCount >= $maxRows) {
                        $warning_messages[] = '<p><b>Warning</b>: Processing the first ' . $maxRows . ' rows. Only ' . self::$afrfq_pricing_max_rows . ' valid items can be displayed in the Quote.</p>';
                        break;
                    }
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    $rowData = array();
                    foreach ($cellIterator as $cell) {
                        $value = $cell->getValue();
                        $rowData[] = sanitize_text_field($value);
                    }

                    if (empty($rowData[0])) {
                        break;
                    }

                    $parsed_data[] = [
                        'product pricing group' => $rowData[0]
                    ];
                    $rowCount++;
                }
                return $parsed_data;
            } catch (Exception $e) {
                return array();
            }
        }

        public static function validate_parsed_quote_data($sku, $product_id, $current_product_ids, $offered_price, &$quantity, $imported_skus) {
            if (!$product_id) {
                self::$skipped_sku_items['not_available_sku'][] = $sku;
                return false;
            }

            if ($offered_price <= 0 || $quantity <= 0) {
                self::$skipped_sku_items['empty_values'][] = $sku;
                return false;
            }

            $product = wc_get_product($product_id);
            if (empty($product) || !$product->is_purchasable()) {
                self::$skipped_sku_items['not_available_sku'][] = $sku;
                return false;
            }

            $min_qty = intval( get_post_meta( $product_id, 'min_quantity', true ) );
            if ($quantity < $min_qty) {
                self::$skipped_sku_items['skus_below_minimum'][] = $sku;
                return false;
            }

            if (in_array($product_id, $current_product_ids)) {
                self::$skipped_sku_items['exist_in_current_quote'][] = $sku;
                return false;
            }

            $product_step = intval( get_post_meta( $product_id, 'product_step', true ) );
            if ($product_step > 1 && $quantity % $product_step != 0) {
                $quantity = ceil($quantity / $product_step) * $product_step;
                self::$skipped_sku_items['skus_step_quantity_up'][] = $sku;
            }

            if ( in_array( $sku, $imported_skus ) ) {
                self::$skipped_sku_items['duplicated_sku'][] = $sku;
                return false;
            }
            return true;
        }

        public static function get_xls_to_quote_messages(&$warning_messages) {
            if (!empty(self::$skipped_sku_items['exist_in_current_quote'])) {
                $exist_in_current_quote_msg = '<b>Warning</b>: These SKUs are already added to quote: ' . implode(', ', self::$skipped_sku_items['exist_in_current_quote']) . '.';
                $warning_messages[] = $exist_in_current_quote_msg;
            }
            if (!empty(self::$skipped_sku_items['not_available_sku'])) {
                $not_available_sku_msg = '<b>Warning</b>: There are no products with SKUs ' . implode(', ', self::$skipped_sku_items['not_available_sku']) . ' or products are not purchasable.';
                $warning_messages[] = $not_available_sku_msg;
            }
            if (!empty(self::$skipped_sku_items['empty_values'])) {
                $empty_values_msg = '<b>Warning</b>: Price and quantity must be positive values. Affected SKUs: ' . implode(', ', self::$skipped_sku_items['empty_values']) . '.';
                $warning_messages[] = $empty_values_msg;
            }
            if (!empty(self::$skipped_sku_items['empty_values_copypaste'])) {
                $empty_values_msg = '<b>Warning</b>: Quantity must be a positive value. Affected SKUs: ' . implode(', ', self::$skipped_sku_items['empty_values_copypaste']) . '.';
                $warning_messages[] = $empty_values_msg;
            }
            if (!empty(self::$skipped_sku_items['skus_below_minimum'])) {
                $skus_below_minimum_msg = '<b>Warning</b>: Quantity is below minimum for SKUs: ' . implode(', ', self::$skipped_sku_items['skus_below_minimum']) . '.';
                $warning_messages[] = $skus_below_minimum_msg;
            }
            if (!empty(self::$skipped_sku_items['skus_step_quantity_up'])) {
                $skus_step_quantity_up_msg = '<b>Warning</b>: Quantity for SKUs ' . implode(', ', self::$skipped_sku_items['skus_step_quantity_up']) . ' was rounded up according to the next sales unit of measure.';
                $warning_messages[] = $skus_step_quantity_up_msg;
            }
            if (!empty(self::$skipped_sku_items['skus_failed'])) {
                $skus_failed_msg = '<b>Warning</b>: Failed adding SKUs to quote: ' . implode(', ', self::$skipped_sku_items['skus_failed']) . '.';
                $warning_messages[] = $skus_failed_msg;
            }
            if (!empty(self::$skipped_sku_items['duplicated_sku'])) {
                $skus_duplicated_msg = '<b>Warning</b>: Duplicated SKUs found in the file: ' . implode(', ', self::$skipped_sku_items['duplicated_sku']) . '.';
                $warning_messages[] = $skus_duplicated_msg;
            }
        }

        public static function get_pricing_xls_to_quote_messages(&$warning_messages) {
            if (!empty(self::$skipped_group_items['not_found'])) {
                $not_found_msg = '<b>Warning</b>: These pricing groups were not found in the system: ' . implode(', ', self::$skipped_group_items['not_found']) . '.';
                $warning_messages[] = $not_found_msg;
            }
            if (!empty(self::$skipped_group_items['duplicate'])) {
                $duplicate_msg = '<b>Warning</b>: These pricing groups were skipped because they are duplicates or already in the quote: ' . implode(', ', self::$skipped_group_items['duplicate']) . '.';
                $warning_messages[] = $duplicate_msg;
            }
            if (!empty(self::$skipped_group_items['invalid'])) {
                $invalid_msg = '<b>Warning</b>: These pricing groups have invalid names (e.g., too long): ' . implode(', ', self::$skipped_group_items['invalid']) . '.';
                $warning_messages[] = $invalid_msg;
            }
        }

        public static function add_product_to_quote($product_id, $quantity, $offered_price, $post_id, &$quote_contents, $price_base_type) {
            if (!empty($quote_contents)) {
                $af_quote = new AF_R_F_Q_Quote($quote_contents);
            } else {
                $af_quote = new AF_R_F_Q_Quote();
            }
            try {
                $product_data = wc_get_product( $product_id );
                $quantity     = apply_filters( 'addify_add_to_quote_quantity', $quantity, $product_id );

                if ( $quantity <= 0 || ! $product_data || 'trash' === $product_data->get_status() ) {
                    return false;
                }

                $quote_id = $af_quote->generate_quote_id( $product_id );
                $quote_item_key = $af_quote->find_product_in_quote( $quote_id );

                if ( empty( $quote_item_key ) ) {
                    $quote_item_key = $quote_id;

                    $args          = array(
                        'qty'   => 1,
                        'price' => $offered_price,
                    );
                    $offered_price = $af_quote->get_product_price( $product_data, $args, 'edit' );
                    $price_qty_multiplier = self::get_price_qty_multiplier($price_base_type, $product_id);
                    $offered_price_per_each = $offered_price / $price_qty_multiplier;
                    $offered_price = number_format( $offered_price, 2 );

                    $af_quote->quote_contents[ $quote_item_key ] = apply_filters(
                        'addify_add_quote_item',
                        array(
                            'key'           => $quote_item_key,
                            'product_id'    => $product_id,
                            'variation_id'  => 0,
                            'variation'     => array(),
                            'quantity'      => $quantity,
                            'offered_price' => $offered_price,
                            'offered_price_per_each' => $offered_price_per_each,
                            'role_base_price' => $product_data->get_price(),
                            'data'          => $product_data,
                            'data_hash'     => wc_get_cart_item_data_hash( $product_data ),
                        ),
                        $quote_item_key
                    );
                }
                $quote_contents = $af_quote->quote_contents;
                if ( empty($post_id) ) {
                    if ( is_user_logged_in() ) {
                        Nsi_Helper::update_addify_quote_user_meta( $af_quote->quote_contents );
                    }

                    wc()->session->set( 'quotes', $af_quote->quote_contents );

                    do_action('addify_quote_session_changed');

                    do_action( 'addify_add_to_quote', $quote_item_key, $product_id, $quantity, 0, array(), array() );
                }

                return $quote_item_key;

            } catch ( Exception $e ) {
                if ( $e->getMessage() && ! is_admin() ) {
                    wc_add_notice( $e->getMessage(), 'error' );
                }
                return false;
            }
        }

        public static function get_price_qty_multiplier($price_base_type, $product_id) {
            if ($price_base_type === 'moq') {
                $price_qty_multiplier = intval(get_post_meta($product_id, 'min_quantity', true));
                $price_qty_multiplier = $price_qty_multiplier < 1 ? 1 : $price_qty_multiplier;
            } else {
                $price_qty_multiplier = get_post_meta($product_id, 'ns_price_qty_multiplier', true);
                $price_qty_multiplier = floatval($price_qty_multiplier) > 0 ? floatval($price_qty_multiplier) : 1;
            }
            return $price_qty_multiplier;
        }

        public static function handle_clear_quotes_cart_button(): void {
            $user_id = get_current_user_id();
            $context_key = get_current_user_contextual_quote_type_key();
            update_user_meta( $user_id, $context_key, null );
            update_user_meta( $user_id, 'quote_pricing_groups', null );
            $unique_id = Eleks_Carts_Management::get_user_unique_session_id($user_id);
            check_ajax_referer('clear_quotes_cart', 'nonce');
            Eleks_Carts_Management::clear_quotes_carts(0, $unique_id);
            wp_send_json_success();
        }

	}
}

