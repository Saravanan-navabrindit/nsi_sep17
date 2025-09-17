<?php
/**
 * @author         Squiz Pty Ltd <products@squiz.net>
 * @copyright      2023 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

namespace PH7\Eu\Vat;

use PH7\Eu\Vat\Provider\Providable;
use stdClass;

class Validator implements Validatable {

	/** @var integer|string */
	private $sVatNumber;

	/** @var string */
	private $sCountryCode;

	/** @var stdClass */
	private $oResponse;

	/**
	 * @param Providable     $oProvider    The API that checks the VAT no. and retrieve the VAT registration's details.
	 * @param integer|string $sVatNumber   The VAT number.
	 * @param string         $sCountryCode The country code.
	 */
	public function __construct( Providable $oProvider, $sVatNumber, string $sCountryCode) {
		$this->sVatNumber   = $sVatNumber;
		$this->sCountryCode = $sCountryCode;

		$this->sanitize();
		$this->oResponse = $oProvider->getResource($this->sVatNumber, $this->sCountryCode);
	}//end __construct()


	/**
	 * Check if the VAT number is valid or not
	 *
	 * @return boolean
	 */
	public function check(): bool {
		return (bool) $this->oResponse->valid;
	}//end check()


	public function getName(): string {
		return $this->oResponse->name ?? '';
	}//end getName()


	public function getAddress(): string {
		return $this->cleanAddress($this->oResponse->address) ?? '';
	}//end getAddress()


	public function getRequestDate(): string {
		return $this->oResponse->requestDate ?? '';
	}//end getRequestDate()


	public function getCountryCode(): string {
		return $this->oResponse->countryCode ?? '';
	}//end getCountryCode()


	public function getVatNumber(): string {
		return $this->oResponse->vatNumber ?? '';
	}//end getVatNumber()


	public function sanitize(): void {
		$aSearch            = array($this->sCountryCode, '-', '_', '.', ',', ' ');
		$this->sVatNumber   = trim(str_replace($aSearch, '', $this->sVatNumber));
		$this->sCountryCode = strtoupper($this->sCountryCode);
	}//end sanitize()


	protected function cleanAddress( string $sString): string {
		return trim(str_replace(array("\n", "\r\n"), ', ', $sString), ', ');
	}//end cleanAddress()

}//end class

