@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
List of categories
@parent
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>List of Category</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Categories</li>
        <li class="active">List</li>
    </ol>
</section>

<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <div class="form-inline">
                    <h4 class="panel-title pull-left" style="padding-right: 20px;padding-top: 5px"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Categories
                    </h4>
                    <select class="form-control" id="lang-select" style="min-width: 150px">
                        @foreach($languages as $lang)
                            <option value="{{$lang->id}}">{{$lang->name}}</option>
                        @endforeach
                    </select>
                    <div class="pull-right">
                        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Add New</a>
                    </div>
                </div>

            </div>
            <br />
            <div class="panel-body">
                <table class="table table-bordered " id="table">
                    <thead>
                        <tr class="filters">
                            <th>Name</th>
							<th>Posts</th>
							<th>Is Menu</th>
							<th>Is Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($categories as $c)
                        <tr>
                            <td><a href="{{ route('categories.edit', $c->id) }}">{{Translate::getValue($c->name_lang_key)}}</a></td>
							<td></td>
							<td>
                                @if ($c->is_menu)
                                    <i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                @else
                                    <i class="livicon" data-name="circle" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                @endif
                            </td>
                            <td>
                                @if ($c->is_active)
                                    <i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                @else
                                    <i class="livicon" data-name="circle" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                @endif
                            </td>


                            <td>
                                <a href="{{ route('categories.edit', $c->id) }}">
                                    <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit category"></i>
                                </a>
                                @if(Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2)
                                <a href="{{ route('categories.confirm-delete', $c->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                    <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete category"></i>
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
@stop
