<?php
defined('VERSION') or die('deny access');

if (!$_POST) {
    redirect(url());
}

$data = getCommentParam();

$id = (int) arrayFind($_GET, 'id');
$comment = Comment::find($id);
if (!$comment) {
    setFlashMessage('未找到要编辑的留言');
    redirect(url());
}

if (!can('edit', $comment)) {
	setFlashMessage('您没有权限进行此操作');
	redirect(url());
}

Comment::update($id, $data);
signAuthor($data['email']);
redirect(url());
