<?php

namespace Sonority\BootstrapComponents\Helpers;

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

use TYPO3\CMS\Core\Html\HtmlParser;

class RteClasses
{

    /**
     * Prefix the tableclass with 'table'
     *
     * @param array $config
     * @param HtmlParser $parserObject
     * @return string
     */
    public function tableClass($config, HtmlParser $parserObject)
    {
        $tableClass = '';
        $default = $config['default'] ? $config['default'] : 'table';

        if (empty($config['attributeValue'])) {
            $tableClass = $default;
        } else {
            if ($config['attributeValue'] !== $default && !strstr($config['attributeValue'], $default . ' ')) {
                $tableClass = $default . ' ' . $config['attributeValue'];
            } else {
                $tableClass = $config['attributeValue'];
            }
        }
        return $tableClass;
    }

    /**
     * Prefix button-classes with default value 'btn'
     *
     * @param array $config
     * @param HtmlParser $parserObject
     * @return string
     */
    public function buttonClass($config, HtmlParser $parserObject)
    {
        $class = $config['attributeValue'];
        $default = $config['default'] ? $config['default'] : 'btn';
        if (strstr($config['attributeValue'], $default . '-')) {
            if ($config['attributeValue'] !== $default && !strstr($config['attributeValue'], $default . ' ')) {
                $class = $default . ' ' . $class;
            }
        }
        return $class;
    }

}
