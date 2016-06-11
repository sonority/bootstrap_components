<?php

defined('TYPO3_MODE') or die();

// Add extra field 'display_mode' to sys_file_reference record
$newSysFileReferenceColumns = [
    'display_mode' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:bootstrap_components/Resources/Private/Language/locallang_db.xlf:sys_file_reference.display_mode',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['LLL:EXT:bootstrap_components/Resources/Private/Language/locallang_db.xlf:sys_file_reference.display_mode.I.0',
                    0],
                ['LLL:EXT:bootstrap_components/Resources/Private/Language/locallang_db.xlf:sys_file_reference.display_mode.I.1',
                    1]
            ],
            'default' => 0
        ]
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_reference', $newSysFileReferenceColumns);

// Add additional palette
$GLOBALS['TCA']['sys_file_reference']['palettes']['bootstrapPalette'] = [
    'showitem' => 'crop,display_mode',
    'canNotCollapse' => true
];
