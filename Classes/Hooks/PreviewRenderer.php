<?php

namespace Sonority\BootstrapComponents\Hooks;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Core\Utility\CsvUtility;

/**
 * Contains a preview rendering for the page module of CType="table"
 */
class PreviewRenderer implements PageLayoutViewDrawItemHookInterface
{

    /**
     * Preprocesses the preview rendering of a content element of type "table"
     *
     * @param \TYPO3\CMS\Backend\View\PageLayoutView $parentObject Calling parent object
     * @param bool $drawItem Whether to draw the item using the default functionality
     * @param string $headerContent Header content
     * @param string $itemContent Item content
     * @param array $row Record row of tt_content
     *
     * @return void
     */
    public function preProcess(PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row)
    {
        if ($row['CType'] === 'table') {
            if ($row['table_content']) {
                $fieldDelimiter = $row['table_delimiter'] ? chr($row['table_delimiter']) : ',';
                $fieldEnclosure = $row['table_enclosure'] ? chr($row['table_enclosure']) : '"';
                $maximumColumns = $row['cols'] ? $row['cols'] : 0;
                $tableData = CsvUtility::csvToArray(
                        $row['table_content'], $fieldDelimiter, $fieldEnclosure, (int) $maximumColumns
                );
                $linkedContent = '';
                if ($tableData > 0) {
                    $tableRows = '';
                    foreach ($tableData as $tableRow) {
                        if ($tableRow > 0) {
                            $tableColumns = '';
                            foreach ($tableRow as $tableColumn) {
                                $tableColumns .= '<td>' . $tableColumn . '</td>';
                            }
                            $tableRows .= '<tr>' . $tableColumns . '</tr>';
                        }
                    }
                    $linkedContent = '<table class="table table-striped table-bordered">' . $tableRows . '</table>';
                }
                $itemContent .= $parentObject->linkEditContent($linkedContent, $row);
            }
        }
    }

}
