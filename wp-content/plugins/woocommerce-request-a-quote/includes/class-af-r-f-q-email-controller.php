<?php
/**
 * Addify Request a Quote Email Controller.
 *
 * The WooCommerce quote class stores quote data and maintain session of quotes.
 * The quote class also has a price calculation function which calls upon other classes to calculate totals.
 *
 * @package addify-request-a-quote
 * @version 1.6.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * AF_R_F_Q_Email_Controller class.
 */
class AF_R_F_Q_Email_Controller {

	/**
	 * Contains an array of quote items.
	 *
	 * @var array
	 */
	private static $email_headers;

	private $is_admin_email;

	/**
	 * Constructor for the AF_R_F_Q_Email_Controller class. Loads email headers.
	 */
	public function __construct() {

		$this->init();
		add_action( 'addify_rfq_email_header', array( $this, 'get_email_header' ) );
		add_action( 'addify_rfq_email_footer', array( $this, 'get_email_footer' ) );
		add_action( 'addify_rfq_email_customer_details', array( $this, 'get_customer_info_table' ) );
		add_action( 'addify_rfq_email_quote_details', array( $this, 'get_quote_contents_table' ) );

		// Action Hooks to send emails.
		add_action( 'addify_rfq_send_quote_email_to_customer', array( $this, 'send_email_to_customer' ) );
		add_action( 'addify_rfq_send_quote_email_to_admin', array( $this, 'send_email_to_admins' ) );

		add_filter( 'woocommerce_email_footer_text', array( $this, 'replace_placeholders' ) );
	}


	/**
	 * Init function to initialize the necessary actions for emails.
	 */
	public function init() {
		self::$email_headers = $this->get_email_headers();
	}

	/**
	 * Load the template of email header.
	 */
	public function get_email_header( $email_heading ) {

		wc_get_template( 
			'emails/email-header.php',
			array(
				'email_heading' => $email_heading,
			),
			'/woocommerce/addify/rfq/',
			AFRFQ_PLUGIN_DIR . 'templates/'
		);
	}

	/**
	 * Load the template of email footer.
	 */
	public function get_email_footer() {

		wc_get_template(
			'emails/email-footer.php',
			array(),
			'/woocommerce/addify/rfq/',
			AFRFQ_PLUGIN_DIR . 'templates/'
		);
	}

	/**
	 * Apply inline styles to dynamic content.
	 *
	 * We only inline CSS for html emails, and to do so we use Emogrifier library (if supported).
	 *
	 * @param string|null $content Content that will receive inline styles.
	 * @return string
	 */
	public function send_email_to_customer( $quote_id ) {
		$this->is_admin_email = false;
		// Email to customer.
		$af_fields_obj = new AF_R_F_Q_Quote_Fields();
		$user_name     = $af_fields_obj->afrfq_get_user_name( $quote_id );
		$user_email    = $af_fields_obj->afrfq_get_user_email( $quote_id, true );
		$quote_status  = get_post_meta( $quote_id, 'quote_status', true );
		$distibutor_name = get_post_meta( $quote_id, 'afrfq_field_5822579', true );
		$email_values  = (array) get_option( 'afrfq_emails' );
		$quote_contents = get_post_meta( $quote_id, 'quote_contents', true );
		 
		if ( ! isset( $af_quote ) ) {
			$af_quote = new AF_R_F_Q_Quote( $quote_contents );
		}		
		
		$totals = $af_quote->get_calculated_totals( $quote_contents, $quote_id );
		
		$quote_subtotal = isset( $totals['_subtotal'] ) ? $totals['_subtotal'] : 0;
		$approved_total  = isset( $totals['_approved_total'] ) ? $totals['_approved_total'] : $offered_total;

		$email_enable  = isset( $email_values[ $quote_status ]['enable'] ) ? $email_values[ $quote_status ]['enable'] : '';
		$email_subject = isset( $email_values[ $quote_status ]['subject'] ) ? $email_values[ $quote_status ]['subject'] : '';
		if ( $quote_status !== 'af_converted' && $quote_status == 'af_accepted' ) {
			if ( ! empty( $distibutor_name ) && ! empty( $approved_total ) ) {
				$email_subject .= ': ' . $distibutor_name . ": $" . number_format( $approved_total, 2 );
			} elseif ( ! empty( $distibutor_name ) ) {
				$email_subject .= ': ' . $distibutor_name;
			}
		}
		elseif ( $quote_status !== 'af_converted' && $quote_status !== 'af_accepted' ) {
			if ( ! empty( $distibutor_name ) && ! empty( $quote_subtotal ) ) {
				$email_subject .= ': ' . $distibutor_name . ": $" . number_format( $quote_subtotal, 2 );
			} elseif ( ! empty( $distibutor_name ) ) {
				$email_subject .= ': ' . $distibutor_name;
			}
		}
		$email_heading = isset( $email_values[ $quote_status ]['heading'] ) ? $email_values[ $quote_status ]['heading'] : '';
		$email_message = isset( $email_values[ $quote_status ]['message'] ) ? $email_values[ $quote_status ]['message'] : '';
		if ( ! is_email( $user_email ) ) {
			return;
		}

		if ( 'yes' !== $email_enable ) {
			return;
		}

		$email = $user_email;
		if ( in_array( $quote_status, array( 'af_accepted' ) ) ) {
			// include RVPs and RSMs
			$email = apply_filters( 'afrfq_admin_email', $email, $quote_id );
		}

        $email_subject = apply_filters( 'filter_customer_quote_email_subject', $email_subject );

		$email_subject = str_replace('{quote_id}', $quote_id, $email_subject );
		$email_heading = str_replace('{quote_id}', $quote_id, $email_heading );

		$email_subject = str_replace('{user_name}', $user_name, $email_subject );
		$email_heading = str_replace('{user_name}', $user_name, $email_heading );

		ob_start();

		wc_get_template(
			'emails/quote-email-to-customer.php',
			array(
				'email_heading' => $email_heading,
				'user_name'     => $user_name,
				'email_message' => $email_message,
				'quote_id'      => $quote_id,
				'email'         => $email,
			),
			'/woocommerce/addify/rfq/',
			AFRFQ_PLUGIN_DIR . 'templates/'
		);

		$template = ob_get_clean();

		$customer_email_html = $this->style_inline( $template );

		wp_mail( $email, $email_subject, $customer_email_html, self::$email_headers );
	}

	public function send_email_to_admins( $quote_id ) {
		$this->is_admin_email = true;

		// Email to administrators, shop managers.
		$af_fields_obj = new AF_R_F_Q_Quote_Fields();
		$user_name     = $af_fields_obj->afrfq_get_user_name( $quote_id );
		$user_email    = $af_fields_obj->afrfq_get_user_email( $quote_id, true );
		$admin_email   = apply_filters( 'afrfq_admin_email', get_option( 'afrfq_admin_email' ), $quote_id );
		$email_values  = (array) get_option( 'afrfq_emails' );
		$quote_status  = get_post_meta( $quote_id, 'quote_status', true );
		$distibutor_name = get_post_meta( $quote_id, 'afrfq_field_5822579', true );
		$quote_contents = get_post_meta( $quote_id, 'quote_contents', true );

		if ( ! isset( $af_quote ) ) {
			$af_quote = new AF_R_F_Q_Quote( $quote_contents );
		}		
		
		$totals = $af_quote->get_calculated_totals( $quote_contents, $quote_id );
		
		$quote_subtotal = isset( $totals['_subtotal'] ) ? $totals['_subtotal'] : 0;
		$approved_total  = isset( $totals['_approved_total'] ) ? $totals['_approved_total'] : $offered_total;
		 
		foreach ( (array) $quote_contents as $key => $item ) {
			$product = isset( $item['data'] ) ? $item['data'] : '';
			if ( ! is_object( $product ) ) {
				continue;
			}
			$offered_price = isset( $item['offered_price'] ) ? floatval( $item['offered_price'] ) : $price;
		}
		
		if ( 'af_pending' === $quote_status ) {

			$email_enable  = isset( $email_values['af_admin']['enable'] ) ? $email_values['af_admin']['enable'] : '';
			$email_subject = isset( $email_values['af_admin']['subject'] ) ? $email_values['af_admin']['subject'] : '';
			$email_heading = isset( $email_values['af_admin']['heading'] ) ? $email_values['af_admin']['heading'] : '';
			$email_message = isset( $email_values['af_admin']['message'] ) ? $email_values['af_admin']['message'] : '';

		} elseif ( 'af_converted' === $quote_status ) {

			$email_enable  = isset( $email_values['af_admin_conv']['enable'] ) ? $email_values['af_admin_conv']['enable'] : '';
			$email_subject = isset( $email_values['af_admin_conv']['subject'] ) ? $email_values['af_admin_conv']['subject'] : '';
			$email_heading = isset( $email_values['af_admin_conv']['heading'] ) ? $email_values['af_admin_conv']['heading'] : '';
			$email_message = isset( $email_values['af_admin_conv']['message'] ) ? $email_values['af_admin_conv']['message'] : '';

		} else {

			return;
		}

        $email_subject = apply_filters( 'filter_admin_quote_email_subject', $email_subject );		

		$email_subject = str_replace('{quote_id}', $quote_id, $email_subject );
		$email_heading = str_replace('{quote_id}', $quote_id, $email_heading );

		$email_subject = str_replace('{user_name}', $user_name, $email_subject );
		$email_heading = str_replace('{user_name}', $user_name, $email_heading );
		
		if ( $quote_status !== 'af_converted' && $quote_status == 'af_accepted' ) {
			if ( ! empty( $distibutor_name ) && ! empty( $approved_total ) ) {
				$email_subject .= ': ' . $distibutor_name . ": $" . number_format( $approved_total, 2 );
			} elseif ( ! empty( $distibutor_name ) ) {
				$email_subject .= ': ' . $distibutor_name;
			}
		}
		elseif ( $quote_status !== 'af_converted' && $quote_status !== 'af_accepted' ) {
			if ( ! empty( $distibutor_name ) && ! empty( $quote_subtotal ) ) {
				$email_subject .= ': ' . $distibutor_name . ": $" . number_format( $quote_subtotal, 2 );
			} elseif ( ! empty( $distibutor_name ) ) {
				$email_subject .= ': ' . $distibutor_name;
			}
		}
		$email = $admin_email;

		if ( 'yes' !== $email_enable ) {

			return;
		}

		ob_start();

		wc_get_template(
			'emails/quote-email-to-admin.php',
			array(
				'email_heading' => $email_heading,
				'user_name'     => $user_name,
				'email_message' => $email_message,
				'quote_id'      => $quote_id,
				'email'         => $email,
			),
			'/woocommerce/addify/rfq/',
			AFRFQ_PLUGIN_DIR . 'templates/'
		);

		$template = ob_get_clean();

		$admin_email_html = $this->style_inline( $template );

		
		$headers   = self::$email_headers;
		$headers[] = 'Reply-to: ' . $user_name . ' <' . $user_email . '>';

		wp_mail( $admin_email, $email_subject, $admin_email_html, $headers );
	}

	/**
	 * Apply inline styles to dynamic content.
	 *
	 * We only inline CSS for html emails, and to do so we use Emogrifier library (if supported).
	 *
	 * @version 4.0.0
	 * @param string|null $content Content that will receive inline styles.
	 * @return string
	 */
	public function style_inline( $content ) {

		ob_start();
		wc_get_template( 'emails/email-styles.php' );
		$css = apply_filters( 'addify_rfq_email_styles', ob_get_clean(), $this );

		$emogrifier_class = 'Pelago\\Emogrifier';

		if ( class_exists( $emogrifier_class ) ) {
			try {
				$emogrifier = new $emogrifier_class( $content, $css );

				do_action( 'addify_rfq_emogrifier', $emogrifier, $this );

				$content    = $emogrifier->emogrify();
				$html_prune = \Pelago\Emogrifier\HtmlProcessor\HtmlPruner::fromHtml( $content );
				$html_prune->removeElementsWithDisplayNone();
				$content = $html_prune->render();
			} catch ( Exception $e ) {
				$logger = wc_get_logger();
				$logger->error( $e->getMessage(), array( 'source' => 'emogrifier' ) );
			}
		} else {
			$content = '<style type="text/css">' . $css . '</style>' . $content;
		}

		return $content;
	}

	/**
	 * Get blog name formatted for emails.
	 *
	 * @return string
	 */
	private function get_blogname() {
		return wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}

	/**
	 * Replace placeholder text in strings.
	 *
	 * @since  3.7.0
	 * @param  string $string Email footer text.
	 * @return string         Email footer text with any replacements done.
	 */
	public function replace_placeholders( $string ) {
		$domain = wp_parse_url( home_url(), PHP_URL_HOST );

		return str_replace(
			array(
				'{site_title}',
				'{site_address}',
				'{site_url}',
				'{woocommerce}',
				'{WooCommerce}',
			),
			array(
				$this->get_blogname(),
				$domain,
				$domain,
				'<a href="https://woocommerce.com">WooCommerce</a>',
				'<a href="https://woocommerce.com">WooCommerce</a>',
			),
			$string
		);
	}


	/**
	 * Load the template of email footer.
	 */
	public function get_quote_contents_table( $quote_id ) {
		$quote_type_id = get_post_meta( $quote_id, 'quote_type', true );
		$quote_type_discount_rules_meta = get_post_meta( $quote_type_id, 'quote_type_discount_rules', true );
		$quote_type_discount_rules = ( $quote_type_discount_rules_meta === 'yes' ) ? 'yes' : 'no';
		$pricing_groups = get_post_meta($quote_id, 'quote_pricing_groups', false);
		$saved_groups = [];

		if ( ! empty( $pricing_groups ) ) {
			foreach ( $pricing_groups as $pg ) {
				$group_data = maybe_unserialize( $pg );

				if ( is_array( $group_data ) ) {
					if ( count( $group_data ) === 1 && is_array( reset( $group_data ) ) && isset( reset( $group_data )['group_id'] ) ) {
						$saved_groups[] = reset( $group_data );
					}
					elseif ( isset( $group_data['group_id'] ) ) {
						$saved_groups[] = $group_data;
					}
					else {
						foreach ( $group_data as $g ) {
							if ( isset( $g['group_id'] ) ) {
								$saved_groups[] = $g;
							}
						}
					}
				}
			}
		}

		if ($quote_type_discount_rules === 'yes' && ! empty($saved_groups)) {
			$template_data = array(
				'quote_type_discount_rules' => $quote_type_discount_rules,
				'saved_groups'              => $saved_groups,
			);
		} else {
			$quote_contents = get_post_meta( $quote_id, 'quote_contents', true );
			$quote_status   = get_post_meta( $quote_id, 'quote_status', true );

			if ( ! isset( $af_quote ) ) {
				$af_quote = new AF_R_F_Q_Quote( $quote_contents );
			}

			$price_display    = 'yes' === get_option( 'afrfq_enable_pro_price' ) ? true : false;
			$of_price_display = 'yes' === get_option( 'afrfq_enable_off_price' ) ? true : false;
			$tax_display      = 'yes' === get_option( 'afrfq_enable_tax' ) ? true : false;

			$colspan  = 1;
			$colspan += $price_display ? 1 : 0;
			$colspan += $of_price_display ? 1 : 0;

			$totals = $af_quote->get_calculated_totals( $quote_contents, $quote_id );

			$quote_subtotal = isset( $totals['_subtotal'] ) ? $totals['_subtotal'] : 0;
			$vat_total      = isset( $totals['_tax_total'] ) ? $totals['_tax_total'] : 0;
			$quote_total    = isset( $totals['_total'] ) ? $totals['_total'] : 0;
			$offered_total  = isset( $totals['_offered_total'] ) ? $totals['_offered_total'] : 0;
			$approved_total  = isset( $totals['_approved_total'] ) ? $totals['_approved_total'] : $offered_total;

			if ( empty( $quote_contents ) ) {
				return;
			}
			$price_base_type = get_post_meta( $quote_id, '_price_base_type', true );
			if ( empty($price_base_type) ) {
				$price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
			}

			$template_data = array(
				'quote_status'     => $quote_status,
				'quote_contents'   => $quote_contents,
				'price_base_type'  => $price_base_type,
				'price_display'    => $price_display,
				'of_price_display' => $of_price_display,
				'tax_display'      => $tax_display,
				'quote_subtotal'   => $quote_subtotal,
				'vat_total'        => $vat_total,
				'quote_total'      => $quote_total,
				'offered_total'    => $offered_total,
				'approved_total'   => $approved_total,
				'colspan'          => $colspan,
			);
		}
		wc_get_template(
			'emails/quote-contents.php',
			$template_data,
			'/woocommerce/addify/rfq/',
			AFRFQ_PLUGIN_DIR . 'templates/'
		);
	}

	/**
	 * Load the template of email footer.
	 */
	public function get_customer_info_table( $quote_id ) {

		$customer_info = $this->get_quote_user_info( $quote_id );

		if ( empty( $customer_info ) ) {
			return;
		}

		$customer_info = array_filter( $customer_info, function( $n ) { return ! empty( $n['value'] ); } );

		wc_get_template(
			'emails/customer-info.php',
			array(
				'customer_info' => $customer_info,
			),
			'/woocommerce/addify/rfq/',
			AFRFQ_PLUGIN_DIR . 'templates/'
		);
	}

	/**
	 * Load the template of email footer.
	 */
	public function get_quote_user_info( $quote_id ) {

		$customer_info = array();
		$quote_date    = gmdate( 'F j, Y, g:i a', get_post_time( 'U', false, $quote_id, true ) );

		$customer_info['quote_id']   = array(
			'label' => __( 'Quote Number', 'addify_rfq' ),
			'value' => '<a href="' . get_edit_post_link( $quote_id ) . '" target="_blank">' . $quote_id . '</a>',
		);
		$customer_info['quote_date'] = array(
			'label' => __( 'Quote Date', 'addify_rfq' ),
			'value' => $quote_date,
		);

		if ( ! $this->is_admin_email ) {
			$customer_info['quote_id']['value'] = '<a href="' . get_site_url() . '/my-account/request-quote/' . $quote_id . '/" target="_blank">' . $quote_id . '</a>';
		}

		$quote_fiels_obj = new AF_R_F_Q_Quote_Fields();
		$quote_fields    = (array) $quote_fiels_obj->afrfq_get_fields_enabled();

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

			if ( 'terms_cond' == $afrfq_field_type ) {
				continue;
			}

			if ( in_array( $afrfq_field_type, array( 'select', 'radio', 'mutliselect' ), true ) ) {
				$field_data = ucwords( $field_data );
			}

			if ( 'file' == $afrfq_field_type && !empty( $field_data ) ) {

				$style = 'display: block; width: 100%; text-decoration:none; background-color: #129FE0; color: white; text-align: center; width: 100%; max-width: 125px; margin: 0 auto; padding: 5px 10px; font-size: 16px; line-height: 26px; height: 25px; max-height: 25px; border-radius: 3px;';

				$field_data = sprintf('<a class="button" style="%s" href="%s">%s</a>', esc_attr( $style), esc_url( AFRFQ_URL . '/uploads/' . $field_data ), esc_html__( 'View File', 'addify_rfq') );
			}

			$customer_info[ $afrfq_field_name ] = array(
				'label' => $afrfq_field_label,
				'value' => $field_data,
			);

		}

		return $customer_info;
	}

	/**
	 * Get WooCommerce settings and return the header of email.
	 *
	 * @return string
	 */
	public function get_email_headers() {

		// Get settings from WooCommerce.
		$from_name  = get_option( 'woocommerce_email_from_name' );
		$from_email = get_option( 'woocommerce_email_from_address' );

		// More headers.
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'content-type: text/html';
		$headers[] = 'From: ' . $from_name . ' <' . $from_email . '>';

		return $headers;
	}

}

new AF_R_F_Q_Email_Controller();
