<?php

if(!class_exists('Crown_Block_Breadcrumbs')) {
	class Crown_Block_Breadcrumbs extends Crown_Block {

		public static $name = 'breadcrumbs';

		public static function init() {
			parent::init();
		}

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' )
			);
		}

		public static function render( $atts, $content ) {
			if ( ! class_exists( 'CrownBreadcrumbs' ) ) return '';
			$block_class = array( 'wp-block-crown-blocks-breadcrumbs', $atts['className'] );
			ob_start();
			?>
				<div class="<?php echo implode( ' ', $block_class); ?>">
					<?php echo CrownBreadcrumbs::getBreadcrumbs(); ?>
				</div>
			<?php
			$output = ob_get_clean();
			return $output;
		}

	}
	Crown_Block_Breadcrumbs::init();
}
