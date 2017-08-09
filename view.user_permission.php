<?php
defined('VERSION') or die('deny access');

$user = User::find(intval(getParam('id')));
?>

<div class="container">
	<header class="page">
		<h1>编辑 <?php echo $user['username'] ?> 的权限</h1>
		<a class="btn" href="<?php echo url('user') ?>">返回</a>
	</header>

	<form action="<?php echo url('user_permission_confirm') ?>" method="post">
		<div>
			<?php foreach (Config::get('PERMISSION_LIST') as $code => $label) { ?>
			<label><input type="checkbox" value="<?php echo $code ?>" /> <?php echo $label ?></label>
			<?php } ?>
		</div>
		<div>
			<button class="btn" type="submit">保存</button>	
		</div>
	</form>
</div>
