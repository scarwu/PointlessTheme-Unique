<?php
/**
 * Tag Data Generator Script for Theme
 *
 * @package     Pointless
 * @author      ScarWu
 * @copyright   Copyright (c) 2012-2014, ScarWu (http://scar.simcz.tw/)
 * @link        http://github.com/scarwu/Pointless
 */

use NanoCLI\IO;

class Tag extends ThemeScript
{
    public function __construct()
    {
        parent::__construct();

        foreach (Resource::get('post')['article'] as $value) {
            foreach ($value['tag'] as $tag) {
                if (!isset($this->list[$tag])) {
                    $this->list[$tag] = [];
                }

                $this->list[$tag][] = $value;
            }
        }

        ksort($this->list);
    }

    /**
     * Get Side Data
     *
     * @return array
     */
    public function getSideData()
    {
        $data['blog'] = Resource::get('config')['blog'];
        $data['list'] = $this->list;

        return $data;
    }

    /**
     * Generate Data
     *
     * @param string
     */
    public function gen()
    {
        $first = null;
        $count = 0;
        $total = count($this->list);
        $keys = array_keys($this->list);

        $blog = Resource::get('config')['blog'];

        foreach ((array) $this->list as $index => $post_list) {
            IO::log("Building tag/$index/");
            if (null === $first) {
                $first = $index;
            }

            $post = [];
            $post['title'] = "Tag: $index";
            $post['url'] = "tag/$index/";
            $post['list'] = $post_list;

            $paging = [];
            $paging['index'] = $count + 1;
            $paging['total'] = $total;

            if (isset($keys[$count - 1])) {
                $tag = $keys[$count - 1];

                $paging['p_title'] = $tag;
                $paging['p_url'] = "{$blog['base']}tag/$tag/";
            }

            if (isset($keys[$count + 1])) {
                $tag = $keys[$count + 1];

                $paging['n_title'] = $tag;
                $paging['n_url'] = "{$blog['base']}tag/$tag/";
            }

            $count++;

            $ext = [];
            $ext['title'] = "{$post['title']} | {$blog['name']}";
            $ext['url'] = $blog['dn'] . $blog['base'];

            $block = Resource::get('block');
            $block['container'] = $this->render([
                'blog' => array_merge($blog, $ext),
                'post' => $post,
                'paging' => $paging
            ], 'container/tag.php');

            // Save HTML
            $this->save($post['url'], $this->render([
                'blog' => array_merge($blog, $ext),
                'post' => $post,
                'block' => $block
            ], 'index.php'));
        }

        $this->createIndex("/tag/$first/index.html", 'tag/index.html');
    }
}
