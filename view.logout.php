<?php
defined('VERSION') or die('deny access');

$_SESSION['IS_ADMIN'] = false;
redirect(url());
