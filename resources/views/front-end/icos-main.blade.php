@extends('layouts.main')

@section('title', 'ICOs - Cryptovest')
@section('body-class', 'mainPage')
@section('meta-tags')
    <meta name="description" content="Cryptovest - ICOs.">
@endsection
@section('styles-css')
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
    <input type="hidden" id="token" data="{{csrf_token()}}">
@endsection
@section('content')
    <div class="container topBlock">
        <div class="row m--8">
            <div class="col-12 p--8 col-md-12 col-lg-7 description-block">
                <h2 class="titleBlock">Upcoming and Live ICOs</h2>
                <p class="description-text">Cryptovest’s team of experts rates ICOs out of 100 based on several factors.
                    We read dozens of white-papers every day so we can provide you with trusted reviews and opinions to help
                    you make better investment decisions.</p>
                <div class="description-item-wraper">
                    <a href = '#' class="btn btn-primary subscribe" data-toggle="modal" data-target="#newsFormModal">Subscribe for Updates</a>
                    <a href = '/ico/deal-form/' class="btn btn-primary submit-ico">Submit an ICO</a>
                </div>
            </div>
            @if($topICO)
                <div class="col-12 p--8 col-md-12 col-lg-5 timer-block" style="height: 250px">
                    <div class="row m--8">
                        {{--<div class="sun">--}}
                            {{--<img src="{{asset('images/sun.png')}}">--}}
                        {{--</div>--}}
                        <div class="ico-name">
                            @if (strlen($topICO->image) > 200)
                                <a href="/ico/{{$topICO->friendly_url}}/" rel="canonical"><img src="{!! $topICO->image !!}"></a>
                            @else
                                <a href="/ico/{{$topICO->friendly_url}}/" rel="canonical"><img src="{{asset($topICO->image)}}"></a>
                            @endif
                            <div class="smartre-text">
                                <span class="token-sale"><a href="/ico/{{$topICO->friendly_url}}/">{{$topICO->title}}</a></span><br>
                                @if($topICO->data_end > date('Y-m-d H:i:s', time()) && date('Y-m-d H:i:s', time()) > $topICO->data_start)
                                    <span class="token-sale-end">Ends In: {{date('M dS Y H:i',strtotime($topICO->data_end))}} UTC</span>
                                @elseif($topICO->data_end > $topICO->data_start && $topICO->data_start > date('Y-m-d H:i:s', time()))
                                    <span class="token-sale-end">Starts In: {{date('M dS Y H:i',strtotime($topICO->data_start))}} UTC</span>
                                @endif
                            </div>
                        </div>
                        @if (isset($IcoTime))
                            <div class='countdown' data-date="{{$IcoTime}}"></div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div id="tabs" class="container newsParentBlock middleInfoBlock listing">
        <div class="row m--8">
            <div class="col-12 headerBlock p--8">
                <div class="row m--8 tabs-line">
                    <div class="tabs col-lg-8 col-md-12 col-sm-12">
                        <ul class="tabs-list list-inline">
                            <li class="tab-element" data-tab-value = 'live'>Live ICOs</li> 
                            <li class="tab-element" data-tab-value = 'upcoming'>Upcoming ICOs</li>                                     
                            <li class="tab-element" data-tab-value = 'finished'>Finished ICOs</li>
                            <li class="tab-element" data-tab-value = 'fraud'>Fraud</li>
                        </ul>
                    </div>
                    <div class="search-block col-lg-4 col-md-12 col-sm-12">
                        <div class="search">
                            <div class="btn-group">
                                <div data-toggle="dropdown" class="btn btn-default dropdown-toggle categories-dropdown" id="changed-category">Category<span class="caret"></span></div>
                                <ul class="dropdown-menu categories">
                                    @foreach($categ as $c)
                                        <li data-category = "{{$c->getCategory ? strtolower($c->getCategory->name) : ""}}">{{$c->getCategory ? $c->getCategory->name : ""}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <input id="search" type="text" class="searching-inputs">
                            <label for="search" id='show-search'>
                                <span><img src="{{asset('images/search.png')}}"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- for mobile -->
                <div class="search-block mobile col-md-12 col-sm-12">
                    <div class="search">
                        <div class="btn-group">
                            <div data-toggle="dropdown" class="btn btn-default dropdown-toggle categories-dropdown">Category<span class="caret"></span></div>
                            <ul class="dropdown-menu categories">
                                @foreach($categ as $c)
                                    <li data-category = "{{$c->getCategory ? strtolower($c->getCategory->name) : ""}}">{{$c->getCategory ? $c->getCategory->name : ""}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="searching-mobile">
                            <input id="search-mobile" type="text" class="searching-inputs">
                            <label for="search-mobile" id='show-search-mobile'>
                                <span><img src="{{asset('images/search.png')}}"></span>
                            </label>
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-12 bigBlocks p--8">
                <div class="row m--8" id="container">
                    <div class="p--8 col-md-12 col-sm-12 col-lg-12 main-new">
                        <div id="tabs-1" class="upcomming-list">
                            <!-- first table -->
                            <table class="main-list">
                                <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th class="no-sort">CATEGORY</th>
                                    <th>START DATE</th>
                                    <th>ENDS IN</th>
                                </tr>
                                </thead>
                                <tbody id = 'main-table-icos'>
                               
                                </tbody>
                            </table>
                        </div>
                        <!--</div> -->

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
    <script>
        // $(document).ready(function() {
        //     var table = $('.main-list').DataTable( {
        //         "columnDefs": [ {
        //             "targets": 'no-sort',
        //             "orderable": false,
        //         } ],
        //         "order": [],
        //         "paging":   false,
        //         "info":     false,
        //          "retrieve": true,
        //          "bStateSave": true
        //     } );
        // } );
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
    <script src="{{asset('js/moment.js')}}"></script>
    <script src="{{asset('js/datetime-moment.js')}}"></script>
    <script src="{{asset('js/listing-page.js')}}"></script>

@endsection
@section('secondstep')
    @include('front-end.layouts.subscrsecondstep')
@endsection
