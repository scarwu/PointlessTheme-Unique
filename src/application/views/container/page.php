<?php
use Oni\Web\Helper;

$prevButton = isset($paging['p_url'])
    ? Helper::linkTo($paging['p_url'], '<< Newer Posts') : '';

$nextButton = isset($paging['n_url'])
    ? Helper::linkTo($paging['n_url'], 'Older Posts >>') : '';
?>
<div id="container_page">
    <?php foreach ($post['list'] as $article): ?>
    <article class="post_block">
        <h1 class="title"><?=Helper::linkTo("{$system['blog']['baseUrl']}article/{$article['url']}", $article['title'])?></h1>
        <div class="info">
            <div class="date">
                <i class="fa fa-calendar"></i>
                <?=Helper::linkTo("{$system['blog']['baseUrl']}archive/{$article['year']}/", $article['date'])?>
            </div>
            <?php foreach ($article['tag'] as $index =>  $tag): ?>
            <div class="tag">
                <i class="fa fa-tag"></i>
                <span><?=Helper::linkTo("{$system['blog']['baseUrl']}tag/$tag/", $tag)?></span>
            </div>
            <?php endforeach; ?>
            <?php if (null != $system['blog']['disqusShortname'] && $article['message']): ?>
            <div class="disqus_comments">
                <i class="fa fa-comment"></i>
                <a href="<?=Helper::linkEncode("{$system['blog']['baseUrl']}article/{$article['url']}")?>#disqus_thread">0 Comment</a>
            </div>
            <?php endif; ?>
            <hr>
            <div class="social_tool">
                <div class="twitter">
                    <a class="twitter-share-button" data-url="http://<?=Helper::linkEncode("{$system['blog']['url']}article/{$article['url']}")?>" data-text="<?="{$article['title']} | {$system['blog']['title']}"?>" data-lang="en" data-via="xneriscool"></a>
                </div>
                <div class="facebook">
                    <div class="fb-like" data-href="http://<?=Helper::linkEncode("{$system['blog']['url']}article/{$article['url']}")?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
                </div>
                <div class="google">
                    <div class="g-plusone" data-href="http://<?=Helper::linkEncode("{$system['blog']['url']}article/{$article['url']}")?>" data-size="medium"></div>
                </div>
            </div>
        </div>
        <div class="content"><?=$article['summary']?></div>
        <a class="more" href="<?="{$system['blog']['baseUrl']}article/{$article['url']}"?>">More</a>
    </article>
    <?php endforeach; ?>

    <div id="paging">
        <span class="new">
            <?=$prevButton?>
        </span>
        <span class="old">
            <?=$nextButton?>
        </span>
        <span class="count">
            <?="{$paging['index']} / {$paging['total']}"?>
        </span>
    </div>
</div>