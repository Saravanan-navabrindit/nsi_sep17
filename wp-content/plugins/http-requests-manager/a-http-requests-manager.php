<?php

/*
  Plugin URI: https://veppa.com/http-requests-manager/
  Description: This is a boot module installed by the "HTTP Requests Manager" plugin when you ENABLE "Load before other plugins" option.
  Author: veppa
  Author URI: https://veppa.com/
  Version: 1.0.2
  Text Domain: http-requests-manager
  Network: true

  Licenced under the GNU GPL.

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */

// If this file is called directly, abort executing.
defined('ABSPATH') or exit;

define('VPHRM_MODE_INIT', 1);

// make sure that we are in mu folder
if(str_replace("\\", "/", __DIR__) === str_replace("\\", "/", WPMU_PLUGIN_DIR))
{
	$_vphrm_active_plugins = apply_filters('active_plugins', get_option('active_plugins', array()));

	// include only if plugin active 
	if(empty($_vphrm_active_plugins))
	{
		// no plugin is active. something wrong. 
		// do nothing. it is temporaty state maybe when all plugins disabled.
		if(!file_exists(WP_PLUGIN_DIR . '/http-requests-manager/http-requests-manager.php'))
		{
			// main plugin file is not there remove this MU loader
			@unlink(__FILE__);
		}
	}
	elseif(is_array($_vphrm_active_plugins) && in_array('http-requests-manager/http-requests-manager.php', $_vphrm_active_plugins))
	{
		// plugin active load it.
		if(( @include_once WP_PLUGIN_DIR . '/http-requests-manager/http-requests-manager.php' ) == true)
		{
			define('VPHRM_MODE', 1);
		}
	}
	else
	{
		// only this plugin is not active 
		// delete self because plugin is disabled without removing mu loader
		@unlink(__FILE__);
	}
}



