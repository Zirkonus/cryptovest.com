@extends('layouts.main')

@section('title', 'Cryptocurrency News, Reviews & Education - Cryptovest')
@section('body-class', 'mainPage')
@section('meta-tags')
    <meta name="description" content="Cryptovest - World's largest cryptocurrency and ICO media publisher offers the latest news, reviews and knowledge centre.">
@endsection
@section('styles-css')
    <style>
        #icoTopAct {
            width: 23px;
            height: 23px;
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/main-page.css')}}">
@show
@section('content')

<div class="container topBlock">
    <div class="row m--8">
        <div class="col-12 p--8 col-md-12 col-lg-8">
            <div class="newsBlock br-4 mask">
                @if (!is_null($mainNews))
                    <?php
                    // Temporary solutions
                    $path = "";
                    if ($mainNews->getCategory->full_url) {
                        $path .= "/{$mainNews->getCategory->full_url}";
                    }
                    $path .= "/{$mainNews->getCategory->friendly_url}/{$mainNews->friendly_url}/";
                    $path = preg_replace('|([/]+)|s', '/', $path);
                    ?>
                        <a href="{{$path}}" class="maskImg"><img style="width: 752px;" src="{{asset($mainNews->title_image)}}" alt="news"/></a>
                        <div class="topSticker">
                            @if (isset($mainNews->getCategory->getParentCateg))
                                {{ $mainNews->getCategory->getParentCateg->friendly_url}}
                                @if ($mainNews->getCategory->friendly_url != $mainNews->getCategory->getParentCateg->friendly_url)
                                <span>{{$mainNews->getCategory->friendly_url}}</span>
                                @endif
                            @else
                                {{ $mainNews->getCategory->friendly_url}}
                            @endif
                        </div>
                        <div class="topStickerBig">
                            <a href="/news/" class="showAllLink">news</a>
                            @if (isset($mainNews->getCategory->getParentCateg))
                                @if ($mainNews->getCategory->friendly_url != $mainNews->getCategory->getParentCateg->friendly_url)
                                    <a href="/news/{{$mainNews->getCategory->friendly_url}}" class="showAllLink">{{$mainNews->getCategory->friendly_url}}</a>
                                @endif
                            @endif
                            <a href="#"><img src="{{asset('images/svg/twitter.svg')}}"/></a>
                            <a href="#"><img src="{{asset('images/svg/facebook.svg')}}"/></a>
                        </div>
                        <div class="titleBlock"><a href="{{$path}}">
                            {{Translate::getValue($mainNews->title_lang_key)}}</a>
                        </div>
                        <div class="bottomInform" style="color: #FFFFFF;">
                            <span class="authorName">by <a href="/author/{{$mainNews->getAuthor->url}}/">{{Translate::getValue($mainNews->getAuthor->first_name_lang_key)}} {{Translate::getValue($mainNews->getAuthor->last_name_lang_key)}}</a></span>
                            {{--<span class="shareTotal"><img src="images/svg/share.svg" class="shareImg"/>123</span>--}}
                        </div>
                @endif
            </div>
            <div class="newsGridBlock">
                <div class="row m--8">
                    @if (count($lastPost) > 0)
                        @foreach ($lastPost as $p)
                            <div class="col-12 col-lg-3 col-md-6 p--8 hidden-sm-down">
                                <div class="newsItem index-grid-news br-4 maskShadow ">
                                    <?php
                                    // Temporary solutions
                                    $path = "";
                                    if($p->getCategory->full_url) {
                                        $path .= "/{$p->getCategory->full_url}";
                                    }
                                    $path .= "/{$p->getCategory->friendly_url}/{$p->friendly_url}/";
                                    $path = preg_replace('|([/]+)|s', '/', $path);
                                    $category = '';
                                    $categoryFullName = '';
                                    if (isset($post->getCategory->getParentCateg)) {
                                        $category = $p->getCategory->getParentCateg->friendly_url;
                                        $categoryFullName = $category . " " . $post->getCategory->friendly_url;
                                    } else {
                                        $category = $p->getCategory->friendly_url;
                                        $categoryFullName = $category;
                                    }
                                    ?>
                                    <!-- <a href="{{$path}}" class="noMaskImg"><img src="{{asset($p->short_image)}}" alt="news1"/></a> -->
                                    <!-- @if ($p->label_id)
                                        <div class="item-label">{{$p->getLabel->name}}</div>
                                    @endif -->


                                    <span class="category-label {{ $category }}">{{ $categoryFullName }}</span>
                                    <div class="titleBlock">
                                        <a href="{{$path}}">
                                            @if (strlen(Translate::getValue($p->title_lang_key)) > 80 )
                                                <?php
                                                $text = Translate::getValue($p->title_lang_key);
                                                $text = substr($text, 0, 60);
                                                $a = preg_replace('/\s(\w)*$/', ' ...', $text);
                                                ?>
                                                {{$a}}
                                            @else
                                                {{ mb_strimwidth(Translate::getValue($p->title_lang_key), 0, 60, '...') }}
                                            @endif
                                        </a>
                                    </div>
                                    <div class="bottomInform">
                                        <span style="font-size: 12px; margin-left:14px" class="authorName">by <a href="/author/{{$p->getAuthor->url}}/">{{Translate::getValue($p->getAuthor->first_name_lang_key)}} {{Translate::getValue($p->getAuthor->last_name_lang_key)}}</a></span>
                                        {{--<span class="shareTotal"><img src="images/svg/shareNw.svg" class="shareImg"/>123</span>--}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <!--  Hidden for mobile <768 (up) -->
                </div>
            </div>
        </div>
        <div class="col-12 p--8 col-md-12 col-lg-4 mobile-wrapper-block">
            <div class="row m--8">
                <!-- <div class="p--8 col-12 col-md-6 col-lg-12">
                    <div class="rightInfoBlock education br-4 mask">
                
                        @if (!is_null($mainEducation))
                            <?php
                            // Temporary solutions
                            $path = "";
                            if ($mainEducation->getCategory->full_url) {
                                $path .= "/{$mainEducation->getCategory->full_url}";
                            }
                            $path .= "/{$mainEducation->getCategory->friendly_url}/{$mainEducation->friendly_url}/";
                            $path = preg_replace('|([/]+)|s', '/', $path);
                            ?>
                            <a href="{{$path}}" class="maskImg"><img  src="{{asset($mainEducation->category_image)}}" alt="education"/></a>
                            <div class="topSticker">
                                @if (isset($mainEducation->getCategory->getParentCateg))
                                    {{ $mainEducation->getCategory->getParentCateg->friendly_url}}
                                    @if ($mainEducation->getCategory->friendly_url != $mainEducation->getCategory->getParentCateg->friendly_url)
                                    <span>{{$mainEducation->getCategory->friendly_url}}</span>
                                    @endif
                                @else
                                    {{ $mainEducation->getCategory->friendly_url}}
                                @endif
                            </div>
                            <div class="topStickerBig">
                                <a href="/education/" class="showAllLink">education</a>
                                @if (isset($mainEducation->getCategory->getParentCateg))
                                    @if ($mainEducation->getCategory->friendly_url != $mainEducation->getCategory->getParentCateg->friendly_url)
                                        <a href="/education/{{$mainEducation->getCategory->friendly_url}}" class="showAllLink">{{$mainEducation->getCategory->friendly_url}}</a>
                                    @endif
                                @endif
                                <a href="#"><img src="{{asset('images/svg/twitter.svg')}}"/></a>
                                <a href="#"><img src="{{asset('images/svg/facebook.svg')}}"/></a>
                            </div>
                            <div class="titleBlock"><a href="{{$path}}">{{Translate::getValue($mainEducation->title_lang_key)}}</a>
                            </div>
                            <div class="bottomInform">
                                <span style="color: #FFF;" class="authorName">by <a href="/author/{{$mainEducation->getAuthor->url}}/">{{Translate::getValue($mainEducation->getAuthor->first_name_lang_key)}} {{Translate::getValue($mainEducation->getAuthor->last_name_lang_key)}}</a></span>
                                {{--<span class="shareTotal"><img src="images/svg/share.svg" class="shareImg"/>89</span>--}}
                            </div>
                        @endif
                    </div>
                </div> -->
            <div class="p--8 col-12 col-md-6 col-lg-12">
                <div class="bitcoinBlock new-main br-4 p--8">
                <div class="bitcoinGrid">
                    <div class="row m-0">
                        @foreach ($moneys as $m)
                            <div class="col-4 p-0">
                                <div class="bitcoinGridItem p--6">
                                    <div class="titleBlock">
                                        @if (strlen($m->getMoney->name) > 8)
                                            <a style="font-size: 16px" href="#">{{$m->getMoney->name}}</a>
                                        @else
                                            <a href="#">{{$m->getMoney->name}}</a>
                                        @endif
                                    </div>
                                    @if ($m->percent_change_24h > 0)
                                        <div class="bitcoinValue bitcoinUp">{{$m->percent_change_24h}}%<img src="{{asset('images/svg/increase-arrow.svg')}}" /></div>
                                    @else
                                        <div class="bitcoinValue bitcoinDown">{{$m->percent_change_24h}}%<img src="{{asset('images/svg/decrease-arrow.svg')}}" /></div>
                                    @endif
                                    <div class="bitcoinCostBlock">
                                        <span class="active">${{number_format($m->price_usd, 2, '.', ',')}}</span>
                                        <!-- <span class="normal">V: ${{number_format($m->market_cap_usd,0,',',',')}}</span> -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="newsGridBlock mobile-news-block">
                <div class="row m--8">                    
                    @if (count($lastPost) > 0)
                        @foreach ($lastPost as $p)
                        <div class="col-lg-12 p--8 right-block grid-news-block">
                            <div class="smallBlock br-4 maskShadow">
                                <?php
                                    // Temporary solutions
                                    $path = "";
                                    if($p->getCategory->full_url) {
                                        $path .= "/{$p->getCategory->full_url}";
                                    }
                                    $path .= "/{$p->getCategory->friendly_url}/{$p->friendly_url}/";
                                    $path = preg_replace('|([/]+)|s', '/', $path);
                                    $category = '';
                                    $categoryFullName = '';
                                    if (isset($post->getCategory->getParentCateg)) {
                                        $category = $p->getCategory->getParentCateg->friendly_url;
                                        $categoryFullName = $category . " " . $post->getCategory->friendly_url;
                                    } else {
                                        $category = $p->getCategory->friendly_url;
                                        $categoryFullName = $category;
                                    }
                                    ?>
                                <a href="{{$path}}" class="noMaskImg"><img src="{{asset($p->short_image)}}" alt="news3-q"  class="pull-left"/></a>
                                <div class="titleLinkBlock">
                                    <div class="titleBlock"><a href="{{$path}}">
                                        @if (strlen(Translate::getValue($p->title_lang_key)) > 80 )
                                                <?php
                                                $text = Translate::getValue($p->title_lang_key);
                                                $text = substr($text, 0, 60);
                                                $a = preg_replace('/\s(\w)*$/', ' ...', $text);
                                                ?>
                                                {{$a}}
                                            @else
                                                {{ mb_strimwidth(Translate::getValue($p->title_lang_key), 0, 60, '...') }}
                                            @endif
                                        </a></div>
                                    <div class="bottomInform">
                                        <div class="pull-left">
                                            <!-- <span class="dateBlock">sdfsdf </span> -->
                                            <span class="separator">by </span>
                                            <span class="authorName">
                                                <a href="/author/{{$p->getAuthor->url}}/">{{Translate::getValue($p->getAuthor->first_name_lang_key)}} {{Translate::getValue($p->getAuthor->last_name_lang_key)}}</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="rightInfoBlock top-active new-top br-4">
                    <div class="title">Featured ICOs</div>
                        @if(count($topICOs) > 0)
                        <table class="top-active-list">
                                @foreach ($topICOs as $ico)
                                    <tr>
                                        <td><a href="/ico/{{ $ico['ico']->friendly_url }}/"><span class="img">
                                                @if(strlen($ico['ico']->image) > 200)
                                                    <img id="icoTopAct" src="{!! $ico['ico']->image !!}">
                                                @else
                                                    <img id="icoTopAct" src="{{asset($ico['ico']->image)}}">
                                                @endif
                                            </span>{{$ico['ico']->title}}</a>
                                        </td>
                                        <td class="time-bar"><span class="time"><span class="startsin">{{ $ico['diff']['tab'] === 'live' ? "ENDS IN" : "STARTS IN" }}: </span></span>
                                            <div class="progress-wrapper">
                                                <div class="progress">
                                                    <div class="bar" data-bar = "{{$ico['diff']['percent']}}"></div>    
                                                </div>
                                                <span class="days-counts">{{$ico['diff']['short_date']}}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                        </table>
                        @endif
                    </div>
                
                   <div class="rightInfoBlock rewiews br-4 mask  hidden-sm-down">
                       @if (!is_null($mainReviews))
                           <?php
                           // Temporary solutions
                           $path = "";
                           if ($mainReviews->getCategory->full_url) {
                               $path .= "/{$mainReviews->getCategory->full_url}";
                           }
                           $path .= "/{$mainReviews->getCategory->friendly_url}/{$mainReviews->friendly_url}/";
                           $path = preg_replace('|([/]+)|s', '/', $path);
                           ?>
                           <a href="{{$path}}" class="maskImg"><img  src="{{asset($mainReviews->category_image)}}" alt="reviews"/></a>
                           <div class="topSticker">
                               @if (isset($mainReviews->getCategory->getParentCateg))
                                   {{ $mainReviews->getCategory->getParentCateg->friendly_url}}
                                   @if ($mainReviews->getCategory->friendly_url != $mainReviews->getCategory->getParentCateg->friendly_url)
                                   <span>{{$mainReviews->getCategory->friendly_url}}</span>
                                   @endif
                               @else
                                   {{ $mainReviews->getCategory->friendly_url}}
                               @endif
                           </div>
                           <div class="topStickerBig">
                               <a href="/reviews/" class="showAllLink">reviews</a>
                               @if (isset($mainReviews->getCategory->getParentCateg))
                                   @if($mainReviews->getCategory->friendly_url != $mainReviews->getCategory->getParentCateg->friendly_url)
                               <a href="/reviews/{{$mainReviews->getCategory->friendly_url}}" class="showAllLink">{{$mainReviews->getCategory->friendly_url}}</a>
                                   @endif
                               @endif
                               <a href="#"><img src="{{asset('images/svg/twitter.svg')}}"/></a>
                               <a href="#"><img src="{{asset('images/svg/facebook.svg')}}"/></a>
                           </div>
                           <div class="titleBlock"><a href="{{$path}}">{{Translate::getValue($mainReviews->title_lang_key)}}</a>
                           </div>
                           <div class="bottomInform">
                               <span style="color: #FFF;" class="authorName">by <a href="/author/{{$mainReviews->getAuthor->url}}/">{{Translate::getValue($mainReviews->getAuthor->first_name_lang_key)}} {{Translate::getValue($mainReviews->getAuthor->last_name_lang_key)}}</a></span>
                           </div>
                       @endif
                   </div>
               </div>
            </div>
        </div>
    </div>
</div>
<!-- upcoming ICOs block-->

<div class="container newsParentBlock middleInfoBlock upcomming-icos new-widget">
    <div class="row m--8">
        <div class="col-12 headerBlock p--8">
            <div class="row m--8">
                <div class="p--8 col-sm-12 col-md-12 col-lg-8 upcomming-title">
                    <h2 class="titleBlock">Discover ICOs & Token Sales</h2>
                    <span class="seeMoreLink pull-right"><a href="/ico/"><span class="hidden-sm-down" >see more</span><img src="{{asset('images/svg/more.svg')}}" /></a></span>
                </div>
                <div class="col-3 p--8 col-md-6 col-lg-4 hidden-md-down">
                    <div class="subSmBlock">
                        <span class="subscribeLink pull-left"><span class="reviews-title" style="font-size: 20px;">Latest ICO reviews</span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 bigBlocks p--8">
            <div class="row m--8">
                <div class="p--8 col-md-12 col-sm-12 col-lg-8 main-new">
                    <div class="upcomming-list">
                        <table class="main-list">
                            <tbody>
                            @if(isset($topSixIcosResult))
                                @foreach ($topSixIcosResult as $topIco)
                                    <tr>
                                        <td class="first-cell">
                                            <span class="img">
                                                    <a href="/ico/{{ $topIco["url"] }}/"><img src="{{ $topIco["icoImage"] }}"></a>
                                            </span><a href="/ico/{{ $topIco["url"] }}/">{{ $topIco["name"] }}</a>
                                            @if($topIco["medalIcon"])
                                                <span class="star">
                                                    <img src="{{ $topIco["medalIcon"] }}">
                                                </span>
                                            @endif
                                            @if($topIco["medalStatus"] === "featured")
                                            <span class="featured">Featured

                                            @endif
                                            </span>
                                        </td>
                                        <td>{{ $topIco["category"] }}</td>
                                        <td class="time-bar">
                                            <span class="time"><span class="startsin">{{ $topIco["tab"] === "upcoming" ? "STARTS IN" : "ENDS IN" }}: </span></span>
                                            <div class="progress-wrapper">
                                                <div class="progress">
                                                    <div class="bar" data-bar = "{{ $topIco["percent"] }}"></div>    
                                                </div>
                                                <span class="days-counts">{{ $topIco["short_date"] }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 p--8 col-lg-4 reviews hidden-md-down">
                    @if(count($mainReviewsSmall) > 0)
                        @foreach($mainReviewsSmall as $post)
                           @php
                           // Temporary solutions
                           $path = "";
                           if ($post->getCategory->full_url) {
                               $path .= "/{$post->getCategory->full_url}";
                           }
                           $path .= "/{$post->getCategory->friendly_url}/{$post->friendly_url}/";
                           $path = preg_replace('|([/]+)|s', '/', $path);
                           @endphp
                            <div class="col-lg-12 p--8 col-md-6 right-block">
                                <div class="smallBlock br-4 maskShadow">
                                    <a href="{{ $path }}" class="noMaskImg"><img src="{{asset($post->short_image)}}" alt="news3-q"  class="pull-left"/></a>
                                    <div class="titleLinkBlock">
                                        <div class="titleBlock"><a href="{{ $path }}">{{Translate::getValue($post->title_lang_key)}}</a></div>
                                        <div class="bottomInform">
                                            <div class="pull-left">
                                                <span class="dateBlock">{{date('d F',strtotime($post->created_at))}}</span>
                                                <span class="separator"> / by </span>
                                                <span class="authorName">
                                                    <a href="/author/{{$post->getAuthor->url}}/">{{Translate::getValue($post->getAuthor->first_name_lang_key)}} {{Translate::getValue($post->getAuthor->last_name_lang_key)}}</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <!--  Only for Desctop (up) -->
            </div>
        </div>
    </div>
</div>

<!-- upcoming ICOs block end-->

<div class="container newsParentBlock middleInfoBlock">
    <div class="row m--8">
        <div class="col-12 headerBlock p--8">
            <div class="row m--8">
                <div class="col-9 p--8 col-md-6 col-lg-8">
                    <h2 class="titleBlock">news</h2>
                </div>
                <div class="col-3 p--8 col-md-6 col-lg-4">
                    <div class="subSmBlock">
                        <span class="subscribeLink pull-left">
                            <button type="button" class="btn btn-primary btn-news-sub" data-toggle="modal" data-target="#newsFormModal">
                                <img src="{{asset('images/svg/mail.svg')}}" />
                                <span class="hidden-sm-down">subscribe to updates</span>
                            </button>
                        </span>
                        <span class="seeMoreLink pull-right"><a href="/news/"><span class="hidden-sm-down">see more</span><img src="{{asset('images/svg/more.svg')}}" /></a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 bigBlocks p--8">
            <div class="row m--8">
                @foreach ($news as $post)
                    @if ($loop->index == 0)
                        <!-- @foreach ($lastPost as $p)
                            @if ($p->label_id) @continue @endif
                            <div class="col-12 p--8 hidden-md-up col-lg-4">
                                <div class="bigBlock br-4 maskShadow">
                                    {{--<div class="topSticker">news--}}
                                    {{--@if($post->getCategory->friendly_url != 'news')--}}
                                    {{--<span>{{$post->getCategory->friendly_url}}</span>--}}
                                    {{--@endif--}}
                                    {{--</div>--}}
                                    <?php
                                    // Temporary solutions
                                    $path = "";
                                    if ($p['getCategory']->full_url) {
                                        $path .= "/{$p['getCategory']->full_url}";
                                    }
                                    $path .= "/{$p['getCategory']->friendly_url}/{$p->friendly_url}/";
                                    $path = preg_replace('|([/]+)|s', '/', $path);
                                    ?>
                                    <a href="{{$path}}" class="noMaskImg">
                                        <img src="{{asset($p->category_image)}}" alt="news5"/>
                                    </a>

                                    <div class="titleBlock" style="min-height: 78px">
                                        <a href="{{$path}}">{{Translate::getValue($p->title_lang_key)}}</a>
                                    </div>
                                </div>
                                <div class="bottomInform">
                                    <div class="pull-left">
                                        <span class="dateBlock">{{date('d F',strtotime($p->created_at))}}</span>
                                        <span class="separator"> / by </span>
                                        <span class="authorName"><a href="/author/{{$p->getAuthor->url}}/">{{Translate::getValue($p->getAuthor->first_name_lang_key)}} {{Translate::getValue($p->getAuthor->last_name_lang_key)}}</a></span>
                                    </div>
                                    {{--<div class="pull-right">--}}
                                    {{--<span class="shareTotal"><img src="images/svg/shareNw.svg" class="shareImg"/>12</span>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        @endforeach -->
                    @endif
                    @if ($loop->index < 3)
                        @if (!is_null($post['getCategory']))
                            <div class="col-12 p--8 col-md-6 col-lg-4">
                                <div class="bigBlock br-4 maskShadow">
                                    <div class="topSticker">
                                        @if (isset($post->getCategory->getParentCateg))
                                            {{ $post->getCategory->getParentCateg->friendly_url}}
                                            @if ($post->getCategory->friendly_url != $post->getCategory->getParentCateg->friendly_url)
                                            <span>{{$post->getCategory->friendly_url}}</span>
                                            @endif
                                        @else
                                            {{ $post->getCategory->friendly_url}}
                                        @endif
                                    </div>
                                    <div class="topStickerBig">
                                        <a href="/news/" class="showAllLink">news</a>
                                        @if (isset($post->getCategory->getParentCateg))
                                            @if ($post->getCategory->friendly_url != $post->getCategory->getParentCateg->friendly_url)
                                                <a href="/news/{{$post->getCategory->friendly_url}}" class="showAllLink">{{$post->getCategory->friendly_url}}</a>
                                            @endif
                                        @endif
                                    </div>
                                    <?php
                                    // Temporary solutions
                                    $path = "";
                                    if ($post['getCategory']->full_url) {
                                        $path .= "/{$post['getCategory']->full_url}";
                                    }
                                    $path .= "/{$post['getCategory']->friendly_url}/{$post->friendly_url}/";
                                    $path = preg_replace('|([/]+)|s', '/', $path);
                                    ?>
                                    <a href="{{$path}}" class="noMaskImg">
                                        <img src="{{asset($post->category_image)}}" alt="news5"/>
                                    </a>

                                    <div class="titleBlock" style="min-height: 78px">
                                        <a href="{{$path}}">{{Translate::getValue($post->title_lang_key)}}</a>
                                    </div>
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
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-12 smallBlocks p--8">
            <div class="row m--8">
                @foreach ($news as $post)
                    @if ($loop->index > 2)
                        @if (!is_null($post['getCategory']))
                            <div class="col-12 p--8 col-md-6 col-lg-4">
                                <div class="smallBlock br-4 maskShadow">
                                    <?php
                                    // Temporary solutions
                                    $path = "";
                                    if ($post['getCategory']->full_url) {
                                        $path .= "/{$post['getCategory']->full_url}";
                                    }
                                    $path .= "/{$post['getCategory']->friendly_url}/{$post->friendly_url}/";
                                    $path = preg_replace('|([/]+)|s', '/', $path);
                                    ?>
                                    <a href="{{$path}}" class="noMaskImg">
                                        <img src="{{asset($post->category_image)}}" alt="news3-q"  class="pull-left"/></a>
                                        <div class="titleLinkBlock">
                                            <div class="titleBlock">
                                                <a href="{{$path}}">{{Translate::getValue($post->title_lang_key)}}</a>
                                            </div>
                                            <div class="bottomInform">
                                            <div class="pull-left">
                                                <span class="dateBlock">{{date('d F', strtotime($post->created_at))}}</span>
                                                <span class="separator"> / by </span>
                                                <span class="authorName"><a href="/author/{{$post->getAuthor->url}}/">{{Translate::getValue($post->getAuthor->first_name_lang_key)}} {{Translate::getValue($post->getAuthor->last_name_lang_key)}}</a></span>
                                            </div>
                                            <div class="pull-right">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="container subscribeBlock upToDateForm">
    <div class="row m--8 alignCenterFlex">
        <div class="col-12 col-md-1 p--8 text-md-left text-center rotateImg"><img src="{{asset('images/svg/metaball-subscriptions.svg')}}" alt="formSide" /></div>
        <div class="col-12 col-md-10 p--8">
            <h3 class="formTitle">Stay up to date with market trends and exclusive news!</h3>
            <form data-toggle="validator" action="//cryptovest.us16.list-manage.com/subscribe/post?u=d409eae0500b9a0f7813335a2&id=734bab7ff4" method="POST" role="form" class="form-inline row m--8" id="upToDateForm" name="mc-embedded-subscribe-form" target=“_blank”>
                <input type="hidden" name="categoryName" id="categoryName" value="news">
                <div class="form-group has-feedback col-12 p--8 col-md-4 col-lg-5">
                    <div class="input-group">
                        <span class="input-group-addon"><img src="{{asset('images/svg/person.svg')}}" /></span>
                        <input type="text" class="form-control" name="FNAME" id="inputNameUp" placeholder="Name" data-minlength="3" required>
                    </div>
                </div>
                <div class="form-group has-feedback col-12 p--8 col-md-4 col-lg-5">
                    <div class="input-group">
                        <span class="input-group-addon"><img src="{{asset('images/svg/mail.svg')}}" /></span>
                        <input type="email" class="form-control" name="EMAIL" id="inputEmailUp" placeholder="Email" required>
                    </div>
                </div>
                <div class="form-group col-12 p--8 col-md-4 col-lg-2">
                    <input type="hidden" name="b_d409eae0500b9a0f7813335a2_734bab7ff4" tabindex="-1" value="">
                    <button type="submit" value="Subscribe" name="subscribe" class="btn btn-primary btn-news-sub">Subscribe</button>
                </div>
            </form>
        </div>
        <div class="col-1 p--8 text-right hidden-sm-down"><img src="{{asset('images/svg/metaball-subscriptions.svg')}}" alt="formSide" /></div>
    </div>
</div>

<!-- review -->
<div class="container newsParentBlock middleInfoBlock">
    <div class="row m--8">
        <div class="col-12 headerBlock p--8">
            <div class="row m--8">
                <div class="col-9 p--8 col-md-6 col-lg-8">
                    <h2 class="titleBlock">reviews</h2>
                </div>
                <div class="col-3 p--8 col-md-6 col-lg-4">
                    <div class="subSmBlock">
                <span class="subscribeLink pull-left">
                    <button type="button" class="btn btn-primary btn-reviews-sub" data-toggle="modal" data-target="#newsFormModal">
                        <img src="{{asset('images/svg/mail.svg')}}" />
                        <span class="hidden-sm-down">subscribe to updates</span>
                    </button>
                </span>
                        <span class="seeMoreLink pull-right"><a href="/reviews/"><span class="hidden-sm-down">see more</span><img src="{{asset('images/svg/more.svg')}}" /></a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 bigBlocks p--8">
            <div class="row m--8">
                @foreach ($reviews as $post)
                    @if ($loop->index < 3)
                        @if (!is_null($post['getCategory']))
                            <div class="col-12 p--8 col-md-6 col-lg-4">
                                <div class="bigBlock rewiews br-4 maskShadow">
                                    {{--<div class="topSticker">reviews--}}
                                        {{--@if($post->getCategory->friendly_url != 'reviews')--}}
                                            {{--<span>{{$post->getCategory->friendly_url}}</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                    <div class="topSticker">
                                        @if (isset($post->getCategory->getParentCateg))
                                            {{ $post->getCategory->getParentCateg->friendly_url}}
                                            @if ($post->getCategory->friendly_url != $post->getCategory->getParentCateg->friendly_url)
                                            <span>{{$post->getCategory->friendly_url}}</span>
                                            @endif
                                        @else
                                            {{ $post->getCategory->friendly_url}}
                                        @endif
                                    </div>
                                    <div class="topStickerBig">
                                        <a href="/reviews/" class="showAllLink">reviews</a>
                                        @if (isset($post->getCategory->getParentCateg))
                                            @if ($post->getCategory->friendly_url != $post->getCategory->getParentCateg->friendly_url)
                                                <a href="/reviews/{{$post->getCategory->friendly_url}}" class="showAllLink">{{$post->getCategory->friendly_url}}</a>
                                            @endif
                                        @endif
                                    </div>
                                    <?php
                                    // Temporary solutions
                                    $path = "";
                                    if ($post['getCategory']->full_url) {
                                        $path .= "/{$post['getCategory']->full_url}";
                                    }
                                    $path .= "/{$post['getCategory']->friendly_url}/{$post->friendly_url}/";
                                    $path = preg_replace('|([/]+)|s', '/', $path);
                                    ?>
                                    <a href="{{$path}}" class="noMaskImg">
                                        <img src="{{asset($post->category_image)}}" alt="news5"/>
                                    </a>
                                    <div class="titleBlock" style="min-height: 78px">
                                        <a href="{{$path}}">
                                            {{Translate::getValue($post->title_lang_key)}}
                                        </a>
                                    </div>
                                </div>
                                <div class="bottomInform">
                                    <div class="pull-left">
                                        <span class="dateBlock">{{date('d F',strtotime($post->created_at))}}</span>
                                        <span class="separator"> / by </span>
                                        <span class="authorName">
                                            <a href="/author/{{$post->getAuthor->url}}/">{{Translate::getValue($post->getAuthor->first_name_lang_key)}} {{Translate::getValue($post->getAuthor->last_name_lang_key)}}</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-12 smallBlocks p--8">
            <div class="row m--8">
            @foreach ($reviews as $post)
                @if ($loop->index > 2)
                    @if (!is_null($post['getCategory']))
                        <div class="col-12 p--8 col-md-6 col-lg-4">
                            <div class="smallBlock br-4 maskShadow">
                                <?php
                                // Temporary solutions
                                $path = "";
                                if ($post['getCategory']->full_url) {
                                    $path .= "/{$post['getCategory']->full_url}";
                                }
                                $path .= "/{$post['getCategory']->friendly_url}/{$post->friendly_url}/";
                                $path = preg_replace('|([/]+)|s', '/', $path);
                                ?>
                                <a href="{{$path}}" class="noMaskImg">
                                    <img src="{{asset($post->category_image)}}" alt="news3-q"  class="pull-left"/>
                                </a>
                                <div class="titleLinkBlock">
                                    <div class="titleBlock">
                                        <a href="{{$path}}">
                                            {{Translate::getValue($post->title_lang_key)}}
                                        </a>
                                    </div>
                                    <div class="bottomInform">
                                        <div class="pull-left">
                                            <span class="dateBlock">{{date('d F', strtotime($post->created_at))}}</span>
                                            <span class="separator"> / by </span>
                                            <span class="authorName"><a href="author/{{$post->getAuthor->url}}/">{{Translate::getValue($post->getAuthor->first_name_lang_key)}} {{Translate::getValue($post->getAuthor->last_name_lang_key)}}</a></span>
                                        </div>
                                        <div class="pull-right">
                                            {{--<span class="shareTotal"><img src="{{asset('images/svg/shareNwS.svg')}}" class="shareImg hidden-sm-down"/>--}}
                                                {{--<img src="{{asset('images/svg/shareNw.svg')}}" class="shareImg hidden-sm-up"/>76--}}
                                            {{--</span>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
            </div>
        </div>
    </div>
</div>
<!--education -->
<div class="container newsParentBlock middleInfoBlock">
    <div class="row m--8">
        <div class="col-12 headerBlock p--8">
            <div class="row m--8">
                <div class="col-9 p--8 col-md-6 col-lg-8">
                    <h2 class="titleBlock">education</h2>
                </div>
                <div class="col-3 p--8 col-md-6 col-lg-4">
                    <div class="subSmBlock">
                <span class="subscribeLink pull-left">
                    <button type="button" class="btn btn-primary btn-reviews-sub" data-toggle="modal" data-target="#newsFormModal">
                        <img src="{{asset('images/svg/mail.svg')}}" />
                        <span class="hidden-sm-down">subscribe to updates</span>
                    </button>
                </span>
                <span class="seeMoreLink pull-right">
                    <a href="/education/"><span class="hidden-sm-down">see more</span>
                        <img src="{{asset('images/svg/more.svg')}}" />
                    </a>
                </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 bigBlocks p--8">
        <div class="row m--8">
            @foreach ($education as $post)
                @if ($loop->index < 3)
                    @if (!is_null($post['getCategory']))
                        <div class="col-12 p--8 col-md-6 col-lg-4">
                            <div class="bigBlock education br-4 maskShadow">
                                {{--<div class="topSticker">education--}}
                                    {{--@if($post->getCategory->friendly_url != 'education')--}}
                                        {{--<span>{{$post->getCategory->friendly_url}}</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                                <div class="topSticker">
                                    @if (isset($post->getCategory->getParentCateg))
                                        {{ $post->getCategory->getParentCateg->friendly_url}}
                                        @if ($post->getCategory->friendly_url != $post->getCategory->getParentCateg->friendly_url)
                                        <span>{{$post->getCategory->friendly_url}}</span>
                                        @endif
                                    @else
                                        {{ $post->getCategory->friendly_url}}
                                    @endif
                                </div>
                                <div class="topStickerBig">
                                    <a href="/education/" class="showAllLink">education</a>
                                    @if (isset($post->getCategory->getParentCateg))
                                        @if ($post->getCategory->friendly_url != $post->getCategory->getParentCateg->friendly_url)
                                            <a href="/education/{{$post->getCategory->friendly_url}}" class="showAllLink">{{$post->getCategory->friendly_url}}</a>
                                        @endif
                                    @endif
                                </div>
                                <?php
                                // Temporary solutions
                                $path = "";
                                if ($post['getCategory']->full_url) {
                                    $path .= "/{$post['getCategory']->full_url}";
                                }
                                $path .= "/{$post['getCategory']->friendly_url}/{$post->friendly_url}/";
                                $path = preg_replace('|([/]+)|s', '/', $path);
                                ?>
                                <a href="{{$path}}" class="noMaskImg">
                                    <img src="{{asset($post->category_image)}}" alt="news5"/>
                                </a>
                                <div class="titleBlock" style="min-height: 78px">
                                    <a href="{{$path}}">
                                        {{Translate::getValue($post->title_lang_key)}}
                                    </a>
                                </div>
                            </div>
                            <div class="bottomInform">
                                <div class="pull-left">
                                    <span class="dateBlock">{{date('d F',strtotime($post->created_at))}}</span>
                                    <span class="separator"> / by </span>
                                    <span class="authorName">
                                        <a href="/author/{{$post->getAuthor->url}}/">{{Translate::getValue($post->getAuthor->first_name_lang_key)}} {{Translate::getValue($post->getAuthor->last_name_lang_key)}}</a>
                                    </span>
                                </div>
                                {{--<div class="pull-right">--}}
                                {{--<span class="shareTotal"><img src="images/svg/shareNw.svg" class="shareImg"/>12</span>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
    <div class="col-12 smallBlocks p--8">
        <div class="row m--8">
            @foreach ($education as $post)
                @if ($loop->index > 2)
                    @if (!is_null($post['getCategory']))
                        <div class="col-12 p--8 col-md-6 col-lg-4">
                        <div class="smallBlock br-4 maskShadow">
                            <?php
                            // Temporary solutions
                            $path = "";
                            if ($post['getCategory']->full_url) {
                                $path .= "/{$post['getCategory']->full_url}";
                            }
                            $path .= "/{$post['getCategory']->friendly_url}/{$post->friendly_url}/";
                            $path = preg_replace('|([/]+)|s', '/', $path);
                            ?>
                            <a href="{{$path}}" class="noMaskImg">
                                <img src="{{asset($post->category_image)}}" alt="news3-q"  class="pull-left"/>
                            </a>
                            <div class="titleLinkBlock">
                                <div class="titleBlock">
                                    <a href="{{$path}}">
                                        {{Translate::getValue($post->title_lang_key)}}</a>
                                </div>
                                <div class="bottomInform">
                                    <div class="pull-left">
                                        <span class="dateBlock">{{date('d F', strtotime($post->created_at))}}</span>
                                        <span class="separator"> / by </span>
                                        <span class="authorName"><a href="/author/{{$post->getAuthor->url}}/">{{Translate::getValue($post->getAuthor->first_name_lang_key)}} {{Translate::getValue($post->getAuthor->last_name_lang_key)}}</a></span>
                                    </div>
                                    <div class="pull-right">
                                        {{--<span class="shareTotal">--}}
                                            {{--<img src="images/svg/shareNwS.svg" class="shareImg hidden-sm-down"/>--}}
                                            {{--<img src="images/svg/shareNw.svg" class="shareImg hidden-sm-up"/>76--}}
                                        {{--</span>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
            @endforeach
    </div>
</div>
</div>
</div>

<div class="container subscribeBlock latestReviewsForm">
    <div class="row m--8 alignCenterFlex">
        <div class="col-12 col-md-1 p--8 text-md-left text-center rotateImg"><img src="{{asset('images/svg/metaball-subscriptions.svg')}}" alt="formSide" /></div>
        <div class="col-12 col-md-10 p--8">
            <h3 class="formTitle">Get the latest reviews and educational content to your inbox, and become a better investor</h3>
            <form data-toggle="validator" action="//cryptovest.us16.list-manage.com/subscribe/post?u=d409eae0500b9a0f7813335a2&id=734bab7ff4" method="POST" role="form" class="form-inline row m--8" id="latestReviewsForm" name="mc-embedded-subscribe-form" target=“_blank”>
                <input type="hidden" name="categoryName" id="categoryName" value="education">
                <div class="form-group has-feedback col-12 p--8 col-md-4 col-lg-5">
                    <div class="input-group">
                        <span class="input-group-addon"><img src="{{asset('images/svg/person.svg')}}" /></span>
                        <input type="text" class="form-control" name="FNAME" id="inputName" placeholder="Name" data-minlength="3" required>
                    </div>
                </div>
                <div class="form-group has-feedback col-12 p--8 col-md-4 col-lg-5">
                    <div class="input-group">
                        <span class="input-group-addon"><img src="{{asset('images/svg/mail.svg')}}"/></span>
                        <input type="email" class="form-control"  name="EMAIL" id="inputEmail" placeholder="Email" required>
                    </div>
                </div>
                <div class="form-group col-12 p--8 col-md-4 col-lg-2">
                    <input type="hidden" name="b_d409eae0500b9a0f7813335a2_734bab7ff4" tabindex="-1" value="">
                    <button type="submit" value="Subscribe" name="subscribe" class="btn btn-primary btn-reviews-sub">Subscribe</button>
                </div>
            </form>
        </div>
        <div class="col-1 p--8 text-right hidden-sm-down"><img src="{{asset('images/svg/metaball-subscriptions.svg')}}" alt="formSide" /></div>
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
    <script type="text/javascript" src="https://files.coinmarketcap.com/static/widget/currency.js"></script>
    <script>
        $(document).ready(function () {
           $('.btn-reviews-sub').click(function () {
               $('#newsFormModal input[name="categoryName"]').val('education');
               $('#newsFormModal button[type="submit"]').removeClass('btn-news-sub');
               $('#newsFormModal button[type="submit"]').addClass('btn-reviews-sub');
           });
            $('.btn-news-sub').click(function () {
                $('#newsFormModal input[name="categoryName"]').val('news');
                $('#newsFormModal button[type="submit"]').removeClass('btn-reviews-sub');
                $('#newsFormModal button[type="submit"]').addClass('btn-news-sub');
            });
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
                   $('#newsFormModal').modal('hide');
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
