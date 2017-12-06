@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
List of Glossary categories
@parent
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>List of Glossary Categories</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Glossary</li>
        <li class="active">Categories</li>
    </ol>
</section>

<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <h4 class="panel-title pull-left"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Categories List
                </h4>
                <div class="pull-right">
                    <a href="{{ route('glossary.category.create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Create</a>
                </div>
            </div>
            <br />
            <div class="panel-body">
                <table class="table table-bordered " id="table">
                    <thead>
                    <tr class="filters">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Items count</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($categories))
                        @foreach ($categories as $cat)
                            <tr>
                                <td>{{$cat->id}}</td>
                                <td>{{$cat->name}}</td>
                                <td>{{ $cat->glossaryItem->count() }}</td>
                                <td>
                                    <a href="{{ route('glossary.category.edit', $cat->id) }}">
                                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit category"></i>
                                    </a>
                                    <a class="delete_item" data-action="{{$cat->id}}" data-lname="{{$cat->name}}">
                                        <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete category"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
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
                    Are you sure that you want delete <span class="cat_name"></span>?
                </div>
                <div class="modal-footer">
                    <form action="" method="get">
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
            $('.delete_item').click(function () {
                var action = '/admin/glossary/categories/delete/' + $(this).data('action');
                $('#delete_confirm form').attr('action', action);
                $('#delete_confirm .cat_name').text($(this).data('lname'));
                $('#delete_confirm').modal();
            })
        });
    </script>
@stop

