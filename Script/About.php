<?php
/**
 * Archive Data Generator Script for Theme
 *
 * @package     Pointless
 * @author      ScarWu
 * @copyright   Copyright (c) 2012-2014, ScarWu (http://scar.simcz.tw/)
 * @link        http://github.com/scarwu/Pointless
 */

class About
{
    public function __construct() {}

    /**
     * Get Side Data
     *
     * @return array
     */
    public function getSideData()
    {
        $data['blog'] = Resource::get('config')['blog'];

        return $data;
    }

    /**
     * Generate Data
     *
     * @param string
     */
    public function gen() {}
}
