<?php
$disqusShortname = $systemConfig['blog']['disqusShortname'];
?>
<div id="container_describe">
    <article class="post_block">
        <h1 class="title"><?=$container['title']?></h1>
        <div class="content"><?=$container['content']?></div>
    </article>

    <?php if(null !== $disqusShortname && $container['withMessage']): ?>
    <div id="disqus_thread"></div>
    <?php endif; ?>
</div>