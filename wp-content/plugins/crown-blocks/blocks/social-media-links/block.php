<?php

if(!class_exists('Crown_Block_Social_Media_links')) {
	class Crown_Block_Social_Media_links extends Crown_Block {

		public static $name = 'social-media-links';
		public static function init() {
			parent::init();
		}

		public static function render( $atts, $content ) {
			
			
			$block_class = array( 'wp-block-crown-blocks-social-media-links' );

			ob_start();
			// print_r($atts);
			?>

				<div class="<?php echo implode( ' ', $block_class ); ?>">
					<div class="inner">
						<h5 class="title">Connect With Us</h4>   
					<?php ct_social_links_w_icon(); ?>


					</div>
				</div>

			<?php
			$output = ob_get_clean();


			return $output;
		}
	}
	Crown_Block_Social_Media_links::init();
}
