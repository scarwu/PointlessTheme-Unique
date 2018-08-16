<?php
/**
 * Category Data Handler for Theme
 *
 * @package     Pointless Theme - Unique
 * @author      Scar Wu
 * @copyright   Copyright (c) Scar Wu (http://scar.tw)
 * @link        https://github.com/scarwu/PointlessTheme-Unique
 */

namespace Pointless\Handler;

use Pointless\Extend\ThemeHandler;

class Category extends ThemeHandler
{
    public function __construct()
    {
        $this->type = 'category';
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
            $category = $post['category'];

            if (!isset($this->data[$category])) {
                $this->data[$category] = [];
            }

            $this->data[$category][] = $post;
        }

        uasort($this->data, function ($a, $b) {
            if (count($a) === count($b)) {
                return 0;
            }

            return count($a) > count($b) ? -1 : 1;
        });
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
        // $extBlog['url'] = $blog['dn'] . $blog['base'];

        // $this->createIndex("category/{$first}/index.html", 'category/index.html');

        $keys = array_keys($this->data);
        $firstKey = $keys[0];

        $totalIndex = count($this->data);
        $currentIndex = 0;

        foreach ($this->data as $key => $postList) {

            // Set Post
            $post = [];
            $post['title'] ="Category: {$key}";
            $post['url'] = "category/{$key}";
            $post['list'] = $this->createDateList($postList);

            // Set Paging
            $paging = [];
            $paging['totalIndex'] = $totalIndex;
            $paging['currentIndex'] = $currentIndex + 1;

            if (isset($keys[$currentIndex - 1])) {
                $prevKey = $keys[$currentIndex - 1];

                $paging['prevTitle'] = $prevKey;
                $paging['prevUrl'] = "category/{$prevKey}";
            }

            if (isset($keys[$currentIndex + 1])) {
                $nextKey = $keys[$currentIndex + 1];

                $paging['nextTitle'] = $nextKey;
                $paging['nextUrl'] = "category/{$nextKey}";
            }

            $currentIndex++;
        }

        return $this->data;
    }

    private function createDateList($list)
    {
        $result = [];

        foreach ($list as $article) {
            $year = $article['year'];
            $month = $article['month'];

            if (!isset($result[$year])) {
                $result[$year] = [];
            }

            if (!isset($result[$year][$month])) {
                $result[$year][$month] = [];
            }

            $result[$year][$month][] = $article;
        }

        return $result;
    }
}
