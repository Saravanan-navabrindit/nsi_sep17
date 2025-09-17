<?php

use Crown\AdminPage;
use Crown\Api\GoogleMaps;
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


if ( ! class_exists( 'Crown_Team' ) ) {
	class Crown_Team {

		public static $init = false;

		public static $team_member_post_type = null;
		public static $team_members_shortcode = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			$plugin_file = preg_replace( '/\/classes$/', '', dirname( __FILE__ ) ) . '/plugin.php';
			register_activation_hook( $plugin_file, array( __CLASS__, 'activate' ));
			register_deactivation_hook( $plugin_file, array( __CLASS__, 'deactivate' ));

			add_action( 'after_setup_theme', array( __CLASS__, 'register_team_member_post_type' ) );

			add_filter( 'use_block_editor_for_post_type', array( __CLASS__, 'filter_use_block_editor_for_post_type' ), 10, 2 );

			add_action( 'after_setup_theme', array( __CLASS__, 'register_team_members_shortcode' ) );

		}


		public static function activate() {
			global $wp_roles;
			
			foreach ( $wp_roles->role_objects as $role ) {
				foreach ( array( 'publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private' ) as $cap ) {
					if ( $role->has_cap( $cap . '_posts' ) ) {
						$role->add_cap( $cap . '_team_members' );
					}
				}
				// foreach ( array( 'manage', 'edit', 'delete' ) as $cap ) {
				// 	if ( $role->has_cap( 'manage_categories' ) ) {
				// 		$role->add_cap( $cap . '_resource_industries' );
				// 	}
				// }
				// if ( $role->has_cap( 'edit_posts' ) ) {
				// 	$role->add_cap( 'assign_resource_industries' );
				// }
			}

			flush_rewrite_rules();
		}


		public static function deactivate() {
			global $wp_roles;
			
			foreach ( $wp_roles->role_objects as $role ) {
				foreach ( array( 'publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private' ) as $cap ) {
					$role->remove_cap( $cap . '_team_members' );
				}
				// foreach ( array( 'manage', 'edit', 'delete', 'assign' ) as $cap ) {
				// 	$role->remove_cap ( $cap . '_resource_industries' );
				// }
			}
			
			flush_rewrite_rules();
		}


		public static function register_team_member_post_type() {

			self::$team_member_post_type = new PostType( array(
				'name' => 'team_member',
				'singularLabel' => 'Team Member',
				'pluralLabel' => 'Team Members',
				'settings' => array(
					'supports' => array( 'title', 'revisions', 'thumbnail' ),
					'rewrite' => array( 'slug' => 'team-members', 'with_front' => false ),
					'menu_icon' => 'dashicons-businessperson',
					'has_archive' => false,
					'publicly_queryable' => false,
					'show_in_rest' => true,
					'show_in_nav_menus' => false,
					'capability_type' => array( 'team_member', 'team_members' ),
					'map_meta_cap' => true,
					'menu_position' => 39
				),
				'metaBoxes' => array(
					new MetaBox( array(
						'id' => 'team-member-details',
						'title' => 'Details',
						'priority' => 'high',
						'fields' => array(
							new FieldGroup( array(
								'label' => 'Social Profile Links',
								'fields' => array(
									new Field( array(
										'label' => 'YouTube',
										'input' => new TextInput( array( 'name' => 'team_member_social_link_youtube' ) )
									) ),
									new Field( array(
										'label' => 'Facebook',
										'input' => new TextInput( array( 'name' => 'team_member_social_link_facebook' ) )
									) ),
									new Field( array(
										'label' => 'Instagram',
										'input' => new TextInput( array( 'name' => 'team_member_social_link_instagram' ) )
									) ),
									new Field( array(
										'label' => 'LinkedIn',
										'input' => new TextInput( array( 'name' => 'team_member_social_link_linkedin' ) )
									) ),
									new Field( array(
										'label' => 'Twitter',
										'input' => new TextInput( array( 'name' => 'team_member_social_link_twitter' ) )
									) )
								)
							) ),
							new Field( array(
								'label' => 'Summary',
								'input' => new Textarea( array( 'name' => 'team_member_summary', 'rows' => 4 ) )
							) )
						)
					) ),
					new MetaBox( array(
						'id' => 'team-member-bio',
						'title' => 'Details',
						'priority' => 'high',
						'fields' => array(
							new Field( array(
								'input' => new RichTextarea( array( 'name' => 'team_member_bio', 'rows' => 10 ) )
							) )
						)
					) )
				),
				'listTableColumns' => array(
					// new ListTableColumn( array(
					// 	'key' => 'sales-rep-country',
					// 	'title' => 'Country',
					// 	'position' => 2,
					// 	'outputCb' => function( $post_id, $args ) {
					// 		$country = get_post_meta( $post_id, 'sales_rep_country', true );
					// 		echo $country;
					// 	}
					// ) ),
					// new ListTableColumn( array(
					// 	'key' => 'sales-rep-regions',
					// 	'title' => 'Regions',
					// 	'position' => 3,
					// 	'outputCb' => function( $post_id, $args ) {
					// 		$regions = get_post_meta( $post_id, 'sales_rep_regions', true );
					// 		if ( empty( $regions ) || ! is_array( $regions ) ) return;
					// 		$output = array_map( function( $n ) { return preg_replace( '/.+\//', '', $n ); }, $regions );
					// 		echo implode( ', ', $output );
					// 	}
					// ) )
				)
			) );

		}


		public static function filter_use_block_editor_for_post_type( $use_block_editor, $post_type ) {
			return in_array( $post_type, array( 'team_member' ) ) ? false : $use_block_editor;
		}


		public static function register_team_members_shortcode() {

			self::$team_members_shortcode = new Shortcode( array(
				'tag' => 'team_members',
				'defaultAtts' => array(),
				'getOutputCb' => function( $atts, $content ) {

					$team_member_query = new WP_Query( array(
						'post_type' => 'team_member',
						'posts_per_page' => -1,
						'orderby' => 'menu_order',
						'order' => 'ASC'
					) );
					if ( ! $team_member_query->have_posts() ) return '';

					ob_start();
					?>

						<div class="team-members-grid row">
							<?php while ( $team_member_query->have_posts() ) { ?>
								<?php $team_member_query->the_post(); ?>
								<div <?php post_class( 'team-member col col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex mb-3' ); ?>>
									<div class="overview w-100 d-flex bg-white text-body p-3" data-toggle="modal" data-target="#team-member-modal-<?php the_ID(); ?>">
										<div class="inner w-100">

											<div class="headshot">
												<?php the_post_thumbnail( 'medium' ); ?>
											</div>

											<ul class="social-links">
												<?php foreach ( array( 'youtube', 'facebook', 'instagram', 'linkedin', 'twitter' ) as $site ) { ?>
													<?php $link = get_post_meta( get_the_ID(), 'team_member_social_link_' . $site, true ); ?>
													<?php if ( empty( $link ) ) continue; ?>
													<li class="<?php echo sanitize_title( $site ); ?>">
														<a href="<?php echo $link; ?>" target="_blank"><span class="label"><?php echo $site; ?></span></a>
													</li>
												<?php } ?>
											</ul>

											<h3 class="name"><?php the_title(); ?></h3>

											<div class="summary">
												<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), 'team_member_summary', true ) ); ?>
											</div>

										</div>
									</div>
								</div>
							<?php } ?>
							<?php wp_reset_postdata(); ?>
						</div>

						<?php while ( $team_member_query->have_posts() ) { ?>
							<?php $team_member_query->the_post(); ?>
							<div id="team-member-modal-<?php the_ID(); ?>" <?php post_class( 'modal fade team-member-modal' ); ?> tabindex="-1">
								<div class="modal-dialog modal-xl modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<div class="row">

												<div class="col col-sm-4">

													<div class="headshot">
														<?php the_post_thumbnail( 'medium' ); ?>
													</div>

													<ul class="social-links">
														<?php foreach ( array( 'youtube', 'facebook', 'instagram', 'linkedin', 'twitter' ) as $site ) { ?>
															<?php $link = get_post_meta( get_the_ID(), 'team_member_social_link_' . $site, true ); ?>
															<?php if ( empty( $link ) ) continue; ?>
															<li class="<?php echo sanitize_title( $site ); ?>">
																<a href="<?php echo $link; ?>" target="_blank"><span class="label"><?php echo $site; ?></span></a>
															</li>
														<?php } ?>
													</ul>

												</div>

												<div class="col col-sm-8">

													<h3 class="name"><?php the_title(); ?></h3>

													<div class="bio">
														<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), 'team_member_bio', true ) ); ?>
													</div>

												</div>

											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						<?php wp_reset_postdata(); ?>

					<?php
					return ob_get_clean();

				}
			) );

		}


	}
}