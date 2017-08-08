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
		<a href="<?php echo url() ?>" class="logo"><?php echo Config::get('SITE_NAME') ?></a>
	</header>

	<?php $message = getFlashMessage(); ?>
	<?php if ($message) { ?>
	<div class="container">
		<p class="message"><?php echo $message; ?></p>
	</div>
	<?php } ?>
