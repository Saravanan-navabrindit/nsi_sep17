<?php

require_once plugin_dir_path(__FILE__) . 'ProductList.php';

$productList = new ProductList();
$productsCount = count($productList->getProducts());
$coverLetter = $productList->getCoverLetter();

$coverLetterHtml = '';
if ($coverLetter) {
    $coverLetterHtml .= "<hr /><div class='row'>";
    for ($i = 0; $i < count($coverLetter); $i++) {
        $coverLetterHtml .= "<div class='col-6'>
            <p><strong>{$coverLetter[$i]['label']}:</strong> {$coverLetter[$i]['value']}</p>
        </div>";

        // two columns in a row
        if ($i % 2 == 1) {
            $coverLetterHtml .= "</div><div class='row'>";
        } 
    }
    $coverLetterHtml .= "</div>";
}

get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col my-4">
            <h2 class="text-center text-uppercase">
                <?php echo $productList->getTitle() ?> specification
            </h2>
        </div>
    </div>
    <div class="row my-4">
        <a 
            href="<?php echo $productList->getPdf() ?>" 
            class="btn btn-primary mx-auto" 
            target="_blank"
        >Get Submittal PDF</a>
    </div>
    <div class="row">
        <div class="col-8">
            <a href="<?php echo home_url('/'); ?>"><img alt="NSI Logo" src="<?php 
                echo wp_get_attachment_image_url(
                    get_option('theme_config_site_logo_color'),
                    'large'
                ); ?>" /></a>
        </div>
        <div class="col-4">
            <p class="adress"><?php echo nl2br( get_option( 'theme_config_contact_address' ) ); ?></p>

            <p class="phone"><?php echo get_option( 'theme_config_contact_phone' ); ?></p>

            <p class="email"><a href="mailto:<?php  echo esc_attr( get_option( 'theme_config_contact_email' ) ); ?>"><?php echo get_option( 'theme_config_contact_email' ); ?></a></p>
        </div>
    </div>

    <?php echo $coverLetterHtml ?>

    <?php foreach($productList->getProducts() as $p) {
        $product = wc_get_product($p->ID);
        if (!$product) continue;
        $images = get_post_meta( $p->ID, '__product_image_srcs');

        if ( $images ) {
            $url = Crown_Shop_Display::convert_amplifi_cdn_src($images[0]);
            $image = sprintf(
                '<img src="%s" alt="%s" style="width: 100px" /><a href="%s" target="_blank" download>Download</a>', 
                esc_url($url . '_small.jpg'),
                $product->get_name(),
                esc_url($url . '_medium.jpg')
            );
        } else {
            $image = sprintf(
                '<img src="%s" alt="%s" style="width: 100px" />',
                esc_url( wc_placeholder_img_src( 'woocommerce_single' )),
                esc_html__( 'Awaiting product image', 'woocommerce' )
            );
        }

        $link = '<a href="' . $p->guid . '">' . $product->get_name() . '</a>';
        
        ?>
        <hr>
        <div class="row">
            <div class="col-12">
                <h3><?php echo $product->get_title() ?></h3>
                <p>#<?php echo $product->get_sku() ?></p>
                <p><?php echo $product->get_description() ?></p>
                <p><?php echo $image ?></p>
                <p><?php echo $link ?></p>
                <div class="row">
                    <div class="col-6">
                        <h4>Product Information</h4>
                        <?php wc_display_product_attributes( $product ) ?>
                    </div>
                    <?php 
                    $documents = get_post_meta($p->ID, 'product_doc_data', true);
                    if ($documents) { ?>
                        <div class="col-6">
                            <h4>Product Documents</h4>
                            <?php foreach($documents as $document) {
                                $url = Crown_Shop_Display::convert_amplifi_cdn_src($document['src']);
                                echo "<p><a href='{$url}' target='_blank'>{$document['filename']}</a></p>";
                            } ?>
                        </div>
                <?php } ?>
                </div><!-- .row -->
            </div><!-- .col -->
        </div><!-- .row -->
    <?php } ?>
</div><!-- .container -->

<?php get_footer(); ?>