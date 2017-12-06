@extends('admin/layouts/main')

{{-- Page title --}}
@section('title')
    Edit ICO Project
    @parent
@stop

@section('header_styles')
    <style>
        .my-label {
            margin-bottom: 15px;
        }

        .admin-checkboxes .checkbox {
            text-align: center;
        }
    </style>
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css"
          rel="stylesheet">
    <link href="{{ asset('assets/vendors/fileinput/css/fileinput.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css"/>
@endsection

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>ICO Project</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>projects</li>
            <li class="active">Edit ICO Project</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="livicon" data-name="plus-alt" data-size="16" data-loop="true"
                                                   data-c="#fff" data-hc="white"></i>
                            Edit ICO Project {{$project->title}}
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
                        {!! Form::model($project, ['method' => 'POST', 'url' => 'admin/ico/projects/edit/' . $project->id, 'files' => true]) !!}
                        <div class="form-group" style="height: 30px">
                            {!! Form::label("title", "ICO Name: ", ["class"=>"control-label col-sm-2"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("title", $project->title , ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="form-group" style="height: 30px">
                            {!! Form::label("friendly_url", "Friendly URL: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("friendly_url", $project->friendly_url , ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::select("ico_type", $types, $project->ico_project_type_id, [
                                       "class"        => "form-control",
                                       "placeholder"  => "Please pick a Type",
                                       "required"     => "required",
                                       "id"           => "ico_type"
                                ]) !!}
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="ico_platform" name="ico_platform">
                                    @foreach($platforms as $platform)
                                        @if($project->ico_platform_id == $platform->id && $project->ico_platform_other == null)
                                            <option value="{{ $platform->id }}" data-other="{{$platform->is_other == 1 ? : ""}}" selected>{{ $platform->name }}</option>
                                        @elseif($project->ico_platform_other != null)
                                            <option value="{{ $platform->id }}" data-other="{{$platform->is_other == 1 ? : ""}}" {{$platform->is_other == 1 ? "selected" : ""}}>{{ $platform->name }}</option>
                                        @else
                                            <option value="{{ $platform->id }}" data-other="{{$platform->is_other == 1 ? : ""}}">{{ $platform->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <input class="form-control" type="text" style="margin-top: 10px; {{ $project->ico_platform_other == null ? "display:none" : "display:block" }}" id="customPlatform" name="other_platform" placeholder="Your custom platform" value="{{ $project->ico_platform_other != null ? $project->ico_platform_other : "" }}"/>

                            </div>
                            <div class="form-group">
                                <select class="form-control" id="ico_category" name="ico_category">
                                    @foreach($categories as $category)
                                        @if($project->ico_category_id == $category->id && $project->ico_category_other == null)
                                            <option value="{{ $category->id }}" data-other="{{$category->is_other == 1 ? : ""}}" selected>{{ $category->name }}</option>
                                        @elseif($project->ico_category_other != null)
                                            <option value="{{ $category->id }}" data-other="{{$category->is_other == 1 ? : ""}}" {{$category->is_other == 1 ? "selected" : ""}}>{{ $category->name }}</option>
                                        @else
                                            <option value="{{ $category->id }}" data-other="{{$category->is_other == 1 ? : ""}}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                    <input class="form-control" type="text" style="margin-top: 10px; {{ $project->ico_category_other == null ? "display:none" : "display:block" }}" id="customCategory" name="other_category" placeholder="Your custom category" value="{{ $project->ico_category_other != null ? $project->ico_category_other : "" }}"/>
                            </div>
                            <div class="form-group">
                                {!! Form::select("ico_promotion", $promotions, $project->ico_promotion_id, [
                                       "class"        => "form-control",
                                       "placeholder"  => "Please choose a Promotion",
                                       "id"           => "ico_promotion"
                                ]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label("short_description", "Short description: ", ["class"=>"control-label"]) !!}
                                {!! Form::textarea("short_description", $project->short_description , ["class" =>"form-control", "rows" =>3]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label("content", "Full description: ", ["class"=>"control-label"]) !!}
                                <textmce name="content" id="content">{!! $project->description !!}</textmce>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label("image_old", "ICON: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                <img src="{{asset($project->image)}}">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::file("image", ["class" =>"file", "placeholder" => "New Icon"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label("total_supply", "Total Supply: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("total_supply", $project->total_supply, ["class" =>"form-control"]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label("raised_field", "Raised Field: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("raised_field", $project->raised_field, ["class" =>"form-control"]) !!}
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label("pre-sale_condition", "Pre-sale Conditions: ", ["class"=>"control-label"]) !!}
                                {!! Form::textarea("pre-sale_condition", $project->presale_condition, ["class" =>"form-control", "rows" =>3]) !!}
                            </div>

                            {{--Money--}}
                            <div class="form-group">
                                <label class="control-label">Choose Money for ICO: </label>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::select("money", $money, '', [
                                               "class"        => "form-control",
                                               "placeholder"  => "Please pick Money",
                                               "id"           => "money"
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-default" id="choose-money-but">Add</a>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="chosen_money" id="chosen_money" class="form-control"
                                               value="{{$icoMoney}}" data-role="tagsinput"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--User money--}}
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label class="control-label">
                                    Short Token/Coin Name
                                </label>

                                <input type="text" name="short_token" id="short_token" class="form-control"
                                       value="{{$project->short_token}}"/>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label">
                                    Number of coins available for crowdsale
                                </label>
                                <input type="text" name="number_coins" id="number_coins" class="form-control"
                                       value="{{$project->number_coins}}"/>
                            </div>
                        </div>

                        {{--Dates--}}
                        <div class="form-group">
                            <div class='col-sm-6'>
                                <label class="control-label">Start Date ICO: </label>
                                <div class="form-group">
                                    <div class='input-group date' id='date-start'>
                                        <input id="start" name="start" type='text' class="form-control"
                                               value="{{date('d-m-Y g:i a', strtotime($project->data_start))}}"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                         </span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-6'>
                                <label class="control-label">End Date ICO: </label>
                                <div class="form-group">
                                    <div class='input-group date' id='date-end'>
                                        <input id="end" name="end" type='text' class="form-control"
                                               value="{{date('d-m-Y g:i a', strtotime($project->data_end))}}"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                         </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--Members--}}

                        <div class="col-sm-12" style="padding-bottom: 20px">
                            {!! Form::label('mem', 'Members: ' ,['class' => 'col-sm-2']) !!}
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <a id="new-member" class="btn btn-default">New Member</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" id="addMem" hidden>
                            <div class="col-sm-12">
                                <div class="col-sm-4" style="padding-bottom: 10px">
                                    <input type="text" placeholder="Write First Name" id="memFirstName"
                                           class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Write Last Name" id="memLastName"
                                           class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Write Position" id="memPosition"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12" style="padding-bottom: 10px">
                                <div class="col-sm-6">
                                    <input type="text" placeholder="LinkedId Link" id="memLinkedIdLink"
                                           class="form-control">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Twitter Link" id="memTwitterLink"
                                           class="form-control">
                                </div>
                            </div>
                            <a id="add-member" style="margin: 10px" class="btn btn-default">Add Member</a>
                        </div>
                        <div class="col-sm-12" style="padding-bottom: 30px; padding-top: 30px">
                            <table class="table table-bordered " id="members-table">
                                <thead>
                                <tr class="filters">
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($project->getMembers)
                                    @foreach($project->getMembers as $mem)
                                        <tr>
                                            <td>{{$mem->first_name}} {{$mem->last_name}}</td>
                                            <td>{{$mem->position}}</td>
                                            <td><a class='btn del-member btn-danger' name="member-del"
                                                   num="{{$loop->index}}">Delete</a></td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <input hidden name="list-of-members" id="list-of-members" value="{{$icoMembers}}">
                        {{--Links--}}
                        <div class="form-group">
                            {!! Form::label("link_whitepaper", "Link Whitepaper: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_whitepaper", $project->link_whitepaper, ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label("link_website", "Link WebSite: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_website", $project->link_website , ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label("link_announcement", "Link Announcement: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_announcement", $project->link_announcement , ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label("link_youtube", "Link Youtube: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_youtube", $project->link_youtube , ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label("link_facebook", "Link Facebook: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_facebook", $project->link_facebook , ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label("link_telegram", "Link Telegram: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_telegram", $project->link_telegram , ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label("link_instagram", "Link Instagram: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_instagram", $project->link_instagram , ["class" =>"form-control"]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label("link_linkedin", "Link LinkedIn: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_linkedin", $project->link_linkedin , ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label("link_twitter", "Link Twitter: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_twitter", $project->link_twitter , ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label("link_slack", "Link Slack: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_slack", $project->link_slack , ["class" =>"form-control"]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label("link_but_join_presale", "Link For Button Join Presale: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_but_join_presale", $project->link_but_join_presale , ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label("link_but_explore_more", "Link For Button Explore More: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_but_explore_more", $project->link_but_explore_more , ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label("link_but_join_token_sale", "Link For Button Join Token Sale: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_but_join_token_sale", $project->link_but_join_token_sale , ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label("link_but_exchange", "Link For Button Exchange: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                            <div class="col-sm-10 my-label">
                                {!! Form::text("link_but_exchange", $project->link_but_exchange , ["class" =>"form-control"]) !!}
                            </div>
                        </div>
                            <div class="form-group">
                                {!! Form::label("ico_screenshot", "Screen shot: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-10 my-label">
                                    <img src="{{asset($project->ico_screenshot)}}">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::file("ico_screenshot", ["class" =>"file", "placeholder" => "New screenshot"]) !!}
                                </div>
                            </div>

                            @if (isset($project->getICODeal->getICOBuyer))
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <h4>Buyer info:</h4>
                                    <p>Name: {{ $project->getICODeal->getICOBuyer->name }}</p>
                                    <p>Email: {{ $project->getICODeal->getICOBuyer->email }}</p>
                                    @if ($project->getICODeal->getICOBuyer->company)
                                        <p>Company: {{ $project->getICODeal->getICOBuyer->company }}</p>
                                    @endif
                                    @if ($project->getICODeal->getICOBuyer->mobile)
                                        <p>Mobile: {{ $project->getICODeal->getICOBuyer->mobile }}</p>
                                    @endif
                                </div>
                            </div>
                            @endif


                            <div class="col-sm-12 admin-checkboxes">
                                <div class="col-sm-2 col-sm-offset-1">
                                    <div class="checkbox">
                                        <label><input name="is_top" id="is_top" type="checkbox"
                                                      @if($project->is_top) checked @endif> Is Banner ICO</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="checkbox">
                                        <label><input name="is_widget" id="is_widget" type="checkbox"
                                                      @if($project->is_widget) checked @endif> Is Home Widget
                                            ICO</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="checkbox">
                                        <label><input name="is_active" id="is_active" type="checkbox"
                                                      @if($project->is_active) checked @endif> Is Active</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="checkbox">
                                        <label><input name="is_fraud" id="is_fraud" type="checkbox"
                                                      @if($project->is_fraud) checked @endif> Is Fraud</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="checkbox">
                                        <label><input name="is_top_six" id="is_top_six" type="checkbox"
                                                      @if($project->is_top_six) checked @endif> Is Top 6</label>
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
        </div>
        </div>

    </section>

@endsection
@section('footer_scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"
            type="text/javascript"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"
            type="text/javascript"></script>
    <script src="{{asset('assets/vendors/fileinput/js/fileinput.min.js')}}"></script>
    <script src="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
    <script src="{{ asset('assets/admin/tinymce/js/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
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
                    height: y * 1,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };

        tinymce.init(editor_config);

        var arrMember = [];
        if ($('#list-of-members').val()) {
            arrMember = JSON.parse($('#list-of-members').val())
        }
        var number = arrMember.length;
        var jsonMem;
        $("#image").fileinput();

        $('#title').on('change', function () {
            var str = $('#title').val();
            str = str.trim().toLowerCase();
            str = str.replace(/\s+/g, ' ');
            str = str.replace(/\s/g, '-');
            str = str.replace(/[^A-Za-z0-9\-]/gim, '');
            $('#friendly_url').val(str);
        });

        //        $('#total_supply').change(function () {
        //            if (!$.isNumeric($('#total_supply').val())) {
        //                $('#total_supply').val('');
        //            }
        //        });
        //        $('#raised_field').change(function () {
        //            if (!$.isNumeric($('#raised_field').val())) {
        //                $('#raised_field').val('');
        //            }
        //        });
        $(function () {
            $('#date-start').datetimepicker({
                format: 'DD-MM-YYYY LT',
            });
            $('#date-end').datetimepicker({
                format: 'DD-MM-YYYY LT',
            });
        });
        $('#choose-money-but').on('click', function () {
            var tag = $('#money option:selected').text();
            $('#chosen_money').tagsinput('add', tag);

        });
        //       members
        //        var mem = $('#list-of-members').val();
        $('#new-member').on('click', function () {
            $('#addMem').show();
        });

        $('#add-member').on('click', function () {
            var first_name = $('#memFirstName').val();
            var last_name = $('#memLastName').val();
            var position = $('#memPosition').val();
            var linkedIn = $('#memLinkedIdLink').val();
            var twitter = $('#memTwitterLink').val();

            arrMember[number] = {
                'first_name': first_name,
                'last_name': last_name,
                'position': position,
                'linkedIn': linkedIn,
                'twitter': twitter,
            };
            jsonMem = JSON.stringify(arrMember);
            $('#memFirstName').val('');
            $('#memLastName').val('');
            $('#memPosition').val('');
            $('#memLinkedIdLink').val('');
            $('#memTwitterLink').val('');
            $('#addMem').hide();
            var str = '<tr><td>' + first_name + ' ' + last_name + '</td><td>' + position + '</td><td><a name=\'member-del\' num=\'' + number + '\' class=\'btn del-member btn-danger\'>Delete</a></td><tr>';
            $('#members-table tbody').append(str);
            $('#list-of-members').val(jsonMem);
            number++;
        });

        $('#members-table').on('click', 'a[name=member-del]', function () {
            var n = $(this).attr('num');
            arrMember[n] = '';
            jsonMem = JSON.stringify(arrMember);
            $('#list-of-members').val(jsonMem);
            $(this).parent().parent().remove();
        });

        // Action then user choose other category
        $(".panel-body").on('change', '#ico_category', function(){
            if($(this).find(':selected').attr("data-other")){
//                inputData = $("#customCategory").val();
                $("#customCategory").show().attr("name", "other_category");
            } else {
                $("#customCategory").hide().attr("name", "");
            }
        });

        // Action then user choose other platform
        $(".panel-body").on('change', '#ico_platform', function(){
            if($(this).find(':selected').attr("data-other")){
                $("#customPlatform").show().attr("name", "other_platform");
            } else {
                $("#customPlatform").hide().attr("name", "");
            }
        });
    </script>
@endsection
