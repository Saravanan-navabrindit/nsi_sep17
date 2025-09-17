<?php

get_header();

$page_title = '';

if ( is_singular() ) {
	$page_title = get_the_title();
} else if ( is_home() ) {
	$page_title = __( 'Blog', 'crown_theme' );
} else if ( is_category() ) {
	$page_title = single_cat_title( '', false );
} else if ( is_tag() ) {
	$page_title = __( 'Tag', 'crown_theme' ) . ': ' . single_tag_title( '', false );
} else if ( is_date() ) {
	$month = trim( single_month_title( ' ', false ) );
	$page_title = ! empty( $month ) ? $month : trim( $wp_query->query_vars['year'] );
} else if ( is_author() ) {
	$author = get_queried_object();
	$page_title = __( 'Author', 'crown_theme' ) . ': ' . $author->display_name;
} else if ( is_search() ) {
	$page_title = __( 'Search Results', 'crown_theme' );
} else if ( is_404() ) {
	$page_title = __( '404: Page Not Found', 'crown_theme' );
		
	// Redirect to the first page of the product filter
	redirection_with_404();
}

if ( is_home() && ( $page_for_posts = get_post( get_option( 'page_for_posts' ) ) ) ) {

	$post = $page_for_posts;
	setup_postdata( $post );
	get_template_part( 'template-parts/content', get_post_type() );
	wp_reset_postdata();

} else {
	?>

		<div id="index-entries">

			<?php if ( ! empty( $page_title ) ) { ?>
				<h1><?php echo $page_title; ?></h1>
			<?php } ?>

			<?php if ( have_posts() ) { ?>

				<div class="entries-list-container">

					<?php if ( is_search() ) { ?>
						<?php
							$product_query_args = array(
								'posts_per_page' => 20,
								'post_type' => 'product',
								'orderby' => 'meta_value',
								'order' => 'ASC',
								'meta_query' => array(
									array( 'key' => '_sku', 'compare' => 'LIKE', 'value' => get_search_query() )
								)
							);
							$product_query = null;
							if ( function_exists( 'relevanssi_do_query' ) && isset( $product_query_args['s'] ) && ! empty( $product_query_args['s'] ) ) {
								$product_query = new WP_Query();
								$product_query->parse_query( $product_query_args );
								relevanssi_do_query( $product_query );
							} else {
								$product_query = new WP_Query( $product_query_args );
							}
						?>
						<?php if ( $product_query->have_posts() ) { ?>
							<div class="product-entries-list item-count-<?php echo $product_query->post_count; ?>">
								<div class="inner">
									<h2>Top Product Results</h2>
									<?php while ( $product_query->have_posts() ) { ?>
										<?php $product_query->the_post(); ?>
										<?php get_template_part( 'template-parts/index-product-entry-content', get_post_type() ); ?>
									<?php } ?>
									<?php wp_reset_postdata(); ?>
								</div>
							</div>
						<?php } ?>
					<?php } ?>

					<div class="entries-list item-count-<?php echo $wp_query->post_count; ?>">
						<div class="inner">
							<?php while ( have_posts() ) { ?>
								<?php the_post(); ?>
								<?php if ( is_search() ) { ?>
									<?php get_template_part( 'template-parts/search-entry-content', get_post_type() ); ?>
								<?php } else { ?>
									<?php get_template_part( 'template-parts/index-entry-content', get_post_type() ); ?>
								<?php } ?>
							<?php } ?>
					
						</div>
					</div>

				</div>

			<?php } else { ?>

				<div class="alert alert-warning">
					<p class="mb-0">Nothing found, please try adjusting your search.</p>
				</div>

			<?php } ?>

			<?php get_template_part( 'template-parts/pagination' ); ?>

		</div>

	<?php
}

get_footer();
