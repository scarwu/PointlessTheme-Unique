<?php
use Oni\Web\Helper;

$prevButton = isset($paging['p_url'])
    ? Helper::linkTo($paging['p_url'], "<< {$paging['p_title']}") : '';

$nextButton = isset($paging['n_url'])
    ? Helper::linkTo($paging['n_url'], "{$paging['n_title']} >>") : '';
?>
<div id="container_category">
    <article class="post_block">
        <h1 class="title"><?=$post['title']?></h1>
        <div class="list">
            <?php foreach($post['list'] as $article): ?>
            <section>
                <h1><?=Helper::linkTo("{$system['blog']['baseUrl']}article/{$article['url']}", $article['title'])?></h1>
                <span>
                    <i class="fa fa-calendar"></i>
                    <?=Helper::linkTo("{$system['blog']['baseUrl']}archive/{$article['year']}/", $article['date'])?>
                </span>
                <span>
                    <i class="fa fa-category"></i>
                    <?=Helper::linkTo("{$system['blog']['baseUrl']}category/$article['category']/", $article['category'])?>
                </span>
            </section>
            <?php endforeach; ?>
        </div>
    </article>

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