<?php
use Oni\Web\Helper\HTML;

$domainName = $blog['config']['domainName'];
$baseUrl = $blog['config']['baseUrl'];
$disqusShortname = $blog['config']['disqusShortname'];

// Paging
$paging = $container['paging'];
$prevButton = isset($paging['prevUrl'])
    ? HTML::linkTo("{$baseUrl}{$paging['prevUrl']}", '<< Newer Posts') : '';
$nextButton = isset($paging['nextUrl'])
    ? HTML::linkTo("{$baseUrl}{$paging['nextUrl']}", 'Older Posts >>') : '';
$indicator = "{$paging['currentIndex']} / {$paging['totalIndex']}";
?>
<div id="container_page">
    <?php foreach ($container['list'] as $article): ?>
    <article class="post_block">
        <h1 class="title"><?=HTML::linkTo("{$baseUrl}article/{$article['url']}", $article['title'])?></h1>
        <div class="info">
            <div class="archive">
                <i class="fa fa-calendar"></i>
                <?=HTML::linkTo("{$baseUrl}archive/{$article['year']}/", $article['date'])?>
            </div>
            <div class="category">
                <i class="fa fa-folder"></i>
                <?=HTML::linkTo("{$baseUrl}category/{$article['category']}/", $article['category'])?>
            </div>
            <?php foreach ($article['tags'] as $index =>  $tag): ?>
            <div class="tag">
                <i class="fa fa-tag"></i>
                <span><?=HTML::linkTo("{$baseUrl}tag/{$tag}/", $tag)?></span>
            </div>
            <?php endforeach; ?>
            <?php if (null !== $disqusShortname && $article['withMessage']): ?>
            <div class="disqus_comments">
                <i class="fa fa-comment"></i>
                <a href="<?=HTML::linkEncode("{$baseUrl}article/{$article['url']}")?>#disqus_thread">0 Comment</a>
            </div>
            <?php endif; ?>
        </div>
        <div class="content"><?=$article['summary']?></div>
        <a class="more" href="<?="{$baseUrl}article/{$article['url']}"?>">More</a>
    </article>
    <?php endforeach; ?>

    <div id="paging">
        <span class="new"><?=$prevButton?></span>
        <span class="old"><?=$nextButton?></span>
        <span class="count"><?=$indicator?></span>
    </div>
</div>