<?php
defined('VERSION') or die('deny access');

if (!isPostMethod()) {
	redirect(url('login'));
}

$account = getParam('account');
$password = getParam('password');

if (empty($account)) {
	setFlashMessage('请输入你的登录账号');
	redirect(url('login'));
}

if (empty($password)) {
	setFlashMessage('请输入登录密码');
	redirect(url('login'));
}

try {
	$user = User::login($account, $password);
	signLogin($user);
	setFlashMessage('您已登录');
	redirect(url());
} catch (UserInvalidAccountError $e) {
	setFlashMessage('无效的登录账号');
	redirect(url('login'));
} catch (UserInvalidPasswordError $e) {
	setFlashMessage('无效的登录密码');
	redirect(url('login'));
}
