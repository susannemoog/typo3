<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 CMS File Metadata',
    'description' => 'Adds additional metadata to file management.',
    'category' => 'misc',
    'author' => 'TYPO3 Core Team',
    'author_email' => 'typo3cms@typo3.org',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'version' => '12.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
