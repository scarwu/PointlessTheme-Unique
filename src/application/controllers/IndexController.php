<?php
/**
 * Index Controller Example
 *
 * @package     PointlessTheme - Unique
 * @author      Scar Wu
 * @copyright   Copyright (c) Scar Wu (http://scar.tw)
 * @link        https://github.com/scarwu/PointlessTheme-Unique
 */

namespace WebApp\Controller;

use Oni\Web\Controller;

class IndexController extends Controller
{
    public function getAction()
    {
        $this->res->html('index', [
            'blog' => [
                'name' => 'My Blog',
                'slogan' => 'Pointless - Static Blog Generator',
                'footer' => 'My Blog',
                'description' => '',
                'lang' => 'en',
                'dn' => 'localhost',
                'base' => '/',
                'author' => null,
                'email' => null,
                'disqus_shortname' => null,
                'google_analytics' => null,

                'title' => 'Test Page',
                'url' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']
            ],
            'post' => [
                'url' => ''
            ],
            'block' => [
                'container' => '',
                'side' => ''
            ]
        ]);
    }
}
