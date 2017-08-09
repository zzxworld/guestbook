<?php
defined('VERSION') or die('deny access');
?>

<div class="container">
	<div class="profile">
		<h1><?php echo $currentUser['username'] ?></h1>
		<ul>
			<li>电子邮箱: <?php echo $currentUser['email'] ?></li>
			<li>注册时间: <?php echo $currentUser['created_at'] ?></li>
			<li>最近来访: <?php echo $currentUser['login_at'] ?></li>
		</ul>
	</div>
</div>
