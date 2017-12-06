@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
    List of subscribers
    @parent
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>List of Subscribers</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Subscribers</li>
            <li class="active">List</li>
        </ol>
    </section>

    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <div class="form-inline">
                        <h4 class="panel-title pull-left" style="padding-right: 20px;padding-top: 5px"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Subscribers
                        </h4>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                    <table class="table table-bordered " id="table">
                        <thead>
                        <tr class="filters">
                            <th>Name</th>
                            <th>Email</th>
                            <th>IP</th>
                            <th>Date</th>
                            <th>Interests</th>
                            <th>News</th>
                            <th>Reviews</th>
                            <th>Education</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($subscribers as $s)
                            <tr>
                                <td>{{$s->name}}</td>
                                <td>{{$s->email}}</td>
                                <td>{{$s->ip}}</td>
                                <td>{{$s->created_at}}</td>
                                <td>{{$s->interests}}</td>
                                <?php $news = 0; $rev = 0; $ed = 0?>
                                @foreach($s->getCategories as $cat)
                                    @if($cat->friendly_url == 'news')
                                        <?php $news = 1 ?>
                                    @endif
                                    @if($cat->friendly_url == 'reviews')
                                        <?php $rev = 1 ?>
                                    @endif
                                    @if($cat->friendly_url == 'education')
                                        <?php $ed = 1 ?>
                                    @endif
                                @endforeach
                                <td>
                                    @if($news)
                                        <i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                    @else
                                        <i class="livicon" data-name="circle" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                    @endif
                                </td>
                                <td>
                                    @if($rev)
                                        <i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                    @else
                                        <i class="livicon" data-name="circle" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                    @endif
                                </td>
                                <td>
                                    @if($ed)
                                        <i class="livicon" data-name="check" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                    @else
                                        <i class="livicon" data-name="circle" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('subscribers.confirm-delete', $s->id) }}" data-toggle="modal" data-target="#delete_confirm">
                                        <i class="livicon" data-name="remove-alt" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete subscriber"></i>
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
