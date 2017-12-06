@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
languageKeys List
@parent
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Language Keys</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Languages</li>
        <li class="active">languages</li>
    </ol>
</section>

<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <div class="form-inline">
                    <h4 class="panel-title pull-left" style="padding-right: 20px;padding-top: 5px"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Language Keys
                    </h4>
                    <select class="form-control" id="lang-select" style="min-width: 150px">
                        @foreach($languages as $lang)
                            <option value="{{$lang->id}}">{{$lang->name}}</option>
                        @endforeach
                    </select>
                    <div class="pull-right">
                        <a href="{{ route('language-keys.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Add New</a>
                    </div>
                </div>
            </div>
            <br />
            <div class="panel-body">
                <table class="table table-bordered " id="table">
                    <thead>
                        <tr class="filters">
                            <th>ID</th>
							<th>Key</th>
							<th>Value</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    @foreach($languages as $lang)
                        <tbody id="lang_{{$lang->id}}">
                        @foreach ($langVal as $l)
                            @if($l->language_id == $lang->id)
                                <tr>
                                    <td>{{$l->id}}</td>
                                    <td>{{$l->key}}</td>
                                    <td>{{$l->value}}</td>
                                    <td></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    @endforeach
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
<script src="{{ asset('assets/admin/js/languages.js')}}" type="text/javascript" charset="utf-8" async defer></script>
@stop
