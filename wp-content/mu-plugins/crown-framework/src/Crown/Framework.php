<?php
/**
 * Contains definition for \Crown\Framework class.
 */

/**
 * Crown Framework description goes here...
 */
namespace Crown;

use Crown\Post\Type as PostType;


/**
 * Crown framework configuration class.
 *
 * Performs necessary setup for framework environment including setting up tables and registering scripts and styles.
 *
 * @since 2.0.0
 */
class Framework {

	/**
	 * Post type for repeater entry posts.
	 *
	 * The repeater entry post type is hidden from the UI and is only used for field repeater metadata management.
	 *
	 * @since 2.0.0
	 *
	 * @var Crown\Post\Type
	 */
	private $repeaterEntryPostType;


	/**
	 * Crown framework constructor.
	 *
	 * Creates database tables, adds repeater entry post type, and registers relevant action/filter hooks.
	 *
	 * @since 2.0.0
	 *
	 * @uses \Crown\Framework::setupTables() to setup database tables.
	 */
	public function __construct() {

		// force setup if version is different
		$forceSetup = get_option('crown_framework_version') != CROWN_FRAMEWORK_VERSION;

		// setup database tables
		$this->setupTables($forceSetup);

		// update stored version number
		if($forceSetup) {
			update_option('crown_framework_version', CROWN_FRAMEWORK_VERSION);
		}

		// create repeater entry post type
		$this->repeaterEntryPostType = new PostType(array('name' => 'crown_repeater_entry', 'settings' => array('public' => false)));

		// register hooks
		add_action('admin_enqueue_scripts', array(&$this, 'registerAdminScripts'));
		add_action('admin_enqueue_scripts', array(&$this, 'registerAdminStyles'));

		// post duplicator hooks
		add_action('mtphr_post_duplicator_created', array(&$this, 'duplicatePostRepeaterFieldEntries'), 10, 3);

		// poly lang hooks
		add_action('add_meta_boxes', array(&$this, 'pllDuplicatePostRepeaterFieldEntries'), 5, 2);

		// seo framework hooks
		add_filter('the_seo_framework_save_post_meta', array(&$this, 'seofwFilterSaveCustomFields'), 10, 2);

		// add remote media url hooks
		if(defined('CROWN_USE_REMOTE_MEDIA_URL') && !empty(CROWN_USE_REMOTE_MEDIA_URL)) {
			add_filter('wp_get_attachment_image_src', array(&$this, 'filterWpGetAttachmentImageSrc'));
			add_filter('wp_calculate_image_srcset', array(&$this, 'filterWpCalculateImageSrcset'));
			add_filter('wp_get_attachment_url', array(&$this, 'filterWpGetAttachmentUrl'));
		}

	}


	/**
	 * Setup custom database tables used by Crown framework.
	 *
	 * Adds termmeta table to support taxonomy term metadata.
	 *
	 * @since 2.0.0
	 *
	 * @used-by	\Crown\Framework::__construct() during object instantiation.
	 *
	 * @param boolean $createTables Optional. Whether the tables should be created. By default, does not create tables.
	 */
	protected function setupTables($createTables = false) {
		global $wpdb;

		// setup termmeta table reference
		$tableNameTermMeta = $wpdb->prefix.'termmeta';
		$wpdb->termmeta = $tableNameTermMeta;
		
		if($createTables) {

			// include the wordpress database schema management function
			require_once(ABSPATH.'wp-admin/includes/upgrade.php');

			$charsetCollate = $wpdb->get_charset_collate();

			// create the term meta database table if it doesn't exist
			if($wpdb->get_var("SHOW TABLES LIKE '$wpdb->termmeta'") != $wpdb->termmeta) {
				$sql = "CREATE TABLE $wpdb->termmeta (
					meta_id bigint(20) unsigned NOT NULL auto_increment,
					term_id bigint(20) unsigned NOT NULL default '0',
					meta_key varchar(255) default NULL,
					meta_value longtext,
					PRIMARY KEY (meta_id),
					KEY term_id (term_id),
					KEY meta_key (meta_key(191))
				) $charsetCollate";
				dbDelta($sql);
			}

		}

	}


	/**
	 * Register and/or enqueue scripts to be used in the WP admin.
	 *
	 * This method is added to the 'admin_enqueue_scripts' action hook.
	 *
	 * @since 2.0.0
	 *
	 * @param string $hook The current admin page's hook.
	 */
	public function registerAdminScripts($hook) {

		wp_register_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js', array('jquery'), '4.0.5', true);

		wp_register_script('codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.43.0/codemirror.min.js', array(), '5.43.0', true);
		wp_register_script('codemirror-mode-xml', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.43.0/mode/xml/xml.min.js', array('codemirror'), '5.43.0', true);
		wp_register_script('codemirror-mode-javascript', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.43.0/mode/javascript/javascript.min.js', array('codemirror'), '5.43.0', true);
		wp_register_script('codemirror-mode-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.43.0/mode/css/css.min.js', array('codemirror'), '5.43.0', true);
		wp_register_script('codemirror-mode-html', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.43.0/mode/htmlmixed/htmlmixed.min.js', array('codemirror', 'codemirror-mode-xml', 'codemirror-mode-javascript', 'codemirror-mode-css'), '5.43.0', true);

		// field group set interactivity script
		wp_register_script('crown-form-field-group-set', CROWN_URL.'/src/Resources/Public/js/FormFieldGroupSet.min.js', array('jquery'), false, true);

		// field repeater interactivity script
		wp_register_script('crown-form-field-repeater', CROWN_URL.'/src/Resources/Public/js/FormFieldRepeater.min.js', array('jquery', 'jquery-ui-sortable', 'json2'), false, true);
		wp_localize_script('crown-form-field-repeater', 'crownFormFieldRepeaterData', array(
			'ajaxUrl' => admin_url('admin-ajax.php')
		));

		// field table interactivity script
		wp_register_script('crown-form-field-table', CROWN_URL.'/src/Resources/Public/js/FormFieldTable.min.js', array('jquery', 'jquery-ui-sortable', 'json2'), false, true);

		// textarea input functionality
		wp_register_script('crown-form-input-textarea', CROWN_URL.'/src/Resources/Public/js/FormInputTextarea.min.js', array('jquery'), false, true);

		// select input functionality
		wp_register_script('crown-form-input-select', CROWN_URL.'/src/Resources/Public/js/FormInputSelect.min.js', array('jquery', 'jquery-ui-sortable', 'select2'), false, true);

		// date input functionality
		wp_register_script('crown-form-input-date', CROWN_URL.'/src/Resources/Public/js/FormInputDate.min.js', array('json2', 'jquery', 'jquery-ui-datepicker'), false, true);

		// color input functionality
		wp_register_script('crown-form-input-color', CROWN_URL.'/src/Resources/Public/js/FormInputColor.min.js', array('jquery', 'wp-color-picker'), false, true);

		// media input functionality
		wp_register_script('crown-form-input-media', CROWN_URL.'/src/Resources/Public/js/FormInputMedia.min.js', array('jquery'), false, true);
		
		// rich text area input helper script
		wp_register_script('crown-form-input-rich-textarea', CROWN_URL.'/src/Resources/Public/js/FormInputRichTextarea.min.js', array('jquery', 'jquery-ui-sortable'), false, true);

		// gallery input functionality
		wp_register_script('crown-form-input-gallery', CROWN_URL.'/src/Resources/Public/js/FormInputGallery.min.js', array('jquery'), false, true);

		// gallery input functionality
		wp_register_script('crown-form-input-checkbox-set', CROWN_URL.'/src/Resources/Public/js/FormInputCheckboxSet.min.js', array('jquery', 'jquery-ui-sortable'), false, true);

		// media input functionality
		wp_register_script('crown-form-input-geo-coordinates', CROWN_URL.'/src/Resources/Public/js/FormInputGeoCoordinates.min.js', array('jquery'), false, true);

		// post taxonomy functionality
		wp_register_script('crown-post-taxonomy', CROWN_URL.'/src/Resources/Public/js/PostTaxonomy.min.js', array('jquery'), false, true);

		// conditional UI rules functionality
		wp_register_script('crown-ui-rule', CROWN_URL.'/src/Resources/Public/js/UIRule.min.js', array('jquery', 'json2'), false, true);

	}


	/**
	 * Register and/or enqueue styles to be used in the WP admin.
	 *
	 * This method is added to the 'admin_enqueue_scripts' action hook.
	 *
	 * @since 2.0.0
	 *
	 * @param string $hook The current admin page's hook.
	 */
	public function registerAdminStyles($hook) {

		wp_register_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css', false, '4.0.5', 'all');

		wp_register_style('codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.43.0/codemirror.min.css', array(), '5.43.0', 'all');

		// form styles
		wp_enqueue_style('crown-form', CROWN_URL.'/src/Resources/Public/css/Form.css');
		
	}


	/**
	 * Duplicates post repeater entries to the duplicate post.
	 *
	 * This method is added to the 'mtphr_post_duplicator_created' action hook from
	 * the [Post Duplicator plugin](https://wordpress.org/plugins/post-duplicator/).
	 *
	 * @since 2.11.7
	 *
	 * @param int $originalId ID of original post from which to copy repeater entries.
	 * @param int $duplicateId ID of duplicate post for which to save duplicate repeater entries.
	 * @param array $settings Duplication settings.
	 */
	public function duplicatePostRepeaterFieldEntries($originalId, $duplicateId, $settings = array()) {
		global $wpdb;

		// retrieve entries to duplicate
		$originalEntries = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'crown_repeater_entry',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_parent' => $originalId,
			'meta_query' => array(
				array(
					'key' => 'crown_repeater_entry_object_type',
					'value' => 'post'
				)
			)
		));

		foreach($originalEntries as $originalEntry) {

			// duplicate entry post
			$duplicateEntryArgs = array(
				'post_status' => 'publish',
				'post_type' => 'crown_repeater_entry',
				'menu_order' => $originalEntry->menu_order,
				'post_parent' => $duplicateId
			);
			$duplicateEntryId = wp_insert_post($duplicateEntryArgs);

			// duplicate entry meta
			$originalEntryMeta = get_post_meta($originalEntry->ID);
			foreach($originalEntryMeta as $key => $value) {
				if(is_array($value) && count($value) > 0) {
					foreach($value as $i => $v) {
						add_post_meta($duplicateEntryId, $key, $v);
					}
				}
			}

			// duplicate entry repeater entries
			$this->duplicatePostRepeaterFieldEntries($originalEntry->ID, $duplicateEntryId, $settings);

		}

	}


	/**
	 * Duplicates post repeater entries to the new tranlated post.
	 *
	 * This method is added to the 'add_meta_boxes' action hook from and
	 * piggybacks off the [Polylang plugin](https://polylang.pro).
	 *
	 * @since 2.11.7
	 *
	 * @param string $postType Type of post.
	 * @param \WP_Post $post Post object for which to copy repeater entries to.
	 */
	public function pllDuplicatePostRepeaterFieldEntries($postType, $post) {
		if(!function_exists('PLL')) return;
		if('post-new.php' == $GLOBALS['pagenow'] && isset($_GET['from_post'], $_GET['new_lang']) && PLL()->model->is_translated_post_type($post->post_type)) {
			$originalId = (int)$_GET['from_post'];
			if(!$originalId) return;
			$this->duplicatePostRepeaterFieldEntries($originalId, $post->ID);
		}
	}


	/**
	 * Prevents certain meta fields from saving to post's repeater entries.
	 *
	 * @param array $data Set of post's meta data.
	 * @param \WP_Post $post Post object for which data is to be saved to.
	 *
	 * @since 2.12.0
	 *
	 * @return array Set of modified post's meta data.
	 */
	public function seofwFilterSaveCustomFields($data, $post) {
		if($post->post_type == 'crown_repeater_entry') {
			$data['exclude_local_search'] = 0;
			$data['exclude_from_archive'] = 0;
		}
		return $data;
	}


	public function filterWpGetAttachmentImageSrc($image = array()) {
		if(!is_array($image) || empty($image)) {
			return $image;
		}
		$wpUploadDir = wp_upload_dir();
		$baseDir = $wpUploadDir['basedir'];
		$baseUrl = $wpUploadDir['baseurl'];
		$absolutePath = str_replace($baseUrl, $baseDir, $image[0]);
		if(file_exists($absolutePath)) {
			return $image;
		}
		$find = get_site_url();
		$replace = CROWN_USE_REMOTE_MEDIA_URL;
		$image[0] = str_replace($find, $replace, $image[0]);
		return $image;
	}


	public function filterWpCalculateImageSrcset($src = array()) {
		if(is_array($src)) {
			$wpUploadDir = wp_upload_dir();
			$baseDir = $wpUploadDir['basedir'];
			$baseUrl = $wpUploadDir['baseurl'];
			$find = get_site_url();
			$replace = CROWN_USE_REMOTE_MEDIA_URL;
			foreach($src as $key => $val) {
				$absolutePath = str_replace($baseUrl, $baseDir, $val['url']);
				if(!file_exists($absolutePath)) {
					$val['url'] = str_replace($find, $replace, $val['url']);
					$src[$key] = $val;
				}
			}
		}
		return $src;
	}


	public function filterWpGetAttachmentUrl($url = '') {
		$wpUploadDir = wp_upload_dir();
		$baseDir = $wpUploadDir['basedir'];
		$baseUrl = $wpUploadDir['baseurl'];
		$find = get_site_url();
		$replace = CROWN_USE_REMOTE_MEDIA_URL;
		$absolute_path = str_replace($baseUrl, $baseDir, $url);
		if(!file_exists($absolute_path)) {
			$url = str_replace($find, $replace, $url);
		}
		return $url;
	}


}