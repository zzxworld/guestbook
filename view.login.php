<?php
defined('VERSION') or die('deny access');
?>

<div class="container">
	<header class="page">
		<h1>登录</h1>
		<a class="btn" href="<?php echo url('register') ?>">注册 </a>
	</header>

	<form action="<?php echo url('login_confirm') ?>" method="post">
		<div>
			<input type="text" name="account" placeholder="用户名或 Email 地址">	
		</div>
		<div>
			<input type="password" name="password" placeholder="登录密码">	
		</div>
		<div>
			<button type="submit" class="btn">登录</button>
		</div>
	</form>
</div>
