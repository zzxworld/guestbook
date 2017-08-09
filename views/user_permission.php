<?php
defined('VERSION') or die('deny access');

$user = User::find(intval(getParam('id')));
if (!$user) {
	setFlashMessage('没有找到要操作的用户');
	redirect(url('user'));
}
$permissions = User::findPermissions($user['id']);
$defaultPermissions = Config::get('PERMISSION_DEFAULT');
?>

<div class="container">
	<header class="page">
		<h1>编辑 <?php echo $user['username'] ?> 的权限</h1>
		<a class="btn" href="<?php echo url('user') ?>">返回</a>
	</header>

	<form action="<?php echo url(['action' => 'user_permission_confirm', 'id' => $user['id']]) ?>" method="post">
		<div class="checkbox-list">
			<?php foreach (Config::get('PERMISSION_LIST') as $code => $label) { ?>
			<?php
				$state = '';
				if (in_array($code, $permissions)) {
					$state = ' checked="checked"';
				}

				if (in_array($code, $defaultPermissions)) {
					$state = ' checked="checked" disabled="disabled"';
				}
			?>
			<label><input type="checkbox" name="permissions[]" value="<?php echo $code ?>"<?php echo $state ?>> <?php echo $label ?></label>
			<?php } ?>
		</div>
		<footer>
			<button class="btn" type="submit">保存</button>	
		</footer>
	</form>
</div>
