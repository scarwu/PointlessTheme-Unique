<?php
/**
 * Theme Config
 *
 * @package     Pointless Theme - Unique
 * @author      Scar Wu
 * @copyright   Copyright (c) Scar Wu (http://scar.tw)
 * @link        https://github.com/scarwu/PointlessTheme-Unique
 */

$config = [
    'extensions' => [
        'Atom',
        'Sitemap'
    ],
    'handlers' => [
        'Describe',
        'Article',
        'Page',
        'Archive',
        'Category',
        'Tag'
    ],
    'views' => [
        'container' => [
            'describe',
            'article',
            'page',
            'archive',
            'category',
            'tag'
        ],
        'side' => [
            'about',
            'archive',
            'category',
            'tag'
        ]
    ]
];
