<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
            | CMS
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- global css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- font Awesome -->
    <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/styles/black.css') }}" rel="stylesheet" type="text/css" id="colorscheme"/>
    <link href="{{ asset('assets/css/panel.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/metisMenu.css') }}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="{{ asset('assets/css/jquery.loadingModal.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/lobibox.min.css') }}" type="text/css">
    <!-- end of global css -->
    <!--page level css-->
@yield('header_styles')
<!--end of page level css-->
</head>

<body class="skin-josh">

<header class="header">
    <a href="/admin" class="logo">
        {{--<img src="{{ asset('assets/img/logo.png') }}" alt="logo">--}}
        <h1 class="logo-name-admin">{{Translate::getValue(Auth::user()->first_name_lang_key)}} {{Translate::getValue(Auth::user()->last_name_lang_key)}}</h1>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <div class="riot">
                            <div>

                                <span>
                                        <i class="caret"></i>
                                    </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">

                                <img src="{!! (Auth::user()->profile_image) ? asset(Auth::user()->profile_image) : asset('assets/img/authors/avatar3.jpg') !!}"
                                     class="img-responsive img-circle" alt="User Image">
                        </li>
                        <!-- Menu Body -->

                    <!-- Menu Footer-->
                        <li class="user-footer">

                            <div class="pull-right">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hide">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <section class="sidebar ">
            <div class="page-sidebar  sidebar-nav">
                <div class="nav_icons">

                </div>
                <div class="clearfix"></div>
                <!-- BEGIN SIDEBAR MENU -->
                <ul id="menu" class="page-sidebar-menu">
                    @include('admin/layouts/menu')
                </ul>
                <!-- END SIDEBAR MENU -->
            </div>
        </section>
    </aside>
    <aside class="right-side">

        <!-- Notifications -->
    @include('admin/layouts/notifications')
    <!-- Content -->
        @yield('content')
    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<!-- global js -->
<script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!--livicons-->
<script src="{{ asset('assets/vendors/livicons/minified/raphael-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/livicons/minified/livicons-1.4.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/josh.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/metisMenu.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/holder-master/holder.js') }}" type="text/javascript"></script>
<script src="{{asset('assets/js/jquery.loadingModal.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/lobibox.min.js')}}" type="text/javascript"></script>

<!-- end of global js -->
<!-- begin page level js -->

<script type="text/javascript">
    $(document).ready(function() {
        Lobibox.base.DEFAULTS = $.extend({}, Lobibox.base.DEFAULTS, {
            iconSource: 'fontAwesome',
            soundPath : "<?=url('assets/sounds')?>/"
        });
        Lobibox.notify.DEFAULTS = $.extend({}, Lobibox.notify.DEFAULTS, {
            iconSource: 'fontAwesome',
            soundPath : "<?=url('assets/sounds')?>/"

        });
    });
</script>
@yield('footer_scripts')
<!-- end page level js -->
</body>
</html>
