<?php

use CrownShop\Enums\DualManagerMode;

if (!class_exists('Crown_Shop_Custom_Roles')) {
    class Crown_Shop_Custom_Roles
    {
        public static $init = false;

        //TODO: rewrite after caching be enabled since additional user_role will be redundant
        public static $role;
        public static int $order_viewer_user_id;
        public static $current_user;
        public static $administrator_role_name = 'administrator';
        public static $customer_role_name = 'customer';
        public static $customer_service_role_name = 'customer_service';
        public static $order_viewer_role_name = 'order_viewer';
        public static $pricing_role_name = 'pricing';
        public static $internal_sales_rep_role_name = 'internal_sales_rep';
        public static $shop_manager_role_name = 'shop_manager';
        public static $dual_shop_manager_role_name = 'dual_shop_manager';
        public static $editor_role_name = 'editor';
        public static $branch_admin_role_name = 'branch_admin';
        public static $branch_employee_viewer_role_name = 'branch_employee_viewer';
        public static $branch_employee_role_name = 'branch_employee';
        public static array $users_to_display_data_for = array();
        private static $dual_managers_hooks_added = false;


        public static function init()
        {

            if (self::$init) return;
            self::$init = true;

            add_action('plugins_loaded', array( __CLASS__, 'set_current_user' ), -2 );

            //TODO: refactor as factory
            self::add_new_user_roles();

			add_filter('option_page_capability_rfq_notifications_settings', array(__CLASS__, 'add_manage_rfg_notification_settings_capability'), 10 );
			add_action('init', array(__CLASS__, 'add_manage_rfg_notification_settings_capability_to_existing_roles'));
			add_action('init', array(__CLASS__, 'add_smartslider_capabilities_to_editor'));
            add_action('init', array(__CLASS__, 'restrict_posts_updates'));
            add_action('woocommerce_loaded', array(__CLASS__, 'init_after_woo_loaded_hooks'));

            add_action('admin_enqueue_scripts', array(__CLASS__, 'add_custom_wp_admin_scripts_and_styles'));
            add_action('wp_enqueue_scripts', array(__CLASS__, 'add_custom_frontend_scripts_and_styles'));
            add_action('save_post', array(__CLASS__, 'add_custom_actions_on_post_update'), 10, 2);
            add_action('set_user_role', array( __CLASS__, 'users_role_changes_actions' ), 10, 2);
            add_filter('editable_roles', array( __CLASS__, 'restrict_user_roles_for_branch_admin') );
            add_action( 'admin_footer', array( __CLASS__, 'hide_no_role_option_for_branch_admin') );
            add_action('template_redirect', array( __CLASS__, 'restrict_draft_product_preview') );
            add_action('template_redirect', array( __CLASS__, 'check_quote_view_permissions') );
            add_action('set_user_role', array( __CLASS__, 'clear_user_sessions_on_role_change'), 10, 3);
            add_filter('views_edit-shop_order', array( __CLASS__, 'update_order_counters_in_admin_panel' ), 10, 1 );
        }

        public static function add_new_user_roles() {
            self::add_customer_service_role();
            self::add_orders_viewer_role();
            self::add_pricing_role();
            self::add_internal_sales_rep_role();
            self::add_branch_employee_viewer_role();
            self::add_branch_employee_role();
            self::add_branch_admin_role();
            self::add_dual_shop_manager_role();
        }

        public static function set_current_user() {
            if( !isset( self::$current_user ) ) {
                self::$current_user = wp_get_current_user();
            }
        }

        public static function add_custom_wp_admin_scripts_and_styles() {
            self::hide_element_for_role( self::$customer_service_role_name, array( 'body.post-type-addify_quote #publishing-action' ) );
            self::hide_element_for_role( self::$internal_sales_rep_role_name, array(
                'body.post-type-addify_quote #publishing-action',
                'body.post-type-addify_quote .addify_converty_to_order_button .right-buttons',
                'body.user-edit-php .submit'
            ));
            self::disable_user_profile_edit_for_role( self::$internal_sales_rep_role_name );
            self::hide_element_for_role( self::$branch_admin_role_name, array(
                'body.post-type-addify_quote #publishing-action',
                'body.post-type-addify_quote .addify_converty_to_order_button .left-buttons',
                'body.post-type-addify_quote #afrfq-quote-info .addify_quote_items_wrapper .delete-quote-item',
                'body.post-type-addify_quote #misc-publishing-actions .edit-post-status',
                'body.post-type-addify_quote #misc-publishing-actions .edit-visibility',
                'body.post-type-addify_quote #misc-publishing-actions .edit-timestamp',
            ));
            self::disable_element_for_role( self::$branch_admin_role_name, array(
                'body.post-type-addify_quote input',
                'body.post-type-addify_quote label',
                'body.post-type-addify_quote textarea',
                'body.post-type-addify_quote select',
                'body.post-type-addify_quote .select2',
                'body.post-type-addify_quote #misc-publishing-actions .edit-post-status',
                'body.post-type-addify_quote #misc-publishing-actions .edit-visibility',
                'body.post-type-addify_quote #misc-publishing-actions .edit-timestamp',
            ));
        }

        public static function add_custom_frontend_scripts_and_styles() {
            $roles = wp_roles()->roles;
            $role_names = array_keys($roles);
            foreach ( $role_names as $role_name ) {
                $selectors_to_hide = array('body.product-template-default.single-product .single_add_to_cart_button', '#header-buttons #account-menu .menu-item.cart:first-of-type');
                $menu_item_quote_selector = '#header-buttons #account-menu .menu-item.quote, body.product-template-default.single-product .afrfqbt_single_page.single_add_to_cart_button.button.alt.product_type_simple';
                if ( $role_name != self::$customer_role_name ) {
                    if ( $role_name === self::$dual_shop_manager_role_name && defined('DUALSHOP_QUOTES_CREATION_RESTRICTED') && DUALSHOP_QUOTES_CREATION_RESTRICTED) {
                        $selectors_to_hide[] = $menu_item_quote_selector;
                    }
                    self::hide_element_for_role( $role_name, $selectors_to_hide );
                } else {
                    $admin_id = isset( $_COOKIE['sac_admin_id'] ) ? $_COOKIE['sac_admin_id'] : 0;
                    $admin_user = get_user_by( 'id', $admin_id );
                    if (
                        self::$current_user->ID != $admin_id && $admin_id != 0
                        && isset( $admin_user->roles[0] ) && $admin_user->roles[0] === 'dual_shop_manager'
                    ) {
                        if ( ! defined('DUALSHOP_ORDERS_CREATION_RESTRICTED') || ! DUALSHOP_ORDERS_CREATION_RESTRICTED) {
                            $selectors_to_hide = array();
                        }
                        if ( defined('DUALSHOP_QUOTES_CREATION_RESTRICTED') && DUALSHOP_QUOTES_CREATION_RESTRICTED ) {
                            $selectors_to_hide[] = $menu_item_quote_selector;
                        }
                        if ( ! empty( $selectors_to_hide ) ) {
                            self::hide_element_for_role( self::$current_user->roles[0], $selectors_to_hide );
                        }
                    }
                }
            }
        }

        public static function hide_element_for_role( $role, array $selectors ) {
            if ( !isset(self::$current_user->roles[0]) || self::$current_user->roles[0] !== $role ) {
                return;
            }

            echo '<style>' . implode( ',', $selectors ) . ' { display: none; }</style>';
        }

        public static function disable_element_for_role( $role, array $selectors ) {
            if ( !isset(self::$current_user->roles[0]) || self::$current_user->roles[0] !== $role ) {
                return;
            }

            echo '<style>' . implode( ',', $selectors ) . ' { pointer-events: none; }</style>';
        }

        public static function disable_user_profile_edit_for_role( $role ) {
            if ( !isset(self::$current_user->roles[0]) || self::$current_user->roles[0] !== $role ) {
                return;
            }

            add_action('user_profile_update_errors', function($errors) use ($role) {
                if (isset(self::$current_user->roles[0]) && self::$current_user->roles[0] === $role) {
                    $errors->add('role_error', __('You are not allowed to edit your profile.'));
                }
            }, 10, 1);

        }

        public static function add_custom_actions_on_post_update( $post_id, $post ) {
            self::restrict_post_update_by_role_cpt_action( $post, self::$customer_service_role_name, 'addify_quote', true, 'addify_convert_to_order' );
            self::restrict_post_update_by_role_cpt_action( $post, self::$internal_sales_rep_role_name, 'shop_order' );
            self::restrict_post_update_by_role_cpt_action( $post, self::$editor_role_name, 'addify_quote' );
            self::restrict_post_update_by_role_cpt_action( $post, self::$branch_admin_role_name, 'addify_quote', true, 'addify_convert_to_order' );
        }

        public static function restrict_post_update_by_role_cpt_action( $post, $role, $post_type, $check_post_action = false, $post_action = '' ) {
            if( !isset( $post->post_type ) || $post->post_type !== $post_type ) {
                return;
            }

            if ( isset(self::$current_user->roles[0]) && self::$current_user->roles[0] === $role &&
                ( $check_post_action === false || ( $check_post_action === true && !isset($_POST[$post_action]) ) )
            ) {
                wp_die('Sorry, you are not allowed to update this post...', '403');
            }
        }

        public static function init_after_woo_loaded_hooks()
        {
            if( !isset( self::$current_user ) ) {
                self::$current_user = wp_get_current_user();
            }

            self::$role = self::$current_user->roles[0];

            $roles_in_scope = array(
                self::$customer_service_role_name,
                self::$order_viewer_role_name,
                self::$pricing_role_name,
                self::$internal_sales_rep_role_name,
                self::$shop_manager_role_name,
                self::$dual_shop_manager_role_name,
                self::$editor_role_name,
                self::$branch_admin_role_name,
                self::$branch_employee_viewer_role_name,
                self::$branch_employee_role_name
            );
            if ( ! self::is_user_role( self::$customer_role_name ) ) {
                add_filter('display_cart_in_header', '__return_false');
                add_action('template_redirect', array(__CLASS__, 'remove_cart_and_checkout_access'));
            } else {
                $admin_id = isset( $_COOKIE['sac_admin_id'] ) ? $_COOKIE['sac_admin_id'] : 0;
                $admin_user = get_user_by( 'id', $admin_id );
                if (
                    self::$current_user->ID != $admin_id && $admin_id != 0
                    && isset( $admin_user->roles[0] ) && $admin_user->roles[0] === 'dual_shop_manager'
                    && ! self::$dual_managers_hooks_added
                ) {
                    self::add_hooks_for_dual_managers(DualManagerMode::SWITCHED_AS_USER);
                }
            }

            if (self::is_user_role(self::$order_viewer_role_name)) {
                self::$order_viewer_user_id = self::$current_user->ID;
                add_action('woocommerce_add_cart_item_data', array(__CLASS__, 'empty_cart'), 30);
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
                add_action('woocommerce_account_orders_endpoint', array(__CLASS__, 'show_rep_orders'), 5, 1);
                add_filter('user_has_cap', array(__CLASS__, 'add_cap_to_order_view'), 10, 3);
            } elseif ( self::is_user_role(self::$internal_sales_rep_role_name) ) {
				add_action('pre_get_posts', array(__CLASS__, 'restrict_cpt_listings_for_roles'));
				add_action('pre_get_users', array(__CLASS__, 'restrict_users_listings_for_roles'));
                add_filter('woocommerce_current_user_can_edit_customer_meta_fields', '__return_true');
            } elseif ( self::is_user_role(self::$branch_admin_role_name) ) {
                add_action( 'pre_get_posts', array( __CLASS__, 'restrict_cpt_listings_for_roles' ) );
                add_action( 'pre_get_users', array(__CLASS__, 'restrict_users_listings_for_roles') );
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
                add_filter('woocommerce_current_user_can_edit_customer_meta_fields', '__return_true');
                add_filter('user_has_cap', array( __CLASS__, 'restrict_edit_delete_capabilities_for_branch_admin'), 10, 4 );
                add_filter( 'display_hawksearch_action_buttons', '__return_false' );
            } else if ( self::is_user_role(self::$branch_employee_viewer_role_name) ) {
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
                add_filter( 'enable_convert_to_order_in_users_profile', '__return_false' );
                add_action( 'woocommerce_account_orders_endpoint', array(__CLASS__, 'show_branch_user_orders'), 5, 1 );
                add_filter( 'woocommerce_my_account_my_orders_actions', array( __CLASS__, 'remove_my_account_orders_actions' ), 10, 1 );
                add_action( 'woocommerce_account_request-quote_endpoint', array( __CLASS__, 'show_branch_user_quotes' ) );
                add_filter( 'user_has_cap', array(__CLASS__, 'add_cap_to_branch_users'), 10, 3 );
                add_action('init', array(__CLASS__, 'remove_quotes_listing_hook_on_my_account'), 99 );
                add_filter( 'frontend_quote_fields_editable', '__return_false' );
                remove_action( 'woocommerce_order_details_after_order_table', 'woocommerce_order_again_button' );
                add_filter( 'display_hawksearch_action_buttons', '__return_false' );
            } else if ( self::is_user_role(self::$branch_employee_role_name ) ) {
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
                add_filter( 'enable_convert_to_order_in_users_profile', '__return_false' );
                add_action( 'woocommerce_account_orders_endpoint', array(__CLASS__, 'show_branch_user_orders'), 5, 1 );
                add_filter( 'woocommerce_my_account_my_orders_actions', array( __CLASS__, 'remove_my_account_orders_actions' ), 10, 1 );
                add_action( 'woocommerce_account_request-quote_endpoint', array( __CLASS__, 'show_branch_user_quotes' ) );
                add_filter( 'user_has_cap', array(__CLASS__, 'add_cap_to_branch_users'), 10, 3 );
                add_action('init', array(__CLASS__, 'remove_quotes_listing_hook_on_my_account'), 99 );
                add_filter( 'show_admin_bar', '__return_true' , 1000 );
                add_filter( 'display_hawksearch_action_buttons', '__return_false' );
            } else if ( self::is_user_role(self::$dual_shop_manager_role_name ) && ! self::$dual_managers_hooks_added ) {
                    self::add_hooks_for_dual_managers(DualManagerMode::ADMIN);
            }

            if (in_array(self::$role, $roles_in_scope)) {
                self::add_extra_restriction_for_role();
            }
        }

        public static function remove_my_account_orders_actions($actions)
        {
            if ( isset( $actions['pay'] ) ) {
                unset($actions['pay']);
            }

            if ( isset( $actions['cancel'] ) ) {
                unset($actions['cancel']);
            }

            return $actions;
        }

        public static function remove_quotes_listing_hook_on_my_account() {
            global $wp_filter;
            foreach( $wp_filter['woocommerce_account_request-quote_endpoint'][10] as $id => $filter ) {
                if (
                    is_array( $filter['function']) && count( $filter['function'] ) == 2 &&
                    is_object( $filter['function'][0] ) && get_class( $filter['function'][0] ) == 'AF_R_F_Q_Front' &&
                    $filter['function'][1] === 'addify_endpoint_content'
                ) {
                    remove_action('woocommerce_account_request-quote_endpoint', $id);
                }
            }
        }

        static function add_cap_to_order_view($allcaps, $caps, $args)
        {
            if (isset($caps[0])) {
                switch ($caps[0]) {
                    case 'view_order' :
                        $user_id_to_check = $args[1];
                        $order = wc_get_order($args[2]);
                        $users_with_rep_id = self::get_user_rep(self::$order_viewer_user_id);

                        $query = new WC_Order_Query(array(
                            'limit' => -1,
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'customer_id' => $users_with_rep_id,
                            'meta_compare' => '=',
                            'return' => 'ids'
                        ));
                        $order_ids = $query->get_orders();

                        if ($user_id_to_check === self::$order_viewer_user_id && in_array($order->ID, $order_ids)
                        ) {
                            $allcaps['view_order'] = true;
                        }
                        break;
                }
            }
            return $allcaps;
        }

        static function add_cap_to_branch_users($allcaps, $caps, $args)
        {
            if (isset($caps[0])) {
                switch ($caps[0]) {
                    case 'view_order' :
                        $user_id_to_check = $args[1];
                        $order = wc_get_order($args[2]);
                        $branch_users_ids = self::get_users_ids_for_branch_roles(self::$current_user->ID);

                        $query = new WC_Order_Query(array(
                            'limit' => -1,
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'customer_id' => $branch_users_ids,
                            'meta_compare' => '=',
                            'return' => 'ids'
                        ));
                        $order_ids = $query->get_orders();

                        if ($user_id_to_check === self::$current_user->ID && in_array($order->ID, $order_ids)
                        ) {
                            $allcaps['view_order'] = true;
                        }
                        break;
                }
            }
            return $allcaps;
        }

        public static function add_cap_to_dual_shop_manager_users($allcaps, $caps, $args)
        {
            if (isset($caps[0])) {
                switch ($caps[0]) {
                    case 'view_order' :
                        $user_id_to_check = $args[1];
                        $order = wc_get_order($args[2]);
                        $dual_shop_manager_users_ids = self::get_users_ids_for_dual_shop_manager_role();
                        $current_user_email_domain = self::get_user_email_domain();
                        $query = new WC_Order_Query(array(
                            'limit' => -1,
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'customer_id' => $dual_shop_manager_users_ids,
                            '_created_by_dual_shop_manager' => '1',
                            '_sales_rep_domain' => $current_user_email_domain,
                            'return' => 'ids'
                        ));
                        $order_ids = $query->get_orders();

                        if ($user_id_to_check === self::$current_user->ID && in_array($order->ID, $order_ids)
                        ) {
                            $allcaps['view_order'] = true;
                        } else {
                            $allcaps['view_order'] = false;
                        }
                        break;
                }
            }
            return $allcaps;
        }

        static function show_rep_orders($current_page)
        {
            $current_page = empty($current_page) ? 1 : absint($current_page);
            remove_action('woocommerce_account_orders_endpoint', 'woocommerce_account_orders');
            $customer_rep_orders = self::get_customer_rep_orders(self::$order_viewer_user_id, $current_page);
            wc_get_template(
                'myaccount/orders.php',
                array(
                    'current_page' => absint($current_page),
                    'customer_orders' => $customer_rep_orders,
                    'has_orders' => 0 < $customer_rep_orders->total,
                    'wp_button_class' => wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '',
                )
            );
        }

        public static function show_branch_user_orders( $current_page ) {
            $current_page = empty($current_page) ? 1 : absint($current_page);
            remove_action('woocommerce_account_orders_endpoint', 'woocommerce_account_orders');
            $branch_user_orders = self::get_branch_user_orders(self::$current_user->ID, $current_page);
            wc_get_template(
                'myaccount/orders.php',
                array(
                    'current_page' => absint($current_page),
                    'customer_orders' => $branch_user_orders,
                    'has_orders' => 0 < $branch_user_orders->total,
                    'wp_button_class' => wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '',
                )
            );
        }

        public static function get_quotes_statuses() {
            return array(
                'af_pending'    => __( 'Pending', 'addify_rfq' ),
                'af_in_process' => __( 'In Process', 'addify_rfq' ),
                'af_accepted'   => __( 'Accepted', 'addify_rfq' ),
                'af_converted'  => __( 'Converted to Order', 'addify_rfq' ),
                'af_declined'   => __( 'Declined', 'addify_rfq' ),
                'af_cancelled'  => __( 'Cancelled', 'addify_rfq' ),
            );
        }

        public static function show_branch_user_quotes() {
            //Single Quote
            $statuses = self::get_quotes_statuses();

            $afrfq_id = get_query_var( 'request-quote' );

            $quote = get_post( $afrfq_id );
            $branch_users_ids = self::get_users_ids_for_branch_roles( self::$current_user->ID );
            if ( ! empty( $afrfq_id ) && is_a( $quote, 'WP_Post' ) ) {
                $branch_user_quotes = get_posts(
                    array(
                        'numberposts' => -1,
                        'meta_key'    => '_customer_user',
                        'meta_value'  => $branch_users_ids,
                        'meta_compare' => 'IN',
                        'post_type'   => 'addify_quote',
                        'post_status' => 'publish',
                        'fields' => 'ids'
                    )
                );

                if( !in_array( $afrfq_id, $branch_user_quotes ) ) {
                    wp_redirect( get_permalink(get_option('woocommerce_myaccount_page_id')) );
                    exit();
                }

                $quotedataid = get_post_meta( $afrfq_id, 'quote_proid', true );

                if ( ! empty( $quotedataid ) ) {

                    wc_get_template(
                        'my-account/quote-details-my-account-old-quotes.php',
                        array(
                            'afrfq_id' => $afrfq_id,
                            'quote'    => $quote
                        ),
                        '/woocommerce/addify/rfq/',
                        AFRFQ_PLUGIN_DIR . 'templates/'
                    );

                } else {

                    wc_get_template(
                        'my-account/quote-details-my-account.php',
                        array(
                            'afrfq_id' => $afrfq_id,
                            'quote'    => $quote
                        ),
                        '/woocommerce/addify/rfq/',
                        AFRFQ_PLUGIN_DIR . 'templates/'
                    );
                    echo Crown_Shop_Rfq::afrfq_admin_add_import_modal_render($afrfq_id);
                }
            } else {
                $branch_user_quotes = get_posts(
                    array(
                        'numberposts' => -1,
                        'meta_key'    => '_customer_user',
                        'meta_value'  => $branch_users_ids,
                        'meta_compare' => 'IN',
                        'post_type'   => 'addify_quote',
                        'post_status' => 'publish',
                    )
                );

                wc_get_template(
                    'my-account/quote-list-table.php',
                    array(
                        'customer_quotes' => $branch_user_quotes,
                        'statuses' => $statuses
                    ),
                    '/woocommerce/addify/rfq/',
                    AFRFQ_PLUGIN_DIR . 'templates/'
                );
            }
        }

        public static function show_dual_shop_manager_quotes_listing() {
            $statuses = self::get_quotes_statuses();

            $afrfq_id = get_query_var( 'request-quote' );

            $quote = get_post( $afrfq_id );
            $dual_shop_manager_users_ids = self::get_users_ids_for_dual_shop_manager_role();
            $dual_shop_manager_users_ids[] = self::$current_user->ID;
            $current_user_email_domain = self::get_user_email_domain();
            if ( ! empty( $afrfq_id ) && is_a( $quote, 'WP_Post' ) ) {
                $user_quote_ids = self::get_dual_shop_managers_allowed_quotes($dual_shop_manager_users_ids, 'ids', $current_user_email_domain, true);
                if( !in_array( $afrfq_id, $user_quote_ids ) ) {
                    wp_redirect( get_permalink(get_option('woocommerce_myaccount_page_id')) );
                    exit();
                }

                $quotedataid = get_post_meta( $afrfq_id, 'quote_proid', true );

                if ( ! empty( $quotedataid ) ) {
                    wc_get_template(
                        'my-account/quote-details-my-account-old-quotes.php',
                        array(
                            'afrfq_id' => $afrfq_id,
                            'quote'    => $quote
                        ),
                        '/woocommerce/addify/rfq/',
                        AFRFQ_PLUGIN_DIR . 'templates/'
                    );

                } else {
                    wc_get_template(
                        'my-account/quote-details-my-account.php',
                        array(
                            'afrfq_id' => $afrfq_id,
                            'quote'    => $quote
                        ),
                        '/woocommerce/addify/rfq/',
                        AFRFQ_PLUGIN_DIR . 'templates/'
                    );
                    echo Crown_Shop_Rfq::afrfq_admin_add_import_modal_render( $afrfq_id );
                }
            } else {
                $user_quotes = self::get_dual_shop_managers_allowed_quotes($dual_shop_manager_users_ids, 'posts', $current_user_email_domain, true);

                wc_get_template(
                    'my-account/quote-list-table.php',
                    array(
                        'customer_quotes' => $user_quotes,
                        'statuses' => $statuses
                    ),
                    '/woocommerce/addify/rfq/',
                    AFRFQ_PLUGIN_DIR . 'templates/'
                );
            }
        }

        static function remove_dashboard_items($dashboard_items)
        {
            foreach ($dashboard_items as $dashboard_item) {
                remove_meta_box($dashboard_item, 'dashboard', 'normal');
            }
        }

        public static function init_restrict_admin_screens_for_role()
        {
            if ( self::$role !== self::$customer_service_role_name
                && self::$role !== self::$internal_sales_rep_role_name
                && self::$role !== self::$shop_manager_role_name
                && self::$role !== self::$dual_shop_manager_role_name
                && self::$role !== self::$editor_role_name
                && self::$role !== self::$branch_admin_role_name
            ) {
                return;
            }

            $current_screen_id = get_current_screen()->id;
            $view_only_screens= array();

            if ( self::$role === self::$shop_manager_role_name ) {
                $restricted_screens = array(
                    'wcmmq-min-max-control', 'team_member-order', 'theme-general-settings', 'acf-options-menu-settings'
                );
            } else if (self::$role === self::$dual_shop_manager_role_name) {
                if ( $current_screen_id === 'edit-shop_order' && defined('DUALSHOP_BE_ORDERS_RESTRICTED') && DUALSHOP_BE_ORDERS_RESTRICTED) {
                    wp_safe_redirect( admin_url() );
                    exit;
                }
                if ( self::is_restricted_post_access_for_dual_shop_manager( $current_screen_id ) ) {
                    wp_die('Sorry, you are not allowed to access this page...', '403');
                }
                $restricted_screens = array(
                    'wcmmq-min-max-control', 'team_member-order', 'theme-general-settings', 'acf-options-menu-settings',
                    'addify_rfq', 'edit-addify_rfq', 'addify_rfq_fields', 'edit-addify_rfq_fields', 'woocommerce_page_af-rfq-settings',
                );
                $view_only_screens = array('addify_quote');

            } else if (self::$role === self::$editor_role_name) {
                $restricted_screens = array(
                    'addify_quote', 'edit-addify_quote'
                );
            } else {
                if ( $current_screen_id === 'dashboard' ) {
                    wp_redirect(admin_url('edit.php?post_type=shop_order'));
                    exit();
                }

                $restricted_screens = array(
                    'index', 'post', 'upload', 'link-manager', 'edit-comments', 'options-general', 'themes',
                    'edit-page', 'edit-post', 'admin.php?page=acf-options-menu-settings',
                    'addify_rfq', 'edit-addify_rfq', 'addify_rfq_fields', 'edit-addify_rfq_fields', 'woocommerce_page_af-rfq-settings',
                    'edit.php?post_type=page', 'edit.php?post_type=post'
                );
            }

            // shop_order - edit one order edit-shop_order - list all orders
            foreach( $restricted_screens as $screen ) {
                if( strpos($current_screen_id, $screen) !== false ) {
                    wp_die('Sorry, you are not allowed to access this page', '403');
                }
            }
            foreach( $view_only_screens as $screen ) {
                if( strpos($current_screen_id, $screen) !== false ) {
                    add_action('admin_head', array(__CLASS__, 'restrict_edit_post_elements_in_admin_panel_via_styles'));
                    if ($screen === 'addify_quote' ) {
                    add_action('admin_head', array(__CLASS__, 'restrict_edit_quote_extra_elements_in_admin_panel_via_styles'));
                    }
                }
            }
        }

        public static function is_restricted_post_access_for_dual_shop_manager($current_screen_id) {
            if ((defined('DUALSHOP_BE_ORDERS_RESTRICTED') && DUALSHOP_BE_ORDERS_RESTRICTED && $current_screen_id === 'edit-shop_order')
                || (defined('DUALSHOP_BE_QUOTES_RESTRICTED') && DUALSHOP_BE_QUOTES_RESTRICTED && $current_screen_id === 'edit-addify_rfq')) {
                return true;
            }

            $restricted_post_types = array( 'shop_order' );
            if ( ! in_array( $current_screen_id, $restricted_post_types, true ) || ! isset( $_GET['post'] ) ) {
                return false;
            }

            $post_id = absint( $_GET['post'] );
            $post = $current_screen_id === 'shop_order' ? wc_get_order( $post_id ) : get_post( $post_id );
            if ( ! $post ) {
                return false;
            }

            $dual_shop_manager_users_ids = self::get_users_ids_for_dual_shop_manager_role();
            $dual_shop_manager_users_ids[] = self::$current_user->ID;
            $current_user_email = self::$current_user->user_email;
            $current_user_email_domain = '';
            if ( preg_match( '/(@[^,;\s]+)/', $current_user_email, $matches ) ) {
                $current_user_email_domain = $matches[1];
            }
            if ( $post instanceof WC_Order ) {
                $post_author = $post->get_user_id();
            } else {
                $post_author = intval( $post->post_author );
            }
            $created_by_dual_shop_manager = get_post_meta( $post_id, '_created_by_dual_shop_manager', true );
            $post_sales_rep_domain = get_post_meta( $post_id, '_sales_rep_domain', true );

            if ( ! in_array( $post_author, $dual_shop_manager_users_ids )
                || ! $created_by_dual_shop_manager
                || $post_sales_rep_domain != $current_user_email_domain ) {
                return true;
            }
            return false;
        }

        public static function init_admin_menus_for_role()
        {
            $role = self::$role;
            $role_to_handle = get_role($role);
            $caps_to_add_cs = array(
                'edit_posts', 'edit_post', 'edit_others_posts', 'edit_published_posts', 'publish_posts', 'read', 'read_others_posts', 'edit_pages', 'edit_page',
                'manage_woocommerce_orders', 'edit_others_shop_orders', 'edit_shop_order', 'edit_shop_orders',
                'edit_shop_order_terms', 'manage_shop_order_terms', 'read_private_shop_orders', 'assign_shop_order_terms',
                'delete_others_shop_orders', 'delete_private_shop_orders', 'edit_private_shop_orders',
                'edit_users'
            );
            $caps_to_remove_cs = array(
                'unfiltered_html', 'addify_quote', 'create_posts', 'manage_comments', 'manage_categories', 'level_8', 'level_9'
            );

            $caps_to_add_ov = array(
                'level_0', 'read', 'read_others_posts', 'read_private_shop_orders', 'read_order', 'read_private_shop_orders', 'read_others_posts'
            );

            $caps_to_add_pricing = array ( 'edit_others_shop_orders' ); // array( 'manage_woocommerce' );
            $caps_to_remove_pricing = array ( '' );
            $caps_to_remove_ov = array('cart', 'checkout');
            if ($role === self::$customer_service_role_name) {
                self::add_and_remove_caps_to_role($caps_to_add_cs, $role_to_handle, $caps_to_remove_cs);
                self::allow_only_woocommerce_menu(true, true);
                $dashboard_items_to_remove = array('dashboard_activity', 'dashboard_right_now', 'dashboard_quick_press', 'dashboard_primary');
                self::remove_dashboard_items($dashboard_items_to_remove);
            } else if ($role === self::$order_viewer_role_name) {
                self::add_and_remove_caps_to_role($caps_to_add_ov, $role_to_handle, $caps_to_remove_ov);
            }  else if ( $role === self::$pricing_role_name ) {
                self::add_and_remove_caps_to_role($caps_to_add_pricing, $role_to_handle, $caps_to_remove_pricing );
                self::grant_access_rfq_submenu();
            } else if ( $role == self::$internal_sales_rep_role_name ) {
                $caps_to_add_internal_sales_rep = array(
                    'edit_posts', 'edit_post', 'edit_others_posts', 'edit_published_posts',
                    'publish_posts', 'read', 'read_others_posts', 'level_0', 'read_private_shop_orders',
                    'read_order', 'list_users', 'edit_users', 'manage_woocommerce_orders',
                    'edit_others_shop_orders', 'edit_shop_order', 'edit_shop_orders',
                );
                self::add_and_remove_caps_to_role( $caps_to_add_internal_sales_rep, $role_to_handle, array() );

                $menus = array( 'woocommerce', 'users.php' );
                $submenus = array( 'woocommerce' =>
                    array( 'edit.php?post_type=addify_quote', 'edit.php?post_type=shop_order' )
                );

                self::allow_only_selected_menus_and_submenus( $menus, $submenus );
            } else if ( $role === self::$branch_admin_role_name ) {
                $caps_to_add_branch_admin = array(
                    'edit_posts', 'edit_post', 'edit_others_posts', 'edit_published_posts',
                    'publish_posts', 'read', 'read_others_posts', 'level_0', 'read_private_shop_orders',
                    'read_order', 'manage_woocommerce_orders',
                    'edit_others_shop_orders', 'edit_shop_order', 'edit_shop_orders',
                    'list_users', 'create_users', 'add_users', 'edit_users', 'promote_users', 'edit_user'
                );
                $caps_to_remove_branch_admin = array (
                    'delete_posts', 'manage_options',
                );
                self::add_and_remove_caps_to_role( $caps_to_add_branch_admin, $role_to_handle, $caps_to_remove_branch_admin );

                $menus = array( 'woocommerce', 'users.php' );
                $submenus = array( 'woocommerce' =>
                    array( 'edit.php?post_type=addify_quote', 'edit.php?post_type=shop_order' )
                );
                self::allow_only_selected_menus_and_submenus( $menus, $submenus );
            } else if ( $role === self::$branch_employee_viewer_role_name ) {
                $caps_to_add_branch_employee_viewer = array(
                    'level_0', 'read', 'read_others_posts', 'read_private_shop_orders', 'read_order', 'read_private_shop_orders', 'read_others_posts'
                );
                self::add_and_remove_caps_to_role( $caps_to_add_branch_employee_viewer, $role_to_handle, array( 'cart', 'checkout' ) );
            } else if ( $role === self::$branch_employee_role_name ) {
                $caps_to_add_branch_employee = array(
                    'level_0', 'read', 'read_others_posts', 'read_private_shop_orders', 'read_order', 'read_private_shop_orders', 'read_others_posts'
                );
                self::add_and_remove_caps_to_role( $caps_to_add_branch_employee, $role_to_handle, array( 'cart', 'checkout' ) );
            } else if ( $role === self::$dual_shop_manager_role_name ) {
                //TODO add/remove capabilities if needed
                $caps_to_add_dual_shop_manager = array(
                    'read', 'read_others_posts', 'level_0', 'read_private_shop_orders', 'read_private_posts',
                    'read_order', 'read_shop_order', 'manage_woocommerce_orders',
                    'edit_others_shop_orders', 'edit_shop_order', 'edit_shop_orders',
                    'edit_posts', 'edit_post', 'edit_others_posts', 'edit_published_posts', 'publish_posts'
                );
                $caps_to_remove_dual_shop_manager = array (
                    'delete_posts', 'manage_options',
                );
                self::add_and_remove_caps_to_role( $caps_to_add_dual_shop_manager, $role_to_handle, $caps_to_remove_dual_shop_manager );

                $menus = array( 'woocommerce' );
                $submenus_arfq_orders_allowed = array( 'woocommerce' => array( 'edit.php?post_type=addify_quote', 'edit.php?post_type=shop_order' ) );
                $submenus_arfq_allowed = array( 'woocommerce' => array( 'edit.php?post_type=addify_quote' ) );
                $submenus_orders_allowed = array( 'woocommerce' => array( 'edit.php?post_type=shop_order' ) );
                $submenus = $submenus_arfq_orders_allowed;
                if (defined('DUALSHOP_BE_ORDERS_RESTRICTED') && DUALSHOP_BE_ORDERS_RESTRICTED && defined('DUALSHOP_BE_QUOTES_RESTRICTED') && DUALSHOP_BE_QUOTES_RESTRICTED) {
                    $submenus = array( 'woocommerce' => array());
                } else if (defined('DUALSHOP_BE_ORDERS_RESTRICTED') && DUALSHOP_BE_ORDERS_RESTRICTED) {
                    $submenus = $submenus_arfq_allowed;
                } else if (defined('DUALSHOP_BE_QUOTES_RESTRICTED') && DUALSHOP_BE_QUOTES_RESTRICTED) {
                    $submenus = $submenus_orders_allowed;
                }
                self::allow_only_selected_menus_and_submenus( $menus, $submenus );
            }

        }

        static function init_tab_menu_pages($wp_admin_bar)
        {
            if ( !in_array( self::$role, array( self::$editor_role_name, self::$branch_employee_role_name ) ) ) {
                return;
            }

            if ( self::$role == self::$editor_role_name ) {
                $tab_menu_to_remove = ['switch-to1', 'edit-profile'];
                foreach ($tab_menu_to_remove as $tab_id) {
                    $wp_admin_bar->remove_node($tab_id);
                }
            } else if ( self::$role == self::$branch_employee_role_name ) {
                $tab_menu_to_remove = ['switch-to1', 'edit-profile', 'user-info'];
                foreach ($tab_menu_to_remove as $tab_id) {
                    $wp_admin_bar->remove_node($tab_id);
                }
            }
        }

        static function enable_admin_panel($is_enable)
        {
            return $is_enable;
        }

        protected static function is_user_role($user_role)
        {
            if (is_user_logged_in()) {
                return (isset(self::$current_user->roles[0]) && (self::$current_user->roles[0] == $user_role));
            } else return false;
        }

        public static function add_customer_service_role()
        {

            add_role(self::$customer_service_role_name, 'Customer Service', array(
                'read' => true,
                'edit' => true,
                'create_posts' => true,
                'edit_posts' => true,
                'edit_others_posts' => true,
                'publish_posts' => true,
                'edit_published_posts' => true,
                'edit_pages' => true,
                'level_7' => true,
                'level_6' => true,
                'level_5' => true,
                'level_4' => true,
                'level_3' => true,
                'level_2' => true,
                'level_1' => true,
                'level_0' => true,
                'manage_woocommerce_orders' => true,
                'edit_shop_order' => true,
                'edit_shop_order_terms' => true,
                'manage_shop_order_terms' => true,
                'edit_shop_orders' => true,
                'publish_shop_orders' => true,
                'read_private_shop_orders' => true,
                'read_shop_order' => true,
                'assign_shop_order_terms' => true,
                'delete_others_shop_orders' => true,
                'delete_private_shop_orders' => true,
                'delete_published_shop_orders' => true,
                'delete_shop_order' => true,
                'delete_shop_order_terms' => true,
                'delete_shop_orders' => true,
                'edit_others_shop_orders' => true,
                'edit_private_shop_orders' => true,
                'edit_published_shop_orders' => true,
            ));
        }

        public static function add_orders_viewer_role()
        {
            add_role(self::$order_viewer_role_name, 'Order Viewer', array(
                'read' => true,
                'level_0' => true,
                'read_private_shop_orders' => true,
                'read_shop_order' => true,
            ));
        }
        public static function add_pricing_role()
        {
            $editor_role = get_role(self::$editor_role_name);
            if ( ! is_null($editor_role) ) {
                $editor_capabilities = $editor_role->capabilities;
                add_role(self::$pricing_role_name, 'Pricing', $editor_capabilities);
            }
        }

        public static function add_internal_sales_rep_role()
        {
            add_role(self::$internal_sales_rep_role_name, 'Internal Sales Rep');

            //hide "Add to cart" button when Internal Sales Rep is logged in as another user
            add_action('wp_head', function() {
                $current_user_id = self::$current_user->ID;
                $admin_id = isset( $_COOKIE['sac_admin_id'] ) ? $_COOKIE['sac_admin_id'] : 0;
                $admin_user = get_user_by( 'id', $admin_id );

                if (
                    $current_user_id != $admin_id && $admin_id != 0 && isset( $admin_user->roles[0] ) && $admin_user->roles[0] === self::$internal_sales_rep_role_name
                    && Nsi_Helper::is_admin_session_set()
                ) {
                    self::remove_cart_and_checkout_access();
                    add_filter( 'display_cart_in_header', '__return_false' );
                    self::hide_element_for_role( self::$current_user->roles[0], array( 'body.product-template-default.single-product .single_add_to_cart_button' ) );
                }
            });
        }

        public static function add_branch_admin_role() {
            add_role(self::$branch_admin_role_name, 'Branch Admin',  array(
                'level_0', 'read', 'list_users', 'create_users', 'add_users', 'edit_users', 'promote_users', 'edit_user',
                'read_others_posts', 'read_private_shop_orders', 'read_order', 'manage_woocommerce_orders',
                'edit_posts', 'edit_post', 'edit_others_posts', 'edit_published_posts', 'publish_posts',
                'edit_others_shop_orders', 'edit_shop_order', 'edit_shop_orders',
            ));
        }

        public static function add_branch_employee_viewer_role()
        {
            add_role( self::$branch_employee_viewer_role_name, 'Branch Employee Viewer', array(
                'level_0', 'read', 'read_others_posts', 'read_private_shop_orders', 'read_shop_order',
            ) );
        }

        public static function add_branch_employee_role()
        {
            add_role( self::$branch_employee_role_name, 'Branch Employee', array(
                'level_0', 'read', 'read_others_posts', 'read_private_shop_orders', 'read_shop_order',
            ) );
        }

        public static function add_dual_shop_manager_role() {
            add_role(
                self::$dual_shop_manager_role_name,
                'Dual Shop Manager',
                array(
                    'level_0' => true,
                    'read' => true,
                    'read_others_posts' => true,
                    'read_private_shop_orders' => true,
                    'read_private_posts' => true,
                    'read_shop_order' => true,
                    'read_order' => true,
                    'manage_woocommerce_orders' => true,
                    'edit_posts' => true,
                    'edit_post' => true,
                    'edit_others_posts' => true,
                    'edit_published_posts' => true,
                    'publish_posts' => true,
                    'edit_others_shop_orders' => true,
                    'edit_shop_order' => true,
                    'edit_shop_orders' => true,
                )
            );
        }

        public static function add_extra_restriction_for_role()
        {
            add_action('admin_menu', array(__CLASS__, 'init_admin_menus_for_role'), 100);
            add_action('current_screen', array(__CLASS__, 'init_restrict_admin_screens_for_role'));
            add_action('admin_bar_menu', array(__CLASS__, 'init_tab_menu_pages'), 1000);
        }

        public static function allow_only_woocommerce_menu($orders_only, $allow_quotes = false)
        {
            global $menu, $submenu;
            foreach ($menu as $menu_section) {
                if ($menu_section[2] !== 'woocommerce') {
                    remove_menu_page($menu_section[2]);
                }
            }

            if ( $orders_only && $allow_quotes ) {
                    foreach ( $submenu['woocommerce'] as $submenu_section ) {
                        if ( $submenu_section[1] !== 'edit_shop_orders' && strpos( $submenu_section[2], 'addify' ) === false ) {
                            remove_submenu_page('woocommerce', $submenu_section[2]);
                        }
                    }
            } else if(  $orders_only ) {
                foreach ( $submenu['woocommerce'] as $submenu_section ) {
                    if ( $submenu_section[1] !== 'edit_shop_orders' ) {
                        remove_submenu_page('woocommerce', $submenu_section[2]);
                    }
                }
            } else if ( $allow_quotes ) {
                foreach ( $submenu['woocommerce'] as $submenu_section ) {
                    if ( strpos( $submenu_section[2], 'addify' ) === false ) {
                        remove_submenu_page('woocommerce', $submenu_section[2]);
                    }
                }
            }
        }

        public static function allow_only_selected_menus_and_submenus( $menus, $submenus ) {
            global $menu, $submenu;
            foreach ( $menu as $menu_section ) {
                if ( !in_array($menu_section[2], $menus) ) {
                    remove_menu_page($menu_section[2]);
                }
            }

            foreach( $submenus as $menu_key => $submenu_items ) {
                foreach( $submenu[$menu_key] as $submenu_section ) {
                    if ( !in_array($submenu_section[2], $submenu_items) ) {
                        remove_submenu_page( 'woocommerce', $submenu_section[2] );
                    }
                }
            }
        }

        /**
         * @param array $caps_to_add
         * @param WP_Role|null $role_to_handle
         * @param array $caps_to_remove
         * @return void
         */
        public static function add_and_remove_caps_to_role(array $caps_to_add, ?WP_Role $role_to_handle, array $caps_to_remove): void
        {
            foreach ($caps_to_add as $cap) {
                $role_to_handle->add_cap($cap);
            }
            foreach ($caps_to_remove as $cap) {
                $role_to_handle->remove_cap($cap);
            }
        }

        public static function empty_cart()
        {
            return function () {
                wc_empty_cart();
            };
        }

        public static function allow_view_rep_orders($actions, $order)
        {

            $actions['view'] = [
                'url' => wc_get_endpoint_url('view-my-rep-order', $order->get_id()),
                'name' => __('View', 'txtdomain')
            ];
            return $actions;
        }

        public static function get_customer_rep_orders(int $user_id, $current_page): stdClass|array
        {
            $users_with_rep_id = self::get_user_rep($user_id);
            $customer_orders = wc_get_orders(
                apply_filters(
                    'woocommerce_my_account_my_orders_query',
                    array(
                        'customer' => $users_with_rep_id,
                        'page' => $current_page,
                        'paginate' => true,
                    )
                )
            );
            return $customer_orders;
        }

        public static function get_branch_user_orders(int $user_id, $current_page)
        {
            $branch_users_ids = self::get_users_ids_for_branch_roles($user_id);
            $branch_user_orders = wc_get_orders(
                apply_filters(
                    'woocommerce_my_account_my_orders_query',
                    array(
                        'customer' => $branch_users_ids,
                        'page' => $current_page,
                        'paginate' => true,
                    )
                )
            );
            return $branch_user_orders;
        }

        public static function get_dual_shop_manager_orders($current_page, $plus_authored)
        {
            $dual_shop_manager_users_ids = self::get_users_ids_for_dual_shop_manager_role();
            $dual_shop_manager_orders_ids = self::get_dual_shop_manager_order_ids( $dual_shop_manager_users_ids, $plus_authored );

            if ( empty( $dual_shop_manager_orders_ids ) ) {
                return array();
            }
            $query_args = array(
                'page' => $current_page,
                'paginate' => true,
                'post__in' => $dual_shop_manager_orders_ids,
            );

            $dual_shop_manager_orders = wc_get_orders(
                apply_filters('woocommerce_my_account_my_orders_query', $query_args)
            );

            return $dual_shop_manager_orders;
        }

        public static function get_dual_shop_manager_order_ids($dual_shop_manager_users_ids, $plus_authored) {
            $current_user_email_domain = self::get_user_email_domain();
            if ( empty ( $current_user_email_domain) ) {
                return array();
            }

            if ( defined('DSM_GET_ORDERS_USE_SQL_QUERY_RAW') && DSM_GET_ORDERS_USE_SQL_QUERY_RAW ) {
                $dual_shop_manager_orders_ids = Nsi_Helper::get_orders_for_dsm_sql_query_raw( $dual_shop_manager_users_ids, $current_user_email_domain );
            } else {
                $dualshop_orders_query = new WC_Order_Query(array(
                    'limit' => -1,
                    'customer_id' => $dual_shop_manager_users_ids,
                    '_created_by_dual_shop_manager' => '1',
                    '_sales_rep_domain' => $current_user_email_domain,
                    'return' => 'ids'
                ));
                $dual_shop_manager_orders_ids = $dualshop_orders_query->get_orders();
            }

            $author_id = self::get_author_id_for_switched_from_role(self::$dual_shop_manager_role_name);
            if ( $plus_authored && ! empty( $author_id ) ) {
                $authored_orders_query = new WC_Order_Query(array(
                    'limit' => -1,
                    'customer_id' => $author_id,
                    'return' => 'ids'
                ));
                $authored_order_ids = $authored_orders_query->get_orders();
                if ( ! empty( $authored_order_ids ) ) {
                    $dual_shop_manager_orders_ids = array_merge($dual_shop_manager_orders_ids, $authored_order_ids);
                }
            }

            return $dual_shop_manager_orders_ids;
        }

        public static function get_user_rep(int $user_id): string|array
        {
            $rep = get_user_meta($user_id, 'ns_customer_rep_email_domain', true);
            if ( empty( $rep ) ) {
                return '';
            }
            $domain_list = array_filter( array_map( 'trim', explode( ',', $rep ) ) );
            $meta_query = array( 'relation' => 'OR' );

            foreach ( $domain_list as $domain ) {
                $meta_query[] = array(
                    'key'     => 'ns_customer_rep_email_domain',
                    'value'   => $domain,
                    'compare' => 'LIKE',
                );
            }

            $users_rep_ids = get_users( array(
                'fields'     => 'ids',
                'meta_query' => $meta_query,
            ) );

            return $users_rep_ids;
        }

        public static function grant_access_rfq_submenu(): void
        {
            add_submenu_page(
                'woocommerce',
                'Quote Notifications Settings',
                'Quote Notifications Settings',
                'pricing',
                'rfq-notifications-settings',
                ['Crown_Shop_Rfq', 'rfq_notifications_settings_callback']
            );

            add_submenu_page(
                'woocommerce',
                __('Request a Quote', 'addify_rfq'),
                __('Request a Quote', 'addify_rfq'),
                'pricing',
                'edit.php?post_type=addify_rfq'
            );

            global $_wp_submenu_nopriv;
//              alternate way to avoid direct unset => unset($_wp_submenu_nopriv[ 'woocommerce' ]['rfq-notifications-settings']);
            if (isset($_wp_submenu_nopriv['woocommerce'])) {
                $_wp_submenu_nopriv['woocommerce'] = array_filter($_wp_submenu_nopriv['woocommerce'], function ($submenu_item) {
                    return $submenu_item !== 'rfq-notifications-settings';
                }, ARRAY_FILTER_USE_KEY);
            }

            global $submenu;
            foreach ($submenu['woocommerce'] as $index => $submenu_item) {
                $allowed_submenu_pages = array (
					'rfq-notifications-settings',
					'edit.php?post_type=addify_rfq',
					'quote_data_extraction',
					'acf-options-settings-expired-status',
					);
				$slug = $submenu_item[2];
                if ( !in_array($slug, $allowed_submenu_pages)) {
                    remove_submenu_page('woocommerce', $slug);
                }
            }

        }

		public static function add_manage_rfg_notification_settings_capability_to_existing_roles() {
			$roles = array(
				self::$administrator_role_name,
				self::$editor_role_name,
				self::$pricing_role_name,
            );
			foreach ( $roles as $role_name ) {
				$role = get_role( $role_name );
				$role?->add_cap( 'manage_rfg_notification_settings' );
			}
		}

		public static function add_manage_rfg_notification_settings_capability( $capability ) {
			return 'manage_rfg_notification_settings';
		}

		public static function add_smartslider_capabilities_to_editor() {
			$role = get_role(self::$editor_role_name);
			if (empty($role)) {
				return;
			}

			$role->add_cap('smartslider');
			$role->add_cap('smartslider_config');
			$role->add_cap('smartslider_delete');
			$role->add_cap('smartslider_edit');
			$role->add_cap('unfiltered_html');
		}

        public static function restrict_posts_updates() {
            if ( isset( $_POST['action'] ) && $_POST['action'] === 'editpost' ) {
                $roles_to_restrict_update_quotes = array( self::$branch_admin_role_name, self::$dual_shop_manager_role_name );
                self::restrict_quotes_updates($roles_to_restrict_update_quotes);
            }
        }

        public static function restrict_quotes_updates($roles_to_restrict) {
            if (
                in_array( self::$role, $roles_to_restrict )
                && isset( $_POST['post_type'] ) && $_POST['post_type'] === 'addify_quote' && !isset( $_POST['addify_convert_to_order'] )
            ) {
                wp_die('Sorry, you are not allowed to update this post...', '403');
            }
        }

        public static function restrict_users_listings_for_roles( $query ) {
            self::restrict_users_listing_entries_for_internal_sales_rep( $query );
            self::restrict_users_listing_entries_for_branch_admin( $query );
        }

        public static function restrict_cpt_listings_for_roles( $query ) {
            self::restrict_quotes_and_orders_listing_entries_for_internal_sales_rep( $query );
            self::restrict_quotes_and_orders_listing_entries_for_branch_roles( $query );
        }

        public static function restrict_quotes_and_orders_listing_entries_for_internal_sales_rep($query) {
            global $pagenow;

            if(
                is_admin() && self::$role == self::$internal_sales_rep_role_name && $pagenow === 'edit.php' &&
                ( $_GET['post_type'] == 'addify_quote' || $_GET['post_type'] == 'shop_order' )
            ) {

                $user_states = explode( ',', get_user_meta( get_current_user_id(), 'internal_sales_rep_states', true ) );
                $users = get_users( array(
                    'meta_key' => 'shipping_state',
                    'meta_value' => $user_states,
                    'meta_compare' => 'IN'
                ) );

                $users_to_look_for = [];
                foreach( $users ?? [] as $user ) {
                    $users_to_look_for[] = $user->ID;
                }

                $query->set( 'meta_query', array(
                    array(
                        'key' => '_customer_user',
                        'value' => $users_to_look_for,
                        'compare' => 'IN'
                    )
                ) );
            }
        }

        public static function restrict_quotes_and_orders_listing_entries_for_branch_roles($query) {
            global $pagenow;

            if ( !in_array( self::$role, array( self::$branch_admin_role_name ) ) ) {
                return;
            }

            if (
                is_admin() && $pagenow === 'edit.php' &&
                ( $_GET['post_type'] == 'addify_quote' || $_GET['post_type'] == 'shop_order' )
            ) {
                $users = self::get_users_ids_for_branch_roles( self::$current_user->ID );
                $query->set( 'meta_query', array(
                    array(
                        'key' => '_customer_user',
                        'value' => $users,
                        'compare' => 'IN'
                    )
                ) );
            }
        }

        public static function show_dual_shop_manager_orders_listing($current_page) {
            $current_page = empty($current_page) ? 1 : absint($current_page);
            remove_action('woocommerce_account_orders_endpoint', 'woocommerce_account_orders');
            $dual_shop_manager_orders = self::get_dual_shop_manager_orders($current_page, true);
            wc_get_template(
                'myaccount/orders.php',
                array(
                    'current_page' => absint($current_page),
                    'customer_orders' => $dual_shop_manager_orders,
                    'has_orders' => 0 < $dual_shop_manager_orders->total,
                    'wp_button_class' => wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '',
                )
            );
        }

        public static function restrict_users_listing_entries_for_internal_sales_rep( $query ) {
            if ( self::$role == self::$internal_sales_rep_role_name ) {
                $user_states = explode( ',', get_user_meta( get_current_user_id(), 'internal_sales_rep_states', true ) );
                $query->set( 'meta_query', array(
                    array(
                        'key' => 'shipping_state',
                        'value' => $user_states,
                        'compare' => 'IN'
                    )
                ) );
            }
        }

        public static function restrict_users_listing_entries_for_branch_admin( $query ) {
            global $pagenow;
            $meta = $query->query_vars['meta_query'];
            if (is_admin() && self::is_branch_admin() && $pagenow === 'users.php' && $meta === null ) {
                $assigned_users = self::get_users_ids_for_branch_roles( self::$current_user->ID );
                $branch_employees = self::get_additional_users_ids_for_branch_admin( self::$current_user->ID );
                $assigned_users = array_unique( array_merge( $assigned_users, $branch_employees ) );
                if (is_array($assigned_users) && !empty($assigned_users)) {
                    $query->set('include', $assigned_users);
                }
            }
        }

        public static function remove_cart_and_checkout_access() {
            if( is_cart() || is_checkout() ) {
                wp_redirect( get_home_url() );
                die();
            }
        }

        public static function remove_cart_and_quote_creation_access() {
            $hide_hawksearch_buttons = false;
            if ( defined('DUALSHOP_ORDERS_CREATION_RESTRICTED') && DUALSHOP_ORDERS_CREATION_RESTRICTED) {
                self::remove_cart_and_checkout_access();
                add_filter( 'display_cart_in_header', '__return_false' );
                add_action('template_redirect', array(__CLASS__, 'remove_cart_and_checkout_access'));
                add_filter('woocommerce_add_to_cart_validation',  '__return_false' );
                $hide_hawksearch_buttons = true;
            }
            if ( defined('DUALSHOP_QUOTES_CREATION_RESTRICTED') && DUALSHOP_QUOTES_CREATION_RESTRICTED) {
                add_action('template_redirect', array(__CLASS__, 'remove_quote_creation_access'));
                add_filter( 'frontend_quote_fields_editable', '__return_false' );
                $hide_hawksearch_buttons = true;
            }
            if ( $hide_hawksearch_buttons ) {
                add_filter( 'display_hawksearch_action_buttons', '__return_false' );
            }
        }

        public static function remove_quote_creation_access() {
            if (is_page('request-a-quote')) {
                wp_redirect( get_home_url() );
                die();
            }
        }


        public static function users_role_changes_actions( $user_id, $new_role ) {
            if ( in_array( $new_role, array( self::$branch_employee_role_name, self::$branch_employee_viewer_role_name ) ) ) {
                $role_name = $new_role == self::$branch_employee_role_name ? 'Branch Employee' : 'Branch Employee Viewer';

                $admin_users = get_users( array(
                    'role' => self::$administrator_role_name,
                ) );
                $admins_to_notify = [];
                foreach( $admin_users as $user ) {
                    $admins_to_notify[] = $user->user_email;
                }

                $mail_headers = array(
                    'Content-Type: text/html; charset=UTF-8',
                    'From: ' . get_bloginfo( 'name' ) . ' <' . get_bloginfo( 'admin_email' ) . '>',
                );

                $mail_subject = 'Role ' . $role_name . ' assigned to the user';
                $mail_content = '<h1>Information about role change</h1>';
                $mail_content .= '<p>User ID <b>' . $user_id . '</b> has just been assigned a new role: ' . $new_role . ' - by ' .
                    self::$current_user->user_login . ' (' . self::$current_user->user_email .')<p>';
                wp_mail( $admins_to_notify, $mail_subject, $mail_content, $mail_headers );
            }
        }

        public static function get_users_ids_for_branch_roles( $user_id ) {
            if (!empty(self::$users_to_display_data_for)) {
                return self::$users_to_display_data_for;
            }
            $branch_groups = get_field( 'branch_group', 'user_' . $user_id );
            $assigned_customers = get_user_meta($user_id, 'assigned_customers', true);

            remove_action('pre_get_users', array(__CLASS__, 'restrict_users_listing_entries_for_branch_admin'));
            foreach ( $branch_groups ?? [] as $group ) {
                $branches[$group['customer_branch_name']] = $group['customer_branch_states'];
            }

            $users_to_display_data_for = [];
            foreach( $branches ?? [] as $branch_id => $branch_states ) {
                $branch_term = get_term( $branch_id, 'branch' );
                if ( empty($branch_term) ) {
                    continue;
                }
                $branch_name = $branch_term->name;

                $meta_query = [];
                if( !empty( $branch_states ) ) {
                    $meta_query['relation'] = 'AND';
                    $meta_query[] = array(
                        'key' => 'shipping_state',
                        'value' => $branch_states,
                        'compare' => 'IN'
                    );
                }

                $meta_query[] = array(
                    'key'     => 'nickname',
                    'value'   => '^' . $branch_name,
                    'compare' => 'REGEXP',
                );
                $users = get_users( array(
                    'meta_query' => $meta_query
                ) );

                foreach( $users as $user ) {
                    $users_to_display_data_for[] = $user->ID;
                }
            }

            $users_created_by_admin = get_users ( array(
                'meta_query' => array(
                    array(
                        'key' => 'user_created_by',
                        'value' => $user_id,
                    ),
                )
            ) );

            foreach ( $users_created_by_admin ?? [] as $user_created_by_admin ) {
                if ( !in_array($user_created_by_admin->ID, $users_to_display_data_for ) ){
                    $users_to_display_data_for[] = $user_created_by_admin->ID;
                }
            }

            add_action('pre_get_users', array(__CLASS__, 'restrict_users_listing_entries_for_branch_admin'));

            foreach( $assigned_customers ?? [] as $assigned_customer_id ) {
                $users_to_display_data_for[] = $assigned_customer_id;
            }
            self::$users_to_display_data_for = empty( $users_to_display_data_for ) ? array( $user_id ) : $users_to_display_data_for;

            return self::$users_to_display_data_for;
        }

        public static function get_users_ids_for_dual_shop_manager_role() {
            if (!empty(self::$users_to_display_data_for)) {
                return self::$users_to_display_data_for;
            }
            $current_user_email_domain = self::get_user_email_domain( false );
            $users_to_display_data_for = self::get_sales_rep_customer_ids( $current_user_email_domain );
            $queried_customer_user = isset( $_GET['_customer_user'] ) ? intval( $_GET['_customer_user'] ) : 0;
            if ( ! empty( $queried_customer_user ) && in_array( $queried_customer_user, $users_to_display_data_for ) ) {
                $users_to_display_data_for = array( $queried_customer_user );
            }

            self::$users_to_display_data_for = empty( $users_to_display_data_for ) ? array( self::$current_user->ID ) : $users_to_display_data_for;

            return self::$users_to_display_data_for;
        }

        public static function get_additional_users_ids_for_branch_admin( $user_id ) {
            global $wpdb;
            $max_branch_amount_query = "SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = 'branch_group' ORDER BY meta_value DESC LIMIT 1";
            $max_branch_amount  = $wpdb->get_var( $max_branch_amount_query ) ?? 0;

            if ( $max_branch_amount == 0 ) {
                return [];
            }

            $branches = [];
            $branch_groups = get_field( 'branch_group', 'user_' . $user_id );
            foreach( $branch_groups as $branch_group ) {
                $branches[] = $branch_group['customer_branch_name'];
            }

            $meta_query = [];
            $meta_query['relation'] = 'OR';
            for ( $i = 0; $i < $max_branch_amount; $i++ ) {
                $meta_query[] = array(
                    'key' => 'branch_group_' . $i . '_customer_branch_name',
                    'value' => $branches,
                    'compare' => 'IN'
                );
            }

            remove_action( 'pre_get_users', array( __CLASS__, 'restrict_users_listing_entries_for_branch_admin' ) );
            $users = get_users( array(
                'meta_query' => $meta_query,
                'role__in' => array( self::$branch_employee_role_name, self::$branch_employee_viewer_role_name ),
            ) );

            foreach ( $users as $user ) {
                $branch_users_for_branch_admin[] = $user->ID;
            }
            add_action( 'pre_get_users', array( __CLASS__, 'restrict_users_listing_entries_for_branch_admin' ) );

            return $branch_users_for_branch_admin ?? [];
        }

        public static function restrict_user_roles_for_branch_admin($all_roles) {
            if (self::is_branch_admin()) {
                $allowed_roles = array(
                    self::$branch_employee_role_name,
                    self::$branch_employee_viewer_role_name,
                );
                foreach ($all_roles as $role => $details) {
                    if (!in_array($role, $allowed_roles)) {
                        unset($all_roles[$role]);
                    }
                }
            }
            return $all_roles;
        }

        public static function hide_no_role_option_for_branch_admin() {
            global $pagenow;
            if ( $pagenow !== 'user-edit.php' && $pagenow !== 'user-new.php' ) {
                return;
            }
            if (self::is_branch_admin()) {
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function($){
                        $('#role option[value=""]').remove();
                    });
                </script>
                <?php
            }
        }

        public static function restrict_edit_delete_capabilities_for_branch_admin($allcaps, $cap, $args, $user) {
            $capability = isset($args[0]) ? $args[0] : '';

            if (in_array($capability, array('edit_user') )
                && isset($user->roles)
                && in_array(self::$branch_admin_role_name, $user->roles)) {

                $target_user_id = isset($args[2]) ? $args[2] : null;
                if ($target_user_id) {
                    $assigned_users = self::get_users_ids_for_branch_roles( $user->ID );
                    $branch_employees = self::get_additional_users_ids_for_branch_admin( self::$current_user->ID );
                    $assigned_users = array_unique( array_merge( $assigned_users, $branch_employees ) );

                    if (!is_array($assigned_users)) {
                        $assigned_users = array();
                    }

                    if (!in_array($target_user_id, $assigned_users)) {
                        $allcaps[$cap[0]] = false;
                    }
                }
            }

            return $allcaps;
        }

        public static function is_branch_admin() {
            return isset(self::$current_user->roles[0]) && self::$current_user->roles[0] === self::$branch_admin_role_name;
        }

        public static function restrict_draft_product_preview() {
            if (is_singular('product')) {
                global $post;

                if ($post->post_status === 'draft' && !current_user_can('administrator')) {
                    global $wp_query;
                    $wp_query->posts = array();
                    $wp_query->post_count = 0;
                    $wp_query->set_404();
                    status_header( 404 );
                    nocache_headers();
                }
            }
        }

        public static function is_switched_user() {
            $switched_id = $_COOKIE['sac_admin_id'] ?? 0;
            return $switched_id != 0;
        }

        public static function check_quote_view_permissions () {
            if (preg_match('/\/my-account\/request-quote\/(\d+)\//', $_SERVER['REQUEST_URI'], $matches)) {
                $quote_id = intval($matches[1]);
                $quote = get_post($quote_id);

                if (!$quote || $quote->post_type !== 'addify_quote') {
                    wp_die('Quote not found.', 'Error', array('response' => 404));
                }

                $distributor_name = get_post_meta($quote_id, 'afrfq_field_5822579', true);
                    $users = get_users(array(
                        'meta_key'   => 'nickname',
                        'meta_value' => $distributor_name,
                        'number'     => 1,
                        'fields'     => 'ids',
                    ));
                $distributor_id = !empty($users) ? $users[0] : 0;
                $current_user_email_domain = self::get_user_email_domain();
                $created_by_dual_shop_manager = get_post_meta($quote_id, '_created_by_dual_shop_manager', true);
                $quote_sales_rep_domain = get_post_meta( $quote_id, '_sales_rep_domain', true );
                if ( !current_user_can('administrator') &&
                    intval($quote->post_author) !== get_current_user_id() &&
                    intval($distributor_id) !== get_current_user_id() &&
                    ( current_user_can('dual_shop_manager') &&
                        ( ! in_array( intval($quote->post_author), self::get_users_ids_for_dual_shop_manager_role() )
                            || ! $created_by_dual_shop_manager
                            || $quote_sales_rep_domain != $current_user_email_domain) )
                ) {
                    wp_die('You are not allowed to view this quote.', 'Access Denied', array('response' => 403));
                }
            }
        }

        public static function get_sales_rep_customer_ids( $user_email_domain ) {
            $customer_ids = !empty($user_email_domain) ? get_users(array(
                'fields' => 'ID',
                'meta_query' => array(
                    array(
                        'key' => 'ns_customer_rep_email_domain',
                        'value' => $user_email_domain,
                        'compare' => 'LIKE',
                    )
                )
            )) : array();
            return $customer_ids;
        }

        /**
         * Retrieves allowed quotes or their IDs for dual shop managers.
         *
         * @param array $dual_shop_manager_users_ids Array of user IDs for dual shop managers.
         * @param string $mode The mode to retrieve quotes, either 'ids' or 'objects'.
         * @param bool $plus_authored Ignore (skip) quotes authored by the current user if false.
         * @return array List of allowed quotes or their IDs based on the provided parameters.
         */
        public static function get_dual_shop_managers_allowed_quotes(array $dual_shop_manager_users_ids, string $mode,
                                                                      string $current_user_email_domain, bool $plus_authored): array {
            $dual_shop_manager_user_id = self::get_author_id_for_switched_from_role(self::$dual_shop_manager_role_name);

            $dualshop_query = array(
                    'numberposts' => -1,
                    'post_type'   => 'addify_quote',
                    'post_status' => 'publish',
                    'meta_query' => array(
                        array(
                            'key' => '_customer_user',
                            'value' => $dual_shop_manager_users_ids,
                            'compare' => 'IN',
                        ),
                        array(
                            'key' => '_created_by_dual_shop_manager',
                            'value' => '1',
                        ),
                        array(
                            'key' => '_sales_rep_domain',
                            'value' => $current_user_email_domain,
                        )
                    )
            );

            $author_query = array(
                'numberposts' => -1,
                'post_type'   => 'addify_quote',
                'post_status' => 'publish',
                'author' => $dual_shop_manager_user_id,
            );

            if ($mode === 'ids') {
                $dualshop_query['fields'] = 'ids';
                $author_query['fields'] = 'ids';
            }

            $dualshop_query_results = get_posts($dualshop_query);
            $author_query_results = get_posts($author_query);
            if ($plus_authored) {
            $results_combined = array_merge($dualshop_query_results, $author_query_results);
            
            // Sort by post_date descending (newest first)
            usort($results_combined, function ($a,$b) {
                return strtotime($b->post_date) <=> strtotime($a->post_date);
            });
   
            $results = $mode === 'ids'
                   ? $results_combined
                   : Nsi_Helper::get_unique_objects_by_property($results_combined, 'ID');
            } else {
                $results = $dualshop_query_results;
            }

            return $results;
        }

        public static function add_hooks_for_dual_managers(DualManagerMode $mode): void {
            self::$dual_managers_hooks_added = true;
            if ($mode === DualManagerMode::ADMIN) {
                add_filter( 'show_admin_bar', '__return_true' , 1000 );

            }

            self::remove_cart_and_quote_creation_access();
            self::handle_restrictions_fe_for_dual_shop_managers();
            add_action('woocommerce_account_orders_endpoint', array(__CLASS__, 'show_dual_shop_manager_orders_listing'), 5, 1);
            add_action('woocommerce_account_request-quote_endpoint', array(__CLASS__, 'show_dual_shop_manager_quotes_listing'));
            add_filter('user_has_cap', array(__CLASS__, 'add_cap_to_dual_shop_manager_users'), 10, 3);
            add_action('init', array(__CLASS__, 'remove_quotes_listing_hook_on_my_account'), 99);
        }

        public static function get_user_email_domain( $use_switched_email = true ) {
            $admin_id = isset($_COOKIE['sac_admin_id']) ? $_COOKIE['sac_admin_id'] : 0;
            $admin_user = get_user_by('id', $admin_id);
            $user_email_domain = '';
            if (self::is_switched_from_role($admin_id, $admin_user, self::$dual_shop_manager_role_name)) {
                if ( $use_switched_email ) {
                    $current_user_email = $admin_user->user_email;
                } else {
                    $current_user_email = '';
                }
            } elseif ( $admin_id != 0 && ! Nsi_Helper::is_admin_session_set() ) {
                return $user_email_domain;
            } else {
                $current_user_email = self::$current_user->user_email;
            }
            if (preg_match('/(@[^,;\s]+)/', $current_user_email, $matches)) {
                $user_email_domain = $matches[1];
            }
            return $user_email_domain;
        }

        public static function get_author_id_for_switched_from_role($role_to_check_authority) {
            $user_id = self::$current_user->ID;
            $admin_id = isset($_COOKIE['sac_admin_id']) ? $_COOKIE['sac_admin_id'] : 0;
            $admin_user = get_user_by('id', $admin_id);
            if (self::is_switched_from_role($admin_id, $admin_user, $role_to_check_authority)) {
                $user_id = $admin_id;
            } elseif ( $admin_id != 0 && ! Nsi_Helper::is_admin_session_set() ) {
                $user_id = 0;
            }
            return $user_id;
        }

        public static function hide_restricted_menus($items, $menu_to_unset) {
            unset($items[$menu_to_unset]);
            return $items;
        }

        public static function handle_restrictions_fe_for_dual_shop_managers(): void {
            add_filter('woocommerce_account_menu_items', function ($items) {
                if (defined('DUALSHOP_FE_ORDERS_RESTRICTED') && DUALSHOP_FE_ORDERS_RESTRICTED) {
                    $items = Crown_Shop_Custom_Roles::hide_restricted_menus($items, 'orders');
                }
                if (defined('DUALSHOP_FE_QUOTES_RESTRICTED') && DUALSHOP_FE_QUOTES_RESTRICTED) {
                    $items = Crown_Shop_Custom_Roles::hide_restricted_menus($items, 'request-quote');
                }
                if (defined('DUALSHOP_FE_QUOTES_RESTRICTED') && DUALSHOP_FE_QUOTES_RESTRICTED) {
                    $items = Crown_Shop_Custom_Roles::hide_restricted_menus($items, 'request-a-quote');
                }
                return $items;
            }, 99);

            add_action('template_redirect', function () {
                if (is_account_page()) {
                    global $wp;
                    if (defined('DUALSHOP_FE_ORDERS_RESTRICTED') && DUALSHOP_FE_ORDERS_RESTRICTED && isset($wp->query_vars['orders'])) {
                        wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')));
                        exit;
                    }
                    if (defined('DUALSHOP_FE_QUOTES_RESTRICTED') && DUALSHOP_FE_QUOTES_RESTRICTED && isset($wp->query_vars['request-quote'])) {
                        wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')));
                        exit;
                    }
                }
            });
        }

        public static function clear_user_sessions_on_role_change($user_id, $role, $old_roles) {
            if ( defined('EXTRA_CLEAR_COOKIES_CHANGE_ROLE') && EXTRA_CLEAR_COOKIES_CHANGE_ROLE && $role !== $old_roles[0]) {
                if (class_exists('WP_Session_Tokens')) {
                    $session_tokens = WP_Session_Tokens::get_instance($user_id);
                    $session_tokens->destroy_all();
                }
            }
        }

        /**
         * Checks if the user is switched from a specific role.
         *
         * @param mixed $admin_id The ID of the admin user (from cookie or session).
         * @param WP_User|bool $admin_user The WP_User object or false if not found.
         * @param string $role The role to check against (e\.g\., dual shop manager).
         * @return bool True if the user is switched from the given role, false otherwise.
         */
        public static function is_switched_from_role(mixed $admin_id, WP_User|bool $admin_user, string $switched_role): bool {
            return Nsi_Helper::is_admin_session_set()
                    && self::$current_user->ID != $admin_id && $admin_id != 0
                    && isset($admin_user->roles[0]) && $admin_user->roles[0] === $switched_role;
        }

        public static function restrict_edit_quote_extra_elements_in_admin_panel_via_styles() {
            echo '<style>
                    #poststuff #crown-quote-delete-post-button,
                    #poststuff .addify_converty_to_order_button,
                    #poststuff .delete-quote-item {
                        display: none;
                    }
                </style>';
        }
        public static function restrict_edit_post_elements_in_admin_panel_via_styles() {
            echo '<style>
                    #poststuff input, #poststuff select, #poststuff textarea {
                        pointer-events: none;
                        background: #f9f9f9;
                    }
                    #poststuff #crown-quote-delete-post-button,
                    #poststuff .addify_converty_to_order_button,
                    #poststuff .delete-quote-item,
                    #poststuff .edit-post-status, 
                    #poststuff .edit-visibility, 
                    #poststuff .edit-timestamp {
                        display: none;
                    }
                </style>';
        }

        public static function update_order_counters_in_admin_panel( $views ) {
            $roles_to_alter_counters_for = array(
                self::$branch_admin_role_name,
                self::$internal_sales_rep_role_name,
                self::$shop_manager_role_name,
                self::$dual_shop_manager_role_name
            );

            if ( !in_array(self::$current_user->roles[0], $roles_to_alter_counters_for) ) {
                return $views;
            }

            if ( self::$current_user->roles[0] == self::$branch_admin_role_name ) {
                $users_to_get_orders_for = self::get_users_ids_for_branch_roles( self::$current_user->ID );
            } else if( self::$current_user->roles[0] == self::$internal_sales_rep_role_name ) {
                $user_states = explode( ',', get_user_meta( self::$current_user->ID, 'internal_sales_rep_states', true ) );
                $users = get_users( array(
                    'meta_key' => 'shipping_state',
                    'meta_value' => $user_states,
                    'meta_compare' => 'IN'
                ) );

                $users_to_get_orders_for = [];
                foreach( $users ?? [] as $user ) {
                    $users_to_get_orders_for[] = $user->ID;
                }
            } else if( self::$current_user->roles[0] == self::$shop_manager_role_name ) {
                $current_user_email_domain = Crown_Shop_Orders::get_email_domain( self::$current_user );
                $users_to_get_orders_for = Crown_Shop_Custom_Roles::get_sales_rep_customer_ids( $current_user_email_domain );
            } else if( self::$current_user->roles[0] == self::$dual_shop_manager_role_name ) {
                $current_user_email_domain = Crown_Shop_Orders::get_email_domain( self::$current_user );
                $customer_ids = Crown_Shop_Custom_Roles::get_sales_rep_customer_ids( $current_user_email_domain );

                foreach ( $views as $view => $content ) {
                    if ( $view == 'all' ) {
                        $orders = Nsi_Helper::get_orders_for_dsm_sql_query_raw( $customer_ids, $current_user_email_domain, '', 'shop_order' );
                    } else {
                        $orders = Nsi_Helper::get_orders_for_dsm_sql_query_raw( $customer_ids, $current_user_email_domain, $view, 'shop_order' );
                    }

                    $count = count( $orders );
                    preg_match( '/count">\((.*)\)<\/span/', $content, $matches );
                    if ( isset($matches[1]) ) {
                        $views[ $view ] = str_replace( $matches[1], $count, $content );
                    }

                    unset( $matches );
                }
            }

            if ( !empty($users_to_get_orders_for) ) {
                foreach ( $views as $view => $content ) {
                    if ( $view == 'all' ) {
                        $count = self::get_order_count_by_users_and_status( $users_to_get_orders_for );
                    } else {
                        $count = self::get_order_count_by_users_and_status( $users_to_get_orders_for, $view );
                    }

                    preg_match( '/count">\((.*)\)<\/span/', $content, $matches );
                    if ( isset($matches[1]) ) {
                        $views[ $view ] = str_replace( $matches[1], $count, $content );
                    }

                    unset( $matches );
                }
            }

            return $views;
        }

        public static function get_order_count_by_users_and_status( $users, $status = '' ) {
            global $wpdb;
            $placeholders = implode( ',', array_fill(0, count($users), '%d') );
            if ( empty($status) ) {
                $query = $wpdb->prepare(
                    "SELECT count(*) as cnt FROM wp_posts AS p
LEFT JOIN wp_postmeta pm1 on p.ID = pm1.post_id
WHERE p.post_type = 'shop_order' AND pm1.meta_key = '_customer_user' AND pm1.meta_value IN ( $placeholders )",
                    ...$users
                );
            } else {
                $query = $wpdb->prepare(
                    "SELECT count(*) as cnt FROM wp_posts AS p
LEFT JOIN wp_postmeta pm1 on p.ID = pm1.post_id
WHERE p.post_type = 'shop_order' AND p.post_status = %s AND pm1.meta_key = '_customer_user' AND pm1.meta_value IN ( $placeholders )",
                    $status, ...$users
                );
            }

            $result = $wpdb->get_results( $query );
            return ( $result && isset( $result[0]->cnt ) ) ? $result[0]->cnt : 0 ;
        }

    }
}
