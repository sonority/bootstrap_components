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
use TYPO3\CMS\Frontend\ContentObject\Exception\ContentRenderingException;

/**
 * This data processor will calculate rows, columns and dimensions for a gallery
 * based on several settings and can be used for f.i. the CType "textmedia"
 *
 * The output will be an array which contains the rows and columns,
 * including the file references and the calculated width and height for each media element,
 * but also some more information of the gallery, like position, width and counters
 *
 * Example TypoScript configuration:
 *
 * 10 = TYPO3\CMS\Frontend\DataProcessing\GalleryProcessor
 * 10 {
 *   filesProcessedDataKey = files
 *   mediaOrientation.field = imageorient
 *   numberOfColumns.field = imagecols
 *   equalMediaHeight.field = imageheight
 *   equalMediaWidth.field = imagewidth
 *   columnSpacing = 0
 *   borderEnabled.field = imageborder
 *   borderPadding = 0
 *   borderWidth = 0
 *   maxGalleryWidth = {$styles.content.mediatext.maxW}
 *   maxGalleryWidthInText = {$styles.content.mediatext.maxWInText}
 *   headerAboveContent = 0, 1, 2, 8, 9, 10, 17, 18
 *   alleryAboveContent = 0, 1, 2, 17, 18, 26
 *   as = gallery
 * }
 *
 * Output example:
 *
 * gallery {
 *   position {
 *     horizontal = center
 *     vertical = above
 *     noWrap = FALSE
 *     wrap = nowrap
 *   }
 *   width = 600
 *   count {
 *     files = 2
 *     columns = 1
 *     rows = 2
 *   }
 *   rows {
 *     1 {
 *       columns {
 *         1 {
 *           media = TYPO3\CMS\Core\Resource\FileReference
 *           dimensions {
 *             width = 600
 *             height = 400
 *           }
 *         }
 *       }
 *     }
 *     2 {
 *       columns {
 *         1 {
 *           media = TYPO3\CMS\Core\Resource\FileReference
 *           dimensions {
 *             width = 600
 *             height = 400
 *           }
 *         }
 *       }
 *     }
 *   }
 *   columnSpacing = 0
 *   border {
 *     enabled = FALSE
 *     width = 0
 *     padding = 0
 *   }
 *   headerAboveContent = TRUE
 *   galleryAboveContent = TRUE
 *   columnClass = col-xs-12
 *   galleryClass = col-xs-5 col-sm-4
 *   contentClass = col-xs-7 col-sm-8
 * }
 *
 */
class GalleryProcessor extends \TYPO3\CMS\Frontend\DataProcessing\GalleryProcessor
{

    /**
     * @var int
     */
    protected $galleryCarousel;

    /**
     * @var int
     */
    protected $gridColumns;

    /**
     * @var int
     */
    protected $galleryResponsiveMinWidth;

    /**
     * @var int
     */
    protected $galleryWidth;

    /**
     * @var string
     */
    protected $columnClass;

    /**
     * @var string
     */
    protected $galleryGridClass;

    /**
     * @var int
     */
    protected $defaultGalleryWidth;

    /**
     * @var string
     */
    protected $headerAboveContent;

    /**
     * @var string
     */
    protected $galleryAboveContent;

    /**
     * Process data for a gallery, for instance the CType "textmedia"
     *
     * @param ContentObjectRenderer $cObj The content object renderer, which contains data of the content element
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     * @throws ContentRenderingException
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        if (isset($processorConfiguration['if.']) && !$cObj->checkIf($processorConfiguration['if.'])) {
            return $processedData;
        }

        $this->contentObjectRenderer = $cObj;
        $this->processorConfiguration = $processorConfiguration;

        $filesProcessedDataKey = (string) $cObj->stdWrapValue(
            'filesProcessedDataKey',
            $processorConfiguration,
            'files'
        );
        if (isset($processedData[$filesProcessedDataKey]) && is_array($processedData[$filesProcessedDataKey])) {
            $this->fileObjects = $processedData[$filesProcessedDataKey];
            $this->galleryData['count']['files'] = count($this->fileObjects);
        } else {
            throw new ContentRenderingException('No files found for key ' . $filesProcessedDataKey . ' in $processedData.', 1436809789);
        }

        // If carousel is enabled, there is only one column in use
        $this->galleryCarousel = (int) $cObj->data['gallery_carousel'];
        $this->numberOfColumns = (empty($this->galleryCarousel) ? (int) $this->getConfigurationValue('numberOfColumns', 'imagecols') : 1);
        $this->mediaOrientation = (int) $this->getConfigurationValue('mediaOrientation', 'imageorient');
        $this->maxGalleryWidth = (int) $this->getConfigurationValue('maxGalleryWidth') ? : 1140;
        $this->maxGalleryWidthInText = (int) $this->getConfigurationValue('maxGalleryWidthInText') ? : 737;
        $this->equalMediaHeight = (int) $this->getConfigurationValue('equalMediaHeight', 'imageheight');
        $this->equalMediaWidth = (int) $this->getConfigurationValue('equalMediaWidth', 'imagewidth');
        $this->columnSpacing = (int) $this->getConfigurationValue('columnSpacing');
        $this->borderEnabled = (bool) $this->getConfigurationValue('borderEnabled', 'imageborder');
        $this->borderWidth = (int) $this->getConfigurationValue('borderWidth');
        $this->borderPadding = (int) $this->getConfigurationValue('borderPadding');

        $this->gridColumns = (int) $this->getConfigurationValue('gridColumns') ? : 12;
        $this->galleryResponsiveMinWidth = (int) $this->getConfigurationValue('galleryResponsiveMinWidth') ? : 737;
        $this->galleryWidth = (int) $this->getConfigurationValue('galleryWidth', 'gallery_width');
        $this->columnClass = $this->getConfigurationValue('columnClass') ? : 'col-xs-(0)';
        $this->galleryGridClass = $this->getGalleryGridClass($cObj->data['gallery_break'],
            $contentObjectConfiguration['settings.']['gallery_break.']);
        $this->defaultGalleryWidth = (int) $this->getConfigurationValue('defaultGalleryWidth') ? : 4;
        $this->headerAboveContent = (int) $this->getConfigurationValue('headerAboveContent') ? : '0, 1, 2, 8, 9, 10, 17, 18';
        $this->galleryAboveContent = (int) $this->getConfigurationValue('galleryAboveContent') ? : '0, 1, 2, 17, 18, 26';

        $this->determineGalleryPosition();
        $this->determineMaximumGalleryWidth();
        $this->determineRelationsToContent();

        $this->calculateRowsAndColumns();
        $this->calculateMediaWidthsAndHeights();

        $this->prepareGalleryData();
        $this->extendGalleryData();

        $targetFieldName = (string) $cObj->stdWrapValue(
            'as',
            $processorConfiguration,
            'gallery'
        );

        $processedData[$targetFieldName] = $this->galleryData;

        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->galleryData, '$this->galleryData');
        return $processedData;
    }


    /**
     * Calculate the width/height of the media elements
     *
     * Based on the width of the gallery, defined equal width or height by a user, the spacing between columns and
     * the use of a border, defined by user, where the border width and padding are taken into account
     *
     * File objects MUST already be filtered. They need a height and width to be shown in the gallery
     *
     * @return void
     */
    protected function calculateMediaWidthsAndHeights()
    {
        $columnSpacingTotal = ($this->galleryData['count']['columns'] - 1) * $this->columnSpacing;

        $galleryWidthMinusBorderAndSpacing = max($this->galleryData['width'] - $columnSpacingTotal, 1);

        if ($this->borderEnabled) {
            $borderPaddingTotal = ($this->galleryData['count']['columns'] * 2) * $this->borderPadding;
            $borderWidthTotal = ($this->galleryData['count']['columns'] * 2) * $this->borderWidth;
            $galleryWidthMinusBorderAndSpacing = $galleryWidthMinusBorderAndSpacing - $borderPaddingTotal - $borderWidthTotal;
        }

        // User entered a predefined height
        if ($this->equalMediaHeight) {
            $mediaScalingCorrection = 1;
            $maximumRowWidth = 0;

            // Calculate the scaling correction when the total of media elements is wider than the gallery width
            for ($row = 1; $row <= $this->galleryData['count']['rows']; $row++) {
                $totalRowWidth = 0;
                for ($column = 1; $column <= $this->galleryData['count']['columns']; $column++) {
                    $fileKey = (($row - 1) * $this->galleryData['count']['columns']) + $column - 1;
                    if ($fileKey > $this->galleryData['count']['files'] - 1) {
                        break 2;
                    }
                    $currentMediaScaling = $this->equalMediaHeight / max($this->getCroppedDimensionalProperty($this->fileObjects[$fileKey], 'height'), 1);
                    $totalRowWidth += $this->getCroppedDimensionalProperty($this->fileObjects[$fileKey], 'width') * $currentMediaScaling;
                }
                $maximumRowWidth = max($totalRowWidth, $maximumRowWidth);
                $mediaInRowScaling = $totalRowWidth / $galleryWidthMinusBorderAndSpacing;
                $mediaScalingCorrection = max($mediaInRowScaling, $mediaScalingCorrection);
            }

            // Set the corrected dimensions for each media element
            foreach ($this->fileObjects as $key => $fileObject) {
                $mediaHeight = floor($this->equalMediaHeight / $mediaScalingCorrection);
                $mediaWidth = floor(
                    $this->getCroppedDimensionalProperty($fileObject, 'width') * ($mediaHeight / max($this->getCroppedDimensionalProperty($fileObject, 'height'), 1))
                );
                $this->mediaDimensions[$key] = [
                    'width' => $mediaWidth,
                    'height' => $mediaHeight
                ];
            }

            // Recalculate gallery width
            $this->galleryData['width'] = floor($maximumRowWidth / $mediaScalingCorrection);

        // User entered a predefined width
        } elseif ($this->equalMediaWidth) {
            $mediaScalingCorrection = 1;

            // Calculate the scaling correction when the total of media elements is wider than the gallery width
            $totalRowWidth = $this->galleryData['count']['columns'] * $this->equalMediaWidth;
            $mediaInRowScaling = $totalRowWidth / $galleryWidthMinusBorderAndSpacing;
            $mediaScalingCorrection = max($mediaInRowScaling, $mediaScalingCorrection);

            // Set the corrected dimensions for each media element
            foreach ($this->fileObjects as $key => $fileObject) {
                $mediaWidth = floor($this->equalMediaWidth / $mediaScalingCorrection);
                $mediaHeight = floor(
                    $this->getCroppedDimensionalProperty($fileObject, 'height') * ($mediaWidth / max($this->getCroppedDimensionalProperty($fileObject, 'width'), 1))
                );
                $this->mediaDimensions[$key] = [
                    'width' => $mediaWidth,
                    'height' => $mediaHeight
                ];
            }

            // Recalculate gallery width
            $this->galleryData['width'] = floor($totalRowWidth / $mediaScalingCorrection);

        // Automatic setting of width and height
        } else {
            $maxMediaWidth = (int)($galleryWidthMinusBorderAndSpacing / $this->galleryData['count']['columns']);

            foreach ($this->fileObjects as $key => $fileObject) {
                $mediaWidth = min($maxMediaWidth, $this->getCroppedDimensionalProperty($fileObject, 'width'));
                $mediaHeight = floor(
                    $this->getCroppedDimensionalProperty($fileObject, 'height') * ($mediaWidth / max($this->getCroppedDimensionalProperty($fileObject, 'width'), 1))
                );
                $this->mediaDimensions[$key] = [
                    'width' => $mediaWidth,
                    'height' => $mediaHeight
                ];
            }
        }
    }

    /**
     * Get the gridclass from typoscript and fill in the appropriate values
     *
     * @param int $fieldValue the width-value from database
     * @param array $settings the typoscript-configuration
     * @return void
     */
    protected function getGalleryGridClass($fieldValue = 0, $settings = [])
    {
        $class = 'col-sm-(0)';
        if (count($settings) > 0) {
            if (!empty($fieldValue)) {
                // Use the value defined in database
                $class = $settings[$fieldValue];
            } elseif ($settings['default'] !== '' && $settings[$settings['default']] !== '') {
                // Use default value (if set)
                $class = $settings[$settings['default']];
            }
        }
        return $class;
    }

    /**
     * Get the gallery width based on vertical position
     *
     * @return void
     */
    protected function determineMaximumGalleryWidth()
    {
        if ($this->galleryWidth === 0) {
            if ($this->galleryData['position']['vertical'] === 'intext') {
                // Set width to the default value defined in typoscript
                $this->galleryWidth = $this->defaultGalleryWidth;
            } else {
                // Set to full width if gallery is above or below bodytext or default = 0
                $this->galleryWidth = $this->gridColumns;
            }
        } elseif ($this->galleryWidth === 100) {
            $this->galleryWidth = $this->gridColumns;
        }
        // Calculate percentage
        $galleryWidthInPercent = (100 / $this->gridColumns) * $this->galleryWidth;
        // Calculate maxGalleryWidth from maxW (pixels) and percentage
        $this->galleryData['width'] = floor(($this->maxGalleryWidth * $galleryWidthInPercent) / 100);
        // Set gallery-width to $this->galleryResponsiveMinWidth, which is the minimum width of responsive elements
        if ($this->galleryData['width'] < $this->galleryResponsiveMinWidth) {
            $this->galleryData['width'] = $this->galleryResponsiveMinWidth;
        }
    }

    /**
     * Define the header/gallery position relative to the content
     *
     * @return void
     */
    protected function determineRelationsToContent()
    {
        $headerAboveContent = GeneralUtility::trimExplode(',', $this->headerAboveContent);
        if (in_array($this->mediaOrientation, $headerAboveContent)) {
            $this->galleryData['position']['headerAboveContent'] = true;
        } else {
            $this->galleryData['position']['headerAboveContent'] = false;
        }

        $galleryAboveContent = GeneralUtility::trimExplode(',', $this->galleryAboveContent);
        if (in_array($this->mediaOrientation, $galleryAboveContent)) {
            $this->galleryData['position']['galleryAboveContent'] = true;
        } else {
            $this->galleryData['position']['galleryAboveContent'] = false;
        }

        if ($this->mediaOrientation === 17 || $this->mediaOrientation === 18) {
            $this->galleryData['position']['wrap'] = 'wrap';
        } else {
            $this->galleryData['position']['wrap'] = 'nowrap';
        }
    }

    /**
     * Prepare the gallery data
     *
     * Make an array for rows, columns and configuration
     *
     * @return void
     */
    protected function prepareGalleryData()
    {
        for ($row = 1; $row <= $this->galleryData['count']['rows']; $row++) {
            for ($column = 1; $column <= $this->galleryData['count']['columns']; $column++) {
                $fileKey = (($row - 1) * $this->galleryData['count']['columns']) + $column - 1;

                $this->galleryData['rows'][$row]['columns'][$column] = [
                    'media' => $this->fileObjects[$fileKey],
                    'dimensions' => [
                        'width' => $this->mediaDimensions[$fileKey]['width'],
                        'height' => $this->mediaDimensions[$fileKey]['height']
                    ]
                ];
            }
        }

        $this->galleryData['columnSpacing'] = $this->columnSpacing;
        $this->galleryData['border']['enabled'] = $this->borderEnabled;
        $this->galleryData['border']['width'] = $this->borderWidth;
        $this->galleryData['border']['padding'] = $this->borderPadding;
    }

    /**
     * Extend the prepared gallery data
     *
     * Set variables for imagecarousel and classes
     *
     * @return void
     */
    protected function extendGalleryData()
    {
        $columnClassValue = ($this->gridColumns / $this->galleryData['count']['columns']);
        $this->galleryData['columnClass'] = $this->calculateGridWidth($this->columnClass, $columnClassValue);

        // Set CSS-classes for gallery- and contentblock
        if (in_array($this->mediaOrientation, [0, 1, 2, 8, 9, 10])) {
            $galleryWidth = $this->galleryWidth;
            $this->galleryData['contentClass'] = $this->calculateGridWidth($this->columnClass, $this->gridColumns, true);
        } else {
            // Content width is alvailable space minus gallery width
            $contentWidth = ($this->gridColumns - $this->galleryWidth);
            // Gallery width is available space minus content width
            $galleryWidth = ($this->gridColumns - $contentWidth);
            $this->galleryData['contentClass'] = $this->calculateGridWidth($this->galleryGridClass, $contentWidth, true);
        }
        $this->galleryData['galleryClass'] = $this->calculateGridWidth($this->galleryGridClass, $galleryWidth, false);

        // Add data for bootstrap carousel
        $this->galleryData['carousel'] = $this->galleryCarousel;
        if ($this->galleryData['count']['files'] <= 1) {
            $this->galleryData['carousel'] = false;
        }
    }

    /**
     * Calculate widths for gallery- and textblock according
     * to typoscript configuration (lib.fluidContent.settings.gallery_break.X)
     *
     * @param string $class The configuration from typoscript
     * @param int $width The width from database (in grid-columns)
     * @param boolean $isContent Wether the calucalation is for the gallery- or textblock
     * @return string
     */
    protected function calculateGridWidth($class = '', $width = 0, $isContent = true)
    {
        return preg_replace_callback('/\([-+\w]*\)/u',
            function($match) use ($width, $isContent) {
            $number = str_replace(['(', ')'], '', $match[0]);
            // Add/substract the given value from the predefined width
            if ($isContent) {
                $value = $width - intval($number);
            } else {
                $value = $width + intval($number);
            }
            // If calculation results in more or less than the available columns, set to maximum/minimum
            if ($value > $this->gridColumns) {
                $value = $this->gridColumns;
            } elseif ($value < 1) {
                $value = 1;
            }
            return intval($value);
        }, $class
        );
    }

}
