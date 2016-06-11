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

class VariableObjectViewHelper extends AbstractViewHelper
{

    /**
     * Grab specific elements from given data-array
     * by concatenating the key from array-variables
     *
     * @param $data array The parent object
     * @param $keys array The array of keys to be concatenated
     * @return mixed
     */
    public function render($data = [], $keys = [])
    {
        $key = '';
        if (is_array($data) && count($keys) > 0) {
            foreach ($keys as $keyPart) {
                $key .= $keyPart;
            }
            if (!empty($key) && !empty($data[$key])) {
                return $data[$key];
            }
        }
        return null;
    }

}
