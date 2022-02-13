<?php
use Oni\Web\Helper\HTML;

$domainName = $blog['config']['domainName'];
$baseUrl = $blog['config']['baseUrl'];
$disqusShortname = $blog['config']['disqusShortname'];

// Paging
$paging = $container['paging'];
$prevButton = isset($paging['prevUrl'])
    ? HTML::linkTo("{$baseUrl}{$paging['prevUrl']}", "<< {$paging['prevTitle']}") : '';
$nextButton = isset($paging['nextUrl'])
    ? HTML::linkTo("{$baseUrl}{$paging['nextUrl']}", "{$paging['nextTitle']} >>") : '';
$indicator = "{$paging['currentIndex']} / {$paging['totalIndex']}";
?>
<div id="container_article">
    <article class="post_block">
        <h1 class="title"><?=$container['title']?></h1>
        <div class="info">
            <div class="archive">
                <i class="fa fa-calendar"></i>
                <?=HTML::linkTo("{$baseUrl}archive/{$container['year']}/", $container['date'])?>
            </div>
            <div class="category">
                <i class="fa fa-folder"></i>
                <?=HTML::linkTo("{$baseUrl}category/{$container['category']}/", $container['category'])?>
            </div>
            <?php foreach ($container['tags'] as $tag): ?>
            <div class="tag">
                <i class="fa fa-tag"></i>
                <?=HTML::linkTo("{$baseUrl}tag/{$tag}/", $tag)?>
            </div>
            <?php endforeach; ?>
            <?php if (null !== $disqusShortname && $container['withMessage']): ?>
            <div class="disqus_comments">
                <i class="fa fa-comment"></i>
                <a href="<?=HTML::linkEncode("{$baseUrl}{$container['url']}")?>#disqus_thread">0 Comment</a>
            </div>
            <?php endif; ?>
        </div>
        <div class="content"><?=$container['content']?></div>
    </article>

    <?php if (null !== $disqusShortname && $container['withMessage']): ?>
    <div id="disqus_thread"></div>
    <?php endif; ?>

    <div id="paging">
        <span class="new"><?=$prevButton?></span>
        <span class="old"><?=$nextButton?></span>
        <span class="count"><?=$indicator?></span>
    </div>
</div>