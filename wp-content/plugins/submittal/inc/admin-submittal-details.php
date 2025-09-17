<?php

if (!defined('ABSPATH')) exit;

global $wpdb;

$submittal_id = absint($_GET['submittal_id']);

$submittal = $wpdb->get_row($wpdb->prepare("
    SELECT
        s.*,
        COALESCE(u.user_login, su.id) AS user
    FROM {$wpdb->prefix}submittals s
    LEFT JOIN {$wpdb->prefix}submittal_users su 
        ON su.id = s.user_id
    LEFT JOIN {$wpdb->prefix}users u 
        ON u.id = su.user_id
    WHERE s.id = %d",
    [$submittal_id]
));

$deletedBy = $submittal->deleted_by ?
    get_userdata($submittal->deleted_by)->user_login :
    'User';

$products = $wpdb->get_results($wpdb->prepare("
    SELECT *
    FROM {$wpdb->prefix}submittal_products AS sp
    LEFT JOIN {$wpdb->prefix}posts AS p
        ON sp.product_id = p.id
    WHERE sp.submittal_id = %d",
    [$submittal_id]
));

$details = $wpdb->get_results($wpdb->prepare("
    SELECT *
    FROM {$wpdb->prefix}submittal_details
    WHERE `submittal_id` = %d
    ORDER BY `id` DESC",
    [$submittal_id]
));

?>
<div class="wrap">
    <h1>Submittal Details</h1>
    <h2><?php echo $submittal->title ?></h2>
    <h4>User: <?php echo $submittal->user ?></h4>
    <h4>Created At: <?php echo $submittal->created_at ?></h4>
    <?php if ($submittal->deleted_at) { ?>
        <h4>Deleted At: <?php echo $submittal->deleted_at ?></h4>
        <h4>Deleted By: <?php echo $deletedBy ?></h4>
    <?php } ?>
    <?php if (count($products)) { ?>
        <h3>Products</h3>
        <table class="widefat fixed striped">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>SKU</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p) { 
                    $product = wc_get_product($p->ID);

                    if (!$product) continue;

                    $images = get_post_meta( $p->ID, '__product_image_srcs');

                    if ($images) {
                        $image = sprintf(
                            '<img src="%s" alt="%s" class="preview-image"/>', 
                            esc_url(Crown_Shop_Display::convert_amplifi_cdn_src($images[0]) . '_small.jpg'),
                            $product->get_name()
                        );
                    } else {
                        $image = sprintf(
                            '<img src="%s" alt="%s" class="preview-image"/>',
                            esc_url(wc_placeholder_img_src('woocommerce_single')),
                            esc_html__('Awaiting product image', 'woocommerce')
                        );
                    }

                    $link = '<a href="' . $p->guid . '">' . $product->get_name() . '</a>';               
                ?>
                    <tr>
                        <td><?php echo $image ?></td>
                        <td><?php echo $link ?></td>
                        <td><?php echo $product->get_sku() ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
    <?php if (count($details)) { ?>               
        <h3>Details</h3>
        <table class="widefat fixed striped">
            <thead>
                <tr>
                    <th>Emails</th>
                    <th>PDF</th>
                    <th>Sent At</th>
                    <th>Cover Letter</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($details as $detail) { ?>
                    <tr>
                        <td><?php echo $detail->emails ?></td>
                        <td>
                            <a 
                                href="<?php echo get_option('submittal_pdf_view_path') . $detail->pdf ?>" 
                                target="_blank"
                            >
                                <?php echo $detail->pdf ?>
                            </a>    
                        </td>
                        <td><?php echo $detail->created_at ?></td>
                        <td>
                            <?php 
                                $fields = json_decode($detail->cover_letter, true);
                                foreach ($fields as $key => $value) {
                                    $title = preg_split('/(?=[A-Z])/', $key);
                                    $title = implode(' ', $title);
                                    $title = ucwords($title);
                                    
                                    echo "<strong>{$title}</strong>: {$value} ";
                                }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>