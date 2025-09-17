<?php

if ( ! class_exists( 'Crown_Theme_Walker_Nav_Menu_Mobile_Menu' ) && class_exists( 'Walker_Nav_Menu' ) ) {
	class Crown_Theme_Walker_Nav_Menu_Mobile_Menu extends Crown_Theme_Walker_Nav_Menu_Header {

        public static int $products_menu_tree_transient_expiration_in_sec = HOUR_IN_SECONDS;

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
					if ( $depth != 0 || ! $is_mega_menu ) $this->start_lvl( $output, $depth, ...array_values( $args ) );
				}
				if ( $this->has_children ) {
					foreach ( $children_elements[ $id ] as $child ) {
						if ( $is_mega_menu ) {
							$enabled = get_post_meta($child->ID, '_menu_item_enabled', true);
							if ($enabled != 0) {
								$extended = get_post_meta($child->ID, '_menu_item_render_children', true);
								if ( !isset( $submenu[$child->title] ) ) {
									$submenu[$child->title] = array(
										'children' => (property_exists($child, 'object') && $child->object == 'product_cat' && $extended) ? $this->get_product_categories_submenu( $max_depth, $depth + 1, $child->object_id ): [],
										'url'     => $child->url,
									);
								}
								$submenu_children = $this->get_configured_product_menu_items($max_depth, $depth, $child, $children_elements, $submenu[$child->title]['children']);
								if ( $extended ) {
									$submenu_children = array_merge( $submenu[$child->title]['children'], $submenu_children );
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
					$output .= ct_nav_mega_menu_render( $submenu, array( 'context' => 'mobile-menu' ) );
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
			}
	
			$this->end_el( $output, $element, $depth, ...array_values( $args ) );
		}


	}
}