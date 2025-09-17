<?php

if(!class_exists('Crown_Block_Technical_Library_Search')) {
	class Crown_Block_Technical_Library_Search extends Crown_Block {

		public static $name = 'technical-library-search';

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
			wp_localize_script( 'crown-blocks-' . self::$name . '-script', 'crownBlockTechnicalLibrarySearchData', $data );
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
			
			$filters = self::get_post_feed_block_filters( $filters_args );

			$queried = false;
			$query_args = array(
				'post_type' => array( 'product' ),
				'posts_per_page' => 9,
				'orderby' => 'meta_value',
				'meta_key' => '_sku',
				'order' => 'ASC',
				'tax_query' => array()
			);
			if ( ! $queried ) {
				$query_args['post__in'] = array( 0 );
			}
			$query = self::get_post_feed_block_filtered_query( $query_args, $filters );

			$block_args = array(
				'layout' => 'simple',
				'pagination' => false
			);

			ob_start();
			self::render_post_feed_block( $query, $filters, $atts, $block_args );
			return ob_get_clean();
		}


		protected static function render_post_feed( $query ) {
			return;
		}


	}
	Crown_Block_Technical_Library_Search::init();
}
