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

class FormatStringViewHelper extends AbstractViewHelper
{

    /**
     * Transform a given string for use as ID-value in HTML
     *
     * @param $title string The string to transform
     * @return string
     */
    public function render($title = '')
    {
        // Fetch character set
        $charset = $GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'] ? $GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'] : $GLOBALS['TSFE']->defaultCharSet;
        // Convert to lowercase
        $processedTitle = $GLOBALS['TSFE']->csConvObj->conv_case($charset, $title, 'toLower');
        // Strip tags
        $processedTitle = strip_tags($processedTitle);
        // Convert some special tokens to the delimiter character
        $delimiter = '-';
        // Convert spaces to the delimiter character
        $processedTitle = preg_replace('/[ \-+_]+/', $delimiter, $processedTitle);
        // Convert extended letters to ascii equivalents
        $processedTitle = $GLOBALS['TSFE']->csConvObj->specCharsToASCII($charset, $processedTitle);
        // Convert all other characters (except numbers & letters) to the delimiter character
        $processedTitle = preg_replace('/[^a-zA-Z0-9' . ($delimiter ? preg_quote($delimiter) : '') . ']/', '', $processedTitle);
        // Strip multiple delimiter characters
        $processedTitle = preg_replace('/\\' . $delimiter . '{2,}/', $delimiter, $processedTitle);
        return trim($processedTitle, $delimiter);
    }

}
