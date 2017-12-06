@extends('layouts.main')
@section('title', Translate::getValue($page->title_lang_key) . " - Cryptovest")
@section('meta-tags')
    <meta name="description" content="{{Translate::getValue($page->description_lang_key)}} - Cryptovest">
@endsection
@section('body-class', 'aboutPage secondaryPages')
@section('content')
    <div class="container topAboutBlock">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-8">
                <h1>{{Translate::getValue($page->title_main_block_lang_key)}}</h1>
                <sub>{{Translate::getValue($page->content_lang_key)}}</sub>
            </div>
            <div class="col-12 col-md-4 col-lg-4 text-center hidden-sm-down">
                <img src="{{asset('images/svg/element.svg')}}" alt="element" />
            </div>
        </div>
    </div>
    <div class="container middleAboutBlock">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-4">
                <h2>{{Translate::getValue($page->title_first_block_lang_key)}}</h2>
                <p>{{Translate::getValue($page->text_first_block_lang_key)}}</p>
            </div>
            <div class="col-12 col-md-1 col-lg-1"></div>
            <div class="col-12 col-md-7 col-lg-7 blockquoteBlock">
                <h2>{{Translate::getValue($page->title_second_block_lang_key)}}</h2>
                <blockquote class="blockquote">{{Translate::getValue($page->text_second_block_lang_key)}}</blockquote>
                <p>{{Translate::getValue($page->reserve_text_block_lang_key)}}</p>
            </div>
        </div>
    </div>
    <div class="container bottomAboutBlock">
            <div class="row">
                <h2 class="col-12">Writers team</h2>
                @foreach($users as $u)
                    @if ($u->is_admin != 0 and $u->is_admin != 2) @continue @endif
                    <div class="col-12 col-md-3 col-lg-3">
                        <a href="/author/{{$u->url}}/" class="image"><img src="{{asset($u->profile_image)}}" alt="team-1"/></a>
                        <div class="namePersone"><a href="/author/{{$u->url}}/">{{Translate::getValue($u->first_name_lang_key)}} {{Translate::getValue($u->last_name_lang_key)}}</a></div>
                        <div class="description" style="min-height: 315px"><p>
                            @if(strlen(Translate::getValue($u->biography_lang_key)) > 350)
                                <?php
                                    $text = substr(Translate::getValue($u->biography_lang_key), 0, 350);
                                    $text .= '...';
                                ?>
                                {{$text}}
                            @else
                                {{Translate::getValue($u->biography_lang_key)}}
                            @endif
                            </p></div>
                        <div class="socLinks">
                            @if ($u->facebook_link)
                                <a href="{{$u->facebook_link}}" target="_blank"><img src="{{asset('images/svg/LinkedIN_Color.svg')}}" alt="linkedin"></a>
                            @endif
                            @if ($u->twitter_link)
                                <a href="{{$u->twitter_link}}" target="_blank"><img src="{{asset('images/svg/Twitter_Color.svg')}}" alt="twitter"/></a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
@endsection

@section('newsFormModal')
    @include('front-end.layouts.newsformmodal')
@endsection

@section('joinFormModalButton')
    @include('front-end.layouts.joinformbutton')
@endsection
