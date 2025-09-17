<?php

if(!class_exists('Crown_Block_Product_Index')) {
	class Crown_Block_Product_Index extends Crown_Block {

		public static $name = 'product-index';

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
			$platform_type_term = get_term_by( 'slug', 'platform', 'product_type' );
			$data = array(
				'baseUrl' => get_home_url(),
				'blockClassName' => 'wp-block-crown-blocks-' . self::$name,
				'platformTypeTermId' => $platform_type_term ? $platform_type_term->term_id : null
			);
			wp_localize_script( 'crown-blocks-' . self::$name . '-script', 'crownBlockProductIndexData', $data );
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' ),
			);
		}

		public static function render( $atts, $content ) {

			$product_type_term = get_term_by( 'slug', 'product', 'product_type' );

			$query_input = $_GET;

			if ( isset( $query_input['product_type'] ) ) {
				$term = null;
				if ( $query_input['product_type'] == 'certified_product' ) {
					$term = get_term_by( 'slug', 'product', 'product_type' );
				} else if ( $query_input['product_type'] == 'compliant_platform' ) {
					$term = get_term_by( 'slug', 'platform', 'product_type' );
				}
				if ( $term ) $query_input['p_type'] = $term->term_id;
			}

			if ( isset( $query_input['certified_type'] ) ) {
				$term = get_term_by( 'slug', $query_input['certified_type'], 'product_device_type' );
				if ( $term ) $query_input['p_device_type'] = $term->term_id;
			}

			if ( isset( $query_input['se'] ) ) {
				$query_input['p_keywords'] = $query_input['se'];
			}

			$filters = self::get_post_feed_block_filters( array(
				array(
					'name' => 'p_keywords',
					'type' => 'search',
					'expandable' => false,
					'placeholder' => 'Search'
				),
				array(
					'name' => 'p_type',
					'title' => 'Product / Platform',
					'type' => 'taxonomy-term-radios',
					'default_value' => $product_type_term ? $product_type_term->term_id : null,
					'taxonomy' => 'product_type',
					'sort' => 'menu_order'
				),
				array(
					'name' => 'p_device_type',
					'title' => 'Device Type',
					'type' => 'taxonomy-term-checkboxes',
					'taxonomy' => 'product_device_type'
				),
				array(
					'name' => 'p_program_type',
					'title' => 'Program Type',
					'type' => 'taxonomy-term-checkboxes',
					'taxonomy' => 'product_category'
				),
				array(
					'name' => 'p_certificate',
					'title' => 'Certification ID #',
					'type' => 'meta-search',
					'meta_key' => 'product_certificate_id',
					'placeholder' => 'Enter ID #'
				),
				array(
					'name' => 'p_company',
					'title' => 'Company',
					'type' => 'taxonomy-term-checkboxes',
					'taxonomy' => 'product_company'
				)
			), $query_input );

			$filters->action = remove_query_arg( array( 'product_type', 'certified_type', 'se' ), $filters->action );

			$query = self::get_post_feed_block_filtered_query( array(
				'post_type' => array( 'product' ),
				'posts_per_page' => 12,
				'orderby' => 'meta_value',
				'meta_key' => '_knack_certified_date_timestamp',
				'order' => 'DESC'
			), $filters );

			ob_start();
			self::render_post_feed_block( $query, $filters, $atts, array( 'layout' => 'sidebar', 'pagination' => 'infinite' ) );
			return ob_get_clean();
		}


		public static function render_post_feed_article() {
			?>
				<article <?php post_class(); ?>>
					<a href="<?php the_permalink(); ?>">
						<div class="inner">

							<div class="contents">

								<div class="entry-image">
									<div class="inner">
										<?php echo class_exists( 'Crown_Products' ) ? Crown_Products::get_product_image( get_the_ID(), 'sm' ) : ''; ?>
									</div>
								</div>

								<?php $companies = get_the_terms( get_the_ID(), 'product_company' ); ?>
								<?php $company_names = ! empty( $companies ) ? array_map( function( $n ) { return $n->name; }, $companies ) : array(); ?>
								<?php if ( ! empty( $company_names ) ) { ?>
									<p class="entry-company"><?php echo implode( ', ', $company_names ); ?></p>
								<?php } ?>

								<h3 class="entry-title"><?php the_title(); ?></h3>

								<?php $categories = get_the_terms( get_the_ID(), 'product_category' ); ?>
								<?php $category_names = ! empty( $categories ) ? array_map( function( $n ) { return $n->name; }, $categories ) : array(); ?>
								<?php if ( ! empty( $category_names ) ) { ?>
									<p class="entry-category"><?php echo implode( ', ', $category_names ); ?></p>
								<?php } ?>

								<div class="entry-excerpt"><p><?php echo wp_trim_words( get_the_excerpt(), 14, '&hellip;' ); ?></p></div>

							</div>
							
							<p class="cta"><span class="btn btn--link link-arrow btn--link-blue"><span class="btn-label">Learn More</span><span class="btn__arrow"></span></span></p>

						</div>
					</a>
				</article>
			<?php
		}


	}
	// Crown_Block_Product_Index::init();
}
