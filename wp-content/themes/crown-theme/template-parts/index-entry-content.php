<article <?php post_class(); ?>>

	<div class="entry-header">

		<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<p class="entry-link">
			<a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a>
		</p>

	</div>

	<div class="entry-excerpt">
		<?php the_excerpt(); ?>
	</div>

</article>