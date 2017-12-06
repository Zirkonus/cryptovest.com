@extends('admin/layouts/main')

<style>
    .my-label {
        margin-bottom: 15px;
    }

    .bootstrap-tagsinput input {
        display: none;
    }

    body .bootstrap-tagsinput {
        display: none;
    }
</style>
<link href="{{ asset('assets/vendors/fileinput/css/fileinput.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css"/>
{{-- Page title --}}
@section('title')
    Add New
    @parent
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Executives</h1>
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
                            <i class="livicon" data-name="plus-alt" data-size="16" data-loop="true" data-c="#fff"
                               data-hc="white"></i>
                            Create a new Executive
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
                        {!! Form::open(['url' => 'admin/executives', 'files' => true]) !!}
                        @foreach($languages as $lang)
                            <div class="lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none"
                                 @else style="display:block" @endif>
                                <div class="form-group">
                                    {!! Form::label('name_'.$lang->id, 'First Name : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
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
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label('country', 'Country : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-10 my-label">
                                    {!! Form::select("country", $countries, '', [
                                       "class"        => "form-control",
                                       "placeholder"  => "Please pick a Country",
                                       "required"     => "required",
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        @if(isset($roles))
                            {!! Form::label('role', 'Roles : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 role">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <select class="form-control" id="selectRoles" name="selected_roles">
                                            @foreach($roles as $roleKey => $role)
                                                <option value="{{$roleKey}}">{{ $role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-default" id="choose-role-but">Add</a>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="roles" id="resultRoles" class="form-control"
                                               value=""
                                               data-role="tagsinput"/>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($icos))
                            {!! Form::label('selected_icos', 'ICOs : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 ico">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <select class="form-control" id="selectIcos" name="selected_icos">
                                            @foreach($icos as $ico)
                                                <option value="{{$ico->id}}">{{ $ico->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-default" id="choose-icos-but">Add</a>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="icos" id="resultIcos" class="form-control" value=""
                                               data-role="tagsinput"/>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($supports))
                            {!! Form::label('selected_support', 'Supports : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 supports">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <select class="form-control" id="selectSupports" name="selected_support">
                                            @foreach($supports as $key => $support)
                                                <option value="{{ $key }}">{{ $support }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-default" id="choose-supports-but">Add</a>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="supports" id="resultSupports" class="form-control"
                                               value=""
                                               data-role="tagsinput"/>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label('twitter_link', 'Twitter link : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-10 my-label">
                                    {!! Form::text('twitter_link', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label('linkedin_link', 'Linkedin link : ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-10 my-label">
                                    {!! Form::text('linkedin_link', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::file('image' , ['class' => 'file', "required" => "required"]) !!}
                            </div>
                        </div>
                        @foreach($languages as $lang)
                            <div class="col-sm-12 lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none"
                                 @else style="display:block" @endif>
                                <div class="form-group">
                                    <textmce name="{{ "biography_" . $lang->id }}"
                                             id="{{ "biography_" . $lang->id }}"></textmce>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-sm-12">
                            <div class="checkbox">
                                <label><input name="is_active" id="is_active" type="checkbox"> Is Active</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('executives.index') }}">Cancel</a>
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
            <script src="{{ asset('assets/admin/js/category.js')}}" type="text/javascript" charset="utf-8" async
                    defer></script>
            <script src="{{asset('assets/vendors/fileinput/js/fileinput.min.js')}}"></script>
            <script src="{{asset('assets/js/bootstrap-tagsinput.min.js')}}"></script>
            <script src="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
            <script src="{{ asset('assets/admin/tinymce/js/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
            <script>
                var editor_config = {
                    path_absolute: "/",
                    selector: "textmce",
                    plugins: [
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "emoticons template paste textcolor colorpicker textpattern"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                    relative_urls: false,
                    file_browser_callback: function (field_name, url, type, win) {
                        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                        var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                        if (type == 'image') {
                            cmsURL = cmsURL + "&type=Images";
                        } else {
                            cmsURL = cmsURL + "&type=Files";
                        }

                        tinyMCE.activeEditor.windowManager.open({
                            file: cmsURL,
                            title: 'Filemanager',
                            width: x * 0.8,
                            height: y * 0.8,
                            resizable: "yes",
                            close_previous: "no"
                        });
                    }
                };

                tinymce.init(editor_config);

                $("#image").fileinput();
                var elt = $('#resultIcos');
                var role = $("#resultRoles");
                var support = $("#resultSupports");
                elt.tagsinput({
                    itemValue: 'value',
                    itemText: 'text'
                });
                role.tagsinput({
                    itemValue: 'value',
                    itemText: 'text'
                });
                support.tagsinput({
                    itemValue: 'value',
                    itemText: 'text'
                });

                $('#choose-icos-but').on('click', function () {
                    $(".ico .bootstrap-tagsinput").css({"display": "inline-block"});
                    var icos = $('#selectIcos option:selected');
                    elt.tagsinput('add', {"value": icos.val(), "text": icos.text()});
                });
                $('#choose-role-but').on('click', function () {
                    $(".role .bootstrap-tagsinput").css({"display": "inline-block"});
                    var roles = $('#selectRoles option:selected');
                    role.tagsinput('add', {"value": roles.val(), "text": roles.text()});
                });
                $('#choose-supports-but').on('click', function () {
                    $(".supports .bootstrap-tagsinput").css({"display": "inline-block"});
                    var supports = $('#selectSupports option:selected');
                    support.tagsinput('add', {"value": supports.val(), "text": supports.text()});
                });
            </script>
        @stop
    </section>

@stop