<?php


if ( ! function_exists( 'ct_color_yiq' ) ) {
	function ct_color_yiq( $color, $dark = 'black', $light = 'light', $threshold = 168 ) {

		$hex = preg_replace( '/[^0-9a-f]/i', '', $color );
		if ( empty( $hex ) || strlen( $hex ) < 3 ) $hex = 'fff';
		if ( strlen( $hex ) < 6 ) $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];

		$c = array();
		for ( $i = 0; $i < 3; $i++ ) $c[] = hexdec( substr( $hex, $i * 2, 2 ) );
		$r = $c[0];
		$g = $c[1];
		$b = $c[2];

		$yiq = ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000;

		return $yiq >= $threshold ? $dark : $light;

	}
}


if ( ! function_exists( 'ct_get_svg' ) ) {
	function ct_get_svg( $file ) {
		$file_path = Crown_Theme::get_dir() . '/' . $file;
		if ( file_exists( $file_path ) ) {
			return file_get_contents( $file_path );
		}
		return '';
	}
}


if ( ! function_exists( 'ct_get_icon' ) ) {
	function ct_get_icon( $icon_name, $library = 'bootstrap-icons' ) {
		if ( $library == 'bootstrap-icons' ) {
			$dir = Crown_Theme::get_dir() . '/lib/bootstrap-icons/icons';
			$filename = $icon_name . '.svg';
			if ( file_exists( $dir . '/' . $filename ) ) {
				return file_get_contents( $dir . '/' . $filename );
			}
		} else if ( $library == 'font-awesome' ) {
			$dir = Crown_Theme::get_dir() . '/lib/font-awesome/svgs';
			$filename = $icon_name . '.svg';
			if ( file_exists( $dir . '/' . $filename ) ) {
				return file_get_contents( $dir . '/' . $filename );
			}
		}
		return '';
	}
}

if ( ! function_exists( 'ct_icon' ) ) {
	function ct_icon( $icon_name, $library = 'bootstrap-icons' ) {
		echo ct_get_icon( $icon_name, $library );
	}
}


if ( ! function_exists( 'ct_bg_image_css' ) ) {
	function ct_bg_image_css( $attachment_id, $selector, $breakpoint_sizes = array() ) {

		$image_full_url = ct_get_media_url( $attachment_id );
		if ( ! $image_full_url ) return;

		$css = array();

		$grid_breakpoints = Crown_Theme::get_grid_breakpoints();
		foreach ( $grid_breakpoints as $grid_breakpoint ) {
			if ( array_key_exists( $grid_breakpoint->name, $breakpoint_sizes ) ) {
				$image_source = ct_get_image_src( $attachment_id, $breakpoint_sizes[ $grid_breakpoint->name ] );
				if ( ! empty( $image_source ) ) {
					$css_line = $selector . ' { background-image: url(' . $image_source . '); }';
					if ( ! empty( $css ) ) {
						$css_line = '@media (min-width: ' . $grid_breakpoint->width . 'px) { ' . $css_line . ' }';
					}
					$css[] = $css_line;
				}
			}
		}

		if ( empty( $css ) ) {
			$css[] = $selector . ' { background-image: url(' . $image_full_url . '); }';
		}

		if ( ! empty( $css ) ) {
			echo '<style>' . implode( ' ', $css ) . '</style>';
		}

	}
}


if ( ! function_exists( 'ct_get_image_src' ) ) {
	function ct_get_image_src( $attachment_id, $size = 'full' ) {
		$src = wp_get_attachment_image_src( $attachment_id, $size );
		return $src ? $src[0] : '';
	}
}


if ( ! function_exists( 'ct_get_media_url' ) ) {
	function ct_get_media_url( $attachment_id ) {
		return wp_get_attachment_url( $attachment_id );
	}
}


if ( ! function_exists( 'ct_get_related_posts' ) ) {
	function ct_get_related_posts( $post_id, $tax_weights = array(), $custom_query_args = array() ) {
		
		$default_tax_weights = array(
			'post_tag' => 2,
			'category' => 1
		);
		$tax_weights = ! empty( $tax_weights ) ? (array) $tax_weights : $default_tax_weights;

		$default_query_args = array(
			'post_type' => 'post',
			'tax_query' => array()
		);
		$custom_query_args = (array) $custom_query_args;
		$query_args = array_merge( $default_query_args, $custom_query_args, array(
			'posts_per_page' => -1,
			'ignore_sticky_posts' => true,
			'post__not_in' => array( $post_id ),
			'fields' => 'all'
		) );

		$has_terms = false;
		$post_terms = array();
		$tax_query = array( 'relation' => 'OR' );
		foreach ( $tax_weights as $tax => $weight ) {
			$terms = wp_get_object_terms( $post_id, $tax, array( 'fields' => 'ids' ) );
			if ( ! empty( $terms ) ) $has_terms = true;
			$post_terms[ $tax ] = $terms;
			$tax_query[] = array( 'taxonomy' => $tax, 'terms' => $terms );
		}
		$query_args['tax_query'][] = $tax_query;
		if ( ! $has_terms ) return array();

		$similar_posts = get_posts( $query_args );
		if ( empty( $similar_posts ) ) return array();

		$ranked_posts = array_map( function( $n ) use ( $post_terms, $tax_weights ) {
			$n = (object) array( 'post' => $n, 'score' => 0 );
			foreach( $tax_weights as $tax => $weight ) {
				$terms = wp_get_object_terms( $n->post->ID, $tax, array( 'fields' => 'ids' ) );
				$n->score += $weight * count( array_intersect( $post_terms[ $tax ], $terms ) );
			}
			return $n;
		}, $similar_posts );

		usort( $ranked_posts, function( $a, $b ) {
			if ( $a->score == $b->score ) return strcmp( $b->post->post_date, $a->post->post_date );
			return $b->score - $a->score;
		});

		if ( isset( $custom_query_args['fields'] ) && $custom_query_args['fields'] == 'ids' ) {
			return array_map( function( $n ) { return $n->post->ID; }, $ranked_posts );
		}
		return array_map( function( $n ) { return $n->post; }, $ranked_posts);

	}
}


if ( ! function_exists( 'ct_get_footer_modal_forms' ) ) {
	function ct_get_footer_modal_forms() {
		$forms = apply_filters( 'ct_footer_modal_forms', array() );
		$unique_forms = array();
		foreach ( $forms as $form ) {
			$unique_forms[ md5( json_encode( $form ) ) ] = $form;
		}
		return array_values( $unique_forms );
	}
}


function current_location(){
    if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $protocol = 'https://';
    } else {
        $protocol = 'http://';
    }
    return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}


function multineedle_stripos($haystack, $needles, $offset=0) {
    foreach($needles as $needle) {
        $found[$needle] = stripos($haystack, $needle, $offset);
    }
    return $found;
}


if (!function_exists('redirection_with_404')) {
	function redirection_with_404() {
		$current_url = current_location();
		$current_pagination_page = (get_query_var('paged')) ? get_query_var('paged') : null;
		$product_pages_needle = [
			'product-brands',
			'product-category'
		];
		$multineedle = multineedle_stripos($current_url, $product_pages_needle);
		
		if($current_pagination_page > 1 && ($multineedle['product-brands'] != false || $multineedle['product-category'] != false)){
			$redirect_to = str_replace("/page/{$current_pagination_page}/", '/page/1/', $current_url);
			
			header("Location: {$redirect_to}", true, 301);
        	exit;
		}
	}
}

/* ---------------------------------------------------------------------------
 * Added option pages
 * --------------------------------------------------------------------------- */
if( function_exists('acf_add_options_page')  && function_exists('acf_add_options_sub_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

	acf_add_options_sub_page(array(
        'page_title'    => 'Product Category Import',
        'menu_title'    => 'Product Category Import',
        'parent_slug'   => 'edit.php?post_type=product',
    ));

	acf_add_options_sub_page(array(
        'page_title'    => 'Setting import cron products with Aplifi',
        'menu_title'    => 'Setting import with Aplifi',
        'parent_slug'   => 'edit.php?post_type=product',
    ));

	acf_add_options_sub_page(array(
        'page_title'    => 'Manual sync NS',
        'menu_title'    => 'Manual sync NS',
        'parent_slug'   => 'edit.php?post_type=product',
    ));

	acf_add_options_sub_page(array(
        'page_title'    => 'Settings Expired status',
        'menu_title'    => 'Settings Expired status',
        'parent_slug'   => 'woocommerce',
    ));
}

add_action('init', 'register_menu_tree_transient_related_hooks');

function register_menu_tree_transient_related_hooks() {
    add_action('wp_update_nav_menu_item', 'delete_products_menu_tree_transient_on_menu_update', 10, 3);
    add_action('created_term', 'delete_products_menu_tree_transient_on_created_term', 10, 3);
    add_action('delete_term', 'delete_products_menu_tree_transient_on_delete_term', 10, 4);
    add_action( 'before_delete_post', 'delete_products_menu_tree_transient_on_product_change', 0, 2 );
}

function delete_products_menu_tree_transient_on_menu_update( $menu_id, $menu_item_db_id, $args ) {
    if ($menu_id === 4 ) {
        delete_products_menu_tree_transient();
    }
}

function delete_products_menu_tree_transient_on_created_term( $term_id, $tt_id, $taxonomy ) {
    if ($taxonomy === 'product_cat') {
        delete_products_menu_tree_transient();
    }
}

function delete_products_menu_tree_transient_on_delete_term( $term, $tt_id, $taxonomy, $deleted_term ) {
    if ($taxonomy === 'product_cat') {
        delete_products_menu_tree_transient();
    }
}

function delete_products_menu_tree_transient_on_product_change( $post_id, $post = null ) {
    if ( is_null( $post ) ) {
        $post = get_post( $post_id );
    }
    if ( isset( $post->post_type ) && $post->post_type === 'product' ) {
        delete_products_menu_tree_transient();
    }
}

function delete_products_menu_tree_transient() {
    $products_menu_tree_transient_name = 'products_menu_tree';
    if (get_transient($products_menu_tree_transient_name) !== false) {
        delete_transient( $products_menu_tree_transient_name );
    }
}

function add_menu_item_enabled_field($item_id, $item, $depth, $args, $id) {
	$value = get_post_meta($item_id, '_menu_item_enabled', true);
	if ($value === '') {
		$value = '1';
	}
	?>
	<p class="field-menu-item-enabled description description-wide">
		<label for="edit-menu-item-enabled-<?php echo $item_id; ?>">
			<input type="checkbox" id="edit-menu-item-enabled-<?php echo $item_id; ?>" class="widefat code edit-menu-item-enabled" name="menu-item-enabled[<?php echo $item_id; ?>]" value="1" <?php checked( $value, '1' ); ?> />
			<?php _e('Enable this menu item'); ?>
		</label>
	</p>
	<?php
}
add_action('wp_nav_menu_item_custom_fields', 'add_menu_item_enabled_field', 10, 5);

function save_menu_item_enabled_field($menu_id, $menu_item_db_id, $args) {
	if (isset($_POST['menu-item-enabled'][$menu_item_db_id])) {
		update_post_meta($menu_item_db_id, '_menu_item_enabled', $_POST['menu-item-enabled'][$menu_item_db_id]);
	} elseif ( isset( $_POST['menu-item-enabled'] ) ) {
		update_post_meta($menu_item_db_id, '_menu_item_enabled', '0');
	}
}
add_action('wp_update_nav_menu_item', 'save_menu_item_enabled_field', 10, 3);

function add_menu_item_render_children_field($item_id, $item, $depth, $args, $id) {
	if ($item->type === 'taxonomy' && $item->object === 'product_cat') {
        $value = get_post_meta($item_id, '_menu_item_render_children', true);
	    if ($value === '') {
	    	$value = '1';
	    }
	    ?>
        <p class="field-menu-item-render-children description description-wide">
            <label for="edit-menu-item-render-children-<?php echo $item_id; ?>">
                <input type="checkbox" id="edit-menu-item-render-children-<?php echo $item_id; ?>" class="widefat code edit-menu-item-render-children" name="menu-item-render-children[<?php echo $item_id; ?>]" value="1" <?php checked( $value, '1' ); ?> />
		        <?php _e('Automatically render children elements for this Product category (up to sub-category).'); ?>
            </label>
        </p>
	    <?php
    }
}
add_action('wp_nav_menu_item_custom_fields', 'add_menu_item_render_children_field', 10, 5);

function save_menu_item_render_children_field($menu_id, $menu_item_db_id, $args) {
	if (isset($_POST['menu-item-render-children'][$menu_item_db_id])) {
		update_post_meta($menu_item_db_id, '_menu_item_render_children', $_POST['menu-item-enabled'][$menu_item_db_id]);
	} elseif ( isset( $_POST['menu-item-render-children'] ) ) {
		update_post_meta($menu_item_db_id, '_menu_item_render_children', '0');
	}
}
add_action('wp_update_nav_menu_item', 'save_menu_item_render_children_field', 10, 3);

function set_default_menu_item_enabled_meta($menu_id, $menu_item_db_id, $args) {
	$value = get_post_meta($menu_item_db_id, '_menu_item_enabled', true);
	if ($value === '') {
		update_post_meta($menu_item_db_id, '_menu_item_enabled', 1);
	}
	if ($args['menu-item-type'] === 'taxonomy' && $args['menu-item-object'] === 'product_cat') {
		$value = get_post_meta($menu_item_db_id, '_menu_item_render_children', true);
		if ($value === '') {
			update_post_meta($menu_item_db_id, '_menu_item_render_children', 1);
		}
	}
}
add_action('wp_add_nav_menu_item', 'set_default_menu_item_enabled_meta', 10, 3);

function enable_product_categories_in_screen_options() {
	$current_screen = get_current_screen();

	if ( ! $current_screen || 'nav-menus' !== $current_screen->id ) {
		return;
	}

	add_filter('hidden_meta_boxes', function($hidden, $screen) {
		if ( $screen->id === 'nav-menus' ) {
			$key = array_search('add-product_cat', $hidden);
			if ( false !== $key ) {
				unset($hidden[$key]);
			}
		}
		return $hidden;
	}, 10, 2);
}
add_action('current_screen', 'enable_product_categories_in_screen_options');

if( false == get_option('requests_query') ) {	
	add_option( 'requests_query', [] );
}

add_action('wp_dashboard_setup', 'custom_dashboard_widgets');

function custom_dashboard_widgets() {
	$user = wp_get_current_user();
	if (is_user_logged_in() && ( isset( $user->roles[0] ) && ($user->roles[0] ==  'customer_service') )){
		return;
	} else {
		global $wp_meta_boxes;
		wp_add_dashboard_widget('requests_query_widget', 'Logs requests query:', 'requests_query_function');	
	}
}

function requests_query_function() {
    $requests_query = get_option('requests_query');
	if(count($requests_query) >= 1000){
		update_option( 'requests_query', [] );
	}
	echo '<div style="overflow-x: scroll; height: 400px; overflow-y: none">';
    if(!empty($requests_query)){
        foreach ($requests_query as $key => $item) {
            echo $key + 1 . ') <b>[ '.$item['date'].' ]</b> - <i>' . $item['url'] . '<i><br>';
        }
    }
	echo '</div>';
}

/**
 * Adds a REST API route for checking the app version.
 *
 * This function registers a REST API route at /wp-json/quote/v2/app-version
 * with the GET method. The callback function 'check_version_minor_efforts' is
 * responsible for handling the request and returning the app version.
 *
 * @since 1.0.0
 */
add_action('rest_api_init', function() {
	//path=/wp-json/quote/v2/app-version
	register_rest_route('quote/v2', 'app-version',[
		'methods' =>  'GET',
		'callback' => 'check_version_minor_efforts',
        'args' => [
            'type' => ['STD'],
        ],
	]);
});

function check_version_minor_efforts($request){

	$auth = apache_request_headers();

	if(!$auth['Authorization'] || empty($auth['Authorization'])){		
		http_response_code(403);
		exit;
	}

		$version = App_Version::get_app_version($request['type']);

		return $version;

}

if (!function_exists('write_log')) {
	function write_log ( $log )  {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}

add_action( 'woocommerce_after_checkout_validation', 'validate_fname_po_number', 10, 2 );

function validate_fname_po_number( $fields, $errors ){
	$po_number = trim(filter_input(INPUT_POST, 'af_c_f_4432739'));
	$current_user_id = get_current_user_id();

	if(!empty($po_number)){
		$query = new WC_Order_Query( array(
			'limit' 		=> -1,
			'orderby' 		=> 'date',
			'order' 		=> 'DESC',
			'customer_id'   => $current_user_id,
			'meta_key'      => 'af_c_f_4432739', 
			'meta_value'    =>  $po_number,
			'meta_compare'  => '=',
			'return'        => 'ids'
		) );
		$orders = $query->get_orders();

		if(!empty($orders)){
			$errors->add( 'validation', __( 'This <b>PO number</b> already exists. <br>Please enter a unique number.' ));
		}
	}
}

/**
 * Returns the Amplify region ID based on the current environment.
 *
 * @return int The Amplify region ID.
 */
function get_amplify_region_id() {
	if ( defined( 'WP_ENVIRONMENT' ) && WP_ENVIRONMENT ) {

		// AMPLIFY_PRODUCT_RELEASE_REGION_ID or AMPLIFY_DEFAULT_REGION_ID

		switch (WP_ENVIRONMENT) {
			case 'local':
				return AMPLIFY_PRODUCT_RELEASE_REGION_ID;
			case 'hotfix':
				return AMPLIFY_PRODUCT_RELEASE_REGION_ID;
			case 'dev':
				return AMPLIFY_PRODUCT_RELEASE_REGION_ID;
			case 'prod':
				return AMPLIFY_DEFAULT_REGION_ID;
		}
	} else {
		return AMPLIFY_DEFAULT_REGION_ID;
	}
}

// Add a filter to modify the admin footer text
function custom_left_admin_footer_text($text) {
    $text .= ' <br> WP_ENVIRONMENT: ' . WP_ENVIRONMENT;
    
    return $text;
}

function custom_right_admin_footer_text($content): string {
    $content .= "<br>App version: " . App_Version::get_app_version('FULL');
    return $content;
}

add_filter('admin_footer_text', 'custom_left_admin_footer_text');
add_filter('update_footer', 'custom_right_admin_footer_text', 100);

/**
 * Deletes all items with the 'product_import' post type.
 */
function delete_all_items_with_product_import(){
	$post_ids = get_posts( array( 'post_type' => 'product_import', 'posts_per_page' => -1, 'fields' => 'ids', 'post_status' => 'all' ) );

	foreach ( $post_ids as $i => $post_id ) {
		wp_delete_post( $post_id, true );
	}
}

/**
 * Adds a custom column to the post list table in the admin panel.
 *
 * @param array $columns The existing columns in the post list table.
 * @return array The modified columns array with the new custom column added.
 */
add_filter('manage_product_import_posts_columns', function($columns) {
	return array_merge($columns, ['manual_sync_amplify_column' => 'Manual sync Amplify']);
});

/**
 * Displays the content of the custom column in the post list table.
 *
 * @param string $column_key The key of the current column being displayed.
 * @param int $post_id The ID of the current post being displayed.
 * @return void
 */
add_action('manage_product_import_posts_custom_column', function($column_key, $post_id) {
	if ($column_key == 'manual_sync_amplify_column') {
		$manual_sync_amplify = get_field('manual_sync_amplify', $post_id);

		if ($manual_sync_amplify == 1) {
			echo '<span style="color:green;"> Yes </span>';
		} else {
			echo '<span style="color:red;"> No </span>';
		}
	}
}, 10, 2);

// Register the column as sortable
function register_sortable_columns( $columns ) {
    $columns['manual_sync_amplify_column'] = 'manual_sync_amplify';
    return $columns;
}

add_filter( 'manage_edit-product_import_sortable_columns', 'register_sortable_columns' );

//delete_all_items_with_product_import();

/**
 * Sets the orderby parameter for the main query based on the 'manual_sync_amplify' meta key.
 *
 * @param WP_Query $query The main query object.
 * @return void
 */
function manual_sync_amplify_posts_orderby($query) {
    if (!is_admin() || !$query->is_main_query() || !isset($_GET['orderby']) || $_GET['orderby'] !== 'manual_sync_amplify') {
        return;
    }

	if($_GET['order'] == 'asc'){
		$query->set('meta_key', 'manual_sync_amplify');
		$query->set('orderby', 'meta_value');
	}
}

add_action('pre_get_posts', 'manual_sync_amplify_posts_orderby');

/**
 * Deletes duplicate connected scripts from the given list of scripts.
 *
 * This function is specifically designed to be used as a filter for the 'print_scripts_array' hook.
 * It checks if the current screen is an 'acf-field-group' post type and then removes duplicate connected scripts from the list.
 *
 * @param array $current_list_scripts The list of scripts to filter.
 * @return array The filtered list of scripts with duplicate connected scripts removed.
 */
function delete_duplicate_connected_scripts($current_list_scripts){

	$screen = get_current_screen();
    if(!empty($screen->post_type) && $screen->post_type == 'acf-field-group'){

		// Get all registered scripts with their corresponding source URLs
		$array_src_scripts = get_array_src_scripts();
    
        if(!empty($current_list_scripts) && !empty($array_src_scripts)){

			foreach($array_src_scripts as $filename => $arr_data_script){

				if(!empty($arr_data_script) && count($arr_data_script) > 1){
					unset($arr_data_script[0]);

					foreach($arr_data_script as $key => $data_script){
						$key_delete_element = array_search($data_script['id_script'], $current_list_scripts);

						if ($key_delete_element !== false) {
							unset($current_list_scripts[$key_delete_element]);
						}
					}
				}
			}
        }
	}	

    return $current_list_scripts;
}
if(is_admin()){
	add_filter('print_scripts_array', 'delete_duplicate_connected_scripts');
}

/**
 * Retrieves an array of registered scripts with their corresponding source URLs.
 *
 * This function iterates through the registered scripts in WordPress and creates an array
 * where the keys are the filenames (without the extension) and the values are arrays of
 * script information, including the script handle and source URL.
 *
 * @return array An array of registered scripts with their corresponding source URLs.
 */
function get_array_src_scripts(){
	$scripts = wp_scripts()->registered;

	if(!empty($scripts)){
		foreach($scripts as $script){

			if(!empty($script->src)){
				$filename = strstr(basename($script->src), '.', true);

				$arr_data_scripts_file[$filename][] = [
					'id_script' => $script->handle,
					'src' => $script->src
				];
			}
		}
	}
	return $arr_data_scripts_file;
}



/**
 * Adds a custom column 'Min Order' to the user management screen.
 *
 * @param array $columns The existing columns in the user management screen.
 * @return array The modified columns array with the 'Min Order' column added.
 */
add_filter( 'manage_users_columns', 'add_min_order_column' );
function add_min_order_column( $columns ) {
	$columns[ 'min_order' ] = 'Free shipping Min. Order Amount';
	return $columns;
}


/**
 * Adds custom column data for the 'manage_users' screen.
 *
 * @param string $value       The current column value.
 * @param string $column_name The name of the current column.
 * @param int    $user_id     The ID of the current user.
 * @return string             The modified column value.
 */
add_filter( 'manage_users_custom_column', 'add_min_order_column_data', 10, 3 );
function add_min_order_column_data( $value, $column_name, $user_id ) {
	if ( 'min_order' == $column_name ) {

		$min_order = get_user_meta( $user_id, 'min_order', true );

		return $min_order;
	}

	return $value;
}

function handle_get_dynamic_price() {
	if (isset($_POST['product_id']) && is_user_logged_in()) {
		$product_id = intval(reset($_POST['product_id']));
		$product = wc_get_product($product_id);
		if (!empty($product) && $product->is_purchasable()) {
			$product_price = wc_get_price_excluding_tax($product);
			wp_send_json_success(['price' => $product_price]);
//			wp_send_json_success(['price' => [$product_price]]);
		} else {
			wp_send_json_error('Product not purchasable');
		}
	} else {
		wp_send_json_error('Invalid product ID or user not logged in');
	}
}

function get_dynamic_price($product_id) {
	$product_id = intval($product_id);
	$product = wc_get_product($product_id);
	if (!empty($product) && $product->is_purchasable()) {
		return wc_get_price_excluding_tax($product);
	}
	return null;
}

add_action('wp_ajax_get_dynamic_price', 'handle_get_dynamic_price');

add_filter( 'wp_mail', 'crown_filter_email_receiver_addresses', 10, 1 );
function crown_filter_email_receiver_addresses( $args ) {
    if (
        defined('FILTER_OUTGOING_EMAILS_DOMAINS_WHITE_LIST') && FILTER_OUTGOING_EMAILS_DOMAINS_WHITE_LIST
        && defined('FILTER_OUTGOING_EMAILS_DOMAINS_WHITE_LIST_FILE')
    ) {
        $whitelist_file = fopen(FILTER_OUTGOING_EMAILS_DOMAINS_WHITE_LIST_FILE, 'r');
        $whitelisted_emails = fgetcsv($whitelist_file, 1000, ",");
        if ( is_array($whitelisted_emails) ) {
            $recipients = $args['to'];
            if ( is_string($recipients) && str_contains($recipients, ',') ) {
                $recipients = explode(',', $recipients);
            }

            if ( defined('DO_REGEX_COMPARISON_WHITELIST') && DO_REGEX_COMPARISON_WHITELIST ) {
                if ( is_array($recipients) ) {
                    foreach ( $recipients as $key => $email ) {
                        if ( !crown_filter_is_email_in_list($email, $whitelisted_emails) ) {
                            unset( $recipients[$key] );
                        }
                    }
                } else if ( !crown_filter_is_email_in_list($recipients, $whitelisted_emails) ) {
                    $recipients = '';
                }
            } else {
                if ( is_array($recipients) ) {
                    foreach ( $recipients as $key => $email ) {
                        if ( !in_array($email, $whitelisted_emails) ) {
                            unset( $recipients[$key] );
                        }
                    }
                } else if ( !in_array($recipients, $whitelisted_emails) ) {
                    $recipients = '';
                }
            }

            if ( empty($recipients) && defined('DEFAULT_EMAIL_RECIPIENT') ) {
                $recipients = DEFAULT_EMAIL_RECIPIENT;
            }

            $args['to'] = $recipients;
        }
    }

    if (
        defined('FILTER_OUTGOING_EMAILS_DOMAINS_BLACK_LIST') && FILTER_OUTGOING_EMAILS_DOMAINS_BLACK_LIST
        && defined('FILTER_OUTGOING_EMAILS_DOMAINS_BLACK_LIST_FILE')
    ) {
        $blacklist_file = fopen(FILTER_OUTGOING_EMAILS_DOMAINS_BLACK_LIST_FILE, 'r');
        $blacklisted_emails = fgetcsv($blacklist_file, 1000, ",");
        if ( is_array($blacklisted_emails) ) {
            $recipients = $args['to'];
            if ( is_string($recipients) && str_contains($recipients, ',') ) {
                $recipients = explode(',', $recipients);
            }

            if ( defined('DO_REGEX_COMPARISON_BLACKLIST') && DO_REGEX_COMPARISON_BLACKLIST ) {
                if ( is_array($recipients) ) {
                    foreach ( $recipients as $key => $email ) {
                        if ( crown_filter_is_email_in_list($email, $blacklisted_emails) ) {
                            unset( $recipients[$key] );
                        }
                    }
                } else if ( crown_filter_is_email_in_list($recipients, $blacklisted_emails) ) {
                    $recipients = '';
                }
            } else {
                if ( is_array($recipients) ) {
                    foreach ( $recipients as $key => $email ) {
                        if ( in_array($email, $blacklisted_emails) ) {
                            unset( $recipients[$key] );
                        }
                    }
                } else if ( in_array($recipients, $blacklisted_emails) ) {
                    $recipients = '';
                }
            }

            if ( empty($recipients) && defined('DEFAULT_EMAIL_RECIPIENT') ) {
                $recipients = DEFAULT_EMAIL_RECIPIENT;
            }

            $args['to'] = $recipients;
        }
    }

    return $args;
}

function crown_filter_is_email_in_list( $email, $addresses )
{
    foreach ( $addresses ?? [] as $address ) {
        $email_parts = explode('@', $address);
        $email_name = $email_parts[0];
        $email_domain = $email_parts[1];
        $pattern = "/$email_name(\+.*)?@$email_domain/i";

        if ( preg_match($pattern, $email) === 1 ) {
            return true;
        }
    }

    return false;
}

add_action( 'post_submitbox_misc_actions', 'remove_duplicate_functionality_from_quotes', 1 );
function remove_duplicate_functionality_from_quotes() {
    global $pagenow;

    if ( is_admin() && $pagenow === 'post.php' && isset( $_GET['post'] ) ) {
        $post_id = $_GET['post'];
        $post_type = get_post_type( $post_id );

        if ( $post_type == 'addify_quote' ) {
            remove_action( 'post_submitbox_misc_actions', 'mtphr_post_duplicator_submitbox', 10 );
        }
    }
}

add_filter( 'post_row_actions', 'remove_duplicate_functionality_from_quotes_listing', 99, 2 );
function remove_duplicate_functionality_from_quotes_listing( $actions, $post ) {
    $post_type = get_post_type( $post->ID );
    if ( $post_type == 'addify_quote' && isset($actions['duplicate_post']) ) {
        unset($actions['duplicate_post']);
    }

    return $actions;
}

function add_hawksearch_restricted_brands_condition($current_user, &$check_if_sales_rep_domain_brands_restricted) {
    $restricted_brands_condition = '';
    $user_id = $current_user->ID;
    $user_role = $current_user->roles[0];
    $roles_restricted_for_sales_rep_domains_brands = defined( 'ROLES_RESTRICTED_FOR_SALES_REP_DOMAINS_BRANDS' )
        ? ROLES_RESTRICTED_FOR_SALES_REP_DOMAINS_BRANDS
        : array( 'shop_manager' );
    $manual_restricted_brands_for_sales_rep_domains = defined( 'MANUAL_RESTRICTED_BRANDS_FOR_SALES_REP_DOMAINS' )
        ? MANUAL_RESTRICTED_BRANDS_FOR_SALES_REP_DOMAINS
        : array( '@kunz-powell.com' => array('Metallics') );
    if ( in_array($user_role, $roles_restricted_for_sales_rep_domains_brands ) ) {
        $rep_email_domain = Crown_Shop_Display::get_user_mail_domain($current_user->user_email);
        if ( ! empty( $rep_email_domain ) && isset($manual_restricted_brands_for_sales_rep_domains[ $rep_email_domain ] ) ) {
            $restricted_brands_condition = build_hawksearch_brands_condition($manual_restricted_brands_for_sales_rep_domains[ $rep_email_domain ]);
            $check_if_sales_rep_domain_brands_restricted = true;
        }
    } elseif ( $user_role === 'customer' && Crown_Shop_Display::is_customer_switched_from_limited_access_acount( $user_id ) ) {
        $restricted_brands_condition = build_hawksearch_brands_condition($manual_restricted_brands_for_sales_rep_domains[ Crown_Shop_Display::$limited_rep_email_domain ]);
        $check_if_sales_rep_domain_brands_restricted = true;
    }

    return $restricted_brands_condition;
}

function build_hawksearch_brands_condition( $brands_list ) {
    $conditions = array_map( function($brand) {
        return '(eq attributes.brand.[0] "' . $brand . '")';
    }, $brands_list );
    return implode( ' ', $conditions );
}

function get_dual_shop_manager_allowed_brands( $user ) {
    $dsm_allowed_brands_option = get_option( 'dsm_allowed_brands' );
    $dsm_allowed_brands_config = $dsm_allowed_brands_option['data'] ?? array();

    $user_email = $user->user_email;
    $user_email_domain = '';
    if ( preg_match('/(@[^,;\s]+)/', $user_email, $matches) ) {
        $user_email_domain = $matches[1];
    }

    $dsm_allowed_brands_string = '';
    foreach ( $dsm_allowed_brands_config['dsm-domain'] as $id => $domain ) {
        if ( trim($domain) == trim($user_email_domain) ) {
            $dsm_allowed_brands_string = $dsm_allowed_brands_config['dsm-brands'][$id];
        }
    }

    $dsm_allowed_brands = !empty( $dsm_allowed_brands_string ) ? explode( ',', $dsm_allowed_brands_string ) : array();

    $brand_names = array();
    foreach ( $dsm_allowed_brands as $brand_slug ) {
        $brand = get_term_by( 'slug', $brand_slug, 'product_brand' );
        if ( $brand ) {
            $brand_names[] = $brand->name;
        }
    }

    return $brand_names;
}