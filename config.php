<?php
defined('VERSION') or die('deny access');

// 网站名称
Config::set('SITE_NAME', '一个留言本');

// 网站时区
config::set('SITE_TIMEZONE', 'Asia/Shanghai');

// MySQL 数据库地址
config::set('DB_HOST', '127.0.0.1');

// MySQL 数据库用户
config::set('DB_USER', 'root');

// MySQL 数据库密码
config::set('DB_PASS', '');

// MySQL 数据库名称
config::set('DB_NAME', 'guestbook');

// MySQL 数据库编码
config::set('DB_CHARSET', 'utf8');

// 默认视图
config::set('DEFAULT_VIEW', 'index');

// 不使用布局内容的视图
config::set('NO_LAYOUT_VIEWS', [
	'login_confirm',
	'register_confirm',
	'create',
	'update',
	'destroy',
]);

// 每页显示的留言数量
config::set('PAGINATION_LIMIT', 5);

// 发帖频率限制（单位：秒）
config::set('PUBLIC_FREQ', 60);

// 管理员账号
Config::set('ADMIN_USERS', [
	'test' => 'test',
	'haha' => '123456',
]);
