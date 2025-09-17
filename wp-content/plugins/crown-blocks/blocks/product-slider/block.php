<?php

if(!class_exists('Crown_Block_Product_Slider')) {
	class Crown_Block_Product_Slider extends Crown_Block {

		public static $name = 'product-slider';


		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' ),
				'maxPostCount' => array( 'type' => 'string', 'default' => '12' ),
				'manuallySelectPosts' => array( 'type' => 'boolean', 'default' => false ),
				'excludePrevPosts' => array( 'type' => 'boolean', 'default' => false ),
				'filterCategories' => array( 'type' => 'string', 'default' => '' ),
				'filterBrands' => array( 'type' => 'string', 'default' => '' ),
				'filterPostsExclude' => array( 'type' => 'string', 'default' => '' ),
				'filterPostsInclude' => array( 'type' => 'string', 'default' => '' ),
				'filterPostSkusInclude' => array( 'type' => 'string', 'default' => '' )
			);
		}

		public static function render( $atts, $content ) {

			$query_args = array(
				'post_type' => array( 'product' ),
				'posts_per_page' => intval( $atts['maxPostCount'] )
			);

			if ( $atts['manuallySelectPosts'] ) {

				$skus = array_filter( array_map( 'trim', explode( ',', $atts['filterPostSkusInclude'] ) ), function( $n ) { return ! empty( $n ); } );
				if ( ! empty( $skus ) ) {
					$post_ids = array();
					foreach ( $skus as $sku ) {
						$post_id = self::find_product_by_sku( $sku );
						if ( $post_id ) $post_ids[] = $post_id;
					}
					$query_args['post__in'] = ! empty( $post_ids ) ? $post_ids : array( 0 );
					$query_args['orderby'] = 'post__in';
				}

			} else {

				$query_args['tax_query'] = array();

				$term_names = array_filter( array_map( 'trim', explode( ',', $atts['filterCategories'] ) ), function( $n ) { return ! empty( $n ); } );
				if ( ! empty( $term_names ) ) {
					$term_ids = array();
					foreach ( $term_names as $term_name ) {
						$term = get_term_by( 'name', $term_name, 'product_cat' );
						if ( $term ) $term_ids[] = $term->term_id;
					}
					$query_args['tax_query'][] = array( 'taxonomy' => 'product_cat', 'terms' => ! empty( $term_ids ) ? $term_ids : 0 );
				}

				$term_names = array_filter( array_map( 'trim', explode( ',', $atts['filterBrands'] ) ), function( $n ) { return ! empty( $n ); } );
				if ( ! empty( $term_names ) ) {
					$term_ids = array();
					foreach ( $term_names as $term_name ) {
						$term = get_term_by( 'name', $term_name, 'product_brand' );
						if ( $term ) $term_ids[] = $term->term_id;
					}
					$query_args['tax_query'][] = array( 'taxonomy' => 'product_brand', 'terms' => ! empty( $term_ids ) ? $term_ids : 0 );
				}

			}

			$query = new WP_Query( $query_args );
			if ( ! $query->have_posts() ) return '';

			$block_class = array( 'wp-block-crown-blocks-product-slider' );

			ob_start();
			?>

				<div class="<?php echo implode( ' ', $block_class ); ?>">
					<div class="inner">
						<div class="post-feed item-count-<?php echo $query->post_count; ?>" data-item-count="<?php echo $query->post_count; ?>">
							<div class="inner product-teasers">
								<?php while ( $query->have_posts() ) { ?>
									<?php $query->the_post(); ?>
									<?php Crown_Shop_Display::product_teaser(); ?>
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


		protected static function find_product_by_sku( $sku ) {
			global $wpdb;
			$result = $wpdb->get_var( $wpdb->prepare( "SELECT p.ID AS id
				FROM $wpdb->posts p
				LEFT JOIN $wpdb->wc_product_meta_lookup pm1 ON (pm1.product_id = p.ID)
				WHERE p.post_type = 'product'
				AND pm1.sku = %s
			", $sku ) );
			return ! empty( $result ) ? intval( $result ) : null;
		}


	}
	Crown_Block_Product_Slider::init();
}
