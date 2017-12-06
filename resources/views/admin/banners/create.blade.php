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
    <h1>Banners</h1>
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
                        Create a new Banner
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

                    {!! Form::open(['url' => 'admin/banners', 'enctype' =>'multipart/form-data']) !!}
                         @foreach($languages as $lang)
                             <div class="lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                                 <div class="form-group">
                                    {!! Form::label('title_'.$lang->id, 'Page Title: ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                     <div class="col-sm-10 my-label">
                                        {!! Form::text('title_', null, ['class' => 'form-control']) !!}
                                     </div>
                                 </div>
                                 <div class="col-sm-12">
                                     <div class="form-group">
                                         {!! Form::text('url_'.$lang->id, null, ['class' => 'form-control', "placeholder" => "Description", "rows" => "3"]) !!}
                                     </div>
                                     <div class="form-group">
                                         <label>Content:</label>
                                         <textmce id="content_{{$lang->id}}"></textmce>
                                     </div>
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