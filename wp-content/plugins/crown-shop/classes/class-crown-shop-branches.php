<?php

if ( ! class_exists( 'Crown_Shop_Branches' ) ) {
	class Crown_Shop_Branches {

		public static $init = false;

        public static $current_user;

        public static $administrator_role_name = 'administrator';
        public static $branch_admin_role_name = 'branch_admin';
        public static $branch_employee_viewer_role_name = 'branch_employee_viewer';
        public static $branch_employee_role_name = 'branch_employee';

        private const BRANCH_ADMIN_GROUP_WARNING = 'Branch Group is required for Branch Admins.';
        private const BRANCH_ADMIN_STATES_WARNING = 'You can only assign branch groups and states that you have access to.';
        private const BRANCH_ADMIN_BRANCH_OR_CUSTOMER_WARNING = 'Either Branch Name or Assigned Customers must be provided.';
        private const BRANCH_ADMIN_ROLES_TO_MANAGE_ALLOWED_WARNING = 'Branch Admins can only change the role of Branch Employees and Branch Employee Viewers.';

		public static function init() {
			if( self::$init ) return;
			self::$init = true;

            add_action('plugins_loaded', array( __CLASS__, 'set_current_user' ), -2 );
            add_action('admin_menu', array( __CLASS__, 'add_customer_branch_taxonomy_menu'));
            add_action('after_setup_theme', array( __CLASS__, 'register_user_taxonomies' ) );
            add_action('after_setup_theme', array( __CLASS__, 'add_customer_branch_field'));
            add_action('load-user-edit.php', array( __CLASS__, 'disable_acf_fields_for_branch_admin'));
            add_action('load-profile.php', array( __CLASS__, 'disable_acf_fields_for_branch_admin'));
            add_filter('acf/load_field/key=field_customer_branch_name', array( __CLASS__, 'acf_load_customer_branch_name_field_choices'));
            add_filter('acf/load_field/key=field_customer_branch_states', array( __CLASS__, 'acf_load_customer_branch_states_field_choices'));
            add_filter('acf/load_field/key=field_assigned_customers', array( __CLASS__, 'acf_load_assigned_customers_field_choices'));
            add_filter('acf/validate_value/key=field_branch_group', array( __CLASS__, 'validate_customer_branch_settings'), 10, 2);
            add_action('user_profile_update_errors', array( __CLASS__, 'branch_admin_restrict_role'), 10, 3);
            add_action('user_register', array( __CLASS__, 'set_user_created_by_branch_admin'), 10, 1);
		}

        public static function set_current_user() {
            if( !isset( self::$current_user ) ) {
                self::$current_user = wp_get_current_user();
            }
        }

        public static function add_customer_branch_taxonomy_menu() {
            if ( current_user_can('manage_options') ) {
                add_submenu_page(
                    'users.php',
                    'Customer Branches',
                    'Branches',
                    'edit_users',
                    'edit-tags.php?taxonomy=branch',
                    '',
                    25
                );
            }
        }

        public static function register_user_taxonomies() {
            $labels = array(
                'name'              => __('Branches', 'textdomain'),
                'singular_name'     => __('Branch', 'textdomain'),
                'search_items'      => __('Search Branches', 'textdomain'),
                'all_items'         => __('All Branches', 'textdomain'),
                'parent_item'       => __('Parent Branch', 'textdomain'),
                'parent_item_colon' => __('Parent Branch:', 'textdomain'),
                'edit_item'         => __('Edit Branch', 'textdomain'),
                'update_item'       => __('Update Branch', 'textdomain'),
                'add_new_item'      => __('Add New Branch', 'textdomain'),
                'new_item_name'     => __('New Branch Name', 'textdomain'),
                'menu_name'         => __('Branch', 'textdomain'),
            );

            $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'public'            => true,
                'show_in_rest'      => true,
                'rewrite'           => array('slug' => 'branch'),
                'show_in_menu'      => true,
                'show_in_nav_menus' => false,
                'capabilities'      => array(
                    'manage_terms'  => 'manage_options',
                    'edit_terms'    => 'manage_options',
                    'delete_terms'  => 'manage_options',
                    'assign_terms'  => 'edit_users',
                ),
            );

            register_taxonomy('branch', 'user', $args);
        }

        public static function add_customer_branch_field() {
            $disabled = true;
            if ( isset( self::$current_user ) && in_array( self::$current_user->roles[0], array(self::$branch_admin_role_name, self::$administrator_role_name))) {
                $disabled = false;
            }
            if( function_exists('acf_add_local_field_group') ) {

                acf_add_local_field_group(array(
                    'key' => 'group_customer_branches',
                    'title' => 'Branches Information',
                    'fields' => array(
                        array(
                            'key' => 'field_branch_group',
                            'label' => 'Branch Group',
                            'name' => 'branch_group',
                            'type' => 'repeater',
                            'instructions' => 'Add branch and states information',
                            'layout' => 'row',
                            'button_label' => 'Add Branch Group',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_customer_branch_name',
                                    'label' => 'Branch Name',
                                    'name' => 'customer_branch_name',
                                    'type' => 'select',
                                    'choices' => array(),
                                    'allow_null' => 0,
                                    'disabled' => $disabled,
                                    'required' => 1,
                                    'multiple' => 0,
                                    'ui' => 1,
                                    'return_format' => 'value',
                                    'ajax' => 1,
                                ),
                                array(
                                    'key' => 'field_customer_branch_states',
                                    'label' => 'Branch States',
                                    'name' => 'customer_branch_states',
                                    'type' => 'select',
                                    'choices' => array(),
                                    'allow_null' => 0,
                                    'disabled' => $disabled,
                                    'multiple' => 1,
                                    'ui' => 1,
                                    'return_format' => 'value',
                                    'ajax' => 0,
                                ),
                            ),
                        ),
                        array(
                            'key' => 'field_assigned_customers',
                            'label' => 'Assigned Customers',
                            'name' => 'assigned_customers',
                            'type' => 'select',
                            'multiple' => 1,
                            'disabled' => $disabled,
                            'ui' => 1,
                            'choices' => array(),
                            'ajax' => 1,
                            'return_format' => 'value'
                        ),
                        array(
                            'key' => 'field_user_created_by',
                            'label' => 'User created by',
                            'name' => 'user_created_by',
                            'type' => 'number',
                            'disabled' => true,
                            'ui' => 1,
                            'ajax' => 1,
                            'return_format' => 'value'
                        ),
                    ),
                    'location' => array(
                        array(
                            array(
                                'param' => 'user_form',
                                'operator' => '==',
                                'value' => 'all',
                            ),
                        ),
                        array(
                            array(
                                'param' => 'user_form',
                                'operator' => '==',
                                'value' => 'profile',
                            ),
                        ),
                    ),
                    'menu_order' => 0,
                    'position' => 'normal',
                    'style' => 'default',
                    'label_placement' => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen' => '',
                    'active' => true,
                    'description' => '',
                ));

            }
        }

        public static function acf_load_customer_branch_name_field_choices ( $field ) {
            $field['choices'] = array();

            $branches = get_terms( array(
                'taxonomy' => 'branch',
                'hide_empty' => false,
            ) );

            if( self::$current_user->roles[0] === 'branch_admin' ) {
                $branch_admin_branches = [];
                remove_filter('acf/load_field/key=field_customer_branch_name', array( __CLASS__, 'acf_load_customer_branch_name_field_choices'));
                $branch_groups = get_field('branch_group', 'user_' . self::$current_user->ID);
                foreach ( $branch_groups as $branch_group ) {
                    $branch_admin_branches[] = $branch_group['customer_branch_name'];
                }
                add_filter('acf/load_field/key=field_customer_branch_name', array( __CLASS__, 'acf_load_customer_branch_name_field_choices'));
            }

            if( !empty($branches) ) {
                foreach( $branches as $branch ) {
                     if ( !isset($branch_admin_branches) ) {
                         $field['choices'][ $branch->term_id ] = $branch->name;
                     } else if( in_array($branch->term_id, $branch_admin_branches) ) {
                        $field['choices'][ $branch->term_id ] = $branch->name;
                     }
                }
            }

            return $field;
        }

        public static function acf_load_customer_branch_states_field_choices ( $field ) {
            static $in_progress = false;
            if ($in_progress) {
                return $field;
            }
            $in_progress = true;

            $field['choices'] = array();
            $states = array(
                'USA' => array(),
                'Canada' => array(),
            );
            $countries_obj = new WC_Countries();
            $us_states = $countries_obj->get_states('US');
            $ca_states = $countries_obj->get_states('CA');

            foreach ( $us_states as $us_code => $us_state ) {
                $states['USA'][$us_code] = $us_state;
            }
            foreach ( $ca_states as $ca_code => $ca_state ) {
                $states['Canada'][$ca_code] = $ca_state;
            }

            if (isset(self::$current_user->roles[0]) && self::$current_user->roles[0] === self::$branch_admin_role_name) {
                $allowed_states = [];
                $branch_groups = get_field('branch_group', 'user_' . self::$current_user->ID);
                if (!empty($branch_groups)) {
                    foreach ($branch_groups as $group) {
                        $group_states = $group['customer_branch_states'] ?? $group['field_customer_branch_states'] ?? [];
                        foreach ($group_states as $state) {
                            $allowed_states[] = $state;
                        }
                    }
                }
                foreach ($states as $country => $state_list) {
                    $filtered = array_intersect_key($state_list, array_flip($allowed_states));
                    if (!empty($filtered)) {
                        $field['choices'][$country] = [];
                        foreach ($filtered as $state_code => $state_name) {
                            $field['choices'][$state_code] = $state_name;
                        }
                    }
                }
            } else {
                    foreach( $states as $country => $state_list ) {
                    $field['choices'][ $country ] = array(); // Creates an optgroup
                    if(empty($state_list)) {
                        continue;
                    }
                    foreach( $state_list as $state_code => $state_name ) {
                        $field['choices'][ $state_code ] = $state_name;
                    }
                }
            }

            $in_progress = false;
            return $field;
        }

        public static function acf_load_assigned_customers_field_choices( $field ) {
            $field['choices'] = array();
            $assigned_customers = array();
            $customers = array();

            $user_id_being_edited = isset( $_GET['user_id'] ) ? intval( $_GET['user_id'] ) : 0;
            if ( $user_id_being_edited === 0 && defined( 'IS_PROFILE_PAGE' ) && IS_PROFILE_PAGE ) {
                $user_id_being_edited = get_current_user_id();
            }
            $saved_values = get_user_meta($user_id_being_edited, 'assigned_customers', true);
            if (!empty($saved_values)) {
                foreach ($saved_values as $customer_id) {
                    $user = get_user_by('ID', $customer_id);
                    if ($user && !isset($field['choices'][$customer_id])) {
                        $field['choices'][$customer_id] = $user->display_name;
                    }
                }
            }
            if ( isset( self::$current_user ) && in_array( self::$current_user->roles[0], array(self::$branch_admin_role_name, self::$administrator_role_name))) {
                $args = array(
                    'role' => 'customer',
                    'orderby' => 'display_name',
                    'order'   => 'ASC',
                    'number'  => 20,
                );
                $search = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
                if ( ! empty( $search )) {
                    $args['search'] = '*' . esc_attr( $search ) . '*';
                }

                $branch_groups = get_field('branch_group', 'user_' . self::$current_user->ID);

                if (!empty($branch_groups)) {
                    foreach ($branch_groups as $group) {
                        $branch_meta_query = array();
                        $branch_id = $group['customer_branch_name'] ?? null;
                        $branch_states = $group['customer_branch_states'] ?? [];

                        if ($branch_id) {
                            $branch_term = get_term($branch_id, 'branch');
                            $branch_name = $branch_term->name ?? '';

                            if (!empty($branch_states)) {
                                $branch_meta_query['relation'] = 'AND';
                                $branch_meta_query[] = [
                                    'key' => 'shipping_state',
                                    'value' => $branch_states,
                                    'compare' => 'IN',
                                ];
                            }

                            $branch_meta_query[] = [
                                'key' => 'nickname',
                                'value' => '^' . $branch_name,
                                'compare' => 'REGEXP',
                            ];
                            $args['meta_query'] = $branch_meta_query;
                            $users = get_users( $args );

                            foreach ($users as $user) {
                                $customers[] = $user;
                            }
                        }
                    }
                }

                if ( empty( $customers )  && self::$current_user->roles[0] == self::$administrator_role_name ) {
                    $users = get_users( $args );

                    foreach ($users as $user) {
                        $customers[] = $user;
                    }
                }

                $assigned_customers_ids = get_user_meta(self::$current_user->ID, 'assigned_customers', true);

                if (!empty($assigned_customers_ids)) {
                    $assigned_customers_args = self::get_assigned_customers_query_arguments($assigned_customers_ids);
                    $assigned_customers = get_users( $assigned_customers_args );
                }

                $merged_customers = array_merge($customers, $assigned_customers);

                foreach ($merged_customers as $customer) {
                    if (!isset($field['choices'][$customer->ID])) {
                        $field['choices'][$customer->ID] = $customer->display_name;
                    }
                }
            }
            $field['choices'] = array_slice($field['choices'], 0, 20, true);
            return $field;
        }

        public static function get_assigned_customers_query_arguments($assigned_customers_ids) {
            $args = array(
                'role' => 'customer',
                'include' => $assigned_customers_ids,
                'orderby' => 'display_name',
                'order'   => 'ASC',
                'number'  => 20,
            );
            $search = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
            if ( ! empty( $search )) {
                $args['search'] = '*' . esc_attr( $search ) . '*';
            }

            return $args;
        }

        public static function disable_acf_fields_for_branch_admin() {
            $disable_buttons = $disable_extra_fields = true;
            $disable_roles = false;
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                $user_id_being_edited = isset( $_GET['user_id'] ) ? intval( $_GET['user_id'] ) : 0;

                if ( $current_user->roles[0] === self::$branch_admin_role_name ) {
                    $disable_extra_fields = true;
                    if ( !empty($user_id_being_edited) && $current_user->ID != $user_id_being_edited ) {
                        $disable_buttons = false;
                        $user_being_edited = get_user_by( 'id', $user_id_being_edited );
                        if ($user_being_edited && !in_array($user_being_edited->roles[0], array(self::$branch_employee_role_name, self::$branch_employee_viewer_role_name))) {
                            $disable_roles = true;
                        }
                    }
                } elseif ( $current_user->roles[0] === self::$administrator_role_name ) {
                    $disable_buttons = false;
                    $disable_extra_fields = false;
                }
            }
            if ( $disable_buttons || $disable_roles || $disable_extra_fields ) {
                $js_custom_roles_path = realpath(plugin_dir_path(__FILE__) . '/../../assets/src/js/custom-roles.js');
                $js_custom_roles_url = plugin_dir_url( __FILE__ ) . '/../../assets/src/js/custom-roles.js';
                $js_custom_roles_ver = file_exists($js_custom_roles_path) ? filemtime($js_custom_roles_path) : time();

                wp_enqueue_script( 'custom-roles-script', $js_custom_roles_url, array( 'jquery' ), $js_custom_roles_ver, true);

                wp_localize_script( 'custom-roles-script', 'currentUser', array(
                    'disableButtons' => $disable_buttons,
                    'disableRoles' => $disable_roles,
                    'disableExtraFields' => $disable_extra_fields,
                ) );
            }
            if ($disable_buttons) {
                add_filter('acf/prepare_field', array( __CLASS__, 'disable_acf_fields'));
            }

        }

        public static function disable_acf_fields( $field ) {
            $target_fields = array( 'field_customer_branch_name', 'field_customer_branch_states', 'field_assigned_customers' );
            if ( in_array( $field['key'], $target_fields ) ) {
                $field['data-readonly'] = 1;
                $field['class'] = isset($field['class']) ? $field['class'] . ' disabled' : 'disabled';
            }
            return $field;
        }

        public static function validate_customer_branch_settings($valid, $value) {
            if( !$valid ) {
                return $valid;
            }

            if (isset($_POST['user_id'])) {
                $user_id = $_POST['user_id'];
            } else {
                return $valid;
            }

            $user_roles = self::get_user_roles_after_submission($user_id);

            if (!self::validate_submitted_groups_states($user_roles, $value)) {
                return __(self::BRANCH_ADMIN_STATES_WARNING, 'acf');
            }

            if (!self::validate_branch_admin_group_required($user_roles, $value)) {
                return __(self::BRANCH_ADMIN_GROUP_WARNING, 'acf');
            }

            if (!self::validate_employee_or_viewer_requirements($user_roles, $value)) {
                return __(self::BRANCH_ADMIN_BRANCH_OR_CUSTOMER_WARNING, 'acf');
            }

            return $valid;
        }

        public static function branch_admin_restrict_role($errors, $update, $user) {
            $role = isset($_POST['role']) ? $_POST['role'] : ($user->roles[0] ?? '');
            $branch_group = $_POST['acf']['field_branch_group'] ?? [];

            if ($role === self::$branch_admin_role_name && empty($branch_group)) {
                    $errors->add('branch_admin_error__group_restriction_violation', __(self::BRANCH_ADMIN_GROUP_WARNING, 'acf'));
            } elseif (current_user_can(self::$branch_admin_role_name)) {
                if (!self::validate_submitted_groups_states([$role], $branch_group)) {
                    $errors->add('branch_admin_error__states_restriction_violation', __(self::BRANCH_ADMIN_STATES_WARNING, 'acf'));
                }
                $user_id = $user->ID;
                if ($_POST['action'] === 'createuser' ) {
                    $current_role = isset($_POST['role']) ?? '';
                } else {
                    $existing_user = get_userdata($user_id);
                    $current_role = $existing_user->roles[0];
                }
                if (isset($_POST['role']) && !in_array($current_role, array(self::$branch_employee_role_name, self::$branch_employee_viewer_role_name) ) ) {
                    $errors->add('role_error', __(self::BRANCH_ADMIN_ROLES_TO_MANAGE_ALLOWED_WARNING, 'textdomain'));
                }
            }
        }

        public static function get_user_roles_after_submission($user_id) {
            if (isset($_POST['role']) && !empty($_POST['role'])) {
                return array($_POST['role']);
            } else {
                $user = get_userdata($user_id);
                return $user->roles;
            }
        }

        public static function set_user_created_by_branch_admin( $user_id ) {
            if ( is_user_logged_in() && isset( self::$current_user->roles[0] ) && self::$current_user->roles[0] == self::$branch_admin_role_name ) {
                $branch_admin_roles_allowed = array(
                    self::$branch_employee_role_name,
                    self::$branch_employee_viewer_role_name,
                );
                if ( ! isset( $_POST['role'] ) || ! in_array( $_POST['role'], $branch_admin_roles_allowed ) ) {
                    return;
                }
                update_field('user_created_by', self::$current_user->ID, 'user_' . $user_id);
            }
        }

        private static function validate_submitted_groups_states($user_roles, $submitted_groups_values) {
            if ( isset(self::$current_user->roles[0]) &&
                 self::$current_user->roles[0] === self::$branch_admin_role_name &&
                 in_array($user_roles[0], [self::$branch_employee_role_name, self::$branch_employee_viewer_role_name]) ) {
                $admin_groups = get_field('branch_group', 'user_' . self::$current_user->ID);
                $admin_allowed = [];
                if (!empty($admin_groups)) {
                    foreach ($admin_groups as $admin_group) {
                        $branch_id = $admin_group['customer_branch_name'] ?? null;
                        $states = $admin_group['customer_branch_states'] ?? [];
                        if ($branch_id && !empty($states)) {
                            foreach ($states as $state) {
                                $admin_allowed[] = $branch_id . ':' . $state;
                            }
                        }
                    }
                }
                if (!empty($submitted_groups_values)) {
                    foreach ($submitted_groups_values as $group_value) {
                        $branch_id = $group_value['field_customer_branch_name'] ?? null;
                        $states = $group_value['field_customer_branch_states'] ?? [];
                        foreach ($states as $state) {
                            if (!in_array($branch_id . ':' . $state, $admin_allowed)) {
                                return false;
                            }
                        }
                    }
                }
            }
            return true;
        }

        private static function validate_branch_admin_group_required($user_roles, $value) {
            $is_new_user_branch_admin = isset($_POST['role']) && $_POST['role'] === self::$branch_admin_role_name;
            $is_user_being_set_as_branch_admin = isset($user_roles[0]) && $user_roles[0] === self::$branch_admin_role_name;
            if (($is_new_user_branch_admin || $is_user_being_set_as_branch_admin) && empty($value)) {
                return false;
            }
            return true;
        }

        private static function validate_employee_or_viewer_requirements($user_roles, $value) {
            if (in_array($user_roles[0], [self::$branch_employee_viewer_role_name, self::$branch_employee_role_name])) {
                $assigned_customers_value = isset($_POST['acf']['field_assigned_customers']) ? array_filter(array_map('sanitize_text_field', (array) $_POST['acf']['field_assigned_customers'])) : [];
                if (empty($assigned_customers_value) && empty($value)) {
                    return false;
                }
            }
            return true;
        }

    }
}