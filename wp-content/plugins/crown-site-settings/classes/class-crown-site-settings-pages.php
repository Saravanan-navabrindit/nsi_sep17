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
use Crown\Form\Input\Textarea;
use Crown\Post\MetaBox;
use Crown\Post\Type as PostType;
use Crown\UIRule;


if ( ! class_exists( 'Crown_Site_Settings_Pages' ) ) {
	class Crown_Site_Settings_Pages {

		public static $init = false;

		public static $post_types = array();
		public static $form_input_options = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			add_action( 'after_setup_theme', array( __CLASS__, 'register_page_fields' ) );

		}


		public static function register_page_fields() {

			$gated_content_form_mb = new MetaBox( array(
				'id' => 'page-content-gating',
				'title' => 'Content Gating',
				'context' => 'side',
				'fields' => array(
					new Field( array(
						'label' => 'Gated Content Form',
						'input' => new Select( array( 'name' => 'page_content_gating_form' ) ),
						'getOutputCb' => array( __CLASS__, 'set_form_select_input_options' )
					) )
				)
			) );

			self::$post_types['page'] = new PostType( array(
				'name' => 'page',
				'metaBoxes' => array( $gated_content_form_mb )
			) );

			self::$post_types['post'] = new PostType( array(
				'name' => 'post',
				'metaBoxes' => array( $gated_content_form_mb )
			) );

		}


		public static function set_form_select_input_options( $field, $args ) {
			$field->getInput()->setOptions( array_merge( array( array( 'label' => 'Content Gating Disabled' ) ), self::get_form_input_options() ) );
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


	}
}