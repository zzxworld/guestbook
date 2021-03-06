<?php
defined('VERSION') or die('deny access');

$permissionMapping = Config::get('PERMISSION_LIST');
$users = User::listOf(['page' => intval(getParam('page'))]);
$pagination = $users['pagination'];
$admin = User::findAdmin();
?>
<div class="container">
	<header class="page">
		<h1>用户管理</h1>
	</header>

	<table class="table" id="user-list">
		<thead>
			<tr>
				<th>ID</th>
				<th>电子邮箱</th>
				<th>用户名</th>
				<th>权限</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users['items'] as $rs) { ?>
			<tr>
				<td><?php echo $rs['id'] ?></td>
				<td class="name">
					<?php echo $rs['email'] ?>
					<?php if ($admin['id'] == $rs['id']){ ?>
					<span>管理员</span>
					<?php } ?>
				</td>
				<td><?php echo $rs['username'] ?></td>
				<td>
					<?php foreach (User::findPermissions($rs['id']) as $code) { ?>
					<?php if (isset($permissionMapping[$code])) { ?>
					<span class="permission"><?php echo $permissionMapping[$code] ?></span>
					<?php } ?>
					<?php } ?>
				</td>
				<td>
					<a class="btn" href="<?php echo url(['action' => 'user_permission', 'id' => $rs['id']]) ?>">设置权限</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>


	<?php if ($pagination['page_total'] > 1) { ?>
	<div class="pagination">
		<?php if ($pagination['page'] > 1) { ?>
		<a href="<?php echo url(['page' => $pagination['page_prev']]) ?>">上页</a>
		<?php } ?>
		<span><?php echo $pagination['page'] ?> / <?php echo $pagination['page_total'] ?></span>
		<?php if ($pagination['page'] < $pagination['page_total']) { ?>
		<a href="<?php echo url(['page' => $pagination['page_next']]) ?>">下页</a>
		<?php } ?>
	</div>
	<?php } ?>
<div>
