<?php
/**
 * Generic functions.
 *
 * These functions may be used to supplement WordPress' built-in functions.
 */


global $preprocess_shortcode_tags;
if(!isset($preprocess_shortcode_tags)) {
	/**
	 * Global shortcodes registered to be preprocessed.
	 *
	 * @since 2.0.0
	 *
	 * @var callable[]
	 */
	$preprocess_shortcode_tags = array();
}


if(!function_exists('add_preprocess_shortcode')) {
	/**
	 * Add a shortcode to be preprocessed.
	 *
	 * Preprocess shortcodes will be processed before the auto p routine during
	 * the 'the_content' filter hook.
	 *
	 * ```
	 * add_preprocess_shortcode('my_shortcode', 'myShortcodeCallback');
	 * ```
	 *
	 * @since 2.0.0
	 *
	 * @param string $tag Shortcode tag to register.
	 * @param callable $callback Shortcode output callback method.
	 */
	function add_preprocess_shortcode($tag, $callback) {
		global $preprocess_shortcode_tags;
		if(!array_key_exists($tag, $preprocess_shortcode_tags)) {
			$preprocess_shortcode_tags[$tag] = $callback;
			add_shortcode($tag, $callback);
		}
	}
}


if(!function_exists('preprocess_shortcodes')) {
	/**
	 * Process shortcodes that have been registered to be preprocessed.
	 *
	 * **Automatically registered on the `the_content` filter hook.**
	 *
	 * Any shortcodes that have been registered to be processed before the auto
	 * p routine will be applied.
	 *
	 * @since 2.0.0
	 *
	 * @param string $content Unprocessed content on which to perform shortcode processing.
	 *
	 * @return string Content that has been processed by preprocess shortcodes.
	 */
	function preprocess_shortcodes($content) {
		global $shortcode_tags, $preprocess_shortcode_tags;
		$orig_shortcode_tags = $shortcode_tags;
		remove_all_shortcodes();
		foreach($preprocess_shortcode_tags as $k => $v) {
			add_shortcode($k, $v);
		}
		$content = do_shortcode($content);
		$shortcode_tags = $orig_shortcode_tags;
		return $content;
	}
	add_filter('the_content', 'preprocess_shortcodes', 7);
}


if(!function_exists('get_term_meta')) {
	/**
	 * Retrieve metadata for a taxonomy term.
	 *
	 * @deprecated 2.6.1 Now an internal WP function.
	 *
	 * @since 2.0.0
	 *
	 * @param int $termId Term ID.
	 * @param string $key Optional. The metadata name to retrieve. By default, returns data for all keys.
	 * @param boolean $single Optional. Whether to return a single value. By default, returns all values for key.
	 *
	 * @return mixed Will be an array if $single is false. Will be value of metadata field if $single is true.
	 */
	function get_term_meta($termId, $key = '', $single = false) {
		return get_metadata('term', $termId, $key, $single);
	}
}


if(!function_exists('add_term_meta')) {
	/**
	 * Add metadata to a taxonomy term.
	 *
	 * @deprecated 2.6.1 Now an internal WP function.
	 *
	 * @since 2.0.0
	 *
	 * @param int $termId Term ID.
	 * @param string $key Metadata name.
	 * @param mixed $value Metadata value. Must be serializable if non-scalar.
	 * @param boolean $unique Optional. Whether the same key should not be added. By default, adds for existing key.
	 *
	 * @return int|bool Metadata ID on success, false on failure.
	 */
	function add_term_meta($termId, $key, $value, $unique = false) {
		return add_metadata('term', $termId, $key, $value, $unique);
	}
}


if(!function_exists('update_term_meta')) {
	/**
	 * Update metadata for a taxonomy term.
	 *
	 * @deprecated 2.6.1 Now an internal WP function.
	 *
	 * @since 2.0.0
	 *
	 * @param int $termId Term ID.
	 * @param string $key Metadata name.
	 * @param mixed $value Metadata value. Must be serializable if non-scalar.
	 * @param string $previousValue Optional. Previous value to replace. By default, replaces all entries for meta key.
	 *
	 * @return int|bool Metadata ID if the key didn't exist, true on successful update, false on failure.
	 */
	function update_term_meta($termId, $key, $value, $previousValue = '') {
		return update_metadata('term', $termId, $key, $value, $previousValue);
	}
}


if(!function_exists('delete_term_meta')) {
	/**
	 * Remove metadata from a taxonomy term.
	 *
	 * @deprecated 2.6.1 Now an internal WP function.
	 *
	 * @since 2.0.0
	 *
	 * @param int $termId Term ID.
	 * @param string $key Metadata name.
	 * @param string $previousValue Optional. Metadata value. Must be serializable if non-scalar. By default, removes all entries for meta key.
	 *
	 * @return boolean True on success, false on failure.
	 */
	function delete_term_meta($termId, $key, $previousValue = '') {
		return delete_metadata('term', $termId, $key, $previousValue);
	}
}


if(!function_exists('get_repeater_entries')) {
	/**
	 * Retrieve repeater entries' metadata.
	 *
	 * ```
	 * $entries = get_repeater_entries('post', 'my_repeater_field', $postId);
	 * ```
	 *
	 * Along with the meta data associated with each entry, the entry's ID is
	 * included in the returned data array.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Metadata's object type. Available options: site|blog|post|user|term.
	 * @param string $key Metadata name.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return array[] Array of metadata key-value pair arrays for each repeater entry.
	 */
	function get_repeater_entries($type = 'site', $key = '', $objectId = 0) {
		if(empty($key)) return array();

		// fetch all entry posts
		$entryQueryArgs = array(
			'posts_per_page' => -1,
			'post_type' => 'crown_repeater_entry',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => 'crown_repeater_entry_object_type',
					'value' => $type
				),
				array(
					'key' => 'crown_repeater_entry_name',
					'value' => $key
				)
			)
		);
		if(!in_array($type, array('site, blog'))) {
			$entryQueryArgs['post_parent'] = $objectId;
		}
		$entries = get_posts($entryQueryArgs);

		// build metadata array
		$value = array();
		foreach($entries as $entryPost) {
			$entryMeta = get_post_meta($entryPost->ID);
			$entryData = array('id' => $entryPost->ID);
			foreach($entryMeta as $key => $metaData) {
				if(in_array($key, array('crown_repeater_entry_object_type', 'crown_repeater_entry_name'))) continue;
				$entryData[$key] = maybe_unserialize(count($metaData) == 1 ? $metaData[0] : $metaData);
			}
			$value[] = $entryData;
		}

		return $value;
	}
}


if(!function_exists('locate_template_with_fallback')) {
	/**
	 * Locates theme template with fallback of designated directories.
	 *
	 * This function is useful for locating templates to output HTML from a
	 * plugin while allowing a theme to override the template.
	 *
	 * ```
	 * $template = locate_template_with_fallback('custom-template.php', plugin_dir_path(__FILE__).'/templates');
	 * if($template) {
	 * 	include($template);
	 * }
	 * ```
	 *
	 * @param  string|string[] $templateNames Template name(s) to locate.
	 * @param  string|string[] $fallbackPaths File paths to fallback directories to include in location process.
	 * @param  boolean $load Specifies whether to autoload template, if found.
	 * @param  boolean $requireOnce If autoloading template, specifies whether or not to require it only once.
	 *
	 * @return string The template filename, if one is located, otherwise an empty string.
	 */
	function locate_template_with_fallback($templateNames, $fallbackPaths = array(), $load = false, $requireOnce = true) {

		// try default locations (stylesheet and template directories)
		$located = locate_template($templateNames, $load, $requireOnce);
		if($located != '') return $located;

		// try to locate template
		foreach((array)$templateNames as $templateName) {
			if(!$templateName) continue;
			foreach((array)$fallbackPaths as $fallbackPath) {
				if(file_exists($fallbackPath.'/'.$templateName)) {
					$located = $fallbackPath.'/'.$templateName;
					break;
				}
			}
		}

		// load template, if specified
		if($load && '' != $located) load_template($located, $requireOnce);
		return $located;
	}
}