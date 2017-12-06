@inject('menu', 'App\Helpers')
@php
    $pages      = $menu->getMenu()[0];
    $categories = $menu->getMenu()[1];
@endphp
<div class="mobile-menu hidden-lg-up">        
    <div class="mobile-nav">        
        <a class="mobileMenuLogo" href="/"><img src="{{asset('images/svg/cv-logo-topbar.svg')}}" alt="Cryptovest" title="Cryptovest"/></a>        
        <div class="hamburger hidden-lg-up open">
            <div class="hamburger-inner">
                <div class="bar bar1 hide"></div>
                <div class="bar bar2 cross"></div>
                <div class="bar bar3 cross hidden"></div>
                <div class="bar bar4 hide"></div>
            </div>
        </div>
        <ul class="navbar-nav">
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
                        <li class="nav-item newsNav" @if(Request::is($cat->friendly_url) || Request::is($cat->friendly_url . '/*')) active @endif>
                            <a class="nav-link" href="@if($cat->full_url)/{{$cat->full_url}}@endif/{{$cat->friendly_url}}/">{{Translate::getValue($cat->name_lang_key)}}</a>
                        </li>
                        <li class="nav-item dropdown educationNav" @if(Request::is($cat->friendly_url) || Request::is($cat->friendly_url . '/*')) active @endif>
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
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
                        <li class="nav-item newsNav" @if(Request::is($cat->friendly_url) || Request::is($cat->friendly_url . '/*')) active @endif>
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
        </ul>
        <div class="bottomLinkMobileMenu">
            {{--<div class="followUs">--}}
                {{--<h3>follow us</h3>--}}
                {{--<a href="#" class="fb"><img src="{{asset('images/svg/Facebook_Color.svg')}}" alt="facebook"/></a>--}}
                {{--<a href="#" class="yt"><img src="{{asset('images/svg/Youtube.svg')}}" alt="youtube"/></a>--}}
                {{--<a href="#" class="tw"><img src="{{asset('images/svg/Twitter_Color.svg')}}" alt="twitter"/></a>--}}
            {{--</div>--}}
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newsFormModal">Get Newsletter</button>
        </div>
    </div>
</div>