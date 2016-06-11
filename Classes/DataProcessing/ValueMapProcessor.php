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

class ValueMapProcessor extends AbstractDataProcessor
{

    /**
     * Preprocess fields from database-record for use in fluid-templates
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData)
    {
        if (isset($processorConfiguration['if.']) && !$cObj->checkIf($processorConfiguration['if.'])) {
            return $processedData;
        }
        // The field name to process
        $fieldName = $cObj->stdWrapValue('fieldName', $processorConfiguration);
        if (empty($fieldName)) {
            return $processedData;
        }
        // Set the target variable
        $defaultTargetName = GeneralUtility::underscoredToLowerCamelCase($fieldName);
        $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration, $defaultTargetName);
        // Let's see if we got a parentField from which the values should be retrieved
        $parentField = $cObj->stdWrapValue('parentField', $processorConfiguration);
        // Get settings from TypoScript
        if (!empty($parentField)) {
            $settings = $contentObjectConfiguration['settings.'][$fieldName . '.'][$cObj->data[$parentField] . '.'];
        } else {
            $settings = $contentObjectConfiguration['settings.'][$fieldName . '.'];
        }
        // Get value database
        $fieldValue = $cObj->data[$fieldName];
        // Fill output with value from TypoScript
        if (!empty($fieldValue)) {
            // Use the value defined in database
            $output = $settings[$fieldValue];
        } else if ($settings['default'] !== '' && $settings[$settings['default']] !== '') {
            // Use default value (if set)
            $output = $settings[$settings['default']];
        } else {
            $output = '';
        }
        $processedData[$targetVariableName] = $output;
        return $processedData;
    }

}
