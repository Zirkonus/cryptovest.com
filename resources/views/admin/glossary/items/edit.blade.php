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
{{-- Page title --}}
@section('title')
    Edit the Category
    @parent
@stop


@section('content')
    <section class="content-header">
        <h1>Category</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Glossary</li>
            <li>Items</li>
            <li class="active">Edit Glossary item</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading" style="height: 54px">
                        <h4 class="panel-title" style="display: inline-block; padding-top: 5px">
                            <i class="livicon"
                               data-name="edit"
                               data-size="16"
                               data-loop="true"
                               data-c="#fff"
                               data-hc="white">
                            </i>
                            Edit Glossary item {{$item->title or ""}}
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
                        @if(isset($item))
                            {!! Form::model($item, ['method' => 'POST', 'url' => 'admin/glossary/items/edit/' . $item->id]) !!}
                            <div class="form-group" style="display: inline-block; width: 100%;">
                                @if(isset($category))
                                    {!! Form::label("category", "Item category: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select("category", $categories, $category, [
                                            "class"        => "form-control",
                                            "placeholder"  => "Please pick a Category",
                                            "required"     => "required",
                                            "id"           => "category"
                                        ]) !!}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                {!! Form::label("title", "Item Title : ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-10 my-label">
                                    {!! Form::text("title", $item->title, ["class" =>"form-control", "required"=>"required"]) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label("content", "Content: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <textmce name="content" id="content">{!! $item->content !!}</textmce>
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
                            </div>
                            {!! Form::close() !!}
                        @endif
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
                    },
                };
                tinymce.init(editor_config);

            </script>

        @stop
    </section>
@stop