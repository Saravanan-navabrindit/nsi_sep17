<?php
/**
 * Quote Pricing Group Section
 *
 * Displays pricing groups in the quote details and add product popup when 'apply discount rule' is enabled.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div id="quote-pricing-group-section">
    <div id="af-backbone-add-pricing-group-modal-wrapper" style="display:none;">
        <div id="af-backbone-add-pricing-group-modal" class="af-backbone-modal">
            <div class="af-backbone-modal-content">
                <section class="af-backbone-modal-main" role="main">
                    <header class="af-backbone-modal-header">
                        <h1><?php echo esc_html__( 'Add Pricing Group', 'woocommerce-request-a-quote' ); ?></h1>
                        <span class="af-backbone-close">&times;</span>
                    </header>
                    <article style="max-height: 316.5px;">
                        <form action="" method="post">
                            <table class="widefat">
                                <thead>
                                    <tr>
                                        <th><?php echo esc_html__( 'Pricing Group', 'woocommerce-request-a-quote' ); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select id="af-single_select-pricing-group" style="width:100%"></select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </article>
                    <footer>
                        <div class="inner">
                            <button id="btn-ok-pricing-group" value="<?php echo intval( get_the_ID() ); ?>" class="button button-primary button-large">
                                <?php echo esc_html__( 'Add to Quote', 'woocommerce-request-a-quote' ); ?>
                            </button>
                        </div>
                    </footer>
                </section>
            </div>
        </div>
    </div>
    <div class="woocommerce_order_items_wrapper wc-order-items-editable addify_quote_items_wrapper">
        <table class="addify_quote_items" id="addify_pricing_group_table">
            <thead>
                <tr>
                    <th><?php esc_html_e( 'Product Pricing Group', 'woocommerce-request-a-quote' ); ?></th>
                    <th><?php esc_html_e( 'Discount Level', 'woocommerce-request-a-quote' ); ?></th>
                    <th><?php esc_html_e( '', 'woocommerce-request-a-quote' ); ?></th>
                </tr>
            </thead>
            <tbody id="pricing-group-list">
            <?php
            $saved_groups = get_post_meta($post->ID, 'quote_pricing_groups', true);
            if (is_array($saved_groups) && !empty($saved_groups)) :
                foreach ($saved_groups as $group) : 
                    ?>
                    <tr data-group_id="<?php echo esc_attr($group['group_id']); ?>">
                        <td class="group-name"><?php echo esc_html($group['group_name']); ?></td>
                        <td class="price-name"><?php echo esc_html($group['price_name']); ?></td>
                        <td>
                            <a class="delete-pricing-group delete-quote-item tips" title="<?php echo $delete_title; ?>" data-group_id="<?php echo esc_attr($group['group_id']); ?>"></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>
