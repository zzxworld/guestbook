<?php
define('VERSION', '0.2');
define('ROOT_PATH', __DIR__);

require ROOT_PATH.'/classes/db.php';
require ROOT_PATH.'/classes/user.php';
require ROOT_PATH.'/classes/comment.php';
require ROOT_PATH.'/classes/config.php';
require ROOT_PATH.'/func.utils.php';
require ROOT_PATH.'/config.php';

if (file_exists('config.custom.php')) {
    require ROOT_PATH.'config.custom.php';
}

date_default_timezone_set(Config::get('SITE_TIMEZONE'));
session_start();

$action = getParam('action', 'index');

render($action);
