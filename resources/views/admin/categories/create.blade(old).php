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
    <h1>Categories</h1>
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
                        Create a new Category
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


                    {!! Form::open(['url' => 'admin/categories']) !!}
                         @foreach($languages as $lang)
                         <div class="lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                             <div class="form-group">
                                {!! Form::label('name_'.$lang->id, 'Category Name: ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                 <div class="col-sm-10 my-label">
                                    {!! Form::text('name_'.$lang->id, null, ['class' => 'form-control', 'required'=>'required']) !!}
                                 </div>
                             </div>
                         </div>
                         @endforeach
                         @if (count($categories) > 0)
                            <div class="col-sm-12">
                            <div class="form-group">
                                 {!! Form::select("parent_category", $categories, null, ["class"=>"form-control", "placeholder"=>"Please Choose Parent Category"]) !!}
                            </div>
                            </div>
                         @endif
                         @foreach($languages as $lang)
                             <div class="col-sm-12 lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                                 <div class="form-group">
                                     {!! Form::textarea("description_".$lang->id, null, ["class" => "form-control", "placeholder"=>"Description", "required"=>"required", "rows"=> 5]) !!}
                                 </div>
                             </div>
                         @endforeach
                         <div class="form-group">
                             {!! Form::label("friendly_url", "Friendly URL: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                             <div class="col-sm-8 my-label">
                                {!! Form::text("friendly_url", null, ["class" =>"form-control", "readonly"=>"readonly", "required"=>"required"]) !!}
                             </div>
                             <div class="col-sm-2">
                                <a class="btn btn-default" id="edit_url">Edit</a>
                             </div>
                         </div>
                         @foreach($languages as $lang)

                             <div class="col-sm-12 lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                                 <div class="form-group">
                                     {!! Form::text("meta-title_".$lang->id, null, ["class" => "form-control", "placeholder"=>"Meta title", "required"=>"required"]) !!}
                                 </div>
                                 <div class="form-group">
                                     {!! Form::textarea("meta-description_".$lang->id, null, ["class" => "form-control", "placeholder"=>"Meta description", "required"=>"required", "rows"=> 5]) !!}
                                 </div>
                             </div>
                         @endforeach
                         <div class="col-sm-12">
                             <div class="checkbox">
                                 <label><input name="is_menu" id="is_menu" type="checkbox"> Is menu</label>
                             </div>
                             <div class="checkbox">
                                 <label><input name="is_active" id="is_active" type="checkbox"> Is active</label>
                             </div>
                         </div>
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
        <script src="{{ asset('assets/admin/js/category.js')}}" type="text/javascript" charset="utf-8" async defer></script>
    @stop
</section>

@stop