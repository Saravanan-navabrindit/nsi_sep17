<?php

use Crown\AdminPage;
use Crown\Form\Field;
use Crown\Form\FieldGroup;
use Crown\Form\FieldGroupSet;
use Crown\Form\Input\Textarea;
use Crown\Post\Type as PostType;
use Crown\Post\MetaBox;


if ( ! class_exists( 'Crown_Site_Settings_Scripts' ) ) {
	class Crown_Site_Settings_Scripts {

		public static $init = false;

		public static $site_scripts_admin_page = null;

		public static $post_types = array();


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			add_action( 'after_setup_theme', array( __CLASS__, 'register_admin_pages' ) );
			add_action( 'after_setup_theme', array(__CLASS__, 'register_meta_boxes'), 100 );

			add_action( 'wp_head', array( __CLASS__, 'output_head_scripts' ) );
			add_action( 'wp_body_open', array( __CLASS__, 'output_body_open_scripts' ) );
			add_action( 'wp_footer', array( __CLASS__, 'output_footer_scripts' ) );

		}


		public static function register_admin_pages() {

			self::$site_scripts_admin_page = new AdminPage( array(
				'key' => 'site-scripts',
				'parent' => 'options',
				'title' => 'Site Scripts',
				'fields' => array(
					new FieldGroupSet( array(
						'fieldGroups' => array(

							new FieldGroup( array(
								'label' => 'Header Scripts',
								'description' => 'Scripts will be injected into the header of all pages on the site before the closing <code>&lt;/head&gt;</code> tag.',
								'fields' => array(
									new Field( array(
										'input' => new Textarea( array( 'name' => 'theme_config_scripts_header', 'rows' => 16, 'mode' => 'html', 'atts' => array( 'style' => 'font-family: monospace; font-size: 13px;' ) ) )
									) )
								)
							) ),

							new FieldGroup( array(
								'label' => 'Body Open Scripts',
								'description' => 'Scripts will be injected into the body of all pages on the site after the opening <code>&lt;body&gt;</code> tag.',
								'fields' => array(
									new Field( array(
										'input' => new Textarea( array( 'name' => 'theme_config_scripts_body_open', 'rows' => 16, 'mode' => 'html', 'atts' => array( 'style' => 'font-family: monospace; font-size: 13px;' ) ) )
									) )
								)
							) ),

							new FieldGroup( array(
								'label' => 'Footer Scripts',
								'description' => 'Scripts will be injected into the footer of all pages on the site before the closing <code>&lt;/body&gt;</code> tag.',
								'fields' => array(
									new Field( array(
										'input' => new Textarea( array( 'name' => 'theme_config_scripts_footer', 'rows' => 16, 'mode' => 'html', 'atts' => array( 'style' => 'font-family: monospace; font-size: 13px;' ) ) )
									) )
								)
							) ),

							new FieldGroup( array(
								'label' => 'HubSpot Scripts',
								'description' => 'Scripts will be injected on pages for tracking in HubSpot.',
								'fields' => array(
									new Field( array(
										'input' => new Textarea( array( 'name' => 'theme_config_scripts_hubspot', 'rows' => 16, 'mode' => 'html', 'atts' => array( 'style' => 'font-family: monospace; font-size: 13px;' ) ) )
									) )
								)
							) )

						)
					) )
				)
			) );

		}


		public static function register_meta_boxes() {

			$page_scripts_meta_box = new MetaBox( array(
				'id' => 'page-scripts',
				'title' => 'Page Scripts',
				'context' => 'advanced',
				'priority' => 'low',
				'fields' => array(
					new FieldGroupSet( array(
						'fieldGroups' => array(

							new FieldGroup( array(
								'label' => 'Header Scripts',
								'description' => 'Scripts will be injected into the header of all pages on the site before the closing <code>&lt;/head&gt;</code> tag.',
								'fields' => array(
									new Field( array(
										'input' => new Textarea( array( 'name' => 'page_scripts_header', 'rows' => 16, 'atts' => array( 'style' => 'font-family: monospace; font-size: 13px;' ) ) )
									) )
								)
							) ),

							new FieldGroup( array(
								'label' => 'Body Open Scripts',
								'description' => 'Scripts will be injected into the body of all pages on the site after the opening <code>&lt;body&gt;</code> tag.',
								'fields' => array(
									new Field( array(
										'input' => new Textarea( array( 'name' => 'page_scripts_body_open', 'rows' => 16, 'atts' => array( 'style' => 'font-family: monospace; font-size: 13px;' ) ) )
									) )
								)
							) ),

							new FieldGroup( array(
								'label' => 'Footer Scripts',
								'description' => 'Scripts will be injected into the footer of all pages on the site before the closing <code>&lt;/body&gt;</code> tag.',
								'fields' => array(
									new Field( array(
										'input' => new Textarea( array( 'name' => 'page_scripts_footer', 'rows' => 16, 'atts' => array( 'style' => 'font-family: monospace; font-size: 13px;' ) ) )
									) )
								)
							) )

						)
					) )
				)
			) );

			$post_types = array( 'page', 'post' );
			foreach ( $post_types as $post_type ) {
				if ( ! array_key_exists( $post_type, self::$post_types ) ) self::$post_types[ $post_type ] = new PostType( array( 'name' => $post_type ) );
				self::$post_types[ $post_type ]->addMetaBox( $page_scripts_meta_box );
			}

		}


		public static function output_head_scripts() {
			echo get_option( 'theme_config_scripts_header' );
			if ( is_singular() ) echo get_post_meta( get_the_ID(), 'page_scripts_header', true );
		}


		public static function output_body_open_scripts() {
			echo get_option( 'theme_config_scripts_body_open' );
			if ( is_singular() ) echo get_post_meta( get_the_ID(), 'page_scripts_body_open', true );
		}


		public static function output_footer_scripts() {
			echo get_option( 'theme_config_scripts_footer' );
			if ( is_singular() ) echo get_post_meta( get_the_ID(), 'page_scripts_footer', true );
			$display_hubspot_scripts = true;
			if ( is_account_page() ) $display_hubspot_scripts = false;
			if ( is_cart() ) $display_hubspot_scripts = false;
			if ( $display_hubspot_scripts ) {
				echo get_option( 'theme_config_scripts_hubspot' );
			}
		}


	}
}