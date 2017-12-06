@extends('admin/layouts/main')
<style>
    .my-label{
        margin-bottom: 15px;
    }
</style>
{{-- Page title --}}
@section('title')
    Edit a Coin
    @parent
@stop


@section('content')
    <section class="content-header">
        <h1>Coins</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Coins</li>
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
                            Edit Coin {{$coin->name}}
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

                        {!! Form::model($coin, ['method' => 'PATCH', 'action' => ['CoinsController@update', $coin->slug], 'files' => true  ]) !!}

                            @foreach($languages as $lang)
                                <div class="lang_{{$lang->id}}" @if($lang->is_main == 0) style="display:none" @else style="display:block" @endif>
                                    <div class="form-group">
                                        {!! Form::label('description_'.$lang->id, 'Coin Description: ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                        <div class="col-sm-10 my-label">
                                            <textmce name="{{'description_'.$lang->id}}" id="{{'description_'.$lang->id}}">{!!  Translate::getValue($coin->description_lang_key, $lang->id) !!}</textmce>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                                <div class="form-group">
                                    {!! Form::label('link_buy_coin', 'Link by coin: ', ['class' =>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                    <div class="col-sm-10 my-label">
                                        {!! Form::text('link_buy_coin', \App\CoinValue::getLinkBuyCoin($coin->symbol), ['class' => 'form-control']) !!}
                                    </div>
                                </div>


                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Coin Image:</label>
                                    <div>
                                        <img width="400px" height="400px" src="{{asset(\App\CoinValue::getValueImage($coin->symbol))}}" alt="coin image">
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('new-image', 'Change Coin Image : ', ['class' =>"control-label"]) !!}
                                    {!! Form::file('new-image' , ['class' => 'file']) !!}
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
            <script src="{{ asset('assets/admin/js/category.js')}}" type="text/javascript" charset="utf-8" async defer></script>

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