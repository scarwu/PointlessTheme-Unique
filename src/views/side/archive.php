<?php
use Oni\Web\Helper\HTML;

$baseUrl = $blog['config']['baseUrl'];
?>
<div id="side_archive">
    <div class="title">
        <?=HTML::linkTo("{$baseUrl}archive/", 'Archive')?>
    </div>
    <div class="content">
        <?php foreach ($sideList['archive'] as $key => $postList): ?>
        <span class="item">
            <?php $count = count($postList); ?>
            <?=HTML::linkTo("{$baseUrl}archive/{$key}/", "{$key}({$count})")?>
        </span>
        <?php endforeach; ?>
    </div>
</div>