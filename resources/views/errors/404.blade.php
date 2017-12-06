<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://ogp.me/ns/fb#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">

    <meta property="og:locale" content="en_US" />
    <title>404</title>
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
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/media-query.css')}}">
    <style>
        .error-page .page {
            background:url('/images/page404.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            height: 100vh;
        }
        .error-page .error-main .titleBlock {
            color: #3F4245;
            font-size: 50px;
            line-height: 74px;
            font-family: 'ProximaNova-Black', sans-serif;
            margin-bottom: 0;

        }
        .error-page .error-main .error-wrapper {
            padding-top: 44%;
        }
        .error-page .error-main .error-wrapper p {
            padding-top: 11px;
            font-size: 18px;
        }
        .error-page .error-main .error-wrapper button {
            width: 203px;
            background: #735161;
            border-color: #735161;
            color: #FFFFFF;
            font-size: 18px;
            line-height: 1;
            height: 45px;
            cursor: pointer!important;
            border-radius: 0;
        }
    </style>
</head>

<body class="error-page">

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
        <a class="mobileLogo" href="/"><img src="{{asset('images/svg/cv-logo-topbar.svg')}}" alt="Cryptovest" title="Cryptovest"/></a>
    </header>
    <div class="mainContainer">
        <header class="hidden-md-down">
            <div class="container">
                <input type="hidden" id="subscribeMan" @if(session('isSubscribe')) value="1" @endif>
                @include('front-end.layouts.menu')
            </div>
        </header>
        <div class="main error-main">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-8 col-sm-6 col-xs-0"></div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="error-wrapper">
                            <h2 class="titleBlock">Oops!</h2>
                            <p>The page you were <br>
                                looking for doesn't exist</p>
                            <a href="/">
                                <button type="submit" class="btn btn-primary">
                                    Home Page
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/js/tether.min.js"></script>
<script src="/js/bootstrap.js"></script>


<script src="/js/amcharts.js"></script>
<script src="/js/serial.js"></script>
<script src="/js/export.min.js"></script>
<script src="/js/light.js"></script>

<script src="/js/TweenMax.min.js"></script>
<script src="/js/jv-jquery-mobile-menu.js"></script>

<script src="/js/jquery-ias.min.js"></script>

<script src="/js/lockfixed.js"></script>


<script src="/js/scripts.js"></script>



</body>
</html>