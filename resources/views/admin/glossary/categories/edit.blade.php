@extends('admin/layouts/main')
<style>
    .my-label{
        margin-bottom: 15px;
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
        <li>Categories</li>
        <li class="active">Edit Category</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading" style="height: 54px">
                    <h4 class="panel-title" style="display: inline-block; padding-top: 5px"> <i class="livicon" data-name="edit" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Edit Category {{$category->name or ""}}
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
                    @if(isset($category))
                    {!! Form::model($category, ['method' => 'POST', 'url' => 'admin/glossary/categories/edit/' . $category->id]) !!}

                         <div class="form-group">
                             {!! Form::label("name", "Category Name : ", ["class"=>"control-label col-sm-2", "style"=>"padding-top:4px"]) !!}
                             <div class="col-sm-10 my-label">
                                 {!! Form::text("name", $category->name, ["class" =>"form-control", "required"=>"required"]) !!}
                             </div>
                         </div>
                        <div class="form-group">
                        {!! Form::submit('Update', ['class' => 'btn btn-primary form-control', "style"=>"margin-top:15px"]) !!}
                    </div>
                    {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@stop