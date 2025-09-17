<?php

use Crown\AdminPage;
use Crown\Form\Field;
use Crown\Form\FieldGroup;
use Crown\Form\FieldGroupSet;
use Crown\Form\FieldRepeater;
use Crown\Form\Input\CheckboxSet;
use Crown\Form\Input\Media as MediaInput;
use Crown\Form\Input\RadioSet;
use Crown\Form\Input\Select;
use Crown\Form\Input\Text as TextInput;
use Crown\Form\Input\Date as DateInput;
use Crown\Form\Input\Color as ColorInput;
use Crown\Form\Input\Checkbox as CheckboxInput;
use Crown\Form\Input\Textarea;
use Crown\Post\MetaBox;
use Crown\Post\Type as PostType;
use Crown\UIRule;


if ( ! class_exists( 'Crown_Site_Settings_Site_Announcement' ) ) {
	class Crown_Site_Settings_Site_Announcement {

		public static $init = false;

		public static $site_announcement_admin_page = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			add_action( 'after_setup_theme', array( __CLASS__, 'register_admin_pages' ) );
			add_filter( 'crown_site_announcement', array( __CLASS__, 'filter_site_announcement' ) );

		}


		public static function register_admin_pages() {

			self::$site_announcement_admin_page = new AdminPage( array(
				'key' => 'site-announcement',
				'parent' => 'dashboard',
				'title' => 'Site Announcement',
				'menuTitle' => 'Site Announcement',
				'fields' => array(
					new FieldRepeater( array(
						'name' => 'site_announcements',
						'addNewLabel' => 'Add Site Announcement',
						'fields' => array(
							new FieldGroupSet( array(
								'fieldGroups' => array(
		
									new FieldGroup( array(
										'label' => 'General',
										'fields' => array(
											new Field( array(
												'input' => new CheckboxInput( array( 'name' => 'enabled', 'label' => 'Enable Announcement' ) )
											) ),
											new FieldGroup(array(
												'class' => 'no-border',
												// 'uIRules' => array( new UIRule( array( 'property' => 'input', 'options' => array( 'inputName' => 'enabled' ), 'value' => 1 ) ) ),
												'fields' => array(
													new Field( array(
														'label' => 'Message',
														'input' => new TextInput( array( 'name' => 'message', 'class' => 'input-large' ) )
													) ),
													new FieldGroup( array(
														'label' => 'Link',
														'fields' => array(
															new FieldGroup(array(
																'class' => 'no-border two-column large-left',
																'fields' => array(
																	new Field( array(
																		'label' => 'Link URL',
																		'input' => new TextInput( array( 'name' => 'link_url', 'placeholder' => 'https://' ) )
																	) ),
																	new Field( array(
																		'label' => 'Link Label',
																		'input' => new TextInput( array( 'name' => 'link_label', 'placeholder' => 'Learn More' ) )
																	) )
																)
															) ),
															new Field( array(
																'input' => new CheckboxSet( array( 'name' => 'link_options', 'options' => array(
																	array( 'value' => 'open-new-window', 'label' => 'Open in new window' )
																) ) )
															) )
														)
													) )
												)
											) )
										)
									) ),
		
									new FieldGroup( array(
										'label' => 'Style',
										'fields' => array(
											new Field( array(
												'label' => 'Background Color',
												'input' => new ColorInput( array( 'name' => 'bg_color', 'defaultValue' => '#444444', 'colorpickerOptions' => array( 'palettes' => apply_filters( 'crown_theme_colors', array(), 'site_announcement_bg_color' ) ) ) ),
											) ),
											new Field( array(
												'label' => 'Text Color',
												'description' => 'Manually toggle between dark & light colored text or configure to auto-determine based on background color.',
												'input' => new RadioSet( array( 'name' => 'text_color', 'defaultValue' => 'auto', 'class' => 'toggle', 'options' => array(
													array( 'value' => 'auto', 'label' => 'Auto' ),
													array( 'value' => 'dark', 'label' => 'Dark' ),
													array( 'value' => 'light', 'label' => 'Light' )
												) ) )
											) )
										)
									) ),

									new FieldGroup( array(
										'label' => 'Timing',
										'fields' => array(
											new Field( array(
												'input' => new CheckboxInput( array( 'name' => 'timing_controls_enabled', 'label' => 'Enable Timing Controls' ) )
											) ),
											new FieldGroup( array(
												'class' => 'no-border',
												'uIRules' => array( new UIRule( array( 'property' => 'input', 'options' => array( 'inputName' => 'timing_controls_enabled' ), 'value' => array( 1 ) ) ) ),
												'fields' => array(
													new FieldGroup( array(
														'class' => 'no-border two-column',
														'fields' => array(
															new Field( array(
																'label' => 'Start Date',
																'input' => new DateInput( array(
																	'name' => 'start_date',
																	'class' => 'start-date-input',
																	'datepickerOptions' => array(
																		'onClose' => 'function(selectedDate) { $(this).closest(\'.entry\').find(\'.end-date-input\').datepicker(\'option\', \'minDate\', selectedDate); }'
																	)
																) )
															) ),
															new Field( array(
																'label' => 'End Date',
																'input' => new DateInput( array(
																	'name' => 'end_date',
																	'class' => 'end-date-input',
																	'datepickerOptions' => array(
																		'onClose' => 'function(selectedDate) { $(this).closest(\'.entry\').find(\'.start-date-input\').datepicker(\'option\', \'maxDate\', selectedDate); }'
																	)
																) )
															) )
														)
													) )
												)
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


		public static function filter_site_announcement( $announcement = null ) {

			$site_announcements = get_repeater_entries( 'blog', 'site_announcements' );
			$current_time = new DateTime( current_time( 'Y-m-d H:i:s' ) );

			$site_announcements = array_filter( $site_announcements, function( $n ) use ( $current_time ) {
				if ( ! $n['enabled'] ) return false;
				if ( $n['timing_controls_enabled'] ) {
					if ( strtotime( $n['start_date'] ) !== false ) {
						$startDate = new DateTime( $n['start_date'] );
						if ( $current_time < $startDate ) return false;
					}
					if ( strtotime( $n['end_date'] ) !== false ) {
						$endDate = new DateTime( $n['end_date'] );
						$endDate->modify( 'tomorrow' );
						if ( $current_time > $endDate ) return false;
					}
				}
				return true;
			} );

			usort( $site_announcements, function($a, $b) {
				if ( ! $a['timing_controls_enabled'] && ! $b['timing_controls_enabled'] ) return 0;
				if ( ! $a['timing_controls_enabled'] ) return 1;
				if ( ! $b['timing_controls_enabled'] ) return -1;
				if ( ( strtotime( $a['start_date'] ) === false && strtotime( $b['start_date'] ) === false ) || $a['start_date'] == $b['start_date'] ) {
					if ( strtotime( $a['end_date'] ) === false && strtotime( $b['end_date'] ) === false ) return 0;
					if ( strtotime( $a['end_date'] ) === false) return 1;
					if ( strtotime( $b['end_date'] ) === false) return -1;
					return strcmp( $a['end_date'], $b['end_date'] );
				}
				if ( strtotime( $a['start_date'] ) === false ) return 1;
				if ( strtotime( $b['start_date'] ) === false ) return -1;
				return -strcmp( $a['start_date'], $b['start_date'] );
			} );

			if ( ! empty( $site_announcements ) ) {
				$a = $site_announcements[0];
				$announcement = (object) array(
					'message' => $a['message'],
					'link' => (object) array(
						'url' => $a['link_url'],
						'label' => $a['link_label'],
						'options' => $a['link_options']
					),
					'bg_color' => $a['bg_color'],
					'text_color' => $a['text_color']
				);
			}
			
			return $announcement;

		}


	}
}