<?php

$aria_label = ! empty( $args['aria_label'] ) ? 'aria-label="' . esc_attr( $args['aria_label'] ) . '"' : '';
$placeholder = ! empty( $args['placeholder'] ) ? $args['placeholder'] : 'Search&hellip;';
$submit_label = ! empty( $args['submit_label'] ) ? $args['submit_label'] : 'Search';

?>
<?php
    if (defined('HAWKSEARCH_ENABLED') && HAWKSEARCH_ENABLED) {
        ?>
        <hawksearch-search-field></hawksearch-search-field>
        <?php
    } else {
        ?>
        <form role="search" <?php echo $aria_label; ?> method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <label>
                <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ); ?></span>
                <input type="search" class="search-field" placeholder="<?php echo $placeholder; ?>" value="<?php echo get_search_query(); ?>" name="s" />
            </label>
            <button type="submit" class="search-submit"><?php echo $submit_label; ?></button>
        </form>
        <?php
    }
?>