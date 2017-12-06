@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
    ICO Comments List
    @parent
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>ICO Comments</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>comments</li>
            <li class="active">comments</li>
        </ol>
    </section>

    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        ICO Comments List
                    </h4>
                </div>
                <br />
                <div class="panel-body">
                    <table class="table table-bordered " id="table">
                        <thead>
                        <tr class="filters">
                            <th>ICO</th>
                            <th>Writer Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Submited At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($comments as $c)
                            <tr>
                                <td>{{$c->getICO->title}}</td>
                                <td>{{$c->writer_name}}</td>
                                <td>{{$c->writer_email}}</td>
                                <td>{{$c->content}}</td>
                                <td>{{$c->getStatus->name}}</td>
                                <td>{{$c->created_at}}</td>
                                @if($c->submited_at)
                                    <td style="background-color: green">
                                @else
                                    <td style="background-color: orange">
                                @endif
                                    {{$c->submited_at}}</td>
                                <td>
                                    <a href="{{ route('ico.comments.edit', $c->id) }}">
                                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit comment"></i>
                                    </a>
                                    <a href="{{ route('ico.comments.confirm-delete', $c->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                        <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete comment"></i>
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
