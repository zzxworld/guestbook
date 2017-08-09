<?php
defined('VERSION') or die('deny access');

$id = (int) arrayFind($_GET, 'id');
$comment = Comment::find($id);

if (!$comment) {
    setFlashMessage('留言不存在');
    redirect(url());
}

if (!can('edit', $comment)) {
    	setFlashMessage('您没有权限进行此操作');
    	redirect(url());
}
?>
<div class="container">
    <header class="page">
        <h1>修改留言</h1>
        <a class="btn" href="<?php echo url() ?>">返回</a>
    </header>

    <form action="<?php echo url(['action' => 'update', 'id' => $comment['id']]) ?>" method="post">
        <div>
            <textarea name="content" placeholder="留言内容..." rows="20"><?php echo $comment['content'] ?></textarea>
        </div>
        <div>
            <button class="btn" type="submit">提交</button>
        </div>
    </form>
</div>
