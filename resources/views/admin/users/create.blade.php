@extends('admin/layouts/main')

<style>
    .my-label{
        margin-bottom: 15px;
    }
</style>
<link href="{{ asset('assets/vendors/fileinput/css/fileinput.min.css') }}" rel="stylesheet">
{{-- Page title --}}
@section('title')
Add New
@parent
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Users</h1>
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
                        Create a new Author
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
                    {!! Form::open(['url' => 'admin/users', 'files' => true]) !!}
                         @foreach($languages as $lang)
                         <div class="lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                             <div class="form-group">
                                {!! Form::label('name_'.$lang->id, 'Name : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                 <div class="col-sm-10 my-label">
                                    @if ($lang->is_english == 1)
                                        {!! Form::text('name_'.$lang->id, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    @else
                                        {!! Form::text('name_'.$lang->id, null, ['class' => 'form-control']) !!}
                                    @endif
                                 </div>
                                 {!! Form::label('last-name_'.$lang->id, 'Last Name : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                 <div class="col-sm-10 my-label">
                                     @if ($lang->is_english == 1)
                                         {!! Form::text('last-name_'.$lang->id, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                     @else
                                         {!! Form::text('last-name_'.$lang->id, null, ['class' => 'form-control']) !!}
                                     @endif
                                 </div>

                             </div>
                         </div>
                         @endforeach
                                <label for="user-image" class="control-label col-sm-2">Image:</label>
                                <div class="form-group col-sm-10" id="user-image">
                                    {!! Form::file('image' , ['class' => 'file', "required" => "required"]) !!}
                                </div>
                                {!! Form::label('email_', 'Email : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-10 my-label">
                                    {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                                {!! Form::label('password', 'Password : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-10 my-label">
                                    {!! Form::text('password', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                         @foreach($languages as $lang)
                             <div class="lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                                 <label for="user-biography" class="control-label col-sm-2">Biography:</label>
                                 <div class="form-group col-sm-10" id="user-biography">
                                     {!! Form::textarea("biography_".$lang->id, null, ["class" => "form-control", "placeholder"=>"Biography", "rows"=> 5]) !!}
                                 </div>
                             </div>
                         @endforeach
                         {!! Form::label('twitter-link', 'Twitter Link : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                         <div class="col-sm-10 my-label">
                                 {!! Form::text('twitter-link', null, ['class' => 'form-control']) !!}
                         </div>
                         {!! Form::label('facebook-link', 'LinkedIn Link : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                         <div class="col-sm-10 my-label">
                             {!! Form::text('facebook-link', null, ['class' => 'form-control']) !!}
                         </div>
                         {!! Form::label('twitter-profile-user-name', 'Twitter Profile User Name : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                         <div class="col-sm-10 my-label">
                             {!! Form::text('twitter-profile-user-name', null, ['class' => 'form-control']) !!}
                         </div>

                         <div class="row">
                             <label for="user-role" class="control-label col-sm-2">Role:</label>
                             <div id="user-role" class="col-sm-10">
                                 <label class="checkbox-inline"><input name="is_author" id="is_author" type="checkbox">Author</label>
                                 <label class="checkbox-inline"><input name="is_admin" id="is_admin" type="checkbox">Admin</label>
                                 <label class="checkbox-inline"><input name="is_editor" id="is_editor" type="checkbox">Editor</label>
                                 <label class="checkbox-inline"><input name="is_executive_editor" id="is_executive_editor" type="checkbox">Executive Editor</label>
                                 <label class="checkbox-inline hide"><input name="is_directory_editor" id="is_directory_editor" type="checkbox">Directory Editor</label>
                             </div>
                         </div>

                         <div class="row">
                             <label for="user-status" class="control-label col-sm-2">Status:</label>
                             <div class="col-sm-10" id="user-status">
                                 <label class="checkbox-inline"><input name="is_active" id="is_active" type="checkbox">Active</label>
                             </div>
                         </div>

                         <div class="form-group">
                            <div class="text-center">
                                <a class="btn btn-danger" href="{{ route('users.index') }}">Cancel</a>
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
        <script src="{{asset('assets/vendors/fileinput/js/fileinput.min.js')}}"></script>
        <script src="{{ asset('assets/admin/js/user.js')}}" type="text/javascript"></script>
    @stop
</section>

@stop