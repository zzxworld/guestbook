<?php
defined('VERSION') or die('deny access');
?>
<div class="container">
    <header class="page">
        <h1>发布留言</h1>
        <a class="btn" href="<?php echo url() ?>">返回</a>
    </header>


    <form action="<?php echo url(['action' => 'create']) ?>" method="post">
        <div>
            <textarea name="content" placeholder="留言内容..." rows="20"></textarea>
        </div>
        <div>
            <button class="btn" type="submit">提交</button>
        </div>
    </form>
</div>
