<?php

if(!class_exists('Crown_Block_Developer_Resource_Index')) {
	class Crown_Block_Developer_Resource_Index extends Crown_Block {

		public static $name = 'developer-resource-index';

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
			wp_localize_script( 'crown-blocks-' . self::$name . '-script', 'crownBlockDeveloperResourceIndexData', $data );
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' ),
			);
		}

		public static function render( $atts, $content ) {

			$filters = self::get_post_feed_block_filters( array(
				array(
					'name' => 'dr_keywords',
					'type' => 'search',
					'expandable' => false,
					'placeholder' => 'Search'
				),
				array(
					'name' => 'dr_solution',
					'title' => 'Solutions',
					'type' => 'taxonomy-term-checkboxes',
					'taxonomy' => 'developer_resource_solution'
				),
				array(
					'name' => 'dr_market',
					'title' => 'Market Use',
					'type' => 'taxonomy-term-checkboxes',
					'taxonomy' => 'developer_resource_market_use'
				),
				array(
					'name' => 'dr_format',
					'title' => 'File Format',
					'type' => 'taxonomy-term-checkboxes',
					'taxonomy' => 'developer_resource_file_format'
				)
			) );

			$query = self::get_post_feed_block_filtered_query( array(
				'post_type' => array( 'developer_resource' ),
				'posts_per_page' => 9,
				'orderby' => 'menu_order',
				'order' => 'ASC'
			), $filters );

			ob_start();
			self::render_post_feed_block( $query, $filters, $atts, array( 'layout' => 'sidebar', 'pagination' => 'infinite' ) );
			return ob_get_clean();
		}


		public static function render_post_feed_article() {
			$type = class_exists( 'Crown_Developer_Resources' ) ? Crown_Developer_Resources::get_developer_resource_file_format_type( get_the_ID() ) : '';
			?>
				<article <?php post_class( ! empty( $type ) ? 'file-format-type-' . $type : '' ); ?>>
					<div class="inner">

						<div class="contents">

							<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

							<?php $market_uses = get_the_terms( get_the_ID(), 'developer_resource_market_use' ); ?>
							<?php $market_use_names = ! empty( $market_uses ) ? array_map( function( $n ) { return $n->name; }, $market_uses ) : array(); ?>
							<?php if ( ! empty( $market_use_names ) ) { ?>
								<p class="entry-market-uses">Market Use: <?php echo implode( ', ', $market_use_names ); ?></p>
							<?php } ?>

						</div>
						
						<?php $link = get_post_meta( get_the_ID(), 'developer_resource_link_override_url', true ); ?>
						<?php $link = ! empty( $link ) ? $link : wp_get_attachment_url( get_post_meta( get_the_ID(), 'developer_resource_file', true ) ); ?>
						<p class="cta">
							<?php if ( ! empty( $link ) ) { ?>
								<a href="<?php the_permalink(); ?>">Learn More</a> | 
								<a href="<?php echo $link; ?>" target="_blank" class="download">Download</a>
							<?php } else { ?>
								<a href="<?php the_permalink(); ?>" class="btn btn--link link-arrow btn--link-blue"><span class="btn-label">Learn More</span><span class="btn__arrow"></span></a>
							<?php } ?>
							<a href="<?php the_permalink(); ?>" class="icon-link">Learn More</a>
						</p>

					</div>
				</article>
			<?php
		}


	}
	// Crown_Block_Developer_Resource_Index::init();
}
