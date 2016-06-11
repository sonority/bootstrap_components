<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "bootstrap_components".
 *
 * Auto generated 21-11-2015 18:11
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
	'title' => 'Bootstrap Components',
	'description' => 'Implements Bootstrap3 components (fluid-styled) with all the bells and whistles...',
	'category' => 'fe',
	'version' => '0.0.1',
	'state' => 'experimental',
	'uploadfolder' => false,
	'createDirs' => '',
	'clearcacheonload' => true,
	'author' => 'Stephan Kellermayr',
	'author_email' => 'stephan.kellermayr@gmail.com',
	'author_company' => 'sonority.at - MULTIMEDIA ART DESIGN',
	'constraints' => [
		'depends' => [
			'typo3' => '7.4.0-7.6.99',
            'fluid_styled_content' => ''
		],
		'conflicts' => [
            'css_styled_content' => '',
        ],
		'suggests' => [
            'gridelements' => '3.0.0-',
            'lib_bootstrap3' => '',
            'lib_bootstrap4' => '',
        ],
	],
];
