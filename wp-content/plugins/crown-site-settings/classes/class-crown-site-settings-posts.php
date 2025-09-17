<?php

use Crown\AdminPage;
use Crown\Form\Field;
use Crown\Form\FieldGroup;
use Crown\Form\FieldGroupSet;
use Crown\Form\Input\CheckboxSet;
use Crown\Form\Input\Media as MediaInput;
use Crown\Form\Input\RadioSet;
use Crown\Form\Input\Select;
use Crown\Form\Input\Text as TextInput;
use Crown\Form\Input\Checkbox as CheckboxInput;
use Crown\Form\Input\Color as ColorInput;
use Crown\Form\Input\Textarea;
use Crown\ListTableColumn;
use Crown\Post\MetaBox;
use Crown\Post\Taxonomy;
use Crown\Post\Type as PostType;
use Crown\UIRule;


if ( ! class_exists( 'Crown_Site_Settings_Posts' ) ) {
	class Crown_Site_Settings_Posts {

		public static $init = false;

		public static $post_types = array();
		public static $post_category_taxonomy = null;
		public static $post_topic_taxonomy = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			$plugin_file = preg_replace( '/\/classes$/', '', dirname( __FILE__ ) ) . '/plugin.php';
			register_activation_hook( $plugin_file, array( __CLASS__, 'activate' ));
			register_deactivation_hook( $plugin_file, array( __CLASS__, 'deactivate' ));

			add_action( 'after_setup_theme', array( __CLASS__, 'register_post_fields' ) );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_post_category_taxonomy_fields' ) );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_post_topic_taxonomy' ) );
			add_action( 'init', array( __CLASS__, 'register_post_template' ) );

			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'register_admin_styles' ) );

			add_filter( 'post_class', array( __CLASS__, 'filter_post_class' ), 10, 3 );
			add_filter( 'post_link', array( __CLASS__, 'filter_post_link' ), 10, 3 );

		}


		public static function activate() {
			global $wp_roles;
			
			foreach ( $wp_roles->role_objects as $role ) {
				// foreach ( array( 'publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private' ) as $cap ) {
				// 	if ( $role->has_cap( $cap . '_posts' ) ) {
				// 		$role->add_cap( $cap . '_posts' );
				// 	}
				// }
				foreach ( array( 'manage', 'edit', 'delete' ) as $cap ) {
					if ( $role->has_cap( 'manage_categories' ) ) {
						$role->add_cap( $cap . '_post_topics' );
					}
				}
				if ( $role->has_cap( 'edit_posts' ) ) {
					$role->add_cap( 'assign_post_topics' );
				}
			}

			flush_rewrite_rules();
		}


		public static function deactivate() {
			global $wp_roles;
			
			foreach ( $wp_roles->role_objects as $role ) {
				// foreach ( array( 'publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private' ) as $cap ) {
				// 	$role->remove_cap( $cap . '_posts' );
				// }
				foreach ( array( 'manage', 'edit', 'delete', 'assign' ) as $cap ) {
					$role->remove_cap ( $cap . '_post_topics' );
				}
			}
			
			flush_rewrite_rules();
		}


		public static function register_post_fields() {

			self::$post_types['post'] = new PostType( array(
				'name' => 'post',
				'metaBoxes' => array(
					new MetaBox( array(
						'id' => 'post-format',
						'title' => 'Post Format',
						'context' => 'side',
						'fields' => array(
							new Field(array(
								'input' => new Select( array( 'name' => 'crown_post_format', 'defaultValue' => '', 'options' => array(
									array( 'value' => '', 'label' => 'Default' ),
									array( 'value' => 'tweet', 'label' => 'Tweet' ),
									array( 'value' => 'facebook-update', 'label' => 'Facebook Update' )
								) ) )
							) ),
							new Field(array(
								'uIRules' => array( new UIRule( array( 'property' => 'input', 'options' => array( 'inputName' => 'crown_post_format' ), 'value' => array( 'tweet', 'facebook-update' ) ) ) ),
								'label' => 'External Link',
								'input' => new TextInput( array( 'name' => 'post_external_link', 'placeholder' => 'https://' ) )
							) )
						)
					) )
				)
			) );

		}


		public static function register_post_category_taxonomy_fields() {

			self::$post_category_taxonomy = new Taxonomy( array(
				'name' => 'category',
				'postTypes' => array( 'post' ),
				'fields' => array(
					new Field( array(
						'label' => 'Color',
						'input' => new ColorInput( array( 'name' => 'category_color', 'colorpickerOptions' => array( 'palettes' => apply_filters( 'crown_theme_colors', array(), 'category_color' ) ) ) )
					) )
				),
				'listTableColumns' => array(
					new ListTableColumn(array(
						'key' => 'category-color',
						'title' => '',
						'position' => 1,
						'outputCb' => function( $term_id, $args ) {
							$color = get_term_meta( $term_id, 'category_color', true );
							if ( ! empty( $color ) ) {
								$screen = get_current_screen();
								echo '<a class="color" style="background-color: ' . $color . ';" href="' . get_edit_term_link( $term_id, $screen->taxonomy, $screen->post_type ) . '">' . $color . '</a>';
							}
						}
					))
				)
			) );

		}


		public static function register_post_topic_taxonomy() {

			self::$post_topic_taxonomy = new Taxonomy( array(
				'name' => 'post_topic',
				'singularLabel' => 'Topic',
				'pluralLabel' => 'Topics',
				'postTypes' => array( 'post', 'event', 'event_s', 'resource', 'resource_s', 'webinar', 'webinar_s' ),
				'settings' => array(
					'hierarchical' => true,
					'rewrite' => array( 'slug' => 'topics', 'with_front' => false ),
					'show_in_nav_menus' => false,
					'show_admin_column' => true,
					'publicly_queryable' => true,
					'show_in_rest' => true,
					'labels' => array(
						'menu_name' => 'Topics',
						'all_items' => 'All Topics'
					),
					'capabilities' => array(
						'manage_terms' => 'manage_post_topics',
						'edit_terms' => 'edit_post_topics',
						'delete_terms' => 'delete_post_topics',
						'assign_terms' => 'assign_post_topics'
					)
				)
			) );

		}


		public static function register_post_template() {
			$post_type_object = get_post_type_object( 'post' );
			$post_type_object->template = array(
				array( 'crown-blocks/post-header', array() ),
				array( 'core/paragraph', array() )
			);
		}


		public static function register_admin_styles( $hook ) {
			
			$screen = get_current_screen();
			if ( $screen->base == 'edit-tags' && $screen->taxonomy == 'category' ) {

				ob_start();
				?>
					<style>
						.wp-list-table .column-category-color { width: 30px; }
						.wp-list-table .column-category-color .color { display: block; overflow: hidden; text-indent: -100000px; width: 30px; height: 30px; border-radius: 3px; }
					</style>
				<?php
				$css = trim( ob_get_clean() );
				$css = trim( preg_replace( array( '/^<style>/', '/<\/style>$/' ), '', $css ) );
				wp_add_inline_style( 'common', $css );

			}

		}


		public static function filter_post_class( $classes, $class, $post_id ) {
			if ( get_post_type( $post_id ) == 'post' ) {
				$format = get_post_meta( $post_id, 'crown_post_format', true );
				if ( ! empty( $format ) ) {
					$classes[] = 'post-format-' . $format;
					$external_link = get_post_meta( $post_id, 'post_external_link', true );
					if ( empty( $external_link ) ) {
						if ( $format == 'tweet' && ( $profile_url = get_option( 'theme_config_twitter_profile_url' ) ) ) {
							$external_link = $profile_url;
						} else if ( $format == 'facebook-update' && ( $profile_url = get_option( 'theme_config_facebook_profile_url' ) ) ) {
							$external_link = $profile_url;
						}
					}
					if ( ! empty( $external_link ) ) $classes[] = 'has-external-link';
				}
			}
			return $classes;
		}


		public static function filter_post_link( $permalink, $post, $leavename ) {
			if ( get_post_type( $post->ID ) == 'post' ) {
				$format = get_post_meta( $post->ID, 'crown_post_format', true );
				if ( in_array( $format, array( 'tweet', 'facebook-update' ) ) ) {
					$external_link = get_post_meta( $post->ID, 'post_external_link', true );
					if ( ! empty( $external_link ) ) {
						$permalink = $external_link;
					} else if ( $format == 'tweet' && ( $profile_url = get_option( 'theme_config_twitter_profile_url' ) ) ) {
						$permalink = $profile_url;
					} else if ( $format == 'facebook-update' && ( $profile_url = get_option( 'theme_config_facebook_profile_url' ) ) ) {
						$permalink = $profile_url;
					}
				}
			}
			return $permalink;
		}


		public static function get_post_primary_category_color( $post_id ) {

			$term_ids = wp_get_post_terms( $post_id, 'category', array( 'fields' => 'ids' ) );

			$primary_term_id = get_post_meta( $post_id, '_primary_term_category', true );
			
			if ( ! empty( $primary_term_id ) && in_array( $primary_term_id, $term_ids ) ) array_unshift( $term_ids, $primary_term_id );
			$term_ids = array_values( array_unique( $term_ids ) );

			foreach( $term_ids as $term_id ) {
				$color = get_term_meta( $term_id, 'category_color', true );
				if ( ! empty( $color ) ) return $color;
			}

			return '';
		}


	}
}