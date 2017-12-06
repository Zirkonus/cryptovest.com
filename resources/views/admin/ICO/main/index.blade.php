@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
    ICO List
    @parent
@stop
@section('styles-css')
    <style>
        #table_filter input {
            margin-left: 21px;
            width: 697px;
        }
        #table input {
            width: 90%;
        }
    </style>
@show

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Members</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#" > <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>projects</li>
            <li class="active">ICO</li>
        </ol>
    </section>

    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        ICO Projects List
                    </h4>
                    <div class="pull-right">
                        <a class="btn btn-sm btn-default" id="filters-but"> Filters</a>
                        <a href="{{ route('ico.project.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Create</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                    <table class="table table-bordered " id="table">
                        <thead>
                            <tr class="filters">
                                <th>ID</th>
                                <th>Image</th>
                                <th id="title-table">Title</th>
                                <th id="category-table">Category</th>
                                <th id="type-table">Type</th>
                                <th id="platform-table">Platform</th>
                                <th>Short Description</th>
                                <th>Money</th>
                                <th>Data Start</th>
                                <th>Data End</th>
                                <th>Data Create</th>
                                <th>Supply</th>
                                <th>Is Fraud</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($projects)
                        @foreach ($projects as $p)
                            <tr>
                                <td>{{$p->id}}</td>
                                    @if(file_exists( public_path(). "/" .$p->image))
                                        <td><img style="width: 75px; height: 75px;" src="{{ asset($p->image) }}" alt="icon"></td>
                                    @else
                                        <td><img data-not="" style="width: 75px; height: 75px;" src="{{ $p->image }}" alt="icon"></td>
                                    @endif

                                <td><a href="{{ route('ico.project.edit', $p->id) }}">{{$p->title}}</a></td>

                                <td>{{$p->getCategory->name or $p->ico_category_other}}</td>

                                <td>{{$p->getProjectType->name or ""}}</td>
                                <td>{{$p->getPlatform->name or $p->ico_platform_other}}</td>
                                <td style="width: 150px;">{{$p->short_description}}</td>
                                <td>
                                    @foreach($p->getMoney as $money)
                                        <img src="{{asset($money->image)}}" alt="icon">
                                    @endforeach
                                </td>
                                <td style="width: 115px;">{{date('Y-m-d H:i:s', strtotime($p->data_start))}}</td>
                                <td style="width: 115px;">{{date('Y-m-d H:i:s', strtotime($p->data_end))}}</td>
                                <td style="width: 115px;">{{date('Y/m/d H:i:s', strtotime($p->created_at))}}</td>
                                <td>{{$p->total_supply}}</td>
                                <td>
                                    @if ($p->is_fraud)
                                        <i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                    @else
                                        <i class="livicon" data-name="circle" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('ico.project.edit', $p->id) }}">
                                        <i style="color:#418BCA" class="fa fa-pencil-square-o" aria-hidden="true" title="edit ICO"></i>
                                    </a>
                                    <a href="{{ route('ico.project.confirm-delete', $p->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                        <i style="color:red; font-size: 18px;" class="fa fa-times-circle" aria-hidden="true" title="delete ICO"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @endif
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
                { "orderable": false, "targets": [0,1,2,3,4,5,6,7,11,12,13] }
            ]
        });

        var tab = $('#table').DataTable({
            pageLength: 20,
            lengthChange: false,
            autoWidth: true,
        });

        var category    = tab.columns(3).data().eq(0).unique();
        var types       = tab.columns(4).data().eq(0).unique();
        var platforms   = tab.columns(5).data().eq(0).unique();

        var selectTypes = "<select name='type-filter' id='type-filter'>"+
            "<option value=''>Choose..</option>";
        types.each(function (val) {
            selectTypes += "<option value='"+ val +"'>" + val + "</option>";
        });

        selectTypes         += "</select>";
        var selectPlatform  = "<select name='platform-filter' id='platform-filter'>"+
            "<option value=''>Choose..</option>";
        platforms.each(function (val) {
            selectPlatform  += "<option value='"+ val +"'>" + val + "</option>";
        });

        selectPlatform      += "</select>";
        var selectCategory  = "<select name='category-filter' id='category-filter'>"+
            "<option value=''>Choose..</option>";
        category.each(function (val) {
            selectCategory  += "<option value='"+ val +"'>" + val + "</option>";
        });
        selectCategory      += "</select>";

        $('#filters-but').on('click', function() {
            $('#type-table').html(selectTypes);
            $('#category-table').html(selectCategory);
            $('#platform-table').html(selectPlatform);
        });

        var dataTab;
        $('#table').on('change', '#type-filter', function () {
            if (dataTab) {
                dataTab = dataTab
                    .column(4)
                    .search( $('#type-filter option:selected').val())
                    .draw();
            } else {
                dataTab = tab
                    .column(4)
                    .search($('#type-filter option:selected').val())
                    .draw();
            }
        });
        $('#table').on('change', '#category-filter', function () {
            if (dataTab) {
                dataTab = dataTab
                    .column(3)
                    .search($('#category-filter option:selected').val())
                    .draw();
            } else {
                dataTab = tab
                    .column(3)
                    .search($('#category-filter option:selected').val())
                    .draw();
            }
        });
        $('#table').on('change', '#platform-filter', function () {
            if (dataTab) {
                dataTab = dataTab
                    .column(5)
                    .search($('#platform-filter option:selected').val())
                    .draw();
            } else {
                dataTab = tab
                    .column(5)
                    .search($('#platform-filter option:selected').val())
                    .draw();
            }
        });
    </script>
@stop
