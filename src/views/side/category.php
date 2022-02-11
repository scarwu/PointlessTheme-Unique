<?php
use Oni\Web\Helper\HTML;

$baseUrl = $blog['config']['baseUrl'];
?>
<div id="side_category">
    <div class="title">
        <?=HTML::linkTo("{$baseUrl}category/", 'Category')?>
    </div>
    <div class="content">
        <?php foreach ($sideList['category'] as $key => $postList): ?>
        <span class="item">
            <?php $count = count($postList); ?>
            <?=HTML::linkTo("{$baseUrl}category/{$key}/", "{$key}({$count})")?>
        </span>
        <?php endforeach; ?>
    </div>
</div>