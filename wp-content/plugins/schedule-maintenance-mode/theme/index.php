<!DOCTYPE html>
<?php 
$option = smmgk_get_options();
$time_diff = 0;
$start_time = $end_time = $countdown = "";
if(isset($option['start_time'])) $start_time=$option['start_time'];
if(isset($option['end_time'])) $end_time=$option['end_time'];
if(isset($option['countdown'])) $countdown=$option['countdown'];
if(isset($end_time) && !empty($end_time))		$time_diff=smmgk_time_diff_from_now($end_time);
?>
<html class="no-js smmgk_maintenance" lang="en">
	<head>
		<meta charset="utf-8">
		<?php
		if(isset($option['seo_favicon']) && !empty($option['seo_favicon'])){ echo '<link rel="icon" href="'.$option["seo_favicon"].'" type="image/png" sizes="16x16">'; }
		if(isset($option['seo_title']) && !empty($option['seo_title'])){ echo '<title>'.$option["seo_title"].'</title>'; }
		if(isset($option['seo_description']) && !empty($option['seo_description'])){ echo '<meta name="description" content="'.$option["seo_description"].'" />'; }
		?>
		<link rel="stylesheet" type="text/css" href="<?php echo SMMGK_URL. "/assets/css/maintenance_template.css"; ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo SMMGK_URL. "/assets/css/flipclock.css"; ?>" />
		<script type='text/javascript' src='<?php echo site_url(). "/wp-includes/js/jquery/jquery.js"; ?>'></script>
		<script type='text/javascript' src='<?php echo SMMGK_URL. "/assets/js/flipclock.js"; ?>'></script>
		
		<style>
		<?php 
		if(isset($option['background']) && !empty($option['background'])){ echo 'body{ background:url('.$option["background"].') no-repeat top center fixed; }';}
		if(isset($option['textcolor']) && !empty($option['textcolor'])){ echo '.smmgk_maintenance body{ color: '.$option["textcolor"].'}'; }
		if(isset($option['headlinecolor'])  && !empty($option['headlinecolor'])){ echo '.smmgk_maintenance h1, .smmgk_maintenance h2, .smmgk_maintenance h3, .smmgk_maintenance h4, .smmgk_maintenance h5, .smmgk_maintenance h6{
			color:'.$option["headlinecolor"].'
		}';}
		if(isset($option['linkcolor'])  && !empty($option['linkcolor'])){ echo '.smmgk_maintenance a, .smmgk_maintenance a:visited, .smmgk_maintenance a:hover, .smmgk_maintenance a:active, .smmgk_maintenance a:focus{color:'.$option["linkcolor"].'}'; } ?>
		</style>
	</head> 
	<body>
		<div id="smmgk-page">
			<div id="smmgk-content">
				<?php
				if(isset($option['logo']) && !empty($option['logo'])){ echo '<img class="smmgk_logo" src="'.$option["logo"].'">'; } else
					{
						echo '<img class="smmgk_logo" src="'.SMMGK_URL.'/assets/images/default_maintenance_logo.png">';
					}
				if(isset($option['headline']) && !empty($option['headline'])){ echo '<h1 class="smmgk_headline">'.$option["headline"].'</h1>'; }
				if(isset($option['maintenance_content']) && !empty($option['maintenance_content'])){ echo '<p class="smmgk_descriptions">'.html_entity_decode(wp_unslash($option["maintenance_content"])).'</p>'; }
				?>
					<?php if($time_diff>0 && $countdown==1){ echo '<div class="smmgk_clock"><div class="clock" style="margin:2em;"></div></div>';} ?>
			</div>
		</div>
		<?php 
		if(isset($option['analytic_code']) && !empty($option['analytic_code'])){ echo html_entity_decode(wp_unslash($option['analytic_code'])); } ?>
		<script type="text/javascript">
			var clock;

			jQuery(document).ready(function() {

				// Grab the current date
				var currentDate = new Date();

				// Set some date in the past. In this case, it's always been since Jan 1
				var pastDate  = new Date(currentDate.getFullYear(), 0, 1);

				// Calculate the difference in seconds between the future and current date
				var diff = "<?php echo $time_diff ?>";

				// Instantiate a coutdown FlipClock
				clock = jQuery('.clock').FlipClock(diff, {
					clockFace: 'DailyCounter',
					countdown: true,
					callbacks: {
						stop: function() {
							window.location.reload(true)
						}
					}
				});
			});
		</script>
	</body>
</html>