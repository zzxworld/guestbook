<?php
defined('VERSION') or die('deny access');

if (!$_POST) {
    setFlashMessage('无效的请求');
    redirect(url());
}

$data = getCommentParam();
if (Comment::denyPublicBy($data)) {
    setFlashMessage('暂时不允许发表留言，请稍后再试');
    redirect(url());
}

Comment::create($data);
signAuthor($data['email']);
redirect(url());
