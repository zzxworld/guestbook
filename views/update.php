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

$id = (int) getParam('id');
$comment = Comment::find($id);
if (!$comment) {
    setFlashMessage('未找到要编辑的留言');
    redirect(url());
}

if (!can('edit', $comment)) {
	setFlashMessage('您没有权限进行此操作');
	redirect(url());
}

$data = [
	'content' => htmlentities($content),
	'updated_at' => date('Y-m-d H:i:s'),
];

Comment::update($id, $data);
redirect(url());
