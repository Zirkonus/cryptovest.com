@extends('admin/layouts/main')
<style>
    .my-label{
        margin-bottom: 15px;
    }
</style>
{{-- Page title --}}
@section('title')
Edit a Page
@parent
@stop


@section('content')
<section class="content-header">
    <h1>Pages</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Pages</li>
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
                        Edit Page {{Translate::getValue($page->title_lang_key)}}
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

                    {!! Form::model($page, ['method' => 'PATCH', 'action' => ['PagesController@update', $page->id] ]) !!}

                         @foreach($languages as $lang)
                             <div class="lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                                 <div class="form-group">
                                     {!! Form::label('title_'.$lang->id, 'Title: ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                     <div class="col-sm-10 my-label">
                                         {!! Form::text('title_'.$lang->id, Translate::getValue($page->title_lang_key, $lang->id), ['class' => 'form-control', 'required'=>'required']) !!}
                                     </div>
                                 </div>
                             </div>
                         @endforeach

                         <div class="form-group">
                             {!! Form::label("friendly_url", "Friendly URL: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                             <div class="col-sm-8 my-label">
                                 {!! Form::text("friendly_url", $page->friendly_url, ["class" =>"form-control", "readonly"=>"readonly", "required"=>"required"]) !!}
                             </div>
                             <div class="col-sm-2">
                                 <a class="btn btn-default" id="edit_url">Edit</a>
                             </div>
                         </div>
                         @foreach($languages as $lang)
                             <div class="col-sm-12">
                                 <div class="form-group">
                                     {!! Form::label("description_".$lang->id, "Description: ", ["class"=>"control-label"]) !!}
                                     {!! Form::textarea('description_'.$lang->id, Translate::getValue($page->description_lang_key), ['class' => 'form-control', "placeholder" => "Description", "rows" => "3"]) !!}
                                 </div>
                                 <div class="form-group">
                                     <label>Content:</label>
                                     <textmce id="content_{{$lang->id}}">{!! Translate::getValue($page->content_lang_key) !!}</textmce>
                                 </div>
                             </div>
                             <div class="col-sm-12 lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                                 @foreach($page->getMetaContent as $meta)
                                     <div class="form-group">
                                         @if($meta->language_id == $lang->id && $meta->meta_type_id == 1)
                                         {!! Form::label("meta-title_".$lang->id, "Meta Title: ", ["class"=>"control-label"]) !!}
                                         {!! Form::text("meta-title_".$lang->id, $meta->content, ["class" => "form-control", "placeholder"=>"Meta title", "required"=>"required"]) !!}
                                         @endif
                                     </div>
                                     <div class="form-group">
                                         @if($meta->language_id == $lang->id && $meta->meta_type_id == 2)
                                            {!! Form::label("meta-description_".$lang->id, "Meta Description: ", ["class"=>"control-label"]) !!}
                                            {!! Form::textarea("meta-description_".$lang->id, $meta->content, ["class" => "form-control", "placeholder"=>"Meta description", "required"=>"required", "rows"=> 5]) !!}
                                         @endif
                                     </div>
                                 @endforeach
                             </div>
                         @endforeach
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

        <script>
            var editor_config = {
                path_absolute : "{{ URL::to('/') }}/",
                selector : "textmce",
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
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementByTagName('body')[0].clientWidth;
                    var y = window.innerHeight|| document.documentElement.clientHeight|| document.grtElementByTagName('body')[0].clientHeight;
                    var cmsURL = editor_config.path_absolute+'laravel-filemanaget?field_name'+field_name;
                    if (type = 'image') {
                        cmsURL = cmsURL+'&type=Images';
                    } else {
                        cmsUrl = cmsURL+'&type=Files';
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file : cmsURL,
                        title : 'Filemanager',
                        width : x * 0.8,
                        height : y * 0.8,
                        resizeble : 'yes',
                        close_previous : 'no'
                    });
                }
            };

            tinymce.init(editor_config);
        </script>
    @stop
</section>
@stop