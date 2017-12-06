@extends('admin/layouts/main')
<style>
    .my-label{
        margin-bottom: 15px;
    }
</style>
<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<link href="{{ asset('assets/vendors/fileinput/css/fileinput.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />
{{-- Page title --}}
@section('title')
    Edit Event
    @parent
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Events</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Events</li>
            <li class="active">Edit event</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title"> <i class="livicon" data-name="plus-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Edit {{$event->name}} event
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

                        {!! Form::model($event, ['method' => 'PATCH', 'action' => ['EventsController@update', $event->id] ]) !!}

                            <div class="form-group">
                                {!! Form::label("name", "Event name: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-10 my-label">
                                    {!! Form::text("name", null , ["class" =>"form-control", "required"=>"required"]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label("friendly_url", "Friendly URL: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-10 my-label">
                                    {!! Form::text("friendly_url", null , ["class" =>"form-control", "required"=>"required"]) !!}
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label("short_description", "Short description: ", ["class"=>"control-label"]) !!}
                                    {!! Form::textarea("short_description", null , ["class" =>"form-control", "required"=>"required", "rows" =>3]) !!}
                                </div>
                            </div>
                            {{--Dates--}}
                            <div class="form-group">
                                <label class="control-label col-sm-2">Start Date:</label>
                                <div class="col-sm-10 my-label">
                                    <div class='input-group date' id='date-start'>
                                        <input id="start" name="date_start" type='text' class="form-control"
                                               value="{{$event->date_start}}" required/>
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                     </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">Select location</label>
                                <div class="col-sm-10 my-label">
                                    <select name="city_id" class="form-control" required>
                                        <option value="">Please pick</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" {{$event->city_id == $city->id ? 'selected': ''}}>{{$city->name . ', ' . $city->country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                {!! Form::label("link_but_explore_more", "External link: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-10 my-label">
                                    {!! Form::text("link_but_explore_more", $event->link , ["class" =>"form-control", "required"=>"required"]) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label("ico_promotion", "Promotion: ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                                <div class="col-sm-10 my-label">
                                    {!! Form::select("ico_promotion", $promotions, $event->ico_promotion_id, [
                                           "class"        => "form-control",
                                           "placeholder"  => "Please choose a Promotion",
                                           "id"           => "ico_promotion"
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="checkbox">
                                    <label><input name="is_widget" id="is_widget" type="checkbox" {{$event->top_featured ? 'checked': ''}}> Top feature</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="checkbox">
                                    <label><input name="is_active" id="is_active" type="checkbox" {{$event->is_active ? 'checked': ''}}> Is Active</label>
                                </div>
                            </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('events.index') }}">Cancel</a>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- row-->
    </section>
@stop
@section('footer_scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js" type="text/javascript"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <script src="{{asset('assets/vendors/fileinput/js/fileinput.min.js')}}"></script>
    <script src="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
    <script type="text/javascript">
        var str;
        $("#image").fileinput();

        $('#title').on('change', function(){
            var str = $('#title').val();
            str = str.trim().toLowerCase();
            str = str.replace(/\s+/g, ' ');
            str = str.replace(/\s/g, '-');
            str = str.replace(/[^A-Za-z0-9\-]/gim, '');
            $('#friendly_url').val(str);
        });

        $(function () {
            $('#date-start').datetimepicker({
                format: 'YYYY-MM-DD',
            });
        });
    </script>
@endsection
