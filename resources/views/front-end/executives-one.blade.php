@extends('layouts.main')

@section('title', Translate::getValue($executive->first_name_lang_key) . " " . Translate::getValue($executive->last_name_lang_key) . ' - Cryptovest')
@section('body-class', 'mainPage')
@section('meta-tags')
    <meta name="description" content="Executive Profile - Cryptovest">
@endsection

@section('styles-css')
    <link rel="stylesheet" href="{{asset('css/executives.css')}}">
@endsection
@section('content')
    <div class="main profile-page one-ico">
        <section class="page-navigation">
            <div class="container">
                <div class="row m--8">
                    <div class="col-lg-12">
                        <nav class="breadcrumb hidden-sm-down">
                            <a class="breadcrumb-item" href="/">home</a>
                            <a class="breadcrumb-item" href="/executives/">executives</a>
                            <span class="breadcrumb-item active"><a href="" rel="canonical">
                                    {{ $executive->first_name_lang_key  ? Translate::getValue($executive->first_name_lang_key) . " " : "" }}
                                    {{ $executive->last_name_lang_key  ? Translate::getValue($executive->last_name_lang_key) : "" }}
                                </a>
                            </span>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- PROFILE CONTENT -->

        <section class="profile-content executive-profile">
            <div class="container">
                <div class="row m--8">
                    <div class="col-lg-12 fixed-title right-sidebar">
                        <div class="ico-name">
                            <div class="smartre-text">
                                <span class="token-sale">
                                    <img src="{{asset($executive->profile_image)}}">
                                </span>
                            </div>
                            <div class="executive-info">
                                <div class="executive-name">
                                    {{ $executive->first_name_lang_key  ? Translate::getValue($executive->first_name_lang_key) . " " : "" }}
                                    {{ $executive->last_name_lang_key  ? Translate::getValue($executive->last_name_lang_key) : "" }}
                                </div>
                                <div class="executive-role">
                                    @if(count($executive->roles) > 0)
                                        @foreach($executive->roles as $key => $role)
                                            @if(++$key != $executive->roles->count())
                                                <span>{{ $role->name }}, </span>
                                            @else
                                                <span>{{ $role->name }}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if($executive->twitter_link)
                                        <a id="twitter" href="{{ $executive->twitter_link }}" class="executive-link"
                                           target="_blank"><img
                                                    src="{{asset('images/Twitter_Color.png')}}"></a>
                                    @endif
                                    @if($executive->linkedin_link)
                                        <a href="{{ $executive->linkedin_link }}"
                                           class="executive-link" target="_blank"><img
                                                    src="{{asset('images/LinkedIN_Color.png')}}"></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 fixed-sidebar right-sidebar">
                        @if(count($companies) > 0)
                            <div class="sidebar-content">
                                <h3 class="involved-title">INVOLVED</h3>
                                <div class="involved-links-wrapper">
                                    @foreach($companies as $ico)
                                        @if($loop->iteration < 6)
                                            <a href="/ico/{{$ico->friendly_url }}/" class="involved-link">
                                                @if(isset($ico->image))
                                                    @if(Storage::exists($ico->image))
                                                        <img src="{{ Storage::get($ico->image)}}" alt="icon">
                                                    @elseif(File::exists($ico->image))
                                                        <img src="{{asset($ico->image)}}" alt="icon">
                                                    @else
                                                        <img src="{{$ico->image}}" alt="icon">
                                                    @endif
                                                @endif
                                                {{ $ico->title }}
                                            </a>
                                        @endif
                                        @if($loop->count > 6)
                                            @if($loop->iteration === 6)
                                                <span class="more-links">
                                            +{{ $loop->remaining }}
                                                    <div class="hover-involved">
                                            @endif
                                                        @if($loop->iteration > 6)
                                                            <a href="/ico/{{$ico->friendly_url }}/">{{ $ico->title }}</a>
                                                        @endif
                                                        @if($loop->last)
                                                </div>
                                                </span>
                                            @endif
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                        @endif
                        @if(count($executive->supports) > 0)
                            <div class="executive-supports">
                                <span class="support-title">
                                    Supports:
                                </span>
                                @foreach($executive->supports as $key => $support)
                                    @if(++$key != $executive->supports->count())
                                        <span>{{ $support->name }}, </span>
                                    @else
                                        <span>{{ $support->name }}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        @if(isset($location))
                            <div class="executive-country">
                                <span class="country-title">
                                    COUNTRY:
                                </span>
                                <span>{{ $location }}</span>
                            </div>
                        @endif
                        <div class="latest-tweets">
                            @if(isset($executive->twitter_link))
                                <h2 class="latest-tweets-title">Latest Tweets
                                </h2>
                                <a class="twitter-timeline"
                                   href="{{ $executive->twitter_link }}"
                                   data-chrome="nofooter noheader"
                                   data-link-color="#820bbb"
                                   data-border-color="#e1e8ee"
                                   data-tweet-limit="2">
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-8 main-content">
                        <div class="description">
                            <h1 class="titleBlock one-ico-title">Information</h1>
                            <p>{!! $executive->biography_lang_key ? Translate::getValue($executive->biography_lang_key) : "" !!}</p>
                        </div>
                        <div class="executive-profile-news smallBlocks">
                            @if(isset($posts) && count($posts) > 0)
                                <h1 class="titleBlock one-ico-title">Latest
                                    on {{ $executive->first_name_lang_key  ? Translate::getValue($executive->first_name_lang_key) . " " : "" }}
                                    {{ $executive->last_name_lang_key  ? Translate::getValue($executive->last_name_lang_key) : "" }} </h1>
                            @endif
                            <div class="row m--8">
                                @if(isset($posts) && count($posts) > 0)
                                    @foreach($posts as $post)
                                        <div class="col-12 p--8 col-md-6 col-lg-6">
                                            <div class="smallBlock br-4 maskShadow">
                                                @php
                                                    $path = "";
                                                    if ($post->getCategory->full_url) {
                                                        $path .= "/{$post->getCategory->full_url}";
                                                    }
                                                    $path .= "/{$post->getCategory->friendly_url}/{$post->friendly_url}/";
                                                    $path = preg_replace('|([/]+)|s', '/', $path);
                                                @endphp
                                                <a href="{{ $path }}" class="noMaskImg">
                                                    <img src="{{asset($post->title_image)}}" alt="news{{ $post->id }}-q"
                                                         class="pull-left"/></a>
                                                <div class="titleLinkBlock">
                                                    <div class="titleBlock">

                                                        <a href="{{ $path }}">{{ $post->title_lang_key ? Translate::getValue($post->title_lang_key) : "" }}</a>
                                                    </div>
                                                    <div class="bottomInform">
                                                        <div class="pull-left">
                                                            <span class="dateBlock">{{ date('d F', strtotime($post->created_at)) }}</span>
                                                            <span class="separator"> / by </span>
                                                            <span class="authorName"><a
                                                                        href="{{ $path }}">{{ $post->getUser ? Translate::getValue($post->getUser->first_name_lang_key) . " " . Translate::getValue($post->getUser->last_name_lang_key) : "" }}</a></span>
                                                        </div>
                                                        <div class="pull-right">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="latest-tweets mobile">
                                    @if(isset($executive->twitter_link))
                                        <h2 class="latest-tweets-title">Latest Tweets
                                        </h2>
                                        <a class="twitter-timeline"
                                           href="{{ $executive->twitter_link }}"
                                           data-height="300px"
                                           data-chrome="nofooter noheader"
                                           data-link-color="#820bbb"
                                           data-border-color="#e1e8ee"
                                           data-tweet-limit="2">
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
@section('newsFormModal')
    @include('front-end.layouts.newsformmodal')
@endsection

@section('joinFormModalButton')
    @include('front-end.layouts.joinformbutton')
@endsection
@section('jsscripts')
    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    <script src="{{asset('js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('js/executives-list.js')}}"></script>
    <script src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    <script>
        twttr.events.bind(
            'loaded',
            function (event) {
                if (!event.widgets[0].id) {
                    $('.latest-tweets').hide();
                }
            }
        );
    </script>
    <!-- <script type=”text/javascript” src=”http://twitter.com/javascripts/blogger.js”> -->
@endsection
