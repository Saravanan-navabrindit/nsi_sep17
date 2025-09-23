<?php
/**
 * Template Name: Login page
 */

get_header();
if (
    !empty($_REQUEST['email']) && trim($_REQUEST['email']) != "" &&
    !empty($_REQUEST['password']) && trim($_REQUEST['password']) != ""
) {
    $user_verify = wp_signon(array(
        'user_login' => $_REQUEST['email'],
        'user_password' => $_REQUEST['password'],
        'remember' => isset($_REQUEST['rememberme']) && $_REQUEST['rememberme'] == 'yes'
    ));

    if ( is_wp_error( $user_verify ) ) {
        foreach ( $user_verify->errors as $error_type ) {
            foreach ( $error_type as $error ) {
                $custom_login_error[] = $error;
            }
        }
    } else {
        $user_id = $user_verify->ID;
        if ( !empty($user_id) ) {
            do_action( 'wp_login', $user_verify->user_login, $user_verify );
            wp_set_current_user( $user_id );
            wp_set_auth_cookie( $user_id );
            wp_safe_redirect( get_site_url() . '/my-account/' ); //redirect is required to render page in 'logged-in' state
            exit;
        }
    }
}
?>
<div class="page--login__holder">
    <div class="page--login__content">
        <?php
        if ( isset($custom_login_error) ) { ?>
            <div class="woocommerce-notices-wrapper">
                <?php
                foreach ( $custom_login_error as $error ) { ?>
                    <ul class="woocommerce-error" role="alert" tabindex="-1">
                        <li><?php echo $error;?></li>
                    </ul>
                <?php } ?>
            </div>
        <?php } ?>
        <h2><?php echo __( 'Login', 'crown-theme' ); ?></h2>
        <form method="POST" action="">
            <label class="label--fullwidth">
                <?php echo __( 'Username or email address', 'crown-theme' ); ?>
                <input type="text" name="email" placeholder="" required />
            </label>
            <label class="label--fullwidth">
                <?php echo __( 'Password', 'crown-theme' ); ?>
                <input type="password" name="password" placeholder="" required />
            </label>
            <button class="button" type="submit"><?php echo __( 'Login', 'crown-theme' ); ?></button>
            <label class="label--checkbox">
                <input type="checkbox" name="rememberme" value="yes" /> <?php echo __( 'Remember Me', 'crown-theme' ); ?>
            </label>

            <p class="link--forgotpassword">
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
            </p>
        </form>
    </div>
</div>
<?php
get_footer();