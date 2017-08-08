<?php
defined('VERSION') or die('deny access');
?>
	<footer id="page-bottom">
		<?php if (adminIsLogin()) { ?>
		<a href="<?php echo url(['action'=>'logout']) ?>">退出管理</a>
		<?php } else { ?>
		<a href="<?php echo url(['action'=>'login']) ?>">管理登录</a>
		<?php } ?>
	</footer>
</body>
</html>
