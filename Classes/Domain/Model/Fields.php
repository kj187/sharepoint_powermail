<?php
namespace Aijko\SharepointPowermail\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Julian Kleinhans <julian.kleinhans@aijko.de>, aijko GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 * Extends the original fields model
 *
 * @package sharepoint_powermail
 */
class Fields extends \Tx_Powermail_Domain_Model_Fields {

	/**
	 * @var int
	 */
	protected $sharepointList = '';

	/**
	 * @var int
	 */
	protected $sharepointAttribute = '';

	/**
	 * @param int $sharepointAttribute
	 */
	public function setSharepointAttribute($sharepointAttribute) {
		$this->sharepointAttribute = $sharepointAttribute;
	}

	/**
	 * @return int
	 */
	public function getSharepointAttribute() {
		return $this->sharepointAttribute;
	}

	/**
	 * @param int $sharepointList
	 */
	public function setSharepointList($sharepointList) {
		$this->sharepointList = $sharepointList;
	}

	/**
	 * @return int
	 */
	public function getSharepointList() {
		return $this->sharepointList;
	}

}

?>