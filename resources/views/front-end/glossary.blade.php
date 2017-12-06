@extends('layouts.main')

@section('title', 'Glossary - Cryptovest')
@section('body-class', 'mainPage')
@section('meta-tags')
    <meta name="description" content="Cryptovest - Events.">
@endsection
@section('styles-css')
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/glossary.css')}}">
    <input type="hidden" id="token" data="{{csrf_token()}}">
@endsection
@section('content')
    <div class="container topBlock events-header glossary-header">
        <div class="row m--8">
            <div class="col-lg-7 p--8 description-block">
                <h2 class="titleBlock">Glossary</h2>
                <p class="description-text">From altcoins to mining, This guide will Introduce you to the most important terms in the cryptocurrency industry.</p>
            </div>
            <div class="col-lg-5 headerBlock p--8">
                <div class="row m--8 tabs-line">
                    <div class="search-block col-lg-12 col-md-12 col-sm-12">
                        <div class="search">
                            <div class="btn-group">
                                @if(isset($categories))
                                    <div data-toggle="dropdown"
                                         class="btn btn-default dropdown-toggle categories-dropdown"
                                         id="changed-category">Category<span class="caret"></span></div>
                                    <ul class="dropdown-menu categories">
                                        <li data-category=""><a>All</a></li>
                                        @foreach($categories as $key => $cat)
                                            <li data-category="{{ $key }}"><a>{{ $cat }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <input id="search" type="text" class="searching-inputs" style="display: none;">
                            <label for="search" id='show-search'>
                                <span><img src="/images/search.png"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container topBlock alphabet-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="alphabet">
                    <span class="letter">A</span>
                    <span class="letter">B</span>
                    <span class="letter">C</span>
                    <span class="letter">D</span>
                    <span class="letter">E</span>
                    <span class="letter">F</span>
                    <span class="letter">G</span>
                    <span class="letter">H</span>
                    <span class="letter">I</span>
                    <span class="letter">J</span>
                    <span class="letter">K</span>
                    <span class="letter">L</span>
                    <span class="letter">M</span>
                    <span class="letter">N</span>
                    <span class="letter">O</span>
                    <span class="letter">P</span>
                    <span class="letter">Q</span>
                    <span class="letter">R</span>
                    <span class="letter">S</span>
                    <span class="letter">T</span>
                    <span class="letter">U</span>
                    <span class="letter">V</span>
                    <span class="letter">W</span>
                    <span class="letter">X</span>
                    <span class="letter">Y</span>
                    <span class="letter">Z</span>
                </div>
                <div class="search-result-block" style="display: none;">
                    <div class="search-title">
                        Search Results for :
                        <span class="search-word"><span class="inputed-word"></span><span
                                    class="delete-link fa fa-times"></span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tabs" class="container newsParentBlock middleInfoBlock glossary-container" style="position: relative;">
        <div id = 'glossaryPre'><img class="preloader" src="{{asset('/images/svg/metaball-subscriptions.svg')}}" alt=""></div>

        <div class="col-12 bigBlocks p--8">
            <div class="row m--8">
                <div class="p--8 col-md-12 col-sm-12 col-lg-12 main-new">
                    <div class="upcomming-list">
                        <!-- first table -->
                        <table class="main-list">
                            <tbody id = 'glossaryTable'>
                            @if(isset($items))
                                
                                @foreach($items as $key => $item)
                                    <tr class="glossary-tr">
                                        <td>
                                            <span class="char-name">{{ $key }}</span>
                                        </td>
                                        <td>
                                            @foreach($item as $value)
                                                <div class="glossary-element">
                                                    <h2 class="glossary-title">
                                                        {{ $value->title }}
                                                        <div class="glossary-words">
                                                            <span class="glossary-word">{{ isset(head($value->glossaryCategory)[0]) ? head($value->glossaryCategory)[0]->name : "" }}</span>
                                                        </div>
                                                    </h2>
                                                    <span class="glossary-description">{!! $value->content !!}</span>
                                                </div>
                                            @endforeach

                                        </td>
                                    </tr>
                                @endforeach
                               @endif 
                            </tbody>
                        </table>                        
                    </div>
                    <!--</div> -->

                </div>
            </div>
            <!--  Only for Desctop (up) -->
        </div>
        @endsection

        @section('jsscripts')
            <script src="/js/jquery.dataTables.js"></script>
            <script src="/js/dataTables.bootstrap.js"></script>
           <!--  <script>
                // $(document).ready(function() {

                //     var table = $('.main-list').DataTable( {
                //         "columnDefs": [ {
                //             "targets": 'no-sort',
                //             "orderable": false,
                //         } ],
                //         "order": [],
                //         "paging":   false,
                //         "info":     false,
                //     } );
                    // $('#search').on( 'keyup', function () {
                    //     table.search( this.value ).draw();
                    // } );
                    // searchLocation = function(text) {
                    //     if(text == "All")
                    //     {
                    //         table
                    //             .search( '' )
                    //             .columns().search( '' )
                    //             .draw();
                    //     } else {
                    //         table.search( searchText ).draw();
                    //     }

                    // }
                } );
            </script> -->
            <script src="/js/glossary.js"></script>
@endsection