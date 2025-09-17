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


if ( ! class_exists( 'Crown_Resources' ) ) {
	class Crown_Resources {

		public static $init = false;

		public static $catalog_post_type = null;
		public static $video_post_type = null;
		public static $resource_industry_taxonomy = null;
		public static $resource_service_taxonomy = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			$plugin_file = preg_replace( '/\/classes$/', '', dirname( __FILE__ ) ) . '/plugin.php';
			register_activation_hook( $plugin_file, array( __CLASS__, 'activate' ));
			register_deactivation_hook( $plugin_file, array( __CLASS__, 'deactivate' ));

			add_action( 'after_setup_theme', array( __CLASS__, 'register_catalog_post_type' ) );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_video_post_type' ) );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_resource_industry_taxonomy' ) );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_resource_service_taxonomy' ) );

			add_filter( 'use_block_editor_for_post_type', array( __CLASS__, 'filter_use_block_editor_for_post_type' ), 10, 2 );

			add_action( 'template_redirect', array( __CLASS__, 'redirect_singular' ) );
			add_filter( 'post_type_link', array(  __CLASS__, 'filter_post_type_link' ), 10, 4 );

		}


		public static function activate() {
			global $wp_roles;
			
			foreach ( $wp_roles->role_objects as $role ) {
				foreach ( array( 'publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private' ) as $cap ) {
					if ( $role->has_cap( $cap . '_posts' ) ) {
						$role->add_cap( $cap . '_catalogs' );
						$role->add_cap( $cap . '_videos' );
					}
				}
				foreach ( array( 'manage', 'edit', 'delete' ) as $cap ) {
					if ( $role->has_cap( 'manage_categories' ) ) {
						$role->add_cap( $cap . '_resource_industries' );
						$role->add_cap( $cap . '_resource_services' );
					}
				}
				if ( $role->has_cap( 'edit_posts' ) ) {
					$role->add_cap( 'assign_resource_industries' );
					$role->add_cap( 'assign_resource_services' );
				}
			}

			flush_rewrite_rules();
		}


		public static function deactivate() {
			global $wp_roles;
			
			foreach ( $wp_roles->role_objects as $role ) {
				foreach ( array( 'publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private' ) as $cap ) {
					$role->remove_cap( $cap . '_catalogs' );
					$role->remove_cap( $cap . '_videos' );
				}
				foreach ( array( 'manage', 'edit', 'delete', 'assign' ) as $cap ) {
					$role->remove_cap ( $cap . '_resource_industries' );
					$role->remove_cap ( $cap . '_resource_services' );
				}
			}
			
			flush_rewrite_rules();
		}


		public static function register_catalog_post_type() {

			self::$catalog_post_type = new PostType( array(
				'name' => 'catalog',
				'singularLabel' => 'Catalog',
				'pluralLabel' => 'Catalogs',
				'settings' => array(
					'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
					'rewrite' => array( 'slug' => 'catalogs', 'with_front' => false ),
					'menu_icon' => 'dashicons-book',
					'has_archive' => false,
					'publicly_queryable' => true,
					'show_in_rest' => true,
					'show_in_nav_menus' => true,
					'capability_type' => array( 'catalog', 'catalogs' ),
					'map_meta_cap' => true,
					'menu_position' => 36
				),
				'metaBoxes' => array(
					new MetaBox( array(
						'id' => 'catalog-link',
						'title' => 'Catalog Link',
						'priority' => 'high',
						'context' => 'side',
						'fields' => array(
							new Field( array(
								'label' => 'File',
								'input' => new MediaInput( array( 'name' => 'catalog_file' ) )
							) ),
							new Field( array(
								'label' => 'Link Override',
								'input' => new TextInput( array( 'name' => 'catalog_link', 'placeholder' => 'https://' ) )
							) )
						)
					) )
				)
			) );

		}


		public static function register_video_post_type() {

			self::$video_post_type = new PostType( array(
				'name' => 'video',
				'singularLabel' => 'Video',
				'pluralLabel' => 'Videos',
				'settings' => array(
					'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
					'rewrite' => array( 'slug' => 'videos', 'with_front' => false ),
					'menu_icon' => 'dashicons-format-video',
					'has_archive' => false,
					'publicly_queryable' => true,
					'show_in_rest' => true,
					'show_in_nav_menus' => true,
					'capability_type' => array( 'video', 'videos' ),
					'map_meta_cap' => true,
					'menu_position' => 37
				),
				'metaBoxes' => array(
					new MetaBox( array(
						'id' => 'video-link',
						'title' => 'Video Link',
						'priority' => 'high',
						'context' => 'side',
						'fields' => array(
							new Field( array(
								// 'label' => 'Link Override',
								'input' => new TextInput( array( 'name' => 'video_link', 'placeholder' => 'https://' ) )
							) )
						)
					) )
				)
			) );

		}


		public static function register_resource_industry_taxonomy() {

			self::$resource_industry_taxonomy = new Taxonomy( array(
				'name' => 'resource_industry',
				'singularLabel' => 'Resource Industry',
				'pluralLabel' => 'Resource Industries',
				'postTypes' => array( 'catalog', 'video' ),
				'settings' => array(
					'hierarchical' => true,
					'rewrite' => array( 'slug' => 'resource-industries', 'with_front' => false ),
					'show_in_nav_menus' => false,
					'show_admin_column' => true,
					'publicly_queryable' => false,
					'show_in_rest' => true,
					'labels' => array(
						'menu_name' => 'Industries',
						'all_items' => 'All Industries'
					),
					'capabilities' => array(
						'manage_terms' => 'manage_resource_industries',
						'edit_terms' => 'edit_resource_industries',
						'delete_terms' => 'delete_resource_industries',
						'assign_terms' => 'assign_resource_industries'
					)
				)
			) );

		}


		public static function register_resource_service_taxonomy() {

			self::$resource_industry_taxonomy = new Taxonomy( array(
				'name' => 'resource_service',
				'singularLabel' => 'Resource Service',
				'pluralLabel' => 'Resource Services',
				'postTypes' => array( 'catalog', 'video' ),
				'settings' => array(
					'hierarchical' => true,
					'rewrite' => array( 'slug' => 'resource-services', 'with_front' => false ),
					'show_in_nav_menus' => false,
					'show_admin_column' => true,
					'publicly_queryable' => false,
					'show_in_rest' => true,
					'labels' => array(
						'menu_name' => 'Services',
						'all_items' => 'All Services'
					),
					'capabilities' => array(
						'manage_terms' => 'manage_resource_services',
						'edit_terms' => 'edit_resource_services',
						'delete_terms' => 'delete_resource_services',
						'assign_terms' => 'assign_resource_services'
					)
				)
			) );

		}


		public static function filter_use_block_editor_for_post_type( $use_block_editor, $post_type ) {
			return in_array( $post_type, array( 'catalog', 'video' ) ) ? false : $use_block_editor;
		}


		public static function redirect_singular() {
			$redirect = null;
			if ( is_singular( 'catalog' ) ) {
				$link = get_post_meta( get_the_ID(), 'catalog_link', true );
				if ( ! empty( $link ) ) {
					$redirect = $link;
				} else {
					$link = wp_get_attachment_url( get_post_meta( get_the_ID(), 'catalog_file', true ) );
					if ( ! empty( $link ) ) $redirect = $link;
				}
			}
			if ( is_singular( 'video' ) ) {
				$link = get_post_meta( get_the_ID(), 'video_link', true );
				if ( ! empty( $link ) ) {
					$redirect = $link;
				}
			}
			if ( ! empty( $redirect ) ) {
				wp_redirect( $redirect );
				exit;
			}
		}


		public static function filter_post_type_link( $permalink, $post, $leavename, $sample ) {
			if ( $post->post_type == 'catalog' ) {
				$link = get_post_meta( $post->ID, 'catalog_link', true );
				if ( ! empty( $link ) ) return $link;
				$link = wp_get_attachment_url( get_post_meta( $post->ID, 'catalog_file', true ) );
				if ( ! empty( $link ) ) return $link;
			}
			if ( $post->post_type == 'video' ) {
				$link = get_post_meta( $post->ID, 'video_link', true );
				if ( ! empty( $link ) ) return $link;
			}
			return $permalink;
		}


	}
}