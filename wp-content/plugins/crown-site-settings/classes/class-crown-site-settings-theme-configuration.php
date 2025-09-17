<?php

use Crown\AdminPage;
use Crown\Api\GoogleMaps;
use Crown\Form\Field;
use Crown\Form\FieldGroup;
use Crown\Form\FieldGroupSet;
use Crown\Form\FieldRepeater;
use Crown\Form\Input\CheckboxSet;
use Crown\Form\Input\Media as MediaInput;
use Crown\Form\Input\RadioSet;
use Crown\Form\Input\Select;
use Crown\Form\Input\Text as TextInput;
use Crown\Form\Input\Gallery as GalleryInput;
use Crown\Form\Input\GeoCoordinates as GeoCoordinatesInput;
use Crown\Form\Input\Textarea;
use Crown\Form\Input\RichTextarea;
use Crown\Post\MetaBox;
use Crown\Post\Type as PostType;
use Crown\UIRule;


if ( ! class_exists( 'Crown_Site_Settings_Theme_Configuration' ) ) {
	class Crown_Site_Settings_Theme_Configuration {

		public static $init = false;

		public static $theme_config_admin_page = null;
		public static $post_types = array();

		public static $post_type_input_options = array();
		public static $form_input_options = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			add_action( 'after_setup_theme', array( __CLASS__, 'register_admin_pages' ) );
			// add_action( 'admin_menu', array( __CLASS__, 'add_reusable_blocks_menu_page' ), 50 );
			add_filter( 'display_post_states', array( __CLASS__, 'filter_display_post_states' ), 10, 2 );

			add_filter( 'crown_site_footer_copyright', array( __CLASS__, 'filter_crown_site_footer_copyright' ));
			add_filter( 'crown_site_footer_description', array( __CLASS__, 'filter_crown_site_footer_description' ));

			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'register_admin_styles' ) );

		}


		public static function register_admin_pages() {

			self::$theme_config_admin_page = new AdminPage( array(
				'key' => 'theme-config',
				'parent' => 'theme',
				'title' => 'Theme Configuration',
				'menuTitle' => 'Configuration',
				'fields' => array(
					new FieldGroupSet( array(
						'fieldGroups' => array(

							new FieldGroup( array(
								'label' => 'General',
								'fields' => array(
									new FieldGroup( array(
										'label' => 'Site Logo',
										'fields' => array(
											new Field( array(
												'label' => 'Primary Logo',
												'input' => new MediaInput( array( 'name' => 'theme_config_site_logo_color', 'mimeType' => 'image', 'buttonLabel' => 'Select Image', 'class' => 'logo dark' ) )
											) )
										)
									) ),
								)
							) ),

							new FieldGroup( array(
								'label' => 'Site Footer',
								'fields' => array(
									new Field( array(
										'label' => 'Footer Logo',
										'input' => new MediaInput( array( 'name' => 'theme_config_footer_logo', 'mimeType' => 'image', 'class' => 'logo light' ) )
									) ),
									new Field( array(
										'label' => 'Copyright Text',
										'description' => 'Use the <code>%%year%%</code> placeholder to display the current year.',
										'input' => new TextInput( array( 'name' => 'theme_config_footer_copyright' ) )
									) )
								)
							) ),

							new FieldGroup( array(
								'label' => 'Shop',
								'fields' => array(
									new Field( array(
										'label' => 'Checkout Status',
										'input' => new RadioSet( array( 'name' => 'theme_config_shop_checkout_status', 'defaultValue' => 'enabled', 'class' => 'toggle', 'options' => array(
											array( 'value' => 'enabled', 'label' => 'Enabled' ),
											array( 'value' => 'disabled', 'label' => 'Disabled' )
										) ) )
									) ),
                                    new FieldGroup( array(
                                        'label' => 'Order Documents Images ',
                                        'fields' => array(
                                            new Field( array(
                                                'label' => 'Order Documents Logo',
                                                'input' => new MediaInput( array( 'name' => 'theme_config_order_documents_logo', 'mimeType' => 'image', 'buttonLabel' => 'Select Image', 'class' => 'logo dark' ) )
                                            ) ),
                                            new Field( array(
                                                'label' => 'Order Documents Footer image',
                                                'input' => new MediaInput( array( 'name' => 'theme_config_order_documents_footer', 'mimeType' => 'image', 'buttonLabel' => 'Select Image', 'class' => 'logo dark' ) )
                                            ) )
                                        )
                                    ) ),
								)
							) ),

							// new FieldGroup( array(
							// 	'label' => 'Modals',
							// 	'fields' => array(
							// 		new FieldGroup( array(
							// 			'label' => 'Subscribe',
							// 			'fields' => array(
							// 				new Field( array(
							// 					'label' => 'Title',
							// 					'input' => new TextInput( array( 'name' => 'theme_config_modal_subscribe_title', 'class' => 'input-large' ) )
							// 				) ),
							// 				new Field( array(
							// 					'label' => 'Description',
							// 					'input' => new Textarea( array( 'name' => 'theme_config_modal_subscribe_description', 'rows' => 6 ) )
							// 				) ),
							// 				new Field( array(
							// 					'label' => 'Form',
							// 					'input' => new Select( array( 'name' => 'theme_config_modal_subscribe_form' ) ),
							// 				) )
							// 			)
							// 		) )
							// 	)
							// ) ),

							// new FieldGroup( array(
							// 	'label' => 'Events',
							// 	'fields' => array(
							// 		new Field( array(
							// 			'label' => 'Event Zoom Meeting Registration Form',
							// 			'input' => new Select( array( 'name' => 'theme_config_events_zoom_meeting_registration_form' ) ),
							// 		) )
							// 	)
							// ) ),

							new FieldGroup( array(
								'label' => 'Index Pages',
								'fields' => array(
									new Field( array(
										'label' => 'Posts',
										'input' => new Select( array( 'name' => 'theme_config_index_page_post' ) ),
									) )
								)
							) )

						)
					) )
				)
			) );

		}


		public static function set_block_id_select_field_options( $field, $args ) {
			$options = array( array( 'value' => '', 'label' => '&mdash;' ) );
			$posts = get_posts( array(
				'post_type' => 'wp_block',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
				'post_status' => 'any'
			) );
			if ( ! empty( $posts ) ) {
				$options = array_merge( $options, array_map( function( $n ) {
					return array( 'value' => $n->ID, 'label' => $n->post_title );
				}, $posts ) );
				$field->getInput()->setOptions( $options );
			}
		}


		public static function set_page_select_input_options( $field, $args ) {
			$field->getInput()->setOptions( array_merge( array( array( 'label' => '&mdash;' ) ), self::get_post_input_options( 'page' ) ) );
		}
		private static function get_post_input_options( $post_type = 'post', $order_by = 'title', $order = 'ASC', $parent = 0, $level = 0 ) {
			if ( $parent == 0 && array_key_exists( $post_type, self::$post_type_input_options ) ) return self::$post_type_input_options[ $post_type ];
			$options = array();
			$posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => $order_by, 'order' => $order, 'post_parent' => $parent ) );
			foreach ( $posts as $post ) {
				$options[] = array( 'value' => $post->ID, 'label' => $post->post_title, 'depth' => $level );
				$options = array_merge( $options, self::get_post_input_options( $post_type, $order_by, $order, $post->ID, $level + 1 ) );
			}
			if ( $parent == 0 ) self::$post_type_input_options[ $post_type ] = $options;
			return $options;
		}


		public static function set_form_select_input_options( $field, $args ) {
			$field->getInput()->setOptions( array_merge( array( array( 'label' => '&mdash;' ) ), self::get_form_input_options() ) );
		}
		private static function get_form_input_options() {
			if ( empty( self::$form_input_options ) ) {
				self::$form_input_options = array();
				if ( class_exists('RGFormsModel' ) ) {
					$forms = RGFormsModel::get_forms();
					foreach ( $forms as $form ) {
						self::$form_input_options[] = array('value' => $form->id, 'label' => $form->title);
					}
				}
			}
			return self::$form_input_options;
		}


		public static function add_reusable_blocks_menu_page() {
			add_menu_page( 'Reusable Blocks', 'Reusable Blocks', 'edit_posts', 'edit.php?post_type=wp_block', '', 'dashicons-editor-table', 22 );
		}


		public static function filter_display_post_states( $post_states, $post ) {
			// if ( $post->post_type == 'wp_block' && $post->ID == get_option( 'theme_config_category_tpl_cta_block_id' ) ) {
			// 	$post_states['category-tpl-cta'] = 'Category Template CTA';
			// }
			return $post_states;
		}


		public static function filter_crown_site_footer_copyright( $copyright = '' ) {
			$copyright = get_option( 'theme_config_footer_copyright' );
			$copyright = str_replace( '%%year%%', current_time( 'Y' ), $copyright );
			return $copyright;
		}


		public static function filter_crown_site_footer_description( $description = '' ) {
			$description = get_option( 'theme_config_footer_description' );
			return $description;
		}


		public static function register_admin_styles( $hook ) {
			
			$screen = get_current_screen();
			if ( $screen->id == 'appearance_page_theme-config' ) {

				ob_start();
				?>
					<style>
						.crown-media-input.logo .media-input-preview img { width: 100%; height: 100px; object-fit: contain; object-position: left center; }
						.crown-media-input.logo.dark .media-input-preview { max-width: 400px; padding: 10px; background-color: #eee; border: 1px dashed #ccc; border-radius: 4px; }
						.crown-media-input.logo.light .media-input-preview { max-width: 400px; padding: 10px; background-color: #222; border: 1px solid #222; border-radius: 4px; }
					</style>
				<?php
				$css = trim( ob_get_clean() );
				$css = trim( preg_replace( array( '/^<style>/', '/<\/style>$/' ), '', $css ) );
				wp_add_inline_style( 'common', $css );

			}

		}


	}
}