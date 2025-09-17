<?php

if(!class_exists('Crown_Block_Cross_Reference_Search')) {
	class Crown_Block_Cross_Reference_Search extends Crown_Block {

		public static $name = 'cross-reference-search';

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
					'placeholder' => 'Search',
					'title' => 'Enter a manufacturer\'s part number and the corresponding NSI product(s) will be listed below:',
					'custom' => 'isp_ignore',
				)
			);
			
			$filters = self::get_post_feed_block_filters( $filters_args );

			$query_args = array(
				'post_type' => array( 'product' ),
				'posts_per_page' => 9,
				'orderby' => 'meta_value',
				'meta_key' => '_sku',
				'order' => 'ASC',
				'tax_query' => array()
			);
			$query_args['post__in'] = array( 0 );
			$query = self::get_post_feed_block_filtered_query( $query_args, $filters );

			$block_args = array(
				'layout' => '',
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
	Crown_Block_Cross_Reference_Search::init();
}
