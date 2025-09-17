<?php

function generate_pdf($coverLetter = []) {
    $options = new Dompdf\Options();
    $options->set('isRemoteEnabled', true);

    // Instantiate the Dompdf class
    $dompdf = new Dompdf\Dompdf($options);

    require_once 'ProductList.php';
    $productList = new ProductList();
    $products = $productList->getProducts();

    $coverLetterHtml = '';
    if ($coverLetter) {
        $coverLetterHtml .= "<p><div class='row'>";
        for ($i = 0; $i < count($coverLetter); $i++) {
            $coverLetterHtml .= "<div class='column'>
                <strong>{$coverLetter[$i]['label']}:</strong> {$coverLetter[$i]['value']}
            </div>";

            // two columns in a row
            if ($i % 2 == 1) {
                $coverLetterHtml .= "</div><div class='row'>";
            } 
        }
        $coverLetterHtml .= "</div></p>";
    }

    ob_start(); ?>
<html>
    <head>
        <style>
            @page {
                margin-top: 180px;
            }
            header {
                position: fixed;
                left: 0px;
                right: 0px;
                height: 150px;
                margin-top: -150px;
            }

            .column {
                float: left;
                width: 50%;
            }
            .row:after {
                content: "";
                display: table;
                clear: both;
            }
            .wrapper { page-break-after: always; }
            .wrapper:last-child { page-break-after: never; }

            .woocommerce-product-attributes-item__label {
                text-align: left;
            }

            .text-center { text-align: center;}
        </style>
    </head>
    <body>
        <header>
            <div class="row">
                <div class="column" style="width:70%">
                    <a href="<?php echo home_url('/'); ?>"><img alt="NSI Logo" src="<?php 
                            echo wp_get_attachment_image_url(
                                get_option('theme_config_site_logo_color'),
                                'large'
                            ); 
                        ?>" /></a>
                </div>
                <div class="column">
                    <p>
                        <?php echo nl2br(get_option('theme_config_contact_address')); ?><br />
                        <?php echo get_option('theme_config_contact_phone'); ?><br />
                        <a href="mailto:<?php 
                            echo esc_attr(get_option('theme_config_contact_email')); 
                        ?>"><?php echo get_option('theme_config_contact_email'); ?></a>
                    </p>
                </div>
            </div>
        </header>
        <main>
<?php 
    foreach($products as $p) {
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

        $link = '<a href="' . $p->guid . '">' . $product->get_name() . '</a>'; ?>
        <hr>
        <div class="wrapper">
            <h2 class="text-center"><?php echo $productList->getTitle() ?></h2>
            <?php echo $coverLetterHtml ?>
            <h2><?php echo $product->get_title() ?></h2>
            <p>#<?php echo $product->get_sku() ?></p>
            <p><?php echo $product->get_description() ?></p>
            <div><?php echo $image ?></div>
            <div><?php echo $link ?></div>
            <div class="row">
                <div class="column">
                    <h3>Product Information</h3>
                    <?php wc_display_product_attributes( $product ) ?>
                </div>
                <?php 
                    $documents = get_post_meta($p->ID, 'product_doc_data', true);
                    
                    if (count($documents) > 5) {
                        usort($documents, function($a, $b) {
                            $prioritized = ['prodsheet', 'prodspec', 'prodraw'];
                            return in_array(strtolower($a['filename']), $prioritized) ? -1 :
                                (in_array(strtolower($b['filename']), $prioritized) ? 1 : 0);
                        });
                        
                        $documents = array_slice($documents, 0, 5);
                    }

                    if ($documents) { ?>
                        <div class="column">
                            <h3>Product Documents</h3>
                            <?php foreach($documents as $document) {
                                $url = Crown_Shop_Display::convert_amplifi_cdn_src($document['src']);
                                echo "<p><a href='{$url}' target='_blank'>{$document['filename']}</a></p>";
                            } ?>
                        </div>
                    <?php } ?>
                </div><!-- .row -->
            </div><!-- .wrapper -->
    <?php } ?>
        
        </main>
    </body>
</html>
<?php
    $html = ob_get_clean();
    $dompdf->loadHtml($html);
    $dompdf->render();

    $path = get_option('submittal_pdf_store_path');
    $name = uniqid(rand()) . '.pdf';

    file_put_contents($path . $name, $dompdf->output());
    return $name;
}

function custom_rewrite_rule() {
  add_rewrite_rule('^download-pdf/?', 'index.php?download_pdf=true', 'top');
}
add_action('init', 'custom_rewrite_rule', 10, 0);

function custom_query_vars($vars) {
  $vars[] = 'download_pdf';
  return $vars;
}
add_filter('query_vars', 'custom_query_vars', 10, 1);

function check_for_pdf_download() {
  global $wp_query;
  if(isset($wp_query->query_vars['download_pdf'])) {
      generate_pdf();
      exit;
  }
}
add_action('template_redirect', 'check_for_pdf_download');