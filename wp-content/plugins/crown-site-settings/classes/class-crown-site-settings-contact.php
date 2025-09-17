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


if ( ! class_exists( 'Crown_Site_Settings_Contact' ) ) {
	class Crown_Site_Settings_Contact {

		public static $init = false;

		public static $contact_admin_page = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			GoogleMaps::init( array( 'apiKey' => defined( 'CROWN_GOOGLE_API_KEY' ) ? CROWN_GOOGLE_API_KEY : '' ) );

			add_action( 'after_setup_theme', array( __CLASS__, 'register_admin_pages' ) );

		}


		public static function register_admin_pages() {

			self::$contact_admin_page = new AdminPage( array(
				'key' => 'contact-info',
				'parent' => 'options',
				'title' => 'Contact Info',
				'fields' => array(
					new FieldGroupSet( array(
						'fieldGroups' => array(

							new FieldGroup( array(
								'label' => 'Contact Information',
								'fields' => array(
									new Field(array(
										'label' => 'Address',
										'input' => new Textarea(array('name' => 'theme_config_contact_address', 'rows' => 4, 'class' => 'input-medium'))
									)),
									new Field(array(
										'label' => 'Email Address',
										'input' => new TextInput(array('name' => 'theme_config_contact_email', 'class' => 'input-medium'))
									)),
									new Field(array(
										'label' => 'Phone Number',
										'input' => new TextInput(array('name' => 'theme_config_contact_phone', 'class' => 'input-medium'))
									))
								)
							) )

						)
					) )
				)
			) );

		}


		public static function get_address_components_field_output( $field, $args ) {
			$object_id = isset( $args['entryId'] ) ? $args['entryId'] : 0;

			$address_component_meta_keys = array(
				'street_number' => 'Street Number',
				'route' => 'Route',
				'locality' => 'City',
				'administrative_area_level_2' => 'County',
				'administrative_area_level_1' => 'State',
				'country' => 'Country',
				'postal_code' => 'Postal Code',
				'postal_code_suffix' => 'Postal Code Suffix',
			);

			$output = '';
			$output .= '<div class="crown-field address-components"><div class="input-wrap"><ul style="margin: 0; font-size: 12px; line-height: 1.2; color: #888;">';
			foreach ( $address_component_meta_keys as $key => $label ) {
				$output .= '<li style="margin: 0;"><strong class="label" style="color: #444;">' . $label . ':</strong> <span class="value">' . get_post_meta( $object_id, '_ac_' . $key . '_l', true ) . '</span></li>';
			}
			$output .= '</ul></div></div>';

			return $output;
		}


		public static function save_coordinates_field_meta($field, $input, $type, $objectId, $value) {

			$address = isset( $input['address'] ) ? $input['address'] : '';
			$address = preg_replace( '/\r\n/', ', ', $address );
			if ( empty( $address ) ) return;

			$geocode_data = GoogleMaps::getGeocodeData( $address );

			$address_component_meta_keys = array(
				'street_number' => 'Street Number',
				'route' => 'Route',
				'locality' => 'City',
				'administrative_area_level_2' => 'County',
				'administrative_area_level_1' => 'State',
				'country' => 'Country',
				'postal_code' => 'Postal Code',
				'postal_code_suffix' => 'Postal Code Suffix',
			);
			$address_component_meta = array();
			foreach ( $address_component_meta_keys as $key => $label ) {
				$address_component_meta[ $key ] = (object) array( 'long' => '', 'short' => '' );
			}

			if ( $geocode_data ) {

				if ( ! empty( $geocode_data->geometry->location ) ) {
					$field->setValue( (array) $geocode_data->geometry->location, $type, $objectId );
				} else {
					$field->setValue( array( 'lat' => '', 'lng' => '' ), $type, $objectId );
				}

				foreach ( $geocode_data->address_components as $address_component ) {
					if ( ! is_array( $address_component->types ) || ! isset( $address_component->types[0] ) ) continue;
					if ( ! array_key_exists( $address_component->types[0], $address_component_meta ) ) continue;
					$meta = $address_component_meta[ $address_component->types[0] ];
					
					$meta->long = $address_component->long_name;
					$meta->short = $address_component->short_name;
				}

			}

			foreach ( $address_component_meta as $key => $meta ) {
				update_post_meta( $objectId, '_ac_' . $key . '_l', $meta->long );
				update_post_meta( $objectId, '_ac_' . $key . '_s', $meta->short );
			}

		}


	}
}