@extends('layouts.main')

@section('title', 'ICOs - Cryptovest')
@section('body-class', 'mainPage')
@section('meta-tags')
    <meta name="description" content="Cryptovest - ICOs.">
@endsection
@section('styles-css')
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/datepicker.css')}}">
    <input type="hidden" id="token" data="{{csrf_token()}}">
@endsection
@section('content')
<div id = 'loadingDiv'><img class="preloader" src="{{asset('/images/svg/metaball-subscriptions.svg')}}" alt=""></div>
    <div class="main icos-submit">

        <div class="container topBlock">
            <div class="row m--8">
                <div class="col-12 p--8 col-md-12 col-lg-12">
                    <h2 class="titleBlock">ICO Submission Form</h2>
                </div>
            </div>
            <div class="row m--8">
                <div class="p--8 col-md-10 col-lg-10 wizard-block">
                    <ol class="wizard">
                        <li class="active-step"><span class="step">1</span><span class="step-text">Registration</span>
                        </li>
                        <li><span class="step">2</span><span class="step-text">ICO Information</span></li>
                        <li><span class="step">3</span><span class="step-text">Project Team</span></li>
                        <li><span class="step">4</span><span class="step-text">Payment</span></li>
                        <li><span class="step">5</span><span class="step-text">Confirmation</span></li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="container newsParentBlock middleInfoBlock">
            <div class="row m--8">
                <!-- register block -->
                <div class="col-lg-12 register-block hide-this-submit-block active-block">
                    <div class="p--8 col-md-12 col-lg-12 wizard-block mobile-wizard">
                        <ol class="wizard">
                            <li class="active-step"><span class="step">1</span><span
                                        class="step-text">Registration</span></li>
                            <li><span class="step">2</span><span class="step-text">ICO Information</span></li>
                            <li><span class="step">3</span><span class="step-text">Project Team</span></li>
                            <li style="display: none;"><span class="step">4</span><span class="step-text">Payment</span>
                            </li>
                            <li style="display: none;"><span class="step">5</span><span
                                        class="step-text">Confirmation</span></li>
                        </ol>
                    </div>
                    <h3 class="block-title">Register To Continue</h3>
                    <div class="row">
                        <form data-toggle="validator" role="form" class="form-inline" id="register-form">
                            <div class="col-lg-8 inputs-wraper">
                                <!-- <form data-toggle="validator" role="form" class="form-inline" id="register-form"> -->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="input-group">
                                            <input type="text" name='name' class="form-control" id="yourName"
                                                   placeholder="Your Name *" data-minlength="3" required>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name='companyname' class="form-control" id="companyName"
                                                   placeholder="Company">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="input-group">
                                            <input type="mail" name='email' class="form-control" id="yourMail"
                                                   placeholder="Email *"
                                                   data-minlength="3" required>
                                        </div>
                                        <div class="input-group">
                                            <input type="tel" name='mobile' class="form-control" id="yourPhone"
                                                   placeholder="Mobile"
                                                   data-minlength="3">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 button-wrapper">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 button-block">
                                                <a class="btn btn-primary" href="{{ route('ico') }}">Cancel</a>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6 button-block">
                                                <button class="btn btn-primary next-btn" type='submit' id='firstTab'>
                                                    Next
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  </form> -->
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ico-information block -->
                <div class="col-lg-12 ico-information-block hide-this-submit-block">
                    <div class="p--8 col-md-12 col-lg-12 wizard-block mobile-wizard">
                        <ol class="wizard">
                            <li class="active-step"><span class="step">1</span><span
                                        class="step-text">Registration</span></li>
                            <li><span class="step">2</span><span class="step-text">ICO Information</span></li>
                            <li><span class="step">3</span><span class="step-text">Project Team</span></li>
                            <li style="display: none;"><span class="step">4</span><span class="step-text">Payment</span>
                            </li>
                            <li style="display: none;"><span class="step">5</span><span
                                        class="step-text">Confirmation</span></li>
                        </ol>
                    </div>
                    <h3 class="block-title">Write your ICO information</h3>
                    <div class="row">
                        <form data-toggle="validator" role="form" class="form-inline" id="ico-information">
                            <div class="col-lg-8 inputs-wraper">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name='iconame' id="icoName"
                                                   placeholder="ICO name">
                                        </div>
                                        <div class="input-group">
                                            <textarea class="form-control" name='description' id="description"
                                                      placeholder="Description"></textarea>
                                        </div>
                                        <div class="input-group add-file-block">
                                            <label for="informationFile">
                                                <div class="dotted-squere">
                                                    <span class="fa fa-cloud-upload"></span>
                                                    <span class="upload-text">Upload your logo</span>
                                                </div>
                                            </label>
                                            <input type="file" name='icoavatar' id='informationFile'>
                                        </div>
                                    </div>
                                    <!-- right block -->
                                    <div class="col-lg-6 col-md-6 col-sm-12 right-block">
                                        <div class="input-group">
                                            <select class="form-control" name='industry' name="selectIndustry"
                                                    id="selectIndustry"
                                                    style="height: inherit">
                                                <option value="" hidden="">Industry *</option>
                                                <option value="null">My industry</option>
                                                @foreach($category as $cat)
                                                    <option data-other="{{ $cat->is_other ? "other" : ""}}" value="{{ $cat->id }}">{{$cat->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group my-industry" style="display: none">
                                            <input type="text" class="form-control" id="myIndustry" placeholder="Input Your Industry">
                                        </div>
                                        <div class="input-group">
                                            <select class="form-control" name="selectPlatform" id="selectPlatform"
                                                    style="height: inherit">
                                                <option value="" hidden="">Platform *</option>
                                                <option value="null">My platform</option>
                                                @foreach($platforms as $pl)
                                                    <option data-other="{{ $pl->is_other ? "other" : ""}}" value="{{$pl->id}}">{{$pl->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group my-platform" style="display: none">
                                            <input type="text" class="form-control" id="myPlatform" placeholder="Input Your Platform">
                                        </div>
                                        <div class="input-group">
                                            <select class="form-control" name="selectCoinName" id="selectCoinName" style="height: inherit">
                                                <option value="" hidden="">Accepted Currency</option>
                                                @foreach($money as $key => $m)
                                                    <option value="{{$key}}">{{$m}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="shortCoinName"
                                                   placeholder="Short Token/Coin Name">
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name='totalsupply' class="form-control" id="totalSupply"
                                                   placeholder="Total Supply">
                                        </div>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name='numberofcoin'
                                                   id="numberOfCoins"
                                                   placeholder="Number of coins available for crowdsale">
                                        </div>
                                        <!-- <div class="input-group">
                                            <input type="text" class="form-control datepicker" placeholder="Presale Date" id="presaleDate">
                                        </div> -->
                                        <div class="input-group">
                                            <input type="text" name="startdate" class="form-control datepicker"
                                                   placeholder="Start Date"
                                                   id="startDate">
                                            <!-- <span class="fa fa-calendar calendar-on-input"></span> -->
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name='enddate' class="form-control datepicker"
                                                   placeholder="End Date"
                                                   id="endDate">
                                            <!-- <span class="fa fa-calendar calendar-on-input"></span> -->
                                        </div>
                                    </div>
                                </div>
                                <h3 class="block-title">ICO links</h3>

                                <div class="col-lg-12 button-wrapper">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="input-group">
                                                <input type="text" name="website" class="form-control" id="website"
                                                       placeholder="Website">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="input-group">
                                                <input type="text" name="whitepaper" class="form-control" id="whitepaper"
                                                       placeholder="Whitepaper">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h3 class="block-title">ICO socials</h3>

                                <div class="col-lg-12 button-wrapper">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-3-wraper">
                                            <div class="input-group">
                                                <select class="form-control" name="department" id="social" style="height: inherit">
                                                    <option value="facebook">Facebook</option>
                                                    <option value="twitter">Twitter</option>
                                                    <option value="slack">Slack Link</option>
                                                    <option value="instagram">Instagram</option>
                                                    <option value="telegram">Telegram</option>
                                                    <option value="linkedin">LinkedIN</option>
                                                    <option value="youtube">YouTube</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="socialLink"
                                                       placeholder="Link">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-3-wraper">
                                            <div class="input-group">
                                                <button class="btn btn-primary add-link" id="addLinkButton">Add social
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="social-links-list" id='socialsLinksList'>
                                    </ul>
                                </div>

                                <div class="col-lg-12 button-wrapper">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 button-block">
                                            <a class="btn btn-primary previous-tab">Back</a>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6 button-block">
                                            <button class="btn btn-primary next-btn" type='submit' id='secondTab'>Next
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- project team block -->
                <div class="col-lg-12 project-team-block hide-this-submit-block">
                    <div class="p--8 col-md-12 col-lg-12 wizard-block mobile-wizard">
                        <ol class="wizard">
                            <li class="active-step" style="display: none;"><span class="step">1</span><span
                                        class="step-text">Registration</span></li>
                            <li><span class="step">2</span><span class="step-text">ICO Information</span></li>
                            <li><span class="step">3</span><span class="step-text">Project Team</span></li>
                            <li><span class="step">4</span><span class="step-text">Payment</span></li>
                            <li style="display: none;"><span class="step">5</span><span
                                        class="step-text">Confirmation</span></li>
                        </ol>
                    </div>
                    <h3 class="block-title">Add Your Team Members Here</h3>
                    <div class="row">
                        <form data-toggle="validator" role="form" class="form-inline" id="team-form">
                            <div class="col-lg-8 inputs-wraper">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="memberFullName"
                                                   placeholder="Full Name" data-minlength="3" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="memberPosition"
                                                   placeholder="Position" data-minlength="3" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 button-wrapper">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-3-wraper">
                                            <div class="input-group">
                                                <select class="form-control" name="department" id="memberSocial"
                                                        required="" style="height: inherit">
                                                    <option value="twitter">Twitter</option>
                                                    <option value="linkedin">Linkedin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="memberSocialLink"
                                                       placeholder="Link" data-minlength="3" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-3-wraper">
                                            <div class="input-group">
                                                <button class="btn btn-primary add-link" id="addMemberLinkButton">Add
                                                    social
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="social-links-list" id='memberSocialList'>
                                    </ul>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <button class="btn btn-primary add-member-button" id='addMember'>Add member
                                        </button>
                                    </div>

                                    <table class="members-table-list">
                                        <thead>
                                        <tr>
                                            <th>NAME</th>
                                            <th>POSITION</th>
                                            <th>LINKS</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                        </thead>
                                        <tbody id='memberTableList'>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-12 button-wrapper">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 button-block">
                                            <button class="btn btn-primary previous-tab">Back</button>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6 button-block">
                                            <button type="submit" class="btn btn-primary next-btn" id="thirdTab">Next
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- payment block -->
                <div class="col-lg-12 payment-block hide-this-submit-block">
                    <div class="p--8 col-md-12 col-lg-12 wizard-block mobile-wizard">
                        <ol class="wizard">
                            <li class="active-step" style="display: none;"><span class="step">1</span><span
                                        class="step-text">Registration</span></li>
                            <li style="display: none;"><span class="step">2</span><span class="step-text">ICO Information</span>
                            </li>
                            <li><span class="step">3</span><span class="step-text">Project Team</span></li>
                            <li><span class="step">4</span><span class="step-text">Payment</span></li>
                            <li><span class="step">5</span><span class="step-text">Confirmation</span></li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 inputs-wraper">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 payment-left">
                                    <h3 class="block-title">Select Payment Option</h3>
                                    <div class="checkboxes">
                                        <div class="radio-wrapper">
                                            <input type="radio" id="bitcoinPay" name="paymentType" value="bitcoin"
                                                   checked="">
                                            <label for="bitcoinPay">
                                                <span class="fa fa-btc"></span>
                                                <span class="first-coin-name">Bitcoin</span>
                                            </label>
                                        </div>
                                        <div class="radio-wrapper">
                                            <input type="radio" id="ethereumPay" name="paymentType"
                                                   value="ethereum">
                                            <label for="ethereumPay">
                                                    <span class="radio-img">
                                                        <svg version="1.0"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             width="20.000000pt"
                                                             height="24.000000pt"
                                                             viewBox="0 0 20.000000 24.000000"
                                                             preserveAspectRatio="xMidYMid meet">
                                                            <g transform="translate(0.000000,24.000000) scale(0.100000,-0.100000)"
                                                               stroke="none">
                                                            <path d="M72 152 l-22 -39 26 -12 c14 -6 31 -8 37 -5 9 5 9 4 1 -5 -9 -10 -17
                                                            -10 -34 -1 l-22 12 18 -26 c23 -31 33 -29 57 11 17 30 17 32 -4 67 -11 20 -24
                                                            36 -28 36 -4 0 -17 -17 -29 -38z"/>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                <span class="second-coin-name">Ethereum</span>
                                            </label>
                                        </div>
                                    </div>
                                    <h3 class="block-title">Add Options To have a Promotion</h3>
                                    <div class="change-medal">
                                        <div for = 'silverMedal' class="medal col-lg-6 medal-silver">
                                            <span class="check fa fa-check-circle check-silver"></span>
                                            <img src="{{asset('images/silver.jpg')}}">
                                            <h3>Silver</h3>
                                            <span class="price"><span class="price-value"></span><span class="btc"> DTC</span></span>
                                            <hr>
                                            <p>Silver medal includes a high priority on the index and a Newsletter announcement. </p>
                                        </div>
                                        <div class="medal col-lg-6 medal-gold">
                                            <span class="check fa fa-check-circle check-gold"></span>
                                            <img src="{{asset('images/gold.png')}}">
                                            <h3>Gold</h3>
                                            {{-- need to dynamic choose a type--}}
                                            <span class="price"><span class="price-value"></span><span class="btc">BTC</span></span>
                                            <hr>
                                            <p>The gold medal has the highest priority, 2 news announcements, and a newsletter promotion.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 payment-right">
                                    <div class="order-summary">
                                        <span class="summary-title">Order summary</span>
                                        <ol class="summary-list main-summary-list">
                                            {{-- need to dynamic choose a type--}}
                                            <li><span class="summary-text ">ICO Basic Listing +
                                                News Announcement</span><span class="item-price basic-listing"></span></li>
                                        </ol>
                                        <ul class="summary-list total-price">
                                            <li><span class="summary-text">Total</span><span class="item-price"></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-12 col-md-12 col-sm-12 button-block agree-block">
                                    <input type="checkbox" id="agree" name="iagree" value="agree">
                                    <label for="agree">I agree with the <a href="">terms and conditions * </a></label>
                                </div> -->
                            </div>
                            <div class="col-lg-12 button-wrapper bottom-buttons">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 button-block">
                                        <button class="btn btn-primary previous-tab">Back</button>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 button-block">
                                        <button class="btn btn-primary next-btn" id = 'fourTab'>Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- confirmation block -->
                <div class="col-lg-12 confirmation-block hide-this-submit-block">
                    <div class="p--8 col-md-12 col-lg-12 wizard-block mobile-wizard">
                        <ol class="wizard">
                            <li class="active-step" style="display: none;"><span class="step">1</span><span
                                        class="step-text">Registration</span></li>
                            <li style="display: none;"><span class="step">2</span><span class="step-text">ICO Information</span>
                            </li>
                            <li><span class="step">3</span><span class="step-text">Project Team</span></li>
                            <li><span class="step">4</span><span class="step-text">Payment</span></li>
                            <li><span class="step">5</span><span class="step-text">Confirmation</span></li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 inputs-wraper">
                            <h3 class="block-title">You Are Almost Done. </h3>
                            <div class="col-lg-12 button-wrapper">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 button-block confirmation-wrapper">
                                        <h2 class="payment-link"></h2>
                                        <div class="confirmation-info">To complete the listing, please transfer <span class="total-price-confirm">0.001 BTC</span><br>
                                        to the below address and upload the confirmation screenshot.</div>
                                    </div>
                                    <div class="copy-link-block col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <input type="text" id="paymentLinkInput" class="col-lg-10">
                                            <button class="btn btn-primary col-lg-1" id = 'copyLink'>Copy</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 important-information">
                                        <span class="fa fa-exclamation-triangle"></span>
                                            <span class="important-text">IMPORTANT: Send only BTC to this deposit address.<br>
                                            Sending any other currency to this address may result in the loss of your deposit.</span>
                                    </div>
                                </div>
                                <div class="upload-screenshot">
                                    <label for="uploadScreen">Upload Confirmation Screenshot</label>
                                    <input type="file" name = 'screenshot' id="uploadScreen">
                                </div>
                                <div class="file-info" style="display: none;">
                                    <span class="clip fa fa-paperclip"></span>
                                    <span class="file-name"></span>
                                    <span class="delete-file fa fa-times"></span>
                                </div>
                            </div>
                            <div class="col-lg-12 button-wrapper bottom-buttons">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 button-block">
                                        <button class="btn btn-primary previous-tab">Back</button>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 button-block">
                                        <button class="btn btn-primary next-btn" id = 'fifthTab'>Confirm</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- finish confirmation block -->
                <div class="col-lg-12 finish-confirmation-block hide-this-submit-block">
                    <div class="p--8 col-md-12 col-lg-12 wizard-block mobile-wizard">
                        <ol class="wizard">
                            <li class="active-step" style="display: none;"><span class="step">1</span><span
                                        class="step-text">Registration</span></li>
                            <li style="display: none;"><span class="step">2</span><span class="step-text">ICO Information</span>
                            </li>
                            <li><span class="step">3</span><span class="step-text">Project Team</span></li>
                            <li><span class="step">4</span><span class="step-text">Payment</span></li>
                            <li><span class="step">5</span><span class="step-text">Confirmation</span></li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 inputs-wraper">
                            <h3 class="block-title">Thank you !</h3>
                            <div class="col-lg-12 button-wrapper">
                                <div class="row">
                                    <div class="col-lg-10 col-md-10 col-sm-12 button-block confirmation-wrapper">
                                        <div class="confirmation-info">An order summary email has been sent to you. <br><br>
                                        Once the transaction is confirmed, our team will review<br> the listing and publish it.<br><br>
                                        For any questions, please <a href="{{ route('contact') }}">contact us</a>.</div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-lg-12 button-wrapper">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 button-block">
                                        <a class="btn btn-primary redirect-home-page" href="{{ route('home') }}">Home</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('newsFormModal')
    @include('front-end.layouts.newsformmodal')
@endsection

@section('joinFormModalButton')
    @include('front-end.layouts.joinformbutton')
@endsection
@section('jsscripts')
    <script>
        var public_path = "{{ URL::to('/') }}";
    </script>
    <script src="{{asset('js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/additional-methods.min.js')}}"></script>
    <script src="{{asset('js/scripts.js')}}"></script>
   <!--  <script src='https://www.google.com/recaptcha/api.js'></script> -->
    <script src="{{asset('js/ico-submit.js')}}"></script>

    <script type="text/javascript">
        $('.datepicker').datepicker();
    </script>
@endsection
