@extends('admin/layouts/main')
<style>
    .my-label{
        margin-bottom: 15px;
    }
</style>
{{-- Page title --}}
@section('title')
Edit the Member
@parent
@stop


@section('content')
<section class="content-header">
    <h1>Member</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li>members</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading" style="height: 54px">
                    <h4 class="panel-title" style="display: inline-block; padding-top: 5px"> <i class="livicon" data-name="edit" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Edit Member: {{$member->first_name}} {{$member->last_name}}
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

                    {!! Form::model($member, ['method' => 'POST', 'url' => 'admin/ico/members/edit/' . $member->id]) !!}

                         <div class="form-group">
                             {!! Form::label("first_name", "Member First Name : ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                             <div class="col-sm-10 my-label">
                                 {!! Form::text("first_name", $member->first_name, ["class" =>"form-control", "required"=>"required"]) !!}
                             </div>
                         </div>
                         <div class="form-group">
                             {!! Form::label("last_name", "Member Last Name : ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                             <div class="col-sm-10 my-label">
                                 {!! Form::text("last_name", $member->last_name, ["class" =>"form-control", "required"=>"required"]) !!}
                             </div>
                         </div>
                         <div class="form-group">
                             {!! Form::label("position", "Member Position : ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                             <div class="col-sm-10 my-label">
                                 {!! Form::text("position", $member->position, ["class" =>"form-control", "required"=>"required"]) !!}
                             </div>
                         </div>
                         <div class="form-group">
                             {!! Form::label("twitter_link", "Twitter Link : ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                             <div class="col-sm-10 my-label">
                                 {!! Form::text("twitter_link", $member->twitter_link, ["class" =>"form-control"]) !!}
                             </div>
                         </div>
                         <div class="form-group">
                             {!! Form::label("linkedin_link", "LinkedIn Link : ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                             <div class="col-sm-10 my-label">
                                 {!! Form::text("linkedin_link", $member->linkedin_link, ["class" =>"form-control"]) !!}
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
@stop