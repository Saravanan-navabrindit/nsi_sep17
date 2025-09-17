<?php
/**
 * Loads the Crown Framework.
 *
 * Include this file to autoload all classes/functions of the framework. The 'Crown' namespace
 * is registered for all framework classes to be referenced.
 */

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Symfony\Component\ClassLoader\ApcUniversalClassLoader;

use Crown\Framework as CrownFramework;

// be sure to not load framework more than once!
if(!defined('CROWN_FRAMEWORK_VERSION')) {

	/**
	 * Framework version number.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	define('CROWN_FRAMEWORK_VERSION', '2.13.7');

	// get correct URL and path to wp-content to determine framework base URL
	$contentUrl = untrailingslashit(dirname(dirname(get_stylesheet_directory_uri())));
	$contentDir = str_replace('\\', '/', untrailingslashit(dirname(dirname(get_stylesheet_directory()))));
	$crownUrl = str_replace('/load.php', '', str_replace($contentDir, $contentUrl, str_replace('\\', '/', __FILE__)));

	/**
	 * Base Crown Framework directory path.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	define('CROWN_DIR', untrailingslashit(dirname(__FILE__)));

	/**
	 * Base Crown Framework URL.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	define('CROWN_URL', $crownUrl);


	require_once(CROWN_DIR.'/vendor/autoload.php');
	require_once(CROWN_DIR.'/functions.php');

	// create loader
	$loader = null;
	if(extension_loaded('apc') && ini_get('apc.enabled')) { // check if we're able to use APC
		$loader = new ApcUniversalClassLoader('apc.crown.');
	} else {
		$loader = new UniversalClassLoader();
	}

	// register crown's namespaces
	$loader->registerNamespaces(array(
		'Crown' => CROWN_DIR.'/src',
	));

	$loader->register();

	// setup framework
	if(is_blog_installed()) {
		$crownFramework = new CrownFramework();
	}

}