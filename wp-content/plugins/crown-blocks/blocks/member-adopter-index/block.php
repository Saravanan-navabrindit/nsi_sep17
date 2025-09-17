<?php

if(!class_exists('Crown_Block_Member_Adopter_Index')) {
	class Crown_Block_Member_Adopter_Index extends Crown_Block {

		public static $name = 'member-adopter-index';

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
			wp_localize_script( 'crown-blocks-' . self::$name . '-script', 'crownBlockMemberAdopterIndexData', $data );
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' ),
				'viewAllLinkUrl' => array( 'type' => 'string', 'default' => '' ),
			);
		}

		public static function render( $atts, $content ) {

			$filters_args = array();
			if ( empty( $atts['viewAllLinkUrl'] ) ) {
				$filters_args[] = array( 'name' => 'ma_keywords', 'type' => 'search', 'expandable' => false, 'placeholder' => 'Search' );
			}
			$filters = self::get_post_feed_block_filters( $filters_args );

			$query = self::get_post_feed_block_filtered_query( array(
				'post_type' => array( 'member' ),
				'posts_per_page' => empty( $atts['viewAllLinkUrl'] ) ? -1 : 12,
				'orderby' => 'title',
				'order' => 'ASC',
				'tax_query' => array(
					array( 'taxonomy' => 'member_level', 'field' => 'slug', 'terms' => 'adopters' )
				)
			), $filters );

			$block_args = array(
				'layout' => 'simple',
				'title' => 'Adopters',
				'pagination' => false
			);
			if ( ! empty( $atts['viewAllLinkUrl'] ) ) {
				$all_ids = get_posts( array(
					'post_type' => array( 'member' ),
					'posts_per_page' => -1,
					'fields' => 'ids',
					'tax_query' => array(
						array( 'taxonomy' => 'member_level', 'field' => 'slug', 'terms' => 'adopters' )
					)
				) );
				$block_args['link_label'] = 'See All ' . count( $all_ids );
				$block_args['link_url'] = $atts['viewAllLinkUrl'];
			}

			ob_start();
			self::render_post_feed_block( $query, $filters, $atts, $block_args );
			return ob_get_clean();
		}


		public static function render_post_feed_article() {
			$link = get_post_meta( get_the_ID(), 'member_website_url', true );
			?>
				<article <?php post_class(); ?>>
					<a <?php echo ! empty( $link ) ? 'href="' . $link . '" target="_blank"' : 'href="' . get_the_permalink() . '"'; ?>>
						<div class="inner">

							<div class="contents">

								<h3 class="entry-title"><?php the_title(); ?></h3>

							</div>
							
						</div>
					</a>
				</article>
			<?php
		}


	}
	// Crown_Block_Member_Adopter_Index::init();
}
