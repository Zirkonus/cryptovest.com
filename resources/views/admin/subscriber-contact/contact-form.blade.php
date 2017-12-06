@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
    List of posts from Contact-form
    @parent
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>List of posts from Contact-form</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Contact-form</li>
            <li class="active">List</li>
        </ol>
    </section>

    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <div class="form-inline">
                        <h4 class="panel-title pull-left" style="padding-right: 20px;padding-top: 5px"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Posts from Contact Form
                        </h4>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                    <table class="table table-bordered " id="table">
                        <thead>
                        <tr class="filters">
                            <th>User Data</th>
                            <th>Company</th>
                            <th>Phone</th>
                            <th>Post</th>
                            <th>Department</th>
                            <th>IP</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($contacts as $c)
                            <tr>
                                <td>
                                    {{$c->first_name}} {{$c->last_name}}
                                    <br>{{$c->email}}
                                </td>
                                <td>{{$c->company}}</td>
                                <td>{{$c->phone}}</td>
                                <td>{{ $c->post_content }}</td>
                                <td>{{ $c->department }}</td>
                                <td>{{ $c->ip }}</td>
                                <td>{{ $c->created_at }}</td>
                                <td>
                                    <a href="{{ route('contact-form.confirm-delete', $c->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                        <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete post from user"></i>
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
