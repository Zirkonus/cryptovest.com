@extends('layouts.main')
@push('head_links')
<link rel="canonical" href="{{asset($categ->friendly_url)}}/"/>
@endpush
@section('title', Translate::getValue($categ->name_lang_key) . " - Cryptovest")
@section('meta-tags')
    <meta name="description" content="{{Translate::getValue($categ->description_lang_key)}}">
@endsection
@section('body-class', 'newsPage')

@section('content')
    <div class="container topNewsBlock">
        <div class="row m--8">
            @if($topPost)
                @foreach($topPost as $post)
                    @if($post)
                        <div class="col-12 col-md-6 col-lg-4 p--8 featuredNews">
                            <div class="bigBlock br-4 {{ $post->selectedCategoryForLabel }} maskShadow">
                                <?php
                                // Temporary solutions
                                $path = "";
                                if($post->getCategory->full_url) {
                                    $path .= "/{$post->getCategory->full_url}";
                                }
                                $path .= "/{$post->getCategory->friendly_url}/{$post->friendly_url}/";
                                $path = preg_replace('|([/]+)|s', '/', $path);
                                ?>
                                <a href="{{$path}}" class="noMaskImg"><img style="width: 368px; height: 240px" src="{{asset($post->category_image)}}" alt="newsList1"/></a>
                                {{--@if($categ->friendly_url != $post->getCategory->friendly_url)--}}
                                    {{--<div class="topSticker">{{$categ->friendly_url}}--}}
                                        {{--@if($post->getCategory->friendly_url != $categ->friendly_url)--}}
                                            {{--<span>{{$post->getCategory->friendly_url}}</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--@endif--}}
                                <div class="topSticker">
                                    @if(isset($post->getCategory->getParentCateg))
                                        {{ $post->getCategory->getParentCateg->friendly_url}}
                                        <span>{{$post->getCategory->friendly_url}}</span>
                                    @else
                                        {{ $post->getCategory->friendly_url}}
                                    @endif
                                </div>
                                    <div class="topStickerBig">
                                        @if(isset($post->getCategory->getParentCateg))
                                            <a href="/{{$post->getCategory->getParentCateg->friendly_url}}/" class="showAllLink">{{$post->getCategory->getParentCateg->friendly_url}}</a>
                                            @if($post->getCategory->friendly_url != $post->getCategory->getParentCateg->friendly_url)
                                                <a href="/{{$post->getCategory->getParentCateg->friendly_url}}/{{$post->getCategory->friendly_url}}" class="showAllLink">{{$post->getCategory->friendly_url}}</a>
                                            @endif
                                        @else
                                            <a href="/{{$post->getCategory->friendly_url}}/" class="showAllLink">{{$post->getCategory->friendly_url}}</a>
                                        @endif
                                    </div>
                                <div class="titleBlock" style="min-height: 80px"><a href="{{$path}}">{{Translate::getValue($post->title_lang_key)}}</a></div>
                                <div class="descriptionBlock">
                                    <p style="margin-bottom: 0">
                                        @if(strlen(Translate::getValue($post->description_lang_key)) > 110)
                                            <?php
                                                $text = substr(Translate::getValue($post->description_lang_key), 0 , 110);
                                                $text .='...';
                                            ?>
                                            {{$text}}
                                        @else
                                            {{Translate::getValue($post->description_lang_key)}}
                                        @endif
                                    </p>
                                </div>
                                <div class="bottomInform">
                                    <div class="pull-left">
                                        <span class="dateBlock">{{date('d F',strtotime($post->created_at))}}</span>
                                        <span class="separator"> / by </span>
                                        <span class="authorName"><a href="/author/{{$post->getAuthor->url}}/">{{Translate::getValue($post->getAuthor->first_name_lang_key)}} {{Translate::getValue($post->getAuthor->last_name_lang_key)}}</a></span>
                                    </div>
                                    {{--<div class="pull-right">--}}
                                        {{--<span class="shareTotal"><img src="images/svg/shareNw.svg" class="shareImg"/>12</span>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
            <div class="col-12 col-lg-4 p--8 sideFormBannerBlock">
                <div class="sideForm">
                    <h2 class="formTitle col-12">
                        Stay up to date with market trends and exclusive news!
                        <img src="{{asset('images/svg/metaball-subscriptions.svg')}}" alt="metaball"/>
                    </h2>
                    <form data-toggle="validator" method="POST" action="//cryptovest.us16.list-manage.com/subscribe/post?u=d409eae0500b9a0f7813335a2&id=734bab7ff4" role="form" class="form-inline" id="sideFormBannerBlock" name="mc-embedded-subscribe-form" target="_blank">
                        <input type="hidden" id="categoryName" name="categoryName" value="{{$categ->friendly_url}}">
                        <div class="form-group has-feedback col-12">
                            <div class="input-group">
                                <span class="input-group-addon"><img src="/images/svg/person.svg" /></span>
                                <input type="text" class="form-control" id="inputNameUp"  name="FNAME" placeholder="Name" data-minlength="3" required>
                            </div>
                        </div>
                        <div class="form-group has-feedback col-12">
                            <div class="input-group">
                                <span class="input-group-addon"><img src="/images/svg/mail.svg" /></span>
                                <input type="email" class="form-control" name="EMAIL" id="inputEmailUp" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <input type="hidden" name="b_d409eae0500b9a0f7813335a2_734bab7ff4" tabindex="-1" value="">
                            <button type="submit" class="btn btn-primary {{($categ->friendly_url == 'news' or $categ->parent_id == 2) ? "btn-news-sub": 'btn-reviews-sub'}}" value="Subscribe" name="subscribe">Subscribe</button>
                        </div>
                    </form>
                </div>
                <div class="sideBanner hidden-sm-down">
                    <a href="/_click-banner" target="_blank"><img  style="width: 368px; height: 206px" src="/_show-banner" /></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container topSmallNews">
        <div class="row m--8">
            <div class="col-12 smallBlocks p--8">
                <div class="row m--8">
                    @foreach($posts as $post)
                        <div class="col-12 p--8 col-md-12 col-lg-4">
                            <div class="smallBlock br-4 maskShadow">
                                <?php
                                // Temporary solutions
                                $path = "";
                                if($post->getCategory->full_url) {
                                    $path .= "/{$post->getCategory->full_url}";
                                }
                                $path .= "/{$post->getCategory->friendly_url}/{$post->friendly_url}/";
                                $path = preg_replace('|([/]+)|s', '/', $path);
                                ?>
                                <a href="{{$path}}" class="noMaskImg"><img src="{{asset($post->category_image)}}" alt="news3-q" class="pull-left"/></a>
                                {{--@if($categ->friendly_url != $post->getCategory->friendly_url)--}}
                                    {{--<div class="topSticker">{{$categ->friendly_url}}--}}
                                        {{--@if($post->getCategory->friendly_url != $categ->friendly_url)--}}
                                            {{--<span>{{$post->getCategory->friendly_url}}</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--@endif--}}
                                <div class="titleLinkBlock">
                                    <div class="titleBlock">
                                        <a href="{{$path}}">{{Translate::getValue($post->title_lang_key)}}</a>
                                    </div>
                                    <div class="bottomInform">
                                        <div class="pull-left">
                                            <span class="dateBlock">{{date('d F',strtotime($post->created_at))}}</span>
                                            <span class="separator"> / by </span>
                                            <span class="authorName"><a href="/author/{{$post->getAuthor->url}}/">{{Translate::getValue($post->getAuthor->first_name_lang_key)}} {{Translate::getValue($post->getAuthor->last_name_lang_key)}}</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12 p--8 hidden-md-up">
                        <div class="sideBanner">
                            <a href="/_click-banner" target="_blank"><img style="width: 100%" src="/_show-banner"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container infiniteNewsBlock">
                <div class="row m--8" id="container">
                    @foreach($pagination as $pag)
                        <div class="col-12 col-md-6 col-lg-4 p--8 post">
                            <div class="bigBlock br-4 {{ $pag->selectedCategoryForLabel }} maskShadow">
                                @if($post->getCategory->friendly_url != $categ->friendly_url)
                                    <div class="topSticker">{{$post->getCategory->friendly_url}} </div>
                                @endif
                                @if(empty(Request::segment(2)) || is_numeric(Request::segment(2)))
                                    <div class="topSticker">
                                        @if(isset($pag->getCategory->getParentCateg))
                                            {{ $pag->getCategory->getParentCateg->friendly_url}}
                                            <span>{{$pag->getCategory->friendly_url}}</span>
                                        @else
                                            {{ $pag->getCategory->friendly_url}}
                                        @endif
                                    </div>
                                    <div class="topStickerBig">
                                        @if(isset($pag->getCategory->getParentCateg))
                                            <a href="/{{$pag->getCategory->getParentCateg->friendly_url}}/" class="showAllLink">{{$pag->getCategory->getParentCateg->friendly_url}}</a>
                                            @if($pag->getCategory->friendly_url != $pag->getCategory->getParentCateg->friendly_url)
                                                <a href="/{{$pag->getCategory->getParentCateg->friendly_url}}/{{$pag->getCategory->friendly_url}}" class="showAllLink">{{$pag->getCategory->friendly_url}}</a>
                                            @endif
                                        @else
                                            <a href="/{{$pag->getCategory->friendly_url}}/" class="showAllLink">{{$pag->getCategory->friendly_url}}</a>
                                        @endif
                                    </div>
                                @endif
                                <?php
                                // Temporary solutions
                                $path = "";
                                if($pag->getCategory->full_url) {
                                    $path .= "/{$pag->getCategory->full_url}";
                                }
                                $path .= "/{$pag->getCategory->friendly_url}/{$pag->friendly_url}/";
                                $path = preg_replace('|([/]+)|s', '/', $path);
                                ?>
                                <a href="{{$path}}" class="noMaskImg"><img src="{{asset($pag->category_image)}}" alt="news6"/></a>
                                <div class="titleBlock" style="min-height: 80px">
                                    <a href="{{$path}}">{{Translate::getValue($pag->title_lang_key)}}</a></div>
                                <div class="bottomInform">
                                    <div class="pull-left">
                                        <span class="dateBlock">{{date('d F', strtotime($pag->created_at))}}</span>
                                        <span class="separator"> / by </span>
                                        <span class="authorName"><a href="/author/{{$pag->getAuthor->url}}/">{{Translate::getValue($pag->getAuthor->first_name_lang_key)}} {{Translate::getValue($pag->getAuthor->last_name_lang_key)}}</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="pagination">
                    {!! @$new_pagination ? preg_replace('/(\d?\d\?=)/', '' ,$pagination->links()) : preg_replace('/(\?page=)/', '/' ,$pagination->links()) !!}
                </div>
            </div>
@endsection

@section('newsFormModal')
    @include('front-end.layouts.newsformmodal')
@endsection

@section('joinFormModalButton')
    @include('front-end.layouts.joinformbutton')
@endsection
@section('jsscripts')
    <script>
        $(document).ready(function () {
            $('form[name="mc-embedded-subscribe-form"]').submit(function () {
                var u_name = $(this).find('input[name="FNAME"]').val();
                var u_email = $(this).find('input[name="EMAIL"]').val();
                var categoryName = $(this).find('input[name="categoryName"]').val();
                var response = false;
                $.ajax({
                    type: "POST",
                    async: false,
                    url: '/_categorySubscribe',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "inputEmail": u_email,
                        'inputName': u_name,
                        'categoryName': categoryName
                    },
                    success: function (e) {
                        response = e;
                    }
                });
                if (response == 'success') {
                    //send ajax and not return true(not open additional tabs)
                    var dd = $(this).serialize();
                    var url = $(this).attr('action');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: dd
                    });
                    //google analitic send
                    categoryName == 'news' ? categoryName = 'News': categoryName = 'Reviews & Education';
                    ga('send', {
                        hitType: 'event',
                        eventCategory: 'Subscription',
                        eventAction: categoryName,
                        eventLabel: '{{Request::url() . '/'}}'
                    });
                    $('#secondStepModal').modal();
                    $(this)[0].reset();
//                   return true;
                }
                return false;
            })
        });
    </script>
@endsection
@section('secondstep')
@include('front-end.layouts.subscrsecondstep')
@endsection
