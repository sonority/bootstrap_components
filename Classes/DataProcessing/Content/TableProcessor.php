<?php

namespace Sonority\BootstrapComponents\DataProcessing\Content;

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

use Sonority\BootstrapComponents\DataProcessing\AbstractDataProcessor;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class TableProcessor extends AbstractDataProcessor
{

    /**
     * Process data for the CType "table"
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData)
    {
        $options = $this->getOptionsFromFlexFormData($processedData['data']);
        $processedData['data']['table_responsive'] = $options['responsive'];
        $options['tableClass'] = explode(',', $options['tableClass']);
        if ($options['tableClass'] > 0) {
            $processedData['data']['table_tableClass'] = implode(' ', $options['tableClass']);
        }
        return $processedData;
    }

}
