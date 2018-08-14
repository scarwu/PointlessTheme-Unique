<!doctype html>
<html class="no-js" style="display: block !important;" lang="<?=$system['blog']['lang']?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta property="og:description" name="description" content="<?=$system['blog']['description']?>">
    <meta property="og:title" content="<?=$system['blog']['title']?>">
    <meta property="og:url" content="//<?=$system['blog']['url']?>/<?=$post['url']?>">
    <meta property="og:image" content="//<?=$system['blog']['url']?>/images/icon.jpg">
    <meta property="og:type" content="blog">

    <title><?=$system['blog']['title']?></title>

    <link rel="canonical" href="//<?=$system['blog']['url']?>/<?$post['url']?>">
    <link rel="author" href="//plus.google.com/+ScarWu">
    <link rel="image_src" href="//<?=$system['blog']['url']?>/images/icon.jpg">
    <link rel="shortcut icon" href="//<?=$system['blog']['url']?>/favicon.ico">
    <link rel="stylesheet" href="<?=$system['blog']['baseUrl']?>assets/styles/theme.min.css">

    <script src="<?=$system['blog']['baseUrl']?>assets/scripts/vendor/modernizr.min.js"></script>
    <script src="<?=$system['blog']['baseUrl']?>assets/scripts/theme.min.js" async></script>

    <script>
        function asyncLoad(src) {
            var s = document.createElement('script');
            s.src = src; s.async = true;
            var e = document.getElementsByTagName('script')[0];
            e.parentNode.insertBefore(s, e);
        }
    </script>
    <?php if(null != $system['blog']['googleAnalytics']): ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', '<?=$system['blog']['googleAnalytics']?>', 'auto');
        ga('send', 'pageview');
    </script>
    <?php endif; ?>
</head>
<body>
    <hgroup id="header">
        <h1><a href="/">ScarShow</a></h1>
        <h2><?=$system['blog']['slogan']?></h2>
    </hgroup>

    <nav id="nav">
        <span class="left">
            <a href="<?="{$system['blog']['baseUrl']}archive/"?>">Archive</a>
            <a href="<?="{$system['blog']['baseUrl']}tag/"?>">Tag</a>
        </span>
        <span class="home">
            <a href="<?=$system['blog']['baseUrl']?>">Home</a>
            <span class="arrow"></span>
        </span>
        <span class="right">
            <a href="<?="{$system['blog']['baseUrl']}works/"?>">Works</a>
            <a href="<?="{$system['blog']['baseUrl']}atom.xml"?>">RSS</a>
        </span>
    </nav>

    <div id="main">
        <div id="container"><?=$this->loadContent()?></div>
        <div id="side">
            <div id="side_search">
                <i class="fa fa-search"></i>
                <form action="//www.google.com/search?q=as" target="_blank" method="get">
                    <input type="hidden" name="q" value="site:<?=$system['blog']['domainName']?>">
                    <input type="text" name="q" placeholder="Search">
                    <input type="submit">
                </form>
            </div>
            <?php foreach ($theme['views']['side'] as $name): ?>
            <?=$this->loadPartial("side/{$name}")?>
            <?php endforeach; ?>
        </div>
    </div>

    <footer id="footer">
        <span><?=$system['blog']['footer']?></span>
        <p>Powered by Pointless</p>
    </footer>

    <div id="fb-root"></div>

    <script>
        <?php if(null != $system['blog']['disqusShortname']): ?>
        var disqusShortname = '<?=$system['blog']['disqusShortname']?>';
        if (document.getElementsByTagName('disqus_comments')) {
            asyncLoad('//' + disqusShortname + '.disqus.com/count.js');
        }
        if (document.getElementById('disqus_thread')) {
            asyncLoad('//' + disqusShortname + '.disqus.com/embed.js');
        }
        <?php endif; ?>
        if (document.getElementsByTagName('social_tool')) {
            asyncLoad('//apis.google.com/js/plusone.js');
            asyncLoad('//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1403512429930397&version=v2.0');
            asyncLoad('//platform.twitter.com/widgets.js');
        }
    </script>
</body>
</html>