<?php
/**
 * Addify Add to Quote.
 */

// Add metabox Custom Fields in admin panel
add_action('add_meta_boxes', 'afrfq_add_metaboxes');

function afrfq_add_metaboxes() {
	add_meta_box(
		'afrfq-quote-status',
		esc_html__('Quote Attributes', 'addify_rfq'),
		'afrfq_quote_status_callback',
		'addify_quote',
		'side',
		'high'
	);
}

// Callback function to display the quote status metabox
function afrfq_quote_status_callback() {
	global $post;
	$quote_status   = get_post_meta( $post->ID, 'quote_status', true );
	$quote_statuses = array(
		'af_pending'    => __( 'Pending', 'addify_rfq' ),
		'af_in_process' => __( 'In Process', 'addify_rfq' ),
		'af_accepted'   => __( 'Accepted', 'addify_rfq' ),
		'af_converted'  => __( 'Converted to Order', 'addify_rfq' ),
		'af_declined'   => __( 'Declined', 'addify_rfq' ),
		'af_cancelled'  => __( 'Cancelled', 'addify_rfq' ),
		'af_expired'    => __( 'Expired', 'addify_rfq' ),
	);
	?>
	<p class="post-attributes-label-wrapper quote-status-label-wrapper">
		<label class="post-attributes-label" for="quote_status">
			<?php echo esc_html__( 'Current Status', 'addify_rfq' ); ?>
		</label>
	</p>
	<select name="quote_status" id="quote_status">
		<?php foreach ( $quote_statuses as $value => $label ) : ?>
			<option value="<?php echo esc_html( $value ); ?>" <?php echo selected( $value, $quote_status ); ?> >
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select> 

	<p class="post-attributes-label-wrapper afrfq-label-wrapper">
		<label class="post-attributes-label" for="quote_status">
			<?php esc_html_e( 'Notify Customer', 'addify_rfq' ); ?>
		</label>
	</p>
		<select name="afrfq_notify_customer" id="afrfq_notify_customer" >
			<option value="no"><?php esc_html_e( 'No', 'addify_rfq' ); ?></option>
			<option value="yes"><?php esc_html_e( 'Yes', 'addify_rfq' ); ?></option>
		</select>
	<p class="desciption">
		<?php esc_html_e( 'Select "Yes" to notify customer via email.', 'addify_rfq' ); ?>
	</p>

	<?php
}