@extends('layouts.main')

@section('title', 'Cryptovest - Tag')
@section('meta-tags')
    <meta name="description" content="Cryptovest - World's largest cryptocurrency and ICO media publisher offers the latest news, reviews and knowledge centre.">
@endsection
@section('body-class', 'tagPage')
@section('content')

<div class="container authorNewsBlock">
    <div class="row">
        {{--<div class="col-12 col-md-4 col-lg-4">--}}
            {{--<div class="authorBlock">--}}
                {{--<img src="{{asset($user->profile_image)}}" class="face"/>--}}
                {{--<h2>{{Translate::getValue($user->first_name_lang_key)}} {{Translate::getValue($user->last_name_lang_key)}}</h2>--}}
                {{--<p>{{Translate::getValue($user->biography_lang_key)}}</p>--}}
                {{--<div class="socialBlockAuthor">--}}
                    {{--@if($user->facebook_link)--}}
                        {{--<a href="{{$user->facebook_link}}" target="_blank"><img src="{{asset('images/svg/LinkedIN_Color.svg')}}" alt="linkedin" /></a>--}}
                    {{--@endif--}}
                    {{--@if($user->twitter_link)--}}
                        {{--<a href="{{$user->twitter_link}}" target="_blank"><img src="{{asset('images/svg/Twitter_Color.svg')}}" alt="twitter" /></a>--}}
                    {{--@endif--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="col-12 col-md-12 col-lg-12">
            <div class="infiniteNewsBlock">
                <div class="tag-result">Articles with tag : <span class="selected-tag">{{$tag->name}}</span></div>
                <br>
                <div class="row m--8" id="container">
                    @foreach($posts as $post)
                        <div class="col-12 col-md-4 col-lg-4 p--8 post">
                            <div class="bigBlock br-4 maskShadow">
                                <a href="@if($post->getCategory->full_url)/{{$post->getCategory->full_url}}@endif/{{$post->getCategory->friendly_url}}/{{$post->friendly_url}}/" class="noMaskImg"><img src="{{asset($post->category_image)}}"/></a>
                                <div class="titleBlock" style="min-height: 80px"><a href="@if($post->getCategory->full_url)/{{$post->getCategory->full_url}}@endif/{{$post->getCategory->friendly_url}}/{{$post->friendly_url}}/">{{Translate::getValue($post->title_lang_key)}}</a></div>
                                <div class="bottomInform">
                                    <div class="pull-left">
                                        <span class="dateBlock">{{date('d, F', strtotime($post->created_at))}}</span>
                                        <span class="separator"> / by </span>
                                        <span class="authorName"><a href="/author/{{$post->getAuthor->url}}/">{{Translate::getValue($post->getAuthor->first_name_lang_key)}} {{Translate::getValue($post->getAuthor->last_name_lang_key)}}</a></span>
                                    </div>
                                    {{--<div class="pull-right">--}}
                                        {{--<span class="shareTotal"><img src="{{asset('images/svg/shareNw.svg')}}" class="shareImg"/>12</span>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            <div id="pagination">
                {{$posts->links()}}
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('newsFormModal')
    @include('front-end.layouts.newsformmodal')
@endsection

@section('jsscripts')
    <script>
        $(window).resize(function(){
            if(($(window).width()<'1300')&&($(window).width()>='1150')){
                window.setTimeout('location.reload()', 0);
            }
        });
    </script>
@endsection
