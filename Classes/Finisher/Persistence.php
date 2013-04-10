<?php
namespace Aijko\SharepointPowermail\Finisher;

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
 * Sharepoint persistence finisher
 *
 * @package sharepoint_powermail
 */
class Persistence {

	/**
	 * @var \Aijko\SharepointConnector\Sharepoint\SharepointInterface
	 */
	protected $sharepointApi;

	/**
	 * The main method called by the controller
	 *
	 * @param array $field
	 * @param integer $form
	 * @param object $mail
	 * @param Tx_Powermail_Controller_FormsController $pObj
	 *
	 * @return string
	 */
	public function process($field, $form, $mail, $pObj) {
		$data = array();
		if (is_array($field) && count($field)>0) {
			foreach ($field as $uid => $value) {
				if (is_numeric($uid)) {
					$fieldsRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Powermail_Domain_Repository_FieldsRepository');
					$row = $fieldsRepository->findByUid($uid);

					if ('sharepoint' == $row->getType()) {
						if (NULL === $this->sharepointApi) {
							$typoscriptConfiguration = $GLOBALS['TSFE']->tmpl->setup['module.']['tx_sharepointconnector.']['settings.']['sharepointServer.'];
							$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
							$sharepointRESTApi = $objectManager->create('Aijko\\SharepointConnector\\Sharepoint\\Rest\\Sharepoint');
							$this->sharepointApi = $objectManager->create('Aijko\\SharepointConnector\\Sharepoint\\SharepointFacade', $sharepointRESTApi, $typoscriptConfiguration);
						}

						$sharepointAttribute = $this->sharepointApi->getListMappingAttributeByUid($row->getSharepointAttribute());
						$data[$row->getSharepointList()][$sharepointAttribute->getTypo3FieldName()] = $value;
					}
				}
			}

			// Store data
			$resultArray = $this->sharepointApi->addToMultipleLists($data);
			//if (!$resultArray) {
				// TODO error handling - array iteration

			//}
		}
	}
}

?>