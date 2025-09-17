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


if ( ! class_exists( 'Crown_Site_Settings_Signup' ) ) {
	class Crown_Site_Settings_Signup {

		public static $init = false;

		public static $signup_admin_page = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			add_action( 'after_setup_theme', array( __CLASS__, 'register_admin_pages' ) );

		}


		public static function register_admin_pages() {
			if ( ! is_main_site() ) return;

			self::$signup_admin_page = new AdminPage( array(
				'key' => 'signup',
				'parent' => 'options',
				'title' => 'Signup',
				'fields' => array(
					new FieldGroupSet( array(
						'fieldGroups' => array(

							new FieldGroup( array(
								'label' => 'Program Mapping',
								'fields' => array(
									new FieldRepeater( array(
										'name' => 'theme_config_signup_programs',
										'addNewLabel' => 'Add Program',
										'fields' => array(
											new Field( array(
												'label' => 'Program Parameter Value',
												'description' => 'program=<strong>{value}</strong>',
												'input' => new TextInput( array( 'name' => 'parameter_value', 'class' => 'input-small' ) )
											) ),
											new Field( array(
												'label' => 'Neoserra Center ID Override',
												'input' => new TextInput( array( 'name' => 'neoserra_center_id', 'class' => 'input-small' ) )
											) ),
											new Field( array(
												'label' => 'Calendly Meeting URL',
												'input' => new TextInput( array( 'name' => 'calendly_url' ) )
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


		public static function get_program( $queried_program ) {

			$queried_program = trim( strtolower( $queried_program ) );
			$program = null;

			$programs = array();
			if ( is_main_site() ) {
				$programs = get_repeater_entries( 'blog', 'theme_config_signup_programs' );
			} else {
				switch_to_blog( get_main_site_id() );
				$programs = get_repeater_entries( 'blog', 'theme_config_signup_programs' );
				restore_current_blog();
			}

			foreach ( $programs as $p ) {
				if ( trim( strtolower( $p['parameter_value'] ) ) == $queried_program ) {
					$program = (object) $p;
				}
			}

			return $program;
		}


	}
}