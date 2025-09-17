<?php $announcement = apply_filters( 'crown_site_announcement', null ); ?>
<?php if ( $announcement ) { ?>
	<div id="site-announcement" class="text-color-<?php echo $announcement->text_color == 'auto' ? ct_color_yiq( $announcement->bg_color, 'dark', 'light' ) : $announcement->text_color; ?>" data-announcement-id="<?php echo esc_attr( md5( json_encode( $announcement ) ) ); ?>" style="background-color: <?php echo $announcement->bg_color; ?>;">
		<div class="inner">

			<button type="button" class="dismiss">Dismiss</button>

			<div class="container">
				<div class="inner">

					<?php if ( ! empty( $announcement->message ) ) { ?>	
						<p class="message"><?php echo $announcement->message; ?></p>
					<?php } ?>

					<?php if ( ! empty( $announcement->link->url ) ) { ?>	
						<p class="link">
							<a href="<?php echo $announcement->link->url; ?>" target="<?php echo in_array( 'open-new-window', $announcement->link->options ) ? '_blank' : '_self'; ?>">
								<?php echo ! empty( $announcement->link->label ) ? $announcement->link->label : 'Learn More'; ?>
							</a>
						</p>
					<?php } ?>

				</div>
			</div>

		</div>
	</div>
<?php } ?>