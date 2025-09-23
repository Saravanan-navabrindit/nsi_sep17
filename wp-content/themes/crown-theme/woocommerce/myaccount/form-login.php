<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="page--login__holder">
    <div class="page--login__content">
        <h2><?php echo __( 'Login', 'crown-theme' ); ?></h2>
        <form method="POST" action="">
            <label class="label--fullwidth">
                <?php echo __( 'Username or email address', 'crown-theme' ); ?>
                <input type="text" name="custom-email" placeholder="" required />
            </label>
            <label class="label--fullwidth">
                <?php echo __( 'Password', 'crown-theme' ); ?>
                <input type="password" name="custom-password" placeholder="" required />
            </label>
            <button class="button" type="submit"><?php echo __( 'Login', 'crown-theme' ); ?></button>
            <label class="label--checkbox">
                <input type="checkbox" name="custom-rememberme" value="yes" /> <?php echo __( 'Remember Me', 'crown-theme' ); ?>
            </label>

            <p class="link--forgotpassword">
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
            </p>
            <?php wp_nonce_field( 'custom-login-form', 'custom-login-form-nonce' ); ?>
        </form>
    </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
