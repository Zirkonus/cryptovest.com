@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
The banner
@parent
@stop

{{-- Page content --}}
@section('content')

<section class="content-header">
    <h1>Banner</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Banner</li>
        <li class="active">Main</li>
    </ol>
</section>

<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <div class="form-inline">
                    <h4 class="panel-title pull-left" style="padding-right: 20px;padding-top: 5px"> Banner</h4>
                </div>
            </div>
            <br />

            <div class="panel-body">
                {!! Form::model($banner, ['method' => 'POST', 'action' => ['BannersController@update', $banner->id], 'files' => true ]) !!}
                <div>
                    <div class="col-sm-6">
                        <img src="{{asset($banner->image)}}" alt="Cinque Terre" width="304" height="236">
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::file('image', ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::text('title', Translate::getValue($banner->title_lang_key), ['class' => 'form-control', 'required'=>'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::text('url', $banner->url, ['class' => 'form-control', 'required'=>'required']) !!}
                        </div>
                        <div class="form-group">
                            <div class="form-inline">
                                <a class="btn btn-danger" href="#">Cancel</a>
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="col-md-12">
                    <table class="table table-bordered " id="table">
                        <thead>
                            <tr class="filters">
                                <th>Views</th>
                                <th>Clicks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$banner->views_count}}</td>
                                <td>{{$banner->clicks_count}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
