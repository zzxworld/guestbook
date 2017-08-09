<?php
defined('VERSION') or die('deny access');
?><DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title><?php echo Config::get('SITE_NAME') ?></title>
<link rel="stylesheet" text="text/css" href="<?php echo assertURL('style.css') ?>" />
</head>
<body>
	<header id="page-top">
		<div class="container">
			<a href="<?php echo url() ?>" class="logo"><?php echo Config::get('SITE_NAME') ?></a>
			<nav>
				<ul>
					<?php if (isLogined()) { ?>

					<?php if (isAdmin()) { ?>
					<li><a href="<?php echo url('user') ?>">用户管理</a></li>
					<?php } ?>

					<li><a href="<?php echo url('home') ?>">个人资料</a></li>
					<li><a href="<?php echo url('logout') ?>" onclick="return confirm('确定要退出吗？')">退出</a></li>
					<?php } else { ?>

					<li><a href="<?php echo url('login') ?>">登录</a></li>
					<li><a href="<?php echo url('register') ?>">注册</a></li>

					<?php } ?>
				</ul>
			</nav>
		</div>
	</header>

	<?php $message = getFlashMessage(); ?>
	<?php if ($message) { ?>
	<div class="container">
		<p class="message"><?php echo $message; ?></p>
	</div>
	<?php } ?>
