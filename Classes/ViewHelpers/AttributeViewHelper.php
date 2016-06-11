<?php

namespace Sonority\BootstrapComponents\ViewHelpers;

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

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class AttributeViewHelper extends AbstractViewHelper
{

    /**
     * Render a HTML-attribute from given array
     *
     * @param $values array Values to process
     * @param $name string The name of the HTML-attribute
     * @param $useKey boolean Use the key as parameter
     * @return string
     */
    public function render($values = [], $name = 'class', $useKey = false)
    {
        $output = '';
        if (is_array($values) && count($values) > 0 && $name !== '') {
            $items = [];
            foreach ($values as $key => $value) {
                if (!empty($value)) {
                    if ($useKey && !empty($key)) {
                        $items[] = $key . ':' . $value . ';';
                    } else {
                        $items[] = $value;
                    }
                }
            }
            if (count($items) > 0) {
                $output = ' ' . $name . '="' . implode(' ', $items) . '"';
            }
        }
        return $output;
    }

}
