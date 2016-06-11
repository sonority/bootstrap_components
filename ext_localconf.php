<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
// Load extension manager configuration
if (!empty($_EXTCONF)) {
    $_EXTCONF = unserialize($_EXTCONF);
}

if (TYPO3_MODE === 'BE') {
    // Hook to override tt_content backend_preview for CType 'table'
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][$_EXTKEY] = \Sonority\BootstrapComponents\Hooks\PreviewRenderer::class;
}

if (!empty($_EXTCONF['setRteTSconfig'])) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/TsConfig/Rte.txt">');
}
if (!empty($_EXTCONF['setPageTSconfig'])) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/TsConfig/Page.txt">');
}
