@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
    List of coins
    @parent
@stop
@section('styles-css')
    <style>
        #table_filter input {
            margin-left: 21px;
            width: 697px;
        }
        .panel-body tr td {
            word-break: break-all;
        }

    </style>
@show

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>List of Coins</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Coins</li>
            <li class="active">List</li>
        </ol>
    </section>

    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <div class="form-inline">
                        <h4 class="panel-title pull-left" style="padding-right: 20px;padding-top: 5px"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Tags
                        </h4>
                        <select class="form-control" id="lang-select" style="min-width: 150px">
                            @foreach ($languages as $lang)
                                <option value="{{$lang->id}}">{{$lang->name}}</option>
                            @endforeach
                        </select>
                        {{--<div class="pull-right">--}}
                            {{--<a href="{{ route('coins.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Add New</a>--}}
                        {{--</div>--}}
                    </div>

                </div>
                <br />
                <div class="panel-body">
                    <table class="table table-bordered " id="table">
                        <thead>
                        <tr class="filters">
                            <th class="no-sort">Name</th>
                            <th class="no-sort no-search">Image</th>
                            <th class="no-sort no-search">Symbol</th>
                            <th class="no-search">Rank</th>
                            <th class="no-sort no-search">Circulation supply</th>
                            <th class="no-sort no-search">Total supply</th>
                            <th class="no-sort no-search">Price USD</th>
                            <th class="no-sort no-search">Price BTC</th>
                            <th class="no-sort no-search">Volume BTC</th>
                            <th class="no-sort no-search">Change 24 %</th>
                            <th class="no-sort no-search">Marketcap USD</th>
                            <th class="no-sort no-search">Website</th>
                            <th class="no-sort no-search">Description coin</th>
                            <th class="no-sort no-search">Link Buy coin</th>
                            <th class="no-sort no-search">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($coinsList as $coin)
                            <tr>
                                <td>{{$coin->name}}</td>
                                <td><img style='width: 75px; height: 75px;' src="{{ asset(\App\CoinValue::getValueImage($coin->symbol)) }}" alt="no img"></td>
                                <td>{{$coin->symbol}}</td>
                                <td>{{$coin->rank}}</td>
                                <td>{{$coin->circulating_supply}}</td>
                                <td>{{$coin->total_supply}}</td>
                                <td>{{$coin->price_usd}}</td>
                                <td>{{$coin->price_btc}}</td>
                                <td>{{$coin->volume_btc}}</td>
                                <td>{{$coin->change_24}}</td>
                                <td>{{$coin->marketcap_usd}}</td>
                                <td>{{$coin->website}}</td>
                                <td style="width: 15%">{!! str_limit(Translate::getValue($coin->description_lang_key), 90)!!}</td>
                                <td>{{\App\CoinValue::getLinkBuyCoin($coin->symbol)}}</td>
                                <td style="text-align: center">
                                    <a href="{{ route('coins.edit', $coin->slug) }}">
                                        <i style="color:#418BCA" class="fa fa-pencil-square-o" aria-hidden="true" title="edit coin"></i>
                                    </a>
                                    {{--@if(Auth::user()->is_admin)--}}
                                        {{--<a href="{{ route('coins.confirm-delete', $coin->slug) }}" data-toggle="modal" data-target="#delete_confirm">--}}
                                            {{--<i style="color:red; font-size: 18px;" class="fa fa-times-circle" aria-hidden="true" title="delete coin"></i>--}}
                                        {{--</a>--}}
                                    {{--@endif--}}
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>    <!-- row-->
    </section>
@stop

{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <script>$(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});</script>
    <script src="{{asset('js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap.js')}}"></script>
    <script>
        $.extend( true, $.fn.dataTable.defaults, {
            "searching": true,
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": 'no-sort'
                },
                {
                    "targets": 'no-search', "searchable": false
                }
            ],
            'order' : []
        });
        var table = $('#table').DataTable({
            pageLength: 20,
            lengthChange: false,
            autoWidth: true,
        });

    </script>
@stop
