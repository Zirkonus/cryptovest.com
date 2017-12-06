@extends('front-end.amp.app')

@section('title', Translate::getValue($post->title_lang_key))

@section('amp_section')
    <link rel="canonical" href="{{ $url }}/">
    <title>{{Translate::getValue($post->title_lang_key)}}</title>
    <meta property="og:locale" content="en_US" />
    <meta name="description" content="{{Translate::getValue($post->description_lang_key)}}" />
    
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{Translate::getValue($post->title_lang_key)}} - Cryptovest" />
    <meta property="og:description" content="{{Translate::getValue($post->description_lang_key)}}" />
    <meta property="og:url" content="{{Request::url()}}" />
    <meta property="og:site_name" content="Cryptovest" />
    @if($post->getAuthor->facebook_link)
        <meta property="article:publisher" content="{{$post->getAuthor->facebook_link}}" />
    @endif
    @foreach($post->getMetaContent as $k)
        @if($k->meta_type_id == 3)
            <meta property="article:tag" content="{{$k->content}}" />
        @endif
    @endforeach
    @if($post->getCategory->friendly_url == 'news')
        <meta property="article:section" content="News" />
    @else
        <meta property="article:section" content="{{$post->getCategory->friendly_url}}_category" />
    @endif
    <meta property="article:published_time" content="{{date('c', strtotime($post->created_at))}}" />
    <meta property="og:image" content="{{asset($post->title_image)}}">
    <meta property="og:image:width" content="{{ $post->title_image_width or '600' }}" />
    <meta property="og:image:height" content="{{ $post->title_image_height or '400' }}" />
    
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="{{Translate::getValue($post->title_lang_key)}} - Cryptovest" />
    <meta name="twitter:description" content="{{Translate::getValue($post->description_lang_key)}}" />
    <meta name="twitter:image" content="{{asset($post->title_image)}}" />
    <meta property="DC.date.issued" content="{{date('c', strtotime($post->created_at))}}" />


    <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "BlogPosting",
        "headline": "{!! Translate::getValue($post->title_lang_key) !!}",
        "articleBody": "{!! Translate::getValue($post->description_lang_key) !!}",
        "datePublished": "{{ $post->created_at }}",
        "author": { "@type": "Organization ", "name": "Cryptovest" },
        "publisher": { "@type": "Organization ", "name": "Cryptovest", "logo": "https://cryptovest.com/images/svg/cv-logo-topbar.svg"},
        "image": {
            "@type": "ImageObject",
            "representativeOfPage": "true",
            "url": "{{asset($post->title_image)}}",
            "height":"{{ $post->title_image_height or '400' }}",
            "width":"{{ $post->title_image_width or '600' }}"
        }
      }
    </script>
     <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>   
@endsection
@section('content')
    <amp-analytics config="https://www.googletagmanager.com/amp.json?id=GTM-P77W82D&gtm.url=SOURCE_URL" data-credentials="include"></amp-analytics>
	<div class="header">
		<a href="{{ url('/') }}"><amp-img src="{{asset("/images/svg/cv-logo-topbar.svg")}}"  width="147.1" height="21.5"></amp-img></a>
		<a href="{{ $url }}/?pop" class="subscribe-button">Subscribe</a>
	</div>
  	<div class="main-container">
  		<h1 class="main-title">
            {{Translate::getValue($post->title_lang_key)}}
  		</h1>
  		<h3 class="title-description">
            {{Translate::getValue($post->description_lang_key)}}
  		</h3>
  		<div class="autor-block">
            <a href="/author/{{$post->getAuthor->url}}/">
  			<amp-img src="{{asset($post->getAuthor->profile_image)}}" alt="author" width="40" height="40"></amp-img>
  			<span class="autor-name">by {{Translate::getValue($post->getAuthor->first_name_lang_key)}} {{Translate::getValue($post->getAuthor->last_name_lang_key)}}, {{date('d F', strtotime($post->created_at))}}</span></a>
  		</div>
  		<amp-img src="{{asset($post->title_image)}}" alt="articleStartImage" class ="title-image" layout="responsive" width="{{ $post->title_image_width or '0' }}" height="{{ $post->title_image_height or '0' }}"></amp-img>
  		<div class="article-body">
            {!! $post->content !!}            
  		</div>
        <div class="shared-buttons">
            <amp-social-share type="linkedin" width="30" height="30"
              data-param-text="{{Translate::getValue($post->title_lang_key)}}"
              data-param-url="{{ $url }}">
            </amp-social-share>            
            <amp-social-share type="twitter" width="30" height="30"
              data-param-text="{{Translate::getValue($post->title_lang_key)}}"
              data-param-url="{{ $url }}">
            </amp-social-share>
            <a href="{{ $url }}/?pop" class="subscribe-button">Subscribe</a>
        </div>
        <div class="latest-news">
            <h3 class="news-title">latest news <a href="{{ url('/news') }}/">see more</a></h3>
            @foreach($latestPosts as $lat)
                <div class="latest-news-one">
                    <a href="/{{$lat->getCategory->friendly_url}}/{{$lat->friendly_url}}/"><amp-img src="{{asset($lat->short_image)}}"  width="96" height="96"></amp-img></a>
                    <a href="/{{$lat->getCategory->friendly_url}}/{{$lat->friendly_url}}/" class="latest-news-title">{{Translate::getValue($lat->title_lang_key)}}</a>
                    <a href="/author/{{$lat->getAuthor->url}}/"><span class="latest-autor">by {{Translate::getValue($lat->getAuthor->first_name_lang_key)}} {{Translate::getValue($lat->getAuthor->last_name_lang_key)}}</span></a>
                </div>
            @endforeach
        </div>
        <div class="may-like">
            <h3 class="news-title">you may like</h3>
            @foreach($likesPost as $postLike)
                @if($loop->index === 2)
                    @break
                @endif
                <div class="like-one">
                        @php
                            $path = "";
                            if ($postLike['getCategory']->full_url) {
                            $path .= "/{$postLike['getCategory']->full_url}";
                            }
                            $path .= "/{$postLike['getCategory']->friendly_url}/{$postLike->friendly_url}/";
                            $path = preg_replace('|([/]+)|s', '/', $path);
                        @endphp
                    <a href="{{ $path }}" class="img-link"><amp-img src="{{asset($postLike->title_image)}}" width="96" layout="responsive" height="160"></amp-img></a>                       
                    <a href="{{ $path }}">{{str_limit(Translate::getValue($postLike->title_lang_key), $limit = 80, $end = '...')}}</a>
                    <a href="/author/{{$postLike->getAuthor->url}}/"><span class="like-autor">{{date('d F', strtotime($postLike->created_at))}} by {{Translate::getValue($postLike->getAuthor->first_name_lang_key)}} {{Translate::getValue($postLike->getAuthor->last_name_lang_key)}}</span></a>
                </div>            
            @endforeach
        </div>
        <div class="footer">
            <a href="{{ url('/') }}"><amp-img src="{{asset("/images/svg/cv-logo-topbar.svg")}}"  width="147.1" height="21.5"></amp-img></a>
            <div class="footer-menu">
                <ul>
                    <li><a href="{{ url('/about') }}/">ABOUT</a></li>
                    <li><a href="{{ url('/contact') }}/">CONTACT</a></li>
                </ul>
            </div>
        </div>
  	</div>
    @endsection
