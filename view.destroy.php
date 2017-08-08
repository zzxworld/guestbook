<?php
defined('VERSION') or die('deny access');

$id = (int) getParam('id');
$comment = Comment::find($id);

if ($comment && canEdit($comment)) {
    Comment::destroy($id);
}

redirect(url());
