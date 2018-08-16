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
    public function initData($data)
    {
        $data['articleByArchive'] = [];

        foreach ($data['postBundle']['article'] as $post) {
            $category = $post['category'];

            if (!isset($data['articleByArchive'][$category])) {
                $data['articleByArchive'][$category] = [];
            }

            $data['articleByArchive'][$category][] = $post;
        }

        uasort($data['articleByArchive'], function ($a, $b) {
            if (count($a) === count($b)) {
                return 0;
            }

            return count($a) > count($b) ? -1 : 1;
        });

        $this->data = $data;
    }

    /**
     * Get Side Data
     *
     * @return array
     */
    public function getSideData()
    {
        return $this->data['articleByArchive'];
    }

    /**
     * Get Container Data List
     *
     * @return array
     */
    public function getContainerDataList()
    {
        // $this->createIndex("category/{$firstKey}/index.html", 'category/index.html');

        $articleList = $this->data['articleByArchive'];
        $keys = array_keys($articleList);
        $firstKey = $keys[0];
        $totalIndex = count($articleList);

        $containerList = [];

        foreach ($keys as $currentIndex => $key) {

            // Set Post
            $container = [];
            $container['title'] ="Category: {$key}";
            $container['url'] = "category/{$key}";
            $container['list'] = $articleList[$key];

            // Set Paging
            $container['paging'] = [];
            $container['paging']['totalIndex'] = $totalIndex;
            $container['paging']['currentIndex'] = $currentIndex + 1;

            if (isset($keys[$currentIndex - 1])) {
                $prevKey = $keys[$currentIndex - 1];
                $container['paging']['prevTitle'] = $prevKey;
                $container['paging']['prevUrl'] = "category/{$prevKey}";
            }

            if (isset($keys[$currentIndex + 1])) {
                $nextKey = $keys[$currentIndex + 1];
                $container['paging']['nextTitle'] = $nextKey;
                $container['paging']['nextUrl'] = "category/{$nextKey}";
            }

            $containerList[] = $container;
        }

        return $containerList;
    }
}
