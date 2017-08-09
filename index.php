<?php
define('VERSION', '0.1');

require 'func.utils.php';
require 'class.db.php';
require 'class.user.php';
require 'class.comment.php';
require 'class.config.php';
require 'config.php';

if (file_exists('config.custom.php')) {
    require 'config.custom.php';
}

date_default_timezone_set(Config::get('SITE_TIMEZONE'));
session_start();

$action = getParam('action', 'index');

render($action);
