<?php

if(!class_exists('Crown_Block_Brand_Index')) {
	class Crown_Block_Brand_Index extends Crown_Block {

		public static $name = 'brand-index';

		protected static $output_post_ids = array();

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
			wp_localize_script( 'crown-blocks-' . self::$name . '-script', 'crownBlockBrandIndexData', $data );
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' ),
			);
		}

		public static function render( $atts, $content ) {

			// $filters = self::get_post_feed_block_filters( array(
			// 	array(
			// 		'name' => 't_markets',
			// 		// 'title' => 'Filter by Markets Served',
			// 		'type' => 'taxonomy-term-select',
			// 		'taxonomy' => 'brand_market',
			// 		'all_label' => 'Filter by Markets Served'
			// 	)
			// ) );

			//$args = get_posts( array( 'post_type' => 'brand', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
			// $non_featured_post_ids = get_posts( array( 'post_type' => 'brand', 'posts_per_page' => -1, 'fields' => 'ids', 'orderby' => 'menu_order', 'order' => 'ASC', 'post__not_in' => $featured_post_ids ) );

			// $query = self::get_post_feed_block_filtered_query( array(
			// 	'post_type' => array( 'brand' ),
			// 	'posts_per_page' => -1,
			// 	'orderby' => 'post__in',
			// 	'order' => 'ASC',
			// 	'post__in' => array_merge( $featured_post_ids, $non_featured_post_ids )
			// ), $filters );
			$args = array(
				'post_type' => 'brand',
				'posts_per_page' => -1,
				'order' => 'ASC'
			);

			$query = new WP_Query( $args );

			ob_start();
			self::render_post_feed_block( $query, [], $atts, array( 'layout' => 'simple', 'pagination' => 'infinite' ) );
			return ob_get_clean();
		}


		protected static function render_post_feed_article() {

			// $color = get_post_meta( get_the_ID(), 'brand_primary_color', true );
			$options = get_post_meta( get_the_ID(), '__brand_options', false );


			?>
				<article id="<?php echo get_post_field( 'post_name', get_the_ID() ); ?>" <?php post_class( $options ); ?>>
					<div class="inner" <?php echo ! empty( $color ) ? 'style="border-color: ' . $color . ';"' : ''; ?>>

						<div class="overview">

							<div class="contents">
								<?php if ( has_post_thumbnail() ) { ?>
									<h3 class="entry-title"><?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'large' ); ?></h3>
								<?php } else { ?>
									<h3 class="entry-title"><?php the_title(); ?></h3>
								<?php } ?>
								<div class="entry-content"><?php the_content(); ?></div>
							</div>
							

						</div>

					</div>
				</article>
			<?php
		}


	}
	Crown_Block_Brand_Index::init();
}
