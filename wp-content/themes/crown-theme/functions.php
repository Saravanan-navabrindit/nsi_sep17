<?php


// load required class files
$include_dirs = array(
	'/classes',
	'/inc',
	'/acf-group'
);
foreach ( $include_dirs as $include_dir ) {
	$include_dir = dirname( __FILE__ ) . $include_dir;
	foreach ( scandir( $include_dir ) as $file ) {
		if ( preg_match( '/^[^\.]+\.php$/', $file ) ) {
			include_once( $include_dir . '/' . $file );
		}
	}
}

// initialize theme modules
Crown_Theme::init();
// Crown_Theme_Ajax_Content::init();
Crown_Theme_Block_Editor::init();
// Crown_Theme_Config::init();
// Crown_Theme_Main_Query::init();
// Crown_Theme_Post_Type_Templates::init();
Crown_Theme_Scripts::init();
// Crown_Theme_Shortcode_Filters::init();
Crown_Theme_Styles::init();
// Crown_Theme_Template_Hooks::init();
Crown_Order_Types::init();


// Add default metabox Custom Fields in admin panel
add_filter('acf/settings/remove_wp_meta_box', '__return_false');

require get_template_directory() . '/woocommerce/dropship-product.php';
require get_template_directory() . '/woocommerce/restrict-product.php';
// disabling product purchase functionality
require get_template_directory() . '/woocommerce/disable-product-purchase.php';

function clear_all_cookies(): void {
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 3600, '/'); //3600 = 1h in past
            setcookie($name, '', time() - 3600, '/', $_SERVER['HTTP_HOST'], isset($_SERVER['HTTPS']), true);
        }
    }
}

if (defined('EXTRA_CLEAR_COOKIES_LOGIN_LOGOUT') && !empty(EXTRA_CLEAR_COOKIES_LOGIN_LOGOUT)) {
        add_action('wp_login', function($user_login, $user) {
            if (EXTRA_CLEAR_COOKIES_LOGIN_LOGOUT === 'ALL') {
                clear_all_cookies();
            } elseif (EXTRA_CLEAR_COOKIES_LOGIN_LOGOUT === 'AUTH') {
                wp_clear_auth_cookie();
            }
        }, 10, 2);
        add_action('wp_logout', function() {
            if (EXTRA_CLEAR_COOKIES_LOGIN_LOGOUT === 'ALL') {
                clear_all_cookies();
            } elseif (EXTRA_CLEAR_COOKIES_LOGIN_LOGOUT === 'AUTH') {
                wp_clear_auth_cookie();
            }
        });
}


// Add custom quote type popup
require get_template_directory() . '/woocommerce/quote-type-popup.php';

// quote type popup for switched customers
require get_template_directory() . '/woocommerce/switch-to-customer.php';

//hawksearch-popup
add_action( 'wp_footer', function() {
    get_template_part( '/hawksearch/plp-select-quote-popup' );
});