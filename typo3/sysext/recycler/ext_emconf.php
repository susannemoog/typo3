<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 CMS Recycler',
    'description' => 'Restore deleted records or remove them from the database permanently.',
    'category' => 'module',
    'author' => 'TYPO3 Core Team',
    'author_email' => 'typo3cms@typo3.org',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'author_company' => '',
    'version' => '12.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.0.0',
        ],
        'conflicts' => [],
        'suggests' => [
            'scheduler' => '',
        ],
    ],
];
