@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
    List of events
    @parent
@stop

{{-- Page content --}}
@section('content')
    <!--suppress ALL -->
    <section class="content-header">
        <h1>List of events</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Events</li>
            <li class="active">List</li>
        </ol>
    </section>

    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <div class="form-inline">
                        <h4 class="panel-title pull-left" style="padding-right: 20px;padding-top: 5px"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Events
                        </h4>

                        <div class="pull-right">
                            <a href="{{ route('events.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Add New</a>
                        </div>
                    </div>

                </div>
                <br />
                <div class="panel-body">
                    <table class="table table-bordered " id="table">
                        <thead>
                        <tr class="filters">
                            <th width="50">#</th>
                            <th width="50">Flag</th>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><img src="/images/flags/{{strtolower($event->country->code)}}.svg" width="30"></td>
                                <td><a href="{{ route('events.edit', $event->id) }}">{{$event->name}}</a></td>
                                <td>{{date("Y-m-d", strtotime($event->date_start))}}</td>
                                <td>{{$event->city->name}}, {{$event->country->name}}</td>
                                <td>
                                    <a href="{{ route('events.edit', $event->id) }}">
                                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit event"></i>
                                    </a>
                                    <a class="delete_event" data-action="{{$event->id}}" data-lname="{{$event->name}}">
                                        <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete event"></i>
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
    <div class="modal fade" id="delete_confirm" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="user_delete_confirm_title">Question</h4>
                </div>
                <div class="modal-body">
                    Are you sure that you want delete <span class="event_name"></span>?
                </div>
                <div class="modal-footer">
                    <form action="" method="post">
                        {{csrf_field()}}
                        {{method_field('delete')}}
                        <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.delete_event').click(function () {
                var action = '/admin/events/' + $(this).data('action');
                $('#delete_confirm form').attr('action', action);
                $('#delete_confirm .event_name').text($(this).data('lname'));
                $('#delete_confirm').modal();
            })
        });
    </script>
@endsection