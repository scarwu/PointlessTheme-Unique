<?php
use Oni\Web\Helper;

$baseUrl = $systemConfig['blog']['baseUrl'];
?>
<div id="side_archive">
    <div class="title">
        <?=Helper::linkTo("{$baseUrl}archive/", 'Archive')?>
    </div>
    <div class="content">
        <?php foreach ($sideList['archive'] as $key => $postList): ?>
        <span class="item">
            <?php $count = count($postList); ?>
            <?=Helper::linkTo("{$baseUrl}archive/{$key}/", "{$key}({$count})")?>
        </span>
        <?php endforeach; ?>
    </div>
</div>