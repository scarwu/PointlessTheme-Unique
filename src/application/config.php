<?php
/**
 * Theme Config
 *
 * @package     Pointless Theme - Unique
 * @author      ScarWu
 * @copyright   Copyright (c) ScarWu (http://scar.tw/)
 * @link        http://github.com/scarwu/Pointless
 */

$theme = [
    'assets' => [
        'scripts' => [
            'theme'
        ],
        'styles' => [
            'theme'
        ]
    ],
    'views' => [
        'side' => [
            'about',
            'archive',
            'tag'
        ]
    ],
    'handlers' => [
        'About',
        'StaticPage',
        'Article',
        'Page',
        'Archive',
        'Tag'
    ],
    'extensions' => [
        'Atom',
        'Sitemap'
    ]
];
