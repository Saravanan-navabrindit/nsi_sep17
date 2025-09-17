<?php
/**
 * Manual Autoloader File (if composer isn't installed)
 *
 * @author         Squiz Pty Ltd <products@squiz.net>
 * @copyright      2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

namespace PH7\Eu;

// Autoloading Classes Files
spl_autoload_register(function ( $sClass) {
	// Hack to remove namespace and backslash
	$sClass = str_replace(array(__NAMESPACE__ . '\\', '\\'), DIRECTORY_SEPARATOR, $sClass);

	// Get library classes
	if (is_file(__DIR__ . $sClass . '.php')) {
		require_once __DIR__ . $sClass . '.php';
	}
});
