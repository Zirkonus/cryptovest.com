@extends('admin/layouts/main')
<style>
    .my-label{
        margin-bottom: 15px;
    }
</style>
<link href="{{ asset('assets/vendors/fileinput/css/fileinput.min.css') }}" rel="stylesheet">
{{-- Page title --}}
@section('title')
Edit the Project-type
@parent
@stop


@section('content')
<section class="content-header">
    <h1>Project-types</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>Project-types</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading" style="height: 54px">
                    <h4 class="panel-title" style="display: inline-block; padding-top: 5px"> <i class="livicon" data-name="edit" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Edit Project-type {{$money->name}}
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

                    {!! Form::model($money, ['method' => 'POST', 'url' => 'admin/ico/money/edit/' . $money->id , 'files' => true]) !!}

                         <div class="form-group">
                             {!! Form::label("name", "Name : ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                             <div class="col-sm-10 my-label">
                                 {!! Form::text("name", $money->name , ["class" =>"form-control", "required"=>"required"]) !!}
                             </div>
                         </div>
                         <div class="col-sm-12">
                             <div class="col-sm-6">
                                 <div class="form-group" style="padding-top: 15px">
                                     <label style="padding-right: 20px"> Icon : </label>
                                     <img style = "width: 75px; height: 75px;" src="{{asset($money->icon)}}" alt="money icon">
                                 </div>
                             </div>
                             <div class="col-sm-6">
                                 <label style="padding-right: 20px"> New Icon : </label>
                                 <div class="form-group" style="padding-top: 15px">
                                     {!! Form::file('image' , ['class' => 'file']) !!}
                                 </div>
                             </div>
                         </div>

                         <div class="col-sm-12">
                             <div class="checkbox">
                                 <label><input name="is_active" id="is_active" type="checkbox" {{($money->is_active) ? "checked" : "" }}> Is active</label>
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
</section>
    @section('footer_scripts')
        <script src="{{asset('assets/vendors/fileinput/js/fileinput.min.js')}}"></script>
    @stop
@stop