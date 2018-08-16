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
    public function initData($data)
    {
        $data['articleByArchive'] = $data;

        foreach ($data['postBundle']['article'] as $post) {
            $archive = $post['year'];

            if (!isset($data['articleByArchive'][$archive])) {
                $data['articleByArchive'][$archive] = [];
            }

            $data['articleByArchive'][$archive][] = $post;
        }

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
        // $this->createIndex("archive/{$firstKey}/index.html", 'archive/index.html');

        $articleList = $this->data['articleByArchive'];
        $keys = array_keys($articleList);
        $firstKey = $keys[0];
        $totalIndex = count($articleList);

        $containerList = [];

        foreach ($keys as $currentIndex => $key) {

            // Set Post
            $container = [];
            $container['title'] = "Archive: {$key}";
            $container['url'] = "archive/{$key}/";
            $container['list'] = $articleList[$key];

            // Set Paging
            $container['paging'] = [];
            $container['paging']['totalIndex'] = $totalIndex;
            $container['paging']['currentIndex'] = $currentIndex + 1;

            if (isset($keys[$currentIndex - 1])) {
                $prevKey = $keys[$currentIndex - 1];
                $container['paging']['prevTitle'] = $prevKey;
                $container['paging']['prevUrl'] = "archive/{$prevKey}/";
            }

            if (isset($keys[$currentIndex + 1])) {
                $nextKey = $keys[$currentIndex + 1];
                $container['paging']['nextTitle'] = $nextKey;
                $container['paging']['nextUrl'] = "archive/{$nextKey}/";
            }

            $containerList[] = $container;
        }

        return $containerList;
    }
}
