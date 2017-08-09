<?php
defined('VERSION') or die('deny access');
?>

<div class="container">
	<header class="page">
		<h1>注册</h1>
		<a href="<?php echo url('login') ?>" class="btn">登录</a>
	</header>

	<form action="<?php echo url('register_confirm') ?>" method="post">
		<div>
			<input type="text" name="email" placeholder="电子邮箱">
		</div>
		<div>
			<input type="text" name="username" placeholder="用户名">
		</div>
		<div>
			<input type="password" name="password" placeholder="登录密码">
		</div>
		<div>
			<input type="password" name="password_confirm" placeholder="确认登录密码">
		</div>
		<footer>
			<button type="submit" class="btn">确认注册</button>	
		</footer>
	</form>
</div>
