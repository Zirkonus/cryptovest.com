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
        <h1>Tags</h1>
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
                            Create a new Tag
                        </h4>
                        <select class="form-control" id="lang-select" style="width: 150px; float: right">
                            @foreach($languages as $lang)
                                <option value="{{$lang->id}}">{{$lang->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif


                        {!! Form::open(['url' => 'admin/tags']) !!}
                        @foreach($languages as $lang)
                            <div class="lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                                <div class="form-group">
                                    {!! Form::label('name_'.$lang->id, 'Tag Name: ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                    <div class="col-sm-10 my-label">
                                        @if ($lang->is_english == 1)
                                            {!! Form::text('name_'.$lang->id, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                        @else
                                            {!! Form::text('name_'.$lang->id, null, ['class' => 'form-control']) !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('tags.index') }}">Cancel</a>
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