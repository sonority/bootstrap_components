<?php

namespace Sonority\BootstrapComponents\DataProcessing;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

abstract class AbstractDataProcessor implements DataProcessorInterface
{

    /**
     * Process content object data
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData)
    {
        return $processedData;
    }

    /**
     * Extract flexform-values from database-records
     *
     * @param array $row
     * @return array
     */
    protected function getOptionsFromFlexFormData($row = [])
    {
        $options = [];
        if (!is_array($row['pi_flexform'])) {
            $flexFormAsArray = GeneralUtility::xml2array($row['pi_flexform']);
        } else {
            $flexFormAsArray = $row['pi_flexform'];
        }
        if (!empty($flexFormAsArray['data']) && is_array($flexFormAsArray['data'])) {
            foreach ($flexFormAsArray['data'] as $flexFormSheet) {
                if (!empty($flexFormSheet['lDEF']) && is_array($flexFormSheet['lDEF'])) {
                    foreach ($flexFormSheet['lDEF'] as $optionKey => $optionValue) {
                        $optionParts = explode('.', $optionKey);
                        $options[array_pop($optionParts)] = $optionValue['vDEF'] === '1' ? true : $optionValue['vDEF'];
                    }
                }
            }
        }
        return $options;
    }

}
