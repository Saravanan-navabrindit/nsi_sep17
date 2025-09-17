<?php

use Crown\Api\GoogleMaps;
use Crown\Shortcode;


if ( ! class_exists( 'Crown_Site_Settings_Shortcodes' ) ) {
	class Crown_Site_Settings_Shortcodes {

		public static $init = false;

		public static $shortcodes = null;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			add_action( 'after_setup_theme', array( __CLASS__, 'register_shortcodes') );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_scripts' ), 10 );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_styles' ), 10 );

		}


		public static function register_shortcodes() {

			self::$shortcodes['post_category'] = new Shortcode(array(
				'tag' => 'post_category',
				'getOutputCb' => array( __CLASS__, 'get_post_category_shortcode' ),
				'defaultAtts' => array(
					'post_id' => 0
				)
			));

			self::$shortcodes['social_profile_links'] = new Shortcode(array(
				'tag' => 'social_profile_links',
				'getOutputCb' => array( __CLASS__, 'get_social_profile_links_shortcode' ),
				'defaultAtts' => array()
			));

			self::$shortcodes['contact_info'] = new Shortcode(array(
				'tag' => 'contact_info',
				'getOutputCb' => array( __CLASS__, 'get_contact_info_shortcode' ),
				'defaultAtts' => array(
					'context' => ''
				)
			));

			self::$shortcodes['branch_map'] = new Shortcode(array(
				'tag' => 'branch_map',
				'getOutputCb' => array( __CLASS__, 'get_branch_map_shortcode' ),
				'defaultAtts' => array(
					'class' => '',
					'zoom' => 11
				)
			));

			self::$shortcodes['data_chart'] = new Shortcode(array(
				'tag' => 'data_chart',
				'getOutputCb' => array( __CLASS__, 'get_data_chart_shortcode' ),
				'defaultAtts' => array(
					'name' => '',
					'width' => '100',
					'height' => '100'
				)
			));

			self::$shortcodes['qp_placeholder'] = new Shortcode(array(
				'tag' => 'qp_placeholder',
				'getOutputCb' => array( __CLASS__, 'get_query_parameter_placeholder_shortcode' ),
				'defaultAtts' => array(
					'parameter' => '',
					'template' => '',
					'fallback' => ''
				)
			));

			self::$shortcodes['devblock'] = new Shortcode(array(
				'tag' => 'devblock',
				'getOutputCb' => array( __CLASS__, 'get_devblock_shortcode' ),
				'defaultAtts' => array(
					'block' => ''
				)
			));

		}


		public static function register_scripts() {

			wp_register_script( 'chart-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js', array(), '2.9.4', true );
			wp_register_script( 'chart-js-bundle', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js', array(), '2.9.4', true );

		}


		public static function register_styles() {

			wp_register_style( 'chart-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css', array(), '2.9.4' );

		}


		public static function get_post_category_shortcode( $atts, $content ) {
			$post_id = $atts['post_id'];
			if ( empty( $post_id ) ) $post_id = is_singular() ? get_the_ID() : $post_id;
			if ( empty( $post_id ) ) return '';
			$primary_term_id = get_post_meta( $post_id, '_primary_term_category', true );
			if ( ! empty( $primary_term_id ) ) {
				$term = get_term( $primary_term_id, 'category' );
				if ( $term ) return $term->name;
			}
			$terms = get_the_terms( $post_id, 'category' );
			if ( empty( $terms ) ) return '';
			$term_names = array_map( function( $n ) { return $n->name; }, $terms );
			return implode( ', ', $term_names );
		}


		public static function get_social_profile_links_shortcode( $atts, $content ) {
			return apply_filters( 'crown_social_profile_links_shortcode', '', $atts, $content );
		}


		public static function get_contact_info_shortcode( $atts, $content ) {
			$branches = get_repeater_entries( 'blog', 'theme_config_contact_branches' );
			if ( empty( $branches ) ) return '';

			if ( $atts['context'] == 'primary-phone' ) {
				foreach ( $branches as $branch ) {
					if ( ! empty( $branch['phone'] ) ) {
						return '<a href="' . self::get_tel_link( $branch['phone'] ) . '">' . $branch['phone'] . '</a>';
					}
				}
			}

			$classes = array( 'contact-info' );
			if ( ! empty( $atts['context'] ) ) $classes[] = $atts['context'];
			ob_start();
			?>
				<div class="<?php echo implode( ' ', $classes ); ?>">
					<?php foreach ( $branches as $branch ) { ?>
						<div class="branch">

							<h6 class="name"><?php echo ! empty( $branch['title'] ) ? $branch['title'] : get_bloginfo( 'name' ); ?></h6>

							<?php if ( $atts['context'] == 'simple' ) { ?>

								<?php if ( ! empty( $branch['address'] ) ) { ?>
									<p class="address"><?php echo nl2br( $branch['address'] ); ?></p>
									<p class="directions"><a href="https://www.google.com/maps/dir//<?php echo esc_attr( preg_replace( '/\n/', ', ', $branch['address'] ) ); ?>/" target="_blank"><?php _e( 'Get Directions', 'crown_site_settings' ); ?></a></p>
								<?php } ?>

								<?php if ( ! empty( $branch['phone'] ) ) { ?>
									<p class="phone"><a href="<?php echo self::get_tel_link( $branch['phone'] ); ?>"><?php echo $branch['phone']; ?></a></p>
								<?php } ?>

							<?php } else if ( $atts['context'] == 'phone-hours' ) { ?>

								<?php if ( ! empty( $branch['phone'] ) ) { ?>
									<p class="phone"><a href="<?php echo self::get_tel_link( $branch['phone'] ); ?>"><?php echo $branch['phone']; ?></a></p>
								<?php } ?>

								<?php if ( ! empty( $branch['hours'] ) ) { ?>
									<?php
										$search = array(
											'/\r\n/',
											'/monday/i',
											'/tuesday/i',
											'/wednesday/i',
											'/thursday/i',
											'/friday/i',
											'/saturday/i',
											'/sunday/i'
										);
										$replace = array(
											', ',
											'Mon',
											'Tue',
											'Wed',
											'Thu',
											'Fri',
											'Sat',
											'Sun'
										);
									?>
									<p class="hours"><?php echo preg_replace( $search, $replace, $branch['hours'] ); ?></p>
								<?php } ?>

							<?php } else { ?>

								<div class="columns">

									<div class="column">

										<?php if ( ! empty( $branch['address'] ) ) { ?>
											<p class="address"><?php echo nl2br( $branch['address'] ); ?></p>
											<p class="directions"><a href="https://www.google.com/maps/dir//<?php echo esc_attr( preg_replace( '/\n/', ', ', $branch['address'] ) ); ?>/" target="_blank"><?php _e( 'Get Directions', 'crown_site_settings' ); ?></a></p>
										<?php } ?>

									</div>

									<div class="column">

										<?php if ( ! empty( $branch['phone'] ) ) { ?>
											<p class="phone"><a href="<?php echo self::get_tel_link( $branch['phone'] ); ?>"><?php echo $branch['phone']; ?></a></p>
										<?php } ?>

										<?php if ( ! empty( $branch['hours'] ) ) { ?>
											<p class="hours"><?php echo nl2br( $branch['hours'] ); ?></p>
										<?php } ?>

									</div>

								</div>

							<?php } ?>

						</div>
					<?php } ?>
				</div>
			<?php
			return ob_get_clean();
		}


		protected static function get_tel_link( $phone_number ) {

			$phone_number = preg_replace( '/[^0-9A-Z]/', '', strtoupper( $phone_number ) );

			$t9_map = array(
				'2' => array( 'A', 'B', 'C' ),
				'3' => array( 'D', 'E', 'F' ),
				'4' => array( 'G', 'H', 'I' ),
				'5' => array( 'J', 'K', 'L' ),
				'6' => array( 'M', 'N', 'O' ),
				'7' => array( 'P', 'Q', 'R', 'S' ),
				'8' => array( 'T', 'U', 'V' ),
				'9' => array( 'W', 'X', 'Y', 'Z' )
			);
			$s = array_map( function( $n ) { return '/[' . implode( '', $n ) . ']/'; }, $t9_map );
			$r = array_keys( $t9_map );
			$phone_number = preg_replace( $s, $r, $phone_number );

			return 'tel:' . $phone_number;
		}


		public static function get_branch_map_shortcode( $atts, $content ) {

			$classes = array_filter( array_map( 'trim', explode( ' ', $atts['class'] ) ), function( $n ) { return ! empty( $n ); } );
			$wrapper_classes = array_merge( array( 'branch-map' ), array_map( function( $n ) { return $n . '-wrapper'; }, $classes ) );

			$map_args = array(
				'points' => array(),
				'class' => implode( ' ', $classes ),
				'autoAddMarkers' => false,
				'options' => array(
					'styles' => apply_filters( 'crown_google_map_styles', null ),
					'scrollwheel' => false,
					'mapTypeControl' => false,
					'streetViewControl' => false,
					'zoom' => $atts['zoom']
				)
			);

			$branches = get_repeater_entries( 'blog', 'theme_config_contact_branches' );
			if ( empty( $branches ) ) return '';

			foreach ( $branches as $branch ) {
				if ( ! isset( $branch['coordinates'] ) || empty( $branch['coordinates']['lat'] ) || empty( $branch['coordinates']['lng'] ) ) continue;
				$map_args['points'][] = $branch['coordinates'];
			}
			if ( empty( $map_args['points'] ) ) return '';

			return '<div class="' . implode( ' ', $wrapper_classes ) . '">' . GoogleMaps::getMap( $map_args ) . '</div>';

		}


		public static function get_data_chart_shortcode( $atts, $content ) {

			$name = ! empty( $atts['name'] ) ? $atts['name'] : null;
			if ( ! $name ) return '';
			if ( ! in_array( $name, array( 'tfg-client-capital-infusion' ) ) ) return '';

			wp_enqueue_script( 'chart-js' );
			wp_enqueue_style( 'chart-js' );

			ob_start();
			?>

				<div class="data-chart-container <?php echo $name; ?>">
					<canvas id="data-chart-<?php echo $name; ?>" width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>"></canvas>
				</div>
				<script>
					window.onload = function() {
						var ctx = document.getElementById('data-chart-<?php echo $name; ?>').getContext('2d');
						var chartData = {
							labels: ['2016', '2017', '2018', '2019'],
							datasets: [
								// {
								// 	type: 'line',
								// 	label: 'Trendline for SBIR/STTR Grants R² = 0.037',
								// 	borderColor: '#F700FF',
								// 	borderWidth: 2,
								// 	pointRadius: 0,
								// 	fill: false,
								// 	data: [
								// 		62,
								// 		54.6667,
								// 		47.3333,
								// 		40
								// 	]
								// },
								// {
								// 	type: 'line',
								// 	label: 'Trendline for Investment R² = 0.085',
								// 	borderColor: '#F700FF',
								// 	borderWidth: 2,
								// 	pointRadius: 0,
								// 	fill: false,
								// 	data: [
								// 		24,
								// 		26.3333,
								// 		28.6667,
								// 		31
								// 	]
								// },
								{
									type: 'line',
									label: 'Trendline for SBIR/STTR Grants R² = 0.018',
									borderColor: '#F700FF',
									borderWidth: 2,
									pointRadius: 0,
									fill: false,
									data: [
										4.700000,
										4.499058,
										4.298116,
										4.097174,
									]
								},
								{
									type: 'line',
									label: 'Trendline for Investment R² = 0.587',
									borderColor: '#F700FF',
									borderWidth: 2,
									pointRadius: 0,
									fill: false,
									data: [
										15.000000,
										38.100000,
										61.200000,
										84.300000
									]
								},
								{
									type: 'bar',
									label: 'SBIR/STTR Grants',
									backgroundColor: '#84C318',
									borderWidth: 0,
									data: [
										5.852886,
										4.006929,
										1.802963,
										5.917734
									]
								},
								{
									type: 'bar',
									label: 'Investment',
									backgroundColor: '#A4E535',
									borderWidth: 0,
									data: [
										33.453619,
										24.748504,
										32.823271,
										107.820898
									]
								}
							]
						};
						var myChart = new Chart(ctx, {
							type: 'bar',
							data: chartData,
							options: {
								responsive: true,
								title: {
									display: true,
									text: 'TFG Client Capital Infusion'
								},
								legend: {
									onClick: function(e, legendItem) {},
									labels: {
										filter: function(legendItem, data) {
											return legendItem.text.match(/^trendline/i) ? false : true;
										}
									}
								},
								scales: {
									xAxes: [{
										display: true,
										gridLines: {
											display: false
										}
									}],
									yAxes: [{
										display: true,
										ticks: {
											// min: 100000,
											callback: function(value, index, values) {
												return '$' + value + 'M';
											}
										}
									}]
								},
								tooltips: {
									mode: 'index',
									intersect: true
								}
							}
						});
					};
				</script>

			<?php
			return ob_get_clean();

		}


		public static function get_query_parameter_placeholder_shortcode( $atts, $content ) {
			$value = isset( $_GET[ $atts['parameter'] ] ) ? trim( $_GET[ $atts['parameter'] ] ) : '';
			$value = wp_unslash( strip_tags( $value ) );
			if ( empty( $value ) ) return $atts['fallback'];
			return sprintf( $atts['template'], $value );
		}


		public static function get_devblock_shortcode( $atts, $content ) {
			$block = $atts['block'];

			ob_start();

			if ( $block == 'content-slider' ) {
				?>
					<div class="content-slider">
						<a class="slide" href="#">
							<div class="bg">
								<div class="bg-image" style="background-image: url(http://ip.norcalsbdc.org.test/wp-content/uploads/sites/5/2021/04/photo-1459478309853-2c33a60058e7-768x512.jpeg);"></div>
							</div>
							<div class="inner">
								<h5>Tag / Category</h5>
								<h3>TITLE THAT GETS AN ANIMATED UNDERLINE WHEN HOVERED ON</h3>
								<p><span href="#" class="btn btn-link btn-has-arrow-icon">Link</span></p>
							</div>
						</a>
						<a class="slide" href="#">
							<div class="bg">
								<div class="bg-image" style="background-image: url(http://ip.norcalsbdc.org.test/wp-content/uploads/sites/5/2021/04/bg-colors-1-768x507.jpg);"></div>
							</div>
							<div class="inner">
								<h5>Tag / Category</h5>
								<h3>Lorem ipsum dolor sit amet, justo congue mauris fermentum lacus. Dignissim hymenaeos placerat in, non mus enim diam nam, vivamus velit nunc imperdiet auctor sed, nibh elit, pellentesque convallis est.</h3>
								<p><span href="#" class="btn btn-link btn-has-arrow-icon">Link</span></p>
							</div>
						</a>
					</div>
				<?php
			} else if ( $block == 'news-slider' ) {
				?>
					<div class="news-slider">
						<a class="slide" href="#">
							<div class="inner">
								<h6 class="is-style-display"><strong>News</strong> Finance</h6>
								<h3>TITLE THAT GETS AN ANIMATED UNDERLINE WHEN HOVERED ON</h3>
								<p class="date">2 days ago</p>
							</div>
						</a>
						<a class="slide" href="#">
							<div class="inner">
								<h6 class="is-style-display"><strong>News</strong> Food Biz</h6>
								<h3>Lorem ipsum dolor sit amet, justo congue mauris fermentum lacus. Dignissim hymenaeos placerat in, non mus enim diam nam, vivamus velit nunc imperdiet auctor sed, nibh elit, pellentesque convallis est.</h3>
								<p class="date">8 days ago</p>
							</div>
						</a>
						<a class="slide" href="#">
							<div class="inner">
								<h6 class="is-style-display"><strong>News</strong> Finance</h6>
								<h3>TITLE THAT GETS AN ANIMATED UNDERLINE WHEN HOVERED ON</h3>
								<p class="date">2 days ago</p>
							</div>
						</a>
						<a class="slide" href="#">
							<div class="inner">
								<h6 class="is-style-display"><strong>News</strong> Food Biz</h6>
								<h3>Lorem ipsum dolor sit amet, justo congue mauris fermentum lacus. Dignissim hymenaeos placerat in, non mus enim diam nam, vivamus velit nunc imperdiet auctor sed, nibh elit, pellentesque convallis est.</h3>
								<p class="date">8 days ago</p>
							</div>
						</a>
					</div>
				<?php
			} else if ( $block == 'client-story-slider' ) {
				?>
					<div class="client-story-slider">
						<a class="slide" href="#">
							<div class="bg">
								<div class="bg-image" style="background-image: url(http://ip.norcalsbdc.org.test/wp-content/uploads/sites/5/2021/04/photo-1459478309853-2c33a60058e7-768x512.jpeg);"></div>
							</div>
							<div class="inner">
								<h3>Churn Creamery</h3>
							</div>
						</a>
						<a class="slide" href="#">
							<div class="bg">
								<div class="bg-image" style="background-image: url(http://ip.norcalsbdc.org.test/wp-content/uploads/sites/5/2021/04/bg-colors-1-768x507.jpg);"></div>
							</div>
							<div class="inner">
								<h3>Another Slide Goes Here...</h3>
							</div>
						</a>
					</div>
				<?php
			}

			return ob_get_clean();
		}


	}
}