@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
    List of executives
    @parent
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>List of Executives</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Executives</li>
            <li class="active">List</li>
        </ol>
    </section>

    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <div class="form-inline">
                        <h4 class="panel-title pull-left" style="padding-right: 20px;padding-top: 5px"><i
                                    class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff"
                                    data-hc="white"></i>
                            Executives
                        </h4>
                        <select class="form-control" id="lang-select" style="min-width: 150px">
                            @foreach($languages as $lang)
                                <option value="{{$lang->id}}">{{$lang->name}}</option>
                            @endforeach
                        </select>
                        <div class="pull-right">
                            <a href="{{ route('executives.create') }}" class="btn btn-sm btn-default"><span
                                        class="glyphicon glyphicon-plus"></span> Add New</a>
                        </div>
                    </div>

                </div>
                <br/>
                <div class="panel-body">
                    <table class="table table-bordered " id="table">
                        <thead>
                        <tr class="filters">
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Roles</th>
                            <th>Country</th>
                            <th>ICOs</th>
                            <th>Photo</th>
                            <th>Email</th>
                            <th>Is Active</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($executives as $e)
                            <tr>
                                <td>
                                    <a href="{{ route('executives.edit', $e->id) }}">{{  Translate::getValue($e->first_name_lang_key) }}</a>
                                </td>
                                <td>{{  Translate::getValue($e->last_name_lang_key) }}</td>
                                <td>
                                    @if(isset($e->roles))
                                        @foreach($e->roles as $key => $role)
                                            @if(++$key != $e->roles->count())
                                                <span>{{ $role->name }}, </span>
                                            @else
                                                <span>{{ $role->name }}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $e->country ? $e->country->name : "" }}</td>
                                <td>
                                    @if(isset($e->ICOProjects))
                                        @foreach($e->ICOProjects as $key => $ico)
                                            @if(++$key != $e->ICOProjects->count())
                                                <span>{{ $ico->title }}, </span>
                                            @else
                                                <span>{{ $ico->title }}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td><img src="{{  asset($e->profile_image) }}" alt="profile image"
                                         style="height:75px;weidth=75px"></td>
                                <td>{{  $e->email }}</td>
                                <td>
                                    @if ($e->is_active)
                                        <i class="livicon" data-name="check" data-size="18" data-loop="true"
                                           data-c="#428BCA" data-hc="#428BCA"></i>
                                    @else
                                        <i class="livicon" data-name="circle" data-size="18" data-loop="true"
                                           data-c="#428BCA" data-hc="#428BCA"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('executives.edit', $e->id) }}">
                                        <i class="livicon" data-name="edit" data-size="18" data-loop="true"
                                           data-c="#428BCA" data-hc="#428BCA" title="edit executive"></i>
                                    </a>
                                    <a href="{{ route('executives.confirm-delete', $e->id) }}" data-toggle="modal"
                                       data-target="#delete_confirm">
                                        <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true"
                                           data-c="#f56954" data-hc="#f56954" title="delete executive"></i>
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
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <script>$(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });</script>
@stop
