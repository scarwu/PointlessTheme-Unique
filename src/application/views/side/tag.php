<?php
use Oni\Web\Helper;

$link = "{$system['blog']['baseUrl']}tag";
?>
<div id="side_tag">
    <div class="title">
        <?=Helper::linkTo($link, 'Tag')?>
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