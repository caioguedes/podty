<!DOCTYPE html>
<html lang="en" class="app bg-dark">
<head>
    <meta charset="utf-8" />

    <title>@yield('title')</title>

    <meta name="theme-color" content="#5a6a7a">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="shortcut icon" type="image/png" href="/img/favicon.png"/>
    <script src="/js/jquery.min.js"></script>
    <link rel="stylesheet" href="/js/jPlayer/jplayer.flat.css" type="text/css" />
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="/css/simple-line-icons.css" type="text/css" />
    <link rel="stylesheet" href="/css/font.css" type="text/css" />
    <link rel="stylesheet" href="/css/app.css" type="text/css" />
    <!--[if lt IE 9]>
    <script src="/js/ie/html5shiv.js"></script>
    <script src="/js/ie/respond.min.js"></script>
    <script src="/js/ie/excanvas.js"></script>
    <![endif]-->

    @yield('head')
</head>
<body class="bg-dark lt body">
    @yield('content')

    @yield('footer')

    <!-- Bootstrap -->
    <script src="/js/bootstrap.js"></script>
    <!-- App -->
    <script src="/js/app.js"></script>
    <script src="/js/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/js/app.plugin.js"></script>
    <script type="text/javascript" src="/js/jPlayer/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="/js/jPlayer/add-on/jplayer.playlist.min.js"></script>
    <script type="text/javascript" src="/js/jPlayer/demo.js"></script>

</body>
</html>
