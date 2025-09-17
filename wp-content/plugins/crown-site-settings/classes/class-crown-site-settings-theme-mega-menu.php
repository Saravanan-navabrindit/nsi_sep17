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
use Crown\Form\Input\Textarea;
use Crown\Form\Input\RichTextarea;
use Crown\Post\MetaBox;
use Crown\Post\Type as PostType;
use Crown\UIRule;


if ( ! class_exists( 'Crown_Site_Settings_Theme_Mega_Menu' ) ) {
	class Crown_Site_Settings_Theme_Mega_Menu {

		public static $init = false;

		public static $theme_mega_menu_admin_page = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			add_action( 'after_setup_theme', array( __CLASS__, 'register_admin_pages' ) );
			add_filter( 'crown_mega_menu', array( __CLASS__, 'filter_mega_menu' ) );

		}


		public static function register_admin_pages() {

			self::$theme_mega_menu_admin_page = new AdminPage( array(
				'key' => 'theme-mega-menu',
				'parent' => 'theme',
				'title' => 'Mega Menu',
				'fields' => array(
					new FieldRepeater( array(
						'name' => 'theme_mega_menu_items',
						'addNewLabel' => 'Add Menu Item',
						'fields' => array(
							new FieldGroupSet( array(
								'fieldGroups' => array(
		
									new FieldGroup( array(
										'label' => 'General',
										'fields' => array(
											new Field( array(
												'label' => 'Title',
												'input' => new TextInput( array( 'name' => 'title', 'class' => 'input-large' ) )
											) ),
											new FieldGroup( array(
												'class' => 'no-border two-column large-left',
												'fields' => array(
													new Field( array(
														'label' => 'Link URL (optional)',
														'input' => new TextInput( array( 'name' => 'link_url' ) )
													) ),
													new Field( array(
														'label' => '&nbsp;',
														'input' => new CheckboxSet( array( 'name' => 'link_options', 'options' => array(
															array( 'value' => 'open-new-window', 'label' => 'Open in new window' )
														) ) )
													) )
												)
											) ),
											new Field( array(
												'label' => 'Menu Type',
												'input' => new RadioSet( array( 'name' => 'type', 'defaultValue' => 'default', 'class' => 'toggle', 'options' => array(
													array( 'value' => 'default', 'label' => 'Standard' ),
													array( 'value' => 'events', 'label' => 'Events' ),
													array( 'value' => 'disabled', 'label' => 'Disabled' )
												) ) )
											) )
										)
									) ),

									new FieldGroup( array(
										'label' => 'Primary Section',
										'uIRules' => array( new UIRule( array( 'property' => 'input', 'options' => array( 'inputName' => 'type' ), 'value' => array( 'default' ) ) ) ),
										'fields' => array(
											new Field( array(
												'label' => 'Title',
												'input' => new TextInput( array( 'name' => 'primary_section_title', 'class' => 'input-large' ) )
											) ),
											new Field( array(
												'label' => 'Menu Layout',
												'input' => new RadioSet( array( 'name' => 'primary_section_menu_layout', 'defaultValue' => 'default', 'class' => 'toggle', 'options' => array(
													array( 'value' => 'default', 'label' => 'Multi-Column' ),
													array( 'value' => 'sub-menus', 'label' => 'Sub-Menus' ),
													array( 'value' => 'content', 'label' => 'Content' ),
													array( 'value' => 'disabled', 'label' => 'Disabled' )
												) ) )
											) ),
											new FieldGroup( array(
												'label' => 'Sub Menu',
												'uIRules' => array( new UIRule( array( 'property' => 'input', 'options' => array( 'inputName' => 'primary_section_menu_layout' ), 'value' => array( 'default' ) ) ) ),
												'fields' => array(
													new Field( array(
														'label' => 'Title',
														'input' => new TextInput( array( 'name' => 'primary_section_sub_menu_title' ) )
													) ),
													new Field( array(
														'label' => 'Menu',
														'input' => new Select( array( 'name' => 'primary_section_sub_menu' ) ),
														'getOutputCb' => array( __CLASS__, 'set_menu_select_field_options' ),
													) )
												)
											) ),
											new FieldGroup( array(
												'label' => 'Sub Menus',
												'uIRules' => array( new UIRule( array( 'property' => 'input', 'options' => array( 'inputName' => 'primary_section_menu_layout' ), 'value' => array( 'sub-menus' ) ) ) ),
												'fields' => array(
													new FieldRepeater( array(
														'name' => 'primary_section_sub_menus',
														'addNewLabel' => 'Add Sub-Menu',
														'fields' => array(
															new Field( array(
																'label' => 'Title',
																'input' => new TextInput( array( 'name' => 'title' ) )
															) ),
															new FieldGroup( array(
																'class' => 'no-border two-column large-left',
																'fields' => array(
																	new Field( array(
																		'label' => 'Link URL (optional)',
																		'input' => new TextInput( array( 'name' => 'link_url', 'placeholder' => 'https://' ) )
																	) ),
																	new Field( array(
																		'label' => '&nbsp;',
																		'input' => new CheckboxSet( array( 'name' => 'link_options', 'options' => array(
																			array( 'value' => 'open-new-window', 'label' => 'Open in new window' )
																		) ) )
																	) )
																)
															) ),
															new Field( array(
																'label' => 'Menu',
																'input' => new Select( array( 'name' => 'menu' ) ),
																'getOutputCb' => array( __CLASS__, 'set_menu_select_field_options' ),
															) )
														)
													) )
												)
											) ),
											new FieldGroup( array(
												'label' => 'Content',
												'uIRules' => array( new UIRule( array( 'property' => 'input', 'options' => array( 'inputName' => 'primary_section_menu_layout' ), 'value' => array( 'content' ) ) ) ),
												'fields' => array(
													new Field( array(
														'input' => new RichTextarea( array( 'name' => 'primary_section_content', 'rows' => 8 ) ),
													) )
												)
											) ),
											new FieldGroup( array(
												'label' => 'CTA Links',
												'uIRules' => array( new UIRule( array( 'property' => 'input', 'options' => array( 'inputName' => 'primary_section_menu_layout' ), 'value' => array( 'disabled' ), 'compare' => 'not in' ) ) ),
												'fields' => array(
													new FieldRepeater( array(
														'name' => 'primary_section_cta_links',
														'addNewLabel' => 'Add CTA Link',
														'fields' => array(
															new FieldGroup( array(
																'class' => 'no-border two-column large-left',
																'fields' => array(
																	new Field( array(
																		'input' => new TextInput( array( 'name' => 'url', 'label' => 'Link URL', 'placeholder' => 'https://' ) )
																	) ),
																	new FieldGroup( array(
																		'class' => 'no-border two-column',
																		'fields' => array(
																			new Field( array(
																				'input' => new TextInput( array( 'name' => 'label', 'label' => 'Link Label', 'placeholder' => 'Learn More' ) )
																			) ),
																			new Field( array(
																				'input' => new CheckboxSet( array( 'name' => 'options', 'options' => array(
																					array( 'value' => 'open-new-window', 'label' => 'Open in new window' )
																				) ) )
																			) )
																		)
																	) ),
																)
															) )
														)
													) )
												)
											) )
										)
									) ),

									new FieldGroup( array(
										'label' => 'Secondary Section',
										'uIRules' => array( new UIRule( array( 'property' => 'input', 'options' => array( 'inputName' => 'type' ), 'value' => array( 'default', 'events' ) ) ) ),
										'fields' => array(
											new Field( array(
												'label' => 'Title',
												'input' => new TextInput( array( 'name' => 'secondary_section_title', 'class' => 'input-large' ) )
											) ),
											new Field( array(
												'label' => 'Menu Layout',
												'input' => new RadioSet( array( 'name' => 'secondary_section_menu_layout', 'defaultValue' => 'default', 'class' => 'toggle', 'options' => array(
													array( 'value' => 'default', 'label' => 'Multi-Column' ),
													array( 'value' => 'sub-menus', 'label' => 'Sub-Menus' ),
													array( 'value' => 'content', 'label' => 'Content' ),
													array( 'value' => 'disabled', 'label' => 'Disabled' )
												) ) )
											) ),
											new FieldGroup( array(
												'label' => 'Sub Menu',
												'uIRules' => array( new UIRule( array( 'property' => 'input', 'options' => array( 'inputName' => 'secondary_section_menu_layout' ), 'value' => array( 'default' ) ) ) ),
												'fields' => array(
													new Field( array(
														'label' => 'Title',
														'input' => new TextInput( array( 'name' => 'secondary_section_sub_menu_title' ) )
													) ),
													new Field( array(
														'label' => 'Menu',
														'input' => new Select( array( 'name' => 'secondary_section_sub_menu' ) ),
														'getOutputCb' => array( __CLASS__, 'set_menu_select_field_options' ),
													) )
												)
											) ),
											new FieldGroup( array(
												'label' => 'Sub Menus',
												'uIRules' => array( new UIRule( array( 'property' => 'input', 'options' => array( 'inputName' => 'secondary_section_menu_layout' ), 'value' => array( 'sub-menus' ) ) ) ),
												'fields' => array(
													new FieldRepeater( array(
														'name' => 'secondary_section_sub_menus',
														'addNewLabel' => 'Add Sub-Menu',
														'fields' => array(
															new Field( array(
																'label' => 'Title',
																'input' => new TextInput( array( 'name' => 'title' ) )
															) ),
															new FieldGroup( array(
																'class' => 'no-border two-column large-left',
																'fields' => array(
																	new Field( array(
																		'label' => 'Link URL (optional)',
																		'input' => new TextInput( array( 'name' => 'link_url', 'placeholder' => 'https://' ) )
																	) ),
																	new Field( array(
																		'label' => '&nbsp;',
																		'input' => new CheckboxSet( array( 'name' => 'link_options', 'options' => array(
																			array( 'value' => 'open-new-window', 'label' => 'Open in new window' )
																		) ) )
																	) )
																)
															) ),
															new Field( array(
																'label' => 'Menu',
																'input' => new Select( array( 'name' => 'menu' ) ),
																'getOutputCb' => array( __CLASS__, 'set_menu_select_field_options' ),
															) )
														)
													) )
												)
											) ),
											new FieldGroup( array(
												'label' => 'Content',
												'uIRules' => array( new UIRule( array( 'property' => 'input', 'options' => array( 'inputName' => 'secondary_section_menu_layout' ), 'value' => array( 'content' ) ) ) ),
												'fields' => array(
													new Field( array(
														'input' => new RichTextarea( array( 'name' => 'secondary_section_content', 'rows' => 8 ) ),
													) )
												)
											) ),
											new FieldGroup( array(
												'label' => 'CTA Links',
												'uIRules' => array( new UIRule( array( 'property' => 'input', 'options' => array( 'inputName' => 'secondary_section_menu_layout' ), 'value' => array( 'disabled' ), 'compare' => 'not in' ) ) ),
												'fields' => array(
													new FieldRepeater( array(
														'name' => 'secondary_section_cta_links',
														'addNewLabel' => 'Add CTA Link',
														'fields' => array(
															new FieldGroup( array(
																'class' => 'no-border two-column',
																'fields' => array(
																	new Field( array(
																		'input' => new TextInput( array( 'name' => 'url', 'label' => 'Link URL', 'placeholder' => 'https://' ) )
																	) ),
																	new FieldGroup( array(
																		'class' => 'no-border two-column',
																		'fields' => array(
																			new Field( array(
																				'input' => new TextInput( array( 'name' => 'label', 'label' => 'Link Label', 'placeholder' => 'Learn More' ) )
																			) ),
																			new Field( array(
																				'input' => new CheckboxSet( array( 'name' => 'options', 'options' => array(
																					array( 'value' => 'open-new-window', 'label' => 'Open in new window' )
																				) ) )
																			) )
																		)
																	) ),
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
					) )
				)
			) );

		}


		public static function set_menu_select_field_options( $field, $args ) {
			$options = array( array( 'value' => '', 'label' => '&mdash;' ) );
			foreach ( wp_get_nav_menus() as $nav_menu ) {
				$options[] = array( 'value' => $nav_menu->term_id, 'label' => $nav_menu->name );
			}
			$field->getInput()->setOptions( $options );
		}


		public static function filter_mega_menu( $mega_menu = null ) {

			$menu = (object) array(
				'items' => array()
			);

			foreach ( get_repeater_entries( 'blog', 'theme_mega_menu_items' ) as $n ) {

				$item = (object) array(
					'id' => $n['id'],
					'title' => $n['title'],
					'link' => (object) array(
						'href' => $n['link_url'],
						'target' => in_array( 'open-new-window', $n['link_options'] ) ? '_blank' : '_self'
					),
					'type' => $n['type'],
					'sections' => (object) array(
						'primary' => null,
						'secondary' => null
					)
				);

				if ( ! in_array( $item->type, array( 'disabled' ) ) ) {

					$section = (object) array(
						'title' => $n['primary_section_title'],
						'layout' => $n['primary_section_menu_layout'],
						'menus' => null,
						'content' => '',
						'cta_links' => array()
					);

					if ( in_array( $section->layout, array( 'default' ) ) ) {
						$section->menus[] = (object) array(
							'title' => $n['primary_section_sub_menu_title'],
							'link' => (object) array(
								'href' => '',
								'target' => '_self'
							),
							'menu_id' => $n['primary_section_sub_menu']
						);
					}
					
					if ( in_array( $section->layout, array( 'sub-menus' ) ) ) {
						foreach ( get_repeater_entries( 'post', 'primary_section_sub_menus', $n['id'] ) as $m ) {
							$section->menus[] = (object) array(
								'title' => $m['title'],
								'link' => (object) array(
									'href' => $m['link_url'],
									'target' => in_array( 'open-new-window', $m['link_options'] ) ? '_blank' : '_self'
								),
								'menu_id' => $m['menu']
							);
						}
					}
					
					if ( in_array( $section->layout, array( 'content' ) ) ) {
						$section->content = $n['primary_section_content'];
					}

					if ( ! in_array( $section->layout, array( 'disabled' ) ) ) {
						foreach ( get_repeater_entries( 'post', 'primary_section_cta_links', $n['id'] ) as $m ) {
							$section->cta_links[] = (object) array(
								'href' => $m['url'],
								'label' => $m['label'],
								'target' => in_array( 'open-new-window', $m['options'] ) ? '_blank' : '_self'
							);
						}
					}
					
					$item->sections->primary = $section;

				}

				if ( ! in_array( $item->type, array( 'disabled' ) ) ) {

					$section = (object) array(
						'title' => $n['secondary_section_title'],
						'layout' => $n['secondary_section_menu_layout'],
						'menus' => null,
						'content' => '',
						'cta_links' => array()
					);

					if ( in_array( $section->layout, array( 'default' ) ) ) {
						$section->menus[] = (object) array(
							'title' => $n['secondary_section_sub_menu_title'],
							'link' => (object) array(
								'href' => '',
								'target' => '_self'
							),
							'menu_id' => $n['secondary_section_sub_menu']
						);
					}
					
					if ( in_array( $section->layout, array( 'sub-menus' ) ) ) {
						foreach ( get_repeater_entries( 'post', 'secondary_section_sub_menus', $n['id'] ) as $m ) {
							$section->menus[] = (object) array(
								'title' => $m['title'],
								'link' => (object) array(
									'href' => $m['link_url'],
									'target' => in_array( 'open-new-window', $m['link_options'] ) ? '_blank' : '_self'
								),
								'menu_id' => $m['menu']
							);
						}
					}
					
					if ( in_array( $section->layout, array( 'content' ) ) ) {
						$section->content = $n['secondary_section_content'];
					}

					if ( ! in_array( $section->layout, array( 'disabled' ) ) ) {
						foreach ( get_repeater_entries( 'post', 'secondary_section_cta_links', $n['id'] ) as $m ) {
							$section->cta_links[] = (object) array(
								'href' => $m['url'],
								'label' => $m['label'],
								'target' => in_array( 'open-new-window', $m['options'] ) ? '_blank' : '_self'
							);
						}
					}
					
					$item->sections->secondary = $section;

				}

				$menu->items[] = $item;

			}

			return ! empty( $menu->items ) ? $menu : $mega_menu;
		}


	}
}