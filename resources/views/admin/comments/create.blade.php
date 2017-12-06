@extends('admin/layouts/main')

<style>
    .my-label{
        margin-bottom: 15px;
    }
</style>
{{-- Page title --}}
@section('title')
Add New
@parent
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Comments</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>List</li>
        <li class="active">Add New</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading" style="height: 54px">
                    <h4 class="panel-title" style="display: inline-block; padding-top: 5px">
                        <i class="livicon" data-name="plus-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Create a new Comment
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
                    {!! Form::open(['url' => 'admin/comments']) !!}
                    <div class="col-sm-12">
                        <div class="form-group">
                            {!! Form::select("post", $p, '', [
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
                                {!! Form::text('writer-name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        {!! Form::label('writer-email', 'Writer Email : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                        <div class="col-sm-10 my-label">
                            {!! Form::email('writer-email', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                    </div>
                    <div class="col-sm-12" style="padding-bottom: 15px">
                        {!! Form::textarea('content', null, ["class" => "form-control", "placeholder" => "Content", "rows" => 3, 'required' => 'required']) !!}
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            {!! Form::select("status", $statuses, '', [
                                   "class"        => "form-control",
                                   "placeholder"  => "Please pick a Status",
                                   "required"     => "required",
                                   "id"           => "status"
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-4">
                            <a class="btn btn-danger" href="{{ route('comments.index') }}">Cancel</a>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
    <!-- row-->
    @section('footer_scripts')
        <script src="{{ asset('assets/admin/js/category.js')}}" type="text/javascript" charset="utf-8" async defer></script>
    @stop
</section>

@stop