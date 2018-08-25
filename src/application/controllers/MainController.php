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

use Pointless\Library\Misc;
use Pointless\Library\Utility;
use Oni\Web\Controller\Page as Controller;

class MainController extends Controller
{
    /**
     * @var array
     */
    private $systemConstant = [];

    /**
     * @var array
     */
    private $systemConfig = [];

    /**
     * @var array
     */
    private $themeConfig = [];

    /**
     * @var array
     */
    private $handlerList = [];

    public function up()
    {
        // Set View
        $this->view->setLayoutPath('index');

        // Load System Consatnt
        include POI_ROOT . '/constant.php';

        $systemConstant = $constant;

        // Load System Config
        include POI_ROOT . '/sample/config.php';

        $systemConfig = $config;

        // Load Theme Config
        require ROOT . '/application/config.php';

        $themeConfig = $config;

        // Load Posts
        $postBundle = [];

        foreach ($systemConstant['formats'] as $name) {
            $namespace = 'Pointless\\Format\\' . ucfirst($name);

            $instance = new $namespace();
            $type = $instance->getType();

            $postBundle[$type] = [];

            foreach (Misc::getPostList($type) as $post) {
                if (false === $post['isPublic']) {
                    continue;
                }

                $postBundle[$type][] = $instance->convertPost($post);
            }
        }

        foreach ($postBundle as $type => $post) {
            $postBundle[$type] = array_reverse($post);
        }

        // Rendering HTML Pages
        $handlerList = [];

        foreach ($themeConfig['handlers'] as $name) {
            if (!isset($handlerList[$name])) {
                $namespace = 'Pointless\\Handler\\' . ucfirst($name);

                $instance = new $namespace();
                $type = $instance->getType();

                $handlerList[$type] = $instance;
                $handlerList[$type]->initData([
                    'systemConstant' => $systemConstant,
                    'systemConfig' => $systemConfig,
                    'themeConfig' => $themeConfig,
                    'postBundle' => $postBundle
                ]);
            }
        }

        // Set
        $this->systemConstant = $systemConstant;
        $this->systemConfig = $systemConfig;
        $this->themeConfig = $themeConfig;
        $this->handlerList = $handlerList;
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
     *
     * @param array $params
     */
    public function pageAction($params = [])
    {
        // Get Side Data
        $sideList = [];

        foreach ($this->themeConfig['views']['side'] as $name) {
            if (!isset($this->handlerList[$name])) {
                continue;
            }

            $sideList[$name] = $this->handlerList[$name]->getSideData();
        }

        // Get Container Data List
        $containerDataList = $this->handlerList['page']->getContainerDataList();

        $url = join('/', $params) . '/';

        if (isset($containerDataList[$url])) {
            $container = $containerDataList[$url];
        }

        // Set View
        $this->view->setContentPath('container/page');
        $this->view->setData([
            'systemConstant' => $this->systemConstant,
            'systemConfig' => $this->systemConfig,
            'themeConfig' => $this->themeConfig,
            'sideList' => $sideList,
            'container' => $container
        ]);
    }

    /**
     * Archive Action
     *
     * @param array $params
     */
    public function archiveAction($params = [])
    {
        // Set View
        $this->view->setContentPath('container/archive');
        $this->view->setData([
            'systemConstant' => $this->systemConstant,
            'systemConfig' => $this->systemConfig,
            'themeConfig' => $this->themeConfig,
            'sideList' => $sideList,
            'container' => $container
        ]);
    }

    /**
     * Category Action
     *
     * @param array $params
     */
    public function categoryAction($params = [])
    {
        // Set View
        $this->view->setContentPath('container/category');
        $this->view->setData([
            'systemConstant' => $this->systemConstant,
            'systemConfig' => $this->systemConfig,
            'themeConfig' => $this->themeConfig,
            'sideList' => $sideList,
            'container' => $container
        ]);
    }

    /**
     * Tag Action
     *
     * @param array $params
     */
    public function tagAction($params = [])
    {
        // Set View
        $this->view->setContentPath('container/tag');
        $this->view->setData([
            'systemConstant' => $this->systemConstant,
            'systemConfig' => $this->systemConfig,
            'themeConfig' => $this->themeConfig,
            'sideList' => $sideList,
            'container' => $container
        ]);
    }

    /**
     * Article Action
     *
     * @param array $params
     */
    public function articleAction($params = [])
    {
        // Set View
        $this->view->setContentPath('container/article');
        $this->view->setData([
            'systemConstant' => $this->systemConstant,
            'systemConfig' => $this->systemConfig,
            'themeConfig' => $this->themeConfig,
            'sideList' => $sideList,
            'container' => $container
        ]);
    }

    /**
     * Describe Action
     *
     * @param array $params
     */
    public function describeAction($params = [])
    {
        // Set View
        $this->view->setContentPath('container/describe');
        $this->view->setData([
            'systemConstant' => $this->systemConstant,
            'systemConfig' => $this->systemConfig,
            'themeConfig' => $this->themeConfig,
            'sideList' => $sideList,
            'container' => $container
        ]);
    }
}
