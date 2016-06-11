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
use TYPO3\CMS\Frontend\Resource\FileCollector;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Service\ImageService;

/**
 * This data processor can be used for processing data for record which contain
 * relations to sys_file records (e.g. sys_file_reference records) or for fetching
 * files directly from UIDs or from folders or collections.
 *
 *
 * Example TypoScript configuration:
 *
 * 10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
 * 10 {
 *   references.fieldName = image
 *   collections = 13,15
 *   as = myfiles
 * }
 *
 * whereas "myfiles" can further be used as a variable {myfiles} inside a Fluid template for iteration.
 */
class FilesProcessor implements DataProcessorInterface
{

    /**
     * Process data of a record to resolve File objects to the view
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

        // gather data
        /** @var FileCollector $fileCollector */
        $fileCollector = GeneralUtility::makeInstance(FileCollector::class);

        $settings = $contentObjectConfiguration['settings.']['display_mode.'];
        // references / relations
        if (!empty($processorConfiguration['references.'])) {
            $referenceConfiguration = $processorConfiguration['references.'];
            $relationField = $cObj->stdWrapValue('fieldName', $referenceConfiguration);

            // If no reference fieldName is set, there's nothing to do
            if (!empty($relationField)) {
                // Fetch the references of the default element
                $relationTable = $cObj->stdWrapValue('table', $referenceConfiguration, $cObj->getCurrentTable());
                if (!empty($relationTable)) {
                    $fileCollector->addFilesFromRelation($relationTable, $relationField, $cObj->data);
                }
            }
        }
        // Get files from database-record
        $files = $fileCollector->getFiles();
        if (count($files) > 0) {
            // Use ImageService for further processing
            $imageService = self::getImageService();
            foreach ($files as $file) {
                $displayMode = $file->getReferenceProperty('display_mode');
                $image = $imageService->getImage(null, $file, true);
                $processingInstructions = ['crop' => $image->getProperty('crop')];
                $maxWidth = intval($contentObjectConfiguration['settings.']['display_mode_maxWidth.'][$displayMode]);
                if ($maxWidth > 0) {
                    $processingInstructions['maxWidth'] = $maxWidth;
                }
                $processedImage = $imageService->applyProcessingInstructions($image, $processingInstructions);
                $styleAttribute = 'background-image:url(\'' . $imageService->getImageUri($processedImage) . '\');';
                switch ($displayMode) {
                    case '1':
                        $targetVariableName = 'layoutMedia';
                        break;
                    default:
                        $targetVariableName = 'backgroundMedia';
                        break;
                }
                $processedData[$targetVariableName]['fileReference'] = $file;
                $processedData[$targetVariableName]['class'] = $settings[$displayMode];
                $processedData[$targetVariableName]['style'] = $styleAttribute;
            }
        }
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($files, '$files');
        return $processedData;
    }

    /**
     * Return an instance of ImageService using object manager
     *
     * @return ImageService
     */
    protected static function getImageService()
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        return $objectManager->get(ImageService::class);
    }

}
