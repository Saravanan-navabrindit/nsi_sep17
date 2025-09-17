<?php
/**
 * Quote details in Meta box.
 *
 * It shows the details of quotes items in meta box.
 *
 * @package addify-request-a-quote
 * @version 1.6.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$quote_contents = get_post_meta( $post->ID, 'quote_contents', true );
$quote_status   = get_post_meta( $post->ID, 'quote_status', true );
$user_id        = get_post_meta( $post->ID, '_customer_user', true );
$af_quote       = new AF_R_F_Q_Quote( $quote_contents );
$post_status = $post->post_status;

$quote_totals = $af_quote->get_calculated_totals( (array) $quote_contents, $post->ID );

$quote_id = $post->ID;

$disable_button = false;
$sku_with_zero_subtotal = [];

foreach ($quote_contents as $item) {
    if (isset($item['role_base_price']) && $item['role_base_price'] == 0) {
        $disable_button = true;
        if (isset($item['data']->get_data()['sku'])) {
            $sku_with_zero_subtotal[] = $item['data']->get_data()['sku'];
        }
    }
}

$sku_message = '';
if (!empty($sku_with_zero_subtotal)) {
    $sku_message = 'This SKU have 0 subtotal: <b> ' . implode(', ', $sku_with_zero_subtotal) . '</b>. Please remove these SKUs if you want to convert this quote to the order.';
}

$disable_quote_buttons = false;
if ( $post_status == 'auto-draft' ) {
    $disable_quote_buttons = true;
    echo '<div class="notice notice-error inline">';
    echo '<p>Please create a new quote first by clicking the <b>Publish button</b>, only then adding new items to the quote will be possible.</p>';
    echo '</div>';
}
?>
<div class="woocommerce_order_items_wrapper wc-order-items-editable addify_quote_items_wrapper">
	<?php
	do_action( 'addify_rfq_order_details_before_order_table', $post );

    // Fetch selected quote type
    $quote_type_id = get_post_meta($post->ID, 'quote_type', true);
    $show_pricing_group = false;
    $disable_convert_order_button = false;
    if ($quote_type_id) {
        $apply_discount = get_post_meta($quote_type_id, 'quote_type_discount_rules', true);
        if ($apply_discount === 'yes') {
            $show_pricing_group = true;
        }

        if ('yes' === get_post_meta($quote_type_id, 'quote_type_disable_convert_order', true)) {
        $disable_convert_order_button = true;
        }
    }

    if ($show_pricing_group) {
        require AFRFQ_PLUGIN_DIR . 'admin/meta-boxes/quotes/quote-pricing-group-section.php';
    } else {
        echo '<div id="add-product-section">';
        require AFRFQ_PLUGIN_DIR . 'admin/meta-boxes/quotes/quote-details-table.php';
        echo '</div>';
        echo '<div id="add-product-modal-section">';
        ?>
        <div id="af-backbone-add-product-modal" class="af-backbone-modal">
            <div class="af-backbone-modal-content">
                <section class="af-backbone-modal-main" role="main">
                    <header class="af-backbone-modal-header">
                        <h1><?php echo esc_html__( 'Add product', 'addify_rfq' ); ?></h1>
                        <span class="af-backbone-close">&times;</span>
                    </header>
                    <article style="max-height: 316.5px;">
                        <form action="" method="post">
                        </form>
                    </article>
                    <footer>
                        <div class="inner">
                            <button id="btn-ok" value="<?php echo intval( $post->ID ); ?>" class="button button-primary button-large">
                                <?php echo esc_html__( 'Add to Quote', 'addify_rfq' ); ?>
                            </button>
                        </div>
                    </footer>
                </section>
            </div>
        </div>
        <?php
        echo '</div>';
    }

	do_action( 'addify_rfq_order_details_after_order_table', $post );
	?>
	<div id="af-backbone-add-product-modal" class="af-backbone-modal">
		  <div class="af-backbone-modal-content">
			<section class="af-backbone-modal-main" role="main">
				<header class="af-backbone-modal-header">
					<h1><?php echo esc_html__( 'Add product', 'addify_rfq' ); ?></h1>
						<span class="af-backbone-close">&times;</span>
				</header>
				<article style="max-height: 316.5px;">
					<form action="" method="post">
						<table class="widefat">
							<thead>
								<tr>
									<th><?php echo esc_html__( 'Product', 'addify_rfq' ); ?></th>
									<th><?php echo esc_html__( 'Quantity', 'addify_rfq' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<td>
									<select class="af-single_select-product">	
									</select>
								</td>
								<td>
									<input type="number" min='1' name="afacr_product_quantity" value="1">
								</td>
							</tbody>
						</table>
					</form>
				</article>
				<footer>
					<div class="inner">
						<button id="btn-ok" value="<?php echo intval( $post->ID ); ?>" class="button button-primary button-large">
							<?php echo esc_html__( 'Add to Quote', 'addify_rfq' ); ?>
						</button>
					</div>
				</footer>
			</section>
		</div>
	</div>
    <?php if ($disable_button) { ?>
        <p class="custom-notice-message-of-empty-subtotal" style="float: right"><?= $sku_message; ?></p>
    <?php } ?>
    <?php
    $current_user = wp_get_current_user();
    if (
        !in_array($quote_status, array('af_converted', 'af_cancelled', 'af_declined', 'af_expired', 'af_pending')) ||
        in_array($current_user->roles[0], array('administrator', 'pricing', 'dual_shop_manager'))
    ) {
        ?>
        <div class="addify_converty_to_order_button">
            <div class="left-buttons">
                <?php if ($show_pricing_group) { ?>
                    <button type="button" id="addify_add_pricing_group" name="addify_add_pricing_group" class="button add-pricing-group"<?php echo $disable_quote_buttons ? ' disabled' : '';?> >
                        <?php echo esc_html__( 'Add Pricing Group', 'addify_rfq' ); ?>
                    </button>
                <?php } else { ?>
                    <button type="button" id="addify_add_item" name="addify_add_item" class="button add-product"<?php echo $disable_quote_buttons ? ' disabled' : '';?> >
                        <?php echo esc_html__( 'Add product(s)', 'addify_rfq' ); ?>
                    </button>
                <?php } ?>
                <?php if ($show_pricing_group) { ?>
                   <button type="button" id="afrfq_import_quote_pricing_btn" class="button add-product afrfq_import_quote_pricing_btn afrfq_import_quote_admin_btn"
                        name="import_quote" value="Import Pricing Group List"<?php echo $disable_quote_buttons ? ' disabled' : '';?>>
                    <?php echo 'Import Pricing Group List'; ?>
                <?php } else { ?>
                <button type="button" type="submit" id="afrfq_import_quote_btn" class="button add-product afrfq_import_quote_btn afrfq_import_quote_admin_btn"
                        name="import_quote" value="Import Product List"<?php echo $disable_quote_buttons ? ' disabled' : '';?>>
                    <?php echo 'Import Product List'; ?>
                </button>
                <?php } ?>
                <button type="button" id="afrfq_update_quote_admin_btn" class="button afrfq_update_quote_admin_btn"
                        name="update_quote" data-quote_id="<?php echo $post->ID;?>"<?php echo $disable_quote_buttons ? ' disabled' : '';?>>
                    Submit
                </button>
            </div>
            <?php
                if ( 'af_converted' !== $quote_status && !$disable_convert_order_button ) : ?>
                    <div class="right-buttons">
                        <button type="submit" name="addify_convert_to_order" class="button button-primary button-large"
                            <?php echo $disable_button ? 'disabled' : ''; ?>
                            <?php echo $disable_quote_buttons ? ' disabled' : '';?>
                        >
                            <?php echo esc_html__( 'Convert to Order', 'addify_rfq' ); ?>
                        </button>
                    </div>
                <?php endif; ?>
        </div>
    <?php } ?>
</div>
