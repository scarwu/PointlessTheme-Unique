<?php
use Oni\Web\Helper;

$link = "{$system['blog']['baseUrl']}archive";
?>
<div id="side_archive">
    <div class="title">
        <?=Helper::linkTo($link, 'Archive')?>
    </div>
    <div class="content">
        <?php foreach ($list as $key => $value): ?>
        <span class="item">
            <?php $count = count($value); ?>
            <?=Helper::linkTo("{$link}/{$key}", "{$key}({$count})")?>
        </span>
        <?php endforeach; ?>
    </div>
</div>