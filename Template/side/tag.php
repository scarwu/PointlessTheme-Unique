<div id="side_tag">
    <div class="title">
        <?=linkTo("{$blog['base']}tag/", 'Tag')?>
    </div>
    <div class="content">
        <?php foreach((array)$list as $key => $value): ?>
        <span class="item">
            <?php $count = count($value); ?>
            <?=linkTo("{$blog['base']}tag/$key/", "$key($count)")?>
        </span>
        <?php endforeach; ?>
    </div>
</div>