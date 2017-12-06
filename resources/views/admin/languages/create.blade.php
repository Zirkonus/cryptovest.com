@extends('admin/layouts/main')

<style>
    .my-label{
        margin-bottom: 15px;
    }
</style>
{{-- Page title --}}
@section('title')
Create New Language
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
        <li>languages</li>
        <li class="active">Create New Language</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="plus-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Create a new Language
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

                    {!! Form::open(['url' => 'admin/languages']) !!}

                         <div class="form-group">
                            {!! Form::label('name', 'Language Name: ', ['class' =>"control-label"]) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required'=>'required']) !!}
                         </div>
                         <div class="form-group">
                             {!! Form::label('country_code', 'Country Code: ', ['class' =>"control-label"]) !!}
                             {!! Form::text('country_code', null, ['class' => 'form-control', 'required'=>'required']) !!}
                         </div>
                         <div class="form-group">
                             {!! Form::label('language_code', 'Language Code: ', ['class' =>"control-label"]) !!}
                             {!! Form::text('language_code', null, ['class' => 'form-control', 'required'=>'required']) !!}
                         </div>
                         <div class="checkbox">
                             <label><input name="is_main" id="is_main" type="checkbox"> Is main</label>
                         </div>
                         <div class="checkbox">
                             <label><input name="is_english" id="is_english" type="checkbox"> Is English</label>
                         </div>
                         <div class="checkbox">
                             <label><input name="is_active" id="is_active" type="checkbox"> Is active</label>
                         </div>
                         <div class="form-group">
                             <div class="col-sm-offset-2 col-sm-4">
                                 <a class="btn btn-danger" href="{{ route('languages.index') }}">Cancel</a>
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