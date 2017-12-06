@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
Edit a language
@parent
@stop


@section('content')
<section class="content-header">
    <h1>Language</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>clubs</li>
        <li class="active">Create New language</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="edit" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Edit language
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

                    {!! Form::model($lang, ['method' => 'PATCH', 'action' => ['LanguagesController@update', $lang->id] ]) !!}

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
                             <label>
                                 {!! Form::checkbox('is_main', 'true', $lang->is_main) !!}
                                  Is Main
                             </label>
                         </div>
                         <div class="checkbox">
                             <label>
                                 {!! Form::checkbox('is_english', 'true', $lang->is_english) !!}
                                  Is English
                             </label>
                         </div>
                         <div class="checkbox">
                             <label>
                                 {!! Form::checkbox('is_active', 'true', $lang->is_active) !!}
                                  Is Active
                             </label>
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

    @stop
</section>
@stop