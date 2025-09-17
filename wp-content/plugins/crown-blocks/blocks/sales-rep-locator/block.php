<?php

if(!class_exists('Crown_Block_Sales_Rep_Locator')) {
	class Crown_Block_Sales_Rep_Locator extends Crown_Block {

		public static $name = 'sales-rep-locator';

		public static function get_attributes() {
			return array(
				'className' => array( 'type' => 'string', 'default' => '' ),
				'selectedType' => array( 'type' => 'string', 'default' => '' ),
			);
		}

		public static function render( $atts, $content ) {
			if ( ! class_exists( 'Crown_Sales_Reps' ) ) return '';

			$block_class = array( 'wp-block-crown-blocks-' . self::get_name(), $atts['className'] );
			$selected_type = isset($atts['selectedType']) ? $atts['selectedType'] : '';

			ob_start();
			?>
				<div class="<?php echo implode( ' ', $block_class ); ?>">
					<?php Crown_Sales_Reps::sales_rep_locator($selected_type); ?>
				</div>
			<?php
			return ob_get_clean();
		}


		protected static function render_post_feed( $query ) {
			return;
		}


	}
	Crown_Block_Sales_Rep_Locator::init();
}
