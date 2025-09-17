<?php
/**
 * Order Document template
 */

defined( 'ABSPATH' ) || exit;

$order = $order_data['order'];
$order_items = $order_data['order_items_details'] ?? array();
$line_level_discount = 0;
?>

<html>
<head>
    <style>
        * {
            font-family: NotoSans, sans-serif;
        }
        @page {
            margin: 350px 40px 150px 40px;
        }
        .header {
            position: fixed;
            top: -300px;
            left: 0;
            right: 0;
            height: 300px;
            text-align: center;
        }
        .footer {
            position: fixed;
            bottom: -80px;
            left: 0;
            right: 0;
            height: 80px;
            width: 100%;
            text-align: center;
            padding-top: 5px;
        }
        .content {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }
        .content th, .content tr {
            border-collapse: collapse;
        }
        .header .pagenum:after {
            content: counter(page);
        }
        table {
            font-size: 9pt;
            table-layout: fixed;
        }
        th {
            font-weight: bold;
            font-size: 8pt;
            vertical-align: middle;
            padding: 5px 6px 3px;
            background-color: #0000FF;
            color: #FFFFFF;
        }
        td {
            padding: 4px 6px;
        }
        td p { text-align:left }
        table.itemtable {
            border-collapse: collapse;
            border: 1px solid #000000;
        }
        table.itemtable td {
            padding: 5px;
            border-collapse: collapse;
            border: 0.5px solid #000000;
        }
        table.itemtable th {
            padding-bottom: 10px;
            padding-top: 10px;
            border: 1px solid #000000;
        }
        table.itemtable td, table.itemtable tr {
            border-top: none;
        }
    </style>
</head>
<body>
<div class="header">
    <table style="width: 100%;">
        <tr>
            <td colspan="4">
                <img src="<?php echo wp_get_attachment_image_url( get_option( 'theme_config_order_documents_logo' ), 'full' ); ?>" alt="NSI Industries logo" style="float: left; margin-bottom: -55px; width: 60px; height: 70px;" />
            </td>
            <td align="center" colspan="4"><b><span style="font-size:16pt;">Sales Order</span></b></td>
            <td colspan="2" style="text-align: right;">Number:</td>
            <td colspan="2"><b><?php echo esc_html( $order_data['order_tran_id'] ); ?></b></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td style="text-align: right;" colspan="2">Customer:</td>
            <td colspan="2"><b><?php echo esc_html( $order_data['customer_name'] ); ?></b></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td style="text-align: right;" colspan="2">Sales Order Date:</td>
            <td colspan="2"><b><?php echo get_the_date('n/d/Y', $order_id); ?></b></td>
        </tr>
        <tr>
            <td colspan="4">Remit To: <strong><?php echo esc_html( $order_data['subsidiary_name'] ); ?></strong></td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4"><?php echo nl2br(get_option( 'subsidiary_settings_address', "PO Box 842924\r\nDallas, TX 75284-2924" ) ); ?></td>
            <td colspan="4">&nbsp;</td>
            <td style="text-align: right;" colspan="2"><span>Page: </span></td>
            <td colspan="2"><b><span class="pagenum"></span></b></td>
        </tr>
        <tr>
            <td colspan="4">Phone: <b></b></td>
            <td colspan="4"></td>
            <td style="text-align: right;" colspan="2"><span>Partner Rep: </span></td>
            <td colspan="2"><b><?php echo esc_html( $order_data['partner'] ); ?></b></td>
        </tr>
        <tr>
            <td colspan="4">Email: <?php echo esc_html( $order_data['subsidiary_email'] ); ?></td>
            <td style="text-align: center;" colspan="4">&nbsp;</td>
            <td style="text-align: right;" colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
</div>

<div class="footer">
    <table class="footer-content" style="width: 100%;">
        <tr>
            <td style="width: 35%;">GST#86415-4430-RT0001</td>
            <?php if ( $order_data['division_name'] === 'Electrical') { ?>
                <td>
                    <img src="<?php echo wp_get_attachment_image_url( get_option( 'theme_config_order_documents_footer' ), 'full' ); ?>" alt="NSI brands" style="width: 100%; height: 70px;" />
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td style="width: 35%;"><b>www.nsiindustries.com</b></td>
        </tr>
    </table>
</div>

<div class="content">
    <table style="border-collapse: collapse; border: none; width: 100%; margin-top: 10px;">
        <tr style="border: none;">
            <td colspan="2" style="border: none; background-color:blue; padding-left:75px;"><b><span style="color: white;">Sold To</span></b></td>
            <td colspan="2" style="border: none; background-color:blue; padding-left:75px;"><b><span style="color: white;">Ship To</span></b></td>
        </tr>
        <tr style="border: none;">
            <td colspan="2" rowspan="2" style="border: none; padding-left:75px;"><?php echo $order_data['billing_address']; ?></td>
            <td colspan="2" rowspan="2" style="border: none; padding-left:75px;"><?php echo $order_data['shipping_address']; ?></td>
        </tr>
    </table>

    <table style="border-collapse: collapse; margin-top:10px; width:100%; border: 1px solid #000000;">
        <tr>
            <th style="text-align: center; background-color: blue; border-color: rgb(0, 0, 0);"><span style="color: white;">Customer P.O</span></th>
            <th style="text-align: center; background-color: blue; border-color: rgb(0, 0, 0);"><span style="color: white;">Ship Via</span></th>
            <th style="text-align: center; background-color: blue; border-color: rgb(0, 0, 0);"><span style="color: white;">F.O.B.</span></th>
            <th style="text-align: center; background-color: blue; border-color: rgb(0, 0, 0);"><span style="color: white;">Terms</span></th>
        </tr>
        <tr>
            <td style="text-align: left; border-color: rgb(0, 0, 0); border-right: 1px solid black;"><?php echo esc_html( $order_data['customer_po'] ); ?></td>
            <td style="text-align: center; border-color: rgb(0, 0, 0); border-right: 1px solid black;"><?php echo esc_html( $order_data['shipping_carrier'] ); ?></td>
            <td style="text-align: left; border-color: rgb(0, 0, 0); border-right: 1px solid black;"></td>
            <td style="text-align: center; border-color: rgb(0, 0, 0); border-right: 1px solid black;"><?php echo esc_html( $order_data['terms'] ); ?></td>
        </tr>
    </table>

    <table class="itemtable" style="width: 100%; margin-top: 10px;">
        <thead>
        <tr>
            <th style="text-align: left; width: 20%;">Item</th>
            <th style="text-align: left; width: 50%;">Description</th>
            <th style="text-align: left; width: 20%;">QTY&nbsp;Ordered</th>
            <th style="text-align: left; width: 20%;">QTY B.O</th>
            <th style="text-align: left; width: 20%;">Price</th>
            <th style="text-align: left; width: 20%;">Amount</th>

        </tr>
        </thead>
        <?php foreach ($order_items as $sku => $item) {
            $description = $item['description'] ?? '';
            $quantity = $item['quantity'] ?? 0;
            $qty_billed = $item['quantity_billed'] ?? 0;
            $qty_committed = $item['quantity_committed'] ?? 0;
            $qty_backordered = $quantity - ($qty_committed + $qty_billed);
            $rate = $item['rate'] ?? 0;
            $subtotal = $item['item_amount'] ?? 0;
            ?>
            <tr>
                <td><?php echo esc_html( $sku ); ?></td>
                <td style="line-height: 19px;">
                    <?php if ( ! empty( $description ) ) { ?>
                        <?php echo esc_html( $description ); ?><br />
                    <?php } ?>
                    <b>Ship Track Num:</b> <?php echo esc_html( $order_data['tracking_no'] ); ?><br />
                    <b>Ship Method:</b> <?php echo esc_html( $order_data['shipping_carrier'] ); ?>
                </td>
                <td style="width: 90px;"><?php if ( ! empty( $description ) ) echo esc_html( $quantity ); ?></td>
                <td style="width: 90px;"><?php if ( ! empty( $description ) ) echo esc_html( $qty_backordered ); ?></td>

                <?php if ( $rate < 0 ) { ?>
                    <td style="width: 103px;"><?php echo $rate . '%'; ?></td>
                <?php } else { ?>
                    <td style="width: 103px;"><?php echo wc_price( $rate ); ?></td>
                <?php } ?>

                <?php if ( $subtotal < 0 ) {
                    $line_level_discount += $subtotal;?>
                    <td style="width: 120px;"><?php echo  '(' . wc_price(  abs($subtotal) ) . ')'; ?></td>
                <?php } else { ?>
                    <td style="width: 120px;"><?php echo wc_price( $subtotal ); ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>

    <table style="border: none; width:60%; float: right; page-break-inside:avoid; padding-top: 15px;">
        <tr>
            <td style="border: none; text-align: right; width: 65%;"><b>Gross</b></td>
            <td style="border: none; text-align: right;"><?php echo wc_price( $order->get_subtotal() ); ?></td>
        </tr>
        <?php if ( ! empty( $line_level_discount ) ) {?>
        <tr>
            <td style="border: none; text-align: right; width: 65%;">Line Level Discounts</td>
            <td style="border: none; text-align: right;"><?php echo '(' . wc_price(  abs( $line_level_discount ) ) . ')'; ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td style="border: none; text-align: right; width: 65%;"><b>Subtotal (Net of Line-level Disc)</b></td>
            <td style="border: none; text-align: right;"><?php echo wc_price( $order->get_subtotal() - $order->get_total_discount() ); ?></td>
        </tr>
        <?php if ( isset( $order_data['total_discount'] ) && ! empty( $order_data['discount_label'] ) ) {?>
        <tr>
            <td style="border: none; text-align: right;"><?php echo esc_html( $order_data['discount_label'] ); ?></td>
            <td style="border: none; text-align: right;"><?php echo $order_data['total_discount']; ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td style="border: none; text-align: right; width: 65%;"><b>Subtotal (Net of all Discounts)</b></td>
            <td style="border: none; text-align: right;"><?php echo wc_price( $order->get_subtotal() - $order->get_total_discount() ); ?></td>
        </tr>
        <tr>
            <td style="border: none; text-align: right;">Freight</td>
            <td style="border: none; text-align: right;"><?php echo wc_price( $order->get_shipping_total() ); ?></td>
        </tr>
        <tr>
            <td style="border: none; text-align: right;">Tax Total</td>
            <td style="border: none; text-align: right;"><?php echo wc_price( $order->get_total_tax() ); ?></td>
        </tr>
        <tr>
            <td style="border: none; text-align: right;">Total</td>
            <td style="border: none; text-align: right;"><?php echo wc_price( $order->get_total() ); ?></td>
        </tr>
        <tr>
            <td style="border: none;">&nbsp;</td>
        </tr>
    </table>
</div>
</body>
</html>