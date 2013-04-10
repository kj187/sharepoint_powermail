<?php

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

if (!defined('TYPO3_MODE')) die ('Access denied.');


//
// Add static typoscript file
//

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'Sharepoint Powermail');


//
// Change the flexform file path for formhandler
//

#t3lib_extMgm::addPiFlexFormValue('formhandler' . '_pi1', 'FILE:EXT:' . $_EXTKEY . '/Resources/Private/Xml/Flexform.xml');


//
// Extends powermail TCA
//

\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('tx_powermail_domain_model_fields');

// Add Sharepoint as powermail type

$items = array(
	array(
		'LLL:EXT:sharepoint_powermail/Resources/Private/Language/locallang_db.xlf:tx_powermail_domain_model_fields.type.spacer_sharepoint',
		'--div--'
	),
	'sharepoint' => array(
		'LLL:EXT:sharepoint_powermail/Resources/Private/Language/locallang_db.xlf:tx_powermail_domain_model_fields.type.sharepoint_attribute',
		'sharepoint'
	),
);
$TCA['tx_powermail_domain_model_fields']['columns']['type']['config']['items'] = array_merge($TCA['tx_powermail_domain_model_fields']['columns']['type']['config']['items'], $items);


// Add list and attribute selector

$newColumns = array(
	'sharepoint_list' => array(
		'l10n_mode' => 'exclude',
		'exclude' => 1,
		'label' => 'LLL:EXT:sharepoint_powermail/Resources/Private/Language/locallang_db.xlf:tx_powermail_domain_model_fields.sharepoint_list',
		'config' => array(
			'type' => 'user',
			'userFunc' => 'Aijko\\SharepointConnector\\Utility\\Tca->getAvailableMappings'
		),
		'displayCond' => 'FIELD:type:IN:sharepoint'
	),
	'sharepoint_attribute' => array(
		'l10n_mode' => 'exclude',
		'exclude' => 1,
		'label' => 'LLL:EXT:sharepoint_powermail/Resources/Private/Language/locallang_db.xlf:tx_powermail_domain_model_fields.sharepoint_attribute',
		'config' => array(
			'type' => 'user',
			'userFunc' => 'Aijko\\SharepointConnector\\Utility\\Tca->getAttributesFromMapping'
		),
		'displayCond' => 'FIELD:sharepoint_list:>:0'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_powermail_domain_model_fields', $newColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('tx_powermail_domain_model_fields', '1', 'sharepoint_list, sharepoint_attribute');


// Change behaviour

$TCA['tx_powermail_domain_model_fields']['ctrl']['requestUpdate'] .= ',sharepoint_list';
$TCA['tx_powermail_domain_model_fields']['columns']['css']['displayCond'] .= ',sharepoint';
$TCA['tx_powermail_domain_model_fields']['columns']['validation']['displayCond'] .= ',sharepoint';
$TCA['tx_powermail_domain_model_fields']['columns']['mandatory']['displayCond'] .= ',sharepoint';
















?>