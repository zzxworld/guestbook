<?php
defined('VERSION') or die('deny access');

$result = Comment::listOf(['page' => (int) getParam('page')]);
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

                    by <span class="author"><?php echo Comment::formatUser($rs['user_id']) ?></span> 

                    from <span class="ip"><?php echo Comment::formatIP($rs['ip']) ?></span>

                    <div class="actions">
		    	<?php if (can('edit', $rs)) { ?>
                        <a class="btn" href="<?php echo url(['action' => 'edit', 'id' => $rs['id']]) ?>">修改</a>
                    	<?php } ?>

		    	<?php if (can('delete', $rs)) { ?>
                        <a class="btn" href="<?php echo url(['action' => 'destroy', 'id' => $rs['id']]) ?>" onclick="return confirm('确定要删除此留言吗？')">删除</a>
                    	<?php } ?>
                    </div>
                </footer>
            </article>
        <?php } ?>
    </div>


    <?php if ($pagination['page_total'] > 1) { ?>
    <div class="pagination">
        <?php if ($pagination['page'] > 1) { ?>
        <a href="<?php echo url(['page' => $pagination['page_prev']]) ?>">上页</a>
        <?php } ?>
        <span><?php echo $pagination['page'] ?> / <?php echo $pagination['page_total'] ?></span>
        <?php if ($pagination['page'] < $pagination['page_total']) { ?>
        <a href="<?php echo url(['page' => $pagination['page_next']]) ?>">下页</a>
        <?php } ?>
    </div>
    <?php } ?>
</div>
