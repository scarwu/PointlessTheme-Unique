<?php
/**
 * Bootstrap Example
 *
 * @package     PointlessTheme - Unique
 * @author      Scar Wu
 * @copyright   Copyright (c) Scar Wu (https://scar.tw)
 * @link        https://github.com/scarwu/PointlessTheme-Unique
 */

// Set Default Time Zone
date_default_timezone_set('Etc/UTC');

// Define Global Constants
define('ROOT', __DIR__ . '/..');
define('POI_ROOT', ROOT . '/../subModules/Pointless/src');
define('BLOG_POST', POI_ROOT . '/sample/posts');

// Require Composer Autoloader
require ROOT . '/application/vendor/autoload.php';

error_reporting(E_ALL);

// Register Whoops Exception Handler
$whoops = new Whoops\Run();
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
$whoops->register();

// New Oni Web Application Instance
$app = new Oni\Web\App();

$app->setAttr('controller/namespace', 'WebApp\Controller');
$app->setAttr('controller/path', ROOT . '/application/controllers');
$app->setAttr('controller/default/Handler', 'Main');
$app->setAttr('controller/default/action', 'describe');
$app->setAttr('controller/error/Handler', 'Main');
$app->setAttr('controller/error/action', 'describe');
$app->setAttr('model/namespace', 'WebApp\Model');
$app->setAttr('model/path', ROOT . '/application/models');
$app->setAttr('view/path', ROOT . '/application/views');

// Loader Append
Oni\Loader::append('Pointless\Handler', ROOT . '/application/handlers');
Oni\Loader::append('Pointless\Extension', ROOT . '/application/extensions');
Oni\Loader::append('Pointless\Library', POI_ROOT . '/libraries');
Oni\Loader::append('Pointless\Extend', POI_ROOT . '/extends');
Oni\Loader::append('Pointless\Format', POI_ROOT . '/formats');
Oni\Loader::append('Pointless\Handler', POI_ROOT . '/sample/handlers');
Oni\Loader::append('Pointless\Extension', POI_ROOT . '/sample/extensions');

// Start Application
$app->run();
