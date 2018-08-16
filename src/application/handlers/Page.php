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
    public function initData($data)
    {
        $data['articleByPage'] = [];
        $articleList = $data['postBundle']['article'];
        $quantity = $data['systemConfig']['post']['article']['quantity'];
        $totalIndex = ceil(count($articleList) / $quantity);

        for ($currentIndex = 1; $currentIndex <= $totalIndex; $currentIndex++) {
            $data['articleByPage'][$currentIndex] = array_slice($articleList, $quantity * ($currentIndex - 1), $quantity);
        }

        $this->data = $data;
    }

    /**
     * Get Container Data List
     *
     * @return array
     */
    public function getContainerDataList()
    {
        // $this->createIndex('page/1/index.html', 'page/index.html');
        // $this->createIndex('page/1/index.html', 'index.html');

        $articleList = $this->data['articleByPage'];
        $keys = array_keys($articleList);
        $firstKey = $keys[0];
        $totalIndex = count($articleList);

        $containerList = [];

        foreach ($keys as $currentIndex => $key) {

            // Set Post
            $container = [];
            $container['url'] = "page/{$currentIndex}/";
            $container['list'] = $articleList[$key];

            // Set Paging
            $container['paging'] = [];
            $container['paging']['totalIndex'] = $totalIndex;
            $container['paging']['currentIndex'] = $currentIndex + 1;

            if (isset($keys[$currentIndex - 1])) {
                $prevKey = $keys[$currentIndex - 1];
                $container['paging']['prevTitle'] = $prevKey;
                $container['paging']['prevUrl'] = "page/{$prevKey}/";
            }

            if (isset($keys[$currentIndex + 1])) {
                $nextKey = $keys[$currentIndex + 1];
                $container['paging']['nextTitle'] = $nextKey;
                $container['paging']['nextUrl'] = "page/{$nextKey}/";
            }

            $containerList[] = $container;
        }

        return $containerList;
    }
}
