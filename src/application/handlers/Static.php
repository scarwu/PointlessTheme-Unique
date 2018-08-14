<?php
/**
 * Static Data Handler for Theme
 *
 * @package     Pointless Theme - Unique
 * @author      Scar Wu
 * @copyright   Copyright (c) Scar Wu (http://scar.tw)
 * @link        https://github.com/scarwu/PointlessTheme-Unique
 */

namespace Pointless\Handler;

use Pointless\Library\Resource;
use Pointless\Extend\ThemeHandler;
use Oni\CLI\IO;

class Static extends ThemeHandler
{
    public function __construct()
    {
        $this->type = 'static';
        $this->list = Resource::get('post:static');
    }

    /**
     * Render Block
     *
     * @param string
     */
    public function renderBlock($blockName)
    {
        return false;
    }

    /**
     * Render Page
     */
    public function renderPage()
    {
        $blog = Resource::get('system:config')['blog'];

        foreach ($this->list as $post) {
            IO::log("Building {$post['url']}");

            $extBlog = [];
            $extBlog['title'] = "{$post['title']} | {$blog['name']}";
            $extBlog['url'] = $system['blog']['domainName'] . $system['blog']['baseUrl'];

            $block = Resource::get('block');
            $block['container'] = $this->render([
                'blog' => array_merge($blog, $extBlog),
                'post' => $post
            ], 'container/static.php');

            // Save HTML
            $this->save($post['url'], $this->render([
                'blog' => array_merge($blog, $extBlog),
                'post' => $post,
                'block' => $block
            ], 'index.php'));
        }
    }
}
