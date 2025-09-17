<?php
/**
 * Plugin Name: Crown Breadcrumbs
 * Description: Adds support for breadcrumb output.
 * Version: 1.2.0
 * Author: Jordan Crown
 * Author URI: http://www.jordancrown.com
 * License: GNU General Pulic License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

use Crown\Post\Type as PostType;
use Crown\Post\Taxonomy;
use Crown\Post\MetaBox;

use Crown\Form\Field;
use Crown\Form\Input\Text as TextInput;


if(defined('CROWN_FRAMEWORK_VERSION') && !class_exists('CrownBreadcrumbs')) {
	class CrownBreadcrumbs {

		public static $init = false;

		public static $breadcrumbTitleOverrideField;


		public static function init() {
			if(self::$init) return;
			self::$init = true;

			self::$breadcrumbTitleOverrideField = new Field(array(
				'label' => 'Breadcrumb Title',
				'input' => new TextInput(array('name' => '_crown_breadcrumb_title')),
				'getOutputCb' => array(__CLASS__, 'addBreadcrumbTitleInputPlaceholder')
			));

			add_action('init', array(__CLASS__, 'registerBreadcrumbTitleFields'), 20);

		}


		public static function addBreadcrumbTitleInputPlaceholder($field, $args) {
			$placeholder = '';

			$screen = get_current_screen();
			if(property_exists($screen, 'base') && $screen->base == 'post') {
				global $post;
				$placeholder = $post->post_title;
			} else if(property_exists($screen, 'base') && $screen->base == 'term') {
				$term = get_term($_GET['tag_ID'], $_GET['taxonomy']);
				$placeholder = $term->name;
			}

			if(!empty($placeholder)) {
				$field->getInput()->setPlaceholder($placeholder);
			}
			
		}


		public static function registerBreadcrumbTitleFields() {

			$applicablePostTypes = array();
			$ignoreTypes = array('attachment', 'revision', 'nav_menu_item', 'cta');

			$postTypes = get_post_types(array(), 'objects');
			foreach($postTypes as $postType) {
				if(in_array($postType->name, $ignoreTypes)) continue;
				if(!$postType->public) continue;
				$applicablePostTypes[] = $postType->name;
			}
			$applicablePostTypes = apply_filters('crown_breadcrumb_settings_post_types', $applicablePostTypes);

			foreach($applicablePostTypes as $postTypeName) {
				$postType = get_post_type_object($postTypeName);
				$pt = new PostType(array(
					'name' => $postType->name,
					'metaBoxes' => array(
						new MetaBox(array(
							'id' => 'breadcrumb-settings',
							'title' => 'Breadcrumb Settings',
							'context' => 'side',
							'priority' => 'low',
							'fields' => array(
								self::$breadcrumbTitleOverrideField
							)
						))
					)
				));
				$pt->register();
			}

			$applicableTaxonomies = array();
			$ignoreTaxonomies = array('post_format');

			$taxonomies = get_taxonomies(array(), 'objects');
			foreach($taxonomies as $taxonomy) {
				if(in_array($taxonomy->name, $ignoreTaxonomies)) continue;
				if(!$taxonomy->public) continue;
				$applicableTaxonomies[] = $taxonomy->name;
			}
			$applicableTaxonomies = apply_filters('crown_breadcrumb_settings_taxonomies', $applicableTaxonomies);

			foreach($applicableTaxonomies as $taxonomyName) {
				$taxonomy = get_taxonomy($taxonomyName);
				$t = new Taxonomy(array(
					'name' => $taxonomy->name,
					'postTypes' => $taxonomy->object_type,
					'fields' => array(
						self::$breadcrumbTitleOverrideField
					)
				));
				$t->register();
			}

		}


		public static function getBreadcrumbs($sep = ' <span class="sep">/</span> ') {

			$items = self::getBreadcrumbItems();
			$breadcrumbs = '';

			$links = array();
			foreach($items as $i => $item) {
				$link = self::getBreadcrumbItemLink($item, $i == count($items) - 1);
				if(!empty($link)) $links[] = $link;
			}
			
			$crumbs = array();
			foreach($links as $i => $link) {
				$crumbs[] = apply_filters('crown_breadcrumb', '<span class="crumb">'.$link.'</span>', $link, $i == count($items) - 1);
			}

			if(!empty($crumbs)) {
				$breadcrumbs = '<div class="breadcrumbs">'.implode($sep, $crumbs).'</div>';
			}

			return apply_filters('crown_breadcrumbs', $breadcrumbs, $crumbs, $sep, $links, $items);
		}


		public static function getBreadcrumbItems() {
			global $post, $wp_query;
			$items = array();

			$rootItem = self::getRootBreadcrumbItem();
			if($rootItem) $items[] = $rootItem;

			if((is_home() || is_post_type_archive())) {

				if(isset($wp_query->query['post_type'])) {
					$items[] = array('pt_archive' => $wp_query->query['post_type']);
				} else if(get_option('show_on_front') == 'page') {
					$postsPageId = get_option('page_for_posts');
					if(!empty($postsPageId)) {
						$items = array_merge($items, self::getPostAncestorBreadcrumbItems($postsPageId));
						$items[] = array('p' => $postsPageId);
					}
				}

			} else if(is_tax() || is_category() || is_tag()) {

				$postType = get_post_type_object(get_post_type());
				if(!$postType) {
					$term = get_queried_object();
					$taxonomy = get_taxonomy($term->taxonomy);
					$postType = !empty($taxonomy->object_type) ? get_post_type_object($taxonomy->object_type[0]) : null;
				}
				if($postType) {
					if($postType->has_archive) {
						$items[] = array('pt_archive' => get_post_type());
					} else if($postType->name == 'post' && get_option('show_on_front') == 'page') {
						$postsPageId = get_option('page_for_posts');
						if(!empty($postsPageId)) {
							$items = array_merge($items, self::getPostAncestorBreadcrumbItems($postsPageId));
							$items[] = array('p' => $postsPageId);
						}
					}
				}

				$items = array_merge($items, self::getTermAncestorBreadcrumbItems(get_queried_object()->term_id, get_queried_object()->taxonomy));

				$items[] = array('tax' => get_queried_object()->taxonomy, 'term' => get_queried_object()->term_id);

			} else if(is_singular()) {

				$postType = get_post_type_object(get_post_type());
				if($postType->has_archive) {
					$items[] = array('pt_archive' => get_post_type());
				} else if($postType->name == 'post' && get_option('show_on_front') == 'page') {
					$postsPageId = get_option('page_for_posts');
					if(!empty($postsPageId)) {
						$items = array_merge($items, self::getPostAncestorBreadcrumbItems($postsPageId));
						$items[] = array('p' => $postsPageId);
					}
				}

				if($postType->name == 'post') {
					$primaryTermId = get_post_meta(get_the_ID(), '_primary_term_category', true);
					$terms = wp_get_object_terms(get_the_ID(), 'category', array('orderby' => 'term_order'));
					if(!empty($terms)) {
						$primaryTerm = false;
						if(!empty($primaryTermId)) {
							foreach($terms as $term) {
								if($term->term_id == $primaryTermId) {
									$primaryTerm = $term;
									break;
								}
							}
						}
						if(!$primaryTerm) $primaryTerm = $terms[0];
						$items = array_merge($items, self::getTermAncestorBreadcrumbItems($primaryTerm->term_id, 'category'));
						$items[] = array('tax' => 'category', 'term' => $primaryTerm->term_id);
					}
				} else if($postType->hierarchical) {
					$items = array_merge($items, self::getPostAncestorBreadcrumbItems(get_the_ID()));
				}

				if($postType->name != 'page' || get_option('show_on_front') != 'page' || get_option('page_on_front') != get_the_ID()) {
					$items[] = array('p' => get_the_ID());
				}

			} else if(is_day() || is_month() || is_year()) {

				if(get_option('show_on_front') == 'page') {
					$postsPageId = get_option('page_for_posts');
					if(!empty($postsPageId)) {
						$items = array_merge($items, self::getPostAncestorBreadcrumbItems($postsPageId));
						$items[] = array('p' => $postsPageId);
					}
				}

				$items[] = array('year' => get_the_time('Y'));
				if(is_month() || is_day()) $items[] = array('year' => get_the_time('Y'), 'month' => get_the_time('m'));
				if(is_day()) $items[] = array('year' => get_the_time('Y'), 'month' => get_the_time('m'), 'day' => get_the_time('j'));

			} else if(is_author()) {

				if(get_option('show_on_front') == 'page') {
					$postsPageId = get_option('page_for_posts');
					if(!empty($postsPageId)) {
						$items = array_merge($items, self::getPostAncestorBreadcrumbItems($postsPageId));
						$items[] = array('p' => $postsPageId);
					}
				}

				global $author;
				$items[] = array('author' => $author);

			} else if(is_search()) {

				$items[] = array('text' => 'Search results for: '.get_search_query());

			} else if(is_404()) {

				$items[] = array('text' => 'Page not Found');

			}

			if(is_paged()) {
				$items[] = array('page' => $wp_query->query['paged']);
			}

			return apply_filters('crown_breadcrumb_items', $items);
		}


		public static function getRootBreadcrumbItem() {
			$item = array();

			$showOnFront = get_option('show_on_front');
			if($showOnFront == 'page') {
				$fontPageId = get_option('page_on_front');
				if(!empty($fontPageId)) $item = array('p' => $fontPageId);
			}

			if(empty($item) && $showOnFront == 'posts') {
				$postsPageId = get_option('page_for_posts');
				if(!empty($postsPageId)) $item = array('p' => $postsPageId);
			}

			if(empty($item)) {
				$item = array('url' => get_home_url(), 'text' => 'Home');
			}

			return $item;
		}


		public static function getPostAncestorBreadcrumbItems($postId) {
			$items = array();

			$frontPostId = get_option('show_on_front') == 'page' ? get_option('page_on_front') : 0;

			$parentId = wp_get_post_parent_id($postId);
			while($parentId != 0 && $parentId != $frontPostId) {
				$items[] = array('p' => $parentId);
				$parentId = wp_get_post_parent_id($parentId);
			}

			return array_reverse($items);
		}


		public static function getTermAncestorBreadcrumbItems($termId, $taxonomy) {
			$items = array();

			$term = get_term($termId, $taxonomy);
			while($term->parent != 0) {
				$items[] = array('tax' => $taxonomy, 'term' => $term->parent);
				$term = get_term($term->parent, $taxonomy);
			}

			return array_reverse($items);
		}


		public static function getBreadcrumbItemLink($item, $last) {
			$link = '';

			$url = '';
			$text = '';

			if(isset($item['p']) && !empty($item['p'])) {

				$post = get_post($item['p']);
				$url = get_permalink($post->ID);
				$text = $post->post_title;
				$titleOverride = get_post_meta($post->ID, '_crown_breadcrumb_title', true);
				if(!empty($titleOverride)) $text = $titleOverride;

			} else if(isset($item['pt_archive']) && !empty($item['pt_archive'])) {

				$postType = get_post_type_object($item['pt_archive']);
                if ( $postType->name === 'product' && do_replace_category_pages_with_hawksearch() ) {
                    $url = get_site_url() . '/search-results';
                } else {
                    $url = get_post_type_archive_link($postType->name);
                }
				$text = $postType->labels->name;

			} else if(isset($item['tax']) && !empty($item['tax']) && isset($item['term']) && !empty($item['term'])) {

				$term = get_term($item['term'], $item['tax']);
                if ( $term->taxonomy === 'product_cat' && do_replace_category_pages_with_hawksearch() ) {
                    $url = get_site_url() . '/search-results?category=' . $term->term_id;
                } else {
                    $url = get_term_link($term->term_id, $term->taxonomy);
                }
				$text = $term->name;
				$titleOverride = get_term_meta($term->term_id, '_crown_breadcrumb_title', true);
				if(!empty($titleOverride)) $text = $titleOverride;

			} else if(isset($item['year']) && !empty($item['year']) && isset($item['month']) && !empty($item['month']) && isset($item['day']) && !empty($item['day'])) {

				$url = get_day_link($item['year'], $item['month'], $item['day']);
				$text = intval($item['day']);

			} else if(isset($item['year']) && !empty($item['year']) && isset($item['month']) && !empty($item['month'])) {

				$url = get_month_link($item['year'], $item['month']);
				$text = $item['month'];

			} else if(isset($item['year']) && !empty($item['year'])) {

				$url = get_year_link($item['year']);
				$text = $item['year'];

			} else if(isset($item['author']) && !empty($item['author'])) {

				$author = get_userdata($item['author']);
				$url = get_author_posts_url($author->ID);
				$text = $author->display_name;

			} else if(isset($item['page']) && !empty($item['page'])) {

				$text = 'Page '.$item['page'];

			}

			if(isset($item['url']) && !empty($item['url'])) {
				$url = $item['url'];
			}
			if(isset($item['text']) && !empty($item['text'])) {
				$text = $item['text'];
			}

			if($last) $url = '';

			$url = apply_filters('crown_breadcrumb_link_url', $url, $item, $last);
			$text = apply_filters('crown_breadcrumb_link_text', $text, $item, $last);

			if(!empty($url) && !empty($text)) {
				$link = '<a href="'.$url.'">'.$text.'</a>';
			} else if(!empty($text)) {
				$link = '<span>'.$text.'</span>';
			}

			return apply_filters('crown_breadcrumb_item_link', $link, $url, $text, $item, $last);
		}


	}
}

if(class_exists('CrownBreadcrumbs')) {
	CrownBreadcrumbs::init();
}