@extends('admin/layouts/main')

<style>
    .my-label{
        margin-bottom: 15px;
    }
</style>
{{-- Page title --}}
@section('title')
    Edit Location
    @parent
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Locations</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li>Locations</li>
            <li class="active">Edit location</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title"> <i class="livicon" data-name="plus-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            Edit {{$city->name}} event
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

                        {!! Form::model($city, ['method' => 'PATCH', 'action' => ['LocationsController@update', $city->id] ]) !!}

                        <div class="form-group">
                            {!! Form::label('name', 'City: ', ['class' =>"control-redirect"]) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required'=>'required']) !!}
                        </div>
                        <div class="form-group">
                            <select name="country_id" id="country" class="form-control" required>
                                <option value="">Please pick a country</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}" {{$country->id == $city->country_id ? 'selected': ''}}>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('locations.index') }}">Cancel</a>
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
            <script src="{{ asset('assets/admin/js/category.js')}}" type="text/javascript" charset="utf-8" async defer></script>
        @stop
    </section>

@stop