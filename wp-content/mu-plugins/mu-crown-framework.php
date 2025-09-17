<?php
/**
 * Plugin Name: Crown Framework
 * Plugin URI: http://www.jordancrown.com
 * Description: The Crown Framework extends the functionality of the WordPress core.
 * Version: 2.13.7
 * Author: Jordan Crown
 * Author URI: http://www.jordancrown.com
 * License: GNU General Pulic License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// load framework
require_once(dirname(__FILE__).'/crown-framework/load.php');

// add_filter('gutenberg_can_edit_post_type', '__return_false');