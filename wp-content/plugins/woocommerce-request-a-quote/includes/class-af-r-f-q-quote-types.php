<?php
/**
 * Addify Request a Quote - Quote Types Handler.
 *
 * The Addify Quote Types handler class manages quote type data and related functions.
 *
 * @package addify-request-a-quote
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * AF_R_F_Q_Quote_Types class.
 */
class AF_R_F_Q_Quote_Types {

    /**
     * Contains an array of quote type objects.
     *
     * @var array
     */
    public $quote_types = array();

    /**
     * Constructor for the AF_R_F_Q_Quote_Types class.  Loads quote types.
     */
    public function __construct() {
        $this->quote_types = $this->afrfq_get_all_quote_types();
    }

    /**
     * Retrieves all quote types.
     *
     * @return array An array of WP_Post objects representing the quote types.
     */
    public function afrfq_get_all_quote_types() {
        $args = array(
            'post_type'      => 'addify_quote_type',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'meta_query'     => array(
                array(
                    'key'     => 'quote_type_is_enabled',
                    'value'   => 'yes',
                    'compare' => '='
                )
            )
        );

        $query = new WP_Query( $args );

        return $query->posts;
    }

    /**
     * Gets a specific quote type by its ID.
     *
     * @param int $quote_type_id The ID of the quote type.
     * @return WP_Post|null       The quote type object or null if not found.
     */
    public function afrfq_get_quote_type( $quote_type_id ) {
        if ( empty( intval( $quote_type_id ) ) ) {
            return null;
        }

        return get_post( $quote_type_id );
    }

    /**
     * Gets the quote type name by ID.  Fetches it from the post title.
     *
     * @param int $quote_type_id The ID of the quote type.
     * @return string The name of the quote type, or an empty string if not found.
     */
    public function afrfq_get_quote_type_name( $quote_type_id ) {
        $quote_type = $this->afrfq_get_quote_type( $quote_type_id );

        if ( $quote_type ) {
            return esc_html( $quote_type->post_title );
        }

        return '';
    }

    /**
     * Checks if convert to order is disabled.
     *
     * @param int $quote_type_id The ID of the quote type.
     * @return bool True if convert to order is disabled, false otherwise.
     */
    public function afrfq_is_convert_to_order_disabled( $quote_type_id ) {
        $quote_type = $this->afrfq_get_quote_type( $quote_type_id );

        if ( $quote_type ) {
            $disable_convert = get_post_meta( $quote_type_id, 'quote_type_disable_convert_order', true );
            return ( 'yes' === $disable_convert );
        }

        return false;
    }

    /**
     * Checks if discount rules should be applied.
     *
     * @param int $quote_type_id The ID of the quote type.
     * @return bool True if discount rules should be applied, false otherwise.
     */
    public function afrfq_should_apply_discount_rules( $quote_type_id ) {
        $quote_type = $this->afrfq_get_quote_type( $quote_type_id );

        if ( $quote_type ) {
            $discount_rules = get_post_meta( $quote_type_id, 'quote_type_discount_rules', true );
            return ( 'yes' === $discount_rules );
        }

        return false;
    }

     /**
     * Checks if discount rules should be applied.
     *
     * @param int $quote_type_id The ID of the quote type.
     * @return bool True if discount rules should be applied, false otherwise.
     */
    public function afrfq_is_quote_type_enabled( $quote_type_id ) {
        $quote_type = $this->afrfq_get_quote_type( $quote_type_id );

        if ( $quote_type ) {
            $is_enabled = get_post_meta( $quote_type_id, 'quote_type_is_enabled', true );
            return ( 'yes' === $is_enabled );
        }

        return false;
    }
}