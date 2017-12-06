@extends('layouts.main')

@section('title', "$coin->name ($coin->symbol) Price, Volume & Markets Data - Cryptovest")
@section('body-class', 'mainPage')
@section('meta-tags')
    <meta name="description" content="{{$coin->name}} ({{$coin->symbol}}/USD) Price Charts with Real Time Updates from 50+ Worldwide Exchanges - Check BTC Price Now!">
    <meta name="robots" content="noindex,nofollow" />
@endsection

@section('styles-css')
<link rel="canonical" href="">
<link rel="stylesheet" href="{{asset('css/coins.css')}}">
@endsection
@section('content')
    
        <div class="main profile-page one-ico one-coin">
        <section class="page-navigation">
            <div class="container">
                <div class="row m--8">
                    <div class="col-lg-12">
                        <nav class="breadcrumb hidden-sm-down">
                            <a class="breadcrumb-item" href="/">home</a>
                            <a class="breadcrumb-item" href="/coins/">coins</a>
                            <span class="breadcrumb-item active"><a href="" rel="canonical">{{ strtolower($coin->name) }}</a></span>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

<!-- PROFILE CONTENT -->

        <section class="profile-content coins-one">
            <div class="container">
                <div class="row m--8">
                    <div class="col-lg-12 fixed-title right-sidebar">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4 ico-name">
                                    <div class="smartre-text">
                                        <span class="token-sale">
                                            <!-- <img src="{{ asset(\App\CoinValue::getValueImage($coin->symbol)) }}"> -->
                                            <div class="coin-name-wrapper">
                                                {{ $coin->name }}
                                                <span class="short-coin">({{ $coin->symbol }})</span><br>
                                                {{--<span class="coin-rank">Rank #{{ $coin->rank }}</span>--}}
                                            </div>   
                                        </span>                                
                                    </div>
                                </div>
                                <div class="col-lg-8 coin-price-wrapper">
                                    <div class="coin-info">
                                        <span class="coin-dollar">$ {{ $coin->price_usd }}</span>
                                        <span class="coin-change" @if ($coin->change_24 < 0) style = "color: #fb3c4f" @endif>({{ $coin->change_24 }}%)</span><br>
                                        <span class="coin-bottom">{{ number_format($coin->price_btc,2) }} BTC </span>
                                    </div>
                                    <!-- <select name="price-type" id="priceType">
                                        <option value="usd">USD</option>
                                        <option value="btc">BTC</option>
                                    </select> -->
                                    <span class="price-type">USD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 fixed-sidebar right-sidebar">
                        <div class="sidebar-content">
                            <div class="status-block">
                                <div class="status">
                                    <table>
                                        {{--<tr>--}}
                                            {{--<td>Trade volume :</td>--}}
                                            {{--<td>{{ $coin->volume_btc }}</td>--}}
                                        {{--</tr>--}}
                                        @if ($coin->website)
                                            <tr>
                                                <td>Link :</td>
                                                <td><a href="{{ $coin->website }}">{{ $coin->website }}</a></td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="form-group col-12">
                                        <a target="_blank" href="{{ $linkForBuyCoin }}" class="btn btn-primary">
                                            Buy Instantly
                                    </a>
                                </div>
                            </div>
                            <div class="information">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 main-content">
                        <div class="team">
                            <table>
                                <tr>
                                    <th>MARKET CAP</th>
                                    <th>VOLUME (24H)</th>
                                    <th>CIRCULATING SUPPLY</th>
                                    {{--<th>MAX SUPPLY</th>--}}
                                </tr>
                                <tr>
                                    <td>${{ number_format($coin->marketcap_usd, 2) }}
                                        {{--<span class="table-bottom">@if (!empty(floatval($coin->price_usd))) {{ number_format($coin->marketcap_usd / $coin->price_usd, 2) }} B @endif</span>--}}
                                    </td>
                                    <td>{{ $coin->volume_btc }} BTC
                                        {{--<span class="table-bottom">@if (!empty(floatval($coin->price_usd))) {{ number_format($coin->volume_btc / $coin->price_usd, 2) }} B @endif</span>--}}
                                    </td>
                                    <td>{{ number_format($coin->circulating_supply, 2) }} BTC</td>
                                    {{--<td>{{ $coin->total_supply }}</td>--}}
                                </tr>
                            </table>
                        </div>
                        <div class="team mobile">                            
                            <table>
                                <tr>
                                    <th>MARKET CAP</th>
                                    <th>VOLUME (24H)</th>
                                </tr>
                                <tr>
                                    <td>$ {{ number_format($coin->marketcap_usd, 2) }}
                                        {{--<span class="table-bottom">@if (!empty(floatval($coin->price_usd))) {{ number_format($coin->marketcap_usd / $coin->price_usd, 2) }} B @endif</span>--}}
                                    </td>
                                    <td>{{ $coin->volume_btc }}
                                        {{--<span class="table-bottom">@if (!empty(floatval($coin->price_usd))) {{ number_format($coin->volume_btc / $coin->price_usd, 2) }} B @endif</span>--}}
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <th>CIRCULATING SUPPLY</th>
                                    <th>MAX SUPPLY</th>
                                </tr>
                                <tr>
                                    <td>{{ number_format($coin->circulating_supply, 2) }}</td>
                                    <td>{{ $coin->total_supply }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="trading-markets">
                            <h3 class="trading-title">Trading markets for {{ $coin->name }}</h3>
                            <div class="trading-table-wrapper">
                                <table>
                                    <tr>
                                        <th>MARKET</th>
                                        <th>PAIR</th>
                                        <th>PRICE</th>
                                        <th>VOLUME</th>
                                    </tr>
                                    @foreach ($exchangesListForView as $exchangeForView)
                                            <tr>
                                                <td>{{ $exchangeForView['name'] }}</td>
                                                <td>{{ $exchangeForView['market'] }}</td>
                                                @php
                                                    $position = strpos($exchangeForView['market'], "/");
                                                    $row = substr($exchangeForView['market'], $position + 1);
                                                @endphp
                                                <td>{{ number_format($exchangeForView['price'], 2) }} {{$row}}</td>
                                                <td>{{ number_format($exchangeForView['volume_btc'], 2) }} BTC</td>
                                            </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row m--8 tabs-line">
                        <div class="tabs col-lg-8 col-md-12 col-sm-12">
                            @php($languageValue = Translate::getValue($coin->description_lang_key))
                            <ul class="tabs-list list-inline">
                                <li class="coin-tab-element active" data-tab-value = 'news'>NEWS</li>
                                @if (!stripos($languageValue, $coin->description_lang_key) && $languageValue != $coin->description_lang_key)
                                <li class="coin-tab-element" data-tab-value = 'overview'>OVERVIEW</li>
                                @endif
                                <li class="coin-tab-element" data-tab-value = 'education'>EDUCATION</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 smallBlocks p--8 coins-tab news">
                    <div class="row m--8">
                        @foreach ($news as $news)
                            <div class="col-12 p--8 col-md-6 col-lg-4">
                                <div class="smallBlock br-4 maskShadow">
                                    <a href="" class="noMaskImg">
                                    <img src="{{asset($news->title_image)}}" alt="news3-q"  class="pull-left"/></a>
                                    <div class="titleLinkBlock">
                                        <div class="titleBlock">
                                            @php
                                                $path = "";
                                                if ($news['getCategory']->full_url) {
                                                $path .= "/{$news['getCategory']->full_url}";
                                                }
                                                $path .= "/{$news['getCategory']->friendly_url}/{$news->friendly_url}/";
                                                $path = preg_replace('|([/]+)|s', '/', $path);
                                            @endphp
                                            <a href="{{ $path }}">{{str_limit(Translate::getValue($news->title_lang_key), $limit = 80, $end = '...')}}</a>
                                        </div>
                                            <div class="bottomInform">
                                                <div class="pull-left">
                                                    <span class="dateBlock">{{date('d F', strtotime($news->created_at))}}</span>
                                                    <span class="separator"> / by </span>
                                                    <span class="authorName"><a href='/author/{{$news->getAuthor->url}}/'>{{Translate::getValue($news->getAuthor->first_name_lang_key)}} {{Translate::getValue($news->getAuthor->last_name_lang_key)}}</a></span>
                                                </div>
                                        <div class="pull-right"></div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 smallBlocks p--8 coins-tab overview">
                    <div class="row m--8">
                        <div class="col-12 p--8 col-md-12 col-lg-12 overview-block">
                            {!! Translate::getValue($coin->description_lang_key) !!}
                        </div>
                    </div>
                </div>
                <div class="col-12 smallBlocks p--8 coins-tab education">
                    <div class="row m--8">
                        @foreach ($education as $education)
                            <div class="col-12 p--8 col-md-6 col-lg-4">
                                <div class="smallBlock br-4 maskShadow">
                                    <a href="" class="noMaskImg">
                                        <img src="{{asset($education->title_image)}}" alt="news3-q"  class="pull-left"/></a>
                                    <div class="titleLinkBlock">
                                        <div class="titleBlock">
                                            @php
                                                $path = "";
                                                if ($education['getCategory']->full_url) {
                                                $path .= "/{$education['getCategory']->full_url}";
                                                }
                                                $path .= "/{$education['getCategory']->friendly_url}/{$education->friendly_url}/";
                                                $path = preg_replace('|([/]+)|s', '/', $path);
                                            @endphp
                                            <a href="{{ $path }}">{{str_limit(Translate::getValue($education->title_lang_key), $limit = 80, $end = '...')}}</a>
                                        </div>
                                        <div class="bottomInform">
                                            <div class="pull-left">
                                                <span class="dateBlock">{{date('d F', strtotime($education->created_at))}}</span>
                                                <span class="separator"> / by </span>
                                                <span class="authorName"><a href='/author/{{$education->getAuthor->url}}/'>{{Translate::getValue($education->getAuthor->first_name_lang_key)}} {{Translate::getValue($education->getAuthor->last_name_lang_key)}}</a></span>
                                            </div>
                                            <div class="pull-right"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
    <script src="{{asset('js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('js/coins-one.js')}}"></script>
    <script>
        // $(document).ready(function() {
        //     $('.main-list').DataTable();
        // } );
    </script>
@endsection
