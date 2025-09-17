<?php

$prev_text = __( 'Previous', 'crown_theme' );
$next_text = __( 'Next', 'crown_theme' );

$posts_pagination = get_the_posts_pagination(
	array(
		'prev_text' => __( $prev_text, 'crown_theme' ),
		'next_text' => __( $next_text, 'crown_theme' ),
		'mid_size' => 2
	)
);

?>

<?php if ( $posts_pagination ) { ?>
	<div class="pagination-wrapper">
		<?php echo $posts_pagination; ?>
	</div>
<?php } ?>