<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Add static typoscript configurations
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Bootstrap Components');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Gridelements', 'Bootstrap Components [Gridelements]');

// Page TypoScript (gridelements)
// Note: This configuration needs to be loaded directly in the page to avoid empty content in some cases!!!
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'bootstrap_components', 'Configuration/TsConfig/Gridelements/Page.txt',
    'EXT:bootstrap_components :: Configuration for gridelements');
