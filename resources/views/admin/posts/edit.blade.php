@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
    Edit a Post
    @parent
@stop

@section('header_styles')
    <style>
        .my-label{
            margin-bottom: 15px;
        }
    </style>
    <link href="{{ asset('assets/vendors/fileinput/css/fileinput.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />
@endsection

@section('content')
    <section class="content-header">
        <h1>Posts</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Posts</li>
            <li class="active">Add New</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading" style="height: 54px">
                        <h4 class="panel-title" style="display: inline-block; padding-top: 5px"> <i class="livicon" data-name="edit" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Edit Post {{Translate::getValue($post->title_lang_key)}}
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

                        {!! Form::model($post, ['method' => 'PATCH', 'action' => ['PostsController@update', $post->id], 'files' => true ]) !!}

                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::select("category", $cat, $post->category_id, [
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
                                        <input type="text" name="chosen_tag" id="chosen_tag" class="form-control" value="{{ implode(",", $post->tags->pluck('name')->toArray()) }}" data-role="tagsinput"/>
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
                                        <input type="text" name="chosen_executive" id="chosen_executive" class="form-control" value="{{ implode(",", $post->executives->pluck('url')->toArray()) }}" data-role="tagsinput"/>
                                    </div>
                                </div>
                            </div>
                            @if (Auth::user()->is_admin)
                                <div class="form-group">
                                    {!! Form::select("author", $authors, $post->user_id, [
                                       "class"        => "form-control",
                                       "placeholder"  => "Please pick the Author",
                                       "required"     => "required",
                                       "id"           => "author"
                                    ]) !!}
                                </div>
                            @endif
                            {!! Form::label('image','Image:', ['class' => 'label-form']) !!}
                            <div class="form-group">
                                <img src="{{asset($post->title_image)}}">
                            </div>
                            {!! Form::label('new-image','Change Title Image:', ['class' => 'label-form']) !!}
                            <div class="form-group">
                                {!! Form::file('new-image' , ['class' => 'file']) !!}
                            </div>
                            @foreach($languages as $lang)
                                <div class="lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                                    <div class="form-group">
                                        {!! Form::text('title_'.$lang->id, Translate::getValue($post->title_lang_key, $lang->id), ['class' => 'form-control', "placeholder" => "Title"]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::textarea("description_".$lang->id, Translate::getValue($post->description_lang_key, $lang->id), ["class" => "form-control", "placeholder" => "Description", "required" => "required", "rows" => 3]) !!}
                                    </div>
                                    <textmce id="content_{{$lang->id}}">{!! Translate::getValue($post->content_lang_key, $lang->id) !!}</textmce>
                                </div>
                            @endforeach
                            <div class="form-group" style="padding: 15px;">
                                {!! Form::label("friendly_url", "Friendly URL: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-8 my-label">
                                    {!! Form::text("friendly_url", $post->friendly_url, ["class" =>"form-control", "readonly"=>"readonly", "required"=>"required"]) !!}
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-default" id="edit_url">Edit</a>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::select("label", $labels, $post->label_id, [
                                   "class"        => "form-control",
                                   "placeholder"  => "Please pick the label",
                                   "id"           => "label"
                                ]) !!}
                            </div>
                        </div>
                        @foreach($languages as $lang)
                            <div class="col-sm-12 lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                                @foreach($post->getMetaContent as $meta)
                                    <div class="form-group">
                                        @if($meta->language_id == $lang->id && $meta->meta_type_id == 1)
                                            {!! Form::text("meta-title_".$lang->id, $meta->content, ["class" => "form-control", "placeholder"=>"Meta title", "required"=>"required"]) !!}
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        @if($meta->language_id == $lang->id && $meta->meta_type_id == 2)
                                            {!! Form::textarea("meta-description_".$lang->id, $meta->content, ["class" => "form-control", "placeholder"=>"Meta description", "required"=>"required", "rows"=> 5]) !!}
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for='keys' >Meta Keys: </label>
									<?php $str = ''; ?>
                                    @foreach($post->getMetaContent as $meta)
                                        @if($meta->meta_type_id == 3)
											<?php $str .= $meta->content . ', '; ?>
                                        @endif
                                    @endforeach
                                    <div class="form-group">
                                        {!! Form::text('keys', $str , ['class' => 'form-control', "data-role" => "tagsinput", "placeholder" => "Add key"]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::select("status", $statuses, $post->status_id, [
                                   "class"        => "form-control",
                                   "placeholder"  => "Please pick a Status",
                                   "required"     => "required",
                                   "id"           => "status"
                                ]) !!}
                            </div>
                        </div>
                        {!! Form::label("created_at", "Created At: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                        <div class="col-sm-8 my-label">
                            {!! Form::text('created_at', $post->created_at,['class' => 'form-control', "required" => "required" ]) !!}
                        </div>
                        <div class="col-sm-12">
                            <div id="is_keep_featured_for_main" class="form-group">
                                <div class="checkbox">
                                    <label><input name="is_keep_featured" id="is_keep_featured" type="checkbox" @if($post->is_keep_featured) checked @endif> Is Keep Featured</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div id="is_exclusive_for_main" class="form-group">
                                <div class="checkbox">
                                    <label><input name="is_exclusive" id="is_exclusive" type="checkbox" @if($post->is_exclusive) checked @endif> Is Exclusive</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div id="hide_image" class="form-group">
                                <div class="checkbox">
                                    <label><input name="hide_image" id="hide_image" type="checkbox" @if($post->hide_image) checked @endif>Hide featured image</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div id="is_ico_review" class="form-group">
                                    <div class="checkbox">
                                        <label><input name="is_ico_review" id="is_ico_review" type="checkbox"  @if($post->is_ico_review) checked @endif>ICO Review</label>
                                    </div>
                                </div>
                            </div>
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
            <script src="{{ asset('assets/admin/tinymce/js/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
            <script src="{{ asset('assets/admin/js/category.js')}}" type="text/javascript" charset="utf-8" async defer></script>
            <script src="{{asset('assets/vendors/fileinput/js/fileinput.min.js')}}"></script>
            <script src="{{asset('assets/js/bootstrap-tagsinput.min.js')}}"></script>
            <script src="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
            <script>
                if ($('#category option:selected').text() != 'News') {
                    $('#is_keep_featured_for_main').hide();
                }
                $("#new-image").fileinput();
                var editor_config = {
                    path_absolute : "/",
                    selector: "textmce",
                    plugins: [
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "emoticons template paste textcolor colorpicker textpattern"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                    relative_urls: false,
                    default_link_target: "_blank",
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