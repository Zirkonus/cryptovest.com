@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
Promotion List
@parent
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Promotion</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>promotion</li>
        <li class="active">promotion</li>
    </ol>
</section>

<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <h4 class="panel-title pull-left"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Promotion List
                </h4>
                <div class="pull-right">
                    <a href="{{ route('promotion.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Create</a>
                </div>
            </div>
            <br />
            <div class="panel-body">
                <table class="table table-bordered " id="table">
                    <thead>
                        <tr class="filters">
                            <th>ID</th>
							<th>Name</th>
                            <th>Icon</th>
							<th>Is Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($promotion as $p)
                        <tr>
							<td>{{$p->id}}</td>
							<td>{{$p->name}}</td>
							<td><img style = "width: 75px; height: 75px;" src="{{asset($p->icon)}}" alt="platform icon"></td>
                            <td>
                                @if ($p->is_active)
                                    <i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                @else
                                    <i class="livicon" data-name="circle" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('promotion.edit', $p->id) }}">
                                    <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit promotion"></i>
                                </a>
                                <a href="{{ route('promotion.confirm-delete', $p->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                    <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete promotion"></i>
                                </a>
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
