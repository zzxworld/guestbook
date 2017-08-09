<?php
defined('VERSION') or die('deny access');

$authViews = array_merge(Config::get('LOGIN_VIEWS'), Config::get('ADMIN_VIEWS'));

if (in_array($action, $authViews) && !isLogined()) {
	setFlashMessage('请先登录');
	redirect(url('login'));
}

if (in_array($action, Config::get('ADMIN_VIEWS')) && !isAdmin()) {
	setFlashMessage('需要管理员权限');
	redirect(url());
}
