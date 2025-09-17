<?php

if(!class_exists('Crown_Block_Post_Header')) {
	class Crown_Block_Post_Header extends Crown_Block {

		public static $name = 'post-header';

		public static function init() {
			parent::init();
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' ),
				'openNewWindow' => array( 'type' => 'boolean', 'default' => true ),
				'url' => array( 'type' => 'string', 'default' => '' ),
				'buttonLabel' => array( 'type' => 'string', 'default' => 'Learn More' ),
				'videoID' => array( 'type' => 'string', 'default' => '' ),
			);
		}

		public static function render( $atts, $content ) {
			$block_class = array( 'wp-block-crown-blocks-post-header', $atts['className'] );
			ob_start();
			// print_r($atts);
			?>
			<div class="<?php echo implode( ' ', $block_class); ?>">
				<div class="post-header__hero">
					<?php $image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium_large' ); ?>
					<?php if ($image_src) { ?>
					<div class="post-header__image-container <?php echo $atts['videoID'] ? 'post-header__image-container--video' : ''; ?>">
						<img class="post-header__image" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ? get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) : get_the_title(); ?>" src="<?php echo $image_src ? $image_src[0] : ''; ?>"> 
						<?php if ($atts['videoID']) { ?>
							<div class="post-header__video">
								<iframe id="post-video" width="250" height="140" src="https://www.youtube.com/embed/<?php echo $atts['videoID']; ?>?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
							</div>
						<?php } ?>
					</div>
					<?php } ?>
					<div class="post-header__meta">
						<div class="post-header__date">
							<?php the_time('m/d/Y') ?>
						</div>
						<h1 class="post-header__title"><?php the_title(); ?></h1>
						<?php if ($atts['url']) { ?>
						<div class="post-header__cta">
							<a href="<?php echo $atts['url']; ?>" target="<?php echo $atts['openNewWindow'] ? '_blank' : '' ;?>" class="btn btn--black"><?php echo $atts['buttonLabel']; ?></a>
						</div>
						<?php } ?>
						<?php if ( function_exists( 'ct_social_sharing_links' ) ) ct_social_sharing_links(); ?>
					</div>
				</div>
			</div>

			<?php
			$output = ob_get_clean();

			return $output;
		}

	}
	Crown_Block_Post_Header::init();
}
