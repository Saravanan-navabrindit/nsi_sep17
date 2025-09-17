<?php

if(!class_exists('Crown_Block_Team_Member_Index')) {
	class Crown_Block_Team_Member_Index extends Crown_Block {

		public static $name = 'team-member-index';

		public static function init() {
			parent::init();
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_dependency_scripts' ), 100 );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'localize_script_data' ) );
		}

		public static function register_dependency_scripts() {
			$dependency_scripts = array( 'jquery' );
			global $wp_scripts;
			$block_script = $wp_scripts->query( 'crown-blocks-' . self::$name . '-script', 'registered' );
			if ( $block_script ) {
				foreach ( $dependency_scripts as $dep_handle ) {
					if( ! in_array( $dep_handle, $block_script->deps ) && $wp_scripts->query( $dep_handle, 'registered' ) ) {
						$block_script->deps[] = $dep_handle;
					}
				}
			}
		}

		public static function localize_script_data() {
			$data = array(
				'baseUrl' => get_home_url(),
				'blockClassName' => 'wp-block-crown-blocks-' . self::$name
			);
			wp_localize_script( 'crown-blocks-' . self::$name . '-script', 'crownBlockTeamMemberIndexData', $data );
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' ),
				'includeDepartments' => array( 'type' => 'string', 'default' => '' ),
				'excludeDepartments' => array( 'type' => 'string', 'default' => '' )
			);
		}

		public static function render( $atts, $content ) {

			$include_department_ids = array();
			if ( ! empty( $atts['includeDepartments'] ) ) {
				$term_names = array_filter( array_map( 'trim', explode( ',', $atts['includeDepartments'] ) ), function( $n ) { return ! empty( $n ); } );
				foreach ( $term_names as $term_name ) {
					$term = get_term_by( 'name', $term_name, 'team_member_department' );
					if ( ! empty( $term ) ) $include_department_ids[] = $term->term_id;
				}
			}

			$exclude_department_ids = array();
			if ( ! empty( $atts['excludeDepartments'] ) ) {
				$term_names = array_filter( array_map( 'trim', explode( ',', $atts['excludeDepartments'] ) ), function( $n ) { return ! empty( $n ); } );
				foreach ( $term_names as $term_name ) {
					$term = get_term_by( 'name', $term_name, 'team_member_department' );
					if ( ! empty( $term ) ) $exclude_department_ids[] = $term->term_id;
				}
			}

			$include_deptartment_filter_term_ids = get_terms( array(
				'taxonomy' => 'team_member_department',
				'include' => ! empty( $include_department_ids ) ? array_diff( $include_department_ids, $exclude_department_ids ) : array(),
				'exclude' => $exclude_department_ids,
				'fields' => 'ids'
			) );

			$filters_args = array();
			if ( ! empty( $include_deptartment_filter_term_ids ) && count( array_diff( $include_department_ids, $exclude_department_ids ) ) != 1 ) {
				$filters_args[] = array(
					'name' => 'tm_department',
					'type' => 'taxonomy-term-select',
					'taxonomy' => 'team_member_department',
					'include_terms' => $include_deptartment_filter_term_ids,
					'all_label' => 'Filter by Department'
				);
			}
			$filters = self::get_post_feed_block_filters( $filters_args );

			$query_args = array(
				'post_type' => array( 'team_member' ),
				'posts_per_page' => -1,
				'orderby' => 'meta_value',
				'meta_key' => 'team_member_name_last_comma_first',
				'order' => 'ASC',
				'tax_query' => array()
			);
			if ( ! empty( $include_department_ids ) ) {
				$query_args['tax_query'][] = array( array( 'taxonomy' => 'team_member_department', 'terms' => $include_department_ids ) );
				if ( count($include_department_ids) == 1 ) {
					$options = get_term_meta( $include_department_ids[0], '__team_member_department_options', false );
					if ( in_array( 'use-custom-order', $options ) ) {
						$query_args['orderby'] = 'tax_team_member_department_' . $include_department_ids[0] . '_order';
					}
				}
			}
			if ( ! empty( $exclude_department_ids ) ) {
				$query_args['tax_query'][] = array( array( 'taxonomy' => 'team_member_department', 'operator' => 'NOT IN', 'terms' => $exclude_department_ids ) );
			}
			$query = self::get_post_feed_block_filtered_query( $query_args, $filters );

			$block_args = array(
				'layout' => 'simple',
				'pagination' => 'infinite'
			);

			ob_start();
			self::render_post_feed_block( $query, $filters, $atts, $block_args );
			return ob_get_clean();
		}


		public static function render_post_feed_article() {
			?>
				<article <?php post_class(); ?>>
					<a href="<?php the_permalink(); ?>">
						<div class="inner">

							<div class="entry-headshot-photo">
								<div class="inner">
									<?php echo wp_get_attachment_image( get_post_meta( get_the_ID(), 'team_member_headshot_photo', true ), 'medium' ); ?>
								</div>
							</div>

							<h3 class="entry-title"><?php the_title(); ?></h3>

							<?php $job_title = get_post_meta( get_the_ID(), 'team_member_job_title', true ); ?>
							<?php if ( ! empty( $job_title ) ) { ?>
								<p class="entry-job-title"><?php echo $job_title; ?></p>
							<?php } ?>

							<?php /* $departments = get_the_terms( get_the_ID(), 'team_member_department' ); ?>
							<?php $department_names = ! empty( $departments ) ? array_map( function( $n ) { return $n->name; }, $departments ) : array(); ?>
							<?php if ( ! empty( $department_names ) ) { ?>
								<p class="entry-department"><?php echo implode( ', ', $department_names ); ?></p>
							<?php } */ ?>

							<?php $company = get_post_meta( get_the_ID(), 'team_member_company', true ); ?>
							<?php if ( ! empty( $company ) ) { ?>
								<p class="entry-company"><?php echo $company; ?></p>
							<?php } ?>

						</div>
					</a>
					<div class="drawer">
						<div class="inner">
							<div class="entry-details">

								<button class="close">Close</button>

								<?php $alt_photo = wp_get_attachment_image( get_post_meta( get_the_ID(), 'team_member_alt_photo', true ), 'large' ); ?>
								<?php if ( ! empty( $alt_photo ) ) { ?>
									<div class="entry-alt-photo">
										<div class="inner">
											<?php echo $alt_photo; ?>
										</div>
									</div>
								<?php } ?>

								<div class="entry-bio">
									<div class="inner">
										<h3 class="entry-title"><?php the_title(); ?></h3>
										<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), 'team_member_bio', true ) ); ?>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</article>
			<?php
		}


	}
	// Crown_Block_Team_Member_Index::init();
}
