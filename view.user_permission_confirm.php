<?php
defined('VERSION') or die('deny access');

if (!$_POST) {
	redirect(url('user'));
}

$id = (int) getParam('id');
$user = User::find($id);
if (!$user) {
	setFlashMessage('用户不存在');
	redirect(url('user'));
}


$defaultPermissions = Config::get('PERMISSION_DEFAULT');
$permissions = (array) getParam('permissions');
$permissions = array_filter($permissions, function($rs) use($defaultPermissions) {
	return !in_array($rs, $defaultPermissions);
});

User::updatePermission($permissions, $user['id']);

setFlashMessage('用户权限已保存');
redirect(url('user'));
