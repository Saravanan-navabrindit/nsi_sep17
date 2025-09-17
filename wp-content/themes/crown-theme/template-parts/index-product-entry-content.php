<article <?php post_class(); ?>>

	<a href="<?php the_permalink(); ?>"><?php echo woocommerce_get_product_thumbnail(); ?></a>

	<div class="entry-header">

		<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<?php $sku = get_post_meta( get_the_ID(), '_sku', true ); ?>
		<?php if ( ! empty( $sku ) ) { ?>
			<p class="entry-sku"><?php echo $sku; ?></p>
		<?php } ?>

	</div>

	<?php if ( is_user_logged_in() ) woocommerce_template_loop_add_to_cart(); ?>

</article>