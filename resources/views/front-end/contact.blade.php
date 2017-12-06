@extends('layouts.main')

@section('title', Translate::getValue($page->title_lang_key) . " - Cryptovest")
@section('meta-tags')
    <meta name="description" content="{{Translate::getValue($page->description_lang_key)}}">
@endsection
@section('body-class', 'contactPage')

@section('content')
    <div class="container contactFormBlock">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-8">
                        <h1>Contact</h1>
                        <sub class="col-12 col-md-12 col-lg-9 p-0">To learn more about this unique service and to discover how it can help you grow your business, send us
                            a message in the form below.</sub>
                        <form data-toggle="validator" role="form" method="POST" action="/_postFromContactForm" class="form-inline row m--4" id="contactForm">
                            {{csrf_field()}}
                            <div class="form-group has-feedback col-12 p--4 col-md-4 col-lg-4">
                                <div class="input-group">
                                    <input type="text" class="form-control"  name="first-name" id="inputFirstName" placeholder="First Name" data-minlength="3">
                                </div>
                            </div>
                            <div class="form-group has-feedback col-12 p--4 col-md-4 col-lg-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="last-name" id="inputLastName" placeholder="Last Name" data-minlength="3">
                                </div>
                            </div>
                            <div class="form-group has-feedback col-12 p--4 col-md-4 col-lg-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="company" id="inputCompany" placeholder="Company" data-minlength="3">
                                </div>
                            </div>
                            {{--<div class="form-group has-feedback col-12 p--4 col-md-4 col-lg-4">--}}
                                {{--<div class="input-group">--}}
                                    {{--<input type="email" class="form-control"  name="email" id="inputContactEmail" placeholder="Email" required>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group has-feedback col-12 p--4 col-md-4 col-lg-4">--}}
                                {{--<div class="input-group">--}}
                                    {{--<input type="tel" class="form-control" name="phone" id="inputPhone" placeholder="Phone">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group has-feedback col-12 p--4 col-md-4 col-lg-4">--}}
                                {{--<div class="input-group">--}}
                                    {{--<select class="form-control" name="department" id="selectDepartment" required style="height: inherit">--}}
                                        {{--<option value="" hidden>Department</option>--}}
                                        {{--<option value="1">General & Sales</option>--}}
                                        {{--<option value="2"> Editorial</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group has-feedback col-12 p--4 col-md-4 col-lg-4">
                                <div class="input-group">
                                    <input type="email" class="form-control"  name="email" id="inputContactEmail" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group has-feedback col-12 p--4 col-md-4 col-lg-4">
                                <div class="input-group">
                                    <input type="tel" class="form-control" name="phone" id="inputPhone" placeholder="Phone">
                                </div>
                            </div>
                            <div class="form-group has-feedback col-12 p--4 col-md-4 col-lg-4">
                                <div class="input-group">
                                    <select class="form-control" name="department" id="selectDepartment" style="height: inherit">
                                        <option value="1" hidden>Department</option>
                                        <option value="1">General & Sales</option>
                                        <option value="2"> Editorial</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group has-feedback col-12 p--4 col-md-12 col-lg-12">
                                <div class="input-group">
                                    <textarea class="form-control" id="textareaContactComments" name="content" placeholder="How can we help you?"></textarea>
                                </div>
                            </div>
                            <div class="form-group has-feedback col-12 p--4">
                                    {!! NoCaptcha::display() !!}
                            </div>
                            <div class="form-group col-12 p--4">
                                <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Send</button>
                            </div>
                        </form>
                        {!! NoCaptcha::renderJs() !!}
                    </div>
                    {{--<div class="col-12 col-md-4 col-lg-4">--}}
                        {{--<div class="contactBlock">--}}
                            {{--<img src="/images/svg/contact-metaball.svg" alt="contactMetaball" class="hidden-sm-down"/>--}}
                            {{--<h2>Other ways to contact us</h2>--}}
                            {{--<h3>Address</h3>--}}
                            {{--<address>Singel 542<br/>1017 AZ Los Angeles<br/>USA</address>--}}
                            {{--<address class="phone"><img src="/images/svg/ic_phone.svg" alt="phone"/>+31 20 489 5779</address>--}}
                            {{--<div class="socialBlock">--}}
                                {{--<a href="#"><img src="/images/svg/Facebook_Color.svg" /></a>--}}
                                {{--<a href="#"><img src="/images/svg/Twitter_Color.svg" /></a>--}}
                                {{--<a href="#"><img src="/images/svg/LinkedIN_Color.svg" /></a>--}}
                                {{--<a href="#"><img src="/images/svg/Youtube.svg" /></a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
@endsection
@if(session('successSendMessage'))

@section('jsscripts')
    <script>
        $(document).ready(function () {
            $('#FormModalSubscribeThanks').modal();
        })
    </script>
@endsection
@endif