<?php
error_reporting(E_ALL);
define('PATH_TO_ROOT', str_replace('\\', '/', realpath(dirname(__FILE__))));
define('APP_FOLDER', 'app');
define('PATH_TO_APP', PATH_TO_ROOT . '/' . APP_FOLDER . '/');

require_once('etc/autoload.php');

$configCollection = new ArrayObject;
$appConfig = [];
require_once('etc/config.php');
require_once(PATH_TO_APP . 'config/config.php');
foreach ($appConfig as $index => $value)
    $configCollection->offsetSet($index, $value);

core\Config::setDbConfigs($configCollection);
$router = new core\Router();
$controller = $router->getController();

$action = $router->getAction();
$params = $router->getParams() ? $router->getParams() : FALSE;

$app = new core\App($controller, $action, $params);
$app->run();
