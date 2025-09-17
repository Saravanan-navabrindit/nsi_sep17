<?php

if(!class_exists('Crown_Block_Latest_News_Article')) {
	class Crown_Block_Latest_News_Article extends Crown_Block {

		public static $name = 'latest-news-article';

		protected static $output_post_ids = array();

		public static function init() {
			parent::init();
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' ),
				'enableNewsCTA' => array( 'type' => 'boolean', 'default' => true ),
				'newsCTALink' => array( 'type' => 'string', 'default' => '' )
			);
		}

		public static function render( $atts, $content ) {
			
			$queryArgs = array(
				'post_type' => array( 'post' ),
				'posts_per_page' => 1
			);

			$query = new WP_Query( $queryArgs );
			if ( ! $query->have_posts() ) return '';

			$index_page_url = get_permalink( get_option( 'theme_config_index_page_post' ) );
			if ( ! empty( $atts['newsCTALink'] ) ) $index_page_url = $atts['newsCTALink'];

			$block_class = array( 'wp-block-crown-blocks-latest-news-article' );

			ob_start();
			// print_r($atts);
			?>

				<div class="<?php echo implode( ' ', $block_class ); ?>">
					<div class="inner">
						<div class="post-feed item-count-<?php echo $query->post_count; ?>" data-item-count="<?php echo $query->post_count; ?>">

							<h2>Latest Alliance News</h2>

							<div class="inner">
								<?php while ( $query->have_posts() ) { ?>
									<?php $query->the_post(); ?>
									<article <?php post_class(); ?>>
										<a href="<?= get_permalink(); ?>" target="<?php echo apply_filters( 'post_link_target', '_self' ); ?>">
											<div class="inner">
												<div class="contents">
													<h3 class="entry-title"><?php the_title(); ?></h3>
													<?php $authors = get_the_terms( get_the_ID(), 'post_author' ); ?>
													<?php $author_names = $authors ? array_map( function( $n ) { return $n->name; }, $authors ) : array(); ?>
													<?php if ( ! empty( $author_names ) ) { ?>
														<p class="entry-author">by <?php echo implode( ', ', $author_names ); ?></p>
													<?php } ?>
													<p class="entry-date"><?php the_time( 'F j, Y' ); ?></p>
												</div>
												<?php $cta = get_post_meta( get_the_ID(), 'post_cta_label', true ); ?>
												<p class="cta"><span class="btn btn--link link-arrow"><span class="btn-label"><?php echo ! empty( $cta ) ? $cta : 'Read More'; ?></span><span class="btn__arrow"></span></span></p>
											</div>
										</a>
									</article>
								<?php } ?>
								
								<?php wp_reset_postdata(); ?>

							</div>

							<?php if ( ! empty( $index_page_url ) && $atts['enableNewsCTA'] ) { ?>
								<div class="block-cta">
									<a href="<?php echo $index_page_url; ?>" class="btn btn--outline">See More News</a>
								</div>
							<?php } ?>

						</div>
					</div>
				</div>

			<?php
			$output = ob_get_clean();

			return $output;
		}


	}
	Crown_Block_Latest_News_Article::init();
}
