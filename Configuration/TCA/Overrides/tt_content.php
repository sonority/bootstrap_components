<?php

defined('TYPO3_MODE') or die();

call_user_func(
    function ($extKey) {

    $fieldLanguageFilePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_db.xlf:';
    $backendLanguageFilePrefix = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:';

    // Define field(s)
    $additionalColumns = [
        'table_content' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:field.table.bodytext',
            'config' => [
                'type' => 'text',
                'cols' => '80',
                'rows' => '15',
                'wizards' => [
                    'table' => [
                        'notNewRecords' => 1,
                        'type' => 'script',
                        'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext.W.table',
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_table.gif',
                        'module' => [
                            'name' => 'wizard_table'
                        ],
                        'params' => [
                            'xmlOutput' => 0
                        ]
                    ]
                ]
            ]
        ],
        'header_position' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_position',
            'exclude' => true,
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value',
                        0],
                    ['LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_position.I.1',
                        1],
                    ['LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_position.I.2',
                        2],
                    ['LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_position.I.3',
                        3],
                    [$fieldLanguageFilePrefix . 'shared.notset',
                        100]
                ],
                'default' => 0
            ]
        ],
        'header_style' => [
            'label' => $fieldLanguageFilePrefix . 'tt_content.header_style',
            'exclude' => true,
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value',
                        0],
                    [$fieldLanguageFilePrefix . 'tt_content.header_style.I.1',
                        1],
                    [$fieldLanguageFilePrefix . 'tt_content.header_style.I.2',
                        2],
                    [$fieldLanguageFilePrefix . 'tt_content.header_style.I.3',
                        3],
                    [$fieldLanguageFilePrefix . 'tt_content.header_style.I.4',
                        4],
                    [$fieldLanguageFilePrefix . 'tt_content.header_style.I.5',
                        5],
                    [$fieldLanguageFilePrefix . 'tt_content.header_style.I.6',
                        6],
                    [$fieldLanguageFilePrefix . 'shared.nostyle',
                        100]
                ],
                'default' => 0
            ]
        ],
        'header_icon' => [
            'label' => $fieldLanguageFilePrefix . 'tt_content.header_icon',
            'exclude' => true,
            'config' => [
                'type' => 'input',
                'size' => 12,
                'eval' => ''
            ]
        ],
        'visibility' => [
            'exclude' => true,
            'label' => $fieldLanguageFilePrefix . 'tt_content.visibility',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value',
                        0],
                    [$fieldLanguageFilePrefix . 'tt_content.visibility.visible.xs',
                        1],
                    [$fieldLanguageFilePrefix . 'tt_content.visibility.visible.sm-xs',
                        2],
                    [$fieldLanguageFilePrefix . 'tt_content.visibility.visible.md-lg',
                        3],
                    [$fieldLanguageFilePrefix . 'tt_content.visibility.visible.lg',
                        4],
                    [$fieldLanguageFilePrefix . 'tt_content.visibility.hidden.xs',
                        5],
                    [$fieldLanguageFilePrefix . 'tt_content.visibility.hidden.sm-xs',
                        6],
                    [$fieldLanguageFilePrefix . 'tt_content.visibility.hidden.md-lg',
                        7],
                    [$fieldLanguageFilePrefix . 'tt_content.visibility.hidden.lg',
                        8],
                    [$fieldLanguageFilePrefix . 'shared.notset',
                        100]
                ]
            ]
        ],
        'image_shape' => [
            'exclude' => true,
            'label' => $fieldLanguageFilePrefix . 'tt_content.image_shape',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value',
                        0],
                    [$fieldLanguageFilePrefix . 'tt_content.image_shape.I.1',
                        1],
                    [$fieldLanguageFilePrefix . 'tt_content.image_shape.I.2',
                        2],
                    [$fieldLanguageFilePrefix . 'tt_content.image_shape.I.3',
                        3],
                    [$fieldLanguageFilePrefix . 'shared.notset',
                        100]
                ]
            ]
        ],
        'image_responsive' => [
            'exclude' => true,
            'label' => $fieldLanguageFilePrefix . 'tt_content.image_responsive',
            'config' => [
                'type' => 'check',
                'default' => 1,
                'items' => [
                    ['LLL:EXT:lang/locallang_core.xml:labels.enabled', 1]
                ]
            ]
        ],
        'gallery_width' => [
            'label' => $fieldLanguageFilePrefix . 'tt_content.gallery_width',
            'exclude' => true,
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                // TODO: Make items dynamic (according to the available amount of grid columns)
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value',
                        0],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_width.I.1',
                        1],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_width.I.2',
                        2],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_width.I.3',
                        3],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_width.I.4',
                        4],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_width.I.5',
                        5],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_width.I.6',
                        6],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_width.I.7',
                        7],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_width.I.8',
                        8],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_width.I.9',
                        9],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_width.I.10',
                        10]
                ],
                'default' => 0
            ]
        ],
        'gallery_break' => [
            'exclude' => true,
            'label' => $fieldLanguageFilePrefix . 'tt_content.gallery_break',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value',
                        0],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_break.I.1',
                        1],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_break.I.2',
                        2],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_break.I.3',
                        3],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_break.I.4',
                        4],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_break.I.5',
                        5]
                ],
                'default' => 0
            ]
        ],
        'gallery_carousel' => [
            'exclude' => true,
            'label' => $fieldLanguageFilePrefix . 'tt_content.gallery_carousel',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:lang/locallang_common.xlf:disabled',
                        0],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_carousel.I.1',
                        1],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_carousel.I.2',
                        2],
                    [$fieldLanguageFilePrefix . 'tt_content.gallery_carousel.I.3',
                        3]
                ]
            ]
        ],
        'layout_style' => [
            'exclude' => true,
            'displayCond' => 'FIELD:layout:>:0',
            'label' => $fieldLanguageFilePrefix . 'tt_content.layout_style',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'disableNoMatchingValueElement' => true,
                'itemsProcFunc' => 'Sonority\BootstrapComponents\Backend\ItemsProcFunc->layoutStyleItems',
            ]
        ],
        'wrap' => [
            'exclude' => true,
            // Display only if the contentelement is NOT inside a gridelements-container
            // TODO: Allow this option only if Backend-Layout 3 was selected
            /* 'displayCond' => [
              'OR' => [
              'FIELD:tx_gridelements_container:=:0',
              'FIELD:tx_gridelements_container:=:',
              //'USER:NAMESPACE\\Classes\\User\\ElementConditionMatcher->checkHeaderGiven'
              ]
              ], */
            'label' => $fieldLanguageFilePrefix . 'tt_content.wrap',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value',
                        0],
                    [$fieldLanguageFilePrefix . 'tt_content.wrap.I.1',
                        1],
                    [$fieldLanguageFilePrefix . 'tt_content.wrap.I.2',
                        2],
                    [$fieldLanguageFilePrefix . 'tt_content.wrap.I.3',
                        3],
                    [$fieldLanguageFilePrefix . 'tt_content.wrap.I.4',
                        4],
                    [$fieldLanguageFilePrefix . 'shared.notset',
                        100],
                ],
                'default' => 0,
            ]
        ],
        'container' => [
            'exclude' => true,
            'label' => $fieldLanguageFilePrefix . 'tt_content.container',
            'config' => [
                'type' => 'check',
                'default' => 1,
                'items' => [
                    ['LLL:EXT:lang/locallang_core.xml:labels.enabled', 1]
                ]
            ]
        ],
        'section_frame' => [
            'label' => $fieldLanguageFilePrefix . 'tt_content.section_frame',
            'exclude' => true,
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value',
                        0],
                    [$fieldLanguageFilePrefix . 'tt_content.section_frame.I.1',
                        1],
                    [$fieldLanguageFilePrefix . 'tt_content.section_frame.I.2',
                        2],
                    [$fieldLanguageFilePrefix . 'tt_content.section_frame.I.3',
                        3],
                    [$fieldLanguageFilePrefix . 'tt_content.section_frame.I.4',
                        4],
                    [$fieldLanguageFilePrefix . 'tt_content.section_frame.I.5',
                        5],
                    [$fieldLanguageFilePrefix . 'tt_content.section_frame.I.6',
                        6]
                ],
                'default' => 0
            ]
        ],
        'section_frame_style' => [
            'exclude' => true,
            'displayCond' => 'FIELD:section_frame:>:0',
            'label' => $fieldLanguageFilePrefix . 'tt_content.section_frame_style',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'disableNoMatchingValueElement' => true,
                'itemsProcFunc' => 'Sonority\BootstrapComponents\Backend\ItemsProcFunc->sectionFrameStyleItems',
            ]
        ],
        'template_media' => [
            'label' => $fieldLanguageFilePrefix . 'tt_content.template_media',
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'template_media',
                [
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                    'headerThumbnail' => [
                        'width' => '25',
                        'height' => '25c'
                    ]
                ],
                // Custom configuration for displaying fields in the overlay/reference table
                'foreign_types' => [
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                        'showitem' => '
                            --palette--;Einstellungen;bootstrapPalette,
                            --palette--;;filePalette'
                    ]
                ]
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
                //$GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext']
            )
        ]
    ];

    $GLOBALS['TCA']['tt_content']['columns']['imageorient']['config']['selicon_cols'] = 4;

    /*
     *  Set custom flexform for tt_content CType "table"
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('*',
        'FILE:EXT:' . $extKey . '/Configuration/FlexForms/Table.xml', 'table');
    // Add flexform-fields to CType "table"
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
        'tt_content', 'tablelayout', '--linebreak--, pi_flexform'
    );
    // (Re)enable RTE for field "bodytext" in CType "table"
    $GLOBALS['TCA']['tt_content']['types']['table']['columnsOverrides']['bodytext'] = ['defaultExtras' => 'richtext:rte_transform[mode=ts_css]'];
    $GLOBALS['TCA']['tt_content']['ctrl']['searchFields'] .= ',table_content';
    //$GLOBALS['TCA']['tt_content']['ctrl']['label_alt'] .= ',table_content';
    //$GLOBALS['TCA']['tt_content']['interface']['showRecordFieldList'] .= ',table_content';
    // Remove table-wizard from field "bodytext"
    unset($GLOBALS['TCA']['tt_content']['columns']['bodytext']['config']['wizards']['table']);
    // Reset title for field "bodytext"
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content', 'bodytext;LLL:EXT:lang/locallang_general.xlf:LGL.text', 'table', 'replace:bodytext'
    );
    // Add new field for table-content
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content', '--linebreak--, table_content', 'table', 'after:bodytext'
    );

    /*
     *  Modifications for dynamic 'layout_style'-field
     */
    $GLOBALS['TCA']['tt_content']['ctrl']['requestUpdate'] .= ',layout';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content', 'layout_style', '', 'after:layout'
    );

    /*
     *  Add custom fields
     */
    // Readd the field 'assets' to all content-elements and let the fluid-template decide what should happen with the mediafile
    $anchor = ':tabs.appearance,';
    foreach ($GLOBALS['TCA']['tt_content']['types'] as $fieldName => $fieldConfig) {
        // Iterate through existing fields and add a new palette right after tab "Appearance" to all content-elements
        $replacement = $anchor . '--palette--;' . $backendLanguageFilePrefix . 'tt_content.palette.displaySettings;displaySettings,';
        $GLOBALS['TCA']['tt_content']['types'][$fieldName]['showitem'] = str_replace($anchor, $replacement,
            $fieldConfig['showitem']);
    }
    // Add custom fields to the backend-forms
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('tt_content', 'displaySettings',
        'visibility;' . $fieldLanguageFilePrefix . 'tt_content.visibility,' .
        'wrap;' . $fieldLanguageFilePrefix . 'tt_content.wrap,' .
        'container;' . $fieldLanguageFilePrefix . 'tt_content.container,' .
        'section_frame;' . $fieldLanguageFilePrefix . 'tt_content.section_frame,' .
        'section_frame_style;' . $fieldLanguageFilePrefix . 'tt_content.section_frame_style,' .
        '--linebreak--,template_media;' . $fieldLanguageFilePrefix . 'tt_content.template_media'
    );
    $GLOBALS['TCA']['tt_content']['ctrl']['requestUpdate'] .= ',section_frame';

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('tt_content', 'mediaAdjustments',
        'image_shape;' . $fieldLanguageFilePrefix . 'tt_content.image_shape,' .
        'image_responsive;' . $fieldLanguageFilePrefix . 'tt_content.image_responsive'
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
        'tt_content', 'gallerySettings',
        'gallery_width;' . $fieldLanguageFilePrefix . 'tt_content.gallery_width,' .
        'gallery_break;' . $fieldLanguageFilePrefix . 'tt_content.gallery_break,' .
        'gallery_carousel;' . $fieldLanguageFilePrefix . 'tt_content.gallery_carousel'
    );

    // Add custom fields to TCA
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content',
        'header_layout,header_position,header_style,header_icon', '', 'replace:header_layout');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $additionalColumns, 1);
}, 'bootstrap_components'
);
