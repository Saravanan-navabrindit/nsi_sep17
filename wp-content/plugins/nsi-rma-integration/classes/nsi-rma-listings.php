<?php

if ( ! class_exists( 'NSI_RMA_Listings' ) ) {

    class NSI_RMA_Listings
    {
        public static bool $init = false;

        public static function init() {
            if ( self::$init ) {
                return true;
            }

            add_action( 'init', array( __CLASS__, 'add_returns_endpoint' ) );
            add_filter( 'query_vars', array( __CLASS__, 'add_returns_query_vars' ) );
            add_action( 'woocommerce_account_returns_endpoint', array(  __CLASS__, 'returns_endpoint_content' ) );
        }

        public static function add_returns_endpoint() {
            add_rewrite_endpoint('returns', EP_ROOT | EP_PAGES);
        }

        public static function add_returns_query_vars( $vars ) {
            $vars[] = 'returns';
            return $vars;
        }

        public static function is_rma_dashboard() {
            return get_query_var('returns', false) !== false;
        }

        public static function is_single_rma_page() {
            return !empty( get_query_var('returns', false) );
        }

        public static function get_return_pdf_button( $wc_return_id ) {
            $button_html = '<div class="return-document-holder">
                <button type="button"
                        data-wc-return-id="' . $wc_return_id . '"
                        class="button return-document-button" id="DownloadRmaDoc">
                    RMA Document
                </button>
            </div>';

            return $button_html;
        }

        public static function returns_endpoint_content() {
            echo '<div class="rma--archive-holder">';
            if ( !is_user_logged_in() ) {
                echo '<p>' . __( 'You must be logged in to view this page.', 'nsi-rma' ) . '</p></div>';
                return;
            }

            $user_id = get_current_user_id();
            $rma_id = get_query_var( 'returns' );
            $rma_post = get_post( $rma_id );
            $rma_author_id = $rma_post->post_author ?? 0;
            $is_valid_rma = !empty( $rma_id ) && get_post_type( $rma_post ) === 'rma' && $user_id == $rma_author_id;

            if ( !$is_valid_rma ) {
                $filter_rma = $_GET['filter_rma'] ?? null;
                echo '<div class="wc-returns btn-wrapper"><a href="' . esc_url( site_url('/my-account/initiate-rma') ) . '" class="woocommerce-button woocommerce-Button wc-returns btn btn-primary">' . __( 'Initiate Return Request', 'nsi-rma' ) . '</a></div>';
                echo '<h2>' . __( 'Return History', 'nsi-rma' ) . '</h2>';

                $months_limit = get_option('returns_settings_months_to_display_rma', 18);
                $args = array(
                    'post_type' => 'rma',
                    'post_status' => 'publish',
                    'author' => $user_id,
                    'posts_per_page' => -1,
                    'date_query'     => array(
                        array(
                            'after'     => $months_limit . ' months ago',
                            'inclusive' => true,
                        ),
                    ),
                );

                if ( $filter_rma ) {
                    $args['s'] = $filter_rma;
                }
                $status = $_GET['rma_status'] ?? '';

                if ( !empty($status) ) {
                    $args['meta_key'] = 'rma_status';
                    $args['meta_value'] = $status;
                }

                $query = new WP_Query( $args );
                wc_get_template(
                    'rma-search-form.php',
                    array(
                        'filter_rma' => $filter_rma
                    ),
                    '/woocommerce/order/',
                    NSI_RMA_DIR_PATH . 'templates/'
                );
                if ( $query->have_posts() ) {
                    wc_get_template(
                        'rma-listing.php',
                        array(
                            'return_orders' => $query->posts,
                        ),
                        '/woocommerce/order/',
                        NSI_RMA_DIR_PATH . 'templates/'
                    );
                } else {
                    echo '<p>' . __( 'There are no returns found.', 'nsi-rma' ) . '</p>';
                }

                wp_reset_postdata();
            } else {
                $rma_postmeta = get_post_meta( $rma_id );
                wc_get_template(
                    'rma-single-details.php',
                    array(
                        'rma_id' => $rma_id,
                        'return_order' => $rma_post,
                        'rma_postmeta' => $rma_postmeta,
                    ),
                    '/woocommerce/order/',
                    NSI_RMA_DIR_PATH . 'templates/'
                );
            }

            echo "</div>";
        }
    }
}

NSI_RMA_Listings::init();