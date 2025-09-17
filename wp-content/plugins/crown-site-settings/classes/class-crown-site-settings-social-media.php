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


if ( ! class_exists( 'Crown_Site_Settings_Social_Media' ) ) {
	class Crown_Site_Settings_Social_Media {

		public static $init = false;

		public static $social_media_admin_page = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			add_action( 'after_setup_theme', array( __CLASS__, 'register_admin_pages' ) );

		}


		public static function register_admin_pages() {

			self::$social_media_admin_page = new AdminPage( array(
				'key' => 'social-media',
				'parent' => 'options',
				'title' => 'Social Media',
				'fields' => array(
					new FieldGroupSet( array(
						'fieldGroups' => array(

							new FieldGroup( array(
								'label' => 'Social Media Links',
								'fields' => array(
									new FieldGroup( array(
										'class' => 'no-border two-column large-left',
										'fields' => array(
											new Field( array(
												'label' => 'Facebook Page URL',
												'input' => new TextInput( array( 'name' => 'theme_config_facebook_profile_url', 'placeholder' => 'https://' ) )
											) ),
											new Field( array(
												'label' => 'Handle',
												'input' => new TextInput( array( 'name' => 'theme_config_facebook_profile_handle', 'placeholder' => '' ) )
											) )
										)
									) ),
									new FieldGroup( array(
										'class' => 'no-border two-column large-left',
										'fields' => array(
											new Field( array(
												'label' => 'Twitter Profile URL',
												'input' => new TextInput( array( 'name' => 'theme_config_twitter_profile_url', 'placeholder' => 'https://' ) )
											) ),
											new Field( array(
												'label' => 'Handle',
												'input' => new TextInput( array( 'name' => 'theme_config_twitter_profile_handle', 'placeholder' => '' ) )
											) )
										)
									) ),
									new FieldGroup( array(
										'class' => 'no-border two-column large-left',
										'fields' => array(
											new Field( array(
												'label' => 'Google+ Profile URL',
												'input' => new TextInput( array( 'name' => 'theme_config_google_plus_profile_url', 'placeholder' => 'https://' ) )
											) ),
											new Field( array(
												'label' => 'Handle',
												'input' => new TextInput( array( 'name' => 'theme_config_google_plus_profile_handle', 'placeholder' => '' ) )
											) )
										)
									) ),
									new FieldGroup( array(
										'class' => 'no-border two-column large-left',
										'fields' => array(
											new Field( array(
												'label' => 'LinkedIn Business Page URL',
												'input' => new TextInput( array( 'name' => 'theme_config_linkedin_profile_url', 'placeholder' => 'https://' ) )
											) ),
											new Field( array(
												'label' => 'Handle',
												'input' => new TextInput( array( 'name' => 'theme_config_linkedin_profile_handle', 'placeholder' => '' ) )
											) )
										)
									) ),
									new FieldGroup( array(
										'class' => 'no-border two-column large-left',
										'fields' => array(
											new Field( array(
												'label' => 'Instagram Profile URL',
												'input' => new TextInput( array( 'name' => 'theme_config_instagram_profile_url', 'placeholder' => 'https://' ) )
											) ),
											new Field( array(
												'label' => 'Handle',
												'input' => new TextInput( array( 'name' => 'theme_config_instagram_profile_handle', 'placeholder' => '' ) )
											) )
										)
									) ),
									new FieldGroup( array(
										'class' => 'no-border two-column large-left',
										'fields' => array(
											new Field( array(
												'label' => 'YouTube Channel URL',
												'input' => new TextInput( array( 'name' => 'theme_config_youtube_profile_url', 'placeholder' => 'https://' ) )
											) ),
											new Field( array(
												'label' => 'Handle',
												'input' => new TextInput( array( 'name' => 'theme_config_youtube_profile_handle', 'placeholder' => '' ) )
											) )
										)
									) ),
									new FieldGroup( array(
										'class' => 'no-border two-column large-left',
										'fields' => array(
											new Field( array(
												'label' => 'Vimeo Profile URL',
												'input' => new TextInput( array( 'name' => 'theme_config_vimeo_profile_url', 'placeholder' => 'https://' ) )
											) ),
											new Field( array(
												'label' => 'Handle',
												'input' => new TextInput( array( 'name' => 'theme_config_vimeo_profile_handle', 'placeholder' => '' ) )
											) )
										)
									) ),
									new FieldGroup( array(
										'class' => 'no-border two-column large-left',
										'fields' => array(
											new Field( array(
												'label' => 'Pinterest Page URL',
												'input' => new TextInput( array( 'name' => 'theme_config_pinterest_profile_url', 'placeholder' => 'https://' ) )
											) ),
											new Field( array(
												'label' => 'Handle',
												'input' => new TextInput( array( 'name' => 'theme_config_pinterest_profile_handle', 'placeholder' => '' ) )
											) )
										)
									) )
								)
							) )

						)
					) )
				)
			) );

		}


	}
}