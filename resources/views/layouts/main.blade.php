<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://ogp.me/ns/fb#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">

    {!! env('META_ROBOTS_NOINDEX_NOFOLLOW') !!}
    <meta property="og:locale" content="en_US" />
    <title>@yield('title')</title>
    @section('meta-tags')
    @show
    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MMGJ3QK');
    </script>
    <!-- End Google Tag Manager -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicons/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicons/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicons/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('favicons/manifest.json')}}">
    <link rel="mask-icon" href="{{asset('favicons/safari-pinned-tab.svg')}}" color="#5bbad5">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/export.css')}}">
    <link rel="stylesheet" href="{{asset('css/jv-jquery-mobile-menu.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css?v=1.2')}}">
    <link rel="stylesheet" href="{{asset('css/media-query.css?v=1.1')}}">
    <link rel="manifest" href="{{asset('manifest.json')}}">
    @stack('head_links')

    @section('styles-css')
    @show
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-3501883465263753",
            enable_page_level_ads: true
        });
    </script>
</head>

<body class="@yield('body-class')">

<div class="hamburger hidden-lg-up">
    <div class="hamburger-inner">
        <div class="bar bar1 hide"></div>
        <div class="bar bar2 cross"></div>
        <div class="bar bar3 cross hidden"></div>
        <div class="bar bar4 hide"></div>
    </div>
</div>
<div class="page">
    <header class="hidden-lg-up">
        <div class="mobile-menu-wrapper">
            <a class="mobileLogo" href="/"><img src="{{asset('images/svg/cv-logo-topbar.svg')}}" alt="Cryptovest" title="Cryptovest"/></a>            
        </div>
        <div class="search-opened" style="display: none;">
            <form action="{{asset('/')}}" style="margin-bottom:0" method="get">
                <span class="fa fa-icon fa-search"></span>
                <input type="search" name="s" placeholder="Search news" id="topMenuSearch">
                <button type='submit' class="btn btn-primary" style="display: none;">Search</button>
                <span class="close-search"><i class="fa fa-times" aria-hidden="true"></i></span>
            </form>            
        </div>
        <div class="nav-item newsNav" id = 'openMobileSearch'>
            <span class="fa fa-icon fa-search"></span>
        </div>
    </header>

    <div class="mainContainer">
        <header class="hidden-md-down">
            <div class="container">
                <input type="hidden" id="subscribeMan" @if(session('successSendMessage')) value="1" @endif>
                @include('front-end.layouts.menu')
            </div>
        </header>
        <div class="main">
            @section('content')
            @show
        </div>
    </div>
    @include('front-end.layouts.footer')
</div>

@include('front-end.layouts.mobile-menu')

@section('newsFormModal')
@show

@include('front-end.layouts.modalsubscribeform')
@yield('secondstep')
{{--@section('joinFormModalButton')--}}
{{--@show--}}
<script src="{{asset('storage/js/api-data.js?v=' . strtotime('now'))}}"></script>
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('js/tether.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/validator.min.js')}}"></script>
<script src="{{asset('js/amcharts.js')}}"></script>
<script src="{{asset('js/serial.js')}}"></script>
<script src="{{asset('js/export.min.js')}}"></script>
<script src="{{asset('js/light.js')}}"></script>
<script src="{{asset('js/TweenMax.min.js')}}"></script>
<script src="{{asset('js/jv-jquery-mobile-menu.js')}}"></script>
<script src="{{asset('js/jquery-ias.min.js')}}"></script>
<script src="{{asset('js/lockfixed.js')}}"></script>
<script src="{{asset('js/countdown2.js')}}"></script>
<script src="{{asset('js/scripts.js')}}"></script>
<script src="{{asset('js/menu-search.js')}}"></script>
<script>
    var mousebottom = 0;
    var pu = 1;
    setTimeout(function () {
        pu = 1;
    }, 5000);

    $(document).mousemove(function (e) {
        var X = e.pageX;
        var Y = e.pageY;

        //console.log(Y - $(window).scrollTop());
        if (Y - $(window).scrollTop() > 200)
            mousebottom = 1;

        if (Y - $(window).scrollTop() < 15 && mousebottom == 1 && pu == 1) {
            var $btn = $("#joinFormModalButton"),
                click = $btn.click.bind($btn);
            setTimeout(click, 0);
            mousebottom = 0;
            pu = 0;
        }
    });
</script>
<script>
    var valSubsc = $('#subscribeMan'). val();
    if(valSubsc == 1) {
        $('#FormModalSubscribeThanks').modal('show');
    }
</script>
@section('jsscripts')
@show
<script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(["init", {
        appId: "6333fbda-3c60-4596-be20-664559cb6cc1",
        autoRegister: false,
        notifyButton: {
            enable: true /* Set to false to hide */
        }
    }]);
</script>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
</body>
</html>
