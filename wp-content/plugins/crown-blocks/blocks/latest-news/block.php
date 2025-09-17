<?php

if(!class_exists('Crown_Block_Latest_News')) {
	class Crown_Block_Latest_News extends Crown_Block {

		public static $name = 'latest-news';

		protected static $output_post_ids = array();

		public static function init() {
			parent::init();
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' ),
			);
		}

		public static function render( $atts, $content ) {
			
			$queryArgs = array(
				'post_type' => array( 'post' ),
				'posts_per_page' => 3
			);

			$query = new WP_Query( $queryArgs );
			if ( ! $query->have_posts() ) return '';

			$index_page_url = get_permalink( get_option( 'page_for_posts' ) );

			$block_class = array( 'wp-block-crown-blocks-latest-news' );

			ob_start();
			?>

				<div class="<?php echo implode( ' ', $block_class ); ?>">
					<div class="inner">
						<div class="post-feed item-count-<?php echo $query->post_count; ?>" data-item-count="<?php echo $query->post_count; ?>">

							<div class="inner">
								<?php while ( $query->have_posts() ) { ?>
									<?php $query->the_post(); ?>
									<?php get_template_part( 'template-parts/index-entry-content', get_post_type() ); ?>
								<?php } ?>
								<?php wp_reset_postdata(); ?>
							</div>

						</div>
					</div>
				</div>

			<?php
			$output = ob_get_clean();

			return $output;
		}


	}
	Crown_Block_Latest_News::init();
}
