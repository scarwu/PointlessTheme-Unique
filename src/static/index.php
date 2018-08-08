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

$root = __DIR__ . '/..';

// Require Composer Autoloader
require "{$root}/application/vendor/autoload.php";

error_reporting(E_ALL);

// Register Whoops Exception Handler
$whoops = new Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

// New Oni Web Application Instance
$app = new Oni\Web\App();

$app->setAttr('namespace', 'WebApp');
$app->setAttr('controller/namespace', 'WebApp\Controller');
$app->setAttr('controller/path', "{$root}/application/controllers");
$app->setAttr('model/namespace', 'WebApp\Model');
$app->setAttr('model/path', "{$root}/application/models");
$app->setAttr('view/path', "{$root}/application/views");
$app->setAttr('static/path', "{$root}/application/static");
$app->setAttr('cache/path', "{$root}/application/cache");

$app->run();
