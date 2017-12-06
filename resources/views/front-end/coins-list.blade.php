
@extends('layouts.main')

@section('title', 'Cryptocurrency Prices & Charts for BTC & Alt Coins - Cryptovest')
@section('body-class', 'mainPage')
@section('meta-tags')
    <meta name="description" content="Our cryptocurrency index brings you the latest, real-time price action for all cryptocurrencies along with charts and statistics such as market cap, trading volume and exchange listings">
    <meta name="robots" content="noindex,nofollow" />
@endsection
@section('styles-css')
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/coins.css')}}">
    <input type="hidden" id="token" data="{{csrf_token()}}">
@endsection
@section('content')
    <div class="container topBlock">
        <div class="row m--8">
            <div class="col-12 p--8 col-md-12 col-lg-12 description-block">
                <h2 class="titleBlock">Crypto Coins</h2>
                <p class="description-text">Use this exchange list to find a cryptocurrency exchange for you. Each user has unique needs, so there is no one size fits all for exchanges.</p>
                <div class="description-item-wraper">
                </div>
            </div>
        </div>
    </div>

    <div id="tabs" class="container newsParentBlock middleInfoBlock listing coins-list">
        <div class="row m--8">
            <div class="col-12 headerBlock p--8">
                <div class="row m--8 tabs-line">
                    <div class="tabs col-lg-8 col-md-12 col-sm-12">
                        <ul class="tabs-list list-inline">
                            <li class="tab-element" data-tab-value = '1'>TOP 100</li>
                            <li class="tab-element" data-tab-value = '2'>101-1000</li>
                        </ul>
                    </div>
                    <div class="search-block col-lg-4 col-md-12 col-sm-12">
                        <div class="search">
                            <input id="search" type="text" class="searching-inputs">
                            <label for="search" id='show-search'>
                                <span><img src="{{asset('images/search.png')}}"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 bigBlocks p--8 coins-list-table">
                <div class="row m--8" id="container">
                    <div class="p--8 col-md-12 col-sm-12 col-lg-12 main-new">
                        <div id="tabs-1" class="upcomming-list">
                            <!-- first table -->
                            <table class="main-list">
                                <thead>
                                <tr>
                                    <th class="no-sort">#</th>
                                    <th id = 'primaryColumn'>NAME</th>
                                    <th class="no-sort">SYMBOL</th>
                                    <th>MARKETCAP</th>
                                    <th>PRICE <span>USD</span></th>
                                    <th>PRICE BTC</th>
                                    <th>CHANGE (24H)</th>
                                    <th>VOLUME (24H)</th>
                                    <th>SUPPLY</th>
                                </tr>
                                </thead>
                                <tbody id = 'main-table-coins'>
                                @foreach ($coinsList as $k => $coin)
                                    <tr>
                                        <td> {{ $k + 1 }} </td>
                                        <td class="first-cell">
                                        <!-- <span class="img hidden-md-down">
                                                        <a href="/coins-one/{{$coin->slug}}" rel="canonical"><img src="{{asset(\App\CoinValue::getValueImage($coin->symbol))}}" alt="icon"></a>
                                                </span> -->
                                            <a>{{$coin->name}}</a>
                                            <span class="bottom-short">{{$coin->symbol}}</span>
                                        </td>
                                        <td>{{$coin->symbol}}</td>
                                        <td>${{$coin->marketcap_usd}}</td>
                                        <td data-order = "{{$coin->price_usd}}">${{$coin->price_usd}}
                                            <span class="bottom-price @if ($coin->price_btc < 1) {{ "color-btc-red" }} @else {{ "color-btc-green" }} @endif"">{{round($coin->price_btc, 4)}} BTC</span>
                                        </td>
                                        <td>{{ round($coin->price_btc, 4)}} BTC</td>
                                        <td><span class="@if ($coin->change_24 < 0) {{ "color-btc-red" }} @else {{ "color-btc-green" }} @endif">{{$coin->change_24}}%</span></td>
                                        <td data-order = "{{$coin->volume_btc}}">{{$coin->volume_btc}} BTC </td>
                                        <td>{{$coin->total_supply}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div id = 'executivePre'>
                                <img class="preloader" src="{{asset('/images/svg/metaball-subscriptions.svg')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <!--  Only for Desctop (up) -->
            </div>
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
    <script src="{{asset('js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('js/coins.js')}}"></script>    

@endsection
