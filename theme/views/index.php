<?php
$lang = $systemConfig['blog']['lang'];
$slogan = $systemConfig['blog']['slogan'];
$footer = $systemConfig['blog']['footer'];

$domainName = $systemConfig['blog']['domainName'];
$baseUrl = $systemConfig['blog']['baseUrl'];

$googleAnalytics = $systemConfig['blog']['googleAnalytics'];
$disqusShortname = $systemConfig['blog']['disqusShortname'];

$title = isset($container['title'])
    ? "{$container['title']} | {$systemConfig['blog']['name']}"
    : $systemConfig['blog']['name'];
$description = (!isset($container['description']) || '' === $container['description'])
    ? $systemConfig['blog']['description']
    : $container['description'];
?>
<!doctype html>
<html class="no-js" style="display: block !important;" lang="<?=$lang?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta property="og:description" name="description" content="<?=$description?>">
    <meta property="og:title" content="<?=$title?>">
    <meta property="og:url" content="//<?="{$domainName}{$baseUrl}{$container['url']}"?>">
    <meta property="og:image" content="//<?="{$domainName}{$baseUrl}"?>images/icon.jpg">
    <meta property="og:type" content="blog">

    <title><?=$title?></title>

    <link rel="canonical" href="//<?="{$domainName}{$baseUrl}{$container['url']}"?>">
    <link rel="author" href="//plus.google.com/+ScarWu">
    <link rel="image_src" href="//<?="{$domainName}{$baseUrl}"?>images/icon.jpg">
    <link rel="shortcut icon" href="//<?="{$domainName}{$baseUrl}"?>favicon.ico">
    <link rel="stylesheet" href="<?=$baseUrl?>assets/styles/theme.min.css">

    <script src="<?=$baseUrl?>assets/scripts/vendor/modernizr.min.js"></script>
    <script src="<?=$baseUrl?>assets/scripts/theme.min.js" async></script>

    <script>
        function asyncLoad(src) {
            var s = document.createElement('script');
            s.src = src; s.async = true;
            var e = document.getElementsByTagName('script')[0];
            e.parentNode.insertBefore(s, e);
        }
    </script>
    <?php if(null !== $googleAnalytics): ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', '<?=$googleAnalytics?>', 'auto');
        ga('send', 'pageview');
    </script>
    <?php endif; ?>
</head>
<body>
    <hgroup id="header">
        <h1><a href="/">ScarShow</a></h1>
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
            <?php foreach ($themeConfig['views']['side'] as $name): ?>
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
    <script>
        if (document.getElementsByTagName('social_tool')) {
            asyncLoad('//apis.google.com/js/plusone.js');
            asyncLoad('//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1403512429930397&version=v2.0');
            asyncLoad('//platform.twitter.com/widgets.js');
        }
    </script>
</body>
</html>