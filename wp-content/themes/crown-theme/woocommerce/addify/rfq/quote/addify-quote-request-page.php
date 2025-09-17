<?php
/**
 * Quote Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/addify/rfq/quote/addify-quote-request-page.php.
 *
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

if ( null === WC()->session ) {
    WC()->initialize_session();
}

if ( is_user_logged_in() ) {
    $current_user = wp_get_current_user();
    if ( in_array($current_user->roles[0], array('order_viewer', 'branch_employee_viewer')) ) {
        wp_redirect(home_url());
        die();
    }
}

$af_quote = new AF_R_F_Q_Quote( WC()->session->get( 'quotes' ) );
$selected_quote_type_data = get_current_user_quote_type_value();
$quote_id = ! empty( $selected_quote_type_data['id'] ) ? (int) $selected_quote_type_data['id'] : 0;
$quote_title = ! empty( $selected_quote_type_data['title'] ) ? esc_html( $selected_quote_type_data['title'] ) : 'Not Selected';
$has_discount_rules = ( get_post_meta( $quote_id, 'quote_type_discount_rules', true ) === 'yes' );
if ( ! $quote_id || ! $has_discount_rules ) {
	$has_discount_rules = false;
}

$quotes = WC()->session->get( 'quotes' );
$discount_groups = WC()->session->get( 'afrfq_discount_groups', array() );

if ( !empty( $quotes ) ) {
	
	foreach ( WC()->session->get( 'quotes' ) as $quote_item_key => $quote_item ) {

		if ( isset( $quote_item['quantity'] ) && empty( $quote_item['quantity'] ) ) {

			unset( $quotes[$quote_item_key] );
		}

		if ( !isset( $quote_item['data'] ) ) {
			unset( $quotes[$quote_item_key] );
		}
	}

	WC()->session->set( 'quotes', $quotes );
}

if ( !empty( $discount_groups ) ) {
	
	foreach ( $discount_groups as $group_key => $group_data ) {

		if ( !isset( $group_data['group_name'] ) || empty( $group_data['group_name'] ) ) {
			unset( $discount_groups[$group_key] );
		}

		if ( !isset( $group_data['price_name'] ) || !is_numeric( $group_data['price_name'] ) ) {
			unset( $discount_groups[$group_key] );
		}
	}

	WC()->session->set( 'afrfq_discount_groups', $discount_groups );
}


if ( ! empty( WC()->session->get( 'quotes' ) ) || !empty($has_discount_rules) ) {

	$quotes         = WC()->session->get( 'quotes' );
	$total          = 0;
	$user           = null;
	$user_name      = '';
	$user_email_add = '';

	if ( is_user_logged_in() ) {
		$user = wp_get_current_user(); // object
		if ( '' == $user->user_firstname && '' == $user->user_lastname ) {
			$user_name = $user->nickname; // probably admin user
		} elseif ( '' == $user->user_firstname || '' == $user->user_lastname ) {
			$user_name = trim( $user->user_firstname . ' ' . $user->user_lastname );
		} else {
			$user_name = trim( $user->user_firstname . ' ' . $user->user_lastname );
		}

		$user_email_add = $user->user_email;
	}

	do_action( 'addify_before_quote' );

	$price_display    = 'yes' === get_option( 'afrfq_enable_pro_price' ) ? true : false;
	$of_price_display = 'yes' === get_option( 'afrfq_enable_off_price' ) ? true : false;
	$tax_display      = 'yes' === get_option( 'afrfq_enable_tax' ) ? true : false;

	?>
	<h4>Quote Type: <span id="selected-quote-type-title"><?php echo $quote_title; ?></span><span class="tooltip-icon"><img src="../wp-content/uploads/2025/09/information.webp" /><span class="tooltip-text">The selected quote type has been saved. To reset, please use the Cancel Quote/Clear Quote.</span></span></h4>
	<div class="woocommerce">
		<?php woocommerce_output_all_notices(); ?>
		<form class="woocommerce-cart-form addify-quote-form <?php echo $has_discount_rules ? 'discount-quote-form' : ''; ?>" method="post" enctype="multipart/form-data">
			
			<?php
			if ( $has_discount_rules ) {
				wc_get_template( 
					'quote/quote-discount-table.php',
					array(),
					'/woocommerce/addify/rfq/',
					get_stylesheet_directory() . '/woocommerce/addify/rfq/'
				);
			} else {

				if ( file_exists( get_stylesheet_directory() . '/woocommerce/addify/rfq/front/quote-table.php' ) ) {

					include get_stylesheet_directory() . '/woocommerce/addify/rfq/front/quote-table.php';

				} else {
					wc_get_template( 
						'quote/quote-table.php',
						array(),
						'/woocommerce/addify/rfq/',
						AFRFQ_PLUGIN_DIR . 'templates/'
					);
				}
			}
			?>

			<?php do_action( 'addify_before_quote_collaterals' ); ?>
			<?php
			if (!$has_discount_rules) {
				if ( $price_display || $of_price_display ) : ?>
					<div class="after-shop-table--holder">
						<div class="cart-collaterals">
							<?php
							/**
							 * Cart collaterals hook.
							 *
							 * @hooked addify_cross_sell_display
							 * @hooked addify_quote_totals - 10
							 */
							do_action( 'addify_quote_collaterals' );
							?>
							<div class="cart_totals">

								<?php do_action( 'addify_rfq_before_quote_totals' ); ?>

								<h2><?php esc_html_e( 'Quote totals', 'addify_rfq' ); ?></h2>

								<?php
								if ( file_exists( get_stylesheet_directory() . '/woocommerce/addify/rfq/front/quote-totals-table.php' ) ) {

									include get_stylesheet_directory() . '/woocommerce/addify/rfq/front/quote-totals-table.php';

								} else {

									wc_get_template(
										'quote/quote-totals-table.php',
										array(),
										'/woocommerce/addify/rfq/',
										AFRFQ_PLUGIN_DIR . 'templates/'
									);
								}
								?>
							</div>
						</div>
						<div class="quote-copypaste">
							<?php
							wc_get_template(
								'quote/quote-copypaste.php',
								array(),
								'/woocommerce/addify/rfq/'
							);
							?>
						</div>
					</div>
				<?php endif; 
			}
			?>

			<?php do_action( 'addify_after_quote' ); ?>

			<div class="af_quote_fields">

				<?php
				if ( file_exists( get_stylesheet_directory() . '/woocommerce/addify/rfq/front/quote-fields.php' ) ) {

					include get_stylesheet_directory() . '/woocommerce/addify/rfq/front/quote-fields.php';

				} else {

					wc_get_template( 
						'quote/quote-fields.php',
						array(),
						'/woocommerce/addify/rfq/',
						AFRFQ_PLUGIN_DIR . 'templates/'
					);
				}
				?>

				<?php do_action( 'addify_after_quote_fields' ); ?>

				<?php if ( 'yes' == get_option( 'afrfq_enable_captcha' ) ) { ?>

					<?php if ( ! empty( get_option( 'afrfq_site_key' ) ) ) { ?>

						<div class="form_row">
							<div class="g-recaptcha" data-sitekey="<?php echo esc_attr( get_option( 'afrfq_site_key' ) ); ?>"></div>
						</div>
					<?php } ?>
				<?php } ?>

				<div class="form_row">
					<?php
					if ( $has_discount_rules ) {
						?>
						<input name="afrfq_action" type="hidden" value="save_afrfq_discount" />
						<?php wp_nonce_field( 'save_afrfq_discount', 'afrfq_nonce' ); ?>
						<?php
					} else {
						?>
						<input name="afrfq_action" type="hidden" value="save_afrfq" />
						<?php wp_nonce_field( 'save_afrfq', 'afrfq_nonce' ); ?>
						<?php
					}
					?>

					<?php 
					$afrfq_submit_button_text     = get_option('afrfq_submit_button_text');
					$afrfq_submit_button_bg_color = get_option('afrfq_submit_button_bg_color');
					$afrfq_submit_button_fg_color = get_option('afrfq_submit_button_fg_color');
					$afrfq_submit_button_text     = empty( $afrfq_submit_button_text ) ? __( 'Place Quote', 'addify_rfq' ) : $afrfq_submit_button_text;
					?>

					<style type="text/css">
						.addify_checkout_place_quote{
							color: <?php echo esc_html( $afrfq_submit_button_fg_color ); ?> !important;
							background-color: <?php echo esc_html( $afrfq_submit_button_bg_color ); ?> !important;
						}
					</style>

					<button type="submit" name="addify_checkout_place_quote" class="button alt addify_checkout_place_quote"><?php echo esc_html( $afrfq_submit_button_text ); ?></button>
				</div>

			</div>
		</form>

        <script>
            jQuery(document).ready(function($) {
                function updateRequiredAttributes() {
                    $('tr.addify-option-field').each(function() {
                        const isVisible = $(this).is(':visible');
                        const inputElements = $(this).find('input, select, textarea');

                        inputElements.each(function() {
                            if (isVisible) {
                                if ($(this).data('was-required')) {
                                    $(this).prop('required', true);
                                    $(this).removeData('was-required');
                                }
                            } else {
                                if ($(this).prop('required')) {
                                    $(this).data('was-required', true);
                                    $(this).prop('required', false);
                                }
                            }
                        });
                    });
                }
                updateRequiredAttributes();

				$('form.discount-quote-form').on('submit', function(e) {
				var pricingGroupCount = $(this).find('table.shop_table tbody tr').length;

				if (pricingGroupCount === 0) {
					e.preventDefault();

					$('.woocommerce-error.custom-pricing-error').remove();
					
					var errorMessage = '<ul class="woocommerce-error custom-pricing-error" role="alert"><li>No pricing groups found in your quote request. Please add at least one group.</li></ul>';

					var noticeWrapper = $('.woocommerce-notices-wrapper').first();
					if (noticeWrapper.length) {
						noticeWrapper.html(errorMessage);
					} else {
						$(this).prepend(errorMessage);
					}
					
					$('html, body').animate({
						scrollTop: $(this).offset().top - 100
					}, 500);
				}
			});

		});
        </script>

	</div>

<?php } else { ?>

	<?php woocommerce_output_all_notices(); ?>
    <?php
    $notice = WC()->session->get( 'notice_message');
    if ( isset($notice) ) {
        echo '<div class="woocommerce-message" role="alert">' . $notice . '</div>';
        WC()->session->__unset( 'notice_message');
    }
    $warnings = WC()->session->get( 'warning_messages' );
    if ( isset($warnings) && is_array($warnings) && !empty($warnings) ) {
        echo '<div class="woocommerce-notices-wrapper">';
        echo '<div class="woocommerce-error" role="alert">';
        foreach ( $warnings as $warning ) {
            echo '<p>' . $warning . '</p>';
        }
        echo '</div>';
        echo '</div>';
        WC()->session->__unset( 'warning_messages');
    }
    ?>

	<div class="addify">
        <div class="before-quote--holder">
            <div class="quote--left">
				<h4>Quote Type: <span id="selected-quote-type-title"><?php echo $quote_title; ?></span><span class="tooltip-icon"><img src="../wp-content/uploads/2025/09/information.webp" /><span class="tooltip-text">The selected quote type has been saved. To reset, please use the Cancel Quote/Clear Quote.</span></span></h4>
                <p class="cart-empty"><?php echo esc_html__( 'Your quote is currently empty.', 'addify_rfq' ); ?></p>
                <button type="button" type="submit" id="afrfq_import_quote_btn" class="button afrfq_import_quote_btn" name="import_quote" value="Import Product List">
                    <?php echo 'Import Product List'; ?>
                </button>
                <p class="return-to-shop"><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="button wc-backward"><?php echo esc_html__( 'Return To Shop', 'addify_rfq' ); ?></a>
                </p>
            </div>
            <div class="quote--right">
                <?php
                wc_get_template(
                    'quote/quote-copypaste.php',
                    array(),
                    '/woocommerce/addify/rfq/'
                );
                ?>
            </div>
        </div>
	</div>

	<?php
}
