<?php
/**
 * Article Data Handler for Theme
 *
 * @package     Pointless Theme - Unique
 * @author      Scar Wu
 * @copyright   Copyright (c) Scar Wu (http://scar.tw)
 * @link        https://github.com/scarwu/PointlessTheme-Unique
 */

namespace Pointless\Handler;

use Pointless\Extend\ThemeHandler;

class Article extends ThemeHandler
{
    public function __construct()
    {
        $this->type = 'article';
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
        $keys = array_keys($this->data);
        $totalIndex = count($this->data);
        $currentIndex = 0;

        foreach ($this->data as $key => $post) {

            // Set Paging
            $paging = [];
            $paging['totalIndex'] = $totalIndex;
            $paging['currentIndex'] = $currentIndex + 1;

            if (isset($keys[$currentIndex - 1])) {
                $prevKey = $keys[$currentIndex - 1];
                $title = $this->data[$prevKey]['title'];
                $url = $this->data[$prevKey]['url'];

                $paging['prevTitle'] = $title;
                $paging['prevUrl'] = "article/{$url}/";
            }

            if (isset($keys[$currentIndex + 1])) {
                $nextKey = $keys[$currentIndex + 1];
                $title = $this->data[$nextKey]['title'];
                $url = $this->data[$nextKey]['url'];

                $paging['nextTitle'] = $title;
                $paging['nextUrl'] = "article/{$url}/";
            }

            $post['paging'] = $paging;
            $this->data[$key] = $post;

            $currentIndex++;
        }

        // $extBlog['title'] = "{$post['title']} | {$blog['name']}";
        // $extBlog['url'] = $system['blog']['domainName'] . $system['blog']['baseUrl'];
        // $extBlog['description'] = '' !== $post['description']
        //     ? $post['description'] : $blog['description'];

        return $this->data;
    }
}
