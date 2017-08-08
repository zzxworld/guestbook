<div class="container">
    <header class="page">
        <h1>发布留言</h1>
        <a class="btn" href="<?php echo url() ?>">返回</a>
    </header>


    <form action="<?php echo url(['action' => 'create']) ?>" method="post">
        <div>
            <input name="email" type="text" placeholder="电子邮箱" />
        </div>
        <div>
            <input name="username" type="text" placeholder="网名" />
        </div>
        <div>
            <textarea name="content" placeholder="留言内容..." rows="20"></textarea>
        </div>
        <div>
            <button class="btn" type="submit">提交</button>
        </div>
    </form>
</div>
