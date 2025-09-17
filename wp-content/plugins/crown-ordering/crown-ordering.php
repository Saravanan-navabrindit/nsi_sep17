<?php
/**
 * Plugin Name: Crown Ordering
 * Description: Adds support for ordering posts and taxonomy terms.
 * Version: 1.2.0
 * Author: Jordan Crown
 * Author URI: http://www.jordancrown.com
 * License: GNU General Pulic License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

use Crown\AdminPage;
use Crown\Post\Taxonomy;

use Crown\Form\Field;
use Crown\Form\FieldGroup;


if(defined('CROWN_FRAMEWORK_VERSION') && !class_exists('CrownOrdering')) {
	class CrownOrdering {

		public static $sortablePostTypes = array('team_member'); // replace with post types to make sortable
		public static $sortableTaxonomies = array(false); // replace with taxonomies to make terms sortable
		public static $sortableTermPostsTaxonomies = array('faq_category'); // replace with taxonomies to make term posts sortable

		public static $init = false;

		public static $postOrderingAdminPages;
		public static $termOrderingAdminPages;
		public static $termPostsTaxonomies;


		public static function init() {
			if(self::$init) return;
			self::$init = true;

			add_action('init', array(__CLASS__, 'addAdminUI'), 20);
			add_action('admin_enqueue_scripts', array(__CLASS__, 'registerAdminScripts'));
			add_action('admin_enqueue_scripts', array(__CLASS__, 'registerAdminStyles'));
			add_action('wp_ajax_update_post_order_meta_data', array(__CLASS__, 'updatePostOrderMetaData'));
			add_action('wp_ajax_update_term_order_meta_data', array(__CLASS__, 'updateTermOrderMetaData'));

			add_filter('posts_clauses', array(__CLASS__, 'filterPostQueryClauses'), 10, 2);
			add_filter('get_terms_orderby', array(__CLASS__, 'filterGetTermsOrderBy'), 10, 3);
			add_filter('terms_clauses', array(__CLASS__, 'filterGetTermsQueryClauses'), 10, 3);

		}


		public static function getSortablePostTypes() {
			$sortablePostTypes = self::$sortablePostTypes;
			if(empty($sortablePostTypes)) $sortablePostTypes = self::getEligibleSortablePostTypes();
			return $sortablePostTypes;
		}


		protected static function getEligibleSortablePostTypes() {
			$sortablePostTypes = array();
			$ignoreTypes = array('attachment', 'revision', 'nav_menu_item');

			$postTypes = get_post_types(array(), 'objects');
			foreach($postTypes as $postType) {
				if(in_array($postType->name, $ignoreTypes)) continue;
				if(post_type_supports($postType->name, 'page-attributes') || is_post_type_hierarchical($postType->name)) {
					$sortablePostTypes[] = $postType->name;
				}
			}

			return $sortablePostTypes;
		}


		public static function getSortableTaxonomies() {
			$sortableTaxonomies = self::$sortableTaxonomies;
			if(empty($sortableTaxonomies)) $sortableTaxonomies = self::getEligibleSortableTaxonomies();
			return $sortableTaxonomies;
		}


		protected static function getEligibleSortableTaxonomies() {
			$sortableTaxonomies = array();
			$ignoreTaxonomies = array('attachment', 'revision', 'nav_menu_item');

			$taxonomies = get_taxonomies(array());
			foreach($taxonomies as $taxonomy) {
				if(in_array($taxonomy, $ignoreTaxonomies)) continue;
				if(is_taxonomy_hierarchical($taxonomy)) {
					$sortableTaxonomies[] = $taxonomy;
				}
			}

			return $sortableTaxonomies;
		}


		public static function getSortableTermPostsTaxonomies() {
			$sortableTermPostsTaxonomies = self::$sortableTermPostsTaxonomies;
			if(empty($sortableTermPostsTaxonomies)) $sortableTermPostsTaxonomies = self::getEligibleSortableTermPostsTaxonomies();
			return $sortableTermPostsTaxonomies;
		}


		protected static function getEligibleSortableTermPostsTaxonomies() {
			$sortableTermPostsTaxonomies = array();
			$ignoreTaxonomies = array('attachment', 'revision', 'nav_menu_item');

			$taxonomies = get_taxonomies(array());
			foreach($taxonomies as $taxonomy) {
				if(in_array($taxonomy, $ignoreTaxonomies)) continue;
				if(is_taxonomy_hierarchical($taxonomy)) {
					$sortableTermPostsTaxonomies[] = $taxonomy;
				}
			}

			return $sortableTermPostsTaxonomies;
		}


		public static function addAdminUI() {

			$sortablePostTypes = self::getSortablePostTypes();
			foreach($sortablePostTypes as $postType) {
				$postType = get_post_type_object($postType);
				if($postType) {
					$parentSlug = $postType->name == 'post' ? 'edit.php' : 'edit.php?post_type='.$postType->name;
					self::$postOrderingAdminPages[$postType->name] = new AdminPage(array(
						'key' => $postType->name.'-order',
						'parent' => $parentSlug,
						'title' => $postType->labels->singular_name.' Order',
						'capability' => 'edit_others_pages',
						'outputCb' => array(__CLASS__, 'outputPostOrderingAdminPage')
					));
				}
			}

			$sortableTaxonomies = self::getSortableTaxonomies();
			foreach($sortableTaxonomies as $taxonomy) {
				$taxonomy = get_taxonomy($taxonomy);
				if($taxonomy && property_exists($taxonomy, 'object_type')) {
					$objectTypes = (array)$taxonomy->object_type;
					foreach($objectTypes as $objectType) {
						$parentSlug = $objectType == 'post' ? 'edit.php' : 'edit.php?post_type='.$objectType;
						self::$termOrderingAdminPages[$taxonomy->name.'-'.$objectType] = new AdminPage(array(
							'key' => $taxonomy->name.'-order',
							'parent' => $parentSlug,
							'title' => $taxonomy->labels->singular_name.' Order',
							'capability' => 'edit_others_pages',
							'outputCb' => array(__CLASS__, 'outputTermOrderingAdminPage')
						));
					}
				}
			}

			$sortableTermPostsTaxonomies = self::getSortableTermPostsTaxonomies();
			foreach($sortableTermPostsTaxonomies as $taxonomy) {
				$taxonomy = get_taxonomy($taxonomy);
				if($taxonomy && property_exists($taxonomy, 'object_type')) {
					$sortingFields = array();
					$objectTypes = (array)$taxonomy->object_type;
					foreach($objectTypes as $objectType) {
						$object = get_post_type_object($objectType);
						$sortingFields[] = new FieldGroup(array(
							'label' => $object->labels->singular_name.' Order',
							'getOutputCb' => array(__CLASS__, 'getTaxonomyTermPostSortingFieldGroupOutput'),
							'atts' => array('data-post-type' => $objectType),
							'fields' => array(
								new Field(array(
									'getOutputCb' => array(__CLASS__, 'getTaxonomyTermPostSortingFieldOutput'),
									'saveMetaCb' => array(__CLASS__, 'saveTaxonomyTermPostSortingFieldMeta'),
									'atts' => array('data-post-type' => $objectType)
								))
							)
						));
					}
					if(!empty($sortingFields)) {
						self::$termPostsTaxonomies[$taxonomy->name] = new Taxonomy(array(
							'name' => $taxonomy->name,
							'postTypes' => true,
							'fields' => $sortingFields
						));
						self::$termPostsTaxonomies[$taxonomy->name]->register();
					}
				}
			}

		}


		public static function outputPostOrderingAdminPage() {
			$screen = get_current_screen();
			$postType = get_post_type_object($screen->post_type);
			?>
				<div id="sortable-posts-list">
					<?php self::outputPostList($postType->name); ?>
				</div>
				<div class="sortable-posts-controls">
					<button type="button" class="button button-primary button-large save-sortable-posts-list">Save Changes</button>
					<span class="spinner"></span>
				</div>
			<?php
		}


		protected static function outputPostList($postType, $parentId = 0) {
			global $post;

			$postQuery = new \WP_Query(array(
				'posts_per_page' => -1,
				'post_type' => $postType,
				'post_parent' => $parentId,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'post_status' => array('publish', 'pending', 'draft', 'future', 'private')
			));
			if(!$postQuery->have_posts()) return;

			$isHierarchical = is_post_type_hierarchical($postType);

			?>
				<ol>
					<?php while($postQuery->have_posts()) { $postQuery->the_post(); ?>
						<li id="post-<?php echo $post->ID; ?>" <?php echo !$isHierarchical ? 'class="mjs-nestedSortable-no-nesting"' : ''; ?>>
							<div class="sortable-post">
								<span class="title"><?php the_title(); ?></span>
								<span class="collapse-toggle"></span>
							</div>
							<?php self::outputPostList($postType, $post->ID); ?>
						</li>
					<?php } wp_reset_postdata(); ?>
				</ol>
			<?php
		}


		public static function outputTermOrderingAdminPage() {
			$screen = get_current_screen();
			$postType = get_post_type_object($screen->post_type ? $screen->post_type : 'post');
			$taxonomy = get_taxonomy(preg_replace(array('/^'.$postType->name.'s?_page_/', '/-order$/'), array(''), $screen->id));
			?>
				<div id="sortable-terms-list">
					<?php self::outputTermList($taxonomy->name); ?>
				</div>
				<div class="sortable-terms-controls">
					<button type="button" class="button button-primary button-large save-sortable-terms-list">Save Changes</button>
					<span class="spinner"></span>
				</div>
			<?php
		}


		protected static function outputTermList($taxonomy, $parentId = 0) {

			$terms = get_terms($taxonomy, array(
				'orderby' => 'menu_order',
				'hide_empty' => false,
				'parent' => $parentId
			));
			if(empty($terms)) return;

			$isHierarchical = is_taxonomy_hierarchical($taxonomy);

			?>
				<ol>
					<?php foreach($terms as $term) { ?>
						<li id="term-<?php echo $term->term_id; ?>" <?php echo !$isHierarchical ? 'class="mjs-nestedSortable-no-nesting"' : ''; ?>>
							<div class="sortable-term">
								<span class="title"><?php echo $term->name; ?></span>
								<span class="collapse-toggle"></span>
							</div>
							<?php self::outputTermList($taxonomy, $term->term_id); ?>
						</li>
					<?php } ?>
				</ol>
			<?php
		}


		public static function getTaxonomyTermPostSortingFieldGroupOutput($field, $args) {
			if(empty($args['objectId'])) return '<!-- post sorting disabled -->';

			$fieldAtts = $field->getAtts();
			if(!isset($fieldAtts['data-post-type']) || empty($fieldAtts['data-post-type'])) return '<!-- post sorting disabled -->';

			$term = get_term($args['objectId']);
			$posts = get_posts(array(
				'post_type' => $fieldAtts['data-post-type'],
				'posts_per_page' => 1,
				'tax_query' => array(
					array(
						'taxonomy' => $term->taxonomy,
						'terms' => $term->term_id
					)
				)
			));
			if(empty($posts)) return '<!-- post sorting disabled -->';

			return '';
		}


		public static function getTaxonomyTermPostSortingFieldOutput($field, $args) {
			if(empty($args['objectId'])) return '<!-- post sorting disabled -->';

			$fieldAtts = $field->getAtts();
			if(!isset($fieldAtts['data-post-type']) || empty($fieldAtts['data-post-type'])) return '<!-- post sorting disabled -->';

			$term = get_term($args['objectId']);
			$queryArgs = array(
				'post_type' => $fieldAtts['data-post-type'],
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => $term->taxonomy,
						'terms' => $term->term_id
					)
				)
			);

			// $posts = array_merge(get_posts(array_merge($queryArgs, array(
			// 	'meta_query' => array(
			// 		array(
			// 			'key' => $term->taxonomy.'_'.$args['objectId'].'_order',
			// 			'compare' => 'NOT EXISTS'
			// 		)
			// 	)
			// ))), get_posts(array_merge($queryArgs, array(
			// 	'meta_key' => $term->taxonomy.'_'.$args['objectId'].'_order',
			// 	'orderby' => 'meta_value_num',
			// 	'order' => 'ASC'
			// ))));
			$posts = get_posts(array_merge($queryArgs, array(
				'orderby' => 'tax_'.$term->taxonomy.'_'.$term->term_id.'_order',
				'order' => 'ASC',
				'suppress_filters' => false
			)));
			if(empty($posts)) return '<!-- post sorting disabled -->';

			ob_start();
			?>
				<div class="sortable-taxonomy-posts-list">
					<ol>
						<?php foreach($posts as $post) { ?>
							<li id="post-<?php echo $post->ID; ?>">
								<div class="sortable-post">
									<input type="hidden" name="<?php echo $term->taxonomy; ?>_<?php echo $fieldAtts['data-post-type']; ?>_order[]" value="<?php echo $post->ID; ?>">
									<span class="title"><?php echo !empty($post->post_title) ? $post->post_title : '(no title)'; ?></span>
								</div>
							</li>
						<?php } ?>
					</ol>
				</div>
			<?php
			return ob_get_clean();
		}


		public static function saveTaxonomyTermPostSortingFieldMeta($field, $input, $type, $objectId, $value) {

			$fieldAtts = $field->getAtts();
			if(!isset($fieldAtts['data-post-type']) || empty($fieldAtts['data-post-type'])) return;

			$term = get_term($objectId);

			$inputName = $term->taxonomy.'_'.$fieldAtts['data-post-type'].'_order';
			$postIds = isset($input[$inputName]) ? $input[$inputName] : array();
			foreach($postIds as $i => $postId) {
				update_post_meta($postId, '_'.$term->taxonomy.'_'.$objectId.'_order', $i + 1);
			}
		}


		public static function registerAdminScripts($hook) {

			wp_register_script('jquery-ui-nested-sortable', plugins_url('assets/js/jquery.mjs.nestedSortable.js', __FILE__), array('jquery-ui-sortable'));
			wp_register_script('crown-ordering-admin-post-ordering', plugins_url('assets/js/admin-post-ordering.min.js', __FILE__), array('jquery-ui-nested-sortable'));
			wp_register_script('crown-ordering-admin-term-ordering', plugins_url('assets/js/admin-term-ordering.min.js', __FILE__), array('jquery-ui-nested-sortable'));
			wp_register_script('crown-ordering-admin-term-post-ordering', plugins_url('assets/js/admin-term-post-ordering.min.js', __FILE__), array('jquery-ui-sortable'));

			$screen = get_current_screen();

			$sortablePostTypes = self::getSortablePostTypes();
			if(in_array($screen->post_type, $sortablePostTypes)) {
				wp_enqueue_script('crown-ordering-admin-post-ordering');
				wp_localize_script('crown-ordering-admin-post-ordering', 'crownOrderingAdminPostOrderingData', array(
					'ajaxUrl' => admin_url('admin-ajax.php'),
					'isHierarchical' => is_post_type_hierarchical($screen->post_type)
				));
			}

			if(property_exists($screen, 'post_type') && preg_match('/^'.($screen->post_type ? $screen->post_type : 'post').'s?_page_(.+)-order$/', $screen->id, $matches)) {
				$taxonomy = get_taxonomy($matches[1]);
				if($taxonomy && in_array($taxonomy->name, self::getSortableTaxonomies())) {
					wp_enqueue_script('crown-ordering-admin-term-ordering');
					wp_localize_script('crown-ordering-admin-term-ordering', 'crownOrderingAdminTermOrderingData', array(
						'ajaxUrl' => admin_url('admin-ajax.php'),
						'isHierarchical' => is_post_type_hierarchical($screen->post_type),
						'taxonomy' => $taxonomy->name
					));
				}
			}

			if($screen->base == 'term' && preg_match('/^edit-(.+)/', $screen->id, $matches)) {
				if(in_array($matches[1], self::getSortableTermPostsTaxonomies())) wp_enqueue_script('crown-ordering-admin-term-post-ordering');
			}

		}


		public static function registerAdminStyles($hook) {

			wp_register_style('crown-ordering-admin-post-ordering', plugins_url('assets/css/admin-post-ordering.css', __FILE__));
			wp_register_style('crown-ordering-admin-term-ordering', plugins_url('assets/css/admin-term-ordering.css', __FILE__));
			wp_register_style('crown-ordering-admin-term-post-ordering', plugins_url('assets/css/admin-term-post-ordering.css', __FILE__));

			$screen = get_current_screen();

			$sortablePostTypes = self::getSortablePostTypes();
			if(in_array($screen->post_type, $sortablePostTypes)) {
				wp_enqueue_style('crown-ordering-admin-post-ordering');
			}

			if(property_exists($screen, 'post_type') && preg_match('/^'.($screen->post_type ? $screen->post_type : 'post').'s?_page_(.+)-order$/', $screen->id, $matches)) {
				$taxonomy = get_taxonomy($matches[1]);
				if($taxonomy && in_array($taxonomy->name, self::getSortableTaxonomies())) {
					wp_enqueue_style('crown-ordering-admin-term-ordering');
				}
			}

			if($screen->base == 'term' && preg_match('/^edit-(.+)/', $screen->id, $matches)) {
				if(in_array($matches[1], self::getSortableTermPostsTaxonomies())) wp_enqueue_style('crown-ordering-admin-term-post-ordering');
			}

		}


		public static function updatePostOrderMetaData() {
			if(current_user_can('edit_others_pages')) {
				$updatedPosts = isset($_POST['updatedPosts']) ? $_POST['updatedPosts'] : array();
				foreach($updatedPosts as $updatedPost) wp_update_post($updatedPost);
			}
			die();
		}


		public static function updateTermOrderMetaData() {
			if(current_user_can('edit_others_pages')) {
				$taxonomy = isset($_POST['taxonomy']) ? $_POST['taxonomy'] : '';
				if(taxonomy_exists($taxonomy)) {
					$updatedTerms = isset($_POST['updatedTerms']) ? $_POST['updatedTerms'] : array();
					foreach($updatedTerms as $updatedTerm) {
						wp_update_term($updatedTerm['term_id'], $taxonomy, array(
							'parent' => $updatedTerm['parent']
						));
						update_term_meta($updatedTerm['term_id'], '_menu_order', $updatedTerm['menu_order']);
					}
				}
			}
			die();
		}


		public static function filterPostQueryClauses($clauses, $query) {
			global $wpdb;

			$orderby = $query->get('orderby');
			$orderByHandled = $orderby;
    		if (!empty($orderby) && is_array($orderby)) {
	    		$orderByHandled = reset($orderby);
			}
			if (!is_string($orderByHandled)) {
                $orderByHandled = strval($orderByHandled);
            }

			if(!empty($orderby) && preg_match('/^tax_(.+)_([0-9]+)_order$/', $orderByHandled, $matches)) {

				$metaKey = '_'.$matches[1].'_'.$matches[2].'_order';
				$clauses['join'] .= ' LEFT OUTER JOIN '.$wpdb->postmeta.' AS pm_order ON pm_order.post_id = wp_posts.ID AND pm_order.meta_key = \''.$metaKey.'\'';

				$clauses['orderby'] = 'pm_order.meta_value+0';
				if(!empty($query->get('order'))) $clauses['orderby'] .= ' '.$query->get('order');

			}
			
			return $clauses;
		}


		public static function filterGetTermsOrderBy($orderby, $args, $taxonomies) {
			if(strtolower($args['orderby']) == 'menu_order') $orderby = 'tm_order.meta_value+0';
			return $orderby;
		}


		public static function filterGetTermsQueryClauses($clauses, $taxonomies, $args) {
			global $wpdb;
			if(strtolower($args['orderby']) == 'menu_order') {
				$clauses['join'] .= ' LEFT OUTER JOIN '.$wpdb->termmeta.' AS tm_order ON tm_order.term_id = t.term_id AND tm_order.meta_key = \'_menu_order\'';
			}
			return $clauses;
		}


		public static function getOrderedTermPosts($termId, $taxonomy, $postType, $queryArgs = array()) {

			$queryArgs['orderby'] = 'tax_'.$taxonomy.'_'.$termId.'_order';
			$queryArgs['suppress_filters'] = false;

			$queryArgs = array_merge(array(
				'post_type' => $postType,
				'posts_per_page' => -1,
				'order' => 'ASC',
				'tax_query' => array()
			), $queryArgs);

			$queryArgs['tax_query'][] = array(
				'taxonomy' => $taxonomy,
				'terms' => $termId
			);

			return get_posts($queryArgs);

		}


	}
}

if(class_exists('CrownOrdering')) {
	CrownOrdering::init();
}
