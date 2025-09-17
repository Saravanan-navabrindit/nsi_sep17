<label for="filter_rma"><?php esc_html_e( 'Search by Sales Order#, PO# or Return Confirmation#', 'nsi-rma' ); ?></label>
<form method="get" class="rma--form-search">
    <input type="text" name="filter_rma" id="filter_rma" value="<?php echo esc_attr($filter_rma); ?>" placeholder="<?php esc_html_e( 'SO#, PO# or Return Confirmation#', 'nsi-rma' );?>" />
    <?php echo NSI_RMA_Post_Type::render_rma_listing_filters(); ?>
    <button class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button rma--form-seach__btn" type="submit">
        <?php esc_html_e( 'Apply', 'nsi-rma' ); ?>
    </button>
    <?php if (!empty($_GET['filter_rma']) || !empty($_GET['rma_status'])): ?>
        <a href="<?php echo esc_url(remove_query_arg(['filter_rma', 'rma_status'])); ?>" class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button rma--form-seach__btn reset-btn"><?php esc_html_e( 'Reset', 'nsi-rma' ); ?></a>
    <?php endif; ?>
</form>