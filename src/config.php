<?php
/**
 * Theme Config
 *
 * @package     Pointless
 * @author      ScarWu
 * @copyright   Copyright (c) 2012-2017, ScarWu (http://scar.simcz.tw/)
 * @link        http://github.com/scarwu/Pointless
 */

$theme = [
    'assets' => [
        'scripts' => [
            'custom'
        ],
        'styles' => [
            'normalize',
            'font-awesome',
            'custom',
            'solarized_dark'
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
