<?php

require_once plugin_dir_path(__FILE__) . 'ProductList.php';

$productList = new ProductList();
$productsCount = count($productList->getProducts());

global $wpdb;

$table_submittals = $wpdb->prefix . 'submittals';
$table_submittal_users = $wpdb->prefix . 'submittal_users';

$submittalUser = $wpdb->get_row($wpdb->prepare("
    SELECT *
    FROM {$table_submittal_users}
    WHERE `cookie_id` = %s",
    [$_COOKIE['submittal_user_key']]
));

$submittals = $wpdb->get_results($wpdb->prepare("
    SELECT *
    FROM {$table_submittals}
    WHERE 
        `user_id` = %d AND
        `deleted_at` IS NULL",
    [$submittalUser->id]
));

$submittalTitle = '';
foreach($submittals as $submittal) {
    if ($submittal->id == $submittalUser->current_submittal_id) {
        $submittalTitle = $submittal->title;
        break;
    }
}

get_header(); ?>
<div class="container">
    <?php if (count($submittals) > 1) {
        require_once plugin_dir_path(__FILE__) . 'remove-submittal-modal.php';
    } ?>
    <div class="row mt-5">
        <div class="col-6">
            <div class="d-flex align-items-end">
                <div class="form-group w-75 mb-0 mr-2">
                    <label for="submittals-list">My submittals</label>
                    <select class="form-control" id="submittals-list">
                        <?php foreach($submittals as $submittal) { ?>
                            <option
                            value="<?php echo $submittal->id ?>"
                            <?php echo ($submittal->id == $submittalUser->current_submittal_id ? 
                                'selected' : ''
                                ) ?>
                            >
                                <?php echo mb_strimwidth($submittal->title, 0, 45, '...') ?>
                            </option>
                        <?php } ?>
                    </select>
                </div><!-- .form-group -->
                <?php if (count($submittals) > 1) { ?>
                    <button
                        class="btn btn-primary"
                        data-toggle="modal"
                        data-target="#remove-submittal-modal"
                    >
                        Delete
                    </button>
                <?php } ?>
            </div>
        </div><!-- .col-6 -->
        <div class="col-6">
            <div class="d-flex align-items-end">
                <div class="form-group w-75 mb-0 mr-2">
                    <label for="submittal-title">Create new submittal</label>
                    <input type="text" class="form-control" id="submittal-title" placeholder="Title" />
                </div>
                <button class="btn btn-primary" id="add-submittal" disabled>Create</button>
            </div>
        </div><!-- .col-6 -->
    </div><!-- .row -->
    <div class="row mb-5">
        <div class="col-6"></div>
        <div class="col-6">
            <div class="invalid-feedback" id="title-validation-feedback">
                Max allowed length is 255 characters
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col my-4"><h2 class="text-center"><?php echo $submittalTitle ?> Submittal</h2></div>
    </div>
    <div
        id="empty-submittal"
        class="row my-4 <?php echo ($productsCount > 0 ? 'd-none' : '') ?>"
    >
        <div class="col">
            <h3 class="text-center text-uppercase">Your project submittal is empty</h3>
            <h4 class="text-center my-3">Click <a href="<?php echo home_url('/shop'); ?>" class="text-uppercase text-muted">here</a> to continue browsing our products</h4>
        </div>
    </div>
    <div 
        id="main-submittal"
        class="row my-4 <?php echo ($productsCount == 0 ? 'd-none' : '') ?>"
    >
        <div class="col-8">
            <h4 class="text-center">
                Total products:
                <span
                    id="products-counter"
                    data-total="<?php echo $productsCount ?>"
                >
                    <?php echo $productsCount ?>
                </span>
            </h4>
            <div class="container overflow-auto" style="height: 50vh">
            <?php 
                foreach($productList->getProducts() as $p) { 
                    $product = wc_get_product($p->ID); // @TODO remove request
                    if (!$product) continue;

                    $images = get_post_meta( $p->ID, '__product_image_srcs');

                    if ( $images ) {
                    $image = sprintf(
                        '<img src="%s" alt="%s" style="width: 100px" />', 
                        esc_url(Crown_Shop_Display::convert_amplifi_cdn_src($images[0]) . '_small.jpg'),
                        $product->get_name()
                    );
                    } else {
                    $image = sprintf( '<img src="%s" alt="%s" style="width: 100px" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
                    }

                    $link = '<a href="' . $p->guid . '">' . $product->get_name() . '</a>';
                    
                    ?>
                    <div class="row align-items-center">
                        <div class="col-2"><?php echo $image ?></div>
                        <div class="col-8"><?php echo $link ?></div>
                        <div class="col-2">
                            <button 
                                class="js-remove-from-submittal-page btn btn-secondary btn-sm active"
                                data-product-id="<?php echo $p->ID ?>"
                                data-product-title="<?php echo $product->get_name() ?>"
                            >Remove</button>
                        </div>
                    </div><!-- .row -->
                <?php } ?>
            </div><!-- .container -->
            <div class="row my-4">
                <div class="col">
                    <a
                        href="<?php echo home_url('/shop'); ?>"
                        class="btn btn-primary"
                        role="button"
                        aria-pressed="true"
                    >Add products</a>
                </div>
            </div>
        </div>
        <div class="col-4">
            <?php require_once plugin_dir_path(__FILE__) . 'submittal-form.php'; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>