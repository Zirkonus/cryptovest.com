@extends('layouts.main')

@section('title', 'Events - Cryptovest')
@section('body-class', 'mainPage')
@section('meta-tags')
    <meta name="description" content="Cryptovest - Events.">
@endsection
@section('styles-css')
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
    <input type="hidden" id="token" data="{{csrf_token()}}">
@endsection
@section('content')
    <div class="container topBlock events-header">
        <div class="row m--8">
            <div class="col-12 p--8 description-block">
                <h2 class="titleBlock">Blockchain Events
                    and Conferences</h2>
                <p class="description-text">Explore the most high-profile blockchain events and conferences coming up worldwide. Blockchain events bring new enthusiasm, popularity and credibility to the crypto world- and they drive innovation and integration. Listen in, attend, explore, invest.</p>
            </div>
        </div>
    </div>
    <div id="tabs" class="container newsParentBlock middleInfoBlock listing events">
        <div class="row m--8">
            <div class="col-12 headerBlock p--8">
                <div class="row m--8 tabs-line">
                    <div class="tabs col-lg-6 col-md-12 col-sm-12">
                    </div>
                    <div class="search-block col-lg-6 col-md-12 col-sm-12">
                        <div class="search">
                            <div class="btn-group">
                                <div data-toggle="dropdown" class="btn btn-default dropdown-toggle categories-dropdown" id="changed-category">Location<span class="caret"></span></div>
                                <?php
                                $countries = [];
                                foreach($cities as $city) {
                                    $countries[] = $city->country->name;
                                }
                                $countries = array_unique($countries);
                                ?>
                                <ul class="dropdown-menu categories">
                                    <li><a>All</a></li>
                                    @foreach($countries as $country)
                                        <li><a>{{$country}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <input id="search" type="text" class="searching-inputs">
                            <label for="search" id='show-search'>
                                <span><img src="/images/search.png"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- for mobile -->
                <div class="search-block mobile col-md-12 col-sm-12">
                    <div class="search">
                        <div class="btn-group">
                            <div data-toggle="dropdown" class="btn btn-default dropdown-toggle categories-dropdown">Location<span class="caret"></span></div>
                            <ul class="dropdown-menu categories">
                                <li><a>All</a></li>
                                @foreach($countries as $country)
                                    <li><a>{{$country}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="searching-mobile">
                            <input id="search-mobile" type="text" class="searching-inputs">
                            <label for="search-mobile" id='show-search-mobile'>
                                <span><img src='/images/search.png'></span>
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
                                    <th>START DATE</th>
                                    <th>LOCATION</th>
                                    <th class="no-sort"></th>
                                </tr>
                                </thead>
                                <tbody id = 'main-table-events'>
                                @foreach($events as $event)
                                    <tr>
                                        <td class="first-cell">
                                            <span class="row-title" data-toggle="collapse" data-target="#accordion_{{$event->id}}" style = 'cursor:pointer'>{{$event->name}}</span>
                                            @if($event->ico_promotion_id < 3 && $event->ico_promotion_id)
                                                <span class="featured">Featured</span>
                                            @endif
                                            <span class="star">
                                                    @if ($event->ico_promotion_id != 10)
                                                    <img src="{{asset($event->getPromotion->icon)}}">
                                                @endif
                                                </span>
                                        </td>
                                        <td><span style="display: none">{{$event->date_start}}</span>{{date('M d, Y', strtotime($event->date_start))}}</td>
                                        <td>{{$event->city->name}}, {{$event->country->name}}
                                            <span class="view-more view-more-mob" data-toggle="collapse" data-target="#accordion_{{$event->id}}">view more<i class="fa fa-caret-down" aria-hidden="true"></i></span>
                                        </td>
                                        <td class="time-bar">
                                            <span class="view-more" data-toggle="collapse" data-target="#accordion_{{$event->id}}">view more<i class="fa fa-caret-down" aria-hidden="true"></i></span>
                                        </td>
                                    </tr>
                                    <tr id="accordion_{{$event->id}}" class="collapse">
                                        <td style="display:none;"></td>
                                        <td style="display:none;"></td>
                                        <td style="display:none;">{{$event->country->name}}</td>
                                        <td colspan="4" class="accordion-row"><span class="description-text">{{$event->short_description}}</span>
                                            <span class="bottom-decription">&nbsp;<span class="promocode">&nbsp;</span><a class="visit-website" href="{{$event->link}}" target="_blank">visit website <i class="fa fa-angle-right" aria-hidden="true"></i></a></span>
                                        </td>
                                    </tr>
                                @endforeach
                                <!-- <div id="pagination">
                                            <a href="/page2/" class="next">next</a>
                                        </div> -->
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

@section('jsscripts')
    <script src="/js/jquery.dataTables.js"></script>
    <script src="/js/dataTables.bootstrap.js"></script>
    <script>
        var searchLocation;
        $(document).ready(function() {
            $('.view-more').click(function () {
                $(this).parent().parent().after($($(this).data('target')));
            });
            $('.row-title').click(function () {
                $(this).parent().parent().after($($(this).data('target')));
            });
            $('th').click(function () {
                $('tr.collapse').removeClass('show');
            });
//            $('.row-title').click(function () {
//                $(this).parent().parent().after($($(this).data('target')));
//            });

            var table = $('.main-list').DataTable( {
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                } ],
                "order": [],
                "paging":   false,
                "info":     false,
            } );
            $('#search').on( 'keyup', function () {
                table.search( this.value ).draw();
            } );
            searchLocation = function(text) {
                if(text == "All")
                {
                    table
                        .search( '' )
                        .columns().search( '' )
                        .draw();
                } else {
                    table.search( searchText ).draw();
                }

            }
        } );
    </script>
    <script src="/js/events-page.js"></script>
@endsection