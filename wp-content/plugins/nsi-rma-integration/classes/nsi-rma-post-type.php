<?php

if ( ! class_exists( 'NSI_RMA_Post_Type' ) ) {

    class NSI_RMA_Post_Type
    {
        public static bool $init = false;
        public static array $rma_capabilities;
        public static array $rma_statuses;

        public static function init() {
            if ( self::$init ) {
                return true;
            }

            self::$init = true;
            self::init_capabilities();

            add_action( 'init', array( __CLASS__, 'init_rma_statuses' ) );
            add_action( 'init', array( __CLASS__, 'register_post_type_rma' ) );
            add_action( 'init', array( __CLASS__, 'add_rma_capabilities' ) );

            if ( is_admin() ) {
                add_action( 'add_meta_boxes_rma', array( __CLASS__, 'add_rma_meta_boxes' ) );
                add_filter( 'manage_rma_posts_columns', array( __CLASS__, 'add_admin_rma_listing_columns' ) );
                add_filter( 'manage_rma_posts_custom_column', array( __CLASS__, 'set_admin_rma_listing_columns_values' ), 10, 2 );
                add_filter( 'restrict_manage_posts', array( __CLASS__, 'add_admin_rma_listing_filters' ), 10, 2 );
                add_action( 'parse_query', array( __CLASS__, 'filter_admin_rma_listing_by_status' ) );
                add_action( 'bulk_actions-edit-rma', array( __CLASS__, 'admin_rma_listing_disable_bulk_actions' ) );
                add_action( 'post_row_actions', array( __CLASS__, 'admin_rma_listing_disable_post_actions' ), 99, 2 );
                add_action( 'pre_post_update', array( __CLASS__, 'prevent_rma_posts_editing' ) );
                add_action( 'admin_notices', array( __CLASS__, 'show_rma_posts_error_message_on_editing' ) );
            }
        }

        public static function init_capabilities() {
            self::$rma_capabilities = array(
                'edit_post' => 'edit_rma',
                'read_post' => 'read_rma',
                'delete_post' => 'delete_rma',
                'edit_posts' => 'edit_rmas',
                'edit_others_posts' => 'edit_others_rmas',
                'publish_posts' => 'publish_rma',
                'read_private_posts' => 'read_private_rmas',
                'create_posts' => 'create_rmas',
                'delete_posts' => 'delete_rmas',
            );
        }

        public static function register_post_type_rma() {
            $labels = array(
                'name' => __( 'Returns', 'nsi-rma' ),
                'singular_name' => __( 'Return', 'nsi-rma' ),
                'add_new' => __( 'Add New Return', 'nsi-rma' ),
                'add_new_item' => __( 'Add New Return', 'nsi-rma' ),
                'new_item' => __( 'New Return', 'nsi-rma' ),
                'edit_item' => __( 'Edit Return', 'nsi-rma' ),
                'view_item' => __( 'View Return', 'nsi-rma' ),
                'all_items' => __( 'All Returns', 'nsi-rma' ),
                'search_items' => __( 'Search Returns', 'nsi-rma' ),
            );

            $args = array(
                'labels' => $labels,
                'capability_type' => array( 'rma', 'rmas' ),
                'capabilities' => self::$rma_capabilities,
                'supports' => array( 'title', 'author' ),
                'hierarchical' => false,
                'public' => true,
                'has_archive' => false,
                'menu_icon' => 'dashicons-groups'
            );

            register_post_type( 'rma', $args );
        }

        public static function add_rma_capabilities() {
            $roles_for_rma = array ( 'administrator', 'customer_service', 'shop_manager' );

            foreach( $roles_for_rma as $role_name ) {
                $role = get_role( $role_name );
                foreach( self::$rma_capabilities as $capability ) {
                    $role->add_cap( $capability );
                }
            }
        }

        public static function add_rma_meta_boxes() {
            add_meta_box( 'RmaStatus', 'Return status', array( __CLASS__, 'display_rma_status_box' ), 'rma', 'side', 'high' );
            add_meta_box( 'RmaDetails', 'Return details', array( __CLASS__, 'display_rma_details_box' ), 'rma', 'normal', 'high' );
        }

        public static function display_rma_status_box( $post ) {
            $is_error = get_post_meta( $post->ID, 'ns_rma_api_error', true );
            $ns_return_id = get_post_meta( $post->ID, 'ns_return_internal_id', true );
            if ( !empty($is_error) || empty($ns_return_id) ) {
                if ( empty($is_error) ) {
                    $is_error = 'Missing NetSuite RMA ID';
                }
                echo '<p id="NSReturnSyncError">' . __( 'There was an error during NS sync', 'nsi-rma' ) . ': <strong>' . $is_error . '</strong></p>';
                echo '<div class="button button-secondary" id="RetryNsReturnSync" data-return-id="' . $post->ID . '">Re-send Return to NS</div>';
                echo '<p id="NSReturnSyncResponse">Response: <span></span></p>';
            } else {
                $status = get_post_meta( $post->ID, 'rma_status', true );
                echo '<p>' . __( 'Return status', 'nsi-rma' ) . ': <strong>' . ( self::$rma_statuses[$status] ?? '' ) . '</strong></p>';
            }
        }

        public static function display_rma_details_box( $post ) {
            $return_post_meta = get_post_meta( $post->ID);
            $order_id = $return_post_meta['order_id'][0] ?? '';
            $order = wc_get_order( $order_id );
            $order_items = $order->get_items();
            $return_items = maybe_unserialize($return_post_meta['items'][0]) ?? array();
            $return_status = $return_post_meta['rma_status'][0] ?? '';
            $reason_label = self::get_return_reason_displayed_label( $return_post_meta );
            $ns_return_internal_id = $return_post_meta['ns_return_internal_id'][0] ?? '';

            ?>
            <div class="admin-return-details">
                <?php
                wc_get_template(
                    'rma-admin-rma-details.php',
                    array(
                        'order_id' => $order_id,
                        'return_status' => $return_status,
                        'return_post_meta' => $return_post_meta,
                        'reason_label' => $reason_label
                    ),
                    '/woocommerce/admin/',
                    NSI_RMA_DIR_PATH . 'templates/'
                );


                if ( !empty($ns_return_internal_id) ) {
                    echo NSI_RMA_Listings::get_return_pdf_button( $post->ID );
                }

                wc_get_template(
                    'rma-admin-metabox.php',
                    array(
                        'order' => $order,
                        'order_items' => $order_items,
                        'return_items' => $return_items
                    ),
                    '/woocommerce/admin/',
                    NSI_RMA_DIR_PATH . 'templates/'
                );
                ?>
            </div>
            <?php
        }

        public static function init_rma_statuses() {
            self::$rma_statuses = array(
                'pendingApproval' => __( 'Pending Approval', 'nsi-rma' ),
                'pendingReceipt' => __( 'Pending Receipt', 'nsi-rma' ),
                'pendingReturn' => __( 'Pending Return', 'nsi-rma' ),
                'partialReturn' => __( 'Partial Return', 'nsi-rma' ),
                'pendingCredit' => __( 'Pending Credit', 'nsi-rma' ),
                'pendingCreditpartReturn' => __( 'Pending Credit Part Return', 'nsi-rma' ),
                'refunded' => __( 'Refunded', 'nsi-rma' ),
                'credited' => __( 'Credited', 'nsi-rma' ),
                'cancelled' => __( 'Cancelled', 'nsi-rma' ),
                'closed' => __( 'Closed', 'nsi-rma' ),
            );
        }

        public static function add_admin_rma_listing_columns( $columns ) {
            if (isset ( $columns['cb'] ) ) {
                unset ( $columns['cb'] );
            }
            $columns['so_number'] = 'Sales Order#';
            $columns['po_number'] = 'PO#';
            $columns['rma_confirmation_no'] = 'Return Confirmation#';
            $columns['status'] = 'Status';
            $columns['restocking_fees'] = 'Restocking Fees';
            return $columns;
        }

        public static function set_admin_rma_listing_columns_values( $column_key, $post_id ) {
            if ( $column_key === 'so_number' ) {
                echo get_post_meta( $post_id, 'ns_order_tran_id', true ) ?? '';
            } elseif ( $column_key === 'po_number' ) {
                echo get_post_meta( $post_id, 'customer_po_number', true ) ?? '';
            } elseif ( $column_key === 'rma_confirmation_no' ) {
                echo get_post_meta( $post_id, 'ns_return_internal_id', true ) ?? '';
            } elseif ( $column_key === 'status' ) {
                $status = get_post_meta( $post_id, 'rma_status', true );
                if ( $status ) {
                    echo self::$rma_statuses[$status] ?? '';
                }
            } elseif ( $column_key === 'restocking_fees' ) {
                $restocking_fees_post_data = get_post_meta($post_id, 'restocking_fees', true) ?? null;
                echo self::get_restocking_fees_display_value( $restocking_fees_post_data );
            }
        }

        public static function add_admin_rma_listing_filters( $post_type, $which ) {
            if ($post_type == 'rma') {
                echo self::render_rma_listing_filters();
            }
        }

        public static function render_rma_listing_filters() {
            $status_filter = '<select name="rma_status" id="rma_status" class="postform">';
            $status_filter .= '<option value="">' . __( 'Select Status', 'nsi-rma' ) . '</option>';
            foreach ( self::$rma_statuses as $status_key => $status_name ) {
                $selected = '';
                if ( isset($_GET['rma_status']) && $_GET['rma_status'] == $status_key ) {
                    $selected = ' selected="selected"';
                }
                $status_filter .= '<option value="' . $status_key . '"' . $selected .'>' . $status_name . '</option>';
            }
            $status_filter .= '</select>';

            return $status_filter;
        }

        public static function filter_admin_rma_listing_by_status( $query ) {
            global $pagenow;
            if ( $pagenow !== 'edit.php' || !isset($_GET['post_type']) || $_GET['post_type'] !== 'rma' ) {
                return;
            }

            $status = $_GET['rma_status'] ?? '';

            if ( !empty($status) ) {
                $query->query_vars['meta_key'] = 'rma_status';
                $query->query_vars['meta_value'] = $status;
            }
        }

        public static function admin_rma_listing_disable_bulk_actions( $actions ) {
            return array();
        }

        public static function admin_rma_listing_disable_post_actions( $actions, $post ) {
            if ( $post->post_type != 'rma' ) {
                return $actions;
            }

            unset( $actions['inline hide-if-no-js'] );
            unset( $actions['trash'] );
            unset( $actions['duplicate_post'] );
            unset( $actions['edit'] );
            unset( $actions['view'] );

            return $actions;
        }

        public static function prevent_rma_posts_editing($post_id) {
            $post = get_post($post_id);

            if ( $post && $post->post_type === 'rma' &&
                is_admin() && ! wp_doing_ajax() ) {
                $list_url = admin_url('edit.php?post_type=rma&edit_blocked=1');
                wp_redirect($list_url);
                exit;
            }
        }

        public static function show_rma_posts_error_message_on_editing() {
            global $pagenow;

            if ($pagenow === 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'rma' && isset($_GET['edit_blocked'])) {
                echo '<div class="notice notice-error is-dismissible"><p>';
                echo esc_html__('Editing of this post type is not allowed.', 'rma-integration');
                echo '</p></div>';
            }
        }

        public static function get_return_reason_displayed_label($return_post_meta) {
            $return_reason = $return_post_meta['order_return_reason'][0] ?? '';

            $reasons_settings = get_option('returns_settings_reasons');
            $returns_reasons = $reasons_settings['data'] ?? array();
            foreach ($returns_reasons['reason-key'] as $id => $reason_key) {
                if ($reason_key == $return_reason) {
                    $reason_label = $returns_reasons['reason-label'][$id];
                }
            }
            if (empty($reason_label)) {
                $reason_label = $return_post_meta['order_return_reason_label'][0] ?? '';
            }
            return $reason_label;
        }

        public static function get_restocking_fees_display_value($restocking_fees) {
            return is_numeric( $restocking_fees ) ? wc_price( $restocking_fees ) : '--';
        }
    }
}

NSI_RMA_Post_Type::init();