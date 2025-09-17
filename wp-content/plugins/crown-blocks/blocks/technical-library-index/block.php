<?php

if(!class_exists('Crown_Block_Technical_Library_Index')) {
	class Crown_Block_Technical_Library_Index extends Crown_Block {

		public static $name = 'technical-library-index';

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
			wp_localize_script( 'crown-blocks-' . self::$name . '-script', 'crownBlockTechnicalLibraryIndexData', $data );
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
					'name' => 'p_sku',
					'type' => 'meta-search',
					'meta_key' => '_sku',
					'expandable' => false,
					'placeholder' => 'Search by Part #'
				),
				array(
					'name' => 'p_category',
					'type' => 'taxonomy-term-select',
					'taxonomy' => 'product_cat',
					'all_label' => 'Filter by Category',
					'parent' => 0
				),
				array(
					'name' => 'p_brand',
					'type' => 'taxonomy-term-select',
					'taxonomy' => 'product_brand',
					'all_label' => 'Filter by Brand',
					'parent' => 0
				)
			);
			
			$root_cat_term = null;
			if ( isset( $_GET['p_category'] ) ) {
				$root_cat_term = get_term( $_GET['p_category'], 'product_cat' );
				if ( $root_cat_term && ! is_wp_error( $root_cat_term ) ) {
					while ( $root_cat_term->parent != 0 ) {
						$root_cat_term = get_term( $root_cat_term->parent, 'product_cat' );
					}
				} else {
					$root_cat_term = null;
				}
			}
			$attr_taxonomies = Crown_Shop_Display::get_attribute_filter_taxonomies_to_display( $root_cat_term );
			$attribute_ids = wc_get_attribute_taxonomy_ids();
			foreach ( $attr_taxonomies as $taxonomy_name ) {
				if ( preg_match( '/^pa_(.+)/', $taxonomy_name, $matches ) ) {
					$attribute_id = array_key_exists( $matches[1], $attribute_ids ) ? $attribute_ids[ $matches[1] ] : null;
					$attribute = wc_get_attribute( $attribute_id );
					if ( ! $attribute ) continue;
					$config = array(
						'name' => 'p_' . $taxonomy_name,
						'title' => ucwords( preg_replace( '/\s*_\s*/', ' ', $attribute->name ) ),
						'taxonomy' => $taxonomy_name,
						'type' => 'taxonomy-term-checkboxes'
					);
					if ( isset( $_GET['p_category'] ) ) {
						$cat_term = get_term( $_GET['p_category'], 'product_cat' );
						if ( $cat_term && ! is_wp_error( $cat_term ) ) {
							$term_ids = Crown_Shop_Display::get_posts_of_term_term_ids( $cat_term->term_id, 'product_cat', $taxonomy_name );
							$config['include_terms'] = $term_ids ? $term_ids : array();
						}
					}
					$filters_args[] = $config;
				}
			}

			$filters = self::get_post_feed_block_filters( $filters_args );

			$queried = false;
			foreach ( $filters->groups as $filter ) {
				if ( in_array( $filter->name, array( 'p_sku', 'p_category', 'p_brand' ) ) && ! empty( $filter->queried ) ) {
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
			$filtered_filter_groups = array();
			foreach ( $filters->groups as $filter_group ) {
				// print_r($filter_group);
				if ( ! in_array( $filter_group->name, array( 'p_sku', 'p_category', 'p_brand' ) ) ) {
					$filtered_filter_groups[] = $filter_group;
				}
			}
			$filters->groups = $filtered_filter_groups;
			if ( empty( $filtered_filter_groups ) ) {
				$atts['hideFilter'] = true;
			}
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
	Crown_Block_Technical_Library_Index::init();
}
