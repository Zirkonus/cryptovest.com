@extends('admin/layouts/main')

<style>
    .my-label {
        margin-bottom: 15px;
    }

    .mce-tinymce.mce-container {
        display: inline-block;
        padding: 10px;
        box-sizing: border-box;
        margin: 20px 0 20px;
    }
</style>
{{--<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css"/>--}}
{{-- Page title --}}
@section('title')
    Create New Glossary item
    @parent
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Glossary item</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Glossary</li>
            <li>Items</li>
            <li class="active">Create New Glossary item</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="livicon" data-name="plus-alt" data-size="16" data-loop="true"
                               data-c="#fff" data-hc="white"></i>
                            Create a new Glossary item
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

                        {!! Form::open(['url' => 'admin/glossary/items/create']) !!}
                        <div class="form-group" style="display: inline-block; width: 100%;">
                            @if(isset($categories))
                                {!! Form::label("category", "Category Name : ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-10">
                                    {!! Form::select("category", $categories, null, [
                                        "class"        => "form-control",
                                        "placeholder"  => "Please pick a Category",
                                        "required"     => "required",
                                        "id"           => "category"
                                    ]) !!}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="row">
                                {!! Form::label("title", "Item Name : ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-10">
                                    {!! Form::text("title", null , ["class" =>"form-control", "required"=>"required"]) !!}
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            {!! Form::label("content", "Content: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <textmce name="content" id="content"></textmce>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <a class="btn btn-danger" href="{{ route('glossary.items') }}">Cancel</a>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        @section('footer_scripts')
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

            </script>

        @stop
    </section>
@stop