<?php

if(!class_exists('Crown_Block_Latest_Posts')) {
	class Crown_Block_Latest_Posts extends Crown_Block {

		public static $name = 'latest-posts';

		protected static $output_post_ids = array();

		public static function init() {
			parent::init();

			add_filter( 'crown_blocks_prev_post_ids', array( get_called_class(), 'filter_crown_blocks_prev_post_ids' ) );
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' ),
			);
		}

		public static function render( $atts, $content ) {
			
			$queryArgs = array(
				'post_type' => array( 'post' ),
				'posts_per_page' => 3,
				'tax_query' => array(),
				'post__not_in' => array(),
				'post__in' => array(),
			);

			$query = new WP_Query( $queryArgs );
			if ( ! $query->have_posts() ) return '';

			$block_class = array( 'wp-block-crown-blocks-latest-posts' );

			ob_start();
			// print_r($atts);
			?>

				<div class="<?php echo implode( ' ', $block_class ); ?>">
					<div class="inner">
						<h2 class="latest-posts__title"><?php echo ($atts['optionalTitle']) ? $atts['optionalTitle'] : "Latest News"; ?></h2>
						<div class="post-feed item-count-<?php echo $query->post_count; ?>" data-item-count="<?php echo $query->post_count; ?>">
							<div class="inner">
								<?php while ( $query->have_posts() ) { ?>
									<?php $query->the_post(); ?>
									<article <?php post_class( 'post-teaser latest-posts' ); ?>>
										<a class="post-teaser__post" href="<?= get_permalink(); ?>">
											<?php $image_src = has_post_thumbnail() ? wp_get_attachment_image_url( get_post_thumbnail_id(), 'medium_large' ) : false; ?>
											<div class="post-teaser__post-img" style="background-image: url(<?php echo $image_src; ?>);"></div>
											<?php $date = strtotime(get_post_meta( get_the_ID(), 'date', true )); ?>
											<div class="post-teaser__meta">
												<?php $primary_category = function_exists('the_seo_framework') ? the_seo_framework()->get_primary_term(get_the_ID(), 'category' ) : null; ?>
												<?php if(empty($primary_category)) { $categories = get_the_terms(get_the_ID(), 'category'); $primary_category = !empty($categories) && is_array($categories) ? $categories[0] : $primary_category; } ?>
												<?php if (! empty( $primary_category )) { ?>
													<div class="post-teaser__category" href="<?php echo get_term_link($primary_category->term_id); ?>"><?php echo $primary_category->name; ?></div>
												<?php } ?>
												<h4 class="post-teaser__post-title"><?php the_title(); ?></h4>
												<div class="post-teaser__post-date"><?php echo date("M",$date); ?> <?php echo date("j",$date); ?></div>
											</div>
											</a>
									</article>
								<?php } ?>
								
								<?php wp_reset_postdata(); ?>

							</div>
						</div>

					</div>
				</div>

			<?php
			$output = ob_get_clean();

			self::add_output_post_ids( array_map( function($n) { return $n->ID; }, $query->posts ) );

			return $output;
		}

		public static function get_output_post_ids() {
			return self::$output_post_ids;
		}


		public static function add_output_post_ids( $output_post_ids = array() ) {
			self::$output_post_ids = array_unique( array_merge( self::$output_post_ids, $output_post_ids ) );
		}


		public static function filter_crown_blocks_prev_post_ids( $prev_post_ids = array() ) {
			return array_unique( array_merge( $prev_post_ids, self::get_output_post_ids() ) );
		}


	}
	Crown_Block_Latest_Posts::init();
}
