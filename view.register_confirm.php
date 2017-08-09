<?php
defined('VERSION') or die('deny access');

if (!$_POST) {
	redirect(url('register'));
}

$email = getParam('email');
$username = getParam('username');
$password = getParam('password');
$passwordConfirm = getParam('password_confirm');

if (empty($email)) {
	setFlashMessage('请填写您要作为登录账号的邮箱地址');
	redirect(url('register'));
}

if (!isEmail($email)) {
	setFlashMessage('无效的电子邮箱地址');
	redirect(url('register'));
}

if (empty($username)) {
	setFlashMessage('请填写一个您的个性名称');
	redirect(url('register'));
}

if (empty($password)) {
	setFlashMessage('请为您的账号设置一个登录密码');
	redirect(url('register'));
}

if (empty($passwordConfirm)) {
	setFlashMessage('请在确认登录密码中重复输入一遍密码');
	redirect(url('register'));
}

if ($password != $passwordConfirm) {
	setFlashMessage('两次密码输入不一致');
	redirect(url('register'));
}

try {
	User::create([
		'email' => $email,
		'username' => $username,
		'password' => $password,
		'password_confirm' => $passwordConfirm,
	]);
	setFlashMessage('您的账号注册成功，快使用您的注册账号登录吧');
	redirect(url('login'));
} catch (UserRepeatEmailError $e) {
	setFlashMessage('您使用的邮箱地址已被注册');
	redirect(url('register'));
} catch (UserRepeatUsernameError $e) {
	setFlashMessage('您使用的用户名已被注册');
	redirect(url('register'));
} catch (Exception $e) {
	setFlashMessage('因为未知的错误，注册账号失败，请稍后再试<br />错误原因:'.$e->getMessage());	
	redirect(url('register'));
}
