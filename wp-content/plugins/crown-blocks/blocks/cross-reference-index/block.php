<?php

if(!class_exists('Crown_Block_Cross_Reference_Index')) {
	class Crown_Block_Cross_Reference_Index extends Crown_Block {

		public static $name = 'cross-reference-index';

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
			wp_localize_script( 'crown-blocks-' . self::$name . '-script', 'crownBlockCrossReferenceIndexData', $data );
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' )
			);
		}

		public static function render( $atts, $content ) {
			if ( ! class_exists( 'Crown_Shop_Display' ) ) return '';

			$filters_args = array(
				array(
					'name' => 'part_no',
					'type' => 'meta-search',
					'meta_key' => 'product_competitor_data',
					'expandable' => false,
					'placeholder' => 'Search'
				)
			);
			
			$filters = self::get_post_feed_block_filters( $filters_args );

			$queried = false;
			foreach ( $filters->groups as $filter ) {
				if ( in_array( $filter->name, array( 'part_no' ) ) && ! empty( $filter->queried ) ) {
					$queried = true;
					break;
				}
			}

			$query_args = array(
				'post_type' => array( 'product' ),
				'posts_per_page' => 9,
				'orderby' => 'meta_value',
				'meta_key' => '_sku',
				'order' => 'ASC',
				'tax_query' => array()
			);
			if ( ! $queried ) {
				return;
				$query_args['post__in'] = array( 0 );
			}
			$query = self::get_post_feed_block_filtered_query( $query_args, $filters );

			$block_args = array(
				'layout' => 'sidebar',
				'pagination' => true
			);

			ob_start();
			self::render_post_feed_block( $query, $filters, $atts, $block_args );
			return ob_get_clean();
		}


		protected static function render_post_feed_block( $query, $filters, $atts, $args = array() ) {
			$filters->groups = array();
			$atts['hideFilter'] = true;
			parent::render_post_feed_block( $query, $filters, $atts, $args );
		}


		protected static function render_post_feed( $query ) {
			?>
				<div class="post-feed item-count-<?php echo $query->post_count; ?>" data-item-count="<?php echo $query->post_count; ?>">
					<div class="inner product-teasers">
						<?php while ( $query->have_posts() ) { ?>
							<?php $query->the_post(); ?>
							<?php static::render_post_feed_article(); ?>
						<?php } ?>
						<?php wp_reset_postdata(); ?>
						<?php if ( ! $query->have_posts() ) { ?>
							<div class="alert-wrapper post-feed-item">
								<?php static::render_post_feed_no_results_alert(); ?>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php
		}


		public static function render_post_feed_article() {
			if ( ! class_exists( 'Crown_Shop_Display' ) ) return '';
			Crown_Shop_Display::product_teaser();
			?>
				<div id="product-<?php the_ID(); ?>-docs-modal" class="modal fade product-docs" tabindex="-1">
					<div class="modal-dialog modal-xl modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="inner">
									<div class="product-teaser">
										<a href="<?php the_permalink() ?>">
											<?php echo woocommerce_get_product_thumbnail(); ?>
										</a>
										<a href="<?php the_permalink() ?>" class="btn btn--outline btn--outline-white">View Product</a>
									</div>
									<div class="product-docs">
										<?php $docs = get_post_meta( get_the_ID(), 'product_doc_data', true ); ?>
										<?php if ( ! empty( $docs ) ) { ?>
											<ul>
												<?php foreach ( $docs as $doc ) { ?>
													<li>
														<span class="name"><?php echo $doc['filename']; ?></span>
														<span class="download"><a href="<?php echo $doc['src']; ?>" target="_blank" class="btn btn--white">Download</a></span>
													</li>
												<?php } ?>
											</ul>
										<?php } else { ?>
											<div class="alert alert-info">No technical documents found for this product.</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
		}


	}
	Crown_Block_Cross_Reference_Index::init();
}
