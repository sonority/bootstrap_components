<?php

namespace Sonority\BootstrapComponents\Backend;

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

/**
 * Class/Function which manipulates the item-array for backend-fields
 *
 * @author Stephan Kellermayr <stephan.kellermayr@gmail.com>
 * @package TYPO3
 * @subpackage bootstrap_components
 */
class ItemsProcFunc
{

    /**
     * ItemProcFunc for layout_style-items
     *
     * @param array $params An array containing the items and parameters for the list of items
     * @return void
     */
    public function layoutStyleItems(&$params)
    {
        return $this->prepareItems($params, 'layout');
    }

    /**
     * ItemProcFunc for section_frame-items
     *
     * @param array $params An array containing the items and parameters for the list of items
     * @return void
     */
    public function sectionFrameStyleItems(&$params)
    {
        return $this->prepareItems($params, 'section_frame');
    }

    /**
     * Generate items-array
     *
     * @param array $params An array containing the items and parameters for the list of items
     * @param array $parentField The field to process
     * @return array
     */
    function prepareItems($params = [], $parentField = '')
    {
        $newItems = [];
        $items = $params['items'];
        foreach ($items as $item) {
            $item[1] = explode('-', $item[1]);
            if ($params['row'][$parentField][0] === $item[1][0]) {
                $newItems[] = [$item[0], $item[1][1], $item[2]];
            }
        }
        $params['items'] = $newItems;
        return;
    }

}
