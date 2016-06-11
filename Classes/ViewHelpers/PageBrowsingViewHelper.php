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

use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * Page browser for indexed search, and only useful here, as the regular pagebrowser
 * so this is a cleaner "pi_browsebox" but not a real page browser functionality
 * @internal
 */
class PageBrowsingViewHelper extends \TYPO3\CMS\IndexedSearch\ViewHelpers\PageBrowsingViewHelper
{

    /**
     * @param array $arguments
     * @param callable $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $maximumNumberOfResultPages = $arguments['maximumNumberOfResultPages'];
        $numberOfResults = $arguments['numberOfResults'];
        $resultsPerPage = $arguments['resultsPerPage'];
        $currentPage = $arguments['currentPage'];
        $freeIndexUid = $arguments['freeIndexUid'];

        if ($resultsPerPage <= 0) {
            $resultsPerPage = 10;
        }
        $pageCount = (int) ceil($numberOfResults / $resultsPerPage);
        // Only show the result browser if more than one page is needed
        if ($pageCount === 1) {
            return '';
        }

        // Check if $currentPage is in range
        $currentPage = MathUtility::forceIntegerInRange($currentPage, 0, $pageCount - 1);

        $content = '';
        // Prev page
        // Show on all pages after the 1st one
        if ($currentPage > 0) {
            $label = LocalizationUtility::translate('displayResults.previous', 'IndexedSearch');
            $content .= '<li>' . self::makecurrentPageSelector_link($label, $currentPage - 1, $freeIndexUid) . '</li>';
        }
        // Check if $maximumNumberOfResultPages is in range
        $maximumNumberOfResultPages = MathUtility::forceIntegerInRange($maximumNumberOfResultPages, 1, $pageCount, 10);
        // Assume $currentPage is in the middle and calculate the index limits of the result page listing
        $minPage = $currentPage - (int) floor($maximumNumberOfResultPages / 2);
        $maxPage = $minPage + $maximumNumberOfResultPages - 1;
        // Check if the indexes are within the page limits
        if ($minPage < 0) {
            $maxPage -= $minPage;
            $minPage = 0;
        } elseif ($maxPage >= $pageCount) {
            $minPage -= $maxPage - $pageCount + 1;
            $maxPage = $pageCount - 1;
        }
        for ($a = $minPage; $a <= $maxPage; $a++) {
            $label = $a + 1;
            $label = self::makecurrentPageSelector_link($label, $a, $freeIndexUid);
            if ($a === $currentPage) {
                $content .= '<li class="active">' . $label . '</li>';
            } else {
                $content .= '<li>' . $label . '</li>';
            }
        }
        // Next link
        if ($currentPage < $pageCount - 1) {
            $label = LocalizationUtility::translate('displayResults.next', 'IndexedSearch');
            $content .= '<li>' . self::makecurrentPageSelector_link($label, ($currentPage + 1), $freeIndexUid) . '</li>';
        }
        return '<ul class="pagination">' . $content . '</ul>';
    }

}
