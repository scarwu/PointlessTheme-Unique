<?php
use Oni\Web\Helper;

$domainName = $systemConfig['blog']['domainName'];
$baseUrl = $systemConfig['blog']['baseUrl'];
$disqusShortname = $systemConfig['blog']['disqusShortname'];

// Paging
$paging = $container['paging'];
$prevButton = isset($paging['prevUrl'])
    ? Helper::linkTo("{$baseUrl}{$paging['prevUrl']}", "<< {$paging['prevTitle']}") : '';
$nextButton = isset($paging['nextUrl'])
    ? Helper::linkTo("{$baseUrl}{$paging['nextUrl']}", "{$paging['nextTitle']} >>") : '';
$indicator = "{$paging['currentIndex']} / {$paging['totalIndex']}";
?>
<div id="container_article">
    <article class="post_block">
        <h1 class="title"><?=$container['title']?></h1>
        <div class="info">
            <div class="archive">
                <i class="fa fa-calendar"></i>
                <?=Helper::linkTo("{$baseUrl}archive/{$container['year']}/", $container['date'])?>
            </div>
            <div class="category">
                <i class="fa fa-folder"></i>
                <?=Helper::linkTo("{$baseUrl}category/{$container['category']}/", $container['category'])?>
            </div>
            <?php foreach ($container['tags'] as $tag): ?>
            <div class="tag">
                <i class="fa fa-tag"></i>
                <?=Helper::linkTo("{$baseUrl}tag/{$tag}/", $tag)?>
            </div>
            <?php endforeach; ?>
            <?php if (null !== $disqusShortname && $container['withMessage']): ?>
            <div class="disqus_comments">
                <i class="fa fa-comment"></i>
                <a href="<?=Helper::linkEncode("{$baseUrl}{$container['url']}")?>#disqus_thread">0 Comment</a>
            </div>
            <?php endif; ?>
            <hr>
            <div class="social_tool">
                <div class="twitter">
                    <a class="twitter-share-button"
                        data-url="//<?=Helper::linkEncode("{$domainName}{$baseUrl}{$container['url']}")?>"
                        data-text="<?="{$container['title']} | {$systemConfig['blog']['name']}"?>"
                        data-lang="en"
                        data-via="xneriscool"></a>
                </div>
                <div class="facebook">
                    <div class="fb-like"
                        data-href="//<?=Helper::linkEncode("{$domainName}{$baseUrl}{$container['url']}")?>"
                        data-layout="button_count"
                        data-action="like"
                        data-show-faces="true"
                        data-share="false"></div>
                </div>
                <div class="google">
                    <div class="g-plusone"
                        data-href="//<?=Helper::linkEncode("{$domainName}{$baseUrl}{$container['url']}")?>"
                        data-size="medium"></div>
                </div>
            </div>
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