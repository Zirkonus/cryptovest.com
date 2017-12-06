@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
List of posts
@parent
@stop
@section('styles-css')
<style>
  #table_filter input {
        margin-left: 21px;
        width: 697px;
    }
    #table select {
        width: 100%;
    }

</style>
@show

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>List of Posts</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Posts</li>
        <li class="active">List</li>
    </ol>
</section>

<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <div class="form-inline">
                    <h4 class="panel-title pull-left" style="padding-right: 20px;padding-top: 5px"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Posts
                    </h4>
                    <select class="form-control" id="lang-select" style="min-width: 150px">
                        @foreach($languages as $lang)
                            <option value="{{$lang->id}}">{{$lang->name}}</option>
                        @endforeach
                    </select>
                    <div class="pull-right">
                        <a class="btn btn-sm btn-default" href="/admin/get-table-with-keywords" id="filters-but">
                            <span class="glyphicon glyphicon-download"></span> Get Keywords (CSV)
                        </a>
                        <a class="btn btn-sm btn-default" id="filters-but"> Filters</a>
                        <a href="{{ route('posts.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Add New</a>
                    </div>
                </div>
            </div>
            <br/>
            <div class="panel-body">
                <table class="table table-bordered " id="table">
                    <thead>
                        <tr class="filters">
                            <th id="title-table">Title</th>
                            <th class="no-sort">Image</th>
							<th id="category-table">Category</th>
							<th id="author-table">Author</th>
							<th id="status-table" class="no-sort">Status</th>
                            <th>Data Create</th>
							<th class="no-sort">Is Feat-d</th>
							<th class="no-sort">Tags</th>
							<th class="no-sort">Executives</th>
                            <th class="no-sort">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($posts as $p)
                            <tr>
                                <td>
                                    <a href="{{ route('posts.edit', $p->id) }}">{{ Translate::getValue($p->title_lang_key) }}</a>
                                   <br>@if($p->getCategory->full_url)/{{$p->getCategory->full_url}}@endif/{{$p->getCategory->friendly_url}}/{{$p->friendly_url}}
                                </td>
                                <td><img style='width: 256px; height: 155px;' src="{{ asset($p->short_image) }}" alt="no img"></td>

                                <td style="text-align: center">{{ Translate::getValue($p->getCategory->name_lang_key) }}</td>
                                @if($p->getUser)
                                    <td style="text-align: center">{{ Translate::getValue($p->getUser->first_name_lang_key) }}</td>
                                @else
                                    <td>error</td>
                                @endif
                                @if($p->getStatus)
                                    <td style="text-align: center">{{ $p->getStatus->name }}</td>
                                @else
                                    <td>error</td>
                                @endif
                                <td style="text-align: center">{{date('Y/m/d H:i:s', strtotime($p->created_at))}}</td>
                                <td style="text-align: center">
                                    @if ($p->is_keep_featured)
                                        <i style="color:#418BCA" class="fa fa-check-circle-o" aria-hidden="true"></i>
                                    @else
                                        <i style="color:#418BCA" class="fa fa-circle-o" aria-hidden="true"></i>
                                    @endif
                                </td>
                                <td>
                                    @foreach($p->tags as $tag)
                                        {{ $tag->name . " " }}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($p->executives as $executive)
                                        {{ Translate::getValue($executive->first_name_lang_key) }}
                                    @endforeach
                                </td>
                                <td style="text-align: center">
                                    <a href="{{ route('posts.edit', $p->id) }}">
                                        <i style="color:#418BCA" class="fa fa-pencil-square-o" aria-hidden="true" title="edit post"></i>
                                    </a>
                                    @if(Auth::user()->is_admin)
                                    <a href="{{ route('posts.confirm-delete', $p->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                        <i style="color:red; font-size: 18px;" class="fa fa-times-circle" aria-hidden="true" title="delete post"></i>
                                    </a>
                                    @endif
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
            }
        ],
        'order' : []
    });
    var tab = $('#table').DataTable({
            pageLength: 20,
            lengthChange: false,
            autoWidth: true,
    });
    var statuses = tab.columns(4).data().eq(0).unique();
    var author = tab.columns(3).data().eq(0).unique();
    var category = tab.columns(2).data().eq(0).unique();

    var selectStatus = "<select name='status-filter' id='status-filter'>"+
        "<option value=''>Choose..</option>";
    statuses.each(function (val) {
        selectStatus += "<option value='"+ val +"'>" + val + "</option>";
    });
    selectStatus += "</select>";

    var selectAuthor = "<select name='author-filter' id='author-filter'>"+
        "<option value=''>Choose..</option>";

    author.each(function (val) {
        selectAuthor += "<option value='"+ val +"'>" + val + "</option>";
    });
    selectAuthor += "</select>";

    var selectCategory = "<select name='category-filter' id='category-filter'>"+
        "<option value=''>Choose..</option>";
    category.each(function (val) {
        selectCategory += "<option value='"+ val +"'>" + val + "</option>";
    });
    selectCategory += "</select>";

    $('#filters-but').on('click', function() {
        $('#status-table').html(selectStatus);
        $('#category-table').html(selectCategory);
        $('#author-table').html(selectAuthor);
    });
    var dataTab;
    $('#table').on('change', '#status-filter', function () {
        if (dataTab) {
            dataTab = dataTab
                .column(4)
                .search( $('#status-filter option:selected').val())
                .draw();
        } else {
            dataTab = tab
                .column(4)
                .search($('#status-filter option:selected').val())
                .draw();
        }

    });

    $('#table').on('change', '#category-filter', function () {

        if (dataTab) {
            dataTab = dataTab
                .column(2)
                .search($('#category-filter option:selected').val())
                .draw();
        } else {
            dataTab = tab
                .column(2)
                .search($('#category-filter option:selected').val())
                .draw();
        }
    });
    $('#table').on('change', '#author-filter', function () {
        if (dataTab) {
            dataTab = dataTab
                .column(3)
                .search($('#author-filter option:selected').val())
                .draw();
        } else {
            dataTab = tab
                .column(3)
                .search($('#author-filter option:selected').val())
                .draw();
        }
    });
</script>
@stop
