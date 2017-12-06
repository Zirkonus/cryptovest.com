@extends('admin/layouts/main')

<style>
    .my-label{
        margin-bottom: 15px;
    }
</style>
{{-- Page title --}}
@section('title')
    Create New Redirect
    @parent
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Languages</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>labels</li>
            <li class="active">Create New redirects</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title"> <i class="livicon" data-name="plus-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Create a new Redirect
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

                        {!! Form::open(['url' => 'admin/redirects']) !!}

                        <div class="form-group">
                            {!! Form::label('old_link', 'Old link: ', ['class' =>"control-redirect"]) !!}
                            {!! Form::text('old_link', null, ['class' => 'form-control', 'required'=>'required']) !!}
                        </div>
                            <div class="form-group">
                                {!! Form::label('new_link', 'New link: ', ['class' =>"control-redirect"]) !!}
                                {!! Form::text('new_link', null, ['class' => 'form-control', 'required'=>'required']) !!}
                            </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('redirects.index') }}">Cancel</a>
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