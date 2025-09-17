<?php get_header(); ?>

<?php $gated_content_form = get_post_meta( get_the_ID(), 'page_content_gating_form', true ); ?>
<?php if ( ! empty( $gated_content_form ) ) { ?>
	<?php get_template_part( 'template-parts/content-gated', get_post_type() ); ?>
<?php } ?>

<?php if ( have_posts() ) { ?>
	<?php while ( have_posts() ) { ?>
		<?php the_post(); ?>
		<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
		<?php get_template_part( 'template-parts/related-content', get_post_type() ); ?>
	<?php } ?>
<?php } ?>

<?php get_footer(); ?>