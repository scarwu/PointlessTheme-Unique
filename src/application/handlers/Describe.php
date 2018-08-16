<?php
/**
 * Describe Data Handler for Theme
 *
 * @package     Pointless Theme - Unique
 * @author      Scar Wu
 * @copyright   Copyright (c) Scar Wu (http://scar.tw)
 * @link        https://github.com/scarwu/PointlessTheme-Unique
 */

namespace Pointless\Handler;

use Pointless\Extend\ThemeHandler;

class Describe extends ThemeHandler
{
    public function __construct()
    {
        $this->type = 'describe';
    }

    /**
     * Init Data
     *
     * @param array
     */
    public function initData($postBundle)
    {
        $this->data = $postBundle['describe'];
    }

    /**
     * Get Container Data List
     *
     * @return array
     */
    public function getContainerDataList()
    {
        // $extBlog['title'] = "{$post['title']} | {$blog['name']}";
        // $extBlog['url'] = $system['blog']['domainName'] . $system['blog']['baseUrl'];

        return $this->data;
    }
}
