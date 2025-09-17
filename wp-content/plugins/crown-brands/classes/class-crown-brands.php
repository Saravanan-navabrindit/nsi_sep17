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


if ( ! class_exists( 'Crown_Brands' ) ) {
	class Crown_Brands {

		public static $init = false;

		public static $brand_post_type = null;
		public static $brand_industry_taxonomy = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			$plugin_file = preg_replace( '/\/classes$/', '', dirname( __FILE__ ) ) . '/plugin.php';
			register_activation_hook( $plugin_file, array( __CLASS__, 'activate' ));
			register_deactivation_hook( $plugin_file, array( __CLASS__, 'deactivate' ));

			add_action( 'after_setup_theme', array( __CLASS__, 'register_brand_post_type' ) );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_brand_industry_taxonomy' ) );

			add_action( 'template_redirect', array( __CLASS__, 'redirect_single_brand' ) );
			add_filter( 'post_type_link', array(  __CLASS__, 'filter_brand_post_link' ), 10, 4 );

		}


		public static function activate() {
			global $wp_roles;
			
			foreach ( $wp_roles->role_objects as $role ) {
				foreach ( array( 'publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private' ) as $cap ) {
					if ( $role->has_cap( $cap . '_posts' ) ) {
						$role->add_cap( $cap . '_brands' );
					}
				}
				foreach ( array( 'manage', 'edit', 'delete' ) as $cap ) {
					if ( $role->has_cap( 'manage_categories' ) ) {
						$role->add_cap( $cap . '_brand_industries' );
					}
				}
				if ( $role->has_cap( 'edit_posts' ) ) {
					$role->add_cap( 'assign_brand_industries' );
				}
			}

			flush_rewrite_rules();
		}


		public static function deactivate() {
			global $wp_roles;
			
			foreach ( $wp_roles->role_objects as $role ) {
				foreach ( array( 'publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private' ) as $cap ) {
					$role->remove_cap( $cap . '_brands' );
				}
				foreach ( array( 'manage', 'edit', 'delete', 'assign' ) as $cap ) {
					$role->remove_cap ( $cap . '_brand_industries' );
				}
			}
			
			flush_rewrite_rules();
		}


		public static function register_brand_post_type() {

			self::$brand_post_type = new PostType( array(
				'name' => 'brand',
				'singularLabel' => 'Brand',
				'pluralLabel' => 'Brands',
				'settings' => array(
					'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
					'rewrite' => array( 'slug' => 'brand', 'with_front' => false ),
					'menu_icon' => 'dashicons-info',
					'has_archive' => true,
					'publicly_queryable' => true,
					'show_in_rest' => true,
					'show_in_nav_menus' => false,
					'capability_type' => array( 'brand', 'brands' ),
					'map_meta_cap' => true,
					'menu_position' => 36
				),
				'metaBoxes' => array(
					new MetaBox( array(
						'id' => 'industry-features',
						'title' => 'Key Features',
						'priority' => 'high',
						'fields' => array(
							new FieldRepeater( array(
								'name' => 'industry_key_features',
								'addNewLabel' => 'Add Key Feature',
								'fields' => array(
									new Field( array(
										'input' => new TextInput( array( 'name' => 'brand_feature' ) )
									) )
								)
							) )
						)
					) )
				),
				'listTableColumns' => array()
			) );

		}


		public static function register_brand_industry_taxonomy() {

			self::$brand_industry_taxonomy = new Taxonomy( array(
				'name' => 'brand_industry',
				'singularLabel' => 'Industry',
				'pluralLabel' => 'Industries',
				'postTypes' => array( 'brand' ),
				'settings' => array(
					'hierarchical' => true,
					'rewrite' => array( 'slug' => 'brand-industries', 'with_front' => false ),
					'show_in_nav_menus' => false,
					'show_admin_column' => true,
					'publicly_queryable' => false,
					'show_in_rest' => true,
					'labels' => array(
						'menu_name' => 'Industries',
						'all_items' => 'All Industries'
					),
					'capabilities' => array(
						'manage_terms' => 'manage_brand_industries',
						'edit_terms' => 'edit_brand_industries',
						'delete_terms' => 'delete_brand_industries',
						'assign_terms' => 'assign_brand_industries'
					)
				)
			) );

		}


		// public static function register_admin_styles( $hook ) {
			
		// 	$screen = get_current_screen();
		// 	if ( $screen->base == 'post' && $screen->post_type == 'brand' ) {
		// 		return;

		// 		ob_start();
				
		// 		$css = trim( ob_get_clean() );
		// 		$css = trim( preg_replace( array( '/^<style>/', '/<\/style>$/' ), '', $css ) );
		// 		wp_add_inline_style( 'common', $css );

		// 	}

		// }


		public static function redirect_single_brand() {
			if ( ! is_singular( 'brand' ) ) return;
			$link = get_post_meta( get_the_ID(), 'brand_lp_url', true );
			if ( ! empty( $link ) ) {
				wp_redirect( $link );
				exit;
			}
		}


		public static function filter_brand_post_link( $permalink, $post, $leavename, $sample ) {
			if ( $post->post_type != 'brand' ) return $permalink;
			$link = get_post_meta( $post->ID, 'brand_lp_url', true );
			if ( ! empty( $link ) ) {
				$permalink = $link;
			}
			return $permalink;
		}


	}
}