<?php

if ( ! class_exists( 'Crown_Theme_Walker_Nav_Menu_Header' ) && class_exists( 'Walker_Nav_Menu' ) ) {
	class Crown_Theme_Walker_Nav_Menu_Header extends Walker_Nav_Menu {

        public static int $products_menu_tree_transient_expiration_in_sec = HOUR_IN_SECONDS;

		public function __construct() {
			if ( ! has_filter( 'nav_menu_link_attributes', array( __CLASS__, 'filter_nav_menu_link_attributes' ) ) ) {
				add_filter( 'nav_menu_link_attributes', array( __CLASS__, 'filter_nav_menu_link_attributes' ), 10, 4 );
			}
            if ( defined( 'PRODUCTS_MENU_TREE_TRANSIENT_EXPIRATION_IN_SEC' ) ) {
                self::$products_menu_tree_transient_expiration_in_sec = PRODUCTS_MENU_TREE_TRANSIENT_EXPIRATION_IN_SEC;
            }
		}

		public static function filter_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
			if ( property_exists( $args, 'walker' ) && is_a( $args->walker, 'Crown_Theme_Walker_Nav_Menu_Header' ) ) {
				if ( ! empty( $item->description ) ) {
					$atts['data-description'] = esc_attr( $item->description );
				}
			}
			return $atts;
		}

		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
			if ( ! $element ) {
				return;
			}
	
			$id_field = $this->db_fields['id'];
			$id       = $element->$id_field;
	
			$this->has_children = ! empty( $children_elements[ $id ] );
			if ( isset( $args[0] ) && is_array( $args[0] ) ) {
				$args[0]['has_children'] = $this->has_children;
			}

			$is_mega_menu = $depth == 0 && $element->post_title === 'Products';

			$this->start_el( $output, $element, $depth, ...array_values( $args ) );

			if ( 0 == $max_depth || $max_depth > $depth + 1 ) {
				$submenu = array();
				if ( $is_mega_menu ) {
                    $products_menu_tree_transient_name = 'products_menu_tree';
                    $cached_submenu = get_transient($products_menu_tree_transient_name);
                    if ( $cached_submenu === false ) {
					    $submenu = $this->get_product_categories_submenu($max_depth, $depth);
                    } else {
                        $submenu = $cached_submenu;
                    }
				}
				if ( ! isset( $newlevel ) ) {
					$newlevel = true;
					$output .= '<div class="sub-menu-container ' . ( $is_mega_menu ? 'mega-sub-menu-container' : '' ) . '"><div class="inner">';
					if ( $depth == 0 ) {
						$output .= '<div class="sub-menu-contents">';
					}
					if ( $depth != 0 || ! $is_mega_menu ) $this->start_lvl( $output, $depth, ...array_values( $args ) );
				}

				if ( $this->has_children ) {
					foreach ( $children_elements[ $id ] as $child ) {
						if ( $is_mega_menu ) {
							$enabled = get_post_meta($child->ID, '_menu_item_enabled', true);
							if ($enabled != 0) {
								$extended = get_post_meta($child->ID, '_menu_item_render_children', true);
								if (!isset($submenu[$child->title])) {
									$submenu[$child->title] = array(
										'children' => (property_exists($child, 'object') && $child->object == 'product_cat' && $extended) ? $this->get_product_categories_submenu( $max_depth, $depth + 1, $child->object_id ): [],
										'url'     => $child->url,
									);
								}
								$submenu_children = $this->get_configured_product_menu_items($max_depth, $depth, $child, $children_elements, $submenu[$child->title]['children']);
								if ( $extended) {
									$submenu_children = array_merge($submenu[$child->title]['children'], $submenu_children);
								}
								$submenu[$child->title] = array (
									'children' => $submenu_children,
									'url'     => $child->url,
								);
							} else {
								if (isset($submenu[$child->title])) {
									unset($submenu[$child->title]);
								}
							}
						} else {
							$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
						}
					}
					$output .= ct_nav_mega_menu_render( $submenu );
					unset( $children_elements[ $id ] );
				} elseif ( !empty ( $submenu ) ) {
					$output .= ct_nav_mega_menu_render( $submenu );
				}
                if ( $is_mega_menu && $submenu !== $cached_submenu) {
                    set_transient($products_menu_tree_transient_name, $submenu, self::$products_menu_tree_transient_expiration_in_sec);
                }
			}
	
			if ( isset( $newlevel ) && $newlevel ) {
				if ( $depth != 0 || ! $is_mega_menu ) $this->end_lvl( $output, $depth, ...array_values( $args ) );
				if ( $depth == 0 ) {
					$output .= '</div>';
					$cta = (object) array(
						'text' => '',
						'link_url' => get_post_meta( $id, 'cta_link_url', true ),
						'link_label' => get_post_meta( $id, 'cta_link_label', true )
					);
					if ( ! empty( $cta->text ) || ! empty( $cta->link_url ) ) {
						$output .= '<div class="sub-menu-cta"><div class="inner">';
						if ( ! empty( $cta->text ) ) {
							$output .= '<p class="text">' . $cta->text . '</p>';
						}
						if ( ! empty( $cta->link_url ) ) {
							$output .= '<a class="btn btn--link link-arrow" href="' . $cta->link_url . '"><span class="btn-label">' . ( ! empty( $cta->link_label ) ? $cta->link_label : 'Learn More' ) . '</span><span class="btn__arrow"></span></a>';
						}
						$output .= '</div></div>';
					}
				}
				$output .= '</div></div>';
			}
	
			$this->end_el( $output, $element, $depth, ...array_values( $args ) );
		}

		protected function get_configured_product_menu_items( $max_depth, $depth, $menu_item, $children_elements, $parent_menu ) {
			$submenu = array();
			foreach ( $children_elements[ $menu_item->ID ] as $child ) {
				$enabled = get_post_meta($child->ID, '_menu_item_enabled', true);
				if ($enabled != 0) {
					$extended = get_post_meta($child->ID, '_menu_item_render_children', true);
					if (!isset($parent_menu[$child->title])) {
						$parent_menu[$child->title] = array(
							'children' => (property_exists($child, 'object') && $child->object == 'product_cat' && $extended) ? $this->get_product_categories_submenu( $max_depth, $depth + 1, $child->object_id ): [],
							'url'     => $child->url,
						);
					}

					$children_menu_items = $depth <= $max_depth ? $this->get_configured_product_menu_items( $max_depth, $depth + 1, $child, $children_elements, $parent_menu[$child->title]['children'] ) : [] ;
					if ( $extended) {
						$children_menu_items = array_merge($parent_menu[$child->title]['children'], $children_menu_items);
					}

					$submenu[$child->title] = array (
						'children' => $children_menu_items,
						'url'     => $child->url,
					);
				}
			}
			return $submenu;
		}

		protected function get_product_categories_submenu( $max_depth, $depth, $parent = 0 ) {
			$submenu = array();
			if ( $depth <= $max_depth ) {
				$product_categories = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => $parent ) );
				if (!empty($product_categories) && !is_wp_error($product_categories)) {
					foreach ($product_categories as $category) {
						$submenu[$category->name] = array (
							'children' => $this->get_product_categories_submenu( $max_depth, $depth +1, $category->term_id ),
							'url'     => get_term_link($category),
                            'id' => $category->term_id,
						);
					}
				}
			}
			return $submenu;
		}

	}
}