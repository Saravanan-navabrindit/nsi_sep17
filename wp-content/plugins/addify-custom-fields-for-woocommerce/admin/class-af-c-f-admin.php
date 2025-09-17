<?php
if (!defined('WPINC')) {
	die;
}

if (!class_exists('AF_C_F_Admin')) {

	class AF_C_F_Admin {

		public $dependent_fields;

		public function __construct() {

			$this->dependent_fields = $this->get_all_dependent_fields();

			add_action('admin_enqueue_scripts', array( $this, 'af_c_f_admin_scripts' ));
			add_action( 'all_admin_notices', array( $this, 'af_a_nd_s_m_tabs' ), 5 );

			// Custom meta boxes.
			add_action('admin_init', array( $this, 'af_c_f_register_metaboxes' ), 10);
			add_action('save_post_af_c_fields', array( $this, 'af_c_f_meta_box_save' ));
			add_filter('manage_af_c_fields_posts_columns', array( $this, 'af_c_f_custom_columns' ));
			add_action('manage_af_c_fields_posts_custom_column', array( $this, 'af_c_f_custom_column' ), 10, 2);
			add_filter('bulk_actions-edit-af_c_fields', array( $this, 'af_c_f_bulk_action' ));
			add_filter('handle_bulk_actions-edit-af_c_fields', array( $this, 'af_c_f_bulk_action_handler' ), 10, 3);
			add_action('admin_notices', array( $this, 'af_c_f_bulk_action_admin_notice' ));
			add_action('admin_menu', array( $this, 'af_c_f_custom_menu_admin' ));
			add_action('admin_init', array( $this, 'af_c_f_options' ));
			add_action('edit_user_profile', array( $this, 'af_c_f_profile_fields' ));
			add_action('edit_user_profile_update', array( $this, 'af_c_f_update_profile_fields' ));

			add_filter('manage_users_columns', array( $this, 'af_c_f_modify_user_table' ));
			add_filter('manage_users_custom_column', array( $this, 'af_c_f_modify_user_table_row' ), 10, 3);
			add_filter('user_row_actions', array( $this, 'af_c_f_user_row_actions' ), 10, 2);
			add_action('load-users.php', array( $this, 'af_c_f_update_action' ));
			add_action('restrict_manage_users', array( $this, 'af_c_f_status_filter' ), 10, 1);
			add_action('pre_user_query', array( $this, 'af_c_f_filter_user_by_status' ));
			add_action('admin_footer-users.php', array( $this, 'af_c_f_admin_footer' ));
			add_action('load-users.php', array( $this, 'af_c_f_bulk_action_user' ));

			add_action('wp_ajax_af_c_f_save_df_form', array( $this, 'af_c_f_save_df_form' ));
			add_action('wp_ajax_nopriv_af_c_f_save_df_form', array( $this, 'af_c_f_save_df_form' ));

			add_action('woocommerce_admin_order_data_after_billing_address', array( $this, 'af_c_f_custom_checkout_field_display_admin_order_meta' ), 10, 1);

			add_action('add_meta_boxes', array( $this, 'af_c_f_review_order_meta' ), 100);

			add_filter('post_row_actions', array( $this, 'af_c_f_fields_row_actions' ), 10, 2);
		}//end __construct()
		public function af_c_f_custom_menu_admin() {

			add_submenu_page(
				'woocommerce',
				esc_html__('Custom Fields', 'af_custom_fields'),
				esc_html__('Custom Fields', 'af_custom_fields'),
				'manage_options',
				'af-custom-fields-settings',
				array( $this, 'af_c_f_settings_page' )
			);

			global $typenow, $pagenow;

			if ( ( ( 'edit.php' === $pagenow || 'post-new.php' == $pagenow ) && 'af_c_fields' === $typenow )
				|| ( 'post.php' === $pagenow && isset( $_GET['post'] ) && 'af_c_fields' === get_post_type( sanitize_text_field( $_GET['post'] ) ) ) ) {

				remove_submenu_page( 'woocommerce', 'af-custom-fields-settings' );

			} elseif ( ( ( 'admin.php' === $pagenow ) && isset( $_GET['page'] ) && 'af-custom-fields-settings' === sanitize_text_field( $_GET['page'] ) ) ) {

				remove_submenu_page( 'woocommerce', 'edit.php?post_type=af_c_fields' );

			} else {

				remove_submenu_page( 'woocommerce', 'edit.php?post_type=af_c_fields' );
			}
		}//end af_c_f_custom_menu_admin()


		public function af_c_f_settings_page() {

			

			if (isset($_GET['tab'])) {
				$active_tab = sanitize_text_field($_GET['tab']);
			} else {
				$active_tab = 'tab_one';
			}

			if (isset($_GET['subtab'])) {
				$subtab = sanitize_text_field($_GET['subtab']);
			} else {
				$subtab = 'title';
			}

			?>
			<div class="wrap">

				<?php settings_errors(); ?>

				<form method="post" action="options.php">
					<?php
					if ('tab_one' == $active_tab) {
						settings_fields('setting-group-1');
						do_settings_sections('addify-registration-1');
					}

					if ('tab_two' == $active_tab) {
						settings_fields('setting-group-2');
						do_settings_sections('addify-registration-2');
					}

					if ('tab_three' == $active_tab) {
						settings_fields('setting-group-3');
						do_settings_sections('addify-registration-3');
					}

					if ('tab_four' == $active_tab) {
						settings_fields('setting-group-4');
						do_settings_sections('addify-registration-4');
					}

					if ('tab_five' == $active_tab) {
						include_once AF_CF_PLUGIN_DIR . 'admin/settings/checkout.php';
					}
					if ('default_fields' != $active_tab) {
						submit_button(esc_html__('Save Settings', 'af_custom_fields'), 'primary', 'af_custom_fields_save_settings'); 
					}
					?>
				</form>

			</div>
			<?php
			if ('default_fields' == $active_tab) {

				require AF_CF_PLUGIN_DIR . 'admin/afreg_def_admin.php';
			}
		}//end af_c_f_settings_page()

		public function af_a_nd_s_m_tabs() {

			global $post, $typenow, $pagenow;

			$screen = get_current_screen();

		// handle tabs on the relevant WooCommerce pages

			if ( $screen && in_array( $screen->id, $this->get_tab_screen_ids(), true ) ) {

				$tabs = array(
					'rules'          => array(
						'title' => __( 'Rules', 'addify_avsm' ),
						'url'   => admin_url( 'edit.php?post_type=af_c_fields' ),
					),
					'tab_one'        => array(
						'title' => __( 'General Settings', 'addify_avsm' ),
						'url'   => admin_url( 'admin.php?page=af-custom-fields-settings&tab=tab_one' ),
					),
					'tab_two'        => array(
						'title' => __( 'User Role Settings', 'addify_avsm' ),
						'url'   => admin_url( 'admin.php?page=af-custom-fields-settings&tab=tab_two' ),
					),
					'tab_three'      => array(
						'title' => __( 'Approve New User', 'addify_avsm' ),
						'url'   => admin_url( 'admin.php?page=af-custom-fields-settings&tab=tab_three' ),
					),
					'tab_four'       => array(
						'title' => __( 'Email Settings', 'addify_avsm' ),
						'url'   => admin_url( 'admin.php?page=af-custom-fields-settings&tab=tab_four' ),
					),
					'tab_five'       => array(
						'title' => __( 'Checkout', 'addify_avsm' ),
						'url'   => admin_url( 'admin.php?page=af-custom-fields-settings&tab=tab_five' ),
					),
					'default_fields' => array(
						'title' => __( 'Default Field', 'addify_avsm' ),
						'url'   => admin_url( 'admin.php?page=af-custom-fields-settings&tab=default_fields' ),
					),

				);

				if ( is_array( $tabs ) ) {
					
					if (isset($_GET['tab'])) {
						$active_tab = sanitize_text_field($_GET['tab']);
					} else {
						$active_tab = 'tab_one';
					}

					?>
					<div class="wrap woocommerce">
						<h2><?php echo esc_html__('Custom Fields Settings', 'af_custom_fields'); ?></h2>
						<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
							<?php

							global $typenow, $pagenow;

							$current_tab = $this->get_current_tab();

							if ( 'general_settings' == $current_tab ) {
								$current_tab =  $active_tab;
							}

							foreach ( $tabs as $id => $tab_data ) {

								$class = $id === $current_tab ? array( 'nav-tab', 'nav-tab-active' ) : array( 'nav-tab' );

								printf( '<a href="%1$s" class="%2$s">%3$s</a>', esc_url( $tab_data['url'] ), implode( ' ', array_map( 'sanitize_html_class', $class ) ), esc_html( $tab_data['title'] ) );
							}
							?>
						</h2>
					</div>
					<?php
				}
			}
		}//end af_a_nd_s_m_tabs()


		public function get_current_tab() {

			$active_tab = get_current_screen();

			switch ( $active_tab->id ) {
				case 'woocommerce_page_af-custom-fields-settings':
					return 'general_settings';
				case 'edit-af_c_fields':
				case 'af_c_fields':
					return 'rules';
			}
		}//end get_current_tab()


		public function get_tab_screen_ids() {
			$tabs_screens = array(
				'woocommerce_page_af-custom-fields-settings',
				'edit-af_c_fields',
				'af_c_fields',
			);

			return $tabs_screens;
		}//end get_tab_screen_ids()


		public function af_c_f_fields_row_actions( $actions, $post ) {

			if ('af_c_fields' != $post->post_type) {
				return $actions;
			}

			unset($actions['view']);

			return $actions;
		}//end af_c_f_fields_row_actions()


		public function get_dependent_field( $par_field_id ) {

			if (empty($this->dependent_fields)) {
				return;
			}

			$dependent_fields = array();

			foreach ($this->dependent_fields as $field_id) {

				if (get_post_meta($field_id, 'af_c_f_dep_fields', true) == $par_field_id) {
					$dependent_fields[] = $field_id;
				}
			}

			if (!empty($dependent_fields)) {
				$dependent_fields = $this->get_multilevel_dependent_fields($dependent_fields);
			}

			return $dependent_fields;
		}//end get_dependent_field()


		public function get_multilevel_dependent_fields( $dependent_fields ) {

			$iterated_dependent_fields = array();

			foreach ($dependent_fields as $key => $field_id) {

				$tree_node = $this->find_tree_node_of_field_id($this->get_tree_of_fields(), $field_id);

				if (is_array($tree_node)) {

					$tree_traversal            = $this->preorder_tree_traversal($tree_node);
					$iterated_dependent_fields =  array_merge($iterated_dependent_fields, $tree_traversal);
				} else {

					array_push($iterated_dependent_fields, $field_id);
				}
			}

			return array_filter(array_unique($iterated_dependent_fields));
		}//end get_multilevel_dependent_fields()


		public function get_independent_fields() {

			$checkout_fields  = $this->get_fields();
			$dependent_fields = $this->dependent_fields;

			$independent_fields = array_diff($checkout_fields, $dependent_fields);

			return $independent_fields;
		}//end get_independent_fields()


		public function get_fields() {
			$args = array(
				'numberposts'      => -1,
				'post_type'        => 'af_c_fields',
				'post_status'      => 'publish',
				'orderby'          => 'menu_order',
				'suppress_filters' => false,
				'order'            => 'ASC',
				'fields'           => 'ids',
			);

			$fields = get_posts($args);

			return $fields;
		}//end get_fields()


		public function get_multiple_dependent_field( $par_field_id, $dependent_fields = array() ) {

			if (empty($this->dependent_fields)) {
				$this->dependent_fields = $this->get_all_dependent_fields();
			}

			if (empty($this->dependent_fields)) {
				return;
			}

			foreach ($this->dependent_fields as $field_id) {

				if (get_post_meta($field_id, 'af_c_f_dep_fields', true) == $par_field_id) {

					$dependent_fields[] = $field_id;
				}
			}

			return array_filter($dependent_fields);
		}//end get_multiple_dependent_field()


		public function get_tree_of_fields( $independent_fields = array() ) {

			if (empty($independent_fields)) {
				$independent_fields = $this->get_independent_fields();
			}

			$recursion = true;

			$tree = array();

			foreach ($independent_fields as $parent_field_id) {

				$dependent_fields = $this->get_multiple_dependent_field($parent_field_id);
				$dependent_fields = is_array($dependent_fields) ? array_filter($dependent_fields) : '';
				$post_value       = '';

				if (!empty($dependent_fields)) {

					$tree[] = array(
						'value'    => $parent_field_id,
						'children' => $this->get_tree_of_fields($dependent_fields),
					);
				} else {

					$tree[] = array(
						'value' => $parent_field_id,
					);
				}
			}

			return $tree;
		}//end get_tree_of_fields()


		public function find_tree_node_of_field_id( $tree, $field_id ) {

			$independent_fields = $this->get_independent_fields();

			foreach ($independent_fields as $field_key => $parent_field_id) {

				$all_trees_traversal = array();

				foreach ($tree as $index => $tree_data) {

					if ($parent_field_id == $this->visit_node($tree_data)) {

						$tree_elements = $this->preorder_tree_traversal($tree_data);

						if (in_array($field_id, $tree_elements)) {

							if ($field_id == $parent_field_id) {
								return $tree_data;
							} else {
								$tree_node = $this->find_node_in_tree(array( $tree_data ), array(), $field_id);
								return $tree_node;
							}
						}
					}
				}
			}
		}//end find_tree_node_of_field_id()


		public function visit_node( array $node ) {
			return isset($node['value']) ? $node['value'] : '';
		}//end visit_node()


		public function preorder_tree_traversal( array $node, $find_id = 0 ) {

			if (empty($traversed_nodes)) {
				$traversed_nodes = array();
			}

			array_push($traversed_nodes, $this->visit_node($node));

			if (!empty($find_id) && $find_id == $this->visit_node($node)) {
				return $node;
			}

			if (!empty($node['children'])) {

				foreach ($node['children'] as $child) {

					$traversed_nodes =  array_merge($traversed_nodes, $this->preorder_tree_traversal($child));
				}
			}

			return $traversed_nodes;
		}//end preorder_tree_traversal()


		public function find_node_in_tree( array $queue, array $output = array(), $find_id = 0 ) {

			if (count($queue) === 0) {
				return $output;
			}

			// Take the first item from the queue and visit it.
			$node = array_shift($queue);

			if (!empty($find_id) && $find_id == $this->visit_node($node)) {
				return $node;
			}

			$output[] = $this->visit_node($node);

			// Add any children to the queue.
			if (!empty($node['children'])) {
				foreach ($node['children'] as $child) {
					$queue[] = $child;
				}
			}

			// Repeat the algorithm with the rest of the queue.
			return $this->find_node_in_tree($queue, $output, $find_id);
		}//end find_node_in_tree()


		public function get_all_dependent_fields() {

			$args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'af_c_fields',
				'post_status'      => 'publish',
				'orderby'          => 'menu_order',
				'suppress_filters' => false,
				'order'            => 'ASC',
				'meta_key'         => 'af_c_f_dependable',
				'meta_value'       => 'yes',
				'fields'           => 'ids',
			);

			return get_posts($args);
		}//end get_all_dependent_fields()


		

		public function af_c_f_review_order_meta() {

			$af_checkout = new AF_C_F_Checkout();

			$checkout_fields = $af_checkout->get_checkout_fields();

			if (empty($checkout_fields)) {
				return;
			}

			add_meta_box(
				'ac-cf-checkout-meta',
				esc_html__('Checkout Custom Fields Data', 'af_custom_fields'),
				array( $this, 'review_checkout_fields_data' ),
				'shop_order',
				'normal',
				'high'
			);
		}//end af_c_f_review_order_meta()


		public function review_checkout_fields_data() {

			$af_checkout = new AF_C_F_Checkout();

			global $post;

			$checkout_fields = $af_checkout->get_checkout_fields();

			$checkout_data = $af_checkout->get_order_meta($post->ID);

			if (!empty($checkout_data)) {
				include_once AF_CF_PLUGIN_DIR . 'admin/meta-boxes/order/custom-fields.php';
			}
		}//end review_checkout_fields_data()


		public function af_c_f_admin_scripts() {


			wp_enqueue_style( 'af_a_nd_s_m_f_link_ty', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', false, '4.7.0', false );
			
			wp_enqueue_script('color-spectrum-js', plugins_url('/js/af-c-f-color-spectrum.js', __FILE__), array( 'jquery' ), '1.0.0', false);
			wp_enqueue_style('color-spectrum-css', plugins_url('/css/af-c-f-color-spectrum.css', __FILE__), array(), '1.0.0');
			wp_enqueue_style('afreg-admin-css', plugins_url('/css/af-c-f-admin.css', __FILE__), array(), '1.0.0');


			wp_enqueue_script('jquery-ui-accordion');
			wp_enqueue_script('jquery-ui-sortable');


			$screen = get_current_screen();

			// if (!empty($screen) && 'af_c_fields' == $screen->post_type) {

			wp_enqueue_style('wc-select2', plugins_url('assets/css/select2.css', WC_PLUGIN_FILE), array(), '5.7.2');
			wp_enqueue_script('wc-select2', plugins_url('assets/js/select2/select2.min.js', WC_PLUGIN_FILE), array( 'jquery' ), '4.0.3', true);
			// }

			wp_enqueue_script('afreg-admin-js', plugins_url('/js/af-c-f-admin.js', __FILE__), array( 'jquery' ), '1.0.0', false);

			$current_link = '';
			$af_c_f_data  = array(
				'admin_url' => admin_url('admin-ajax.php'),
				'nonce'     => wp_create_nonce('afreg-ajax-nonce'),
				'url'       => $current_link,

			);
			wp_localize_script('afreg-admin-js', 'af_c_f_php_vars', $af_c_f_data);
		}//end af_c_f_admin_scripts()


		public function af_c_f_custom_checkout_field_display_admin_order_meta( $order ) {

			$af_c_f_args = array(
				'posts_per_page' => -1,
				'post_type'      => 'af_c_fields',
				'post_status'    => 'publish',
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'fields'         => 'ids',
			);

			$af_c_f_extra_fields = get_posts($af_c_f_args);

			foreach ($af_c_f_extra_fields as $field_id) {

				$af_c_f_field               = get_post($field_id);
				$af_c_f_field_type          = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
				$af_c_f_field_order_details = get_post_meta(intval($field_id), 'af_c_f_field_order_details', true);
				$afregcheck                 = get_user_meta($order->get_customer_id(), 'af_c_f_additional_' . intval($field_id), true);

				if (!empty($afregcheck) && 'on' == $af_c_f_field_order_details) {

					$value = get_user_meta($order->get_customer_id(), 'af_c_f_additional_' . intval($field_id), true);

					if ('checkbox' == $af_c_f_field_type) {
						if ('yes' == $value) {
							echo '<p><b>' . esc_html__($af_c_f_field->post_title . ': ', 'af_custom_fields') . '</b>' . esc_html__('Yes', 'af_custom_fields') . '</p>';
						} else {
							echo '<p><b>' . esc_html__($af_c_f_field->post_title . ': ', 'af_custom_fields') . '</b>' . esc_html__('No', 'af_custom_fields') . '</p>';
						}
					} elseif ('fileupload' == $af_c_f_field_type) {

						$value = '<p>' . esc_url(AF_CF_UPLOAD_URL . $value) . '</p>';
						echo '<p><b>' . esc_html__($af_c_f_field->post_title . ': ', 'af_custom_fields') . '</b>' . esc_attr($value) . '</p>';
					} elseif (in_array($af_c_f_field_type, array( 'multiselect', 'multi_checkbox', 'select', 'radio' ))) {
						$val_array            = explode(',', $value);
						$af_c_f_field_options = ( get_post_meta(intval($field_id), 'af_c_f_field_option', true) );
						$value                = '';
						foreach ($val_array as $option_val) {
							foreach ($af_c_f_field_options as $field_id_option) {
								if (esc_attr($option_val) == $field_id_option['field_value']) {
									$value .=  $field_id_option['field_text'] . ', ';
								}
							}
						}

						echo '<p><b>' . esc_html__($af_c_f_field->post_title . ': ', 'af_custom_fields') . '</b>' . esc_attr($value) . '</p>';
					} elseif ('timepicker' == $af_c_f_field_type) {

						echo '<p><b>' . esc_html__($af_c_f_field->post_title . ': ', 'af_custom_fields') . '</b><input type="time" value="' . esc_attr($value) . '" readonly="readonly"></p>';
					} else {
						echo '<p><b>' . esc_html__($af_c_f_field->post_title . ': ', 'af_custom_fields') . '</b>' . esc_attr($value) . '</p>';
					}
				}
			}
		}//end af_c_f_custom_checkout_field_display_admin_order_meta()


		public function af_c_f_register_metaboxes() {

			add_meta_box('af_c_f_field_details', esc_html__('Field Details', 'af_custom_fields'), array( $this, 'af_c_f_field_details_callback' ), 'af_c_fields', 'normal', 'high');
			add_meta_box('af_c_field_formating', esc_html__('Field Formating', 'af_custom_fields'), array( $this, 'af_c_f_field_formating_callback' ), 'af_c_fields', 'normal', 'high');
			add_meta_box('af_c_field_user_role', esc_html__('Field Dependency', 'af_custom_fields'), array( $this, 'af_c_f_field_user_role_callback' ), 'af_c_fields', 'normal', 'high');
			add_meta_box(
				'af_c_field_pricing',
				esc_html__('Field Pricing', 'af_custom_fields'),
				array( $this, 'af_c_f_field_pricing_callback' ),
				'af_c_fields',
				'normal',
				'high'
			);
			add_meta_box(
				'af_c_field_status', 
				esc_html__('Field Status', 'af_custom_fields'), 
				array( $this, 'af_c_f_field_status_callback' ),
				'af_c_fields', 
				'side',
				'high'
			);

			add_meta_box(
				'af_c_field_products',
				esc_html__('Field Products and Categories', 'af_checkout_fields'),
				array( $this, 'af_c_field_products_callback' ),
				'af_c_fields',
				'normal',
				'high'
			);
		}//end af_c_f_register_metaboxes()


		public function af_c_field_products_callback() {

			global $post;


			$af_c_f_field_products      = (array) get_post_meta($post->ID, 'af_c_f_field_products', true);
			$af_c_f_field_categories    = (array) get_post_meta($post->ID, 'af_c_f_field_categories', true);
			$af_c_f_field_tags          = (array) get_post_meta($post->ID, 'af_c_f_field_tags', true);
			$af_a_and_va_s_product_tags = get_terms( array( 'taxonomy' => 'product_tag' ) );

			?>
			<div class="afcs_table_list">
				<table class="wp-list-table widefat table-view-list">
					<tbody>
						
						<tr>
							<th>
								<label for="af_c_f_field_products"><?php echo esc_html__('Field Products', 'af_checkout_fields'); ?></label>
							</th>
							<td>
								<select name="af_c_f_field_products[]" class="af_c_f_field_products" multiple style="width: 80%;">
									<?php
									foreach ((array) $af_c_f_field_products as $product_id) :
										$product = wc_get_product($product_id);

										if (!$product) {
											continue;
										}
										?>
										<option value="<?php echo intval($product_id); ?>" selected>
											<?php echo esc_html($product->get_name()); ?>
										</option>
									<?php endforeach; ?>
								</select>
								<p class="description">
									<?php esc_html_e('Field will be visible when selected products are in cart. Leave empty for none.', 'af_checkout_fields'); ?>
								</p>
							</td>
						</tr>
						<tr>
							<th>
								<label for="af_c_f_field_categories"><?php echo esc_html__('Field Categories', 'af_checkout_fields'); ?></label>
							</th>
							<td>
								<select name="af_c_f_field_categories[]" class="af_c_f_field_categories" multiple style="width: 80%;">
									<?php
									foreach ((array) $af_c_f_field_categories   as $cat_id) :
										$term = get_term_by('id', $cat_id, 'product_cat');
										if (!is_a($term, 'WP_Term')) {
											continue;
										}
										?>
										<option value="<?php echo intval($cat_id); ?>" selected>
											<?php echo esc_html($term->name); ?>
										</option>
									<?php endforeach; ?>
								</select>
								<p class="description">
									<?php esc_html_e('Field will be visible when selected categories are in cart. Leave empty for none.', 'af_checkout_fields'); ?>
								</p>
							</td>
						</tr>

						<tr>
							<th>
								<label for="af_c_f_field_tags"><?php echo esc_html__('Field Tags', 'af_checkout_fields'); ?></label>
								
							</th>
							<td>
								<select name="af_c_f_field_tags[]" class="af_c_f_field_tags" multiple style="width: 80%;">

									<?php foreach ( $af_a_and_va_s_product_tags as $product_tag ) { ?>

										<option value="<?php echo esc_html( $product_tag->term_id ); ?>"
											<?php 
											if ( in_array( (string) $product_tag->term_id, (array) $af_c_f_field_tags, true ) ) {
												echo 'selected'; } 
											?>
												><?php echo esc_html( $product_tag->name ); ?>

											</option>
											<?php
									}
									?>
									</select>
									<p class="description">
										<?php esc_html_e('Field will be visible when selected tags are in cart. Leave empty for none.', 'af_checkout_fields'); ?>
									</p>

								</td>
							</tr>
						</tbody>
					</table>
			</div>
				<?php
		}//end af_c_field_products_callback()


		public function af_c_f_field_pricing_callback() {

			global $post;

			$af_c_f_field_price         = get_post_meta($post->ID, 'af_c_f_field_price', true);
			$af_c_f_field_price_type    = get_post_meta($post->ID, 'af_c_f_field_price_type', true);
			$af_c_f_field_price_taxable = get_post_meta($post->ID, 'af_c_f_field_price_taxable', true);

			?>
			<div class="af_custom_fields">
				<div class="meta_field_full af_c_f_field_price">
					<label for="af_c_f_field_price"><?php echo esc_html__('Field Price', 'af_custom_fields'); ?></label>
					<input type="number" min="0" name="af_c_f_field_price" value="<?php echo esc_attr($af_c_f_field_price); ?>">
					<p class="description"><?php esc_html_e('Add price of field. Leave empty for none.', 'af_custom_fields'); ?></p>
				</div>
				<div class="meta_field_full">
					<label for="af_c_f_field_price_type"><?php echo esc_html__('Price Type', 'af_custom_fields'); ?></label>
					<select name="af_c_f_field_price_type">
						<option value="fixed" <?php echo selected($af_c_f_field_price_type, 'fixed'); ?>>
							<?php esc_html_e('Fixed', 'af_custom_fields'); ?>
						</option>
						<option value="percentage" <?php echo selected($af_c_f_field_price_type, 'percentage'); ?>>
							<?php esc_html_e('Percentage', 'af_custom_fields'); ?>
						</option>
					</select>
					<p class="description">
						<?php esc_html_e('Add type of price. Fixed price or percentage of subtotal of cart.', 'af_custom_fields'); ?>
					</p>
				</div>
				<div class="meta_field_full af_c_f_field_price">
					<label for="af_c_f_field_price_taxable"><?php echo esc_html__('Taxable Price', 'af_custom_fields'); ?></label>
					<select name="af_c_f_field_price_taxable">
						<option value="no" <?php echo selected($af_c_f_field_price_taxable, 'no'); ?>>
							<?php esc_html_e('No', 'af_custom_fields'); ?>
						</option>
						<option value="yes" <?php echo selected($af_c_f_field_price_taxable, 'yes'); ?>>
							<?php esc_html_e('Yes', 'af_custom_fields'); ?>
						</option>
					</select>
					<p class="description"><?php esc_html_e('Is price Taxable?', 'af_custom_fields'); ?></p>
				</div>
			</div>
			<?php
		}//end af_c_f_field_pricing_callback()


		public function af_c_f_field_details_callback() {
			global $post;
			wp_nonce_field('af_c_f_nonce_action', 'af_c_f_nonce_field');
			$af_c_f_field_type = get_post_meta($post->ID, 'af_c_f_field_type', true);

			$af_c_f_field_options = (array) ( get_post_meta($post->ID, 'af_c_f_field_option', true) );


			$af_c_f_field_file_size = get_post_meta($post->ID, 'af_c_f_field_file_size', true);
			$af_c_f_field_file_type = get_post_meta($post->ID, 'af_c_f_field_file_type', true);
			$af_c_f_vat_type        = get_post_meta($post->ID, 'af_c_f_vat_type', true);
			$af_c_f_vat_length      = get_post_meta($post->ID, 'af_c_f_vat_length', true);
			?>
			<div class="af_custom_fields">
				<div class="meta_field_full">
					<label for="af_c_f_field_label"><?php echo esc_html__('Field Label', 'af_custom_fields'); ?></label>
					<p class="af_c_f_field_label_msg">
						<?php echo esc_html__('Enter the text in above title field, that will become field label.', 'af_custom_fields'); ?>
					</p>
				</div>

				<div class="meta_field_full">
					<label for="af_c_f_field_type"><?php echo esc_html__('Field Type', 'af_custom_fields'); ?></label>
					<select name="af_c_f_field_type" id="af_c_f_field_type" class="af_c_f_field_select"
					onchange="af_c_f_show_options(this.value)">

					<option value="text" <?php echo selected(esc_attr($af_c_f_field_type), 'text'); ?>>
						<?php echo esc_html__('Text', 'af_custom_fields'); ?>
					</option>
					<option value="textarea" <?php echo selected(esc_attr($af_c_f_field_type), 'textarea'); ?>>
						<?php echo esc_html__('Textarea', 'af_custom_fields'); ?>
					</option>
					<option value="email" <?php echo selected(esc_attr($af_c_f_field_type), 'email'); ?>>
						<?php echo esc_html__('Email', 'af_custom_fields'); ?>
					</option>
					<option value="select" <?php echo selected(esc_attr($af_c_f_field_type), 'select'); ?>>
						<?php echo esc_html__('Select (dropdown)', 'af_custom_fields'); ?>
					</option>
					<option value="multiselect" <?php echo selected(esc_attr($af_c_f_field_type), 'multiselect'); ?>>
						<?php echo esc_html__('Multi Selectbox', 'af_custom_fields'); ?>
					</option>
					<option value="checkbox" <?php echo selected(esc_attr($af_c_f_field_type), 'checkbox'); ?>>
						<?php echo esc_html__('Checkbox', 'af_custom_fields'); ?>
					</option>
					<option value="multi_checkbox" <?php echo selected(esc_attr($af_c_f_field_type), 'multi_checkbox'); ?>>
						<?php echo esc_html__('Multi Checkbox', 'af_custom_fields'); ?>
					</option>
					<option value="radio" <?php echo selected(esc_attr($af_c_f_field_type), 'radio'); ?>>
						<?php echo esc_html__('Radio Button', 'af_custom_fields'); ?>
					</option>
					<option value="number" <?php echo selected(esc_attr($af_c_f_field_type), 'number'); ?>>
						<?php echo esc_html__('Number', 'af_custom_fields'); ?>
					</option>
					<option value="password" <?php echo selected(esc_attr($af_c_f_field_type), 'password'); ?>>
						<?php echo esc_html__('Password', 'af_custom_fields'); ?>
					</option>
					<option value="fileupload" <?php echo selected(esc_attr($af_c_f_field_type), 'fileupload'); ?>>
						<?php echo esc_html__('File Upload (Supports my account registration page only)', 'af_custom_fields'); ?>

					</option>
					<option value="color" <?php echo selected(esc_attr($af_c_f_field_type), 'color'); ?>>
						<?php echo esc_html__('Color Picker', 'af_custom_fields'); ?>
					</option>
					<option value="datepicker" <?php echo selected(esc_attr($af_c_f_field_type), 'datepicker'); ?>>
						<?php echo esc_html__('Date Picker', 'af_custom_fields'); ?>
					</option>
					<option value="timepicker" <?php echo selected(esc_attr($af_c_f_field_type), 'timepicker'); ?>>
						<?php echo esc_html__('Time Picker', 'af_custom_fields'); ?>
					</option>
					<option value="vat" <?php echo selected(esc_attr($af_c_f_field_type), 'vat'); ?>>
						<?php echo esc_html__('VAT Field', 'af_custom_fields'); ?>
					</option>
					<option value="heading" <?php echo selected(esc_attr($af_c_f_field_type), 'heading'); ?>>
						<?php echo esc_html__('Heading', 'af_custom_fields'); ?>
					</option>
					<option value="message" <?php echo selected(esc_attr($af_c_f_field_type), 'message'); ?>>
						<?php echo esc_html__('Message', 'af_custom_fields'); ?>
					</option>
					<option value="privacy" <?php echo selected(esc_attr($af_c_f_field_type), 'privacy'); ?>>
						<?php echo esc_html__('Privacy Text', 'af_custom_fields'); ?>
					</option>
					<option value="googlecaptcha" <?php echo selected(esc_attr($af_c_f_field_type), 'googlecaptcha'); ?>>
						<?php echo esc_html__('Google reCAPTCHA', 'af_custom_fields'); ?>
					</option>

				</select>
			</div>

			<div id="af_c_f_vat_type" class=" af_c_f_vat meta_field_full">
				<label for="af_c_f_vat_type"><?php echo esc_html__('VAT Validation Type', 'af_custom_fields'); ?></label>
				<select name="af_c_f_vat_type" class=" af_c_f_vat_type af_c_f_field_select">
					<option value="none" <?php echo selected(esc_attr($af_c_f_vat_type), 'none'); ?>>
						<?php echo esc_html__('None', 'af_custom_fields'); ?>
					</option>
					<option value="length" <?php echo selected(esc_attr($af_c_f_vat_type), 'length'); ?>>
						<?php echo esc_html__('Length', 'af_custom_fields'); ?>
					</option>
					<option value="vies" <?php echo selected(esc_attr($af_c_f_vat_type), 'vies'); ?>>
						<?php echo esc_html__('VIES Validation', 'af_custom_fields'); ?>
					</option>
				</select>
			</div>

			<div id="af_c_f_vat_length" class="af_c_f_vat meta_field_full">
				<label for="af_c_f_vat_length"><?php echo esc_html__('VAT Length', 'af_custom_fields'); ?></label>
				<input type="number" name="af_c_f_vat_length" class="af_c_f_vat_length"
				value="<?php echo esc_attr($af_c_f_vat_length); ?>" />
			</div>

			<div id="af_c_f_recaptcha" class="meta_field_full">
				<p class="af_c_f_field_label_msg">
					<?php echo esc_html__('For google reCaptcha field you must enter correct site key and secret key in our module settings. Without these keys google reCaptcha will not work.', 'af_custom_fields'); ?>
				</p>
			</div>

			<div class="meta_field_full af_c_f_fileupload">
				<label
				for="af_c_f_field_file_size"><?php echo esc_html__('File Upload Size(MB)', 'af_custom_fields'); ?></label>
				<input type="number" min="1" step="any" name="af_c_f_field_file_size" id="af_c_f_field_file_size" class=""
				value="<?php echo esc_attr($af_c_f_field_file_size); ?>" />
			</div>

			<div class="meta_field_full af_c_f_fileupload">
				<label
				for="af_c_f_field_file_type"><?php echo esc_html__('Allowed File Types(Add Comma(,) separated types. e.g png,jpg,gif)', 'af_custom_fields'); ?></label>
				<input type="text" name="af_c_f_field_file_type" id="af_c_f_field_file_type" class="af_c_f_field_text"
				value="<?php echo esc_attr($af_c_f_field_file_type); ?>" />
			</div>

			<div class="meta_field_full" id="af_c_f_field_options">
				<label for="af_c_f_field_options"><?php echo esc_html__('Field Options', 'af_custom_fields'); ?></label>
				<div class="af_c_f_field_options">
					<table cellspacing="0" cellpadding="0" border="1" width="100%">
						<thead>
							<tr>
								<th><?php echo esc_html__('Option Value', 'af_custom_fields'); ?></th>
								<th><?php echo esc_html__('Field Label/Text', 'af_custom_fields'); ?></th>
								<th><?php echo esc_html__('Option Price', 'af_custom_fields'); ?></th>
								<th><?php echo esc_html__('Is price Taxable?', 'af_custom_fields'); ?></th>
								<th><?php echo esc_html__('Action', 'af_custom_fields'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php

							if (!empty($af_c_f_field_options)) {
								foreach ($af_c_f_field_options as $af_c_f_a => $field_id_option) {

									$field_price_taxable = isset($field_id_option['option_price_taxable']) ? $field_id_option['option_price_taxable'] : '';

									$option_price = isset($field_id_option['option_price']) ? $field_id_option['option_price'] : '';

									$field_value = isset($field_id_option['field_value']) ? $field_id_option['field_value'] : '';

									$field_text = isset($field_id_option['field_text']) ? $field_id_option['field_text'] : '';
									?>
									<tr>
										<td>
											<input type="text" name="af_c_f_field_option[<?php echo intval($af_c_f_a); ?>][field_value]"
											id="af_c_f_field_option_value<?php echo intval($af_c_f_a); ?>" class="option_field"
											value="<?php echo esc_attr($field_value); ?>" />
										</td>
										<td>
											<input type="text" name="af_c_f_field_option[<?php echo intval($af_c_f_a); ?>][field_text]"
											id="af_c_f_field_option_value<?php echo intval($af_c_f_a); ?>" class="option_field"
											value="<?php echo esc_attr($field_text); ?>" />
										</td>
										<td>
											<input type="number" min="0"
											name="af_c_f_field_option[<?php echo intval($af_c_f_a); ?>][option_price]"
											id="af_c_f_field_option_price<?php echo intval($af_c_f_a); ?>" class="option_field"
											value="<?php echo esc_attr($option_price); ?>" />
										</td>
										<td>
											<input type="checkbox"
											name="af_c_f_field_option[<?php echo intval($af_c_f_a); ?>][option_price_taxable]"
											id="af_c_f_field_option_price_taxable<?php echo intval($af_c_f_a); ?>" class=""
											value="yes" <?php echo checked('yes', $field_price_taxable); ?> />
										</td>
										<td><button type="button" class="button button-danger"
											onclick="jQuery(this).closest('tr').remove();"><?php echo esc_html__('Remove Option', 'af_custom_fields'); ?></button>
										</td>
									</tr>
									<?php
								}
							} 


							?>
						</tbody>
						<tfoot>
							<tr id="NewField"></tr>
						</tfoot>

					</table>

					<div class="af_c_f_addbt"><button type="button" class="button-primary"
						onclick="af_c_f_add_option()"><?php echo esc_html__('Add New Option', 'af_custom_fields'); ?></button>
					</div>
				</div>
			</div>

		</div>

		<?php
		}//end af_c_f_field_details_callback()


		public function af_c_f_field_formating_callback() {
			global $post;

			$af_c_f_field_required      = get_post_meta($post->ID, 'af_c_f_field_required', true);
			$af_c_f_field_read_only     = get_post_meta($post->ID, 'af_c_f_field_read_only', true);
			$af_c_f_field_order_details = get_post_meta($post->ID, 'af_c_f_field_order_details', true);
			$af_c_f_field_width         = get_post_meta($post->ID, 'af_c_f_field_width', true);
			$af_c_f_field_placeholder   = get_post_meta($post->ID, 'af_c_f_field_placeholder', true);
			$af_c_f_field_description   = get_post_meta($post->ID, 'af_c_f_field_description', true);
			$af_c_f_field_css           = get_post_meta($post->ID, 'af_c_f_field_css', true);
			$af_c_f_heading_tag         = get_post_meta($post->ID, 'af_c_f_heading_tag', true);
			$af_c_f_field_text          = get_post_meta($post->ID, 'af_c_f_field_text', true);

			?>
			<div class="af_custom_fields">
				<div class="meta_field_formating af_c_f_heading">
					<label for="af_c_f_heading_tag"><?php echo esc_html__('Heading Tag', 'af_custom_fields'); ?></label>
					<br>
					<input type="radio" name="af_c_f_heading_tag" value="h1"
					<?php echo checked(esc_attr($af_c_f_heading_tag), 'h1'); ?> /> H1
					<input type="radio" name="af_c_f_heading_tag" value="h2"
					<?php echo checked(esc_attr($af_c_f_heading_tag), 'h2'); ?> /> H2
					<input type="radio" name="af_c_f_heading_tag" value="h3"
					<?php echo checked(esc_attr($af_c_f_heading_tag), 'h3'); ?> /> H3
					<input type="radio" name="af_c_f_heading_tag" value="h4"
					<?php echo checked(esc_attr($af_c_f_heading_tag), 'h4'); ?> /> H4
					<input type="radio" name="af_c_f_heading_tag" value="h5"
					<?php echo checked(esc_attr($af_c_f_heading_tag), 'h5'); ?> /> H5
					<input type="radio" name="af_c_f_heading_tag" value="h6"
					<?php echo checked(esc_attr($af_c_f_heading_tag), 'h6'); ?> /> H6
				</div>
				<div class="meta_field_formating af_c_f_field_text">
					<label for="af_c_f_field_text"><?php echo esc_html__('Text', 'af_custom_fields'); ?></label>
					<br>
					<?php
					$content     = wpautop(wptexturize($af_c_f_field_text));
					$editor_name = 'af_c_f_field_text';
					$editor_id   = 'af_c_f_field_text';
					$settings    = array(
						// Disable autop if the current post has blocks in it.
						'wpautop'             => false,
						'media_buttons'       => false,
						'default_editor'      => '',
						'drag_drop_upload'    => false,
						'textarea_name'       => $editor_name,
						'textarea_rows'       => 10,
						'tabindex'            => '',
						'tabfocus_elements'   => ':prev,:next',
						'editor_css'          => '',
						'editor_class'        => '',
						'teeny'               => false,
						'_content_editor_dfw' => false,
						'tinymce'             => true,
						'quicktags'           => true,
					);

					wp_editor($content, $editor_id, $settings);
					?>
				</div>

				<div class="meta_field_formating af_c_f_recaptchahide">
					<label for="af_c_f_field_required"><?php echo esc_html__('Required Field', 'af_custom_fields'); ?></label>
					<input type="checkbox" name="af_c_f_field_required" id="af_c_f_field_required"
					<?php echo checked(esc_attr($af_c_f_field_required), 'on'); ?> />
				</div>
				<div class="meta_field_formating af_c_f_recaptchahide">
					<label
					for="af_c_f_field_read_only"><?php echo esc_html__('Read Only Field(Customer can not update this from My Account page)', 'af_custom_fields'); ?></label>
					<input type="checkbox" name="af_c_f_field_read_only" id="af_c_f_field_read_only"
					<?php echo checked(esc_attr($af_c_f_field_read_only), 'on'); ?> />
				</div>

				<div class="meta_field_formating af_c_f_recaptchahide">
					<label
					for="af_c_f_field_order_details"><?php echo esc_html__('Show in admin order detail page and order email', 'af_custom_fields'); ?></label>
					<input type="checkbox" name="af_c_f_field_order_details" id="af_c_f_field_order_details"
					<?php echo checked(esc_attr($af_c_f_field_order_details), 'on'); ?> />
				</div>

				<div class="meta_field_formating af_c_f_recaptchahide">
					<label for="af_c_f_field_width"><?php echo esc_html__('Field Width', 'af_custom_fields'); ?></label>
					<select name="af_c_f_field_width" id="af_c_f_field_width">
						<option value="full" <?php echo selected(esc_attr($af_c_f_field_width), 'full'); ?>>
							<?php echo esc_html__('Full Width', 'af_custom_fields'); ?>
						</option>
						<option value="half" <?php echo selected(esc_attr($af_c_f_field_width), 'half'); ?>>
							<?php echo esc_html__('Half Width', 'af_custom_fields'); ?>
						</option>
					</select>

				</div>

				<div class="meta_field_full af_c_f_recaptchahide">
					<label
					for="af_c_f_field_placeholder"><?php echo esc_html__('Field Placeholder Text', 'af_custom_fields'); ?></label>
					<input type="text" name="af_c_f_field_placeholder" id="af_c_f_field_placeholder" class="af_c_f_field_text"
					value="<?php echo esc_attr($af_c_f_field_placeholder); ?>" />
				</div>

				<div class="meta_field_full af_c_f_description">
					<label for="af_c_f_field_description"><?php echo esc_html__('Field Description', 'af_custom_fields'); ?></label>
					<textarea name="af_c_f_field_description" class="af_c_f_field_text"
					id="af_c_f_field_description"><?php echo wp_kses_post($af_c_f_field_description); ?></textarea>
				</div>

				<div class="meta_field_full af_c_f_recaptchahide">
					<label for="af_c_f_field_css"><?php echo esc_html__('Field Custom Css Class', 'af_custom_fields'); ?></label>
					<input type="text" name="af_c_f_field_css" id="af_c_f_field_css" class="af_c_f_field_text"
					value="<?php echo esc_attr($af_c_f_field_css); ?>" />
				</div>

			</div>

			<?php
		}//end af_c_f_field_formating_callback()


		public function af_c_f_field_user_role_callback() {

			global $post;

			$field_roles              = (array) get_post_meta($post->ID, 'af_c_f_field_user_roles', true);
			$field_pages              = (array) get_post_meta($post->ID, 'af_c_f_field_pages', true);
			$dep_fields               = get_post_meta($post->ID, 'af_c_f_dep_fields', true);
			$af_c_f_dependable        = get_post_meta($post->ID, 'af_c_f_dependable', true);
			$af_c_f_dependable        = empty($af_c_f_dependable) ? 'no' : $af_c_f_dependable;
			$af_c_f_dependable_values = get_post_meta($post->ID, 'af_c_f_dependable_values', true);
			$selected_location        = get_post_meta($post->ID, 'af_c_f_checkout_position', true);
			?>
			<div class="af_custom_fields">
				<div class="meta_field_formating af_c_f_user_roles">
					<label for="af_c_f_field_required"><?php echo esc_html__('Select User Roles', 'af_custom_fields'); ?></label>
					<div class="all_cats_role">
						<ul>
							<?php
							global $wp_roles;

							$roles          = $wp_roles->get_names();
							$roles['guest'] = __('Guest', 'af_custom_fields');

							if (!empty($roles)) {

								foreach ($roles as $key => $value) {
									?>
									<li class="par_cat">

										<input type="checkbox" class="parent" name="af_c_f_field_user_roles[]"
										value="<?php echo esc_attr($key); ?>" 
										<?php
										if (!empty($field_roles) && in_array($key, $field_roles)) {
											echo 'checked';
										}
										?>
										/>
										<?php echo esc_attr($value); ?>

									</li>
									<?php
								}
							}
							?>
						</ul>
					</div>

					<p class="description af_c_f_enable_user_role">
						<?php echo esc_html__('Select user roles on which you want to show this field, leave empty for show in all.', 'af_custom_fields'); ?>
					</p>
				</div>
				<div class="meta_field_formating af_c_f_dependable">

					<label for="af_c_f_field_required"><?php echo esc_html__('Is Field Dependable', 'af_custom_fields'); ?></label>
					<br>
					<input type="radio" name="af_c_f_dependable" value="yes"
					<?php checked('yes', $af_c_f_dependable); ?>><?php echo esc_html__('Yes', 'af_custom_fields'); ?>
					<br>
					<input type="radio" name="af_c_f_dependable" value="no"
					<?php checked('no', $af_c_f_dependable); ?>><?php echo esc_html__('No', 'af_custom_fields'); ?>

					<p class="description af_c_f_enable_user_role">
						<?php echo esc_html__('Is this field depend on another field?', 'af_custom_fields'); ?></p>


					</div>


					<div class="meta_field_formating af_c_f_show_on_pages independent">
						<label for="af_c_f_field_required"><?php echo esc_html__('Select Pages', 'af_custom_fields'); ?></label>

						<div class="all_cats_role">
							<ul>
								<?php

								$pages = array(
									'registration' => 'Registration',
									'my-account'   => 'My Account',
									'checkout'     => 'Checkout',
								);

								if (!empty($roles)) {

									foreach ($pages as $key => $value) {

										?>
										<li class="par_cat">

											<input type="checkbox" class="parent" name="af_c_f_field_pages[]"
											value="<?php echo esc_attr($key); ?>" 
											<?php
											if (!empty($field_pages) && in_array($key, $field_pages)) {
												echo 'checked';
											}
											?>
											/>
											<?php echo esc_attr($value); ?>

										</li>
										<?php
									}
								}
								?>
							</ul>
						</div>

						<p class="description af_c_f_enable_user_role">
							<?php echo esc_html__('Select page where you want to show field', 'af_custom_fields'); ?></p>


						</div>

						<div class="meta_field_formating af_c_f_show_with_fields dependent">
							<label for="af_c_f_field_required"><?php echo esc_html__('Select Fields', 'af_custom_fields'); ?></label>

							<br>
							<select name="af_c_f_dep_fields" class="af_c_f_dep_fields">
								<?php

								$args = array(
									'post_type'    => 'af_c_fields',
									'post_status'  => 'publish',
									'fields'       => 'ids',
									'numberposts'  => -1,
									'post__not_in' => array( $post->ID ),
									
								);

								$fields = get_posts($args);

								if (!empty($fields)) {

									foreach ($fields as $field_id) {

										$type    = get_post_meta($field_id, 'af_c_f_field_type', true);
										$options = ( get_post_meta($field_id, 'af_c_f_field_option', true) );

										if (!empty($options)) {
											$options = implode(',', array_column($options, 'field_value'));
										}

										?>
										<option data-field_type="<?php echo esc_attr($type); ?>"
											data-field_options="<?php echo esc_attr($options); ?>" value="<?php echo esc_attr($field_id); ?>" 
											<?php
											if ($field_id == $dep_fields) {
												echo 'selected';
											}
											?>
											>
											<?php echo esc_html(get_the_title($field_id)); ?>


										</option>
										<?php
									}
								}
								?>
							</select>

							<p class="description af_c_f_enable_user_role">
								<?php echo esc_html__('Select Fields. Leave empty for none.', 'af_custom_fields'); ?></p>


							</div>

							<div class="meta_field_formating af_c_f_dependable_values">
								<label for="af_c_f_field_required"><?php echo esc_html__('Enter Field Values', 'af_custom_fields'); ?></label>

								<br>
								<input type="text" name="af_c_f_dependable_values" class="af_c_f_dependable_values af_c_f_field_text"
								value="<?php echo esc_attr($af_c_f_dependable_values); ?>">

								<p class="description af_c_f_enable_user_role">
									<?php echo esc_html__('Enter comma separated values for dependency. Leave empty for all.', 'af_custom_fields'); ?>
								</p>
							</div>


							<div class="meta_field_formating af_c_f_checkout_position independent">
								<label for="af_c_f_checkout_position"><?php echo esc_html__('Checkout Position', 'af_custom_fields'); ?></label>

								<br>
								<select name="af_c_f_checkout_position" class="af_c_f_checkout_position">
									<?php

									$all_location = array(
										'woocommerce_checkout_before_customer_details'     => __('Before Customer Details', 'af_custom_fields'),
										'woocommerce_before_checkout_billing_form'         => __('Before Billing Form', 'af_custom_fields'),
										'woocommerce_after_checkout_billing_form'          => __('After Billing Form', 'af_custom_fields'),
										'woocommerce_before_checkout_shipping_form'        => __('Before Shipping Form', 'af_custom_fields'),
										'woocommerce_after_checkout_shipping_form'         => __('After Shipping Form', 'af_custom_fields'),
										'woocommerce_checkout_after_customer_details'      => __('After Customer Details', 'af_custom_fields'),
										'woocommerce_checkout_before_order_review_heading' => __('Before Order Review Heading', 'af_custom_fields'),
										'woocommerce_checkout_before_order_review'         => __('Before Order Review', 'af_custom_fields'),
										'woocommerce_checkout_after_order_review'          => __('After Order Review', 'af_custom_fields'),
										'woocommerce_before_order_notes'                   => __('Before Order Notes', 'af_custom_fields'),
										'woocommerce_after_order_notes'                    => __('After Order Notes', 'af_custom_fields'),
										'woocommerce_checkout_before_terms_and_conditions' => __('Before Terms and Conditions', 'af_custom_fields'),
										'woocommerce_checkout_after_terms_and_conditions'  => __('After Terms and Conditions', 'af_custom_fields'),
										'woocommerce_review_order_before_submit'           => __('Before Order Submit', 'af_custom_fields'),
										'woocommerce_review_order_after_submit'            => __('After Order Submit', 'af_custom_fields'),
									);

									foreach ($all_location as $hook => $label) {

										?>

										<option value="<?php echo esc_attr($hook); ?>" 
											<?php
											selected($hook, $selected_location);
											?>
											>
											<?php echo esc_html($label); ?>


										</option>
										<?php
									}
									?>
								</select>

								<p class="description af_c_f_enable_user_role">
									<?php echo esc_html__('Select Position of Field on Checkout Page.', 'af_custom_fields'); ?></p>


								</div>

							</div>
							<?php
		}//end af_c_f_field_user_role_callback()


		public function af_c_f_field_status_callback() {

			global $post;

			?>
			<div class="af_custom_fields">

				<div class="meta_field_full">
					<label for="af_c_f_field_sort_order"><?php echo esc_html__('Field Sort Order', 'af_custom_fields'); ?></label>
					<input type="number" min="0" name="af_c_f_field_sort_order" id="af_c_f_field_sort_order"
					value="<?php echo esc_attr($post->menu_order); ?>" />
				</div>
				<div class="meta_field_formating">
					<label for="af_c_f_field_status"><?php echo esc_html__('Field Status', 'af_custom_fields'); ?></label>
					<br>
					<select name="af_c_f_field_status" id="af_c_f_field_status">
						<option value="publish" <?php echo selected(esc_attr($post->post_status), 'publish'); ?>>
							<?php echo esc_html__('Active', 'af_custom_fields'); ?>
						</option>
						<option value="draft" <?php echo selected(esc_attr($post->post_status), 'draft'); ?>>
							<?php echo esc_html__('Inactive', 'af_custom_fields'); ?>
						</option>
					</select>
				</div>
			</div>
			<?php
		}//end af_c_f_field_status_callback()


		public function af_c_f_meta_box_save( $post_id ) {

			// For custom post type:
			$exclude_statuses = array(
				'auto-draft',
				'trash',
			);

			$action = isset($_GET['action']) ? sanitize_text_field(wp_unslash($_GET['action'])) : '';

			if (in_array(get_post_status($post_id), $exclude_statuses) || is_ajax() || 'untrash' === $action) {
				return;
			}

			if (isset($_POST['af_c_f_field_type'])) {

				if (!empty($_REQUEST['af_c_f_nonce_field'])) {

					$retrieved_nonce = sanitize_text_field($_REQUEST['af_c_f_nonce_field']);
				} else {
					$retrieved_nonce = 0;
				}

				if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

					die('Failed security check');
				}

				update_post_meta(intval($post_id), 'af_c_f_field_type', sanitize_text_field($_POST['af_c_f_field_type']));
			}

			remove_action('save_post_af_c_fields', array( $this, 'af_c_f_meta_box_save' ));

			if (isset($_POST['af_c_f_field_status'])) {
				wp_update_post(array(
					'ID'          => intval($post_id),
					'post_status' => sanitize_text_field($_POST['af_c_f_field_status']),
				));
			}

			if (isset($_POST['af_c_f_field_sort_order'])) {
				wp_update_post(array(
					'ID'         => intval($post_id),
					'menu_order' => sanitize_text_field($_POST['af_c_f_field_sort_order']),
				));
			}

			add_action('save_post_af_c_fields', array( $this, 'af_c_f_meta_box_save' ));


			$data = isset($_POST['af_c_f_field_option']) ?  sanitize_meta('', $_POST['af_c_f_field_option'], '') :array();

			foreach ((array) $data as $key => $value) {
				if ( !empty( $value ) ) {

					$data[ $key ] = array_map('trim', $value);
				}
			}


			update_post_meta(intval($post_id), 'af_c_f_field_option', $data);



			if (isset($_POST['af_c_f_vat_type'])) {
				update_post_meta(intval($post_id), 'af_c_f_vat_type', sanitize_text_field($_POST['af_c_f_vat_type']));
			}

			if (isset($_POST['af_c_f_vat_length'])) {
				update_post_meta(intval($post_id), 'af_c_f_vat_length', sanitize_text_field($_POST['af_c_f_vat_length']));
			}

			if (isset($_POST['af_c_f_field_required'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_required', sanitize_text_field($_POST['af_c_f_field_required']));
			} else {
				update_post_meta(intval($post_id), 'af_c_f_field_required', 'off');
			}

			if (isset($_POST['af_c_f_field_read_only'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_read_only', sanitize_text_field($_POST['af_c_f_field_read_only']));
			} else {
				update_post_meta(intval($post_id), 'af_c_f_field_read_only', 'off');
			}

			if (isset($_POST['af_c_f_field_order_details'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_order_details', sanitize_text_field($_POST['af_c_f_field_order_details']));
			} else {
				update_post_meta(intval($post_id), 'af_c_f_field_order_details', 'off');
			}

			if (isset($_POST['af_c_f_field_width'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_width', sanitize_text_field($_POST['af_c_f_field_width']));
			}

			if (isset($_POST['af_c_f_field_placeholder'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_placeholder', sanitize_text_field($_POST['af_c_f_field_placeholder']));
			}

			if (isset($_POST['af_c_f_field_description'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_description', sanitize_meta('', $_POST['af_c_f_field_description'], ''));
			}

			if (isset($_POST['af_c_f_field_css'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_css', sanitize_text_field($_POST['af_c_f_field_css']));
			}

			if (isset($_POST['af_c_f_field_file_size'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_file_size', sanitize_text_field($_POST['af_c_f_field_file_size']));
			}

			if (isset($_POST['af_c_f_field_file_type'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_file_type', sanitize_text_field($_POST['af_c_f_field_file_type']));
			}

			if (isset($_POST['af_c_f_dependable'])) {
				update_post_meta(intval($post_id), 'af_c_f_dependable', sanitize_text_field($_POST['af_c_f_dependable']));
			}

			if (isset($_POST['af_c_f_checkout_position'])) {
				update_post_meta(intval($post_id), 'af_c_f_checkout_position', sanitize_text_field($_POST['af_c_f_checkout_position']));
			}

			if (isset($_POST['af_c_f_dependable_values'])) {
				update_post_meta(intval($post_id), 'af_c_f_dependable_values', sanitize_text_field($_POST['af_c_f_dependable_values']));
			}

			if (isset($_POST['af_c_f_field_user_roles'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_user_roles', sanitize_meta('', $_POST['af_c_f_field_user_roles'], ''));
			} else {

				update_post_meta(intval($post_id), 'af_c_f_field_user_roles', array());
			}

			if (isset($_POST['af_c_f_field_products'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_products', sanitize_meta('', $_POST['af_c_f_field_products'], ''));
			} else {

				update_post_meta(intval($post_id), 'af_c_f_field_products', array());
			}

			if (isset($_POST['af_c_f_field_categories'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_categories', sanitize_meta('', $_POST['af_c_f_field_categories'], ''));
			} else {

				update_post_meta(intval($post_id), 'af_c_f_field_categories', array());
			}

			if (isset($_POST['af_c_f_field_tags'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_tags', sanitize_meta('', $_POST['af_c_f_field_tags'], ''));
			} else {

				update_post_meta(intval($post_id), 'af_c_f_field_tags', array());
			}


			if (isset($_POST['af_c_f_field_pages'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_pages', sanitize_meta('', $_POST['af_c_f_field_pages'], ''));
			} else {

				update_post_meta(intval($post_id), 'af_c_f_field_pages', array());
			}

			if (isset($_POST['af_c_f_dep_fields'])) {
				update_post_meta(intval($post_id), 'af_c_f_dep_fields', sanitize_meta('', $_POST['af_c_f_dep_fields'], ''));
			} else {

				update_post_meta(intval($post_id), 'af_c_f_dep_fields', array());
			}

			if (isset($_POST['af_c_f_is_dependable'])) {
				update_post_meta(intval($post_id), 'af_c_f_is_dependable', sanitize_text_field($_POST['af_c_f_is_dependable']));
			} else {
				update_post_meta(intval($post_id), 'af_c_f_is_dependable', 'off');
			}

			if (isset($_POST['af_c_f_heading_tag'])) {
				update_post_meta(intval($post_id), 'af_c_f_heading_tag', sanitize_text_field($_POST['af_c_f_heading_tag']));
			}

			if (isset($_POST['af_c_f_field_text'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_text', sanitize_meta('', $_POST['af_c_f_field_text'], ''));
			}

			if (isset($_POST['af_c_f_field_price'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_price', sanitize_meta('', $_POST['af_c_f_field_price'], ''));
			}

			if (isset($_POST['af_c_f_field_price_type'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_price_type', sanitize_meta('', $_POST['af_c_f_field_price_type'], ''));
			}

			if (isset($_POST['af_c_f_field_price_taxable'])) {
				update_post_meta(intval($post_id), 'af_c_f_field_price_taxable', sanitize_meta('', $_POST['af_c_f_field_price_taxable'], ''));
			}
		}//end af_c_f_meta_box_save()



		public function af_c_f_custom_columns( $columns ) {

			unset($columns['date']);
			$columns['af_c_f_field_type']       = esc_html__('Field Type', 'af_custom_fields');
			$columns['af_c_f_display_location'] = esc_html__('Display Location', 'af_custom_fields');
			$columns['af_c_f_field_status']     = esc_html__('Status', 'af_custom_fields');
			$columns['af_c_f_field_sort_order'] = esc_html__('Priority', 'af_custom_fields');

			return $columns;
		}//end af_c_f_custom_columns()


		public function af_c_f_custom_column( $column, $post_id ) {

			$af_c_f_post = get_post($post_id);

			switch ($column) {

				case 'af_c_f_field_type':
				echo esc_attr(ucwords(str_replace('_', ' ', get_post_meta($post_id, 'af_c_f_field_type', true))));
					break;

				case 'af_c_f_field_status':
					if ('publish' == $af_c_f_post->post_status) {
						echo esc_html__('Active', 'af_custom_fields');
					} else {
						esc_html__('Inactive', 'af_custom_fields');
					}
					break;

				case 'af_c_f_field_sort_order':
				echo esc_attr($af_c_f_post->menu_order);
					break;

				case 'af_c_f_display_location':
				echo esc_attr(implode(', ', (array) get_post_meta($post_id, 'af_c_f_field_pages', true)));
					break;
			}
		}//end af_c_f_custom_column()


		public function af_c_f_bulk_action( $bulk_actions ) {
			$bulk_actions['af_c_f_active']   = esc_html__('Active', 'af_custom_fields');
			$bulk_actions['af_c_f_inactive'] = esc_html__('Inactive', 'af_custom_fields');
			return $bulk_actions;
		}//end af_c_f_bulk_action()


		public function af_c_f_bulk_action_handler( $redirect_to, $action_name, $post_ids ) {

			if ('af_c_f_active' === $action_name) {

				foreach ($post_ids as $post_id) {
					wp_update_post(array(
						'ID'          => intval($post_id),
						'post_status' => 'publish',
					));
				}

				$redirect_to = add_query_arg('af_c_f_active', count($post_ids), $redirect_to);
				return $redirect_to;
			} elseif ('af_c_f_inactive' === $action_name) {

				foreach ($post_ids as $post_id) {
					wp_update_post(array(
						'ID'          => intval($post_id),
						'post_status' => 'draft',
					));
				}

				$redirect_to = add_query_arg('af_c_f_inactive', count($post_ids), $redirect_to);
				return $redirect_to;
			} else {
				return $redirect_to;
			}
		}//end af_c_f_bulk_action_handler()


		public function af_c_f_bulk_action_admin_notice() {

			if (!empty($_POST['af_c_f_nonce_action']) && !check_admin_referer('af_c_f_nonce_action', 'af_c_f_nonce_action')) {
				die('Admin Security Failed');
			}

			$af_c_f_allowed_tags = array(
				'a'      => array(
					'class' => array(),
					'href'  => array(),
					'rel'   => array(),
					'title' => array(),
				),
				'b'      => array(),

				'div'    => array(
					'class' => array(),
					'title' => array(),
					'style' => array(),
				),
				'p'      => array(
					'class' => array(),
				),
				'strong' => array(),

			);

			if (!empty($_REQUEST['af_c_f_active'])) {
				$posts_count      = intval($_REQUEST['af_c_f_active']);
				$af_c_f_woo_check = '<div id="message" class="updated notice notice-success is-dismissible"><p>' . $posts_count . ' field(s) are set to active.</p><button type="button" class="notice-dismiss"></button></div>';
				echo wp_kses(__($af_c_f_woo_check, 'af_custom_fields'), $af_c_f_allowed_tags);
			} elseif (!empty($_REQUEST['af_c_f_inactive'])) {
				$posts_count      = intval($_REQUEST['af_c_f_inactive']);
				$af_c_f_woo_check = '<div id="message" class="updated notice notice-success is-dismissible"><p>' . $posts_count . ' field(s) are set to inactive.</p><button type="button" class="notice-dismiss"></button></div>';
				echo wp_kses(__($af_c_f_woo_check, 'af_custom_fields'), $af_c_f_allowed_tags);
			}
		}//end af_c_f_bulk_action_admin_notice()





		public function af_c_f_options() {

			include_once AF_CF_PLUGIN_DIR . 'admin/settings/title.php';
			include_once AF_CF_PLUGIN_DIR . 'admin/settings/general.php';

			add_settings_section(
				'page_1_section',         // ID used to identify this section and with which to register options  
				'',   // Title to be displayed on the administration page  
				array( $this, 'af_c_f_page_1_section_callback' ), // Callback used to render the description of the section  
				'addify-registration-1'                           // Page on which to add this section of options  
			);

			add_settings_field(
				'af_c_f_additional_fields_section_title',                      // ID used to identify the field throughout the theme  
				esc_html__('Additional Fields Section Title', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_additional_fields_section_title_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-1',                          // The page on which this option will be displayed  
				'page_1_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('This is the title for the section where additional fields are displayed on front end registration form.', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-1',
				'af_c_f_additional_fields_section_title'
			);

			add_settings_section(
				'page_2_section',         // ID used to identify this section and with which to register options  
				'',   // Title to be displayed on the administration page  
				array( $this, 'af_c_f_page_2_section_callback' ), // Callback used to render the description of the section  
				'addify-registration-1'                           // Page on which to add this section of options  
			);

			add_settings_field(
				'af_c_f_site_key',                      // ID used to identify the field throughout the theme  
				esc_html__('Site Key', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_site_key_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-1',                          // The page on which this option will be displayed  
				'page_2_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('This is gogle reCaptcha site key, you can get this from google. With this key google reCaptcha will not work.', 'af_custom_fields'),
				)
			);

			register_setting(
				'setting-group-1',
				'af_c_f_site_key'
			);

			add_settings_field(
				'af_c_f_secret_key',                      // ID used to identify the field throughout the theme  
				esc_html__('Secret Key', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_secret_key_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-1',                          // The page on which this option will be displayed  
				'page_2_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('This is google reCaptcha secret key, you can get this from google. With this key google reCaptcha will not work.', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-1',
				'af_c_f_secret_key'
			);

			// Tab 2
			add_settings_section(
				'page_1_section',         // ID used to identify this section and with which to register options  
				'',   // Title to be displayed on the administration page  
				array( $this, 'af_c_f_page_22_section_callback' ), // Callback used to render the description of the section  
				'addify-registration-2'                           // Page on which to add this section of options  
			);

			add_settings_field(
				'af_c_f_enable_user_role',                      // ID used to identify the field throughout the theme  
				esc_html__('Enable User Role Selection', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_enable_user_role_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-2',                          // The page on which this option will be displayed  
				'page_1_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('Enable/Disable User Role selection on registraiton page. If this is enable then a user role dropdown will be shown on registration page.', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-2',
				'af_c_f_enable_user_role'
			);

			add_settings_field(
				'af_c_f_user_role_field_text',                      // ID used to identify the field throughout the theme  
				esc_html__('User Role Field Label', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_user_role_field_text_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-2',                          // The page on which this option will be displayed  
				'page_1_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('Field label for user role selection select box.', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-2',
				'af_c_f_user_role_field_text'
			);

			add_settings_field(
				'af_c_f_user_roles',                      // ID used to identify the field throughout the theme  
				esc_html__('Select User Roles', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_user_roles_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-2',                          // The page on which this option will be displayed  
				'page_1_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('Select which user roles you want to show in dropdown on registration page. Note: Administrator role is not available for show in dropdown.', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-2',
				'af_c_f_user_roles'
			);

			// Tab 3
			add_settings_section(
				'page_1_section',         // ID used to identify this section and with which to register options  
				'',   // Title to be displayed on the administration page  
				array( $this, 'af_c_f_page_3_section_callback' ), // Callback used to render the description of the section  
				'addify-registration-3'                           // Page on which to add this section of options  
			);

			add_settings_field(
				'af_c_f_enable_approve_user',                      // ID used to identify the field throughout the theme  
				esc_html__('Enable Approve New User', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_enable_approve_user_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-3',                          // The page on which this option will be displayed  
				'page_1_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('Enable/Disable Approve new user. When this option is enabled all new registered users will be set to Pending until admin approves', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-3',
				'af_c_f_enable_approve_user'
			);

			add_settings_field(
				'af_c_f_enable_approve_user_checkout',                      // ID used to identify the field throughout the theme  
				esc_html__('Enable Approve New User at Checkout Page', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_enable_approve_user_checkout_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-3',                          // The page on which this option will be displayed  
				'page_1_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__(' Enable/Disable Approve new user at checkout page. ', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-3',
				'af_c_f_enable_approve_user_checkout'
			);

			add_settings_field(
				'af_c_f_exclude_user_roles_approve_new_user',                      // ID used to identify the field throughout the theme  
				esc_html__('Exclude User Roles', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_exclude_user_roles_approve_new_user_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-3',                          // The page on which this option will be displayed  
				'page_1_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('Select which user roles users you want to exclude from manual approval. These user roles users will be automatically approved.', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-3',
				'af_c_f_exclude_user_roles_approve_new_user'
			);

			add_settings_section(
				'page_2_section',         // ID used to identify this section and with which to register options  
				'',   // Title to be displayed on the administration page  
				array( $this, 'af_c_f_page_33_section_callback' ), // Callback used to render the description of the section  
				'addify-registration-3'                           // Page on which to add this section of options  
			);

			add_settings_field(
				'af_c_f_user_pending_approval_message',                      // ID used to identify the field throughout the theme  
				esc_html__('Message for Users when Account is Created', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_user_pending_approval_message_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-3',                          // The page on which this option will be displayed  
				'page_2_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('First message that will be displayed to user when he/she completes the registration process, this message will be displayed only when manual approval is required. ', 'af_custom_fields'),
					esc_html__('Available placeholders are {customer-id}, {customer-email}, {user-name}, {first-name}, {last-name}, {full-name}, {user-status}.', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-3',
				'af_c_f_user_pending_approval_message'
			);

			add_settings_field(
				'af_c_f_user_approval_message',                      // ID used to identify the field throughout the theme  
				esc_html__('Message for Users when Account is pending for approval', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_user_approval_message_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-3',                          // The page on which this option will be displayed  
				'page_2_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('This will be displayed when user will attempt to login after registration and his/her account is still pending for admin approval. ', 'af_custom_fields'),
					esc_html__('Available placeholders are {customer-id}, {customer-email}, {user-name}, {first-name}, {last-name}, {full-name}, {user-status}.', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-3',
				'af_c_f_user_approval_message'
			);

			add_settings_field(
				'af_c_f_user_disapproved_message',                      // ID used to identify the field throughout the theme  
				esc_html__('Message for Users when Account is disapproved', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_user_disapproved_message_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-3',                          // The page on which this option will be displayed  
				'page_2_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('Message for Users when Account is Disapproved By Admin.', 'af_custom_fields'),
					esc_html__('Available placeholders are {customer-id}, {customer-email}, {user-name}, {first-name}, {last-name}, {full-name}, {user-status}.', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-3',
				'af_c_f_user_disapproved_message'
			);

			// Tab 4
			add_settings_section(
				'page_1_section',         // ID used to identify this section and with which to register options  
				'',   // Title to be displayed on the administration page  
				array( $this, 'af_c_f_page_4_section_callback' ), // Callback used to render the description of the section  
				'addify-registration-4'                           // Page on which to add this section of options  
			);

			add_settings_field(
				'af_c_f_admin_email_text',                      // ID used to identify the field throughout the theme  
				esc_html__('Admin Email Text', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_admin_email_text_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-4',                          // The page on which this option will be displayed  
				'page_1_section',         // The name of the section to which this field belongs  
				array(                         // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('This email text will be used when new user notification is sent to admin. If Approve new user is active then you can write text about new user approval.', 'af_custom_fields'),
					esc_html__('Available placeholders are {customer-id}, {customer-details}, {user-name}, {first-name}, {last-name}, {full-name}, {user-status}, {approval-link}, {disapprove-link}.', 'af_custom_fields'),
				)
			);

			register_setting(
				'setting-group-4',
				'af_c_f_admin_email_text'
			);

			add_settings_field(
				'af_c_f_pending_approval_email_text',                      // ID used to identify the field throughout the theme  
				esc_html__('Welcome/Pending Email Body Text', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_pending_approval_email_text_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-4',                          // The page on which this option will be displayed  
				'page_1_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('This is the email body; when a new customer registers this email be automatically sent and the custom fields will be included in that email. This body text will be included along with the default fields data.', 'af_custom_fields'),
					esc_html__('Available placeholders are {customer-id}, {customer-details}, {user-name}, {first-name}, {last-name}, {full-name}, {user-status}.', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-4',
				'af_c_f_pending_approval_email_text'
			);

			add_settings_field(
				'af_c_f_approved_email_text',                      // ID used to identify the field throughout the theme  
				esc_html__('Approved Email Text', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_approved_email_text_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-4',                          // The page on which this option will be displayed  
				'page_1_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('This is the approved email message, this message is used when account is approved by administrator. ', 'af_custom_fields'),
					esc_html__('Available placeholders are {customer-id}, {customer-details}, {user-name}, {first-name}, {last-name}, {full-name}, {user-status}.', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-4',
				'af_c_f_approved_email_text'
			);

			add_settings_field(
				'af_c_f_disapproved_email_text',                      // ID used to identify the field throughout the theme  
				esc_html__('Disapproved Email Text', 'af_custom_fields'),    // The label to the left of the option interface element  
				array( $this, 'af_c_f_disapproved_email_text_callback' ),   // The name of the function responsible for rendering the option interface  
				'addify-registration-4',                          // The page on which this option will be displayed  
				'page_1_section',         // The name of the section to which this field belongs  
				array(                              // The array of arguments to pass to the callback. In this case, just a description.  
					esc_html__('This is the disapproved email message, this message is used when account is disapproved by administrator.', 'af_custom_fields'),
					esc_html__('Available placeholders are {customer-id}, {customer-details}, {user-name}, {first-name}, {last-name}, {full-name}, {user-status}.', 'af_custom_fields'),
				)
			);
			register_setting(
				'setting-group-4',
				'af_c_f_disapproved_email_text'
			);
		}//end af_c_f_options()


		public function af_c_f_page_1_section_callback() {
			?>

			<p><?php echo esc_html__('Manage registration module general settings from here.', 'af_custom_fields'); ?></p>

			<?php
		}//end af_c_f_page_1_section_callback()
		// function af_c_f_page_1_section_callback
		public function af_c_f_additional_fields_section_title_callback( $args ) {
			?>
			<input type="text" id="af_c_f_additional_fields_section_title" class="setting_fields"
			name="af_c_f_additional_fields_section_title"
			value="<?php echo esc_attr(__(get_option('af_c_f_additional_fields_section_title'), 'af_custom_fields')); ?>">
			<p class="description af_c_f_additional_fields_section_title"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_additional_fields_section_title_callback()
		// end af_c_f_additional_fields_section_title_callback 
		public function af_c_f_page_2_section_callback() {
			?>

			<h3><?php echo esc_html__('Google reCaptcha Settings', 'af_custom_fields'); ?></h3>

			<?php
		}//end af_c_f_page_2_section_callback()
		// function af_c_f_page_2_section_callback
		public function af_c_f_site_key_callback( $args ) {
			?>
			<input type="text" id="af_c_f_site_key" class="setting_fields" name="af_c_f_site_key"
			value="<?php echo esc_attr(get_option('af_c_f_site_key')); ?>">
			<p class="description af_c_f_site_key"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_site_key_callback()
		// end af_c_f_site_key_callback 
		public function af_c_f_secret_key_callback( $args ) {
			?>
			<input type="text" id="af_c_f_secret_key" class="setting_fields" name="af_c_f_secret_key"
			value="<?php echo esc_attr(get_option('af_c_f_secret_key')); ?>">
			<p class="description af_c_f_secret_key"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_secret_key_callback()
		// end af_c_f_secret_key_callback 
		// Tab 2
		public function af_c_f_page_22_section_callback() {
			?>

			<p><?php echo esc_html__('Manage user role settings from here. Choose wheather you want to show user role dropdown on registraiton page or not and choose which user roles you want to show in dropdown on registration page.', 'af_custom_fields'); ?>
		</p>

		<?php
		}//end af_c_f_page_22_section_callback()
		// function af_c_f_page_22_section_callback
		public function af_c_f_user_role_field_text_callback( $args ) {
			?>
			<input type="text" id="af_c_f_user_role_field_text" class="setting_fields" name="af_c_f_user_role_field_text"
			value="<?php echo esc_attr(get_option('af_c_f_user_role_field_text')); ?>">
			<p class="description af_c_f_user_role_field_text"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_user_role_field_text_callback()
		// end af_c_f_user_role_field_text_callback
		public function af_c_f_enable_user_role_callback( $args ) {
			?>
			<input type="checkbox" id="af_c_f_enable_user_role" class="setting_fields" name="af_c_f_enable_user_role" value="yes"
			<?php checked('yes', esc_attr(get_option('af_c_f_enable_user_role'))); ?>>
			<p class="description af_c_f_enable_user_role"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_enable_user_role_callback()
		// end af_c_f_enable_user_role_callback
		public function af_c_f_user_roles_callback( $args ) {
			?>

			<div class="all_cats">
				<ul>
					<?php

					global $wp_roles;
					$roles = $wp_roles->get_names();

					if (!empty($roles)) {

						foreach ($roles as $key => $value) {
							if ('administrator' != $key) {
								?>
								<li class="par_cat">

									<input type="checkbox" class="parent" name="af_c_f_user_roles[]" id="af_c_f_user_roles"
									value="<?php echo esc_attr($key); ?>" 
									<?php
									if (!empty(get_option('af_c_f_user_roles'))) {
										if (in_array($key, get_option('af_c_f_user_roles'))) {
											echo 'checked';
										}
									}
									?>
									/>
									<?php echo esc_attr($value); ?>

								</li>
								<?php
							}
						}
					}
					?>
				</ul>
			</div>

			<p class="description af_c_f_enable_user_role" style="width: 100%; float: left;"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_user_roles_callback()
		// end af_c_f_user_roles_callback
		// Tab 3
		public function af_c_f_page_3_section_callback() {
			?>

			<p><?php echo esc_html__('Manage Approve new user settings from here.', 'af_custom_fields'); ?></p>
			<h3><?php echo esc_html__('Approve New User Settings', 'af_custom_fields'); ?></h3>

			<?php
		}//end af_c_f_page_3_section_callback()
		// function af_c_f_page_3_section_callback
		public function af_c_f_enable_approve_user_callback( $args ) {
			?>
			<input type="checkbox" id="af_c_f_enable_approve_user" class="setting_fields" name="af_c_f_enable_approve_user"
			value="yes" <?php checked('yes', esc_attr(get_option('af_c_f_enable_approve_user'))); ?>>
			<p class="description af_c_f_enable_approve_user"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_enable_approve_user_callback()
		// end af_c_f_enable_approve_user_callback
		public function af_c_f_enable_approve_user_checkout_callback( $args ) {
			?>
			<input type="checkbox" id="af_c_f_enable_approve_user_checkout" class="setting_fields"
			name="af_c_f_enable_approve_user_checkout" value="yes"
			<?php checked('yes', esc_attr(get_option('af_c_f_enable_approve_user_checkout'))); ?>>
			<p class="description af_c_f_enable_approve_user"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_enable_approve_user_checkout_callback()
		// end af_c_f_enable_approve_user_callback
		public function af_c_f_exclude_user_roles_approve_new_user_callback( $args ) {
			?>

			<div class="all_cats">
				<ul>
					<?php

					global $wp_roles;
					$roles = $wp_roles->get_names();

					if (!empty($roles)) {

						foreach ($roles as $key => $value) {
							if ('administrator' != $key) {
								?>
								<li class="par_cat">

									<input type="checkbox" class="parent" name="af_c_f_exclude_user_roles_approve_new_user[]"
									id="af_c_f_exclude_user_roles_approve_new_user" value="<?php echo esc_attr($key); ?>" 
									<?php
									if (!empty(get_option('af_c_f_exclude_user_roles_approve_new_user'))) {
										if (in_array($key, get_option('af_c_f_exclude_user_roles_approve_new_user'))) {
											echo 'checked';
										}
									}
									?>
									/>
									<?php echo esc_attr($value); ?>

								</li>
								<?php
							}
						}
					}
					?>
				</ul>
			</div>

			<p class="description af_c_f_exclude_user_roles_approve_new_user" style="width: 100%; float: left;"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_exclude_user_roles_approve_new_user_callback()
		// end af_c_f_user_roles_callback
		public function af_c_f_page_33_section_callback() {
			?>

			<h3><?php echo esc_html__('Approve New User Messages Settings', 'af_custom_fields'); ?></h3>

			<?php
		}//end af_c_f_page_33_section_callback()
		// function af_c_f_page_33_section_callback
		public function af_c_f_user_pending_approval_message_callback( $args ) {
			?>
			<textarea name="af_c_f_user_pending_approval_message" id="af_c_f_user_pending_approval_message" rows="10"
			cols="70"><?php echo esc_textarea(get_option('af_c_f_user_pending_approval_message')); ?></textarea>
			<p class="description af_c_f_user_pending_approval_message"> <?php echo esc_attr($args[0]); ?> </p>
			<p class="description af_c_f_user_pending_approval_message"> <?php echo esc_attr($args[1]); ?> </p>
			<?php
		}//end af_c_f_user_pending_approval_message_callback()
		// end af_c_f_user_pending_approval_message_callback
		public function af_c_f_user_approval_message_callback( $args ) {
			?>
			<textarea name="af_c_f_user_approval_message" id="af_c_f_user_approval_message" rows="10"
			cols="70"><?php echo esc_textarea(get_option('af_c_f_user_approval_message')); ?></textarea>
			<p class="description af_c_f_user_approval_message"> <?php echo esc_attr($args[0]); ?> </p>
			<p class="description af_c_f_user_pending_approval_message"> <?php echo esc_attr($args[1]); ?> </p>
			<?php
		}//end af_c_f_user_approval_message_callback()
		// end af_c_f_user_approval_message_callback
		public function af_c_f_user_disapproved_message_callback( $args ) {
			?>
			<textarea name="af_c_f_user_disapproved_message" id="af_c_f_user_disapproved_message" rows="10"
			cols="70"><?php echo esc_textarea(get_option('af_c_f_user_disapproved_message')); ?></textarea>
			<p class="description af_c_f_user_disapproved_message"> <?php echo esc_attr($args[0]); ?> </p>
			<p class="description af_c_f_user_pending_approval_message"> <?php echo esc_attr($args[1]); ?> </p>
			<?php
		}//end af_c_f_user_disapproved_message_callback()
		// end af_c_f_user_disapproved_message_callback
		// Tab 4
		public function af_c_f_page_4_section_callback() {
			?>

			<h3><?php echo esc_html__('Manage Email Settings', 'af_custom_fields'); ?></h3>

			<?php
		}//end af_c_f_page_4_section_callback()
		// function af_c_f_page_4_section_callback
		public function af_c_f_admin_email_callback( $args ) {
			?>
			<input type="text" id="af_c_f_admin_email" class="setting_fields" name="af_c_f_admin_email"
			value="<?php echo esc_attr(get_option('af_c_f_admin_email')); ?>">
			<p class="description af_c_f_admin_email"> <?php echo esc_attr($args[0]); ?> </p>

			<?php
		}//end af_c_f_admin_email_callback()
		// end af_c_f_admin_email_callback
		public function af_c_f_enable_admin_email_callback( $args ) {
			?>
			<input type="checkbox" id="af_c_f_enable_admin_email" class="setting_fields" name="af_c_f_enable_admin_email"
			value="yes" <?php echo checked('yes', esc_attr(get_option('af_c_f_enable_admin_email'))); ?>>
			<p class="description af_c_f_enable_admin_email"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_enable_admin_email_callback()
		// end af_c_f_enable_admin_emaill_callback
		public function af_c_f_admin_email_subject_callback( $args ) {
			?>
			<input type="text" id="af_c_f_admin_email_subject" class="setting_fields" name="af_c_f_admin_email_subject"
			value="<?php echo esc_attr(get_option('af_c_f_admin_email_subject')); ?>">
			<p class="description af_c_f_admin_email_subject"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_admin_email_subject_callback()
		// end af_c_f_admin_email_subject_callback
		public function af_c_f_admin_email_text_callback( $args ) {
			?>

			<?php

			$content   = get_option('af_c_f_admin_email_text');
			$editor_id = 'af_c_f_admin_email_text';
			$settings  = array(
				'wpautop'       => false,
				'tinymce'       => true,
				'textarea_rows' => 10,
				'quicktags'     => array( 'buttons' => 'em,strong,link' ),
				
				
			);

			wp_editor($content, $editor_id, $settings);

			?>
			<p class="description af_c_f_admin_email_text"> <?php echo esc_attr($args[0]); ?> </p>
			<p class="description"> <?php echo esc_attr($args[1]); ?> </p>
			<?php
		}//end af_c_f_admin_email_text_callback()
		// end af_c_f_admin_email_text_callback
		public function af_c_f_enable_pending_user_email_callback( $args ) {
			?>
			<input type="checkbox" id="af_c_f_enable_pending_user_email" class="setting_fields"
			name="af_c_f_enable_pending_user_email" value="yes"
			<?php echo checked('yes', esc_attr(get_option('af_c_f_enable_pending_user_email'))); ?>>
			<p class="description af_c_f_enable_pending_user_email"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_enable_pending_user_email_callback()
		// end af_c_f_enable_admin_emaill_callback 
		public function af_c_f_pending_approval_email_subject_callback( $args ) {
			?>
			<input type="text" id="af_c_f_pending_approval_email_subject" class="setting_fields"
			name="af_c_f_pending_approval_email_subject"
			value="<?php echo esc_attr(get_option('af_c_f_pending_approval_email_subject')); ?>">
			<p class="description af_c_f_pending_approval_email_subject"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_pending_approval_email_subject_callback()
		// end af_c_f_pending_approval_email_subject_callback
		public function af_c_f_pending_approval_email_text_callback( $args ) {
			?>

			<?php

			$content   = get_option('af_c_f_pending_approval_email_text');
			$editor_id = 'af_c_f_pending_approval_email_text';
			$settings  = array(
				'wpautop'       => false,
				'tinymce'       => true,
				'textarea_rows' => 10,
				'quicktags'     => array( 'buttons' => 'em,strong,link' ),
				
				
			);

			wp_editor($content, $editor_id, $settings);

			?>
			<p class="description af_c_f_pending_approval_email_text"> <?php echo esc_attr($args[0]); ?> </p>
			<p class="description"> <?php echo esc_attr($args[1]); ?> </p>
			<?php
		}//end af_c_f_pending_approval_email_text_callback()
		// end af_c_f_pending_approval_email_text_callback
		public function af_c_f_approved_email_subject_callback( $args ) {
			?>
			<input type="text" id="af_c_f_approved_email_subject" class="setting_fields" name="af_c_f_approved_email_subject"
			value="<?php echo esc_attr(get_option('af_c_f_approved_email_subject')); ?>">
			<p class="description af_c_f_approved_email_subject"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_approved_email_subject_callback()
		// end af_c_f_approved_email_subject_callback
		public function af_c_f_approved_email_text_callback( $args ) {
			?>

			<?php

			$content   = get_option('af_c_f_approved_email_text');
			$editor_id = 'af_c_f_approved_email_text';
			$settings  = array(
				'wpautop'       => false,
				'tinymce'       => true,
				'textarea_rows' => 10,
				'quicktags'     => array( 'buttons' => 'em,strong,link' ),
				
				
			);

			wp_editor($content, $editor_id, $settings);

			?>
			<p class="description af_c_f_approved_email_text"> <?php echo esc_attr($args[0]); ?> </p>
			<p class="description"> <?php echo esc_attr($args[1]); ?> </p>
			<?php
		}//end af_c_f_approved_email_text_callback()
		// end af_c_f_approved_email_text_callback
		public function af_c_f_disapproved_email_subject_callback( $args ) {
			?>
			<input type="text" id="af_c_f_disapproved_email_subject" class="setting_fields" name="af_c_f_disapproved_email_subject"
			value="<?php echo esc_attr(get_option('af_c_f_disapproved_email_subject')); ?>">
			<p class="description af_c_f_disapproved_email_subject"> <?php echo esc_attr($args[0]); ?> </p>
			<?php
		}//end af_c_f_disapproved_email_subject_callback()
		// end af_c_f_disapproved_email_subject_callback
		public function af_c_f_disapproved_email_text_callback( $args ) {
			?>

			<?php

			$content   = get_option('af_c_f_disapproved_email_text');
			$editor_id = 'af_c_f_disapproved_email_text';
			$settings  = array(
				'wpautop'       => false,
				'tinymce'       => true,
				'textarea_rows' => 10,
				'quicktags'     => array( 'buttons' => 'em,strong,link' ),
				
				
			);

			wp_editor($content, $editor_id, $settings);

			?>
			<p class="description af_c_f_disapproved_email_text"> <?php echo esc_attr($args[0]); ?> </p>
			<p class="description"> <?php echo esc_attr($args[1]); ?> </p>
			<?php
		}//end af_c_f_disapproved_email_text_callback()
		// end af_c_f_disapproved_email_text_callback
		public function af_c_f_profile_fields() {

			if (!empty($_POST['af_c_f_nonce_action']) && !check_admin_referer('af_c_f_nonce_action', 'af_c_f_nonce_field')) {
				die('Admin Security Failed');
			}

			if (isset($_GET['user_id'])) {

				$user_id = intval($_GET['user_id']);
			} else {

				$user_id = '';
			}

			wp_nonce_field('af_c_f_nonce_action', 'af_c_f_nonce_field');
			?>

			<h3><?php echo esc_html__(get_option('af_c_f_additional_fields_section_title'), 'af_custom_fields'); ?></h3>
			<div class="af_c_f_extra_fields">
				<table class="form-table">
					<tr>
						<th><label><?php echo esc_html__('User Status', 'af_custom_fields'); ?></label></th>
						<td>
							<?php
							$user_status = get_user_meta($user_id, 'af_c_f_new_user_status', true);
							?>
							<select name="af_c_f_new_user_status">
								<option value=""><?php echo esc_html__('Select Status', 'af_custom_fields'); ?>
							</option>
							<?php
							if ('pending' == $user_status) {
								?>
								<option value="pending" <?php echo selected('pending', $user_status); ?>>
									<?php echo esc_html__('Pending', 'af_custom_fields'); ?>
								</option>
							<?php } ?>
							<option value="approved" <?php echo selected('approved', $user_status); ?>>
								<?php echo esc_html__('Approved', 'af_custom_fields'); ?>
							</option>
							<option value="disapproved" <?php echo selected('disapproved', $user_status); ?>>
								<?php echo esc_html__('Disapproved', 'af_custom_fields'); ?>
							</option>
						</select>
					</td>
				</tr>
				<?php

				$af_c_f_args = array(
					'posts_per_page' => -1,
					'post_type'      => 'af_c_fields',
					'post_status'    => 'publish',
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'fields'         => 'ids',
				);

				$af_c_f_extra_fields = get_posts($af_c_f_args);

				if (!empty($af_c_f_extra_fields)) {

					foreach ($af_c_f_extra_fields as $field_id) {

						$is_dependent = get_post_meta($field_id, 'af_c_f_dependable', true);

						if ('yes' == $is_dependent) {
							continue;
						}

						$af_c_f_field_type        = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
						$af_c_f_field_options     = ( get_post_meta(intval($field_id), 'af_c_f_field_option', true) );
						$af_c_f_field_placeholder = get_post_meta(intval($field_id), 'af_c_f_field_placeholder', true);
						$af_c_f_field_description = get_post_meta(intval($field_id), 'af_c_f_field_description', true);

						if (isset($_GET['user_id'])) {

							$value = get_user_meta(intval($_GET['user_id']), 'af_c_f_additional_' . intval($field_id), true);
						} else {
							$value = '';
						}

						if (!empty(get_post_meta(intval($field_id), 'af_c_f_is_dependable', true))) {

							$af_c_f_is_dependable = get_post_meta(intval($field_id), 'af_c_f_is_dependable', true);
						} else {
							$af_c_f_is_dependable = 'off';
						}

						$custom_attributes = '';
						$af_c_f_main_class = '';
						$field_roles       = get_post_meta($field_id, 'af_c_f_field_user_roles', true);

						include AF_CF_PLUGIN_DIR . 'admin/user-profile-fields.php';
						$this->show_dependent_field($field_id);
					}
				}

				?>
			</table>
		</div>
		<?php
		}//end af_c_f_profile_fields()


		public function show_dependent_field( $par_field_id ) {

			$dependent_fields = $this->get_dependent_field($par_field_id);

			if (!empty($_POST['af_c_f_nonce_action']) && !check_admin_referer('af_c_f_nonce_action', 'af_c_f_nonce_action')) {
				die('Admin Security Failed');
			}

			if (empty($dependent_fields)) {
				return;
			}

			foreach ($dependent_fields as $field_id) {

				$af_c_f_field_type        = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
				$af_c_f_field_options     = ( get_post_meta(intval($field_id), 'af_c_f_field_option', true) );
				$af_c_f_field_placeholder = get_post_meta(intval($field_id), 'af_c_f_field_placeholder', true);
				$af_c_f_field_description = get_post_meta(intval($field_id), 'af_c_f_field_description', true);

				if (isset($_GET['user_id'])) {

					$value = get_user_meta(intval($_GET['user_id']), 'af_c_f_additional_' . intval($field_id), true);
				} else {
					$value = '';
				}

				if (!empty(get_post_meta(intval($field_id), 'af_c_f_is_dependable', true))) {

					$af_c_f_is_dependable = get_post_meta(intval($field_id), 'af_c_f_is_dependable', true);
				} else {
					$af_c_f_is_dependable = 'off';
				}


				$dependable_values = get_post_meta($field_id, 'af_c_f_dependable_values', true);
				$dep_fields        = get_post_meta($field_id, 'af_c_f_dep_fields', true);
				$custom_attributes = 'data-dependent_val=' . $dependable_values . ' data-dependent_on=af_c_f_additional_' . $dep_fields;
				$af_c_f_main_class = 'af_c_f_is_dependable';

				$field_roles = get_post_meta(get_post_meta($field_id, 'af_c_f_dep_fields', true), 'af_c_f_field_user_roles', true);
				include AF_CF_PLUGIN_DIR . 'admin/user-profile-fields.php';
			}
		}//end show_dependent_field()


		public function af_c_f_update_profile_fields( $customer_id ) {

			if (!empty($_REQUEST['af_c_f_nonce_field'])) {

				$retrieved_nonce = sanitize_text_field($_REQUEST['af_c_f_nonce_field']);
			} else {
				$retrieved_nonce = 0;
			}

			if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

				wp_die(esc_html__('Security Violated', 'af_custom_fields'));
			}

			$user_info          = get_userdata($customer_id);
			$af_c_f_user_status = $user_info->af_c_f_new_user_status;

			if (!empty($_POST['af_c_f_new_user_status']) && $af_c_f_user_status != $_POST['af_c_f_new_user_status']) {

				update_user_meta($customer_id, 'af_c_f_new_user_status', sanitize_text_field($_POST['af_c_f_new_user_status']));

				if ('approved' == $_POST['af_c_f_new_user_status']) {

					wc()->mailer()->emails['af_email_approve_user_account']->trigger($customer_id);
				} elseif ('disapproved' == $_POST['af_c_f_new_user_status']) {

					wc()->mailer()->emails['af_email_declined_user_account']->trigger($customer_id);
				}
			}

			$af_c_f_args = array(
				'posts_per_page' => -1,
				'post_type'      => 'af_c_fields',
				'post_status'    => 'publish',
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'fields'         => 'ids',
			);

			$af_c_f_extra_fields = get_posts($af_c_f_args);

			if (!empty($af_c_f_extra_fields)) {


				foreach ($af_c_f_extra_fields as $field_id) {

					$af_c_f_field_type = get_post_meta(intval($field_id), 'af_c_f_field_type', true);

					if (isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) || isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ])) {

						if ('fileupload' == $af_c_f_field_type) {

							if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && '' != $_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) {

								if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name'])) {
									$file = time('m') . sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']);
								} else {
									$file = '';
								}


								if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['tmp_name'])) {
									$temp = move_uploaded_file(sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['tmp_name']), AF_CF_UPLOAD_DIR . $file);
								} else {
									$temp = '';
								}

								update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), $file);
							}
						} elseif ('multiselect' == $af_c_f_field_type) {
							$prefix   = '';
							$multival = '';
							foreach (sanitize_meta('', $_POST[ 'af_c_f_additional_' . intval($field_id) ], '') as $value) {
								$multival .= $prefix . $value;
								$prefix    = ', ';
							}
							update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), sanitize_text_field($multival));
						} elseif ('multi_checkbox' == $af_c_f_field_type) {
							$prefix   = '';
							$multival = '';
							foreach (sanitize_meta('', $_POST[ 'af_c_f_additional_' . intval($field_id) ], '') as $value) {
								$multival .= $prefix . $value;
								$prefix    = ', ';
							}
							update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), sanitize_text_field($multival));
						} else {

							update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), sanitize_text_field($_POST[ 'af_c_f_additional_' . intval($field_id) ]));
						}
					} else {

						update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), '');
					}
				}
			}
		}//end af_c_f_update_profile_fields()


		public function af_c_f_modify_user_table( $column ) {

			if ('yes' == get_option('af_c_f_enable_approve_user')) {
				$column['user_status'] = esc_html__('User Status', 'af_custom_fields');
			}

			return $column;
		}//end af_c_f_modify_user_table()


		public function af_c_f_modify_user_table_row( $val, $column_name, $user_id ) {
			switch ($column_name) {
				case 'user_status':
				$user_status = get_user_meta($user_id, 'af_c_f_new_user_status', true);
					return ucfirst($user_status);
				default:
			}
			return $val;
		}//end af_c_f_modify_user_table_row()


		public function af_c_f_user_row_actions( $actions, $user ) {

			if (get_current_user_id() == $user->ID) {
				return $actions;
			}

			if (is_super_admin($user->ID)) {
				return $actions;
			}

			$user_status = get_user_meta($user->ID, 'af_c_f_new_user_status', true);

			$approve_link = add_query_arg(array(
				'action' => 'approved',
				'user'   => $user->ID,
			));
			$approve_link = remove_query_arg(array( 'new_role' ), $approve_link);
			$approve_link = wp_nonce_url($approve_link, 'addify-afreg-fields');

			$deny_link = add_query_arg(array(
				'action' => 'disapproved',
				'user'   => $user->ID,
			));
			$deny_link = remove_query_arg(array( 'new_role' ), $deny_link);
			$deny_link = wp_nonce_url($deny_link, 'addify-afreg-fields');

			$approve_action = '<a href="' . esc_url($approve_link) . '">' . esc_html__('Approve', 'af_custom_fields') . '</a>';
			$deny_action    = '<a href="' . esc_url($deny_link) . '">' . esc_html__('Disapprove', 'af_custom_fields') . '</a>';

			if ('pending' == $user_status) {
				$actions[] = $approve_action;
				$actions[] = $deny_action;
			} elseif ('approved' == $user_status) {
				$actions[] = $deny_action;
			} elseif ('disapproved' == $user_status) {
				$actions[] = $approve_action;
			}

			return $actions;
		}//end af_c_f_user_row_actions()


		public function af_c_f_update_action() {

			if (!empty($_POST['af_c_f_nonce_action']) && !check_admin_referer('af_c_f_nonce_action', 'af_c_f_nonce_action')) {
				die('Admin Security Failed');
			}

			// Email link approval
			if (isset($_GET['action_email']) && in_array($_GET['action_email'], array( 'approved', 'disapproved' )) && !isset($_GET['new_role'])) {

				$sendback = remove_query_arg(array( 'approved', 'disapproved', 'deleted', 'ids', 'afreg-status-query-submit', 'new_role' ), wp_get_referer());
				if (!$sendback) {
					$sendback = admin_url('users.php');
				}

				$wp_list_table = _get_list_table('WP_Users_List_Table');
				$pagenum       = $wp_list_table->get_pagenum();
				$sendback      = add_query_arg('paged', $pagenum, $sendback);

				$status = sanitize_key($_GET['action_email']);

				if (isset($_GET['user'])) {
					$user = absint($_GET['user']);
				} else {
					$user = 0;
				}


				update_user_meta($user, 'af_c_f_new_user_status', $status);

				if ('approved' == $_GET['action_email']) {

					wc()->mailer()->emails['af_email_approve_user_account']->trigger($user);
					?>
					<script>
						window.location = '<?php echo esc_url($sendback); ?>';
					</script>
					<?php

				} elseif ('disapproved' == $_GET['action_email']) {

					wc()->mailer()->emails['af_email_declined_user_account']->trigger($user);
					?>
					<script>
						window.location = '<?php echo esc_url($sendback); ?>';
					</script>
					<?php

				}
			}


			if (isset($_GET['action']) && in_array($_GET['action'], array( 'approved', 'disapproved' )) && !isset($_GET['new_role'])) {
				check_admin_referer('addify-afreg-fields');

				$sendback = remove_query_arg(array( 'approved', 'disapproved', 'deleted', 'ids', 'afreg-status-query-submit', 'new_role' ), wp_get_referer());
				if (!$sendback) {
					$sendback = admin_url('users.php');
				}

				$wp_list_table = _get_list_table('WP_Users_List_Table');
				$pagenum       = $wp_list_table->get_pagenum();
				$sendback      = add_query_arg('paged', $pagenum, $sendback);

				$status = sanitize_key($_GET['action']);

				if (isset($_GET['user'])) {
					$user = absint($_GET['user']);
				} else {
					$user = 0;
				}

				update_user_meta($user, 'af_c_f_new_user_status', $status);


				if ('approved' == $_GET['action']) {

					wc()->mailer()->emails['af_email_approve_user_account']->trigger($user);
				} elseif ('disapproved' == $_GET['action']) {

					wc()->mailer()->emails['af_email_declined_user_account']->trigger($user);
				}

				wp_safe_redirect($sendback);
				exit;
			}
		}//end af_c_f_update_action()


		public function af_c_f_status_filter( $s_filter ) {


			$id = 'af_c_f_approve_new_user_filter-' . $s_filter;

			$f_button = submit_button(esc_html__('Filter', 'af_custom_fields'), 'button', 'afreg-status-query-submit', false, array( 'id' => 'afreg-status-query-submit' ));
			$f_status = $this->changed_status();

			?>
			<label class="screen-reader-text"
			for="<?php echo esc_attr($id); ?>"><?php echo esc_html__('View all users', 'af_custom_fields'); ?></label>
			<select id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($id); ?>" class="anusec">
				<option value=""><?php echo esc_html__('View all users', 'af_custom_fields'); ?></option>

				<?php foreach ($this->get_all_statuses() as $status) { ?>
					<option value="<?php echo esc_attr($status); ?>" <?php echo selected($status, $f_status); ?>> 
						<?php

						if ('disapproved' == $status) {
							echo esc_html__('Disapproved', 'af_custom_fields');
						} else {
							echo esc_html__(ucfirst($status));
						}


						?>
					</option>
				<?php } ?>
			</select>
			<?php echo esc_attr(apply_filters('af_c_f_approve_new_user_filter_button', $f_button)); ?>

			<?php
		}//end af_c_f_status_filter()


		public function changed_status() {

			if (!empty($_POST['af_c_f_nonce_action']) && !check_admin_referer('af_c_f_nonce_action', 'af_c_f_nonce_action')) {
				die('Admin Security Failed');
			}

			if (!empty($_REQUEST['af_c_f_approve_new_user_filter-top']) || !empty($_REQUEST['af_c_f_approve_new_user_filter-bottom'])) {
				$aa =  esc_attr(( !empty($_REQUEST['af_c_f_approve_new_user_filter-top']) ) ? sanitize_text_field($_REQUEST['af_c_f_approve_new_user_filter-top']) : sanitize_text_field($_REQUEST['af_c_f_approve_new_user_filter-bottom']));
			} else {
				$aa =  null;
			}
			return $aa;
		}//end changed_status()


		public function get_all_statuses() {
			return array( 'pending', 'approved', 'disapproved' );
		}//end get_all_statuses()


		public function af_c_f_filter_user_by_status( $qry ) {

			global $wpdb;

			if (!is_admin()) {
				return;
			}


			if ($this->changed_status() != null) {
				$filter = $this->changed_status();


				$qry->query_from .= " INNER JOIN {$wpdb->usermeta} ON ( {$wpdb->users}.ID = $wpdb->usermeta.user_id )";
				if ('approved' == $filter) {
					$qry->query_fields = "DISTINCT SQL_CALC_FOUND_ROWS {$wpdb->users}.ID";
					$where             = $qry->query_from  .= " LEFT JOIN {$wpdb->usermeta} AS mt1 ON ({$wpdb->users}.ID = mt1.user_id AND mt1.meta_key = 'af_c_f_new_user_status')";

					$qry->query_where .= " AND ( ( $wpdb->usermeta.meta_key = 'af_c_f_new_user_status' AND CAST($wpdb->usermeta.meta_value AS CHAR) = 'approved' ) OR mt1.user_id IS NULL )";
				} else {
					$qry->query_where .= " AND ( ($wpdb->usermeta.meta_key = 'af_c_f_new_user_status' AND CAST($wpdb->usermeta.meta_value AS CHAR) = '{$filter}') )";
				}
			}
		}//end af_c_f_filter_user_by_status()


		public function af_c_f_admin_footer() {
			$screen = get_current_screen();

			if ('users' == $screen->id) {
				?>
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						$('<option>').val('approved').text('<?php echo esc_html__('Approve', 'af_custom_fields'); ?>').appendTo(
							"select[name='action']");
						$('<option>').val('approved').text('<?php echo esc_html__('Approve', 'af_custom_fields'); ?>').appendTo(
							"select[name='action2']");

						$('<option>').val('disapproved').text('<?php echo esc_html__('Disapprove', 'af_custom_fields'); ?>')
						.appendTo("select[name='action']");
						$('<option>').val('disapproved').text('<?php echo esc_html__('Disapprove', 'af_custom_fields'); ?>')
						.appendTo("select[name='action2']");
					});
				</script>
				<?php
			}
		}//end af_c_f_admin_footer()


		public function af_c_f_bulk_action_user() {
			$screen = get_current_screen();

			if ('users' == $screen->id) {

				// get the action
				$wp_list_table = _get_list_table('WP_Users_List_Table');
				$action        = $wp_list_table->current_action();

				$allowed_actions = array( 'approved', 'disapproved' );
				if (!in_array($action, $allowed_actions)) {
					return;
				}

				// security check
				check_admin_referer('bulk-users');

				// make sure ids are submitted
				if (isset($_REQUEST['users'])) {
					$user_ids = array_map('intval', $_REQUEST['users']);
				}

				if (empty($user_ids)) {
					return;
				}

				$sendback = remove_query_arg(array( 'approved', 'disapproved', 'deleted', 'ids', 'af_c_f_approve_new_user_filter', 'af_c_f_approve_new_user_filter2', 'afreg-status-query-submit', 'new_role' ), wp_get_referer());
				if (!$sendback) {
					$sendback = admin_url('users.php');
				}

				$pagenum  = $wp_list_table->get_pagenum();
				$sendback = add_query_arg('paged', $pagenum, $sendback);

				switch ($action) {
					case 'approved':
					$approved = 0;
						foreach ($user_ids as $user_id) {

							update_user_meta($user_id, 'af_c_f_new_user_status', 'approved');

							wc()->mailer()->emails['af_email_approve_user_account']->trigger($user_id);

							++$approved;
						}

					$sendback = add_query_arg(array(
						'approved' => $approved,
						'ids'      => join(',', $user_ids),
					), $sendback);
						break;

					case 'disapproved':
					$disapproved = 0;
						foreach ($user_ids as $user_id) {

							update_user_meta($user_id, 'af_c_f_new_user_status', 'disapproved');

							wc()->mailer()->emails['af_email_declined_user_account']->trigger($user_id);

							++$disapproved;
						}

					$sendback = add_query_arg(array(
						'disapproved' => $disapproved,
						'ids'         => join(',', $user_ids),
					), $sendback);
						break;

					default:
						return;
				}

				$sendback = remove_query_arg(array( 'action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status', 'post', 'bulk_edit', 'post_view' ), $sendback);

				wp_safe_redirect($sendback);
				exit();
			}
		}//end af_c_f_bulk_action_user()





		public function af_c_f_save_df_form() {



			if (isset($_POST['nonce']) && '' != $_POST['nonce']) {

				$nonce = sanitize_text_field($_POST['nonce']);
			} else {
				$nonce = 0;
			}

			if (!wp_verify_nonce($nonce, 'afreg-ajax-nonce')) {

				die('Failed ajax security check!');
			}

			
			
			$post_ids = array();
			if (isset($_POST['post_ids']) && '' != $_POST['post_ids']) {
				$post_ids = sanitize_meta('', $_POST['post_ids'], '');
			}

			if (isset($_POST['field_label']) && '' != $_POST['field_label']) {
				$field_label = sanitize_meta('', $_POST['field_label'], '');
			} else {
				$field_label = array();
			}

			if (isset($_POST['field_placeholder']) && '' != $_POST['field_placeholder']) {
				$field_placeholder = sanitize_meta('', $_POST['field_placeholder'], '');
			} else {
				$field_placeholder = array();
			}

			if (isset($_POST['field_required']) && '' != $_POST['field_required']) {
				$field_required = sanitize_meta('', $_POST['field_required'], '');
			} else {
				$field_required = array();
			}

			if (isset($_POST['field_width']) && '' != $_POST['field_width']) {
				$field_width = sanitize_meta('', $_POST['field_width'], '');
			} else {
				$field_width = array();
			}

			if (isset($_POST['field_message']) && '' != $_POST['field_message']) {
				$field_message = sanitize_meta('', $_POST['field_message'], '');
			} else {
				$field_message = array();
			}

			if (isset($_POST['field_status']) && '' != $_POST['field_status']) {
				$field_status = sanitize_meta('', $_POST['field_status'], '');
			} else {
				$field_status = array();
			}

			if (isset($_POST['field_sort_order']) && '' != $_POST['field_sort_order']) {
				$field_sort_order = sanitize_meta('', $_POST['field_sort_order'], '');
			} else {
				$field_sort_order = array();
			}

			$full_array = array_map(function ( $a, $b, $c, $d, $e, $f, $g, $h ) {
				return $a . '-:-' . $b . '-:-' . $c . '-:-' . $d . '-:-' . $e . '-:-' . $f . '-:-' . $g . '-:-' . $h;
			}, $post_ids, $field_label, $field_placeholder, $field_required, $field_width, $field_message, $field_status, $field_sort_order);

			if ('' != $full_array) {
				foreach ($full_array as $data) {

					$value         = explode('-:-', $data);
					$p_id          = intval($value[0]);
					$f_label       = sanitize_text_field($value[1]);
					$f_placeholder = sanitize_text_field($value[2]);
					$f_required    = sanitize_text_field($value[3]);
					$f_width       = sanitize_text_field($value[4]);
					$f_message     = sanitize_text_field($value[5]);
					$f_status      = sanitize_text_field($value[6]);
					$f_sort_order  = sanitize_text_field($value[7]);



					$af_post = array(
						'ID'          => $p_id,
						'post_title'  => $f_label,
						'post_status' => $f_status,
						'menu_order'  => $f_sort_order,
					);

					// Update the post and post meta into the database
					wp_update_post($af_post);

					update_post_meta($p_id, 'placeholder', $f_placeholder);
					update_post_meta($p_id, 'is_required', $f_required);
					update_post_meta($p_id, 'width', $f_width);
					update_post_meta($p_id, 'message', $f_message);
				}
			}

			echo 'success';

			die();
		}//end af_c_f_save_df_form()
	}//end class


	new AF_C_F_Admin();
}
