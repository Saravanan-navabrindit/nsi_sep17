<?php
/**
 * Plugin Name: NSI Industries - FME Addons: Shop as a Customer for WooCommerce
 * Author: fmeaddons
 * Version: 1001.1.0
 * Developed By: fmeaddons Team
 * License:    GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires at least: 4.4
 * Text Domain: shop-as-a-customer-for-woocommerce
 * Domain Path: /languages
 * Tested up to: 5.5.5
 * WC requires at least: 3.0
 * WC tested up to: 3.8.0
 * Woo: 5467980:a75e8762bdf7a49e92759802ab34efb9
 */

error_reporting(0);
if ( ! defined( 'ABSPATH' ) ) { 
	exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active
 * if wooCommerce is not active FME Addons: Shop as a Customer for WooCommerce module will not work.
 **/
if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	function my_admin_notice() {

		// Deactivate the plugin
		deactivate_plugins(__FILE__);
		$error_message = __('This plugin requires <a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce</a> plugin to be installed and active!', 'woocommerce');
		echo esc_attr( $error_message );
		die();
	}
	add_action( 'admin_notices', 'my_admin_notice' );
}


class MainFmeaddonsClass {

	public function __construct() {
		add_action('init', array($this, 'fmeaddons_script'));
		add_action('admin_footer', array($this, 'fmeaddons_script'));
		add_action('wp_ajax_ajaxxx', array( $this, 'fmeaddons_switchtocustomer'));
		add_action('wp_ajax_nopriv_ajaxxx', array( $this, 'fmeaddons_switchtocustomer'));
		
		add_action('wp_ajax_asguest', array( $this, 'fmeaddons_switchtoguest'));
		add_action('wp_ajax_nopriv_asguest', array( $this, 'fmeaddons_switchtoguest'));
		
		add_action('wp_head', array($this, 'fmeaddons_switchback_tab'));
		add_action('wp_ajax_ajax', array( $this, 'fmeaddons_switchback_to_admin'));
		add_action('wp_ajax_nopriv_ajax', array( $this, 'fmeaddons_switchback_to_admin'));
		
		add_action('wp_ajax_vieworder', array( $this, 'fmeaddons_view_order'));
		add_action('wp_ajax_nopriv_vieworder', array( $this, 'fmeaddons_view_order'));
		
		add_action('wp_ajax_editprofile', array( $this, 'fmeaddons_edit_profile'));
		add_action('wp_ajax_nopriv_editprofile', array( $this, 'fmeaddons_edit_profile'));
		
		add_action( 'woocommerce_thankyou', array($this, 'fmeaddons_custom_content_thankyou'), 10, 1 );
		add_action('wp_ajax_sbavs', array( $this, 'fmeaddons_switchbackandviewshop'));
		add_action('wp_ajax_nopriv_sbavs', array( $this, 'fmeaddons_switchbackandviewshop'));
		
		add_action('init', array($this, 'fmeaddons_start_session'));        
		add_action('wp_footer', array($this, 'fmeaddons_modal'));
		add_action('admin_footer', array($this, 'fmeaddons_modal'));
		add_action('admin_bar_menu', array( $this, 'fmeaddons_custom_toolbar_link'), 999);
		add_action('wp_logout', array( $this, 'fmeaddons_end_session'));
        add_action('wp_logout', array($this, 'save_cart_before_logout'), 20);
		add_action('woocommerce_settings_tabs_array', array($this, 'fmeaddons_menu_pages'), 50);
		add_action( 'woocommerce_settings_shop_as_a_customer_for_woocommerce', array($this, 'fmeaddons_customerlogs') );
		add_action('wp_ajax_my_action' , array($this,'data_fetch'));
		add_action('wp_ajax_nopriv_my_action' , array($this,'data_fetch'));
		
		add_action('wp_ajax_nextdatafind' , array($this,'nextdatafind'));
		add_action('wp_ajax_nopriv_nextdatafind' , array($this,'nextdatafind'));
		add_action('wp_ajax_saveallroles' , array($this,'fme_saveallroles'));
		add_action('wp_ajax_nopriv_saveallroles' , array($this,'fme_saveallroles'));
		add_action( 'wp_loaded', array($this,'fme_load_textdomain' ));
		add_filter( 'load_textdomain_mofile', array($this,'my_plugin_load_my_own_textdomain'), 10, 2 );
	}

	public function fme_load_textdomain() {
		load_plugin_textdomain( 'shop-as-a-customer-for-woocommerce', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	public function my_plugin_load_my_own_textdomain( $mofile, $domain ) {

		if ( 'shop-as-a-customer-for-woocommerce' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
			$locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
			$mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
		}
		return $mofile;
	}

	public function fme_saveallroles() {
		if (!isset($_REQUEST['notallowedpleasegoaway_fme_123e']) && 'fmessnotallowedpleasegoaway_fme_123#e' != $_REQUEST['notallowedpleasegoaway_fme_123e'] ) {
			echo esc_attr('GO AWAY THIS IS NOT LEGAL WAY!');
			wp_die();
		}
		if (isset($_REQUEST['allroless']) || isset($_REQUEST['defselectedp']) || isset($_REQUEST['fme_tabselect']) ) {
			$defselectedp=sanitize_text_field($_REQUEST['defselectedp']);
			$allrolessaved=array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['allroless'] ) );
			$fme_tabselect = sanitize_text_field($_REQUEST['fme_tabselect']);
		}
		

		if (isset($_REQUEST['']) || isset($_REQUEST['defselectedp']) ) {
			$defselectedp=sanitize_text_field($_REQUEST['defselectedp']);
			$allrolessaved=array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['allroless'] ) );
		}
		
		update_option('fme_allrolessaved', $allrolessaved);
		update_option('fme_defselectedp', $defselectedp);
		update_option('fme_tabselect', $fme_tabselect);

		wp_die();
	}
	public function nextdatafind() {
		if (!isset($_REQUEST['notallowedpleasegoaway_fme_123e']) && 'fmessnotallowedpleasegoaway_fme_123#e' != $_REQUEST['notallowedpleasegoaway_fme_123e'] ) {
			echo esc_attr('GO AWAY THIS IS NOT LEGAL WAY!');
			wp_die();
		}
		if (isset($_REQUEST['nextvalue'])) {
            // Need to check both variants for backward compatibility.
            $find_original = stripslashes(sanitize_text_field($_REQUEST['nextvalue']));
			$find = htmlspecialchars($find_original);

		}
		if (isset($_REQUEST['globnextcount'])) {
			$globnextcount=sanitize_text_field($_REQUEST['globnextcount']);

		}
	
		global $wpdb;

		$current_user = wp_get_current_user();
		$roles = ( array ) $current_user->roles;
		if ( in_array( 'shop_manager', $roles ) || in_array( 'dual_shop_manager', $roles ) ) {
            $current_user_email_domain = Crown_Shop_Orders::get_email_domain( $current_user );
			$customer_ids = Crown_Shop_Custom_Roles::get_sales_rep_customer_ids( $current_user_email_domain );
		} else if ( in_array( 'internal_sales_rep', $roles ) ) {
		    $sales_rep_states = explode( ',', get_user_meta( get_current_user_id(), 'internal_sales_rep_states', true ) );
            $users = get_users( array(
                'meta_key' => 'shipping_state',
                'meta_value' => $sales_rep_states,
                'meta_compare' => 'IN'
            ) );

            $customer_ids = [];
            foreach( $users ?? [] as $user ) {
                $customer_ids[] = $user->ID;
            }
		} else if (
                in_array( 'branch_employee_viewer', $roles )
                || in_array( 'branch_employee', $roles )
                || in_array( 'branch_admin', $roles )
            ) {
		    $customer_ids = Crown_Shop_Custom_Roles::get_users_ids_for_branch_roles( $current_user->ID );
		}

        if ( isset( $customer_ids ) ) {
            $results = array();
			if ( ! empty( $customer_ids ) ) {
				$results = $wpdb->get_results( call_user_func_array( array( $wpdb, 'prepare' ), array_merge( array( 'SELECT u.ID, u.user_email, u.display_name FROM  ' . $wpdb->prefix . 'users u, ' . $wpdb->prefix . 'usermeta m WHERE u.ID = m.user_id AND m.meta_key LIKE "' . $wpdb->prefix . 'capabilities" AND m.meta_value NOT LIKE %s AND u.display_name LIKE %s AND u.ID IN (' . implode( ', ', array_fill( 0, count( $customer_ids ), '%s' ) ) . ') LIMIT %d, 10', '%administrator%', '%' . $find . '%' ), $customer_ids, array( $globnextcount ) ) ) );
			}
			$results = array_map( function( $n ) {
				$n->display_name = html_entity_decode( $n->display_name );
				return $n;
			}, $results );
			echo json_encode( $results );
			exit();
        }

		$results = $wpdb->get_results($wpdb->prepare(
                'SELECT u.ID, u.user_email, u.display_name
                        FROM  ' . $wpdb->prefix . 'users u, ' . $wpdb->prefix . 'usermeta m
                        WHERE u.ID = m.user_id
                        AND m.meta_key LIKE "' . $wpdb->prefix . 'capabilities"
                        AND m.meta_value NOT LIKE %s
                        AND (u.display_name LIKE %s OR u.display_name LIKE %s)
                        LIMIT %d, 50', '%administrator%', '%' . $find . '%', '%' . $find_original . '%', $globnextcount));
		$results = array_map( function( $n ) {
			$n->display_name = html_entity_decode( $n->display_name );
			return $n;
		}, $results );
	
		echo json_encode( $results);
		exit();
	}
	public function data_fetch() {
		if (!isset($_REQUEST['notallowedpleasegoaway_fme_123e']) && 'fmessnotallowedpleasegoaway_fme_123#e' != $_REQUEST['notallowedpleasegoaway_fme_123e'] ) {
			echo esc_attr('GO AWAY THIS IS NOT LEGAL WAY!');
			wp_die();
		}
		
		if (isset($_REQUEST['value'])) {
			// Need to check both variants for backward compatibility.
			$find_original = stripslashes(sanitize_text_field($_REQUEST['value']));
			$find = htmlspecialchars($find_original);

		}
		global $wpdb;

		$current_user = wp_get_current_user();
		$roles = ( array ) $current_user->roles;
		if ( in_array( 'shop_manager', $roles ) || in_array( 'dual_shop_manager', $roles ) ) {
            $current_user_email_domain = Crown_Shop_Orders::get_email_domain( $current_user );
			$customer_ids = Crown_Shop_Custom_Roles::get_sales_rep_customer_ids( $current_user_email_domain );
		} else if ( in_array( 'internal_sales_rep', $roles ) ) {
		    $sales_rep_states = explode( ',', get_user_meta( get_current_user_id(), 'internal_sales_rep_states', true ) );
            $users = get_users( array(
                'meta_key' => 'shipping_state',
                'meta_value' => $sales_rep_states,
                'meta_compare' => 'IN'
            ) );

            $customer_ids = [];
            foreach( $users ?? [] as $user ) {
                $customer_ids[] = $user->ID;
            }
		} else if (
                in_array( 'branch_employee_viewer', $roles )
                || in_array( 'branch_employee', $roles )
                || in_array( 'branch_admin', $roles )
            ) {
		    $customer_ids = Crown_Shop_Custom_Roles::get_users_ids_for_branch_roles( $current_user->ID );
		}

        if( isset( $customer_ids ) ) {
            $results = [];
			if ( ! empty( $customer_ids ) ) {
				$results = $wpdb->get_results( call_user_func_array( [ $wpdb, 'prepare' ], array_merge([
                    'SELECT u.ID, u.user_email, u.display_name 
                            FROM  ' . $wpdb->prefix . 'users u 
                            LEFT JOIN ' . $wpdb->prefix . 'usermeta m1 ON u.ID = m1.user_id AND m1.meta_key = "inactive" 
                            LEFT JOIN ' . $wpdb->prefix . 'usermeta m2 ON u.ID = m2.user_id AND m2.meta_key LIKE "' . $wpdb->prefix . 'capabilities" 
                            WHERE (m1.meta_value IS NULL OR m1.meta_value = false) 
                            AND m2.meta_value NOT LIKE %s 
                            AND (u.display_name LIKE %s OR u.display_name LIKE %s)
                            AND u.ID IN (' . implode( ', ', array_fill( 0, count( $customer_ids ), '%s' ) ) . ') 
                            LIMIT 10', '%administrator%', '%' . $find . '%', '%' . $find_original . '%'
                                ], $customer_ids ) ) );
			}
			$results = array_map( function( $n ) {
				$n->display_name = html_entity_decode( $n->display_name );
				return $n;
			}, $results );
			echo json_encode( $results );
			exit();
        }

		$results = $wpdb->get_results($wpdb->prepare(
                    'SELECT u.ID, u.user_email, u.display_name 
                    FROM  ' . $wpdb->prefix . 'users u 
                    LEFT JOIN ' . $wpdb->prefix . 'usermeta m1 ON u.ID = m1.user_id AND m1.meta_key = "inactive"
                    LEFT JOIN ' . $wpdb->prefix . 'usermeta m2 ON u.ID = m2.user_id AND m2.meta_key LIKE "' . $wpdb->prefix . 'capabilities"
                    WHERE (m1.meta_value IS NULL OR m1.meta_value = false)
                    AND m2.meta_value NOT LIKE %s 
                    AND (u.display_name LIKE %s OR u.display_name LIKE %s)
                    LIMIT 50', '%administrator%', '%' . $find . '%', '%' . $find_original . '%'
                    ));
		$results = array_map( function( $n ) {
			$n->display_name = html_entity_decode( $n->display_name );
			return $n;
		}, $results );
		echo json_encode( $results);

		exit();
	}


	public function fmeaddons_menu_pages( $tabs ) {
		$tabs['shop_as_a_customer_for_woocommerce'] = __('Shop As a Customer', ' shop-as-a-customer-for-woocommerce');
		return $tabs;
	}
	public function fmeaddons_customerlogs() {

		if (is_admin()  && isset($_GET['tab']) && 'shop_as_a_customer_for_woocommerce' == $_GET['tab']) {
			?>
			<style type="text/css">
				.woocommerce-save-button {
				  display: none !important;
				}
				.subsubsub {
					margin-top: -42px !important;
				}
			</style>
			<?php
		}
		$array_for_log = get_option('all_logs');


		if ( '' == $array_for_log ) {
			$counnnt=count($array_for_log);
			$counnnt=$counnnt-1;
		} else {
			$counnnt=count($array_for_log);

		}
		global $wpdb;

		$results = $wpdb->get_results($wpdb->prepare('SELECT u.ID, u.user_email, u.display_name FROM  ' . $wpdb->prefix . 'users u, ' . $wpdb->prefix . 'usermeta m WHERE u.ID = m.user_id AND m.meta_key LIKE "' . $wpdb->prefix . 'capabilities" AND m.meta_value NOT LIKE %s ', '%administrator%'));
		

		?>
	
		<br><div id="savediv"style="border-radius: 4px;background-color: #5f9a3b;color: #FFF;font-size: large;text-align: center;display: none;"><br> <?php echo esc_html_e('Your settings has been saved!', 'shop-as-a-customer-for-woocommerce'); ?><br><br></div><br>
		<ul class="subsubsub">
			

			<li>
				<a href="#" class="fme_tabsss current" id="fme_customerlogsbtn">
					<?php echo esc_html_e('Switch To Customers', 'shop-as-a-customer-for-woocommerce'); ?>
				</a>|
			</li>

			<li>
				<a href="#" class="fme_tabsss" id="fme_switchcustomerbtn">
					<?php echo esc_html_e('Customer Logs', 'shop-as-a-customer-for-woocommerce'); ?>
				</a>|
			</li>

			<li>
				<a href="#" class="fme_tabsss" id="fme_settingsbtn">
					<?php echo esc_html_e('Settings', 'shop-as-a-customer-for-woocommerce'); ?>
				</a>
			</li>


			
			
		</ul>
		<br>
		<input type="hidden" id="pageefound" value="found">


		<table class="form-table" id="fme_tabofsettings" style="display:none;">
			<?php
			$fme_tabselect=get_option('fme_tabselect');
			?>
			<tbody>
				<tr>
					<th>
						<label ><?php echo esc_html_e('Select Tab to Switch as Customer/Guest', 'shop-as-a-customer-for-woocommerce'); ?></label>
						<span class="woocommerce-help-tip" data-tip="Select The Tab in Which Admin Will be Switch as a Cutomer or Guest"></span>
					</th>
					<td>
						<select id="fme_tabselect">
							<option value="new" 
							<?php
							if ( 'new' == $fme_tabselect) {
								echo esc_attr('selected');

							}
							?>
							>
								<?php echo esc_attr('New'); ?>
							</option>
							<option value="same"

							<?php
							if ( 'same' == $fme_tabselect) {
								echo esc_attr('selected');
								
							}
							?>
							>
							<?php echo esc_attr('Same'); ?>

							</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>
						<label><?php echo esc_html_e('Select Role(s)', 'shop-as-a-customer-for-woocommerce'); ?></label>
						<span class="woocommerce-help-tip" data-tip="Only Selected Roles will be allowed to switch & View orders. If no role is selected all roles will be considered as selected"></span>	
					</th>
					<td>
						<?php 
						global $wp_roles;
						$all_roles = $wp_roles->get_names();
						$savedroles=get_option('fme_allrolessaved');
						$fme_defselectedp=get_option('fme_defselectedp');
						if ('' == $savedroles) {
							$savedroles=array();
						}

						if (!empty($all_roles)) {
							?>
							<select  id="select_roles" multiple="multiple" style="width: 25%;">
								<?php
								foreach ($all_roles as $key => $value) {
									if ( 'customer' != filter_var(strtolower($value))) {
										$valueuserrole  = strtolower( str_replace( ' ', '_', $value ) );
										?>
										<option value="<?php echo filter_var( $valueuserrole ); ?>"
											<?php
											if (in_array(strtolower($valueuserrole), $savedroles)) {
												echo esc_attr('selected');
											}
											?>
											>
											<?php echo filter_var($value); ?>
										</option>
										<?php
									}
								}
								?>
							</select>
							
							<?php

						}
						?>
					</td>
				</tr>
				<tr>
					<th>
						<label style="font-weight: bold;"><?php echo esc_html_e('By Default Order Status During Offline Payment', 'shop-as-a-customer-for-woocommerce'); ?></label>
					</th>
					<td>
						<?php
			
						$vie12p=wc_get_order_statuses();
						?>
						
						<select id="selectdefpm" value="<?php echo esc_attr($fme_defselectedp); ?>">
							<?php
							foreach ($vie12p as $key => $value) {
								?>
							<option value="<?php echo esc_attr($key); ?>">
								<?php echo esc_attr($value); ?>
							</option>
								<?php
							}
							?>
						<script type="text/javascript">
							jQuery('#selectdefpm').val('<?php echo esc_attr($fme_defselectedp); ?>');
						</script>
						</select>
					</td>
				</tr>
				<tr>
					<th>
						<button style="padding: 0px 10px 0px 10px;" class="button-primary saveroles"><?php echo esc_html_e('Save Settings', 'shop-as-a-customer-for-woocommerce'); ?></button>
					</th>
				</tr>
			</tbody>
		</table>		

		<div  id="fme_tableofswitch" style="display:block;">
			<table id="allcustomers" class="display">
				<thead>
					<th >
						<center>
							<?php echo esc_html_e('ID', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>

					</th>
					<th>
						<center>
							<?php echo esc_html_e('Name', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>

					<th>
						<center>
							<?php echo esc_html_e('Email', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>
					<th style="width: 30%;">
						<center>
							<?php echo esc_html_e('Action', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>
					
				</thead>
				<tbody>
					<?php
					
					foreach ($results as $key => $value) {
						?>

						<tr >
							<td >
								<center>
									<?php
									echo esc_attr($value->ID);

									?>
								</center>
							</td>
							<td >
								<center>
									<?php echo esc_attr($value->display_name); ?>
								</center>
							</td>

							<td>
								<center>
									<?php
									echo esc_attr($value->user_email);
									?>
								</center>
							</td>
							<td style="width: 30%;">
								<center>
									<button  class="button frompage switchbtn" style="margin: 1%;" value="<?php echo esc_attr($value->ID); ?>"><?php echo esc_html_e('Switch', 'shop-as-a-customer-for-woocommerce'); ?></button>
									<button  class="button frompage vieworder" value="<?php echo esc_attr($value->ID); ?>" style="margin: 1%;"><?php echo esc_html_e('View Orders', 'shop-as-a-customer-for-woocommerce'); ?></button>
									<button  class="button frompage editprofile" value="<?php echo esc_attr($value->ID); ?>" style="margin: 1%;"><?php echo esc_html_e('Edit Profile', 'shop-as-a-customer-for-woocommerce'); ?></button>
								</center>
							</td>
							

						</tr>

						<?php
					}
					?>
				</tbody>
				<tfoot>
					<th >
						<center>
							<?php echo esc_html_e('ID', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>

					</th>
					<th>
						<center>
							<?php echo esc_html_e('Name', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>

					<th>
						<center>
							<?php echo esc_html_e('Email', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>
					<th style="width: 30%;">
						<center>
							<?php echo esc_html_e('Action', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>
				</tfoot>

			</table>

			<style type="text/css">
				.tooltip {
					position: relative;
					background: rgba(0,0,0,0.3);
					padding: 0px 2px;
					border-radius: 100%;
					
					cursor: help;
				/*	position: relative;
					display: inline-block;
					border-bottom: 1px dotted black;*/
				}
				.subsubsub {
					float: unset !important;
				}

				.tooltip .tooltiptext {
					visibility: hidden;
					width: 270px;
					background-color: #2f283b;
					color: #fff;
					text-align: center;
					border-radius: 6px;
					padding: 5px 0;
					margin-left: 15px;
					/* Position the tooltip */
					position: absolute;
					z-index: 1;
				}

				.tooltip:hover .tooltiptext {
					visibility: visible;
				}
				

			.page-item.active .page-link{
				background-color: #2f283b;
				border-color: #2f283b;
			}
			body{
				background-color: #f1f1f1;
			}
			#allcustomers_paginate{
				margin-right: 0.5%;
			}
			
			.dt-buttons{
				margin-left: 0.5%;
			}
			#allcustomers_filter{
				margin-right: 1.5%;
			}
			#allcustomers_info{
				margin-left: 0.5%;
			}
			#allcustomers {
				font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
				width: 98%;
				margin-left: 0.5%;
				border: 1px solid #c3c4c7;
				box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
			}
			
			#allcustomers td, #customers th {
				border: 0px solid #ddd;
				padding: 8px;
				line-height: 24px;	
			}

			#allcustomers th{
				border-bottom: 1px solid #c3c4c7;
				font-weight: 400;
				font-size: 14px;
				color: #2c3338
			}

			#allcustomers tr {
				border: 1px solid #ddd;
			}


			#allcustomers {
				background-color: #fff !important;
			}

		</style>
		</div>
		
		<div id="fme_taboflogs" style="display: none;">
			<table id="customers" class="display">
				<thead>
					<th style="width: 5%;">
						<center>
							<?php echo esc_html_e('ID', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>

					</th>
					<th style="width: 23%;">
						<center>
							<?php echo esc_html_e('Logged in At', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>

					<th style="width: 30%;">
						<center>
							<?php echo esc_html_e('Customer', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>
					<th style="width: 24%;">
						<center>
							<?php echo esc_html_e('Products', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>
					<th>
						<center>
							<?php echo esc_html_e('Message On Whatsapp', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>
				</thead>
				<tbody>
					<?php
					for ($i=$counnnt-1; $i > 0 ; $i--) { 
						$idd = $array_for_log[$i]['id'];
						$time = $array_for_log[$i]['time'];
						$customer = $array_for_log[$i]['customer'];
						$customer = explode(' ', $customer);
						$order_billing_phone = $array_for_log[$i]['phone'];
						if (isset($array_for_log[$i]['products'])) {
							$products=$array_for_log[$i]['products'];
						} else {
							$products='';
						}
						$disabled = '';
						if ( '' == $order_billing_phone || 'N/A' == $order_billing_phone) {
							$disabled = 'disabled';
						}
						?>

						<tr >
							<td style="width: 5%;">
								<center>
									<?php
									echo esc_attr($idd);

									?>
								</center>
							</td>
							<td style="width: 23%;">
								<center>
									<?php echo esc_attr($time); ?>
								</center>
							</td>

							<td style="width: 30%;">
								<center>
									<?php
									echo esc_attr($customer[0]);
									?>
								</center>
							</td>
							<td style="width: 24%;">
								<center>
									<?php
									echo esc_attr($products);
									?>
								</center>
							</td>
							<td>
								<center>
									<a class="<?php echo esc_attr($disabled); ?>" target="_blank" href="https://web.whatsapp.com/send?phone=<?php echo esc_html($order_billing_phone); ?>&text=" >
										<img style="width: 18%;" src="<?php echo esc_attr(plugin_dir_url( __FILE__ ) . 'whatsapp.png'); ?>">
									</a>
								</center>
							</td>

						</tr>

						<?php
					}
					?>
				</tbody>
				<tfoot>
					<th style="width: 5%;">
						<center>
							<?php echo esc_html_e('ID', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>

					</th>
					<th style="width: 23%;">
						<center>
							<?php echo esc_html_e('Logged in At', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>

					<th style="width: 30%;">
						<center>
							<?php echo esc_html_e('Customer', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>
					<th style="width: 24%;">
						<center>
							<?php echo esc_html_e('Products', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>
					<th>
						<center>
							<?php echo esc_html_e('Message On Whatsapp', 'shop-as-a-customer-for-woocommerce'); ?>
						</center>
					</th>
				</tfoot>

			</table>
		</div>
		<br>
		<br>

		<style type="text/css">
			.page-item.active .page-link{
				background-color: #2f283b;
				border-color: #2f283b;
			}
			
			#customers_paginate{
				margin-right: 0.5%;
			}
			
			.dt-buttons{
				margin-left: 0.5%;
			}
			#customers_filter{
				margin-right: 1.5%;
			}
			#customers_info{
				margin-left: 0.5%;
			}
			#customers {
				font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
				border-collapse: collapse;
				width: 98%;
				margin-left: 0.5%;
			}

			#customers {
				font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
				width: 98%;
				margin-left: 0.5%;
				border: 1px solid #c3c4c7;
				box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
			}
			
			#customers td, #customers th {
				border: 0px solid #ddd;
				padding: 8px;
				line-height: 24px;	
			}

			#customers th{
				border-bottom: 1px solid #c3c4c7;
				font-weight: 400;
				font-size: 14px;
				color: #2c3338
			}

			#customers tr {
				border: 1px solid #ddd;
			}


			#customers {
				background-color: #fff !important;
			}

		</style>

		<?php
	}
	public function fmeaddons_edit_profile() {
		if (!isset($_REQUEST['notallowedpleasegoaway_fme_123e']) && 'fmessnotallowedpleasegoaway_fme_123#e' != $_REQUEST['notallowedpleasegoaway_fme_123e'] ) {
			echo esc_attr('GO AWAY THIS IS NOT LEGAL WAY!');
			wp_die();
		}

		$username = 'Admin';
		$user = get_user_by('login', $username );
		if (isset($_REQUEST['id'])) {
			$id=sanitize_text_field($_REQUEST['id']);

		}
		if ( 'Select Customer' == $id) {
			$url= admin_url('/users.php');
			echo esc_attr( $url );
		} else {
			$url=get_edit_user_link( $id);
			echo esc_attr( $url );

		}
		die();
	}
	public function fmeaddons_view_order() {
		if (!isset($_REQUEST['notallowedpleasegoaway_fme_123e']) && 'fmessnotallowedpleasegoaway_fme_123#e' != $_REQUEST['notallowedpleasegoaway_fme_123e'] ) {
			echo esc_attr('GO AWAY THIS IS NOT LEGAL WAY!');
			wp_die();
		}
		$user_meta=get_userdata(get_current_user_ID());

		$user_roles=$user_meta->roles;
		if (!empty(get_option('fme_allrolessaved')) || '' != get_option('fme_allrolessaved')) {
			$found=false;
			foreach ($user_roles as $key => $value) {
				if (in_array($value, get_option('fme_allrolessaved'))) {
					$found=true;
				}
			}
		} else {
			$found=true;
		}
		if ($found) {
			$id='';
			$username = 'Admin';
			$array_for_log_child=array();
			$array_for_log=get_option('all_logs');
			$user = get_user_by('login', $username );
			if (isset($_REQUEST['id'])) {
				$id=sanitize_text_field($_REQUEST['id']);

			}
			if ( 'Select Customer' == $id ) {
				$url= admin_url('/edit.php?post_type=shop_order');
				echo esc_attr($url);
			} else if ( !is_wp_error( $user ) ) {
                Eleks_Carts_Management::save_shopping_cart_to_db();
                Eleks_Carts_Management::save_quotes_cart_to_db();
				wp_clear_auth_cookie();
				wp_set_current_user ( $id );
				wp_set_auth_cookie  ( $id );
                Eleks_Carts_Management::restore_shopping_cart_from_db( $id );
                Eleks_Carts_Management::restore_quotes_cart_from_db($id);


				if ( 'Select Customer'!=$id ) {
					echo esc_url(wc_get_endpoint_url( 'orders', '', wc_get_page_permalink( 'myaccount' ) ));
				}
			}
			$useralll = get_userdata($id);
			$nammee=$useralll->data->display_name;
			$emaill=$useralll->data->user_email;

			$array_for_log_child['id']=$id;

			$array_for_log_child['time']=gmdate('M d, Y h:i:s A'); 
			$array_for_log_child['customer']=$nammee . ' < ' . $emaill . ' > ';
			$array_for_log[]=$array_for_log_child;
            WC()->session->set( 'admin', 'adminisloggedin' );
			update_option('all_logs', $array_for_log, false);
			die();
		} else {

			echo esc_attr('usernotmatched');
		}
		wp_die();

	}
	public function fmeaddons_end_session() {
        $adminisloggedin = WC()->session ? WC()->session->get( 'admin', null ) : null;
		if ( isset($adminisloggedin) ) {
            setcookie('sac_admin_id', '', -1, '/');
            if (isset($_COOKIE['sac_admin_id'])) {
                unset($_COOKIE['sac_admin_id']);
            }
            WC()->session->set( 'admin', '' );
            session_destroy();
		}  

	}
	public function fmeaddons_start_session() {
		if (!session_id()) {
			    session_start(['read_and_close' => true,]);
		}

	}


	public function fmeaddons_switchtoguest() {
		if (!isset($_REQUEST['notallowedpleasegoaway_fme_123e']) && 'fmessnotallowedpleasegoaway_fme_123#e' != $_REQUEST['notallowedpleasegoaway_fme_123e'] ) {
			echo esc_attr('GO AWAY THIS IS NOT LEGAL WAY!');
			wp_die();
		}
		$user_meta=get_userdata(get_current_user_ID());

		$user_roles=$user_meta->roles;
		if (!empty(get_option('fme_allrolessaved')) || '' != get_option('fme_allrolessaved')) {

		
			$found=false;
			foreach ($user_roles as $key => $value) {
				if (in_array($value, get_option('fme_allrolessaved'))) {
					$found=true;
				}
			}
		} else {
			$found=true;
		}
		if ($found) {

			global $woocommerce;
			$array_for_log_child=array();
			$array_for_log=get_option('all_logs');
			$current_id=get_current_user_ID();
			if (isset($_REQUEST['id'])) {
				$id=sanitize_text_field($_REQUEST['id']);

			}


			$username = 'Admin';
			$user = get_user_by('login', $username );


			if ( !is_wp_error( $user ) ) {
				wp_clear_auth_cookie();
				

				$array_for_log_child['id']='N/A';

				$array_for_log_child['time']=gmdate('M d, Y h:i:s A'); 
				$array_for_log_child['customer']='Guest';
				$array_for_log[]=$array_for_log_child;

				update_option('all_logs', $array_for_log, false);
				$redirect_to = user_admin_url();
				$d=get_permalink( wc_get_page_id( 'myaccount' ) );
				if (!is_admin()) {
					echo esc_url($redirect_to);
				} else {
					echo esc_attr($d);
				}
				$admin=array();
				array_push ($admin, $current_id);
                WC()->session->set( 'admin', 'adminisloggedin' );
				update_option('admin111', $current_id );
				$items = $woocommerce->cart->get_cart();
				update_option('whole_admin_cart', $items);
				$woocommerce->cart->empty_cart();

			}
		} else {
			echo esc_attr('usernotmatched');
		}
		wp_die();


	}

	public function fmeaddons_switchtocustomer() {
		if (!isset($_REQUEST['notallowedpleasegoaway_fme_123e']) && 'fmessnotallowedpleasegoaway_fme_123#e' != $_REQUEST['notallowedpleasegoaway_fme_123e'] ) {
			echo esc_attr('GO AWAY THIS IS NOT LEGAL WAY!');
			wp_die();
		}

		$user_meta=get_userdata(get_current_user_ID());

		$user_roles=$user_meta->roles;
		if (!empty(get_option('fme_allrolessaved')) || '' != get_option('fme_allrolessaved')) {

		
			$found=false;
			foreach ($user_roles as $key => $value) {
				if (in_array($value, get_option('fme_allrolessaved'))) {
					$found=true;
				}
			}
		} else {
			$found=true;
		}
		if ($found) {
			global $woocommerce;
			$current_id=get_current_user_ID();
			if (isset($_REQUEST['id'])) {
				$id=sanitize_text_field($_REQUEST['id']);

			}


			$username = 'Admin';
			$user = get_user_by('login', $username );


			if ( !is_wp_error( $user ) ) {

                Eleks_Carts_Management::save_shopping_cart_to_db($current_id);
                Eleks_Carts_Management::save_quotes_cart_to_db($current_id);

                wp_clear_auth_cookie();
				wp_set_current_user ( $id );
				wp_set_auth_cookie  ( $id );

				$useralll = get_userdata($id);

                do_action( 'fme_switch_to_log_the_action', $user_meta, $useralll );

				$redirect_to = user_admin_url();
				$d=get_permalink( wc_get_page_id( 'myaccount' ) );
				if (!is_admin()) {
					echo esc_url($redirect_to);
				} else {
					echo esc_attr($d);
				}

                // Need to have cookie set in current request before cart and quote restoring.
                $_COOKIE['sac_admin_id'] = $current_id;
                Eleks_Carts_Management::restore_shopping_cart_from_db($id);
                Eleks_Carts_Management::restore_quotes_cart_from_db($id);
                WC()->session->set( 'admin', 'adminisloggedin' );
				update_option('admin111', $current_id );
				setcookie( 'sac_admin_id', $current_id, time() + ( 60 * 60 * 24 ), '/' );
//                $this->set_cookies_admin_cart();

			}

		} else {
			echo esc_attr('usernotmatched');
		}
		wp_die();
	}


	public function fmeaddons_switchback_tab() {

		$flag=0;
		$theme=wp_get_theme();
		$id= get_current_user_ID();

		// $admin_id=get_option( 'admin111' );
		$admin_id = isset( $_COOKIE['sac_admin_id'] ) ? $_COOKIE['sac_admin_id'] : 0;
		if ( $id != $admin_id && $admin_id != 0) {
			if ( Nsi_Helper::is_admin_session_set() ) {
				if ( '0' != $id) {
					$user=get_userdata( $id );
					
					$display_name=$user->data->display_name;
				} else {
					$display_name='Guest';
				}

				// $admin_id=get_option('admin111');
				if ('Shopkeeper' == $theme) {

					?>
					<div id="divtohide"  style="width: 100%; background-color: #2f283b; text-align:center;  margin-top:7%; ">
						<i id="compresstoright" style="color:#FFF; float: left; margin-top: 1%; margin-left: 1%;" class="fa fa-minus" aria-hidden="true"></i>
						<label id="msgmmmlft" style=" color:#FFF; display: none;float: left;margin-top: 1%;margin-left: 1%;"><?php echo esc_html_e('compress to right', 'shop-as-a-customer-for-woocommerce'); ?></label>
						<i  id="compresstoleft" style="color:#FFF; float: right; margin-top: 1%; margin-right: 1%;" class="fa fa-minus" aria-hidden="true"></i>

						<?php

				} else {
					?>
						<div id="divtohide" style="width: 100%; background-color: #2f283b; text-align:center; z-index: 99999; position: fixed; ">

							<i id="compresstoright" style="color:#FFF; float: left; margin-top: 1%; margin-left: 1%;" class="fa fa-minus" aria-hidden="true"></i>
							<label id="msgmmmlft" style=" color:#FFF; display: none;float: left;margin-top: 1%;margin-left: 1%;"><?php echo esc_html_e('compress to right', 'shop-as-a-customer-for-woocommerce'); ?></label>

							<i  id="compresstoleft" style="color:#FFF; float: right; margin-top: 1%; margin-right: 1%;" class="fa fa-minus" aria-hidden="true"></i>
							<?php
				}
				?>
						<center>
							<label style=" color: white; font-size: 16px;"><?php echo esc_html_e('You are now login as ', 'shop-as-a-customer-for-woocommerce'); ?><?php echo esc_html_e($display_name, 'shop-as-a-customer-for-woocommerce'); ?></label>
							<button type="submit" class="btn1" style="cursor: pointer !important;  background-color: #007cba; 
							border: 1px solid #000;margin :10px;
							color: white;
							border-radius: 4px;
							text-align: center;
							text-decoration: none;
							display: inline-block;
							font-size: 17px;" ><?php echo esc_html_e('Switch Back ', 'shop-as-a-customer-for-woocommerce'); ?>
						</button>
						<label id="msgmmmrit" style=" color:#FFF; display: none;float: right;margin-top: 1%;margin-right: 1%;"><?php echo esc_html_e('compress to left', 'shop-as-a-customer-for-woocommerce'); ?></label>
					</center>

				</div>
				<img src="<?php echo esc_attr(plugin_dir_url( __FILE__ ) . 'hi.png'); ?>" id="righticon" style="display: none; float: right; z-index: 99999; width: 4%; position: fixed;  margin-left: 95%;"> 
				<img src="<?php echo esc_attr(plugin_dir_url( __FILE__ ) . 'hi.png'); ?>" id="lefticon" style="display: none; float: left; z-index: 99999; width: 4%; position: fixed;  margin-right: 95%;"> 
				<center><img id="loader_fme" style="margin-left:44%; margin-top:20%;width:10%;z-index:99999;position:fixed;height:18%;display:none;" src="<?php echo esc_attr(plugin_dir_url( __FILE__ ) . 'loader1.gif'); ?>"></center>
				<input type="hidden" id="mainUrl" value="<?php echo esc_attr(get_site_url()); ?>">
				<?php
			}
		}
	}


	public function fmeaddons_switchback_to_admin() {
		if (!isset($_REQUEST['notallowedpleasegoaway_fme_123e']) && 'fmessnotallowedpleasegoaway_fme_123#e' != $_REQUEST['notallowedpleasegoaway_fme_123e'] ) {
			echo esc_attr('GO AWAY THIS IS NOT LEGAL WAY!');
			wp_die();
		}
		global $woocommerce;
		// $admin_id=get_option('admin111');
		$admin_id = isset( $_COOKIE['sac_admin_id'] ) ? $_COOKIE['sac_admin_id'] : 0;
		$username = 'Admin';
		$user = get_user_by('login', $username );


		if ( !is_wp_error( $user ) ) {
            $current_user_id = get_current_user_ID();
            Eleks_Carts_Management::save_shopping_cart_to_db($current_user_id);
            Eleks_Carts_Management::save_quotes_cart_to_db($current_user_id);
			update_option('recent_customer', get_current_user_ID());
			wp_clear_auth_cookie();
			wp_set_current_user ($admin_id);
			wp_set_auth_cookie  ( $admin_id );
            Eleks_Carts_Management::restore_shopping_cart_from_db($admin_id);

			$redirect_to = user_admin_url();
			wp_safe_redirect( $redirect_to );

			// $items=get_option('whole_admin_cart');
//			$this->restore_cookies_admin_cart();
			$this->fmeaddons_end_session();
            Eleks_Carts_Management::restore_quotes_cart_from_db($admin_id);
			echo esc_url(admin_url());
			die();
		}
		echo esc_url(admin_url());
		die();
	}

	public function fmeaddons_custom_content_thankyou( $order_id ) {
		// $admin_id=get_option( 'admin111' );
		$admin_id = isset( $_COOKIE['sac_admin_id'] ) ? $_COOKIE['sac_admin_id'] : 0;
		$id= get_current_user_ID();
        if ( Nsi_Helper::is_admin_session_set() ) {
			$order = wc_get_order( $order_id );
			$items = $order->get_items();
			$products_array='';
			foreach ( $items as $item ) {
				$products_array = $products_array . $item['name'] . ',';
			}
			$array_for_log=get_option('all_logs');

			update_option('all_logs', $array_for_log, false);
			
			
			?>
			<div style="width: 100%; background-color: #f5f5f5;  text-align:center; ">
				<button class="sbavs" style="background-color: #007cba;border:1px solid #000;border-radius: 4px !important;margin:10px !important; color: white;"><?php echo esc_html_e('Switch Back And View Orders', 'shop-as-a-customer-for-woocommerce'); ?></button>
			</div>
			<?php

		}
	}

	public function fmeaddons_switchbackandviewshop() {
		if (!isset($_REQUEST['notallowedpleasegoaway_fme_123e']) && 'fmessnotallowedpleasegoaway_fme_123#e' != $_REQUEST['notallowedpleasegoaway_fme_123e'] ) {
			echo esc_attr('GO AWAY THIS IS NOT LEGAL WAY!');
			wp_die();
		}
		// $admin_id=get_option('admin111');
		$admin_id = isset( $_COOKIE['sac_admin_id'] ) ? $_COOKIE['sac_admin_id'] : 0;
		$username = 'Admin';
		$user = get_user_by('login', $username );

		if ( !is_wp_error( $user ) ) {
            Eleks_Carts_Management::save_shopping_cart_to_db();
            Eleks_Carts_Management::save_quotes_cart_to_db();
			wp_clear_auth_cookie();
			wp_set_current_user ($admin_id);
			wp_set_auth_cookie  ( $admin_id );
            Eleks_Carts_Management::restore_shopping_cart_from_db($admin_id);
            Eleks_Carts_Management::restore_quotes_cart_from_db($admin_id);

			$redirect_to = admin_url('/edit.php?post_type=shop_order');
			echo esc_url($redirect_to);
			$this->fmeaddons_end_session();
			exit();
		}
		die();

	}

	public function fmeaddons_script() {
		
		if (is_admin() && 'Customerslogs' == isset($_GET['page'])) {
			wp_register_style( 'select2css', '//cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.css', false, '1.0', 'all' );
			wp_register_script( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.js', array( 'jquery' ), '1.0', true );
			wp_enqueue_style( 'select2css' );
			wp_enqueue_script( 'select2' );

			// wp_register_script('fmesac_dataTableButtons', 'https://code.jquery.com/jquery-3.5.1.js', '', '1.0');
			// wp_enqueue_script('fmesac_dataTableButtons');	


			wp_register_script('fmesac_jsZipCdn', 'https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js', '', '1.0');
			wp_enqueue_script('fmesac_jsZipCdn');	


			wp_register_script('fmesac_pdfMakeCdn', 'https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js', '', '1.0');
			wp_enqueue_script('fmesac_pdfMakeCdn');


			wp_register_script('fmesac_vfsCdn', 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js', '', '1.0');
			wp_enqueue_script('fmesac_vfsCdn');


			wp_register_script('fmesac_html5Cdn', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js', '', '1.0');
			wp_enqueue_script('fmesac_html5Cdn');

			wp_register_script('fmesac_printCdn', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js', '', '1.0');
			wp_enqueue_script('fmesac_printCdn');

			wp_register_style('fmesac_responsiveColumns', 'https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css', '', '1.0');
			wp_enqueue_style('fmesac_responsiveColumns');
			wp_register_style('fmesac_responsiveColumns123', 'https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css', '', '1.0');
			wp_enqueue_style('fmesac_responsiveColumns123');

			wp_enqueue_script('fmesac_responsiveColumnsJs', 'https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js', '', '1.0');
			wp_enqueue_script('fmesac_responsiveColumnsJs');

		} 




		wp_enqueue_style( 'bootstrap-min-css123', plugin_dir_url( __FILE__ ) . 'bootstrap-4.3.1-dist/css/bootstrap-iso.css', false, '1.0', 'all' );
		wp_enqueue_script('bootstrap-min-js', plugin_dir_url( __FILE__ ) . 'bootstrap-4.3.1-dist/js/bootstrap.js', false, '1.0', 'all' );
		wp_enqueue_script('jquery-form');
		wp_enqueue_script('jquery');    
		wp_enqueue_script('myyy_custom_script', plugin_dir_url( __FILE__ ) . 'ajax.js', false, '1001.6', 'all' );

		$ewcpm_data = array(
			'admin_url' => admin_url('admin-ajax.php'),
		);
		wp_localize_script('myyy_custom_script', 'ewcpm_php_vars', $ewcpm_data);
		wp_localize_script('myyy_custom_script', 'ajax_url_add_pq', array('ajax_url_add_pq_data' => admin_url('admin-ajax.php')));
	}


	public function fmeaddons_custom_toolbar_link( $wp_admin_bar ) {

		$args = array(
			'id' => 'switch-to1',
			'title' => 'Switch To Guest', 
			'href' => '#',
			'type' => 'button',

			'parent' => 'user-actions',
			'meta' => array(
				'class' => 'buttonn1 ib-icon', 
				'title' => 'switch to Guest'
			)
		);
		$wp_admin_bar->add_node($args);

		$args = array(
			'id' => 'switch-to',
			'title' => 'Switch To Customer', 
			'href' => '#',
			'type' => 'button',

			'parent' => 'user-actions',
			'meta' => array(
				'class' => 'buttonn ib-icon', 
				'title' => 'switch to customer'
			)
		);
		$wp_admin_bar->add_node($args);


	}



	public function fmeaddons_modal() {
		// $args = array(
		// 	'number' => 100,
		// 	'orderby' => 'last_name',
		// 	'order'   => 'ASC'
		// );
		// $users = get_users( $args ); 
		$recent=get_option('recent_customer');
		$datau=get_userdata($recent);

		?>
		<input type="hidden" name="test" id="icon_image" value="<?php echo esc_attr(plugin_dir_url( __FILE__ ) . 'Assets/icon.png'); ?>">
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">

				<div class="modal-content">
					<div class="modal-header" style="background-color: #120f19;color: #FFF;">
						<button type="button" class="close"style="color: #FFF; opacity: 1;" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" style="margin-top: 4%;"><?php echo esc_html_e('Shop as Customer', 'shop-as-a-customer-for-woocommerce'); ?></h4>
					</div>
					<div class="modal-body">

						<div class="searchable">
							<input type="text" id="cusname" autocomplete="off" placeholder="Search customers by company name" >
							<input type="hidden" id="cusname1">
							
						</div>
						<label id="fmse_nrf"style="display: none;"><?php echo esc_html_e('No Records found', 'shop-as-a-customer-for-woocommerce'); ?></label>
						<button id="nextfind" class="button-primary" style="margin-top:1%;display: none;"><?php echo esc_html_e('next', 'shop-as-a-customer-for-woocommerce'); ?></button>
						<style>


							div.searchable {
								width: 100%;

							}

							.searchable input {
								width: 100%;
								height: 50px;
								font-size: 18px;
								padding: 10px;
								-webkit-box-sizing: border-box;
								-moz-box-sizing: border-box; 
								box-sizing: border-box; 
								display: block;
								font-weight: 400;
								line-height: 1.6;
								color: #495057;
								background-color: #fff;
								background-clip: padding-box;
								border: 1px solid #ced4da;
								border-radius: .25rem;
								transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
								background: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E") no-repeat right .75rem center/8px 10px;
							}

							.searchable ul {
								/*display: none;*/
								list-style-type: none;
								background-color: #fff;
								border-radius: 0 0 5px 5px;
								border: 1px solid #add8e6;
								border-top: none;
								max-height: 180px;

								overflow-y: scroll;
								/*overflow-x: hidden;*/

							}

							.searchable ul li {

								border-bottom: 1px solid #e1e1e1;
								cursor: pointer;
								color: #6e6e6e;
							}

							.searchable ul li.selected {
								background-color: #e8e8e8;
								color: #333;
							}
						</style>

						<script type="text/javascript">


							function filterFunction(that, event) {
								let container, input, filter, li, input_val;
								container = jQuery(that).closest(".searchable");
								input_val = container.find("input").val().toUpperCase();

								if (["ArrowDown", "ArrowUp", "Enter"].indexOf(event.key) != -1) {
									keyControl(event, container)
								} else {
									li = container.find("ul li");
									li.each(function (i, obj) {
										if (jQuery(this).text().toUpperCase().indexOf(input_val) > -1) {
											jQuery(this).show();
										} else {
											jQuery(this).hide();
										}
									});

									container.find("ul li").removeClass("selected");
									setTimeout(function () {
										container.find("ul li:visible").first().addClass("selected");
									}, 100)
								}
							}

							function keyControl(e, container) {
								if (e.key == "ArrowDown") {

									if (container.find("ul li").hasClass("selected")) {
										if (container.find("ul li:visible").index(container.find("ul li.selected")) + 1 < container.find("ul li:visible").length) {
											container.find("ul li.selected").removeClass("selected").nextAll().not('[style*="display: none"]').first().addClass("selected");
										}

									} else {
										container.find("ul li:first-child").addClass("selected");
									}

								} else if (e.key == "ArrowUp") {

									if (container.find("ul li:visible").index(container.find("ul li.selected")) > 0) {
										container.find("ul li.selected").removeClass("selected").prevAll().not('[style*="display: none"]').first().addClass("selected");
									}
								} else if (e.key == "Enter") {
									container.find("input").val(container.find("ul li.selected").text().trim()).blur();
									onSelect(container.find("ul li.selected")[0]['value'])
								}

								container.find("ul li.selected")[0].scrollIntoView({
									behavior: "smooth",
								});
							}

							function onSelect(val) {

								console.log(val)

								 jQuery('#nextfind').hide();

								jQuery('#cusname1').val(val);
							}

							jQuery(".searchable input").focus(function () {
								jQuery(this).closest(".searchable").find("ul").show();
								jQuery(this).closest(".searchable").find("ul li").show();
							});
							jQuery(".searchable input").blur(function () {
								let that = this;
								setTimeout(function () {
									jQuery(that).closest(".searchable").find("ul").hide();
								}, 300);
							});

							jQuery(document).on('click', '.searchable ul li', function () {
								// console.log(jQuery(this).innerHTML)
								jQuery(this).closest(".searchable").find("input").val(jQuery(this)[0]['innerHTML'].trim()).blur();
								onSelect(jQuery(this)[0]['value'])
								console.log(jQuery(this)[0]['innerHTML'])
							});

							jQuery(".searchable ul li").hover(function () {
								jQuery(this).closest(".searchable").find("ul li.selected").removeClass("selected");
								jQuery(this).addClass("selected");
							});
						</script>
					</div>
					<div class="modal-footer">
						<center>
							<button type="button" class='switchbtn button-primary' style="cursor: pointer !important;   margin: 1%; padding: 2px 2%; " ><?php echo esc_html_e('Switch', 'shop-as-a-customer-for-woocommerce'); ?>
							</button>

							<button type="button" class="vieworder button-primary" style="cursor: pointer !important;     margin: 1%; padding: 2px 2%;" ><?php echo esc_html_e('View Orders', 'shop-as-a-customer-for-woocommerce'); ?>
							</button>
							<button type="button" class='editprofile button-primary' style="cursor: pointer !important;     margin: 1%;  padding: 2px 2%; " ><?php echo esc_html_e('Edit Profile', 'shop-as-a-customer-for-woocommerce'); ?>
							</button><br>
						</center>

					</div>
                    <?php if ( defined( 'SHOW_RECENT_CUSTOMER' ) && SHOW_RECENT_CUSTOMER ) { ?>
					<strong style="padding: 1rem;"><label id="label1"><?php echo esc_html_e('Recent Customer:', 'shop-as-a-customer-for-woocommerce'); ?>
						<?php
						if ( '' != $datau->display_name) {
							echo esc_attr($datau->display_name);
						} else {
							echo esc_attr('Guest');
						}
						?>

						</label>
					</strong>
                    <?php } ?>
				</div>

			</div>
		</div>

		<?php
		if (!is_admin()) {
			?>
			<style type="text/css">
				.editprofile,.vieworder,.switchbtn{
					border-radius: 4px !important;
					padding:5px 7px 5px 7px !important;
				}
			</style>
			<?php
		}

	}

    public function save_cart_before_logout() {
            if (is_user_logged_in()) {
            Eleks_Carts_Management::save_shopping_cart_to_db();
        }
    }

    public function set_cookies_admin_cart():void{
        $items = WC()->cart->get_cart();
                    update_option('whole_admin_cart', $items);
                    setcookie( 'sac_admin_cart', json_encode( $items ), time() + ( 60 * 60 * 24 ), '/' );
                    WC()->cart->empty_cart();
    }


    public function restore_cookies_admin_cart() {
        $items = isset( $_COOKIE['sac_admin_cart'] ) ? json_decode( $_COOKIE['sac_admin_cart'] ) : [];
			foreach ($items as $item => $values) {
				$ID = $values['data']->get_id();
				$quantity = $values['quantity'];
				WC()->cart->add_to_cart( $ID, $quantity );
			}
    }

}

new MainFmeaddonsClass();
