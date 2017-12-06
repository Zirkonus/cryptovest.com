@extends('layouts.main')

@section('title', $project->title . ' ICO Review - Cryptovest')
@section('body-class', 'mainPage')
@section('meta-tags')
    <meta name="description" content="{{$project->short_description}} ICO Review - Cryptovest">
@endsection

@section('styles-css')
<link rel="canonical" href="{{asset("/ico/$project->friendly_url")}}"/>
<style>
    .tab-link-site-st {
        padding-bottom: 10px;
    }
   .tab-link-site-st span img , td img{
       margin-right: 10px;
   }
</style>
@endsection
@section('content')
    @if ($project->data_end < date('Y-m-d', time()))
        <div class="main profile-page one-ico">
    @else
        <div class="main profile-page profile-2 one-ico">
    @endif
        <section class="page-navigation">
            <div class="container">
                <div class="row m--8">
                    <div class="col-lg-12">
                        <nav class="breadcrumb hidden-sm-down">
                            <a class="breadcrumb-item" href="/">home</a>
                            <a class="breadcrumb-item" href="/ico/">ICOs</a>
                            <span class="breadcrumb-item active"><a href="/ico/{{$project->friendly_url}}/" rel="canonical">{{$project->title}}</a></span>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

<!-- PROFILE CONTENT -->

        <section class="profile-content">

            <div class="container">
                <div class="row m--8">


                    <div class="col-lg-12 fixed-title right-sidebar">
                        <div class="col-lg-6">
                            <div class="ico-name">
                                <!-- @if (strlen($project->image) > 200)
                                    <img src="{!! $project->image !!}">
                                @else
                                    <img src="{{asset($project->image)}}">
                                @endif -->
                                <div class="smartre-text">
                                    @if (strlen($project->title) > 16)
                                        <span  style="font-size:26px;" class="token-sale">
                                    @else
                                        <span class="token-sale">
                                    @endif

                                    @if (strlen($project->image) > 200)
                                    <img src="{!! $project->image !!}">
                                @else
                                    <img src="{{asset($project->image)}}">
                                @endif

                                    {{$project->title}}

                                    @if($project->getPromotion->id != 10)
                                        <br class="mobile-break">
                                        <span class="image">
                                            <img src="{{asset($project->getPromotion->icon)}}">
                                        </span>
                                        @if($project->getPromotion->id < 3)
                                            <span class="featured">Featured</span></span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 fixed-sidebar right-sidebar">
                        <div class="sidebar-content">
                        @if ($project->data_end < date('Y-m-d', time()) && $project->data_start < date('Y-m-d', time()))
                            <div class="status-block">
                                <div class="status">
                                    <div class="disc"></div>
                                    <div class="title">
                                        <span class="status-title">Status</span><br>
                                        <span class="status-info">ICO is finished</span>
                                    </div>
                                </div>
                                <div class="raised">
                                    <div class="disc">$</div>
                                    <div class="title">
                                        <span class="status-title">Raised</span><br>
                                        @if($project->raised_field)
                                            <span class="status-info">{{$project->raised_field}}</span>
                                        @else
                                            <span class="status-info">Waiting for data</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    @if($project->link_but_explore_more)
                                        <a target="_blank" href="{{$project->link_but_explore_more}}" class="btn btn-primary">
                                    @else
                                        <a target="_blank" href="{{$project->link_website}}" class="btn btn-primary">
                                    @endif
                                        Explore More
                                    </a>
                                </div>
                            </div>
                        @elseif ($project->data_end > date('Y-m-d', time()) && $project->data_start > date('Y-m-d', time()))
                            {{--If in Future--}}
                            <div class="status-block">
                                <div class="status">
                                    <div class="disc"></div>
                                    <div class="title">
                                        <span class="status-title">Start date</span><br>
                                        <span class="status-info">{{date('F d, Y, HA', strtotime($project->data_start))}}</span>
                                    </div>
                                </div>
                                <div class="time-line"></div>
                                <div class="raised">
                                    <div class="disc"></div>
                                    @if ($project->is_fraud)
                                        <div class="title">
                                            <span class="status-title">Suspended</span><br>
                                        </div>
                                    @else
                                        <div class="title">
                                            <span class="status-title">Starts In</span><br>
                                        </div>
                                        <div class='countdown2' data-date="{{date('Y-m-d-H-i-s',strtotime($project->data_start))}}"></div>
                                    @endif
                                </div>
                                <div class="form-group col-12">
                                @if($project->presale_condition)
                                        @if($project->link_but_join_presale)
                                            <a target="_blank" href="{{$project->link_but_join_presale}}"  class="btn btn-primary">
                                        @else
                                            <a target="_blank" href="{{$project->link_website}}"  class="btn btn-primary">
                                        @endif
                                        Join Presale
                                    </a>
                                @else
                                    @if($project->link_but_explore_more)
                                        <a target="_blank" href="{{$project->link_but_explore_more}}" class="btn btn-primary">
                                    @else
                                        <a target="_blank" href="{{$project->link_website}}" class="btn btn-primary">
                                    @endif
                                        Explore More
                                    </a>
                                @endif
                                </div>
                            </div>
                        @elseif ($project->data_end > date('Y-m-d', time()) && $project->data_start < date('Y-m-d', time()))
                                {{--If going now--}}
                                <div class="status-block">
                                    <div class="status">
                                        <div class="disc"></div>
                                        <div class="title">
                                            <span class="status-title">Start date</span><br>
                                            <span class="status-info">{{date('F d, Y, HA',strtotime($project->data_start))}}</span>
                                        </div>
                                    </div>
                                    <div class="time-line"></div>
                                    <div class="raised">
                                        <div class="disc"></div>
                                        @if($project->is_fraud)
                                            <div class="title">
                                                <span class="status-title">Suspended</span><br>
                                            </div>
                                        @else
                                            <div class="title">
                                                <span class="status-title">End In</span><br>
                                            </div>
                                            <div class='countdown2' data-date="{{date('Y-m-d-H-i-s',strtotime($project->data_end))}}"></div>
                                        @endif
                                    </div>
                                    <div class="form-group col-12">
                                        @if($project->link_but_join_token_sale)
                                            <a target="_blank" href="{{$project->link_but_join_token_sale}}" class="btn btn-primary">
                                        @else
                                            <a target="_blank" href="{{$project->link_website}}" class="btn btn-primary">
                                        @endif
                                            Join Token Sale
                                        </a>
                                    </div>
                                </div>
                        @endif
                            <div class="information">
                                <table class="info-table">
                                    @if($project->link_website)
                                        <tr>
                                            <td class="td-title">Website:</td>
                                            <td><a href="{{$project->link_website}}" target="_blank">{{$project->link_website}}</a></td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="td-title" style="vertical-align: top">Links:</td>
                                        <td>
                                            @if($project->link_facebook)
                                                <div class="tab-link-site-st">
                                                    <span><a href="{{$project->link_facebook}}" target="_blank" rel="nofollow"><img src="{{asset('images/facebook1.png')}}">Facebook</a></span><br>
                                                </div>
                                            @endif
                                            @if($project->link_whitepaper)
                                                <div class="tab-link-site-st">
                                                    <span><a href="{{$project->link_whitepaper}}" target="_blank" rel="nofollow"><img src="{{asset('images/whitepaper.png')}}">White Paper</a></span><br>
                                                </div>
                                            @endif
                                            @if($project->link_telegram)
                                                <div class="tab-link-site-st">
                                                    <span><a href="{{$project->link_telegram}}" target="_blank" rel="nofollow"><img src="{{asset('images/telegram.png')}}">Telegram</a></span><br>
                                                </div>
                                            @endif
                                            @if($project->link_twitter)
                                                <div class="tab-link-site-st">
                                                    <span><a href="{{$project->link_twitter}}" target="_blank" rel="nofollow"><img src="{{asset('images/twitter1.png')}}">Twitter</a></span><br>
                                                </div>
                                            @endif
                                            @if($project->link_instagram)
                                                <div class="tab-link-site-st">
                                                    <span><a href="{{$project->link_instagram}}" target="_blank" rel="nofollow"><img src="{{asset('images/instagram.png')}}">Instagram</a></span><br>
                                                </div>
                                            @endif
                                            @if($project->link_youtube)
                                                <div class="tab-link-site-st">
                                                    <span><a href="{{$project->link_youtube}}" target="_blank" rel="nofollow"><img src="{{asset('images/Youtube.png')}}">Youtube</a></span><br>
                                                </div>
                                            @endif
                                            @if($project->link_linkedin)
                                                <div class="tab-link-site-st">
                                                    <span><a href="{{$project->link_linkedin}}" target="_blank" rel="nofollow"><img src="{{asset('images/LinkedIN_Color.png')}}">LinkedIn</a></span><br>
                                                </div>
                                            @endif
                                            @if($project->link_slack)
                                                <div class="tab-link-site-st">
                                                    <span><a href="{{$project->link_slack}}" target="_blank" rel="nofollow"><img src="{{asset('images/slack_47017.png')}}">Slack</a></span><br>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td-title">Project Type:</td>
                                        <td>{{$project->getProjectType->name or ""}}</td>
                                    </tr>
                                    <tr>
                                        <td class="td-title">Category:</td>
                                        <td>{{$project->getCategory->name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="td-title">Platform:</td>
                                        <td>
                                            @if($project->getPlatform->icon)
                                                <img src="{{asset($project->getPlatform->icon)}}">
                                            @endif
                                            {{$project->getPlatform->name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td-title">Total Supply:</td>
                                        <td>{{$project->total_supply}}</td>
                                    </tr>
                                    <tr>
                                        <td class="td-title">Accepted currencies:</td>
                                        <td>
                                            @if($project->getMoney)
                                                @foreach($project->getMoney as $money)
                                                    <span><img src="{{asset($money->icon)}}">{{$money->name}}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-8 main-content">
                        <div class="description">
                            <h1 class="titleBlock one-ico-title">{{$project->title .' ICO Review'}}</h1>
                            <p>
                                {{$project->short_description}}
                            </p>
                        </div>
                        <div class="team">
                            <h2 class="titleBlock">{{$project->title}} Team</h2>
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Links</th>
                                </tr>
                                @if($project->getMembers)
                                    @foreach($project->getMembers as $mem)
                                        <tr>
                                            <td class="td-title">{{$mem->first_name}} {{$mem->last_name}}</td>
                                            <td>{{$mem->position}}</td>
                                            <td>
                                                @if($mem->linkedin_link)
                                                    <span><a href="{{$mem->linkedin_link}}" target="_blank" rel="nofollow"><img src="{{asset('images/linkedin.png')}}"></a></span>
                                                @endif
                                                @if($mem->twitter_link)
                                                    <span><a href="{{$mem->twitter_link}}" target="_blank" rel="nofollow"><img src="{{asset('images/twitter1.png')}}"></a></span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>

                        <div class="related-projects">
                            <h2 class="titleBlock">Related Projects</h2>
                            @foreach($relProjects as $p)
                                <div class="col-lg-4 col-sm-12 project">
                                    <div class="project-item">
                                        <span class="project-image">
                                            @if(strlen($p->image) > 200)
                                                <img src="{!! $p->image !!}"></span>
                                            @else
                                                <img src="{{asset($p->image)}}"></span>
                                            @endif
                                        <span class="project-text"><a href="/ico/{{$p->friendly_url}}/" rel="canonical">{{$p->title}}</a></span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="comments">
                            <div class="articleFooter">
                                <div class="commentsBlock" id="commentsBlock">
                                    <div class="titleCommentsBlock" style="font-size: 24px;">Comments</div>
                                    <div class="commentsForm">
                                        <form data-toggle="validator" action="/_addICOComment" method="POST" role="form" class="form-inline row m--8" id="commentsForm">
                                            {{csrf_field()}}
                                            <div class="form-group has-feedback col-12 col-md-6 col-lg-6 p--8">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><img src="{{asset('images/svg/person.svg')}}" /></span>
                                                    <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Name" data-minlength="3" required>
                                                </div>
                                                <input type="hidden" name="ico_id" id="ico_id_for_comment" value="{{$project->id}}">
                                            </div>
                                            <div class="form-group has-feedback col-12 col-md-6 col-lg-6 p--8">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><img src="{{asset('images/svg/mail.svg')}}" /></span>
                                                    <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="Email" required>
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback col-12 p--8 col-md-12 col-lg-12">
                                                <div class="input-group">
                                                    <textarea class="form-control" name="textareaComments" ib="textareaComments" placeholder="Add comment"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback col-12 p--4" style="text-align: -webkit-right;">
                                                {!! NoCaptcha::display() !!}
                                            </div>
                                            <div class="col-12 p--8">
                                                <button type="submit" class="btn btn-primary col-12 col-md-4 col-lg-4 pull-right" style="margin-top: 15px;">Add comment</button>
                                            </div>
                                        </form>
                                        {!! NoCaptcha::renderJs() !!}
                                    </div>
                                    <div class="commentsList">
                                        <div class="row">
                                            <div class="col-12">
                                                @foreach($comments as $com)
                                                    @if($com->status_id == 2)
                                                        <div class="commentsItem br-4">
                                                            <div class="itemName">{{$com->writer_name}}</div>
                                                            <div class="itemDate">{{date('H:m', strtotime(time() - strtotime($com->created_at)))}} ago</div>
                                                            <div class="itemDescription">{{$com->content}}</div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </section>
    </div>
@endsection
@section('newsFormModal')
    @include('front-end.layouts.newsformmodal')
@endsection

@section('joinFormModalButton')
    @include('front-end.layouts.joinformbutton')
@endsection
@section('jsscripts')
    <script src="{{asset('js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.main-list').DataTable();
        } );
    </script>
@endsection
