@extends('admin/layouts/main')
<style>
    .my-label{
        margin-bottom: 15px;
    }
</style>
{{-- Page title --}}
@section('title')
Edit a Comments
@parent
@stop


@section('content')
<section class="content-header">
    <h1>Comments</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Comments</li>
        <li class="active">Add New</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading" style="height: 54px">
                    <h4 class="panel-title" style="display: inline-block; padding-top: 5px"> <i class="livicon" data-name="edit" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Edit Comment
                    </h4>
                </div>
                <div class="panel-body">
                     @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    {!! Form::model($comment, ['method' => 'PATCH', 'action' => ['CommentsController@update', $comment->id] ]) !!}

                         <div class="col-sm-12">
                             <div class="form-group">
                                 {!! Form::select("post", $p, $comment->post_id, [
                                         "class"        => "form-control",
                                         "placeholder"  => "Please pick a Post",
                                         "required"     => "required",
                                         "id"           => "post"
                                  ]) !!}
                             </div>
                         </div>
                         <div class="form-group">
                             {!! Form::label('writer-name', 'Writer Name : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                             <div class="col-sm-10 my-label">
                                 {!! Form::text('writer-name', $comment->writer_name, ['class' => 'form-control', 'required' => 'required']) !!}
                             </div>
                             {!! Form::label('writer-email', 'Writer Email : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                             <div class="col-sm-10 my-label">
                                 {!! Form::email('writer-email', $comment->writer_email, ['class' => 'form-control', 'required' => 'required']) !!}
                             </div>
                         </div>
                         <div class="col-sm-12" style="padding-bottom: 15px">
                             {!! Form::textarea('content', $comment->content, ["class" => "form-control", "placeholder" => "Content", "rows" => 3, 'required' => 'required']) !!}
                         </div>
                         <div class="col-sm-12">
                             <div class="form-group">
                                 {!! Form::select("status", $statuses, $comment->status_id, [
                                        "class"        => "form-control",
                                        "placeholder"  => "Please pick a Status",
                                        "required"     => "required",
                                        "id"           => "status"
                                 ]) !!}
                             </div>
                         </div>
                        <div class="form-group">
                        {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
    @section('footer_scripts')
        <script src="{{ asset('assets/admin/js/category.js')}}" type="text/javascript" charset="utf-8" async defer></script>
    @stop
</section>
@stop