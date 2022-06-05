<?php
use Oni\Web\Helper\HTML;

$postfix = time();
$name = $blog['config']['name'];
$lang = $blog['config']['lang'];
$slogan = $blog['config']['slogan'];
$footer = $blog['config']['footer'];

$domainName = $blog['config']['domainName'];
$baseUrl = $blog['config']['baseUrl'];

$googleAnalytics = $blog['config']['googleAnalytics'];
$disqusShortname = $blog['config']['disqusShortname'];

$title = isset($container['title'])
    ? "{$container['title']} | {$blog['config']['name']}"
    : $blog['config']['name'];
$description = (!isset($container['description']) || '' === $container['description'])
    ? $blog['config']['description']
    : $container['description'];
?>
<hgroup id="header">
    <h1><?=HTML::linkTo($baseUrl, $name)?></h1>
    <h2><?=$slogan?></h2>
</hgroup>

<nav id="nav">
    <span class="left">
        <a href="<?=$baseUrl?>works/">Works</a>
    </span>
    <span class="home">
        <a href="<?=$baseUrl?>">Home</a>
        <span class="arrow"></span>
    </span>
    <span class="right">
        <a href="<?=$baseUrl?>atom.xml">RSS</a>
    </span>
</nav>

<div id="main">
    <div id="container">
        <?=$this->loadContent()?>
    </div>
    <div id="side">
        <div id="side_search">
            <i class="fa fa-search"></i>
            <form action="//www.google.com/search?q=as" target="_blank" method="get">
                <input type="hidden" name="q" value="site:<?=$domainName?>">
                <input type="text" name="q" placeholder="Search">
                <input type="submit">
            </form>
        </div>
        <?php foreach ($theme['config']['views']['side'] as $name): ?>
        <?=$this->loadPartial("side/{$name}")?>
        <?php endforeach; ?>
    </div>
</div>

<footer id="footer">
    <span><?=$footer?></span>
    <p>Powered by Pointless</p>
</footer>

<div id="fb-root"></div>

<?php if(null !== $disqusShortname): ?>
<script>
    var disqusShortname = '<?=$disqusShortname?>';

    if (document.getElementsByTagName('disqus_comments')) {
        asyncLoad('//' + disqusShortname + '.disqus.com/count.js');
    }

    if (document.getElementById('disqus_thread')) {
        asyncLoad('//' + disqusShortname + '.disqus.com/embed.js');
    }
</script>
<?php endif; ?>