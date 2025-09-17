<?php

if(!class_exists('Crown_Block_Post_Index')) {
	class Crown_Block_Post_Index extends Crown_Block {

		public static $name = 'post-index';

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
			wp_localize_script( 'crown-blocks-' . self::$name . '-script', 'crownBlockPostIndexData', $data );
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' )
			);
		}

		public static function render( $atts, $content ) {

			$filters_args = array(
				array(
					'name' => 'p_category',
					'type' => 'taxonomy-term-select',
					'taxonomy' => 'category',
					'all_label' => 'Filter by Category',
					'parent' => 0
				),
				array(
					'name' => 'p_keywords',
					'type' => 'search',
					'placeholder' => 'Keyword Search'
				)
			);
			
			$filters = self::get_post_feed_block_filters( $filters_args );

			$query_args = array(
				'post_type' => array( 'post' ),
				'posts_per_page' => 9,
			);
			$query = self::get_post_feed_block_filtered_query( $query_args, $filters );

			$block_args = array(
				'layout' => 'default',
				'pagination' => true
			);

			ob_start();
			self::render_post_feed_block( $query, $filters, $atts, $block_args );
			return ob_get_clean();
		}


		protected static function render_post_feed_filters( $filters ) {
			if ( empty( $filters->groups ) ) return;
			?>
				<form class="post-feed-filters" action="<?php echo esc_attr( $filters->action ); ?>" method="get">
					<div class="inner">

						<header class="filters-header">
							<h3 class="filters-title"><?php _e( 'Filters', 'crown_blocks' ); ?></h3>
						</header>

						<?php foreach ( $filters->groups as $filter ) { ?>
							<?php if ( preg_match( '/^(.+)-checkboxes$/', $filter->type ) && empty( $filter->options ) ) continue; ?>
							<?php if ( preg_match( '/^(.+)-select$/', $filter->type ) && count( $filter->options ) <= 1 ) continue; ?>
							<?php
								$filter_classes = array(
									'filter',
									'name-' . $filter->name,
									'type-' . $filter->type,
								);
								if ( $filter->expandable ) {
									$filter_classes[] = 'expandable';
									if ( ! empty( $filter->queried ) ) $filter_classes[] = 'expanded';
								}
							?>
							<?php $default_value = $filter->default_value !== null ? ( is_array( $filter->default_value ) ? array_map( 'strval', $filter->default_value ) : strval( $filter->default_value ) ) : null; ?>
							<div class="<?php echo implode( ' ', $filter_classes ) ?>" data-default-value="<?php echo esc_attr( json_encode( $default_value ) ); ?>">
								<div class="inner">

									<?php if ( ! empty( $filter->title ) ) { ?>
										<h4 class="filter-title"><?php echo $filter->title; ?></h4>
									<?php } ?>

									<div class="filter-fields">
										<div class="inner">

											<?php if ( preg_match( '/^(?:(.+)-)?search$/', $filter->type, $matches ) ) { ?>
												<input type="text" name="<?php echo esc_attr( $filter->name ); ?>" value="<?php echo esc_attr( $filter->queried ); ?>" <?php echo $filter->placeholder !== null ? 'placeholder="' . esc_attr( $filter->placeholder ) . '"' : ''; ?>>
											<?php } ?>

											<?php if ( preg_match( '/^(.+)-checkboxes$/', $filter->type, $matches ) ) { ?>
												<ul class="options">
													<?php foreach ( $filter->options as $option ) { ?>
														<li class="option">
															<label>
																<input type="checkbox" name="<?php echo esc_attr( $filter->name ); ?>[]" value="<?php echo esc_attr( $option->value ); ?>" <?php echo $option->selected ? 'checked' : ''; ?>>
																<span class="label"><?php echo $option->label; ?></span>
															</label>
														</li>
													<?php } ?>
												</ul>
											<?php } ?>

											<?php if ( preg_match( '/^(.+)-radios$/', $filter->type, $matches ) ) { ?>
												<ul class="options">
													<?php foreach ( $filter->options as $option ) { ?>
														<li class="option">
															<label>
																<input type="radio" name="<?php echo esc_attr( $filter->name ); ?>" value="<?php echo esc_attr( $option->value ); ?>" <?php echo $option->selected ? 'checked' : ''; ?>>
																<span class="label"><?php echo $option->label; ?></span>
															</label>
														</li>
													<?php } ?>
												</ul>
											<?php } ?>

											<?php if ( preg_match( '/^(.+)-select$/', $filter->type, $matches ) ) { ?>
												<select name="<?php echo esc_attr( $filter->name ); ?>">
													<?php foreach ( $filter->options as $option ) { ?>
														<option value="<?php echo esc_attr( $option->value ); ?>" <?php echo $option->selected ? 'selected' : ''; ?>><?php echo $option->label; ?></option>
													<?php } ?>
												</select>
											<?php } ?>

										</div>
									</div>

								</div>
							</div>
						<?php } ?>
						
						<footer class="filters-footer">
							<button type="submit" class="btn btn-primary"><?php _e( 'Search', 'crown_blocks' ); ?></button>
							<a class="reset btn btn--default btn--pure-white btn--md" href="<?php echo esc_attr( $filters->action ); ?>"><?php _e( 'Reset', 'crown_blocks' ); ?></a>
						</footer>

					</div>
				</form>
			<?php
		}


		public static function render_post_feed_article() {
			get_template_part( 'template-parts/index-entry-content', get_post_type() );
		}


	}
	Crown_Block_Post_Index::init();
}
