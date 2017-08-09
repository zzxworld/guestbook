<?php
defined('VERSION') or die('deny access');

$users = User::listOf([
	'page' => intval(getParam('page')),
]);
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
				<th>注册时间</th>
				<th>最近登录</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users['items'] as $rs) { ?>
			<tr>
				<td><?php echo $rs['id'] ?></td>
				<td><?php echo $rs['email'] ?></td>
				<td><?php echo $rs['username'] ?></td>
				<td><?php echo $rs['created_at'] ?></td>
				<td><?php echo $rs['logined_at'] ?></td>
				<td>
					<a class="btn" href="<?php echo url('user_permission') ?>">设置权限</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
<div>
