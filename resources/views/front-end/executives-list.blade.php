@extends('layouts.main')

@section('title', 'Executives - Cryptovest')
@section('body-class', 'mainPage')
@section('meta-tags')
    <meta name="description" content="Cryptovest - Executives.">
@endsection
@section('styles-css')
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/executives.css')}}">
    <input type="hidden" id="token" data="{{csrf_token()}}">
@endsection
@section('content')
    <div class="container topBlock events-header executives-header">
        <div class="row m--8">
            <div class="col-12 p--8 col-lg-12 col-md-12 col-sm-12 description-block">
                <h2 class="titleBlock">Executives</h2>
                <p class="description-text">Use this exchange list to find a cryptocurrency exchange for you. Each user
                    has unique needs, so there is no one size fits all for exchanges.</p>
            </div>
        </div>
    </div>
    <div class="container newsParentBlock middleInfoBlock listing events executives">
        <div class="row m--8">
            <div class="col-12 headerBlock p--8 executives-filters">
                <div class="row m--8 tabs-line">
                    <div class="tabs col-lg-6 col-md-12 col-sm-12">
                    </div>
                    <div class="search-block col-lg-12 col-md-12 col-sm-12">
                        <div class="search">
                            @if(isset($roles))
                            <div class="btn-group role">
                                <div data-toggle="dropdown" class="btn btn-default dropdown-toggle role-dropdown">
                                    Role<span class="caret"></span></div>
                                <ul class="dropdown-menu">
                                    <li data-value=''><a>All</a></li>
                                    @foreach($roles as $roleKey => $role)
                                        <li data-value='{{ $roleKey }}'><a>{{ $role }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
<!-- {{--                            @if(isset($companies))--}}
                                {{--<div class="btn-group company">--}}
                                    {{--<div data-toggle="dropdown"--}}
                                         {{--class="btn btn-default dropdown-toggle company-dropdown">--}}
                                        {{--Company<span class="caret"></span></div>--}}
                                    {{--<ul class="dropdown-menu">--}}
                                        {{--<li data-value=''><a>All</a></li>--}}
{{--                                        @foreach($companies as $companyKey => $company)--}}
{{--                                            <li data-value="{{ $companyKey }}">{{ $company }}</li>--}}
                                        {{--@endforeach--}}
                                    {{--</ul>--}}
                                {{--</div>--}}
                            {{--@endif--}}
{{--                            @if(isset($locations))--}}
                            {{--<div class="btn-group location">--}}
                                {{--<div data-toggle="dropdown" class="btn btn-default dropdown-toggle location-dropdown">--}}
                                    {{--Location<span class="caret"></span></div>--}}
                                {{--<ul class="dropdown-menu">--}}
                                    {{--<li data-value=''><a>All</a></li>--}}
{{--                                    @foreach($locations as $locationKey => $location)--}}
{{--                                        <li data-value='{{ $locationKey }}'><a>{{ $location }}</a></li>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                            {{--@endif--}} -->
                            <input id="search" type="text" class="searching-inputs" style="display: none;">
                            <label for="search" id='show-search' style="cursor: pointer;">
                                <span><img src="/images/search.png"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 bigBlocks p--8">
                <div class="row m--8">
                    <div class="p--8 col-md-12 col-sm-12 col-lg-12">
                        <div class="upcomming-list">
                            <!-- first table -->
                            <table class="executives-list">
                                <thead>
                                    <tr>
                                       <!--  {{--<th><span class="rank-mob-hide">RANK</span>#</th>--}} -->
                                        <th>NAME</th>
                                        <th>ROLE</th>
                                        <th>LOCATION</th>
                                        <!-- {{--<th>INVOLVED<span class="inv-companies">(COMPANIES)</span></th>--}} -->
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id = 'executivesTable'>
                                @foreach($executivesResult as $val => $executive)
                                    <tr class="main-row">
                                        <!-- {{--<td>{{ $loop->iteration }}</td>--}} -->
                                        <td>
                                            <img class="list-avatar" src="{{asset($executive->profile_image)}}">
                                            <a href="{!! route("executive-one", ['url' => $executive->url]) . "/" !!}">{{ Translate::getValue($executive->first_name_lang_key) . " " . Translate::getValue($executive->last_name_lang_key) }}</a>
                                        </td>
                                        <td>
                                            @if(isset($executive->roles))
                                                @foreach($executive->roles as $key => $role)
                                                    @if(++$key != $executive->roles->count())
                                                        <span>{{ $role->name }}, </span>
                                                    @else
                                                        <span>{{ $role->name }}</span>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $executive->country ? $executive->country->name : "" }}</td>
                                        <!-- <td>
                                            {{--<span class="inv-count">{{ $executive->ICOProjects()->where('is_active', 1)->get()->count() }}</span>--}}
                                        </td> -->
                                        <td>
                                            <a href="{{ $executive->twitter_link or '#'}}" target="_blank">
                                                <img class="inv-links" src="{{asset('images/Twitter_Color.png')}}">
                                            </a>
                                            <a href="{{ $executive->linkedin_link or '#' }}" target="_blank">
                                                <img class="inv-links" src="{{asset('images/LinkedIN_Color.png')}}">
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="mobile-role">
                                        <td colspan="4">
                                            @if(isset($executive->roles))
                                                @foreach($executive->roles as $key => $role)
                                                    @if(++$key != $executive->roles->count())
                                                        {{ $role->name }}, 
                                                    @else
                                                        {{ $role->name }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div id = 'executivePre'>
                                <img class="preloader" src="{{asset('/images/svg/metaball-subscriptions.svg')}}" alt="">
                            </div>
                            <!-- pagination -->
                            <div class="pagination-wrapper">
                                <div class="pagination-arrow" id = 'expagination'>
                                    <span class="orange-circle">
                                        <span class="fa fa-arrow-down"></span>
                                    </span>
                                </div>
                                <div class="pagination-line"></div>
                            </div>
                        </div>
                        <!--</div> -->

                    </div>
                </div>
                <!--  Only for Desctop (up) -->
            </div>
        </div>
    </div>

    @if(count($posts) > 0)
        <!-- news blocks -->
        <div class="container infiniteNewsBlock executives-news">
            <h2 class="news-title-block">news</h2>
            <div class="row m--8">
                @foreach($posts as $post)
                    @php
                        $path = "";
                        if ($post->getCategory->full_url) {
                            $path .= "/{$post->getCategory->full_url}";
                        }
                        $path .= "/{$post->getCategory->friendly_url}/{$post->friendly_url}/";
                        $path = preg_replace('|([/]+)|s', '/', $path);
                    @endphp
                    <div class="col-12 col-md-6 col-lg-4 p--8">
                        <div class="bigBlock br-4 maskShadow">
                            <div class="topSticker">{{ $post->getCategory ? strtolower(Translate::getValue($post->getCategory->name_lang_key)) : "" }}</div>
                            <a href="{{ $path }}" class="noMaskImg"><img src="{{asset($post->title_image)}}"
                                                                         alt="news{{ $post->id }}"/></a>
                            <div class="titleBlock" style="height: 80px; overflow: hidden">
                                <a href="{{ $path }}">{{ $post->title_lang_key ? Translate::getValue($post->title_lang_key) : "no title" }}</a>
                            </div>
                            <div class="bottomInform">
                                <div class="pull-left">
                                    <span class="dateBlock">{{ date('d F', strtotime($post->created_at)) }}</span>
                                    <span class="separator"> / by </span>
                                    <span class="authorName"><a
                                                href="{{ $path }}">{{ $post->getUser ? Translate::getValue($post->getUser->first_name_lang_key) . " " . Translate::getValue($post->getUser->last_name_lang_key) : "" }}</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection

@section('jsscripts')
    <script src="/js/jquery.dataTables.js"></script>
    <script src="/js/dataTables.bootstrap.js"></script>
    <script src="/js/executives-list.js"></script>
    <!-- <script src="/js/events-page.js"></script> -->
@endsection