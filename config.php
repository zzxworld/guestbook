<?php
defined('VERSION') or die('deny access');

// 网站名称
Config::set('SITE_NAME', '一个留言本');

// 网站时区
Config::set('SITE_TIMEZONE', 'Asia/Shanghai');

// MySQL 数据库地址
Config::set('DB_HOST', '127.0.0.1');

// MySQL 数据库用户
Config::set('DB_USER', 'root');

// MySQL 数据库密码
Config::set('DB_PASS', '');

// MySQL 数据库名称
Config::set('DB_NAME', 'guestbook');

// MySQL 数据库编码
Config::set('DB_CHARSET', 'utf8');

// 默认视图
Config::set('DEFAULT_VIEW', 'index');

// 不使用布局内容的视图
Config::set('NO_LAYOUT_VIEWS', [
	'login_confirm',
	'register_confirm',
	'logout',
	'create',
	'update',
	'destroy',
]);

// 每页显示的留言数量
Config::set('PAGINATION_LIMIT', 5);

// 发帖频率限制（单位：秒）
Config::set('PUBLIC_FREQ', 60);

// 管理员账号
Config::set('ADMIN_USERS', [
	'test' => 'test',
	'haha' => '123456',
]);

// 系统权限定义
Config::set('PERMISSION_LIST', [
	'add' => '添加留言',
	'edit' => '编辑留言',
	'delete' => '删除留言',
	'manage' => '管理留言'
]);

// 用户默认权限
Config::set('PERMISSION_DEFAULT', ['add', 'edit']);
