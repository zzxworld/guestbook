<?php
defined('VERSION') or die('deny access');

if (!isPostMethod()) {
    redirect(url());
}

$content = getParam('content');
if (empty($content)) {
	setFlashMessage('请输入你的留言内容');
	redirect(backURL());
}

$ip = findIP();
if (Comment::denyPublicBy($ip)) {
    setFlashMessage('请不要太频繁发布留言，请稍后再试');
    redirect(url());
}

$data = [
	'user_id' => $currentUser ? $currentUser['id'] : 0,
	'content' => htmlentities($content),
	'ip' => $ip,
	'created_at' => date('Y-m-d H:i:s'),
];

Comment::create($data);
redirect(url());
