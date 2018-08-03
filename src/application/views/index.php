<!doctype html>
<html class="no-js" style="display: block !important;" lang="<?=$blog['lang']?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta property="og:description" name="description" content="<?=$blog['description']?>">
    <meta property="og:title" content="<?=$blog['title']?>">
    <meta property="og:url" content="https://<?=$blog['url']?>/<?=$post['url']?>">
    <meta property="og:image" content="https://<?=$blog['url']?>/images/icon.jpg">
    <meta property="og:type" content="blog">

    <title><?=$blog['title']?></title>

    <link rel="canonical" href="https://<?=$blog['url']?>/<?$post['url']?>">
    <link rel="author" href="https://plus.google.com/+ScarWu">
    <link rel="image_src" href="https://<?=$blog['url']?>/images/icon.jpg">
    <link rel="shortcut icon" href="https://<?=$blog['url']?>/favicon.ico">
    <link rel="stylesheet" href="<?=$blog['base']?>assets/styles/theme.min.css">

    <script src="<?=$blog['base']?>assets/scripts/vendor/modernizr.min.js"></script>
    <script src="<?=$blog['base']?>assets/scripts/theme.min.js" async></script>

    <script>
        function asyncLoad(src) {
            var s = document.createElement('script');
            s.src = src; s.async = true;
            var e = document.getElementsByTagName('script')[0];
            e.parentNode.insertBefore(s, e);
        }
    </script>
    <?php if(null != $blog['google_analytics']): ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', '<?=$blog['google_analytics']?>', 'auto');
        ga('send', 'pageview');
    </script>
    <?php endif; ?>
</head>
<body>
    <hgroup id="header">
        <h1><a href="/">ScarShow</a></h1>
        <h2><?=$blog['slogan']?></h2>
    </hgroup>
    <nav id="nav">
        <span class="left">
            <a href="<?="{$blog['base']}archive/"?>">Archive</a>
            <a href="<?="{$blog['base']}tag/"?>">Tag</a>
        </span>
        <span class="home">
            <a href="<?=$blog['base']?>">Home</a>
            <span class="arrow"></span>
        </span>
        <span class="right">
            <a href="<?="{$blog['base']}works/"?>">Works</a>
            <a href="<?="{$blog['base']}atom.xml"?>">RSS</a>
        </span>
    </nav>
    <div id="main">
        <div id="container"><?=$block['container']?></div>
        <div id="side">
            <div id="side_search">
                <i class="fa fa-search"></i>
                <form action="https://www.google.com/search?q=as" target="_blank" method="get">
                    <input type="hidden" name="q" value="site:<?=$blog['dn']?>">
                    <input type="text" name="q" placeholder="Search">
                    <input type="submit">
                </form>
            </div>
            <?=$block['side']?>
        </div>
    </div>
    <footer id="footer">
        <span><?=$blog['footer']?></span>
        <p>Powered by Pointless</p>
    </footer>

    <script>
        <?php if(null != $blog['disqus_shortname']): ?>
        var disqus_shortname = '<?=$blog['disqus_shortname']?>';
        if (document.getElementsByTagName('disqus_comments')) {
            asyncLoad('//' + disqus_shortname + '.disqus.com/count.js');
        }
        if (document.getElementById('disqus_thread')) {
            asyncLoad('//' + disqus_shortname + '.disqus.com/embed.js');
        }
        <?php endif; ?>
        if (document.getElementsByTagName('social_tool')) {
            asyncLoad('https://apis.google.com/js/plusone.js');
            asyncLoad('//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1403512429930397&version=v2.0');
            asyncLoad('//platform.twitter.com/widgets.js');
        }
    </script>
</body>
</html>