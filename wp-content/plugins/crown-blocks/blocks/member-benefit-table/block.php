<?php

if(!class_exists('Crown_Block_Member_Benefit_Table')) {
	class Crown_Block_Member_Benefit_Table extends Crown_Block {

		public static $name = 'member-benefit-table';
		public static function init() {
			parent::init();
		}

		public static function render( $atts, $content ) {
			
			
			$block_class = array( 'wp-block-crown-blocks-member-benefit-table' );

			ob_start();
			// print_r($atts);
			?>

				<div class="<?php echo implode( ' ', $block_class ); ?>">
					<div class="inner">
						<div class="column">
							<div class="price-card">
								<h3 class="price-card__title">Council</h3>
								<p class="price-card__price">CNY50,000/Year</p>
							</div>
							<div class="accordion">
								<div class="card-body">
									Participate in CMGC’s marketing activities, including but not limited to exhibitions, forums, training, outreach visits, etc.
								</div>
								<div class="card-body">
									Join the internal meetings to learn the updates of CMGC and the Alliance as well as the dynamics of working groups, or exchange technical and market information with other CMGC members
								</div>
								<div class="card-body">
									Access to and supervise over the policies, regulations management information of CMGC
								</div>
								<div class="card-body">
									Put forward proposals and suggestions for CMGC activities
								</div>
								<div class="card-body">
									Obtain information, data and related materials of events (seminars, trainings sessions) organized by CMGC
								</div>
								<div class="card-body">
									Co-marketing for products and solutions that use the Alliance’s technologies at events or media of CMGC and the Alliance including WeChat platform, exhibitions, forums, etc.								</div>
								<div class="card-body">
									Join the Council for CMGC strategy setting and decide on key polices, such as Member Manuals, organizational structure								</div>
								<div class="card-body">
									Act as representative for CMGC or the Alliance to attend events and make speeches
								</div>
								<div class="card-body">
									Be nominated for the leading roles of the CMGC such as Chair and team leaders
								</div>
								<div class="card-body">
									Enjoy priorities in CMGC’s activities and publicity opportunities, such as exhibition booths and forum speech slots
								</div>
								<div class="card-body">
									Enjoy special discount when extra fee is charged for some events organized by CMGC
								</div>
							</div>
						</div>
						<div class="column">
							<div class="price-card">
								<h3 class="price-card__title">Associate</h3>
								<p class="price-card__price">CNY10,000/Year</p>
							</div>
							<div class="accordion">
								<div class="card-body">
									Participate in CMGC’s marketing activities, including but not limited to exhibitions, forums, training, outreach visits, etc.
								</div>
								<div class="card-body">
									Join the internal meetings to learn the updates of CMGC and the Alliance as well as the dynamics of working groups, or exchange technical and market information with other CMGC members
								</div>
								<div class="card-body">
									Access to and supervise over the policies, regulations management information of CMGC
								</div>
								<div class="card-body">
									Put forward proposals and suggestions for CMGC activities
								</div>
								<div class="card-body">
									Obtain information, data and related materials of events (seminars, trainings sessions) organized by CMGC
								</div>
								<div class="card-body">
									Co-marketing for products and solutions that use the Alliance’s technologies at events or media of CMGC and the Alliance including WeChat platform, exhibitions, forums, etc.
								</div>
							</div>
						</div>
					</div>
				</div>

			<?php
			$output = ob_get_clean();


			return $output;
		}
	}
	Crown_Block_Member_Benefit_Table::init();
}
