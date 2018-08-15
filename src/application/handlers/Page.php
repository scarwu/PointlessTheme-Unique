<?php
/**
 * Page Data Handler for Theme
 *
 * @package     Pointless Theme - Unique
 * @author      Scar Wu
 * @copyright   Copyright (c) Scar Wu (http://scar.tw)
 * @link        https://github.com/scarwu/PointlessTheme-Unique
 */

namespace Pointless\Handler;

use Pointless\Extend\ThemeHandler;

class Page extends ThemeHandler
{
    public function __construct()
    {
        $this->type = 'page';
    }

    /**
     * Init Data
     *
     * @param array
     */
    public function initData($postBundle)
    {
        $this->data = $postBundle['article'];
    }

    /**
     * Get Container Data
     *
     * @return array
     */
    public function getContainerData()
    {
        $quantity = Resource::get('system:config')['post']['article']['quantity'];
        $totalIndex = ceil(count($this->data) / $quantity);

        for ($currentIndex = 0;$currentIndex < $totalIndex;$currentIndex++) {

            // Set Post
            $post = [];
            $post['url'] = "page/{$currentIndex}/";
            $post['list'] = array_slice($this->data, $quantity * ($currentIndex - 1), $quantity);

            // Set Paging
            $paging = [];
            $paging['totalIndex'] = $totalIndex;
            $paging['currentIndex'] = $currentIndex + 1;

            if ($currentIndex - 1 >= 0) {
                $prevKey = $currentIndex - 1;

                $paging['prevTitle'] = $prevKey;
                $paging['prevUrl'] = "page/{$prevKey}/";
            }

            if ($currentIndex + 1 < $totalIndex) {
                $nextKey = $currentIndex + 1;

                $paging['nextTitle'] = $nextKey;
                $paging['nextUrl'] = "page/{$nextKey}/";
            }

        }

        // $extBlog = [];
        // $extBlog['title'] = $blog['name'];
        // $extBlog['url'] = $system['blog']['domainName'] . $system['blog']['baseUrl'];

        // $this->createIndex('page/1/index.html', 'page/index.html');
        // $this->createIndex('page/1/index.html', 'index.html');

        return $this->data;
    }
}
