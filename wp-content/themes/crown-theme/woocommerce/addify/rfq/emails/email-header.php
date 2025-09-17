<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
    <title><?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?></title>
    <style>
        /* Styles for wrapper */
        #wrapper,
        .quote-wrapper {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            background-color: #f9f9f9;
        }
        /* Styles for container */
        #template_container,
        .quote-template_container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 4px;
            overflow: hidden;
        }
        /* Styles for header */
        #template_header,
        .quote-template_container .quote-template_header {
            text-align: left;
            background-color: #f0f0f0;
            color: black;
            padding: 10px;
            width: 100%;
        }

        #template_header img,
        .quote-template_container .quote-template_header img{
            display: inline-block;
            max-width: 40px;
            margin-right: 16px;
        }

        table#template_header h1,
        table#template_header h1 a,
        .quote-template_container table.quote-template_header h1,
        .quote-template_container table.quote-template_header h1 a {
            color: black;
            display: inline;
            vertical-align: middle;
            font-size: 22px;
        }

        /* Styles for body */
        #template_body,
        .quote-template_container .quote-template_body {
            padding: 20px;
        }

        #template_body #body_content table td,
        .quote-template_container .quote-template_body .quote-body_content table td {
            padding: 0 10px 0;
            min-width: 65px;
        }

        #template_body #body_content table th,
        .quote-template_container .quote-template_body .quote-body_content table th {
            padding: 0 10px 0;
        }

        #template_body #body_content table.quote-contents td,
        .quote-template_container .quote-template_body .quote-body_content table.quote-contents td {
            padding: 10px;
        }

        #template_body #body_content table.quote-contents th,
        .quote-template_container .quote-template_body .quote-body_content table.quote-contents th {
            padding: 12px 12px 12px 10px;
        }

        /* Styles for footer */
        #template_footer,
        .quote-template_container .quote-template_footer {
            background-color: #f0f0f0;
            padding: 20px;
            text-align: center;
        }
        /* Styles for footer text */
        #credit,
        .quote-template_container .quote-template_footer .quote-credit {
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div id="wrapper" class="quote-wrapper">
    <div id="template_container" class="quote-template_container">
        <table id="template_header" class="quote-template_header">
            <tr>
			    <?php if ( $img = get_option( 'woocommerce_email_header_image' ) ) : ?>
                    <td style="width: 56px;">
					   	<?php echo wp_kses_post( '<img src="' . esc_url( $img ) . '" alt="' . esc_html( get_bloginfo( 'name', 'display' ) ) . '" />' ); ?>
                    </td>
				<?php endif; ?>
                <td>
                    <h1><?php echo esc_html( $email_heading ); ?></h1>
                </td>
            </tr>
        </table>
        <div id="template_body" class="quote-template_body">
            <div id="body_content" class="quote-body_content">
                <!-- Content -->
                <div id="body_content_inner" style="text-align: left;">