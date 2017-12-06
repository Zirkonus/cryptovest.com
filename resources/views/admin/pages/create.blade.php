@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
Add New
@parent
@stop

@section('styles-css')
    <style>
        .my-label{
            margin-bottom: 15px;
        }
    </style>
@endsection
{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Pages</h1>
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
                        Create a new Page
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

                    {!! Form::open(['url' => 'admin/pages']) !!}
                         @foreach($languages as $lang)
                             <div class="lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                                 <div class="form-group">
                                    {!! Form::label('title_'.$lang->id, 'Page Title: ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                     <div class="col-sm-10 my-label">
                                        @if ($lang->is_english == 1)
                                            {!! Form::text('title_'.$lang->id, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                        @else
                                            {!! Form::text('title_'.$lang->id, null, ['class' => 'form-control']) !!}
                                        @endif
                                     </div>
                                 </div>
                                 <div class="col-sm-12">
                                     <div class="form-group">
                                         {!! Form::textarea('description_'.$lang->id, null, ['class' => 'form-control', "placeholder" => "Description", "rows" => "3"]) !!}
                                     </div>
                                     <div class="form-group">
                                         <label>Content:</label>
                                         {!! Form::textarea('content_'.$lang->id, null, ['class' => 'form-control', 'rows' => '5', "placeholder" => "Main content"]) !!}
                                     </div>
                                 </div>
                                 {!! Form::label('main-block-title_'.$lang->id, 'Main Title For Page  : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                 <div class="col-sm-10 my-label">
                                     {!! Form::text('main-block-title_'.$lang->id, null, ['class' => 'form-control']) !!}
                                 </div>

                                 {!! Form::label('first-block-title_'.$lang->id, 'Title ForFirst block  : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                 <div class="col-sm-10 my-label">
                                     {!! Form::text('first-block-title_'.$lang->id, null, ['class' => 'form-control']) !!}
                                 </div>

                                 <div class="form-group">
                                     {!! Form::textarea('first-block-content_'.$lang->id, null, ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Content for first block']) !!}
                                 </div>

                                 {!! Form::label('second-block-title_'.$lang->id, 'Title For Second block  : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                 <div class="col-sm-10 my-label">
                                     {!! Form::text('second-block-title_'.$lang->id, null, ['class' => 'form-control']) !!}
                                 </div>

                                 <div class="form-group">
                                     {!! Form::textarea('second-block-content_'.$lang->id, null, ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Content for second block']) !!}
                                 </div>

                                 <div class="form-group">
                                     {!! Form::textarea('reserve-block-content_'.$lang->id, null, ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Content for reserve block']) !!}
                                 </div>
                             </div>
                         @endforeach

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('categories.index') }}">Cancel</a>
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
        <script src="{{ asset('assets/admin/tinymce/js/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/admin/js/category.js')}}" type="text/javascript" charset="utf-8" async defer></script>
    @stop
</section>

@stop