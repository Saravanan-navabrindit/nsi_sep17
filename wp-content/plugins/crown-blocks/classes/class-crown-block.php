<?php

if ( ! class_exists( 'Crown_Block' ) ) {
	class Crown_Block {


		private static $namespace = 'crown-blocks';
		protected static $name = 'block-name'; // overridden by extended class
		protected static $block_path; // block base directory
		protected static $block_url; // block base url
		
		public static function get_namespace() { return self::$namespace; }
		public static function get_name() { return static::$name; }
		public static function get_block_name() { return self::get_namespace().'/'.self::get_name(); }

		public static function get_block_path() {
			$name = self::get_name();
			return WP_PLUGIN_DIR.'/crown-blocks/blocks/'.$name;
		}
		public static function get_block_url() {
			$name = self::get_name();
			return WP_PLUGIN_URL.'/crown-blocks/blocks/'.$name;
		}


		public static function init() {

			add_action( 'init', array( get_called_class(), 'register' ) );

		}


		public static function register() {

			$blockPath = self::get_block_path();
			
			if ( ! file_exists($blockPath) ) {
				return;
			}
			
			$blockArgs = array();
			
			/**
			 * If block class contains 'get_attributes' method, add attributes to $blockArgs. 
			 * This is called when using server-side rendering in custom render callback functions. 
			 * Yes, you do need to pass in an attribute array in both the PHP side and the JS side. 
			 */
			if ( is_callable( array( get_called_class(), 'get_attributes' ) ) ) {
				$attributes = call_user_func( array( get_called_class(), 'get_attributes' ) );
				if ( is_array( $attributes ) ) {
					$blockArgs['attributes'] = $attributes;
				}
			}

			/**
			 * If block class contains 'render' method, add custom render callback to $blockArgs. 
			 * This custom render callback provides block markup for the front-end of the site, as well as the editor if ServerSideRender is used. 
			 */
			if ( is_callable( array( get_called_class(), 'render' ) ) ) {
				$blockArgs['render_callback'] = array( get_called_class(), 'render' );
			}

			/**
			 * Register the block. 
			 * We pass in the block base directory and auto-load '${blockPath}/block.json', which contains most block registration settings. 
			 * The block is also registered in '${blockPath}/src/index.js', which controls the markup if not using server-side rendering. 
			 */
			register_block_type( $blockPath, $blockArgs );

		}


		protected static function get_post_feed_block_filters( $filters_config, $query_input = null ) {

			if ( $query_input === null ) $query_input = $_GET;

			$filter_groups = array_map( function( $config ) use ( $query_input ) {

				$config = array_merge( array(
					'name' => '',
					'title' => '',
					'type' => '',
					'default_value' => null,
					'placeholder' => null,
					'expandable' => true,
					'sort' => null,
					'taxonomy' => null,
					'parent' => null,
					'include_terms' => array(),
					'meta_key' => null,
					'all_label' => 'All',
					'custom' => null
				), $config );

				$filter = (object) array(
					'name' => $config['name'],
					'title' => $config['title'],
					'type' => $config['type'],
					'default_value' => $config['default_value'],
					'placeholder' => $config['placeholder'],
					'expandable' => $config['expandable'],
					'queried' => null,
					'taxonomy' => $config['taxonomy'],
					'meta_key' => $config['meta_key'],
					'options' => array(),
					'custom' => $config['custom'],
				);

				// set queried value
				if ( in_array( $filter->type, array( 'taxonomy-term-checkboxes' ) ) ) {
					$filter->queried = isset( $query_input[ $filter->name ] ) ? ( is_array( $query_input[ $filter->name ] ) ? $query_input[ $filter->name ] : array_filter( array_map( 'trim', explode( ',', $query_input[ $filter->name ] ) ), function( $n ) { return ! empty( $n ); } ) ) : array();
					if ( ! isset( $query_input[ $filter->name ] ) && $config['default_value'] !== null ) {
						$filter->queried = is_array( $config['default_value'] ) ? $config['default_value'] : array( $config['default_value'] );
					}
				} else {
					$filter->queried = isset( $query_input[ $filter->name ] ) ? $query_input[ $filter->name ] : null;
					if ( ! isset( $query_input[ $filter->name ] ) && $config['default_value'] !== null ) {
						$filter->queried = $config['default_value'];
					}
				}

				// set options
				if ( preg_match( '/^taxonomy-term-(.+)$/', $filter->type, $matches ) ) {
					$term_args = array( 'taxonomy' => $filter->taxonomy );
					if ( $config['parent'] !== null ) {
						$term_args['parent'] = $config['parent'];
					} else if ( in_array( $filter->type, array( 'taxonomy-term-radios' ) ) ) {
						$term_args['parent'] = 0;
					}
					if ( ! empty( $config['sort'] ) ) {
						if ( preg_match( '/^(.+)_(ASC|DESC)$/', $config['sort'], $matches2 ) ) {
							$term_args['orderby'] = $matches2[1];
							$term_args['order'] = $matches2[2];
						} else {
							$term_args['orderby'] = $config['sort'];
						}
					}
					if ( ! empty( $config['include_terms'] ) ) {
						$term_args['include'] = $config['include_terms'];
					}
					$terms = get_terms( $term_args );
					if ( in_array( $filter->type, array( 'taxonomy-term-checkboxes' ) ) ) {
						$filter->options = array_map( function( $n ) use ( $filter ) {
							return (object) array( 'value' => $n->term_id, 'label' => $n->name, 'selected' => in_array( $n->term_id, $filter->queried ) );
						}, $terms );
						if ( ! isset( $query_input[ $filter->name ] ) && $config['default_value'] !== null ) {
							$default_value = is_array( $config['default_value'] ) ? $config['default_value'] : array( $config['default_value'] );
							$filter->options = array_map( function ( $n ) use ( $default_value ) {
								$n->selected = in_array( $n->value, $default_value );
								return $n;
							}, $filter->options );
						}
					}
					if ( in_array( $filter->type, array( 'taxonomy-term-radios', 'taxonomy-term-select' ) ) ) {
						$filter->options = array_map( function( $n ) use ( $filter ) {
							return (object) array( 'value' => $n->term_id, 'label' => $n->name, 'selected' => $n->term_id == $filter->queried );
						}, $terms );
					}
				}
				if ( in_array( $filter->type, array( 'taxonomy-term-radios' ) ) && $config['default_value'] === null ) {
					$filter->options = array_merge( array( (object) array( 'value' => '', 'label' => $config['all_label'], 'selected' => true ) ), $filter->options );
				}
				if ( in_array( $filter->type, array( 'taxonomy-term-select' ) ) ) {
					$filter->options = array_merge( array( (object) array( 'value' => '', 'label' => $config['all_label'], 'selected' => false ) ), $filter->options );
				}

				return $filter;

			}, $filters_config );

			$filters_action = remove_query_arg( array_map( function( $n ) { return $n->name; }, $filter_groups ) );
			$filters_action = preg_replace( '/\/page\/\d+\/(\?.*)?$/', "/$1", $filters_action );

			return (object) array(
				'action' => $filters_action,
				'groups' => $filter_groups
			);

		}


		protected static function get_post_feed_block_filtered_query( $query_args, $filters ) {

			$query_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

			foreach ( $filters->groups as $filter ) {
				if ( empty( $filter->queried ) ) continue;
				if ( preg_match( '/^taxonomy-term-(.+)/', $filter->type, $matches ) ) {
					if ( ! array_key_exists( 'tax_query', $query_args ) ) $query_args['tax_query'] = array();
					$query_args['tax_query'][] = array( 'taxonomy' => $filter->taxonomy, 'terms' => $filter->queried );
				} else if ( $filter->type == 'meta-search' ) {
					if ( ! array_key_exists( 'meta_query', $query_args ) ) $query_args['meta_query'] = array();
					$query_args['meta_query'][] = array( 'key' => $filter->meta_key, 'compare' => 'LIKE', 'value' => $filter->queried );
				} else if ( $filter->type == 'search' ) {
					$query_args['s'] = $filter->queried;
				}
			}

			$query = null;
			if ( function_exists( 'relevanssi_do_query' ) && isset( $query_args['s'] ) && ! empty( $query_args['s'] ) ) {
				$query = new WP_Query();
				$query->parse_query( $query_args );
				relevanssi_do_query( $query );
			} else {
				$query = new WP_Query( $query_args );
			}

			return $query;
		}


		protected static function render_post_feed_block( $query, $filters, $atts, $args = array() ) {

			$args = array_merge( array(
				'layout' => 'sidebar',
				'title' => '',
				'pagination' => true,
				'link_url' => null,
				'link_label' => 'Learn More'
			), $args );

			$showFilter = true;

			if (! empty($atts['hideFilter']) && $atts['hideFilter']) {
				$showFilter = false;
				// $args['layout'] = 'no-sidebar';
			}

			$block_id = 'post-feed-block-' . md5( json_encode( array( self::get_name(), $atts ) ) );
			$block_class = array( 'wp-block-crown-blocks-' . self::get_name(), 'layout-' . $args['layout'], $atts['className'] );

			?>
				<div id="<?php echo $block_id; ?>" class="<?php echo implode( ' ', $block_class ); ?>">
					<div class="inner">
						<?php if ( ! empty( $args['title'] ) || ! empty( $filters->groups ) || ! empty( $args['link_url'] ) ) { ?>
							<header class="post-feed-header">
								<?php if ( ! empty( $args['title'] ) ) { ?>
									<h2 class="post-feed-title"><?php echo $args['title']; ?></h2>
								<?php } ?>
								<?php if ($showFilter) { ?>
								<?php static::render_post_feed_filters( $filters ); ?>
								<?php } ?>
								<?php if ( ! empty( $args['link_url'] ) ) { ?>
									<a class="post-feed-cta-link" href="<?php echo $args['link_url']; ?>"><?php echo $args['link_label']; ?></a>
								<?php } ?>
							</header>
						<?php } ?>
						<div class="ajax-loader">
							<div class="ajax-content">
								<?php static::render_post_feed( $query ); ?>
								<?php if ( $args['pagination'] === 'infinite' ) { ?>
									<?php static::render_pagination_infinite( $query ); ?>
								<?php } else if ( $args['pagination'] ) { ?>
									<?php static::render_pagination( $query, 5, $block_id ); ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			<?php
		}


		protected static function render_post_feed_filters( $filters ) {
			if ( empty( $filters->groups ) ) return;
			?>
				<form class="post-feed-filters" action="<?php echo esc_attr( $filters->action ); ?>" method="get">
					<div class="inner">

						<header class="filters-header">
							<h3 class="filters-title"><?php _e( 'Filters', 'crown_blocks' ); ?></h3>
							<a class="reset" href="<?php echo esc_attr( $filters->action ); ?>"><?php _e( 'Reset', 'crown_blocks' ); ?></a>
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
												<input type="text" name="<?php echo esc_attr( $filter->name ); ?>" value="<?php echo esc_attr( $filter->queried ); ?>" <?php echo $filter->placeholder !== null ? 'placeholder="' . esc_attr( $filter->placeholder ) . '"' : ''; ?>
												<?php echo $filter->custom !== null ? ' ' . esc_attr( $filter->custom ) : ''; ?>>
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
						</footer>

					</div>
				</form>
			<?php
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


		protected static function render_post_feed_article() {
			?>
				<article <?php post_class(); ?>>
					<div class="inner">
						<h3 class="entry-title"><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></h3>
						<div class="entry-excerpt"><?php the_excerpt(); ?></div>
					</div>
				</article>
			<?php
		}


		protected static function render_post_feed_no_results_alert() {
			?>
				<div class="alert alert-info no-results">
					<h4>No Entries Found</h4>
					<p>Please try adjusting your selected filters.</p>
				</div>
			<?php
		}


		protected static function render_pagination_infinite( $query ) {

			$pagination = self::get_pagination( $query );

			?>
				<div class="pagination-wrapper infinite">
					<?php if ( $pagination && ! empty( $pagination->next ) ) { ?>
						<nav class="navigation pagination infinite">
							<div class="wp-block-crown-blocks-button">
								<a class="btn btn--clear btn-load-more" href="<?php echo esc_attr( $pagination->next ); ?>"><?php _e( 'Load More', 'crown_blocks' ); ?> <span class="plus-icon">+</span></a>
							</div>
						</nav>
					<?php } ?>
				</div>
			<?php
		}


		protected static function render_pagination( $query, $max_page_links = 5, $scroll_anchor = '' ) {

			$pagination = self::get_pagination( $query, $scroll_anchor );
			if ( ! $pagination ) return;

			$index_min = max( 1, $pagination->current_page - ceil( ( $max_page_links - 2 ) / 2 ) );
			$index_max = min( count( $pagination->pages ) - 2, $pagination->current_page - 1 + floor( ( $max_page_links - 2 ) / 2 ) );

			$index_min = $index_min == 1 ? 0 : $index_min;
			$index_max = $index_max == count( $pagination->pages ) - 2 ? count( $pagination->pages ) - 1 : $index_max;

			if ( $index_max - $index_min + 2 < $max_page_links ) {
				if ( $index_min == 0 ) {
					$index_max = $index_max + ( $max_page_links - ( $index_max - $index_min + 2 ) );
					$index_max = $index_max == count( $pagination->pages ) - 2 ? count( $pagination->pages ) - 1 : $index_max;
				} else if ( $index_max == count( $pagination->pages ) - 1 ) {
					$index_min = $index_min - ( $max_page_links - ( $index_max - $index_min + 2 ) );
					$index_min = $index_min == 1 ? 0 : $index_min;
				}
			}

			?>
				<div class="pagination-wrapper">
					<nav class="navigation pagination">
						<h3 class="screen-reader-text">Page Navigation</h3>
						<div class="nav-links">
	
							<?php if ( ! empty( $pagination->prev ) ) { ?>
								<a class="page-numbers prev" href="<?php echo esc_attr( $pagination->prev ); ?>"><span>Previous</span></a>
							<?php } else { ?>
								<span class="page-numbers prev"><span>Previous</span></span>
							<?php } ?>
	
							<?php if ( $index_min > 0 ) { ?>
								<a class="page-numbers <?php echo $pagination->current_page == 1 ? 'current' : ''; ?>" href="<?php echo esc_attr( $pagination->pages[0] ); ?>"><span>1</span></a>
								<span class="page-numbers dots"><span>&hellip;</span></span>
							<?php } ?>
							
							<?php $page_links = array_slice( $pagination->pages, $index_min, $index_max - $index_min + 1 ); ?>
							<?php foreach ( $page_links as $i => $page_link ) { ?>
								<a class="page-numbers <?php echo $pagination->current_page == $i + $index_min + 1 ? 'current' : ''; ?>" href="<?php echo esc_attr( $page_link ); ?>"><span><?php echo $i + $index_min + 1; ?></span></a>
							<?php } ?>
	
							<?php if ( $index_max < count( $pagination->pages ) - 1 ) { ?>
								<span class="page-numbers dots"><span>&hellip;</span></span>
								<a class="page-numbers" href="<?php echo esc_attr( $pagination->pages[ count( $pagination->pages ) - 1 ] ); ?>"><span><?php echo count( $pagination->pages ); ?></span></a>
							<?php } ?>
	
							<?php if ( ! empty( $pagination->next ) ) { ?>
								<a class="page-numbers next" href="<?php echo esc_attr( $pagination->next ); ?>"><span>Next</span></a>
							<?php } else { ?>
								<span class="page-numbers next"><span>Next</span></span>
							<?php } ?>
	
						</div>
					</nav>
				</div>
			<?php
		}


		protected static function get_pagination( $query, $scroll_anchor = '' ) {

			$page = $query->get( 'paged' );
			if ( ! $page ) $page = 1;
			$maxPage = $query->max_num_pages;
			if ( $maxPage < 2 ) return false;

			$pagination = (object) array(
				'current_page' => $page,
				'pages' => array(),
				'next' => null,
				'prev' => null
			);

			for ( $i = 1; $i <= $maxPage; $i++ ) {
				$pagination->pages[] = get_pagenum_link( $i ) . ( ! empty( $scroll_anchor ) ? '#' . $scroll_anchor : '' );
			}

			$nextPage = intval( $page ) + 1;
			if ( ! is_single() && ( $nextPage <= $maxPage ) ) {
				$pagination->next = next_posts( $maxPage, false ) . ( ! empty( $scroll_anchor ) ? '#' . $scroll_anchor : '' );
			}

			if ( ! is_single() && $page > 1 ) {
				$pagination->prev = previous_posts( false ) . ( ! empty( $scroll_anchor ) ? '#' . $scroll_anchor : '' );
			}

			return $pagination;
		}


	}
}
