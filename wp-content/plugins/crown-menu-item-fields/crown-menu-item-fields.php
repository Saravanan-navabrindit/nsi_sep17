<?php
/**
 * Plugin Name: Crown Menu Item Fields
 * Description: Adds additional fields to the menu item editor.
 * Version: 1.0.0
 * Author: Jordan Crown
 * Author URI: http://www.jordancrown.com
 * License: GNU General Pulic License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

use Crown\Form\Input\Media as MediaInput;
use Crown\Form\Input\Text as TextInput;
use Crown\Form\Input\Textarea;
use Crown\Form\Input\Select;
use Crown\Form\Input\CheckboxSet;


// make sure to include inherited walker class
if(is_admin()) {
	include_once(ABSPATH.'/wp-admin/includes/nav-menu.php');
}


if(defined('CROWN_FRAMEWORK_VERSION') && !class_exists('CrownMenuItemFields')) {
	class CrownMenuItemFields {

		public static $init = false;

		protected static $relatedPostOptions = array();


		public static function init() {
			if(self::$init) return;
			self::$init = true;

			add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueueAdminScripts'));
			add_filter('wp_edit_nav_menu_walker', array(__CLASS__, 'filterEditNavMenuWalker'), 10, 2);
			add_action('wp_update_nav_menu_item', array(__CLASS__, 'saveNavMenuItemMeta'), 10, 3);
			add_filter('manage_nav-menus_columns', array(__CLASS__, 'filterManageNavMenuColumns'), 11);

		}


		public static function enqueueAdminScripts($hook) {
			if($hook == 'nav-menus.php') {
				wp_enqueue_media();
				wp_enqueue_script('crown-form-input-media');
			}
		}


		public static function filterEditNavMenuWalker($walker, $menuId) {
			return 'MenuItemMetaNavWalker';
		}


		public static function saveNavMenuItemMeta($menuId, $menuItemId, $args) {

			$metaKeys = array(
				// 'menu-item-contents' => 'content',
				// 'menu-item-thumbnails' => 'thumbnail',
				// 'menu-item-related-posts' => 'related_post',
				// 'menu-item-options' => 'options',
				// 'menu-item-ctas' => 'cta',
				'menu-item-cta-link-urls' => 'cta_link_url',
				'menu-item-cta-link-labels' => 'cta_link_label',
			);

			foreach($metaKeys as $key => $metaKey) {
				$value = isset($_REQUEST[$key]) && is_array($_REQUEST[$key]) && array_key_exists($menuItemId, $_REQUEST[$key]) ? $_REQUEST[$key][$menuItemId] : '';
				if(empty($value) && in_array($metaKey, array('options'))) $value = array();
				update_post_meta($menuItemId, $metaKey, $value);
			}

		}


		public static function filterManageNavMenuColumns($columns) {
			return array_merge($columns, array(
				// 'content' => 'Content',
				// 'thumbnail' => 'Thumbnail',
				// 'related_post' => 'Related Post',
				// 'options' => 'Options',
				'cta' => 'CTA'
			));
		}


	}
}


if(class_exists('Walker_Nav_Menu_Edit') && !class_exists('MenuItemMetaNavWalker')) {
	class MenuItemMetaNavWalker extends Walker_Nav_Menu_Edit {

		public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			parent::start_el($output, $item, $depth, $args, $id);

			// retrieve current item's meta data
			$itemMeta = array(
				// 'content' => get_post_meta($item->ID, 'content', true),
				// 'thumbnail' => get_post_meta($item->ID, 'thumbnail', true),
				// 'related_post' => get_post_meta($item->ID, 'related_post', true),
				// 'options' => get_post_meta($item->ID, 'options', true),
				// 'cta' => get_post_meta($item->ID, 'cta', true),
				'cta_link_url' => get_post_meta($item->ID, 'cta_link_url', true),
				'cta_link_label' => get_post_meta($item->ID, 'cta_link_label', true),
			);
			if(empty($itemMeta['options'])) $itemMeta['options'] = array();
			
			// configure fields
			// $contentInput = new Textarea(array('name' => 'menu-item-contents['.$item->ID.']', 'defaultValue' => $itemMeta['content'], 'rows' => 10, 'class' => 'widefat'));
			// $thumbnailInput = new MediaInput(array('name' => 'menu-item-thumbnails['.$item->ID.']', 'defaultValue' => $itemMeta['thumbnail'], 'buttonLabel' => 'Select Image', 'mimeType' => 'image'));
			// $relatedPostInput = new Select(array('name' => 'menu-item-related-posts['.$item->ID.']', 'defaultValue' => $itemMeta['related_post'], 'options' => $relatedPostOptions, 'class' => 'widefat'));
			// $optionsInput = new CheckboxSet(array('name' => 'menu-item-options['.$item->ID.']', 'defaultValue' => $itemMeta['options'], 'class' => 'widefat', 'options' => array(
			// 	array('value' => 'display-as-mega-menu', 'label' => 'Display as mega menu')
			// )));
			// $ctaInput = new TextInput(array('name' => 'menu-item-ctas['.$item->ID.']', 'defaultValue' => $itemMeta['cta'], 'class' => 'widefat'));
			$ctaLinkUrlInput = new TextInput(array('name' => 'menu-item-cta-link-urls['.$item->ID.']', 'defaultValue' => $itemMeta['cta_link_url'], 'class' => 'widefat', 'placeholder' => 'https://'));
			$ctaLinkLabelInput = new TextInput(array('name' => 'menu-item-cta-link-labels['.$item->ID.']', 'defaultValue' => $itemMeta['cta_link_label'], 'class' => 'widefat', 'placeholder' => 'Learn More'));

			// create custom field output
			ob_start();
			?>
				<div class="custom-fields">

					<?php /*<p class="field-content description description-wide">
						<label>Content</label><br>
						<?php $contentInput->output(); ?>
					</p>

					<p class="field-thumbnail description description-wide">
						<label>Thumbnail</label><br>
						<?php $thumbnailInput->output(); ?>
					</p>

					<p class="field-related_post description description-wide">
						<label>Related Post</label><br>
						<?php $relatedPostInput->output(); ?>
					</p>

					<?php if($depth == 0) { ?>
						<div class="field-options description description-wide" style="margin-top: 4px; margin-bottom: 8px;">
							<?php $optionsInput->output(); ?>
						</div>
					<?php } ?>*/ ?>

					<fieldset class="field-cta description description-wide" style="margin-top: 10px; margin-bottom: 10px; padding: 6px 10px 8px; border: 1px solid #ccc; box-sizing: border-box;">
						<legend>Menu CTA</legend>
						<?php /*<p class="description description-wide">
							<label>Call to Action</label><br>
							<?php $ctaInput->output(); ?>
						</p>*/ ?>
						<p class="description description-wide">
							<label>Link URL</label><br>
							<?php $ctaLinkUrlInput->output(); ?>
						</p>
						<p class="description description-wide">
							<label>Link Label</label><br>
							<?php $ctaLinkLabelInput->output(); ?>
						</p>
					</fieldset>

				</div>
			<?php
			$metaOutput = ob_get_clean();

			// insert custom fields into default output
			$output = preg_replace('/(<\/p>)\s*(<(?:fieldset|p) class="field-move)/', "$1$metaOutput$2", $output);
		}

	}
}


if(class_exists('CrownMenuItemFields')) {
	CrownMenuItemFields::init();
}