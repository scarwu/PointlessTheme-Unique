<?php
use Oni\Web\Helper\HTML;

$baseUrl = $systemConfig['blog']['baseUrl'];
?>
<div id="side_tag">
    <div class="title">
        <?=HTML::linkTo("{$baseUrl}tag/", 'Tag')?>
    </div>
    <div class="content">
        <?php foreach ($sideList['tag'] as $key => $postList): ?>
        <span class="item">
            <?php $count = count($postList); ?>
            <?=HTML::linkTo("{$baseUrl}tag/{$key}/", "{$key}({$count})")?>
        </span>
        <?php endforeach; ?>
    </div>
</div>