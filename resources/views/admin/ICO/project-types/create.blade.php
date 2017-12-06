@extends('admin/layouts/main')

<style>
    .my-label{
        margin-bottom: 15px;
    }
</style>
{{-- Page title --}}
@section('title')
Create New Project-type
@parent
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Project-type</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>project-types</li>
        <li class="active">Create New Project-type</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="plus-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Create a new Project-type
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

                    {!! Form::open(['url' => 'admin/ico/project-types/create']) !!}

                         <div class="form-group">
                             {!! Form::label("name", "Project type Name : ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                             <div class="col-sm-10 my-label">
                                 {!! Form::text("name", null , ["class" =>"form-control", "required"=>"required"]) !!}
                             </div>
                         </div>
                         <div class="col-sm-12">
                             <div class="checkbox">
                                 <label><input name="is_active" id="is_active" type="checkbox"> Is active</label>
                             </div>
                         </div>

                         <div class="form-group">
                             <div class="col-sm-offset-2 col-sm-4">
                                 <a class="btn btn-danger" href="{{ route('project-type.index') }}">Cancel</a>
                                 <button type="submit" class="btn btn-success">Save</button>
                             </div>
                         </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</section>

@stop