<?php

use Crown\AdminPage;
use Crown\Form\Field;
use Crown\Form\FieldGroup;
use Crown\Form\FieldGroupSet;
use Crown\Form\FieldRepeater;
use Crown\Form\FieldRepeaterFlex;
use Crown\Form\Input\CheckboxSet;
use Crown\Form\Input\Media as MediaInput;
use Crown\Form\Input\RadioSet;
use Crown\Form\Input\Select;
use Crown\Form\Input\Date as DateInput;
use Crown\Form\Input\Time as TimeInput;
use Crown\Form\Input\Text as TextInput;
use Crown\Form\Input\Checkbox as CheckboxInput;
use Crown\Form\Input\Color as ColorInput;
use Crown\Form\Input\RichTextarea;
use Crown\Form\Input\Textarea;
use Crown\Form\Input\Gallery as GalleryInput;
use Crown\ListTableColumn;
use Crown\Post\MetaBox;
use Crown\Post\Type as PostType;
use Crown\Post\Taxonomy;
use Crown\Shortcode;
use Crown\UIRule;


if ( ! class_exists( 'Crown_Industries' ) ) {
	class Crown_Industries {

		public static $init = false;

		public static $industry_post_type = null;
		public static $industry_brand_taxonomy = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			$plugin_file = preg_replace( '/\/classes$/', '', dirname( __FILE__ ) ) . '/plugin.php';
			register_activation_hook( $plugin_file, array( __CLASS__, 'activate' ));
			register_deactivation_hook( $plugin_file, array( __CLASS__, 'deactivate' ));

			add_action( 'after_setup_theme', array( __CLASS__, 'register_industry_post_type' ) );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_industry_brand_taxonomy' ) );

			add_action( 'template_redirect', array( __CLASS__, 'redirect_single_industry' ) );
			add_filter( 'post_type_link', array(  __CLASS__, 'filter_industry_post_link' ), 10, 4 );

		}


		public static function activate() {
			global $wp_roles;
			
			foreach ( $wp_roles->role_objects as $role ) {
				foreach ( array( 'publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private' ) as $cap ) {
					if ( $role->has_cap( $cap . '_posts' ) ) {
						$role->add_cap( $cap . '_industries' );
					}
				}
				foreach ( array( 'manage', 'edit', 'delete' ) as $cap ) {
					if ( $role->has_cap( 'manage_categories' ) ) {
						$role->add_cap( $cap . '_industry_brands' );
					}
				}
				if ( $role->has_cap( 'edit_posts' ) ) {
					$role->add_cap( 'assign_industry_brands' );
				}
			}

			flush_rewrite_rules();
		}


		public static function deactivate() {
			global $wp_roles;
			
			foreach ( $wp_roles->role_objects as $role ) {
				foreach ( array( 'publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private' ) as $cap ) {
					$role->remove_cap( $cap . '_industries' );
				}
				foreach ( array( 'manage', 'edit', 'delete', 'assign' ) as $cap ) {
					$role->remove_cap ( $cap . '_industry_brands' );
				}
			}
			
			flush_rewrite_rules();
		}


		public static function register_industry_post_type() {

			self::$industry_post_type = new PostType( array(
				'name' => 'industry',
				'singularLabel' => 'Industry',
				'pluralLabel' => 'Industries',
				'settings' => array(
					'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
					'rewrite' => array( 'slug' => 'industries', 'with_front' => false ),
					'menu_icon' => 'dashicons-hammer',
					'has_archive' => true,
					'publicly_queryable' => true,
					'show_in_rest' => true,
					'show_in_nav_menus' => true,
					'capability_type' => array( 'industry', 'industries' ),
					'map_meta_cap' => true,
					'menu_position' => 31
				),
				'metaBoxes' => array(
					new MetaBox( array(
						'id' => 'industry-options',
						'title' => 'Industry Options',
						'context' => 'side',
						'fields' => array(
							new Field( array(
								'label' => 'Landing Page Link',
								'input' => new TextInput( array( 'name' => 'industry_lp_url', 'placeholder' => 'https://' ) )
							))
						)
					))
				),
				'listTableColumns' => array()
			) );

		}


		public static function register_industry_brand_taxonomy() {

			self::$industry_brand_taxonomy = new Taxonomy( array(
				'name' => 'industry_brand',
				'singularLabel' => 'Brand',
				'pluralLabel' => 'Brands',
				'postTypes' => array( 'industry' ),
				'settings' => array(
					'hierarchical' => false,
					'rewrite' => array( 'slug' => 'industry-brands', 'with_front' => false ),
					'show_in_nav_menus' => false,
					'show_admin_column' => true,
					'publicly_queryable' => false,
					'show_in_rest' => true,
					'labels' => array(
						'menu_name' => 'Brands',
						'all_items' => 'All Brands'
					),
					'capabilities' => array(
						'manage_terms' => 'manage_industry_brands',
						'edit_terms' => 'edit_industry_brands',
						'delete_terms' => 'delete_industry_brands',
						'assign_terms' => 'assign_industry_brands'
					)
				)
			) );

		}


		// public static function register_admin_styles( $hook ) {
			
		// 	$screen = get_current_screen();
		// 	if ( $screen->base == 'post' && $screen->post_type == 'industry' ) {
		// 		return;

		// 		ob_start();
				
		// 		$css = trim( ob_get_clean() );
		// 		$css = trim( preg_replace( array( '/^<style>/', '/<\/style>$/' ), '', $css ) );
		// 		wp_add_inline_style( 'common', $css );

		// 	}

		// }


		public static function redirect_single_industry() {
			if ( ! is_singular( 'industry' ) ) return;
			$link = get_post_meta( get_the_ID(), 'industry_lp_url', true );
			if ( ! empty( $link ) ) {
				wp_redirect( $link );
				exit;
			}
		}


		public static function filter_industry_post_link( $permalink, $post, $leavename, $sample ) {
			if ( $post->post_type != 'industry' ) return $permalink;
			$link = get_post_meta( $post->ID, 'industry_lp_url', true );
			if ( ! empty( $link ) ) {
				$permalink = $link;
			}
			return $permalink;
		}


	}
}