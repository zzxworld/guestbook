<?php
defined('VERSION') or die('deny access');

$id = (int) getParam('id');
$comment = Comment::find($id);
if (!$comment) {
	setFlashMessage('找不到您要删除的留言');
	redirect(url());
}

if (!can('delete', $comment)) {
	setFlashMessage('您没有权限进行此操作');
	redirect(url());
}

Comment::destroy($id);
redirect(url());
