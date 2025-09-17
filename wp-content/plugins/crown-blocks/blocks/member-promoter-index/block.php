<?php

if(!class_exists('Crown_Block_Member_Promoter_Index')) {
	class Crown_Block_Member_Promoter_Index extends Crown_Block {

		public static $name = 'member-promoter-index';

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
			wp_localize_script( 'crown-blocks-' . self::$name . '-script', 'crownBlockMemberPromoterIndexData', $data );
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' ),
			);
		}

		public static function render( $atts, $content ) {

			$filters = self::get_post_feed_block_filters( array(
				// array(
				// 	'name' => 'mp_keywords',
				// 	'type' => 'search',
				// 	'expandable' => false,
				// 	'placeholder' => 'Search'
				// ),
			) );

			$query = self::get_post_feed_block_filtered_query( array(
				'post_type' => array( 'member' ),
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
				'tax_query' => array(
					array( 'taxonomy' => 'member_level', 'field' => 'slug', 'terms' => 'promoters' )
				)
			), $filters );

			ob_start();
			self::render_post_feed_block( $query, $filters, $atts, array( 'layout' => 'simple', 'title' => 'Promoters', 'pagination' => 'infinite' ) );
			return ob_get_clean();
		}


		public static function render_post_feed_article() {
			$link = get_post_meta( get_the_ID(), 'member_website_url', true );
			?>
				<article <?php post_class(); ?>>
					<a <?php echo ! empty( $link ) ? 'href="' . $link . '" target="_blank"' : 'href="' . get_the_permalink() . '"'; ?>>
						<div class="inner">

							<div class="contents">

								<?php if ( has_post_thumbnail() ) { ?>
									<h3 class="entry-title"><span class="logo-wrap"><?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'medium' ); ?></span></h3>
								<?php } else { ?>
									<h3 class="entry-title"><?php the_title(); ?></h3>
								<?php } ?>

								<div class="entry-content"><p><?php echo wp_trim_words( get_the_content(), 14, '&hellip;' ); ?></p></div>

							</div>
							
							<p class="cta">
								<span class="btn btn--link link-arrow btn--link-blue"><span class="btn-label">Visit Site</span><span class="btn__arrow"></span></span>
							</p>

						</div>
					</a>
				</article>
			<?php
		}


	}
	// Crown_Block_Member_Promoter_Index::init();
}
