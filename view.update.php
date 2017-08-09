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

Comment::update($id, $data);
signAuthor($data['email']);
redirect(url());
