<?php


require_once TMWNI_DIR . 'inc/NS_Toolkit/src/NetSuiteService.php';
require_once TMWNI_DIR . 'inc/background-process/class-add-netsuite-order.php';


foreach (glob(TMWNI_DIR . 'inc/NS_Toolkit/src/Classes/*.php') as $filename) {
	require_once $filename;
}

use NetSuite\NetSuiteService;
use NetSuite\Classes\CustomerAddressbookList;
use NetSuite\Classes\CustomerAddressbook;
use NetSuite\Classes\Address;
use NetSuite\Classes\Customer;
use NetSuite\Classes\GetRequest;
use NetSuite\Classes\GetResponse;

use NetSuite\Classes\RecordRef;
use NetSuite\Classes\GetAllRequest;
use NetSuite\Classes\GetAllRecord;
use NetSuite\Classes\GetListRequest;
use NetSuite\Classes\ListOrRecordRef;
use NetSuite\Classes\Record;
use NetSuite\Classes\BaseRef;
use NetSuite\Classes\PriceLevel;
use NetSuite\Classes\GetSelectValueFieldDescription;
use NetSuite\Classes\getSelectValueRequest;
use NetSuite\Classes\RecordType;
use NetSuite\Classes\SearchMultiSelectField;
use NetSuite\Classes\SEARCHENUMMULTISELECTFIELDOPERATOR;
use NetSuite\Classes\TransactionSearchBasic;
use NetSuite\Classes\SearchRequest;
use NetSuite\Classes\AccountSearchBasic;
use NetSuite\Classes\SearchStringField;
use NetSuite\Classes\SearchStringFieldOperator;
use NetSuite\Classes\TermSearchBasic;
use NetSuite\Classes\SearchBooleanField;
use NetSuite\Classes\PriceLevelSearchBasic;


class TMWNI_Loader {

	private static $instance = null;

	public static function getInstance() {
		if (null === self::$instance) {
			self::$instance = new TMWNI_Loader();
		}
		return self::$instance;
	}

	public $netsuiteOrderClient = '';

	/**
	 * Construct
	 *
	*/ 
	public function __construct() {

		global $TMWNI_OPTIONS;
		
		if (class_exists('SOAPClient') ) {
			if (TMWNI_Settings::areCredentialsDefined()) {

				//add_action('init', array($this,'test_order'));



				$this->netsuiteService = new NetSuiteService(null, array('exceptions' => true));
				$this->add_netsuite_order = new Add_Netsuite_Order();

				require_once TMWNI_DIR . 'inc/inventory.php';
				require_once TMWNI_DIR . 'inc/orderRefund.php';

				

				if (isset($TMWNI_OPTIONS['enableCustomerSync']) && 'on' == $TMWNI_OPTIONS['enableCustomerSync']) {
					//USER PROFILE HOOKS


					//wooocommerce customer created
					add_action('woocommerce_created_customer', array($this, 'addUpdateNetsuiteCustomer'), 999);
					//wordpress user register
					add_action('user_register', array($this, 'addUpdateNetsuiteUser'), 999);

					

					//hook for detecting customer address save
					//add_action('woocommerce_update_customer', array($this, 'profileUpdateNetSuiteCustomer'),999);

					//hook for detetcting update in user profile

					add_action('profile_update', array($this, 'profileUpdateNetSuiteUser'), 999);
				}

				if (isset($TMWNI_OPTIONS['enableOrderSync']) && 'on' == $TMWNI_OPTIONS['enableOrderSync']) {

					add_action('wp_ajax_manual_order_sync', array($this, 'ManualOrderSync'));

					add_action('woocommerce_order_actions', array($this, 'sync_to_netsuite_action'));

					add_action('woocommerce_order_action_sync_to_netsuite', array($this, 'sync_to_netsuite'));


					if (isset($TMWNI_OPTIONS['ns_order_autosync_status']) && !empty($TMWNI_OPTIONS['ns_order_autosync_status'])) {
						// var_dump(is_checkout());die;
						
						if ('pending' == $TMWNI_OPTIONS['ns_order_autosync_status']) {
							add_action( 'woocommerce_checkout_order_processed', array($this, 'syncNetSuiteOrder') ); 
						} else {
							add_action('woocommerce_order_status_' . $TMWNI_OPTIONS['ns_order_autosync_status'], array($this, 'syncNetSuiteOrder'));
						}			
					} else {
						add_action('woocommerce_order_status_processing', array($this, 'syncNetSuiteOrder'));
					}


					if (isset($TMWNI_OPTIONS['ns_autosync_on_order_status_changes']) && !empty($TMWNI_OPTIONS['ns_autosync_on_order_status_changes'])) {
						foreach ($TMWNI_OPTIONS['ns_autosync_on_order_status_changes'] as $key => $value ) {
							add_action( 'woocommerce_order_status_' . $value, array($this, 'addNetsuiteOrderOnStatusChange'), 10, 2 );
						}
					}
					// Process all queued order sync to netsuite
					add_action( 'tm_ns_process_order_queue', array( $this, 'addNetsuiteOrder' ), 10, 1 );
				}



				if (( isset($TMWNI_OPTIONS['enableFulfilmentSync']) && 'on' == $TMWNI_OPTIONS['enableFulfilmentSync'] ) || ( isset($TMWNI_OPTIONS['ns_order_tracking_email']) && 'on' == $TMWNI_OPTIONS['ns_order_tracking_email'] ) || ( isset($TMWNI_OPTIONS['ns_order_auto_complete']) && 'on' == $TMWNI_OPTIONS['ns_order_auto_complete'] )) {

					if (!wp_next_scheduled('tm_ns_fetch_order_tracking_info')) {
						wp_schedule_event(time(), 'hourly', 'tm_ns_fetch_order_tracking_info');
					}

				//Fetching Order tracking info
					add_action('tm_ns_fetch_order_tracking_info', array($this, 'fetchOrderTrackingInfo'));
					// $this->fetchOrderTrackingInfo();
					if ( get_current_user_id() == 2 && isset( $_GET['fetchOrderTrackingInfo'] ) && boolval( $_GET['fetchOrderTrackingInfo'] ) ) {
						add_action('admin_init', array($this, 'fetchOrderTrackingInfo'));
					}


					

				//Custom woo order tracking email
					add_filter( 'woocommerce_email_classes', array($this,'ns_order_tracking_woocommerce_email') );

					if (isset($TMWNI_OPTIONS['syncDeletedOrders']) && 'on' == $TMWNI_OPTIONS['syncDeletedOrders']) {
						add_action( 'wp_trash_post', array($this, 'deleteNetsuiteOrder') );
					}

					if (isset($TMWNI_OPTIONS['recreateOnRestore']) && 'on' == $TMWNI_OPTIONS['recreateOnRestore']) {
						add_action( 'untrashed_post', array($this, 'restoreNetsuiteOrder') );
					}
				}
				if ( isset($TMWNI_OPTIONS['refund_order_ns_to_woo']) && 'on' == $TMWNI_OPTIONS['refund_order_ns_to_woo']) {

					if (!wp_next_scheduled('tm_ns_fetch_refund_order')) {
						wp_schedule_event(time(), 'hourly', 'tm_ns_fetch_refund_order');
					}

					//Fetching Order tracking info
					add_action('tm_ns_fetch_refund_order', array($this, 'fetchNSRefundOrder'));

				
				}

				

				//Order Refund 
				if (isset($TMWNI_OPTIONS['refund_order_ns_to_woo']) && 'on' == $TMWNI_OPTIONS['refund_order_ns_to_woo']) {
					add_action( 'woocommerce_order_refunded', array($this,'create_netsuite_refund'), 10, 2 );
				}
			} 


		} else {
			add_action( 'admin_notices', array($this,'soap_notice' ));
		}

	}

	public function soap_notice() {
		?>
		<div class="notice notice-warning is-dismissible">
			<p>PHP SOAP Extension is not enabled on your server.<a target="_blank" href="https://www.php.net/manual/en/soap.setup.php">Know more</a></p>
		</div>
		<?php


	}

	public function addUpdateNetsuiteUser( $customer_id) {
		$user_meta = get_userdata($customer_id);
		$user_roles = $user_meta->roles;

		if ('customer' == $user_roles[0]) {
			return;
		} else {
			$this->addUpdateNetsuiteCustomer($customer_id);
		}

	}


	/**
	 * User Update
	 *
	*/ 
	public function profileUpdateNetSuiteCustomer( $customer_id) {
		$customer_internal_id = get_user_meta($customer_id, TMWNI_Settings::$ns_customer_id, true);
		if (!empty($customer_internal_id)) {
			if (!empty($_GET['wc-ajax']) && 'checkout' ==$_GET['wc-ajax']) {
				$var = 'checkout';
			} else {
				$this->addUpdateNetsuiteCustomer($customer_id);
			}

		}
	}



	public function profileUpdateNetSuiteUser( $customer_id) {
		$user_meta = get_userdata($customer_id);
		$user_roles = $user_meta->roles;

		
		if (!empty($_GET['wc-ajax']) && 'checkout' ==$_GET['wc-ajax']) {
			$var = 'checkout';
		} else {
			$this->addUpdateNetsuiteCustomer($customer_id);
		}

	}





	public function syncNetSuiteOrder( $order_id) {
		$status = true;
		$status = apply_filters('tm_netsuite_order_autosync_status', $status, $order_id);
		if (true == $status) {
			//$this->addNetsuiteOrder($order_id);
			$this->push_orders_to_queue($order_id);
		}





		
	}
	

	/**
	 * Sync Order
	 *
	*/ 
	public function addNetsuiteOrder( $order_id) {
		global $TMWNI_OPTIONS;

		require_once TMWNI_DIR . 'inc/order.php';
		//instance of API client
		$this->netsuiteOrderClient = new OrderClient();


		$order = wc_get_order($order_id);

		//get user id assocaited with order
		$user_id = $order->get_user_id();

		$check_if_sent = get_post_meta($order_id, TMWNI_Settings::$ns_order_id, true);


		if (empty($check_if_sent)) {
			if (0 == $user_id) {
				$customer_internal_id = $this->addUpdateNetsuiteGuestCustomer($order);
				if (!empty($customer_internal_id)) {
					update_post_meta($order_id, TMWNI_Settings::$ns_guest_customer_id, $customer_internal_id);
				}
			} else {
				$customer_internal_id = $this->addUpdateNetsuiteCustomer($user_id, $order_id);
			}

			//get required order data

			$order_data = $this->getOrderData($order_id , TMWNI_Settings::$ns_rec_type_order);
			$order_data = apply_filters('tm_netsuite_order_data', $order_data, $order_id);

			//set order id
			$this->netsuiteOrderClient->order_id = $order_id;

			if (0 != $customer_internal_id) {
				//add order on netsuite
				$order_netsuite_internal_id = $this->netsuiteOrderClient->addOrder($order_data, $customer_internal_id);
				// pr($order_netsuite_internal_id);die;
				if (0 !== $order_netsuite_internal_id) {
					update_post_meta($order_id, TMWNI_Settings::$ns_order_id, $order_netsuite_internal_id);
				}
                if (NULL !== $order_netsuite_internal_id) {
                    delete_post_meta( $order_id, 'add_order_sync_in_progress' );
                }
			}
		} else {
			if (0 == $user_id) {
				$customer_internal_id = $this->addUpdateNetsuiteGuestCustomer($order);
			} else {
				$customer_internal_id = $this->addUpdateNetsuiteCustomer($user_id, $order_id);
			}
			

			//get required order data
			$order_data = $this->getOrderData($order_id, TMWNI_Settings::$ns_rec_type_order);
			$order_data = apply_filters('tm_netsuite_order_data', $order_data, $order_id);

			$order_netsuite_internal_id = $this->netsuiteOrderClient->updateOrder($order_data, $customer_internal_id, $check_if_sent);
			
		}
		
		// if (isset($order_netsuite_internal_id) && 0 != $order_netsuite_internal_id) {
		// 	update_post_meta( $order_id, 'tm_netsuite_order_processed', true );
		// } else {
		// 	delete_post_meta($order_id, '_tm_netsuite_process_waiting');
		// 	delete_post_meta($order_id, 'tm_netsuite_order_processed');
		// }


		return $order_netsuite_internal_id;
	}

	/**
	 * Order Tracking Woo email
	 *
	*/ 
	public function ns_order_tracking_woocommerce_email( $email_classes ) {

		// add the custom email class to the list of email classes that WooCommerce loads
		$email_classes['WC_NetSuite_Order_Tracking_No'] = require( TMWNI_DIR . 'inc/woo-email-class/class-wc-netsuite-order-tracking-email.php' );

		return $email_classes;

	}

	/**
	 * Sync  to NS
	 *
	*/ 
	public function sync_to_netsuite_action( $actions) {
		$actions['sync_to_netsuite'] = __('Sync to NetSuite', 'songlify');
		return $actions;
	}



	public function ManualOrderSync() {
		global $TMWNI_OPTIONS;

		if (isset($_POST['nonce']) && !empty($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field($_POST['nonce']), 'security_nonce') ) {
			die('Order Logs Nonce Error'); 
		}


		
		if (isset($_POST['order_id']) && !empty($_POST['order_id']) ) {
			if (isset($TMWNI_OPTIONS['enableOrderSync']) && 'on' == $TMWNI_OPTIONS['enableOrderSync']) {
				$order_id = intval($_POST['order_id']);
				$response = $this->addNetsuiteOrder($order_id);
				esc_attr_e($response); 
			}
		}


	}


	

	/**
	 * Order status change
	 *
	*/ 
	public function addNetsuiteOrderOnStatusChange( $order_id, $instance) {

		global $TMWNI_OPTIONS;
		$status = true;
		if (isset($TMWNI_OPTIONS['enableOrderSync']) && 'on' == $TMWNI_OPTIONS['enableOrderSync']) {
			$status = apply_filters('tm_add_netsuite_order_on_status_change', $status, $order_id);			
			
			if (true == $status) {
			 //$this->addNetsuiteOrder($order_id);
				$this->push_orders_to_queue($order_id);
			}
		}
		return;
	}

	/**
	 * Sync Order to Netsuite
	 *
	*/ 
	public function sync_to_netsuite( $order) {
		global $TMWNI_OPTIONS;
		$status = true;

		// pr($status);

		if (isset($TMWNI_OPTIONS['enableOrderSync']) && 'on' == $TMWNI_OPTIONS['enableOrderSync']) {
			if (!is_object($order)) {
				
				$status = apply_filters('tm_add_netsuite_order', $status, $order);
				if (true == $status) {
					//$this->addNetsuiteOrder($order);
					$this->push_orders_to_queue($order->get_id());

				}
				

			} else {
				$status  = apply_filters('tm_add_netsuite_order', $status, $order->get_id());
				if (true == $status) {
					//$this->addNetsuiteOrder($order->get_id());
					$this->push_orders_to_queue($order->get_id());

				}
				

			}
		}
		return;
	}

	/**
	 * Hook function which will recieve customer id and pass it to net  update_user_meta($customer_id, TMWNI_Settings::$ns_customer_id, $customer_internal_id);
	 */
	public function addUpdateNetsuiteCustomer( $customer_id, $order_id = 0) {
		$customer_sync = true;
		$customer_sync = apply_filters('tm_ns_customer_sync_status_check', $customer_id);
		if (true == $customer_sync) {
			if ($order_id) {
				do_action('before_add_update_netsuite_customer', $customer_id, $order_id);
			}



			global $TMWNI_OPTIONS;

		//get and set customer data 
			$woo_customer_data = get_userdata($customer_id);

		//check if passed user is a customer
			if (isset($woo_customer_data->roles[0]) && in_array($woo_customer_data->roles[0], $TMWNI_OPTIONS['customer_roles'])) {
				require_once TMWNI_DIR . 'inc/customer.php';

				//instance of API client
				$netsuiteCustomerClient = new CustomerClient();
				$email = $woo_customer_data->data->user_email;
				$customer_internal_id = get_user_meta($customer_id, TMWNI_Settings::$ns_customer_id, true);

				if (empty($customer_internal_id)) {
					//check if customer already registered on netsuite
					$customer_internal_id = $netsuiteCustomerClient->searchCustomer($woo_customer_data->data->user_email, $customer_id);
                    update_user_meta($customer_id, TMWNI_Settings::$ns_customer_id, $customer_internal_id);
				}

                if ( empty($customer_internal_id) ) {
                    if (!empty($woo_customer_data->first_name) && !empty($woo_customer_data->last_name)) {
                        $first_name = $woo_customer_data->first_name;
                        $last_name = $woo_customer_data->last_name;
                    } else {
                        $first_name = get_user_meta($customer_id, 'billing_first_name', true);
                        $last_name = get_user_meta($customer_id, 'billing_last_name', true);
                    }

                    $company_name = get_user_meta($customer_id, 'billing_company', true);
                    $phone = get_user_meta($customer_id, 'billing_phone', true);

                    $customer_data = array(
                        'customer_id' => $customer_id,
                        'firstName' => $first_name,
                        'lastName' => $last_name,
                        'email' => $email,
                        'companyName' => $company_name,
                        'phone' => $phone
                    );

                    $address_type = array('billing', 'shipping');
                    $addresses = array();
                    foreach ($address_type as $single_address) {
                        $address['firstName'] = get_user_meta($customer_id, $single_address . '_first_name', true);
                        $address['lastName'] = get_user_meta($customer_id, $single_address . '_last_name', true);
                        $address['companyName'] = get_user_meta($customer_id, $single_address . '_company', true);
                        $address['address1'] = get_user_meta($customer_id, $single_address . '_address_1', true);
                        $address['address2'] = get_user_meta($customer_id, $single_address . '_address_2', true);
                        $address['city'] = get_user_meta($customer_id, $single_address . '_city', true);
                        $address['state'] = get_user_meta($customer_id, $single_address . '_state', true);
                        $address['postcode'] = get_user_meta($customer_id, $single_address . '_postcode', true);
                        $address['country'] = get_user_meta($customer_id, $single_address . '_country', true);
                        $addresses[$single_address] = $address;
                    }

                    $alb = '';
                    $als = '';
                    foreach ($addresses as $key => $address) {
                        if (isset($address['country']) && !empty($address['country'])) {
                            $ns_country = TMWNI_Settings::$netsuite_country[$address['country']];
                        } else {
                            $ns_country = '';
                        }

                        if ('billing' == $key) {
                            $alb = new CustomerAddressbook();
                            $alb->internalId = $customer_internal_id;
                            $alb->defaultShipping = false;
                            $alb->defaultBilling = true;
                            $alb->isResidential = true;
                            $alb->label = 'Customer Address Billing';
                            $alb->addressbookAddress = new Address();
                            $alb->addressbookAddress->addr1 = $address['address1'];
                            $alb->addressbookAddress->addr2 = $address['address2'];
                            $alb->addressbookAddress->addr3 = '';

                            $alb->addressbookAddress->addrPhone = $phone;
                            $alb->addressbookAddress->addrText = $address['address1'];

                            $alb->addressbookAddress->city = $address['city'];
                            $alb->addressbookAddress->country = $ns_country;
                            $alb->addressbookAddress->internalId = $customer_internal_id;
                            $alb->addressbookAddress->override = false;
                            $alb->addressbookAddress->state = $address['state'];
                            $alb->addressbookAddress->zip = $address['postcode'];

                            if (!empty($address['companyName'])) {
                                $alb->addressbookAddress->attention = $address['firstName'] . ' ' . $address['lastName'];
                                $alb->addressbookAddress->addressee = $address['companyName'];

                            } else {
                                $alb->addressbookAddress->addressee = $address['firstName'] . ' ' . $address['lastName'];

                            }
                        } elseif ('shipping' == $key) {
                            $als = new CustomerAddressbook();
                            $als->internalId = $customer_internal_id;
                            $als->defaultShipping = true;
                            $als->defaultBilling = false;
                            $als->isResidential = false;
                            $als->label = 'Customer Address Shipping';
                            $als->addressbookAddress = new Address();
                            $als->addressbookAddress->addr1 = $address['address1'];
                            $als->addressbookAddress->addr2 = $address['address2'];
                            $als->addressbookAddress->addr3 = '';
                            // $als->addressbookAddress->attention = $address['firstName'] . ' ' . $address['lastName'];
                            // ;
                            $als->addressbookAddress->addrPhone = '';
                            $als->addressbookAddress->addrText = $address['address1'];
                            // $als->addressbookAddress->addressee = $address['companyName'];
                            $als->addressbookAddress->city = $address['city'];
                            $als->addressbookAddress->country = $ns_country;
                            $als->addressbookAddress->internalId = $customer_internal_id;
                            $als->addressbookAddress->override = false;
                            $als->addressbookAddress->state = $address['state'];
                            $als->addressbookAddress->zip = $address['postcode'];


                            if (!empty($address['companyName'])) {
                                $alb->addressbookAddress->attention = $address['firstName'] . ' ' . $address['lastName'];
                                $alb->addressbookAddress->addressee = $address['companyName'];

                            } else {
                                $alb->addressbookAddress->addressee = $address['firstName'] . ' ' . $address['lastName'];

                            }
                        }

                    }

                    $address_data = [$alb, $als];

                    $address_data = apply_filters('tm_netsuite_customer_address_data', $address_data, $customer_id);
                    $al = new CustomerAddressbookList();
                    $al->addressbook = $address_data;

                    //update customer data
                    // $netsuiteCustomerClient->updateCustomer($customer_data, $customer_internal_id, $al, $address['state'], $order_id);

                    //add customer to netsuite
                    $customer_internal_id = $netsuiteCustomerClient->addCustomer($customer_data, $al, $address['state'], $order_id);
                    if ( $customer_internal_id ) {
                        update_user_meta($customer_id, TMWNI_Settings::$ns_customer_id, $customer_internal_id);
                    }
                }

				return $customer_internal_id;

			} else {
				require_once TMWNI_DIR . 'inc/common.php';
				$netsuiteCommonIntegrationFunctions = new CommonIntegrationFunctions();
				$error_msg = 'Please select ' . $woo_customer_data->roles[0] . ' role in customer tab';
				$netsuiteCommonIntegrationFunctions->handleLog(1, $customer_id, 'Customer', $error_msg);

				return 0;
			}

		}
	}
	/**
	 * Sync Guest Customer
	 *
	*/ 
	public function addUpdateNetsuiteGuestCustomer( $order) {

		if ($order) {
			$customer_internal_id = apply_filters('before_add_update_guest_netsuite_customer', 0, $order);
			// do_action("before_add_update_guest_netsuite_customer",$order);
		}
		require_once TMWNI_DIR . 'inc/customer.php';
		//instance of API client
		$netsuiteCustomerClient = new CustomerClient();

		$email = $order->get_billing_email();
		
		$customer_id = 0;
		// $customer_internal_id = 0;
		// //check if customer already registered on netsuite
		// $customer_internal_id = $netsuiteCustomerClient->searchCustomer($email);
		if (empty($customer_internal_id)) {
			$customer_internal_id = 0;
			$customer_internal_id = $netsuiteCustomerClient->searchCustomer($email);
		}
		$first_name = $order->get_billing_first_name();
		$last_name = $order->get_billing_last_name();
		$company_name = $order->get_billing_company();
		$cust_address = $order->get_Address();
		$phone = $order->get_billing_phone();
		$cust_order_id = $order->get_id();

		$customer_data = array(
			'customer_id' => $customer_id,
			'firstName' => $first_name,
			'lastName' => $last_name,
			'email' => $email,
			'companyName' => $company_name,
			'phone' => $phone,
		);


		$address_type = array('billing', 'shipping');
		$addresses = array();


		$alb = '';
		$als = '';
		foreach ($address_type as $key => $type) {
			if ('billing' == $type) {
				if (!empty($order->get_billing_country())) {
					$ns_country = TMWNI_Settings::$netsuite_country[$order->get_billing_country()];
				} else {
					$ns_country = '';
				}
				$alb = new CustomerAddressbook();
				$alb->internalId = $customer_internal_id;
				$alb->defaultShipping = false;
				$alb->defaultBilling = true;
				$alb->isResidential = true;
				$alb->label = 'Customer Address Billing';
				$alb->addressbookAddress = new Address();
				$alb->addressbookAddress->addr1 = $order->get_billing_address_1();
				$alb->addressbookAddress->addr2 = $order->get_billing_address_2();
				$alb->addressbookAddress->addr3 = '';
				$alb->addressbookAddress->attention = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
				$alb->addressbookAddress->addrPhone = $order->get_billing_phone();
				$alb->addressbookAddress->addrText = $order->get_billing_address_1();
				$alb->addressbookAddress->addressee = $order->get_billing_company();
				$alb->addressbookAddress->city = $order->get_billing_city();
				$alb->addressbookAddress->country = $ns_country;
				$alb->addressbookAddress->internalId = $customer_internal_id;
				$alb->addressbookAddress->override = false;
				$alb->addressbookAddress->state = $order->get_billing_state();
				$alb->addressbookAddress->zip = $order->get_billing_postcode();
			}
			if ('shipping' == $type) {
				if (!empty($order->get_shipping_country())) {
					$ns_country = TMWNI_Settings::$netsuite_country[$order->get_shipping_country()];
				} else {
					$ns_country = '';
				}
				$als = new CustomerAddressbook();
				$als->internalId = $customer_internal_id;
				$als->defaultShipping = true;
				$als->defaultBilling = false;
				$als->isResidential = false;
				$als->label = 'Customer Address Shipping';
				$als->addressbookAddress = new Address();
				$als->addressbookAddress->addr1 = $order->get_shipping_address_1();
				$als->addressbookAddress->addr2 = $order->get_shipping_address_2();
				$als->addressbookAddress->addr3 = '';
				$als->addressbookAddress->attention = $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name();
				$als->addressbookAddress->addrPhone = '';
				$als->addressbookAddress->addrText = $order->get_shipping_address_1();
				$als->addressbookAddress->addressee = $order->get_shipping_company();
				$als->addressbookAddress->city = $order->get_shipping_city();
				$als->addressbookAddress->country = $ns_country;
				$als->addressbookAddress->internalId = $customer_internal_id;
				$als->addressbookAddress->override = false;
				$als->addressbookAddress->state = $order->get_shipping_state();
				$als->addressbookAddress->zip = $order->get_shipping_postcode();
			}

		}
		
		$address_data = [$alb, $als]; 
		


		//update customer if it already exists on netsuite
		$address_data = apply_filters('tm_netsuite_customer_address_data', $address_data, $customer_id);
		$al = new CustomerAddressbookList();
		$al->addressbook = $address_data;



		if (!empty($customer_internal_id)) {
			$netsuiteCustomerClient->updateCustomer($customer_data, $customer_internal_id, $al, $cust_address['state'], $cust_order_id);
		} else {
			//add customer to netsuite
			$customer_internal_id = $netsuiteCustomerClient->addCustomer($customer_data, $al, $cust_address['state'], $cust_order_id);
		}
		return $customer_internal_id;
	} 
	

	/**
	 * Get Order Data
	 *
	*/ 
	public function getOrderData( $order_id, $rec_type) {
		global $TMWNI_OPTIONS;
		$data = array();
		
		//instance of woocommerce order class
		$order = new WC_Order($order_id);
		
		//set other order related data
		$data['order_id'] = $order_id;
		$data['order'] = $order;
		
		//get user id assocaited with order
		$user_id = $order->get_user_id();
		if (!$user_id) { //if customer is not a registered woocommerce user then use billing email
			$data['customer_email'] = $order->get_billing_email();
		} else {  //else fetch user email from woocommerce 
			$user_data = get_userdata($user_id);
			$data['customer_email'] = $user_data->data->user_email;
		}
		$data['order_status'] = $order->get_status();
		$data['order_currency'] = $order->get_currency();
		$data['total_shipping'] = $order->get_total_shipping();
		$billing_address = $order->get_Address();
        if ( empty($billing_address['country']) ) {
            $billing_address['country'] = get_user_meta($user_id, 'billing_country', true);
            $billing_address['state'] = get_user_meta($user_id, 'billing_state', true);
        }
        $ns_country = TMWNI_Settings::$netsuite_country[$billing_address['country']];

		$billing_address['country'] = $ns_country;
		$data['billing_address'] = $billing_address;
		//old shiiping code
		$data['shipping_address'] = $order->get_Address('shipping');
        if (empty($data['shipping_address']['country'])) {
            $data['shipping_address']['country'] = get_user_meta($user_id, 'shipping_country', true);
            $data['shipping_address']['state'] = get_user_meta($user_id, 'shipping_state', true);
        }
        $ns_shipping_country = TMWNI_Settings::$netsuite_country[$data['shipping_address']['country']];

		//breaking shipping address
		$data['shipping_address']['country'] = $ns_shipping_country;
		$order_payment_method_id = $order->get_payment_method();
		$data['order_payment_method'] = $order_payment_method_id;
		// pr(WC()->shipping->get_shipping_methods());die;
		$shipping_method = array_values($order->get_shipping_methods());
		$data['order_shipping_method'] = $shipping_method;
		$order_items = array_values($order->get_items());
		$data['items'] = array();
		//get items associated with orders
		$data['items'] = $this->checkOrderItems($order_items, $order_id, $rec_type);
		// pr($data['items']);exit;
		return $data;
	}
	/**
	 * Check Order Items
	 *
	*/ 
	public function checkOrderItems( $order_items, $order_id, $rec_type) {
		$items = array();
		$count = 0;
        $order = new WC_Order($order_id);
        $order_user_id = $order->get_user_id();
        $items_locations_meta = array();
		foreach ($order_items as $key => $order_item) {
			$product = new WC_Product($order_item['product_id']);
			$product_sku = $product->get_sku(); // MANISH : CHANGE THIS TO CUSTOM FIELD
			if (isset($order_item['variation_id']) && !empty($order_item['variation_id'])) {
				$variation_obj = new WC_Product_Variation($order_item['variation_id']);
				if ($variation_obj->variation_has_sku) {
					$product_sku = $variation_obj->get_sku();
				}
				$unit_price = $variation_obj->get_price();
				$netsuite_internal_id = get_post_meta($order_item['variation_id'], TMWNI_Settings::$ns_product_id, true);

			} else {
				$unit_price = $product->get_price();
				$netsuite_internal_id = get_post_meta($order_item['product_id'], TMWNI_Settings::$ns_product_id, true);
			}
			//Search order item's internalId from Netsuite based on woocommerce product's SKU
			
			if (empty($netsuite_internal_id)) {
				if (TMWNI_Settings::$ns_rec_type_order == $rec_type) {
					$netsuite_internal_id = $this->netsuiteOrderClient->searchItem($product_sku, $order_item['product_id'], $order_item['variation_id']);
				}
			//if internalId is not found for any one of the order item, stop order transfer script
				if (0 == $netsuite_internal_id) {
					continue;
				}

			}
			
			if (isset($order_item['variation_id']) && !empty($order_item['variation_id'])) { 
				$location_id = get_post_meta($order_item['variation_id'], 'ns_item_location_id', true);
			} else {
				$location_id = get_post_meta($order_item['product_id'], 'ns_item_location_id', true);
			}

            $user_division = get_user_meta( $order_user_id, 'ns_division_name', true );
            if ( !empty($user_division) && strtolower($user_division) == 'electrical' ) {
                $locations = get_post_meta( $product->get_id(), 'locations_stock' );
                $user_ns_main_location = json_decode( get_user_meta($order_user_id, 'ns_main_location', true) );
                $check_backup = true;

                if ( !empty($user_ns_main_location->id) && isset($locations[0][$user_ns_main_location->id]['location_reorder']) ) {
                    $reorder_point = intval( $locations[0][$user_ns_main_location->id]['location_reorder'] );
                    if ( ($reorder_point * 0.25) <= $locations[0][$user_ns_main_location->id]['location_quantity'] ) {
                        $location_id = $user_ns_main_location->id;
                        $check_backup = false;
                    }
                }

                if ( $check_backup && !empty($user_ns_main_location->id) ) {
                    $backup_location_id = Crown_Shop_Products::get_backup_location_for_main_location( $user_ns_main_location->id )[0]['backup_location'] ?? [];

                    if (
                        !empty($backup_location_id) && isset($locations[0][$backup_location_id]['location_reorder']) &&
                        (intval($locations[0][$backup_location_id]['location_reorder']) * 0.25) <= $locations[0][$backup_location_id]['location_quantity']
                    ) {
                        $location_id = $backup_location_id;
                    }
                }
            }

			$items[$key]['internalId'] = $netsuite_internal_id;
			$items[$key]['total'] = $order_item['total'];
			$items[$key]['unit_price'] = $unit_price;
			$items[$key]['qty'] = $order_item['qty'];
			$items[$key]['total_tax'] = $order_item['total_tax'];
			$items[$key]['locationId'] = $location_id;
			$items[$key]['productId'] = $order_item['product_id'];
			$items[$key]['subtotal'] = $order_item['subtotal'];
            $items_locations_meta[$product_sku] = $location_id;
			
		}
		$items = array_reverse($items);
        update_post_meta( $order_id, 'items_locations', json_encode($items_locations_meta) );
		return $items;
	}

	

	/**
	 * Order tracking file include
	 *
	*/ 
	public function fetchOrderTrackingInfo() {
		global $TMWNI_OPTIONS;
        $search_date = get_option( 'fetchOrderTrackingInfoLastModifiedDate', '' );
        $date_now = date( DATE_ATOM, strtotime('now') );

		if (isset($TMWNI_OPTIONS['enableFulfilmentSync']) && 'on' == $TMWNI_OPTIONS['enableFulfilmentSync']) {
			if ( class_exists( 'Crown_Shop_Orders' ) ) {
				Crown_Shop_Orders::sync_order_statuses( array('search_date' => $search_date) );
				return;
			}
			require_once TMWNI_DIR . 'inc/orderTracking.php';
			$this->netsuiteOrderTrackingClient = new OrdertrackingClient();
			$this->netsuiteOrderTrackingClient->getProcessingOrders( array(), $search_date );
		} elseif (( isset($TMWNI_OPTIONS['ns_order_tracking_email']) && 'on' == $TMWNI_OPTIONS['ns_order_tracking_email'] ) || ( isset($TMWNI_OPTIONS['ns_order_auto_complete']) && 'on' == $TMWNI_OPTIONS['ns_order_auto_complete'] )) {
			if ( class_exists( 'Crown_Shop_Orders' ) ) {
				Crown_Shop_Orders::sync_order_statuses( array('search_date' => $search_date) );
				return;
			}
			require_once TMWNI_DIR . 'inc/orderTracking.php';
			$this->netsuiteOrderTrackingClient = new OrdertrackingClient();
			$this->netsuiteOrderTrackingClient->getProcessingOrders( array(), $search_date );
		}

        update_option( 'fetchOrderTrackingInfoLastModifiedDate', $date_now );
	}

	/**
	 * Delete Order
	 *
	*/ 
	public function deleteNetsuiteOrder( $post_id) {
		global $TMWNI_OPTIONS;
		if ('shop_order' == get_post_type($post_id)) {
			$nsOrderInternalId = get_post_meta($post_id, TMWNI_Settings::$ns_order_id, true);
			

			if (!empty($nsOrderInternalId)) {
				require_once TMWNI_DIR . 'inc/order.php';
				$this->netsuiteOrderClient = new OrderClient();
				$this->netsuiteOrderClient->deleteOrder($nsOrderInternalId);
				delete_post_meta( $post_id, TMWNI_Settings::$ns_order_id);
			}
		}
		return;
	}
	/**
	 * Restore Order
	 *
	*/ 
	public function restoreNetsuiteOrder( $post_id) {
		global $TMWNI_OPTIONS;
		if ('shop_order' == get_post_type($post_id) ) {
			$this->addNetsuiteOrder($post_id);
		}
		return;

	}


	public function push_orders_to_queue( $order_id) {
		$this->add_netsuite_order->push_to_queue($order_id);
		$this->add_netsuite_order->save()->dispatch();

		return false;
	}


	// Order Refund Woo to NS
	public function create_netsuite_refund( $order_id, $refund_id ) {
		// if (isset($_POST['action']) && 'woocommerce_refund_line_items' == $_POST['action'] ) {
			$order_ns_id = get_post_meta($order_id, TMWNI_Settings::$ns_order_id, true); 
		if (!empty($order_ns_id)) {
			$orderRefund = new OrderRefund();
			$ns_order_refund_id = $orderRefund->create_nd_refund( $order_id, $refund_id, $order_ns_id );
			if (!empty($ns_order_refund_id)) {
				update_post_meta($order_id, TMWNI_Settings::$ns_order_refund_internal_id, $ns_order_refund_id);

			}

		}

			
	}
		
	// }

	public static function fetchNSRefundOrder() {
		$orderRefund = new OrderRefund();
		$ns_order_refund_id = $orderRefund->get_refund_order();

	}


}

function TMWNI_Loader() {
	return TMWNI_Loader::getInstance();
}
