<?php
/**
 * @author         Squiz Pty Ltd <products@squiz.net>
 * @copyright      2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

namespace PH7\Eu\Vat\Provider;

use stdClass;

interface Providable {

	public function getApiUrl(): string;

	public function getResource( $sVatNumber, string $sCountryCode): stdClass;
}//end interface

