@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
List of users
@parent
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>List of Users</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Users</li>
        <li class="active">List</li>
    </ol>
</section>

<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <div class="form-inline">
                    <h4 class="panel-title pull-left" style="padding-right: 20px;padding-top: 5px"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Users
                    </h4>
                    <select class="form-control" id="lang-select" style="min-width: 150px">
                        @foreach($languages as $lang)
                            <option value="{{$lang->id}}">{{$lang->name}}</option>
                        @endforeach
                    </select>
                    <div class="pull-right">
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Add New</a>
                    </div>
                </div>

            </div>
            <br />
            <div class="panel-body">
                <table class="table table-bordered " id="table">
                    <thead>
                        <tr class="filters">
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Photo</th>
                            <th>Email</th>
                            <th>Twitter Link</th>
                            <th>LinkedIn</th>
                            <th>Twitter Profile Name</th>
							<th>Is Active</th>
							<th>Is Admin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $u)
                        <tr>
                            <td><a href="{{ route('users.edit', $u->id) }}">{{  Translate::getValue($u->first_name_lang_key) }}</a></td>
							<td>{{  Translate::getValue($u->last_name_lang_key) }}</td>
							<td><img src="{{  asset($u->profile_image) }}" alt="profile image" style="height:75px;weidth=75px"></td>
							<td>{{  $u->email }}</td>
							<td>{{  $u->twitter_link }}</td>
							<td>{{  $u->facebook_link }}</td>
							<td>{{  $u->twitter_profile_username }}</td>
							<td>
                                @if ($u->is_active)
                                    <i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                @else
                                    <i class="livicon" data-name="circle" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                @endif
                            </td>
                            <td>
                                @if ($u->is_admin == 1 or $u->is_admin == 2)
                                    <i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                @else
                                    <i class="livicon" data-name="circle" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.edit', $u->id) }}">
                                    <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit user"></i>
                                </a>
                                @if($u->id != Auth::user()->id)
                                    <a href="{{ route('users.confirm-delete', $u->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                        <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete user"></i>
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
