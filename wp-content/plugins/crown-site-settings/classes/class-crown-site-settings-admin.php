<?php


if ( ! class_exists( 'Crown_Site_Settings_Admin' ) ) {
	class Crown_Site_Settings_Admin {

		public static $init = false;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'redirect_admin' ), 10 );

			add_action( 'admin_menu', array( __CLASS__, 'cleanup_admin' ), 100 );
			add_action( 'admin_bar_menu', array( __CLASS__, 'cleanup_admin_bar' ), 999 );

			add_action( 'admin_menu', array( __CLASS__, 'add_blocks_menu_item' ), 10 );

			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'register_admin_styles' ) );
			add_filter( 'robots_txt', array( __CLASS__, 'add_robots_delay' ), 20, 2 );

		}


		public static function redirect_admin() {

			if ( is_user_logged_in() ) {
				$user = wp_get_current_user();
				$roles = ( array ) $user->roles;
				
				if ( in_array( 'shop_manager', $roles ) ) {
					$current_screen = get_current_screen();
					// print_r($current_screen); die;
					if ( $current_screen->base == 'post' && ! in_array( $current_screen->post_type, array( 'shop_order' ) ) ) {
						wp_redirect( admin_url() );
					}
				} else if ( in_array( 'dual_shop_manager', $roles ) ) {
                    $current_screen = get_current_screen();
                    if ( $current_screen->base == 'post' && ! in_array( $current_screen->post_type, array( 'shop_order', 'addify_quote' ) ) ) {
                        wp_redirect( admin_url() );
                    }
                }
			}

		}


		public static function cleanup_admin() {
			global $menu, $submenu;

			// // find position of posts and pages menu items within menu
			// $blog_posts_menu_item_index = null;
			// $pages_menu_item_index = null;
			// foreach ( $menu as $index => $menu_item ) {
			// 	if ( in_array( 'edit.php', $menu_item ) ) {
			// 		$blog_posts_menu_item_index = $index;
			// 		$menu_item[0] = 'Blog Posts'; // rename menu item
			// 		$menu[$index] = $menu_item;
			// 	} else if ( in_array( 'edit.php?post_type=page', $menu_item ) ) {
			// 		$pages_menu_item_index = $index;
			// 	}
			// }
			
			// remove_menu_page( 'edit.php' );
			remove_menu_page( 'edit-comments.php' );
			// self::add_admin_menu_separator( 25 );

			// // reorder posts and pages menu items
			// if ( $blog_posts_menu_item_index !== null && array_key_exists($blog_posts_menu_item_index, $menu ) ) {
			// 	$menu[29] = $menu[ $blog_posts_menu_item_index ];
			// 	unset( $menu[ $blog_posts_menu_item_index ] );
			// }
			// if ( $pages_menu_item_index !== null && array_key_exists( $pages_menu_item_index, $menu ) ) {
			// 	$menu[7] = $menu[ $pages_menu_item_index ];
			// 	unset( $menu[ $pages_menu_item_index ] );
			// }
			
			// // remove customizer menu item
			// if ( isset( $submenu['themes.php'] ) ) {
			// 	foreach ( $submenu['themes.php'] as $index => $menu_item ) {
			// 		if ( ! empty( array_intersect( array( 'Customize', 'Customizer', 'customize' ), $menu_item ) ) ) {
			// 			unset( $submenu['themes.php'][ $index ] );
			// 		}
			// 	}
			// }

			if ( get_current_user_id() != 1 ) {
				remove_menu_page( 'ghostkit' );
			}
			remove_menu_page( 'edit.php?post_type=ghostkit_template' );
			remove_menu_page( 'edit.php?post_type=wp_block' );

			if ( is_user_logged_in() ) {
				$user = wp_get_current_user();
				$roles = ( array ) $user->roles;
				
				if ( in_array( 'shop_manager', $roles ) || in_array( 'dual_shop_manager', $roles ) ) {
					remove_menu_page( 'edit.php' );
					remove_menu_page( 'upload.php' );
					remove_menu_page( 'edit.php?post_type=page' );
					remove_menu_page( 'edit.php?post_type=af_c_fields' );
					remove_menu_page( 'edit.php?post_type=sales_rep' );
					remove_menu_page( 'edit.php?post_type=catalog' );
					remove_menu_page( 'edit.php?post_type=video' );
					remove_menu_page( 'edit.php?post_type=product' );
					remove_menu_page( 'themes.php' );
					remove_menu_page( 'users.php' );
					remove_menu_page( 'tools.php' );
					remove_menu_page( 'options-general.php' );
					remove_menu_page( 'options-general.php?page=wcmmq_modules' );
					remove_menu_page( 'edit.php?post_type=team_member' );
					remove_menu_page( 'wcmmq-min-max-control' );
					remove_menu_page( 'theme-general-settings' );
					remove_menu_page( 'wc-admin&path=/wc-pay-welcome-page' );
					remove_submenu_page( 'dashboard', 'relevanssi-premium/relevanssi.php' );
					remove_submenu_page( 'woocommerce', 'wcmmq_min_max_step' );
					remove_submenu_page( 'woocommerce', 'customers' );
					remove_submenu_page( 'woocommerce', 'wc-reports' );
					remove_submenu_page( 'woocommerce', 'wc-settings' );
					remove_submenu_page( 'woocommerce', 'wc-status' );
					remove_submenu_page( 'woocommerce', 'wc-addons' );
					remove_submenu_page( 'woocommerce', 'wc-admin' );
				} else if ( in_array( 'editor', $roles ) ) {
                    remove_menu_page( 'edit.php?post_type=addify_quote' );
					remove_submenu_page( 'woocommerce', 'quote_data_extraction' );
					remove_submenu_page( 'woocommerce', 'acf-options-settings-expired-status' );
					remove_menu_page( 'woocommerce' );
                }

                if ( in_array( 'shop_manager', $roles ) ) {
                    remove_menu_page( 'edit.php?post_type=addify_quote' );
                }
			}

		}

		protected static function add_admin_menu_separator( $position ) {
			global $menu;
			$index = 0;
			foreach ( $menu as $offset => $section ) {
				if ( substr( $section[2], 0, 9 ) == 'separator' ) $index++;
				if ( $offset >= $position ) {
					$menu[ $position ] = array( '', 'read', 'separator'.$index, '', 'wp-menu-separator' );
					break;
				}
			}
			ksort( $menu );
		}


		public static function cleanup_admin_bar( $adminBar ) {
			$adminBar->remove_node( 'customize' );
			$adminBar->remove_node( 'new-content' );
			$adminBar->remove_node( 'comments' );
		}


		public static function add_blocks_menu_item() {
			add_theme_page( 'Reusable Blocks', 'Reusable Blocks', 'read', 'edit.php?post_type=wp_block', '', null );
		}


		public static function register_admin_styles( $hook ) {

			// print_r(get_current_screen()); die;

			ob_start();
			?>
				<style>
					.ghostkit-toolbar-templates {
						display: none;
					}
				</style>
			<?php
			$css = trim( ob_get_clean() );
			$css = trim( preg_replace( array( '/^<style>/', '/<\/style>$/' ), '', $css ) );
			wp_add_inline_style( 'common', $css );

			if ( is_user_logged_in() ) {
				$user = wp_get_current_user();
				$roles = ( array ) $user->roles;
				if ( in_array( 'shop_manager', $roles ) ) {

					ob_start();
					?>
						<style>
							#toplevel_page_wc-admin-path--analytics-overview,
							#toplevel_page_woocommerce-marketing,
							#toplevel_page_woocommerce .wp-submenu > li,
							#adminmenu li > a > .awaiting-mod {
								display: none;
							}
							#toplevel_page_woocommerce .wp-submenu > li.wp-first-item {
								display: block;
							}
						</style>
					<?php
					$css = trim( ob_get_clean() );
					$css = trim( preg_replace( array( '/^<style>/', '/<\/style>$/' ), '', $css ) );
					wp_add_inline_style( 'common', $css );

				}
			}

		}

		/**
		 * Adds crawl-delay property to robots.txt.
		 *
		 * @param string $output    robots.txt output.
		 * @param bool   $is_public Whether the site is public.
		 * @return string The robots.txt output.
		 */
		public static function add_robots_delay( $output, $is_public ) {
			if ( $is_public ) {
                $output .= "\nUser-agent: *\n";
				$output .= "Crawl-delay: 10\n";
			}

			return $output;
		}


	}
}