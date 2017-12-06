@extends('admin/layouts/main')

<style>
    .my-label{
        margin-bottom: 15px;
    }

</style>
<link href="{{ asset('assets/vendors/fileinput/css/fileinput.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />
{{-- Page title --}}
@section('title')
Add New
@parent
@stop

{{-- Page content --}}
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="content-header">
    <h1>Posts</h1>
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
                        Create a new Post
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
                    {!! Form::open(['url' => 'admin/posts', 'files' => true]) !!}
                         <div class="form-group">
                            {!! Form::select("category", $c, '', [
                                   "class"        => "form-control",
                                   "placeholder"  => "Please pick a Category",
                                   "required"     => "required",
                                   "id"           => "category"
                            ]) !!}
                         </div>
                         <div class="form-group">
                             <label class="control-label">Choose Tag for posts: </label>
                         </div>
                         <div class="col-sm-12">
                             <div class="col-sm-4">
                                 <div class="form-group">
                                     {!! Form::select("tags", $tags, '', [
                                            "class"        => "form-control",
                                            "id"           => "tags"
                                     ]) !!}
                                 </div>
                             </div>
                             <div class="col-sm-2">
                                 <a class="btn btn-default" id="choose-tag-but">Add</a>
                             </div>
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <input type="text" name="chosen_tag" id="chosen_tag" class="form-control" value="" data-role="tagsinput"/>
                                 </div>
                             </div>
                         </div>
                         <div class="form-group">
                             <label class="control-label">Choose Executive for posts: </label>
                         </div>
                         <div class="col-sm-12">
                             <div class="col-sm-4">
                                 <div class="form-group">
                                     <select class="form-control" id="executives" name="executives">
                                         @foreach($executives as $executive)
                                             <option value="{{$executive->url}}">{{Translate::getValue($executive->first_name_lang_key) . ' ' . Translate::getValue($executive->last_name_lang_key)}}</option>
                                         @endforeach
                                     </select>
                                 </div>
                             </div>
                             <div class="col-sm-2">
                                 <a class="btn btn-default" id="choose-executive-but">Add</a>
                             </div>
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <input type="text" name="chosen_executive" id="chosen_executive" class="form-control" value="" data-role="tagsinput"/>
                                 </div>
                             </div>
                         </div>
                         <div class="form-group">
                            @if(Auth::user()->is_admin)
                                {!! Form::select("author", $authors, '', [
                                     "class"        => "form-control",
                                     "placeholder"  => "Please choose the Author",
                                     "required"     => "required",
                                     "id"           => "author"
                                ]) !!}
                            @endif
                         </div>
                         <div class="form-group" style="padding-top: 15px">
                            {!! Form::file('image' , ['class' => 'file', "required" => "required"]) !!}
                         </div>
                            @foreach($languages as $lang)
                                <div class="lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                                    <div class="form-group">
                                        @if ($lang->is_english == 1)
                                            {!! Form::text('title_'.$lang->id, null, ['class' => 'form-control', "placeholder" => "Title", "required" => "required"]) !!}
                                        @else
                                            {!! Form::text('title_'.$lang->id, null, ['class' => 'form-control', "placeholder" => "Title"]) !!}
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        @if ($lang->is_english == 1)
                                            {!! Form::textarea("description_".$lang->id, null, ["class" => "form-control", "placeholder" => "Description", "required" => "required", "rows" => 3]) !!}
                                        @else
                                            {!! Form::textarea("description_".$lang->id, null, ["class" => "form-control", "placeholder" => "Description", "rows" => 3]) !!}
                                        @endif
                                    </div>
                                    <textmce id="content_{{$lang->id}}">{{ old('content_'.$lang->id), '' }}</textmce>
                                </div>
                            @endforeach

                        @foreach($languages as $lang)
                         <div class="form-group" style="padding-top: 15px;">
                             {!! Form::text("meta-title_".$lang->id, null, ["class" => "form-control", "placeholder"=>"Meta title"]) !!}
                         </div>
                         <div class="form-group">
                             {!! Form::textarea("meta-description_".$lang->id, null, ["class" => "form-control", "placeholder"=>"Meta description", "rows"=> 5]) !!}
                         </div>
                         <div class="form-group">
                             <div class="form-group">
                                 {!! Form::select("label", $labels, '',[
                                    "class"        => "form-control",
                                    "placeholder"  => "Please pick the label",
                                    "id"           => "label"
                                 ]) !!}
                             </div>
                         </div>

                        @endforeach
                         <div class="form-group">
                             <div class="col-sm-12">
                                 <div id="is_exclusive_for_main" class="form-group">
                                     <div class="checkbox">
                                         <label><input name="is_exclusive" id="is_exclusive" type="checkbox"> Is Exclusive</label>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="form-group">
                             <div class="col-sm-12">
                                 <div id="hide_image" class="form-group">
                                     <div class="checkbox">
                                         <label><input name="hide_image" id="hide_image" type="checkbox">Hide featured image</label>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="form-group">
                             <div class="col-sm-12">
                                 <div id="is_ico_review" class="form-group">
                                     <div class="checkbox">
                                         <label><input name="is_ico_review" id="is_ico_review" type="checkbox">ICO Review</label>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="form-group">
                             <div class="row">
                                 <div class="col-md-12">
                                     <label for='keys' >Meta Keys: </label>
                                     {!! Form::text('keys', null, ['class' => 'form-control', "data-role" => "tagsinput", "placeholder" => "add key.."]) !!}
                                 </div>
                             </div>
                         </div>

                        <div class="form-group">
                            {!! Form::select("status", $statuses, '', [
                                 "class"        => "form-control",
                                 "placeholder"  => "Please pick a Status",
                                 "required"     => "required",
                                 "id"           => "status"
                          ]) !!}
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4" style="padding-top: 15px">
                                <a class="btn btn-danger" href="{{ route('posts.index') }}">Cancel</a>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                         <div id="is_keep_featured_for_main" class="form-group">
                             <div class="checkbox">
                                 <label><input name="is_keep_featured" id="is_keep_featured" type="checkbox"> Is Keep Featured</label>
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
        <script src="{{asset('assets/vendors/fileinput/js/fileinput.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap-tagsinput.min.js')}}"></script>
        <script src="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
        <script>
            if ($('#category option:selected').text() != 'News') {
                $('#is_keep_featured_for_main').hide();
            }
            $("#image").fileinput();
            var editor_config = {
                path_absolute : "/",
                selector: "textmce",
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                default_link_target: "_blank",
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                relative_urls: false,
                file_browser_callback : function(field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                    if (type == 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    } else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file : cmsURL,
                        title : 'Filemanager',
                        width : x * 0.8,
                        height : y * 0.8,
                        resizable : "yes",
                        close_previous : "no"
                    });
                },
                init_instance_callback: function (editor) {
                    editor.on('BeforeSetContent', function (e) {
                        var changedFirstUrlToTargetBank = e.content.replace(new RegExp('target="_blank"', 'g'), '');
                        e.content  = changedFirstUrlToTargetBank.replace(new RegExp('<a', 'g'), '<a target="_blank"');
                    });
                }
            };

            tinymce.init(editor_config);

            $('#choose-tag-but').on('click', function(){
                var tag = $('#tags option:selected').text();
                $('#chosen_tag').tagsinput('add', tag);

            });

            $('#choose-executive-but').on('click', function(){
                var tag = $('#executives option:selected').val();
                $('#chosen_executive').tagsinput('add', tag);

            });
        </script>

    @stop
</section>

@stop

