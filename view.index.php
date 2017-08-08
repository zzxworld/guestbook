<?php
defined('VERSION') or die('deny access');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$result = Comment::listOf(['page' => arrayFind($_GET,'page', 1)]);
$pagination = $result['pagination'];
?>

<div class="container">
    <header class="page">
        <a class="btn" href="<?php echo url(['action' => 'new']) ?>">发表</a>
    </header>
    <div>
        <?php foreach($result['items'] as $rs) { ?>

            <article>
                <div><?php echo Comment::formatContent($rs['content']) ?></div>

                <footer>

                    <time datetime=<?php echo $rs['created_at'] ?>><?php echo Comment::formatDateToReadable($rs['created_at']) ?></time>

                    by <span class="author"><?php echo $rs['username'] ? $rs['username'] : '无名氏' ?></span> 

                    from <span class="ip"><?php echo Comment::formatIP($rs['ip']) ?></span>

                    <?php if (canEdit($rs)) { ?>
                    <div class="actions">
                        <a class="btn" href="<?php echo url(['action' => 'edit', 'id' => $rs['id']]) ?>">修改</a>
                        <a class="btn" href="<?php echo url(['action' => 'destroy', 'id' => $rs['id']]) ?>" onclick="return confirm('确定要删除此留言吗？')">删除</a>
                    </div>
                    <?php } ?>
                </footer>
            </article>
        <?php } ?>
    </div>

    <div class="pagination">
        <?php if ($pagination['page'] > 1) { ?>
        <a href="<?php echo url(['page' => $pagination['page_prev']]) ?>">上页</a>
        <?php } ?>
        <span><?php echo $page ?> / <?php echo $pagination['page_total'] ?></span>
        <?php if ($pagination['page'] < $pagination['page_total']) { ?>
        <a href="<?php echo url(['page' => $pagination['page_next']]) ?>">下页</a>
        <?php } ?>
    </div>
</div>
