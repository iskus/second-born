<?php if (!defined('PATH_TO_ROOT')) {
    exit();
}
define('PATH_TO_CORE', PATH_TO_ROOT . '/core/');
define('PATH_TO_LIBS', PATH_TO_ROOT . '/libs/');
define('PATH_TO_WEB', PATH_TO_ROOT . '/web/');
define('PATH_TO_JS', PATH_TO_WEB . '/js/');
define('PATH_TO_CSS', PATH_TO_WEB . '/css/');
define('PATH_TO_IMG', PATH_TO_WEB . '/img/');
define('PATH_TO_TEMPLATES', PATH_TO_APP . 'view/templates/');
define('SITE_URL', $_SERVER['HTTP_HOST']);
//var_dump($_SERVER);die;

$mysqlConfig = new stdClass();
$mongoConfig = clone $mysqlConfig;

/** MySQL connection configuration */

$mysqlConfig->host = 'localhost';
$mysqlConfig->user = 'root';
$mysqlConfig->pass = 'antonjan88';
$mysqlConfig->db = 'test';
$configCollection->offsetSet('mysql', $mysqlConfig);

//	$mysqlConfig->host = 'mysql.hostinger.com.ua';
//	$mysqlConfig->user = 'u124424615_shop';
//	$mysqlConfig->pass = 'idiller88';
//	$mysqlConfig->db = 'u124424615_shop';


/** MongoDB connection configuration */
$mongoConfig->host = '127.0.0.1';
$mongoConfig->port = '27017';
$mongoConfig->user = 'admin';
$mongoConfig->pass = 'admin';
$mongoConfig->db = 'data';

//...
$configCollection->offsetSet('mongo', $mongoConfig);