<?php
/**
 * Archive Data Generator Script for Theme
 *
 * @package     Pointless Theme - Unique
 * @author      ScarWu
 * @copyright   Copyright (c) ScarWu (http://scar.tw/)
 * @link        http://github.com/scarwu/Pointless
 */

namespace Pointless\Handler;

use Pointless\Library\Resource;
use Pointless\Extend\ThemeHandler;

class About extends ThemeHandler
{
    public function __construct() {
        $this->type = 'about';
    }

    /**
     * Render Block
     *
     * @param string
     */
    public function renderBlock($blockName)
    {
        $views = Resource::get('attr:theme')['views'];

        if (!isset($views[$blockName])) {
            return false;
        }

        if (!in_array('about', $views[$blockName])) {
            return false;
        }

        $block = Resource::get('block');

        if (null === $block) {
            $block = [];
        }

        if (!isset($block[$blockName])) {
            $block[$blockName] = '';
        }

        $block[$blockName] .= $this->render([
            'blog' => Resource::get('attr:config')['blog']
        ], "{$blockName}/about.php");

        Resource::set('block', $block);
    }

    /**
     * Render Page
     */
    public function renderPage() {}
}
