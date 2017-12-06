@inject('menu', 'App\Helpers')
@php
    $pages      = $menu->getMenu()[0];
    $categories = $menu->getMenu()[1];
@endphp
<nav class="navbar navbar-toggleable-md navbar-light bg-faded m-0 p-0">
    <button class="navbar-toggler navbar-toggler-right hidden-md-down" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="/"><img src="{{asset('images/svg/cv-logo-topbar.svg')}}" alt="Cryptovest" title="Cryptovest"/></a>
    <!--  Only for tablet 768 - 992 (down) -->
    <div class="topSocLink hidden-lg-up hidden-sm-down">
        {{--<a href="#" class="fonticons"><img src="{{asset('images/svg/twitter-ic.svg')}}" alt="twitter" /></a>--}}
        {{--<a href="#" class="fonticons"><img src="{{asset('images/svg/fb-ic.svg')}}" alt="facebook" /></a>--}}
        {{--<a href="#" class="fonticons"><img src="{{asset('images/svg/yt-ic.svg')}}" alt="youtube" /></a>--}}
    </div>
    <!--  Only for tablet 768 - 992 (up) -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
        <ul class="navbar-nav" >
            @if (Request::is("events") || Request::is("events/*"))
                <li class="nav-item newsNav active">
            @else
                <li class="nav-item newsNav">
                    @endif
                    <a class="nav-link" href="/events/">Events</a>
                </li>
            @if (Request::is("ico") || Request::is("ico/*"))
                <li class="nav-item newsNav active">
            @else
                <li class="nav-item newsNav">
            @endif
                <a class="nav-link" href="/ico/">ICOs</a>
                </li>
            @foreach($categories as $cat)
                @if(count($cat->getChildrens) > 0)
                    <li class="nav-item newsNav @if(Request::is("$cat->friendly_url") || Request::is("$cat->friendly_url" . "/*")) active @endif" >
                        <a class="nav-link" href="@if($cat->full_url)/{{$cat->full_url}}@endif/{{$cat->friendly_url}}/">{{Translate::getValue($cat->name_lang_key)}}</a>
                    </li>
                    <li class="nav-item dropdown educationNav @if(Request::is("$cat->friendly_url") || Request::is("$cat->friendly_url" . "/*")) active @endif" style="margin-left: -30px;" >
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            @foreach ($cat->getChildrens as $child)
                                @if ($child->is_active == 1)
                                    <?php
                                    // Temporary solutions
                                    $path = "";
                                    if ($child->full_url) {
                                        $path .= "/$child->full_url";
                                    }
                                    $path .= "/$child->friendly_url/";
                                    $path = preg_replace('|([/]+)|s', '/', $path);

                                    $class = "";
                                    if (Request::is(trim($path, "/"))) {
                                        $class = "active";
                                    }
                                    ?>
                                    <a class="dropdown-item {{$class}}" href="{{$path}}">{{Translate::getValue($child->name_lang_key)}}</a>
                                @endif
                            @endforeach
                        </div>
                    </li>
                @else
                    <li class="nav-item newsNav @if(Request::is($cat->friendly_url) || Request::is($cat->friendly_url . '/*')) active @endif">
                        <a class="nav-link" href="@if($cat->full_url)/{{$cat->full_url}}@endif/{{$cat->friendly_url}}/">{{Translate::getValue($cat->name_lang_key)}}</a>
                    </li>
                @endif
            @endforeach
            @foreach($pages as $key => $page)
                @if (Request::is($key) || Request::is($key . '/*'))
                    <li class="nav-item newsNav active">
                @else
                    <li class="nav-item newsNav">
                @endif
                    <a class="nav-link" href="/{{$key}}/">{{Translate::getValue($page)}}</a>
                </li>
            @endforeach
                <li class="nav-item newsNav">
                    <a href="/feed/" class="nav-link"><span class="fa fa-icon fa-rss"></span></a>
                </li>
                <li class="nav-item newsNav" id = 'openSearch'>
                    <span class="fa fa-icon fa-search"></span>
                </li>
            <!--  Only for Desctop (down) -->
            <li class="nav-item hidden-md-down">
                {{--<a href="#" class="fonticons"><img src="{{asset('images/svg/twitter-ic.svg')}}" alt="twitter"/></a>--}}
                {{--<a href="#" class="fonticons"><img src="{{asset('images/svg/fb-ic.svg')}}" alt="facebook"/></a>--}}
                {{--<a href="#" class="fonticons"><img src="{{asset('images/svg/yt-ic.svg')}}" alt="youtube"/></a>--}}
            </li>
            <!--  Only for Desctop (up) -->
        </ul>
        <div class="search-opened" style="display: none;">
            <form action="{{asset('/')}}" style="margin-bottom:0" method="get">
                <span class="fa fa-icon fa-search"></span>
                <input type="search" name="s" placeholder="Search news" id="topMenuSearch">
                <button type='submit' class="btn btn-primary">Search</button>
                <span class="close-search"><i class="fa fa-times" aria-hidden="true"></i></span>
            </form>
        </div>
    </div>
</nav>