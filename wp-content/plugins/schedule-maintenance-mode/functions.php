<?php  
function smmgk_get_options() {
	return get_option('smmgk_schedule_maintenance');
}
function smmgk_time_diff_from_now($end_time) {
	return $end_time - time(); 
}

// Success message
function  smmgk_success_option_msg($msg) {
	echo ' <div class="notice notice-success smmgk-success-msg is-dismissible"><p>'. $msg . '</p></div>';
}

// Error message
function  smmgk_failure_option_msg($msg) {
	echo  '<div class="notice notice-error smmgk-error-msg is-dismissible"><p>' . $msg . '</p></div>';
}