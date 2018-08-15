<?php
/**
 * Main Controller
 *
 * @package     PointlessTheme - Unique
 * @author      Scar Wu
 * @copyright   Copyright (c) Scar Wu (http://scar.tw)
 * @link        https://github.com/scarwu/PointlessTheme-Unique
 */

namespace WebApp\Controller;

use Oni\Web\Controller\Page as Controller;

class MainController extends Controller
{
    public function up()
    {
        $this->view->setLayoutPath('index');
    }

    public function down()
    {
        $this->res->html($this->view->render());
    }

    /**
     * Default Action
     */
    public function defaultAction()
    {
        $this->pageAction();
    }

    /**
     * Page Action
     */
    public function pageAction($params = [])
    {
        $this->view->setContentPath('container/page');
        $this->view->setData([
            'system' => [],
            'theme' => [],
            'post' => []
        ]);
    }

    /**
     * Archive Action
     */
    public function archiveAction($params = [])
    {
        $this->view->setContentPath('container/archive');
        $this->view->setData([
            'system' => [],
            'theme' => [],
            'post' => []
        ]);
    }

    /**
     * Category Action
     */
    public function categoryAction($params = [])
    {
        $this->view->setContentPath('container/category');
        $this->view->setData([
            'system' => [],
            'theme' => [],
            'post' => []
        ]);
    }

    /**
     * Tag Action
     */
    public function tagAction($params = [])
    {
        $this->view->setContentPath('container/tag');
        $this->view->setData([
            'system' => [],
            'theme' => [],
            'post' => []
        ]);
    }

    /**
     * Article Action
     */
    public function articleAction($params = [])
    {
        $this->view->setContentPath('container/article');
        $this->view->setData([
            'system' => [],
            'theme' => [],
            'post' => []
        ]);
    }

    /**
     * Describe Action
     */
    public function describeAction($params = [])
    {
        $this->view->setContentPath('container/describe');
        $this->view->setData([
            'system' => [],
            'theme' => [],
            'post' => []
        ]);
    }
}
