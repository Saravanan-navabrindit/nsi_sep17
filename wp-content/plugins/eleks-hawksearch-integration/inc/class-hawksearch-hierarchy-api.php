<?php
require_once HAWKSEARCH_PLUGIN_DIR . '/inc/product-data-helpers.php';

class Hawksearch_hierarchy_API extends Hawksearch_base_API  {

    private static WC_Logger $wc_logger;
    protected string $api_url = '';
    protected Hawksearch_indexing_API $indexing_api;

	public function __construct( $Hawksearch_indexing_API ) {
		parent::__construct();
		if ( defined( 'HAWKSEARCH_API_HIERARCHY_URL' ) ) {
            $this->api_url = HAWKSEARCH_API_HIERARCHY_URL . '/';
        }
        self::$wc_logger = wc_get_logger();
        $this->indexing_api = $Hawksearch_indexing_API;
    }

    public function upsert_hierarchy_data( $index_name = '' ) {
        if ( empty($index_name) ) {
            $index_name = $this->indexing_api->get_current_index();
            if ( !$index_name ) {
                return;
            }
        }

        $product_category_tree = $this->get_product_category_tree();
        $product_category_tree_chunks = array_chunk( $product_category_tree, 125 );
        $chunks_amount = count( $product_category_tree_chunks );
        foreach ( $product_category_tree_chunks as $i => $chunk ) {
            $data = array(
                'IndexName' => $index_name,
                'Hierarchies' => $chunk,
            );

            $response = $this->request( 'upsert', 'POST', $data );
            if ( array_key_exists('response', $response) && isset($response['response']['code']) && $response['response']['code'] == 200 ) {
                self::$wc_logger->info('Hawksearch Hierarchy API - hierarchy chunk ' . ($i+1) . '/' . $chunks_amount . ' inserted', array('source' => 'hawksearch'));
            } else {
                $formatted_message = self::get_formatted_response($response);
                self::$wc_logger->error('Hawksearch Hierarchy API - hierarchy chunk ' . ($i+1) . '/' . $chunks_amount . ' failed, error: ' . $formatted_message, array('source' => 'hawksearch'));
            }
        }

        self::$wc_logger->info( 'Hawksearch Hierarchy API - categories inserted', array('source' => 'hawksearch') );
    }

    public function get_product_category_tree() {
        $category_tree = array();
        $category_tree[] = array(
            'HierarchyId' => 1,
            'Name' => 'category',
            'ParentHierarchyId' => 0,
            'IsActive' => true,
        );

        $this->get_product_category_level( 0, $category_tree );

        return $category_tree;
    }

    public function get_product_category_level( $parent_cat_id, &$category_tree ) {
        $categories = get_terms( array('taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => $parent_cat_id) );
        if ( !empty($categories) && !is_wp_error($categories) ) {
            foreach ( $categories as $category ) {
                $category_tree[] = array (
                    'HierarchyId' => $category->term_id,
                    'Name' => $category->name,
                    'ParentHierarchyId' => $category->parent == 0 ? 1 : $category->parent,
                    'IsActive' => true,
                );

                $this->get_product_category_level( $category->term_id, $category_tree );
            }
        }
    }

    public function rebuild_hierarchy( $index ) {
        $data = array( 'IndexName' => $index );
        $response = $this->request( 'rebuild', 'POST', $data );
        if ( array_key_exists('response', $response) && isset($response['response']['code']) && $response['response']['code'] == 200 ) {
            self::$wc_logger->info('Hawksearch Hierarchy API rebuild DONE', array('source' => 'hawksearch'));
            return TRUE;
        } else {
            $formatted_message = self::get_formatted_response($response);
            self::$wc_logger->error('Hawksearch Hierarchy API rebuild failed, error: ' . $formatted_message, array('source' => 'hawksearch'));
        }

        return FALSE;
    }

    public function delete_hierarchy( $index ) {
        $data = array( 'IndexName' => $index );
        $response = $this->request( 'delete-all', 'POST', $data );
        if ( array_key_exists('response', $response) && isset($response['response']['code']) && $response['response']['code'] == 200 ) {
            self::$wc_logger->info('Hawksearch Hierarchy API - delete hierarchy successful', array('source' => 'hawksearch'));
            return TRUE;
        } else {
            $formatted_message = self::get_formatted_response($response);
            self::$wc_logger->error('Hawksearch Hierarchy API - delete hierarchy failed, error: ' . $formatted_message, array('source' => 'hawksearch'));
        }

        return FALSE;
    }

    public function delete_hierarchy_items( $index, $category_ids ) {
        $data = array(
            'IndexName' => $index,
            'Ids' => $category_ids
        );

        $response = $this->request( 'delete-items', 'POST', $data );
        if ( array_key_exists('response', $response) && isset($response['response']['code']) && $response['response']['code'] == 200 ) {
            self::$wc_logger->info('Hawksearch Hierarchy API - delete hierarchy items successful', array('source' => 'hawksearch'));
            return TRUE;
        } else {
            $formatted_message = self::get_formatted_response($response);
            self::$wc_logger->error('Hawksearch Hierarchy API - delete hierarchy items failed, error: ' . $formatted_message, array('source' => 'hawksearch'));
        }

        return FALSE;
    }

    public function get_hierarchy( $index ) {
        $data = array( 'IndexName' => $index );
        $response = $this->request( '', 'POST', $data );

        if ( array_key_exists('body', $response) && !empty($response['body']) ) {
            return json_decode( $response['body'] );
        }

        return false;
    }

    public static function get_formatted_response( WP_Error|array $response ): string
    {
        if (is_wp_error($response)) {
            $formatted_message = 'error_message' . $response->get_error_message();
        } else if (is_array($response)) {
            $message = isset( $response['body'] ) ? $response['body'] : 'Please check Hawksearch admin panel for error logs.';
            $formatted_message = 'Hawksearch error: ' . $message;
        } else {
            $formatted_message = $response;
        }
        return $formatted_message;
    }
}