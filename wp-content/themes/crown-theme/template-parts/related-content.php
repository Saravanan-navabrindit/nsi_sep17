

<?php $related_post_ids = ct_get_related_posts( get_the_ID(), array(), array( 'fields' => 'ids' ) ); ?>
<?php if ( ! empty( $related_post_ids ) && count( $related_post_ids ) >= 2 ) { ?>
	<!-- related content -->
<?php } ?>