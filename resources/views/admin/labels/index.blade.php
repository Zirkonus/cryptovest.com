@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
    List of labels
    @parent
@stop

{{-- Page content --}}
@section('content')
    <!--suppress ALL -->
    <section class="content-header">
        <h1>List of labels</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Labels</li>
            <li class="active">List</li>
        </ol>
    </section>

    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <div class="form-inline">
                        <h4 class="panel-title pull-left" style="padding-right: 20px;padding-top: 5px"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Labels
                        </h4>

                        <div class="pull-right">
                            <a href="{{ route('labels.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Add New</a>
                        </div>
                    </div>

                </div>
                <br />
                <div class="panel-body">
                    <table class="table table-bordered " id="table">
                        <thead>
                        <tr class="filters">
                            <th width="50">#</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($labels as $label)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$label->name}}</td>
                                <td>
                                    <a href="{{ route('labels.edit', $label->id) }}">
                                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit label"></i>
                                    </a>
                                    <a class="delete_label" data-action="{{$label->id}}" data-lname="{{$label->name}}">
                                        <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete label"></i>
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
        Are you sure that you want delete <span class="label_name"></span>?
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
            $('.delete_label').click(function () {
                var action = '/admin/labels/' + $(this).data('action');
                $('#delete_confirm form').attr('action', action);
                $('#delete_confirm .label_name').text($(this).data('lname'));
                $('#delete_confirm').modal();
            })
        });
    </script>
@endsection
