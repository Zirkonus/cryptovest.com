@extends('layouts.main')
@push('head_links')
<meta name="robots" content="noindex">
@endpush
@section('title', "Cryptocurrency News, Reviews & Education - Cryptovest")
@section('meta-tags')
    <meta name="description" content="Cryptovest - World's largest cryptocurrency and ICO media publisher offers the latest news, reviews and knowledge centre.">
@endsection
@section('body-class', 'newsPage')

@section('content')

    <div class="container infiniteNewsBlock">
        <div class="row search-blade-block" >
            <div class="col-lg-8 col-md-8 col-sm-12 search-input-block">
                <form action="{{asset('/')}}" style="margin-bottom:0" method="get">
                    <span class="fa fa-icon fa-search"></span>
                    <input type="text" name="s" class = 'search-input' placeholder="New search" id="topMenuSearch">
                    <button type='submit' class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 search-result-block">
                <div class="search-title">Search Results for : <span class="search-word">{{$search}}</span></div>
            </div>
        </div>        
        <div class="row m--8" id="container">
            @foreach($pagination as $pag)
                <div class="col-12 col-md-6 col-lg-4 p--8 post">
                    <div class="bigBlock br-4 maskShadow">
                        {{--@if($post->getCategory->friendly_url != $categ->friendly_url)--}}
                        {{--<div class="topSticker">{{$post->getCategory->friendly_url}} </div>--}}
                        {{--@endif--}}
                        @php
                        // Temporary solutions
                        $path = "";
                        if ($pag->getCategory->full_url) {
                            $path .= "/{$pag->getCategory->full_url}";
                        }
                        $path .= "/{$pag->getCategory->friendly_url}/{$pag->friendly_url}/";
                        $path = preg_replace('|([/]+)|s', '/', $path);
                        @endphp
                        <a href="{{$path}}" class="noMaskImg"><img src="{{asset($pag->category_image)}}" alt="news6"/></a>
                        <div class="titleBlock" style="height: 80px; overflow: hidden">
                            <a href="{{$path}}">{!! str_ireplace($search, "<span class='light-search-word'>{$search}</span>", Translate::getValue($pag->title_lang_key))!!}</a></div>
                            <div class="descriptionBlock" style="height: 66px; overflow: hidden;">
                                <p>{!! str_ireplace($search, "<span class='light-search-word'>{$search}</span>", Translate::getValue($pag->description_lang_key))!!}</p>
                            </div>
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
            <ul class="pagination">
                @if($page == 1)
                <li class="disabled"><span>«</span></li>
                @else
                <li><a href="{{url('/')}}/?s={{$search}}&page={{$page - 1}}" rel="prev">«</a></li>
                @endif
                <li class="active"><span>{{$page}}</span></li>
                @if($is_end)
                    <li class="disabled"><span>»</span></li>
                @else
                <li><a href="{{url('/')}}/?s={{$search}}&page={{$page + 1}}" rel="next">»</a></li>
                @endif
            </ul>
        </div>
    </div>
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
                    $('#FormModalSubscribeThanks').modal();
                    $(this)[0].reset();
//                   return true;
                }
                return false;
            })
        });
    </script>
@endsection
