<?php
define('VERSION', '0.1');

require 'classes/db.php';
require 'classes/user.php';
require 'classes/comment.php';
require 'classes/config.php';
require 'func.utils.php';
require 'config.php';

if (file_exists('config.custom.php')) {
    require 'config.custom.php';
}

date_default_timezone_set(Config::get('SITE_TIMEZONE'));
session_start();

$action = getParam('action', 'index');

render($action);
