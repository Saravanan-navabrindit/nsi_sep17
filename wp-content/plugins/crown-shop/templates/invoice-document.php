<?php
/**
 * Order Document template
 */

defined( 'ABSPATH' ) || exit;
$invoice_info = maybe_unserialize($invoice_data['invoice_info']);
$invoice_items = maybe_unserialize($invoice_data['items_info']);
$billing_address = ! empty($invoice_info['billing_address']) ? nl2br( $invoice_info['billing_address'] ) : $order_data['billing_address'];
$shipping_address = ! empty($invoice_info['shipping_address']) ? nl2br( $invoice_info['shipping_address'] ) : $order_data['shipping_address'];
$amount_paid = $invoice_info['amount_paid'] ?? 0;
if ($invoice_info['amount_remaining'] == 0) {
    if ( is_numeric( $invoice_info['custbody_amtdue'] ) ) {
        $balance_due = wc_price( $invoice_info['custbody_amtdue'] );
    } else {
        $balance_due = esc_html( $invoice_info['custbody_amtdue'] );
    }
} else {
    $balance_due = wc_price( $invoice_info['amount_remaining'] );
}
$amount_remaining = $invoice_info['amount_remaining'] ?? 0;
$currency_name = $invoice_info['currency_name'] ?? '';
$qty_ordered = $subtotal_line_level = $line_level_discount = 0;
$transactional_discount = $invoice_info['discount_total'];
?>

<html>
<head>
    <style>
        * {
            font-family: NotoSans, sans-serif;
        }
        @page {
            margin: 300px 45px 150px 45px;
        }
        .header {
            position: fixed;
            top: -250px;
            left: 0;
            right: 0;
            height: 250px;
            text-align: center;
        }
        .header td {
            line-height: 1;
        }
        .footer {
            position: fixed;
            bottom: -80px;
            left: 0;
            right: 0;
            height: 100px;
            width: 100%;
            text-align: center;
            padding-top: 5px;
        }
        .content {
            margin-top: 50px;
            width: 100%;
            border-collapse: collapse;
        }
        .content th, .content tr, .content td {
            border-collapse: collapse;
        }
        .footer .pagenum:after {
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
            border: 1px solid #000000;
            border-bottom: none;
            border-top: none;
        }
        table.itemtable th {
            padding-bottom: 10px;
            padding-top: 10px;
            border: 1px solid #000000;
        }
        table.itemtable.shipping-info th {
            padding: 5px 6px 3px;
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
            <td align="center" colspan="4"><b><span style="font-size:16pt;">Invoice</span></b></td>
            <td colspan="2" style="text-align: right; ">Number:</td>
            <td colspan="2"><b><?php echo esc_html( $invoice_tran_id ); ?></b></td>
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
            <td style="text-align: right;" colspan="2">Invoice Date:</td>
            <td colspan="2"><b><?php if (! empty($invoice_info['invoice_date']) ) echo date('n/d/Y', strtotime($invoice_info['invoice_date'])); ?></b></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td style="text-align: right;" colspan="2">Due Date:</td>
            <td colspan="2"><b><?php if (! empty($invoice_info['due_date']) ) echo date('n/d/Y', strtotime($invoice_info['due_date'])); ?></b></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
            <td style="text-align: right;" colspan="2">Discount Date:</td>
            <td colspan="2"><b><?php if (! empty($invoice_info['discount_date']) ) echo date('n/d/Y', strtotime($invoice_info['discount_date'])); ?></b></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr style="width: 100%">
            <td colspan="6" style="width: 100%; padding-left: 75px;"><b>Bill To:</b><br /><?php echo $billing_address;  ?></td>
            <td colspan="6" style="width: 100%; padding-left: 75px;"><b>Ship To:</b><br /><?php echo $shipping_address; ?></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
            <td align="center" colspan="4">&nbsp;</td>
            <td align="right" colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
</div>

<div class="footer">
    <table class="footer-content" style="width: 100%;">
        <tr><td>&nbsp;</td></tr>
        <tr><td style="width: 100%; height: 70px;">
                <img src="<?php echo wp_get_attachment_image_url( get_option( 'theme_config_order_documents_footer' ), 'full' ); ?>" alt="NSI brands" style="width: 90%; height: 70px;" />
            </td></tr>
        <tr style="margin-bottom: 50px;">
            <td><b>www.nsiindustries.com</b></td>
            <td></td>
            <td></td>
            <td align="right" style="width: 15%;"><b>Page: <span class="pagenum"></span></b></td>
        </tr>
    </table>
</div>

<div class="content">
    <table style="width: 100%; margin-top: 10px;">
            <tr>
                <td align="left" colspan="10" style="width: 100%"><strong>Remit To: <?php echo esc_html( $order_data['subsidiary_name'] ); ?></strong></td>
            </tr>
            <tr>
                <?php if ( $currency_name === 'US Dollar') { ?>
                    <td colspan="2"><?php echo nl2br(get_option( 'subsidiary_settings_address', "PO Box 842924\r\nDallas, TX 75284-2924" ) ); ?></td>
                <?php } else { ?>
                    <td colspan="2">PO Box 2725<br />Huntersville, NC 28070-2725</td>
                <?php } ?>
                <td align="center" colspan="6"><b><?php echo esc_html( 'Sales Order ' . $order_data['order_tran_id'] ); ?></b></td>
                <td colspan="2"><b>Partner: <?php echo esc_html( $order_data['partner'] ); ?></b></td>
            </tr>
            <tr>
                <td colspan="4">Phone: <b><?php echo esc_html( get_option( 'subsidiary_settings_phone', "704-439-2420" ) ); ?></b></td>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="10">Email: <?php echo esc_html( get_option( 'subsidiary_settings_email', "AR@nsiindustries.com" ) ); ?></td>
            </tr>
    </table>

    <table class="itemtable shipping-info" style="border-collapse: collapse; margin-top:10px; width:100%;">
        <tr>
            <th style="text-align: center; background-color: blue; border-color: rgb(0, 0, 0);"><span style="color: white;">Customer P.O</span></th>
            <th style="text-align: center; background-color: blue; border-color: rgb(0, 0, 0);"><span style="color: white;">Ship Via</span></th>
            <th style="text-align: center; background-color: blue; border-color: rgb(0, 0, 0);"><span style="color: white;">Tracking Num</span></th>
            <th style="text-align: center; background-color: blue; border-color: rgb(0, 0, 0);"><span style="color: white;">Terms</span></th>
        </tr>
        <tr>
            <td style="text-align: left; border-color: rgb(0, 0, 0); border-right: 1px solid black;"><?php echo esc_html( $order_data['customer_po'] ); ?></td>
            <td style="text-align: center; border-color: rgb(0, 0, 0); border-right: 1px solid black;"><?php echo esc_html( $order_data['shipping_carrier'] ); ?></td>
            <td style="text-align: left; border-color: rgb(0, 0, 0); border-right: 1px solid black;"><?php echo esc_html( $order_data['tracking_no'] ); ?></td>
            <td style="text-align: center; border-color: rgb(0, 0, 0); border-right: 1px solid black;"><?php echo esc_html( $order_data['terms'] ); ?></td>
        </tr>
    </table>

    <table class="itemtable" style="width: 100%; margin-top: 10px;">
        <thead>
        <tr>
            <th style="text-align: left; width: 10%;">Item</th>
            <th style="text-align: left; width: 30%;">Description</th>
            <th style="text-align: left; width: 10%;">QTY<br />Shipped</th>
            <th style="text-align: left; width: 10%;">QTY<br />Ordered</th>
            <th style="text-align: left; width: 10%;">Price Per</th>
            <th style="text-align: left; width: 10%;">Amount</th>
        </tr>
        </thead>
        <?php foreach ( $invoice_items as $item ) {
            if ( empty( $item['description'] ) ) {
                $item['qty_shipped'] = $qty_ordered = '';
            } elseif ( isset( $order_data['order_items_details'][$item['sku']]['quantity'] ) ) {
                $qty_ordered = $order_data['order_items_details'][$item['sku']]['quantity'];
            }
            $item_amount = $item['item_amount'];
            $subtotal_line_level += $item_amount;
            if ( $item_amount < 0 ) {
                $line_level_discount += $item_amount;
            }
            ?>
            <tr>
                <td><?php echo esc_html( $item['sku'] ); ?></td>
                <td style="line-height: 19px;"><?php echo esc_html( $item['description'] ); ?></td>
                <td style="width: 90px;"><?php echo esc_html( $item['qty_shipped'] ); ?></td>

                <td style="width: 90px;"><?php echo esc_html( $qty_ordered ); ?></td>
                <?php if ( $item['nsi_multiplier'] > 1) { ?>
                    <td style="width: 103px;"><?php echo ( $item['rate'] * $item['nsi_multiplier'] ) . '/' . esc_html( $item['nsi_multiplier'] ); ?></td>
                <?php } else { ?>
                    <td style="width: 103px;"><?php echo $item['rate'] * $item['nsi_multiplier']; ?></td>
                <?php } ?>
                <td style="width: 120px;"><?php echo  $item_amount; ?></td>
            </tr>
        <?php } ?>
    </table>

    <table style="border: none; width:60%; float: right; page-break-inside:avoid; padding-top: 15px;">
        <tr>
            <td style="border: none; text-align: right; width: 65%;"><b>Gross</b></td>
            <td style="border: none; text-align: right;"><?php echo wc_price( $subtotal_line_level - $line_level_discount ); ?></td>
        </tr>
        <tr>
            <td style="border: none; text-align: right; width: 65%;"><b>Subtotal (Net of Line-level Disc)</b></td>
            <td style="border: none; text-align: right;"><?php echo wc_price( $subtotal_line_level ); ?></td>
        </tr>
        <tr>
            <td style="border: none; text-align: right; width: 65%;"><b>Subtotal (Net of all Discounts) </b></td>
            <td style="border: none; text-align: right;"><?php echo wc_price( $subtotal_line_level + $transactional_discount ); ?></td>
        </tr>
        <tr>
            <td style="border: none; text-align: right;">Discount Total</td>
            <td style="border: none; text-align: right;"><?php if ( $transactional_discount != 0 ) echo wc_price( $transactional_discount ); ?></td>
        </tr>
        <tr>
            <td style="border: none; text-align: right;">Freight</td>
            <td style="border: none; text-align: right;"><?php echo wc_price( $invoice_info['shipping_cost'] ); ?></td>
        </tr>
        <tr>
            <td style="border: none; text-align: right;">Tax Total</td>
            <td style="border: none; text-align: right;"><?php echo wc_price( 0 ); ?></td>
        </tr>
        <tr>
            <td style="border: none; text-align: right;">Payment/Credit Amount</td>
            <td style="border: none; text-align: right;"><?php echo wc_price( $amount_paid ); ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="right" class="myFoot"><strong><?php echo esc_html( $currency_name ); ?></strong><b>&nbsp;Balance Due</b></td>
            <td align="right">
                <?php echo $balance_due; ?>
            </td>
        </tr>
    </table>
</div>
</body>
</html>