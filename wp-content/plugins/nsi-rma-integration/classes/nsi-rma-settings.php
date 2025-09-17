<?php

if ( ! class_exists( 'NSI_RMA_Settings' ) ) {

    class NSI_RMA_Settings {
        public static bool $init = false;

        public static function init() {
            if ( self::$init ) {
                return true;
            }

            add_action( 'admin_init', array( __CLASS__, 'init_returns_settings' ) );
            add_action( 'admin_menu', array( __CLASS__, 'update_returns_menu_structure' ) );
        }

        public static function update_returns_menu_structure() {
            remove_submenu_page('edit.php?post_type=rma','post-new.php?post_type=rma');
            add_submenu_page(
                'edit.php?post_type=rma',
                __( 'Settings', 'nsi-rma' ),
                __( 'Settings', 'nsi-rma' ),
                'manage_options',
                'returns-settings',
                array( __CLASS__, 'rma_settings_page_callback' ),
                99
            );
        }

        public static function init_returns_settings() {
            add_settings_section(
                'returns_settings_main_section',
                'Main Settings',
                array( __CLASS__, 'returns_settings_main_section_cb' ),
                'returns-settings'
            );
            add_settings_field(
                'returns_settings_months_to_display_rma',
                'Months to display RMA history',
                array( __CLASS__, 'returns_settings_months_to_display_rma_field_cb' ),
                'returns-settings',
                'returns_settings_main_section'
            );
            add_settings_field(
                'returns_settings_months_for_return',
                'Months for return (default)',
                array( __CLASS__, 'returns_settings_months_for_return_field_cb' ),
                'returns-settings',
                'returns_settings_main_section'
            );
            add_settings_field(
                'returns_settings_max_amount_no_returns_available',
                'No returns available maximum amount',
                array( __CLASS__, 'returns_settings_max_amount_no_returns_available_field_cb' ),
                'returns-settings',
                'returns_settings_main_section'
            );
            add_settings_field(
                'returns_settings_no_returns_available_enabled',
                'No returns available - enabled',
                array( __CLASS__, 'returns_settings_no_returns_available_enabled_field_cb' ),
                'returns-settings',
                'returns_settings_main_section'
            );
            add_settings_field(
                'returns_settings_no_returns_available_notice',
                'No returns available notice',
                array( __CLASS__, 'returns_settings_no_returns_available_notice_field_cb' ),
                'returns-settings',
                'returns_settings_main_section'
            );
            add_settings_field(
                'returns_settings_return_policy_page',
                'Return Policy page',
                array( __CLASS__, 'returns_settings_return_policy_page_field_cb' ),
                'returns-settings',
                'returns_settings_main_section'
            );
            register_setting( 'returns_settings', 'returns_settings_months_to_display_rma' );
            register_setting( 'returns_settings', 'returns_settings_months_for_return' );
            register_setting( 'returns_settings', 'returns_settings_max_amount_no_returns_available' );
            register_setting( 'returns_settings', 'returns_settings_no_returns_available_enabled' );
            register_setting( 'returns_settings', 'returns_settings_no_returns_available_notice' );
            register_setting( 'returns_settings', 'returns_settings_return_policy_page' );


            add_settings_section(
                'returns_customer_settings_section',
                'Customers Settings',
                array( __CLASS__, 'returns_customer_settings_section_cb' ),
                'returns_customer_settings'
            );
            add_settings_field(
                'returns_settings_months_for_return_customers',
                'Months for return per customer',
                array( __CLASS__, 'returns_settings_months_for_return_customers_field_cb' ),
                'returns_customer_settings',
                'returns_customer_settings_section'
            );
            register_setting( 'returns_customer_settings', 'returns_settings_months_for_return_customers' );


            add_settings_section(
                'returns_reasons_settings_section',
                'Reasons Settings',
                array( __CLASS__, 'returns_reasons_settings_section_cb' ),
                'returns_reasons_settings'
            );
            add_settings_field(
                'returns_settings_reasons',
                'Reasons for returns',
                array( __CLASS__, 'returns_settings_reasons_field_cb' ),
                'returns_reasons_settings',
                'returns_reasons_settings_section'
            );
            register_setting( 'returns_reasons_settings', 'returns_settings_reasons' );


            add_settings_section(
                'returns_disclaimers_settings_section',
                'Returns Disclaimers Settings',
                array( __CLASS__, 'returns_disclaimers_settings_section_cb' ),
                'returns_disclaimers_settings'
            );
            add_settings_field(
                'returns_settings_disclaimers',
                'Disclaimers for',
                array( __CLASS__, 'returns_settings_disclaimers_field_cb' ),
                'returns_disclaimers_settings',
                'returns_disclaimers_settings_section'
            );
            register_setting( 'returns_disclaimers_settings', 'returns_settings_disclaimers' );
        }

        public static function rma_settings_page_callback() {
            if ( !defined( 'ABSPATH' ) ) { exit; }

            $active_tab 	= isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'main_settings';
            $main_slug_page = 'returns-settings';

            $list_tabs = [
                'main_settings' => array(
                    'title' 				=> esc_html__( 'Main settings' ),
                    'slug'					=> 'main_settings',
                    'settings_fields' 		=> 'returns_settings',
                    'do_settings_sections' 	=> 'returns-settings'
                ),
                'returns_settings_customer' => array(
                    'title' 				=> esc_html__( 'Customer Specific Settings' ),
                    'slug'					=> 'returns_customer',
                    'settings_fields' 		=> 'returns_customer_settings',
                    'do_settings_sections' 	=> 'returns_customer_settings'
                ),
                'returns_settings_reasons' => [
                    'title' 				=> esc_html__( 'Reasons Settings' ),
                    'slug'					=> 'returns_reasons',
                    'settings_fields' 		=> 'returns_reasons_settings',
                    'do_settings_sections' 	=> 'returns_reasons_settings'
                ],
                'returns_settings_disclaimers' => array(
                    'title' 				=> esc_html__( 'Disclaimers Settings' ),
                    'slug'					=> 'returns_disclaimers',
                    'settings_fields' 		=> 'returns_disclaimers_settings',
                    'do_settings_sections' 	=> 'returns_disclaimers_settings'
                ),
            ];

            echo '<div class="wrap">';
            echo '<h2>';
            esc_html_e( 'Returns Settings' );
            echo '</h2>';
            ?>

            <?php if( !empty( $list_tabs ) ) { ?>
                <h2 class="nav-tab-wrapper">
                    <?php foreach( $list_tabs as $slug => $data_tab ) { ?>
                        <a id="tab-<?php echo $slug ?>" href="?post_type=rma&page=<?php echo $main_slug_page ?>&tab=<?php echo $slug ?>"
                           class="nav-tab <?php echo $active_tab == $slug ? 'nav-tab-active' : ''; ?>">
                            <?php echo $data_tab[ 'title' ] ?>
                        </a>
                    <?php } ?>
                </h2>
            <?php } ?>
            </div>
            <?php
            self::display_content_tab( $list_tabs[ $active_tab ] );
        }

        public static function display_content_tab( $active_tab ) {
            echo '<div id="' . $active_tab[ 'slug' ] . '" class="tab-content">';
            echo '<form method="post" action="options.php">';
            settings_fields( $active_tab[ 'settings_fields' ] );
            do_settings_sections( $active_tab[ 'do_settings_sections' ] );
            submit_button();
            echo '</form>';
            echo '</div>';
        }

        public static function returns_settings_main_section_cb() {
            echo '<p>Settings for specifying:<br/>
- number of months to show returns history for all users<br />
- default amount of months allowed for returns for all users<br />
- page with Return Policy content etc.</p>';
        }

        public static function returns_customer_settings_section_cb() {
            echo '<p>Settings for specifying amount of months allowed for returns for specific users, based on their username prefix.</p>';
        }

        public static function returns_reasons_settings_section_cb() {
            echo '<p>Set up available reasons for return.</p>';
        }

        public static function returns_disclaimers_settings_section_cb() {
            echo '<p>Set up available disclaimers messages.</p>';
        }

        public static function returns_settings_months_to_display_rma_field_cb() {
            $months_limit = get_option( 'returns_settings_months_to_display_rma', 18 );
            $months_limit = esc_attr( $months_limit );

            echo '<div class="returns-settings-months-to-display-rma">';
            echo "<input type='number' min='0' step='1' name='returns_settings_months_to_display_rma' value='$months_limit' />";
            echo '</div>';
        }

        public static function returns_settings_months_for_return_field_cb() {
            $months_for_return = get_option( 'returns_settings_months_for_return', 12 );
            $months_for_return = esc_attr( $months_for_return );

            echo '<div class="returns-settings-months-for-return">';
            echo "<input type='number' min='0' step='1' name='returns_settings_months_for_return' value='$months_for_return' />";
            echo '</div>';
        }

        public static function returns_settings_max_amount_no_returns_available_field_cb() {
            $max_amount_no_returns = get_option( 'returns_settings_max_amount_no_returns_available', 250 );
            $max_amount_no_returns = esc_attr( $max_amount_no_returns );

            echo '<div class="returns-settings-max-amount-no-returns-available">';
            echo "<input type='number' min='0' step='1' inputmode='decimal' name='returns_settings_max_amount_no_returns_available' value='$max_amount_no_returns' />";
            echo '</div>';
        }

        public static function returns_settings_no_returns_available_enabled_field_cb() {
            $no_return_enabled = get_option( 'returns_settings_no_returns_available_enabled' );
            $no_return_enabled = esc_attr( $no_return_enabled );

            echo '<div class="returns-settings-no-returns-available-enabled">';
            echo "<input type='checkbox' name='returns_settings_no_returns_available_enabled' value='1'" . checked(1, $no_return_enabled, false ) . " />";
            echo '</div>';
        }

        public static function returns_settings_no_returns_available_notice_field_cb() {
            $no_return_notice = get_option( 'returns_settings_no_returns_available_notice', '' );
            $no_return_notice = esc_attr( $no_return_notice );

            echo '<div class="returns-settings-no-returns-available-notice">';
            echo "<input type='text' class='text' name='returns_settings_no_returns_available_notice' placeholder='Text' value='$no_return_notice' />";
            echo '</div>';
        }

        public static function returns_settings_return_policy_page_field_cb() {
            $policy_page = get_option( 'returns_settings_return_policy_page', '' );
            $policy_page = esc_attr( $policy_page );

            $pages = get_pages();

            echo '<div class="returns-settings-return-policy-page">';
            echo '<select name="returns_settings_return_policy_page">';
            echo '<option>Select Return Policy page</option>';
            foreach( $pages as $page ) {
                $selected = $policy_page == $page->ID ? 'selected="selected"' : '';
                echo "<option value='$page->ID' $selected>$page->post_title</option>";
            }
            echo '</select>';
            echo '</div>';
        }

        public static function returns_settings_months_for_return_customers_field_cb() {
            $option_value = get_option( 'returns_settings_months_for_return_customers' );
            $months_for_return_customers = $option_value['data'] ?? array();

            echo '<div id="returns-settings-months-for-return-customers" class="settings-returns-group-holder">';
            if( !empty( $months_for_return_customers ) ){
                $rows = count( $months_for_return_customers['customer-prefix'] );
                for( $i = 0; $i <= $rows; $i++ ) {
                    $prefix = $months_for_return_customers['customer-prefix'][$i];
                    $months = $months_for_return_customers['customer-months'][$i];
                    if ( empty($prefix) && empty($months) ) {
                        continue;
                    }

                    echo '<div class="months-for-return-customers-group settings-returns-group">';
                    echo "<input type='text' class='prefix' name='returns_settings_months_for_return_customers[data][customer-prefix][]' placeholder='Prefix' value='$prefix' />";
                    echo "<input type='number' min='0' step='1' class='months' name='returns_settings_months_for_return_customers[data][customer-months][]' placeholder='Months' value='$months' />";
                    echo "<button type='button' class='remove-returns-settings-group'>Remove</button>";
                    echo '</div>';
                }
            }
            echo '</div>';
            echo '<button type="button" id="add-returns-settings-group" data-type="month">Add Next</button>';
        }

        public static function returns_settings_reasons_field_cb() {
            $option_value = get_option( 'returns_settings_reasons' );
            $reasons_for_returns = $option_value['data'] ?? array();

            echo '<div id="returns-settings-reasons" class="settings-returns-group-holder">';
            if( !empty( $reasons_for_returns ) ){
                $rows = count( $reasons_for_returns['reason-key'] );
                for( $i = 0; $i <= $rows; $i++ ) {
                    $key = $reasons_for_returns['reason-key'][$i];
                    $reason = $reasons_for_returns['reason-label'][$i];
                    if ( empty($key) && empty($reason) ) {
                        continue;
                    }

                    echo '<div class="settings-reasons-group settings-returns-group">';
                    echo "<input type='text' class='key' name='returns_settings_reasons[data][reason-key][]' placeholder='Key' value='$key' />";
                    echo "<input type='text' class='label' name='returns_settings_reasons[data][reason-label][]' placeholder='Label' value='$reason' />";
                    echo "<button type='button' class='remove-returns-settings-group'>Remove</button>";
                    echo '</div>';
                }
            }
            echo '</div>';
            echo '<button type="button" id="add-returns-settings-group" data-type="reason">Add Next</button>';
        }

        public static function returns_settings_disclaimers_field_cb() {
            $returns_disclaimers = get_option( 'returns_settings_disclaimers', array() );
            $disclaimers = array(
                'item_returned' => 'Item Returned ',
                'item_discontinued' => 'Item Discontinued ',
                'item_not_returnable' => 'Item Not Returnable ',
                'item_not_shipped' => 'Item Not Shipped ',
                'order_returned' => 'Order Not Available ',
                'return_fees_notice' => 'Re-stocking fees notice ',
            );
            echo '<div id="returns-settings-disclaimers" class="settings-returns-group-holder">';
            foreach( $disclaimers as $key => $label ) {
                $text = ! empty( $returns_disclaimers ) && isset( $returns_disclaimers[$key] ) ? $returns_disclaimers[$key] : '';
                echo '<div class="settings-disclaimers-group settings-returns-group">';
                echo "<label for='returns_settings_disclaimers[$key]'>$label</label>";
                echo "<input type='text' class='text' name='returns_settings_disclaimers[$key]' placeholder='Text' value='$text' />";
                echo '</div>';
            }
            echo '</div>';
        }
    }
}

NSI_RMA_Settings::init();