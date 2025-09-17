<?php

if(!class_exists('Crown_Block_Catalog_Index')) {
	class Crown_Block_Catalog_Index extends Crown_Block {

		public static $name = 'catalog-index';

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
			wp_localize_script( 'crown-blocks-' . self::$name . '-script', 'crownBlockCatalogIndexData', $data );
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' )
			);
		}

		public static function render( $atts, $content ) {

			$filter_args = array(
				array(
					'name' => 'r_industry',
					'type' => 'taxonomy-term-select',
					'taxonomy' => 'resource_industry',
					'all_label' => 'Filter by Industry'
				),
				array(
					'name' => 'r_service',
					'type' => 'taxonomy-term-select',
					'taxonomy' => 'resource_service',
					'all_label' => 'Filter by Service'
				),
				array(
					'name' => 'r_keywords',
					'type' => 'search',
					'placeholder' => 'Keyword Search'
				)
			);
			$filters = self::get_post_feed_block_filters( $filter_args );

			$query_args = array(
				'post_type' => array( 'catalog' ),
				'posts_per_page' => 9
			);
			$query = self::get_post_feed_block_filtered_query( $query_args, $filters );

			$block_args = array(
				'layout' => 'simple',
				'pagination' => true
			);

			ob_start();
			self::render_post_feed_block( $query, $filters, $atts, $block_args );
			return ob_get_clean();
		}


		public static function render_post_feed_article() {
			?>
				<article <?php post_class(); ?>>
					<a href="<?php the_permalink(); ?>" target="<?php echo apply_filters( 'post_link_target', '_self' ); ?>">
						<div class="inner">

							<div class="featured-image">
								<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'large' ); ?>
							</div>

							<div class="teaser">

								<?php $categories = get_the_terms( get_the_ID(), 'category' ); ?>
								<?php $category_names = ! empty( $categories ) ? array_map( function( $n ) { return $n->name; }, $categories ) : array(); ?>
								<?php if ( ! empty( $category_names ) ) { ?>
									<h6 class="entry-categories"><?php echo implode( ', ', $category_names ); ?></h6>
								<?php } ?>

								<h3 class="entry-title"><?php the_title(); ?></h3>

								<p class="entry-date"><?php the_time( 'n/j/Y' ); ?></p>

								<div class="entry-summar"><?php the_excerpt(); ?></div>

							</div>
							
							<p class="cta"><span class="btn btn--link link-arrow btn--link-black"><span class="btn-label">Read More</span><span class="btn__arrow"></span></span></p>

						</div>
					</a>
				</article>
			<?php
		}


	}
	Crown_Block_Catalog_Index::init();
}
