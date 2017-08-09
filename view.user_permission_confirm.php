<?php
defined('VERSION') or die('deny access');

if (!$_POST) {
	redirect(url('user'));
}

$id = (int) getParam('id');
$defaultPermissions = Config::get('PERMISSION_DEFAULT');
$permissions = (array) getParam('permissions');
$permissions = array_filter($permissions, function($rs) use($defaultPermissions) {
	return !in_array($rs, $defaultPermissions);
});

User::updatePermission($permissions, $id);

