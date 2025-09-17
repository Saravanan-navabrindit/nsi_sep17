<?php

if(!class_exists('Crown_Block_Membership_Table')) {
	class Crown_Block_Membership_Table extends Crown_Block {

		public static $name = 'membership-table';
		public static function init() {
			parent::init();
		}

		public static function render( $atts, $content ) {
			
			
			$block_class = array( 'wp-block-crown-blocks-membership-table' );

			ob_start();
			// print_r($atts);
			?>

				<div class="<?php echo implode( ' ', $block_class ); ?>">
					<div class="inner">
						<div class="column">
							<div class="price-card">
								<h3 class="price-card__title">Promoter</h3>
								<p class="price-card__price">*$105,000 USD/yr</p>
							</div>
							<div class="accordion">
								<div class="card">
									<div class="card-header collapsed" id="heading-1-1"  data-toggle="collapse" data-target="#collapse-1-1" aria-expanded="true" aria-controls="collapse-1-1">
										Develop, Test, and Certify
									</div>
									<div id="collapse-1-1" class="collapse" aria-labelledby="heading-1-1">
										<div class="card-body">
											<ul>
												<li>Develop, test, and certify products $2,000 USD per product</li>
												<li>Certify own derivative product $1,500 USD per product</li>
												<li>Develop, test, and certify products that can be transferred to a 3rd party via the Certification Transfer Program</li>
												<li>Implement a Certified Product via the Certification Transfer Program and use the Alliance Certification trademarks and logos $1,500 USD per product</li>
												<li>Certified Product listing on the Alliance website</li>
												<li>Attend Alliance workshops, developer conferences, and test events</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-header collapsed" id="heading-1-2" data-toggle="collapse" data-target="#collapse-1-2" aria-expanded="false" aria-controls="collapse-1-2">
										Go to Market
									</div>
									<div id="collapse-1-2" class="collapse" aria-labelledby="heading-1-2">
										<div class="card-body">
											<ul>
												<li>Participate in the development of market messaging and marketing communication assets for technology brands and specs</li>
												<li>Participate in Alliance marketing communications, including press releases, blogs, member success stories, videos, etc.</li>
												<li>Use Connectivity Standards Alliance trademarks and logos (within usage guidelines)</li>
												<li>Receive access to Alliance marketing collateral</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-header collapsed" id="heading-1-3" data-toggle="collapse" data-target="#collapse-1-3" aria-expanded="false" aria-controls="collapse-1-3">
										Participate and Lead
									</div>
									<div id="collapse-1-3" class="collapse" aria-labelledby="heading-1-3">
										<div class="card-body">
											<ul>
												<li>Receive a seat on the Board of Directors</li>
												<li>Participate, vote, and chair Alliance Working Group teams</li>
												<li>Participate in the development of Specifications and Test Materials</li>
												<li>Participate in the development of Market Requirements and Use Cases for Specifications</li>
												<li>Attend Connectivity Standards Alliance Member Meetings</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="column">
							<div class="price-card">
								<h3 class="price-card__title">Participant</h3>
								<p class="price-card__price">*$20,000 USD/yr</p>
							</div>
							<div class="accordion">
								<div class="card">
									<div class="card-header collapsed" id="heading-2-1"  data-toggle="collapse" data-target="#collapse-2-1" aria-expanded="true" aria-controls="collapse-2-1">
										Develop, Test, and Certify
									</div>
									<div id="collapse-2-1" class="collapse" aria-labelledby="heading-2-1">
										<div class="card-body">
											<ul>
												<li>Develop, test, and certify products $2,000 USD per product</li>
												<li>Certify own derivative product $1,500 USD per product</li>
												<li>Develop, test, and certify products that can be transferred to a 3rd party via the Certification Transfer Program</li>
												<li>Implement a Certified Product via the Certification Transfer Program and use the Alliance Certification trademarks and logos $1,500 USD per product</li>
												<li>Certified Product listing on the Alliance website</li>
												<li>Attend Alliance workshops, developer conferences, and test events</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-header collapsed" id="heading-2-2" data-toggle="collapse" data-target="#collapse-2-2" aria-expanded="false" aria-controls="collapse-2-2">
										Go to Market
									</div>
									<div id="collapse-2-2" class="collapse" aria-labelledby="heading-2-2">
										<div class="card-body">
											<ul>
												<li>Participate in the development of market messaging and marketing communication assets for technology brands and specs</li>
												<li>Participate in Alliance marketing communications, including press releases, blogs, member success stories, videos, etc.</li>
												<li>Use Connectivity Standards Alliance trademarks and logos (within usage guidelines)</li>
												<li>Receive access to Alliance marketing collateral</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-header collapsed" id="heading-2-3" data-toggle="collapse" data-target="#collapse-2-3" aria-expanded="false" aria-controls="collapse-2-3">
										Participate and Lead
									</div>
									<div id="collapse-2-3" class="collapse" aria-labelledby="heading-2-3">
										<div class="card-body">
											<ul>
												<li>Participate, vote, and chair Alliance Working Group teams</li>
												<li>Participate in the development of Specifications and Test Materials</li>
												<li>Participate in the development of Market Requirements and Use Cases for Specifications</li>
												<li>Attend Connectivity Standards Alliance Member Meetings</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="column">
							<div class="price-card">
								<h3 class="price-card__title">Adopter</h3>
								<p class="price-card__price">$7,000 USD/yr</p>
							</div>
							<div class="accordion">
								<div class="card">
									<div class="card-header collapsed" id="heading-3-1"  data-toggle="collapse" data-target="#collapse-3-1" aria-expanded="true" aria-controls="collapse-3-1">
										Develop, Test, and Certify
									</div>
									<div id="collapse-3-1" class="collapse" aria-labelledby="heading-3-1">
										<div class="card-body">
											<ul>
												<li>Develop, test, and certify products $3,000 USD per product</li>
												<li>Certify own derivative product $2,500 USD per product</li>
												<li>Implement a Certified Product via the Certification Transfer Program and use the Alliance Certification trademarks and logos $2,500 USD per product</li>
												<li>Certified Product listing on the Alliance website</li>
												<li>Attend Alliance workshops, developer conferences, and test events</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-header collapsed" id="heading-3-2" data-toggle="collapse" data-target="#collapse-3-2" aria-expanded="false" aria-controls="collapse-3-2">
										Go to Market
									</div>
									<div id="collapse-3-2" class="collapse" aria-labelledby="heading-3-2">
										<div class="card-body">
											<ul>
												<li>Participate in Alliance marketing communications, including press releases, blogs, member success stories, videos, etc.</li>
												<li>Use Connectivity Standards Alliance trademarks and logos (within usage guidelines)</li>
												<li>Receive access to Alliance marketing collateral</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-header collapsed" id="heading-3-3" data-toggle="collapse" data-target="#collapse-3-3" aria-expanded="false" aria-controls="collapse-3-3">
										Participate and Lead
									</div>
									<div id="collapse-3-3" class="collapse" aria-labelledby="heading-3-3">
										<div class="card-body">
											<ul>
												<li>Attend Connectivity Standards Alliance Member Meetings</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="column">
							<div class="price-card">
								<h3 class="price-card__title">Associate</h3>
								<p class="price-card__price">$0 USD/yr</p>
							</div>
							<div class="accordion">
								<div class="card-body">
									White label or rebrand a Certified Product via the Certification Transfer Program and use the Alliance Certification trademarks $2,500 USD per product + $500 USD per year, per product (due annually on the anniversary date of the grant of certification)
								</div>
							</div>
						</div>
					</div>
					<div class="disclaimer">
						<p>* Promoter membership also requires a one-time initiation fee</p>
						<p>* Membership Fees effective 15 July 2021.</p>
					</div>
				</div>

			<?php
			$output = ob_get_clean();


			return $output;
		}
	}
	Crown_Block_Membership_Table::init();
}
