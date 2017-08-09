<?php
defined('VERSION') or die('deny access');
?>

<div class="container">
	<header class="page">
		<h1>登录</h1>
	</header>

	<form action="<?php echo url('login_confirm') ?>" method="post">
		<div>
			<input type="text" name="account" placeholder="用户名或 Email 地址">	
		</div>
		<div>
			<input type="password" name="password" placeholder="登录密码">	
		</div>
		<footer>
			<button type="submit" class="btn">登录</button>
		</footer>
	</form>
</div>
