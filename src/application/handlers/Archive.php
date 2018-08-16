<?php
/**
 * Archive Data Handler for Theme
 *
 * @package     Pointless Theme - Unique
 * @author      Scar Wu
 * @copyright   Copyright (c) Scar Wu (http://scar.tw)
 * @link        https://github.com/scarwu/PointlessTheme-Unique
 */

namespace Pointless\Handler;

use Pointless\Extend\ThemeHandler;

class Archive extends ThemeHandler
{
    public function __construct()
    {
        $this->type = 'archive';
    }

    /**
     * Init Data
     *
     * @param array
     */
    public function initData($postBundle)
    {
        $this->data = [];

        foreach ($postBundle['article'] as $post) {
            $archive = $post['year'];

            if (!isset($this->data[$archive])) {
                $this->data[$archive] = [];
            }

            $this->data[$archive][] = $post;
        }
    }

    /**
     * Get Side Data
     *
     * @return array
     */
    public function getSideData()
    {
        return $this->data;
    }

    /**
     * Get Container Data List
     *
     * @return array
     */
    public function getContainerDataList()
    {
        // $extBlog['title'] = "{$post['title']} | {$blog['name']}";
        // $extBlog['url'] = $system['blog']['domainName'] . $system['blog']['baseUrl'] . $post['url'];

        // $this->createIndex("archive/{$first}/index.html", 'archive/index.html');

        $keys = array_keys($this->data);
        $firstKey = $keys[0];

        $totalIndex = count($this->data);
        $currentIndex = 0;

        foreach ($this->data as $key => $postList) {

            // Set Post
            $post = [];
            $post['title'] = "Archive: {$key}";
            $post['url'] = "archive/{$key}/";
            $post['list'] = $postList;

            // Set Paging
            $paging = [];
            $paging['totalIndex'] = $totalIndex;
            $paging['currentIndex'] = $currentIndex + 1;

            if (isset($keys[$currentIndex - 1])) {
                $prevKey = $keys[$currentIndex - 1];

                $paging['prevTitle'] = $prevKey;
                $paging['prevUrl'] = "archive/{$prevKey}/";
            }

            if (isset($keys[$currentIndex + 1])) {
                $nextKey = $keys[$currentIndex + 1];

                $paging['nextTitle'] = $nextKey;
                $paging['nextUrl'] = "archive/{$nextKey}/";
            }

            $currentIndex++;
        }

        return $this->data;
    }
}
