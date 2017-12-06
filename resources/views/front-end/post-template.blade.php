
@php
    $path = "";
    if ($post['getCategory']->full_url) {
    $path .= "/{$post['getCategory']->full_url}";
    }
    $path .= "/{$post['getCategory']->friendly_url}/{$post->friendly_url}/";
    $path = preg_replace('|([/]+)|s', '/', $path);
@endphp
<!-- <div class="container mainArticleBlock"> -->
    <div class="row post-content-wrapper" data-post="{{ $post->id }}" data-category="{{ $post->getCategory->id }}"
     data-url="{{ $path }}" style="margin-top: 100px">
                    <div class="col-12 col-md-12 col-lg-8 articleBlock">
                        <div class="articleHeader">
                            <h1>{{Translate::getValue($post->title_lang_key)}}</h1>
                            <sub>{{Translate::getValue($post->description_lang_key)}}</sub>
                            <div class="authorInfoBlock clearfix">
                                <div class="pull-left">
                                    <a href="/author/{{$post->getAuthor->url}}/"><img src="{{asset($post->getAuthor->profile_image)}}" alt="author" class="authorAvatar"/></a>
                                    <span class="separator">by </span>
                                    <span class="authorName"><a href="/author/{{$post->getAuthor->url}}/">{{Translate::getValue($post->getAuthor->first_name_lang_key)}} {{Translate::getValue($post->getAuthor->last_name_lang_key)}}</a></span>
                                    <span class="authorTime"> , {{date('d F', strtotime($post->created_at))}}</span>
                                </div>
                                <div class="pull-right">
                                    {{--<span class="shareTotal"><img src="{{asset('images/svg/shareNw.svg')}}" class="shareImg">12</span>--}}
                                    {{--<span class="msgTotal"><a href="#commentsBlock"><img src="{{asset('images/svg/comments.svg')}}" class="shareImg"><span>{{count($comments)}}</span></a></span>--}}
                                </div>
                            </div>
                        </div>
                        <div class="articleBody" id="articleBody">
                            <!-- <div class="leftFixButton" id="leftFixButton">
                                <div class="buttonBlock" style="z-index: 9999">
                                    <a href="#articleBody" class="hidden-md-up"><img src="{{asset('images/svg/ontop.svg')}}"></a>
                                    <a data-network="twitter" class="st-custom-button" style="cursor: pointer;" target="_blank" ><img src="{{asset('images/svg/Twitter_Color.svg')}}"></a>
                                    <a data-network="facebook" class="st-custom-button" style="cursor: pointer;" target="_blank"><img src="{{asset('images/svg/Facebook_Color.svg')}}"></a>
                                    <a class="st-custom-button" style="cursor: pointer;" data-network="linkedin" target="_blank" ><img src="{{asset('images/svg/LinkedIN_Color.svg')}}"></a>
                                    <a class="st-custom-button" style="cursor: pointer;" data-network="reddit" target="_blank" ><img src="{{asset('images/svg/reddit.svg')}}"></a>
                                    <a href="#articleBody" class="hidden-sm-down"><img src="{{asset('images/svg/ontop.svg')}}"></a>

                                    <button type="button" class="btn btn-primary hidden-md-up br-4" data-toggle="modal" data-target="#newsFormModal">Subscribe</button>
                                </div>
                            </div> -->
                            @if(!$post->hide_image)
                            <img src="{{asset($post->title_image)}}" style="margin-bottom: 35px" alt="articleStartImage" class="arcticle-start-img" />
                            @endif
                            {!! Translate::getValue($post->content_lang_key) !!}

                        </div>
                        @if(!empty($post->tags->toArray()))
                        <!-- article  tags block-->
                        <div class="article-tags-separator clearfix"></div>
                        <div class="article-tags">
                            <div class="tags-title only-tags">Tags</div>
                            @foreach($post->tags as $tag)
                            <span class="tag-element">
                                <a href="/tag/{{$tag->slug}}/" class="tag-href">{{$tag->name}}</a>
                            </span>
                            @endforeach
                        </div>
                        @endif
                        @if(!empty($post->executives->toArray()))
                        <div class="article-tags">
                            <div class="tags-title only-executive">Executives</div>
                            <div class="executives-wraper">
                                @foreach($post->executives as $executive)
                                <span class="executives-element"><img src="{{asset($executive->profile_image)}}"><a class="executive-name" href = '{!! route("executive-one", ['url' => $executive->url]) . "/" !!}'>{{Translate::getValue($executive->first_name_lang_key) . " " . Translate::getValue($executive->last_name_lang_key)}}</a></span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 articleSidebar">
                        <!-- <div class="sideForm br-4">
                            <h2 class="formTitle col-12">
                                Stay up to date with market trends and exclusive news!
                                <img src="{{asset('images/svg/metaball-subscriptions.svg')}}" alt="metaball"/>
                            </h2>
                            <form data-toggle="validator" method="POST" action="//cryptovest.us16.list-manage.com/subscribe/post?u=d409eae0500b9a0f7813335a2&id=734bab7ff4" role="form" class="form-inline" id="sideFormBannerBlock" name="mc-embedded-subscribe-form" target="_blank">
                                <input type="hidden" id="CategoryName" name="categoryName" value="{{$post->getCategory->friendly_url}}">
                                <div class="form-group has-feedback col-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><img src="{{asset('images/svg/person.svg')}}" /></span>
                                        <input type="text" class="form-control" name="FNAME" id="inputNameUp" placeholder="Name" data-minlength="3" required>
                                    </div>
                                </div>
                                <div class="form-group has-feedback col-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><img src="{{asset('images/svg/mail.svg')}}" /></span>
                                        <input type="email" class="form-control" name="EMAIL" id="inputEmailUp" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <input type="hidden" name="b_d409eae0500b9a0f7813335a2_734bab7ff4" tabindex="-1" value="">
                                    <button type="submit" class="btn btn-primary {{($post->getCategory->friendly_url == 'news' or $post->getCategory->parent_id == 2) ? "btn-news-sub": 'btn-reviews-sub'}}" value="Subscribe" name="subscribe">Subscribe</button>
                                </div>
                            </form>
                        </div> -->

                        @foreach($otherPosts as $lat)
                        @endforeach
                        <div class="sideForm br-4 fadeUpDowpForm hidden-md-down">
                            <h2 class="formTitle col-12">
                                Stay up to date with market trends and exclusive news!
                                <img src="{{asset('images/svg/metaball-subscriptions.svg')}}" alt="metaball"/>
                            </h2>
                            <form data-toggle="validator" action="//cryptovest.us16.list-manage.com/subscribe/post?u=d409eae0500b9a0f7813335a2&id=734bab7ff4" method="POST" role="form" class="form-inline" id="slideSideFormBannerBlock" name="mc-embedded-subscribe-form" target="_blank">
                                {{csrf_field()}}
                                <input type="hidden" name="categoryName" id="categoryName" value="{{$lat->getCategory->friendly_url}}">
                                <div class="form-group has-feedback col-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><img src="{{asset('images/svg/person.svg')}}" /></span>
                                        <input type="text" class="form-control" name="FNAME" id="inputNameUpSlide" placeholder="Name" data-minlength="3" required>
                                    </div>
                                </div>
                                <div class="form-group has-feedback col-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><img src="{{asset('images/svg/mail.svg')}}" /></span>
                                        <input type="email" class="form-control" name="EMAIL" id="inputEmailUpSlide" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <input type="hidden" name="b_d409eae0500b9a0f7813335a2_734bab7ff4" tabindex="-1" value="">
                                    <button type="submit" class="btn btn-primary {{($post->getCategory->friendly_url == 'news' or $post->getCategory->parent_id == 2) ? "btn-news-sub": 'btn-reviews-sub'}}" value="Subscribe" name="subscribe">Subscribe</button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <!-- test blocks -->
                        <div class="col-12 smallBlocks you-like-block p--8">
                            <div class="titleCommentsBlock">Read next</div>
                            <div class="row m--8">
                                @foreach($likesPost as $postLike)
                                    <div class="col-12 p--8 col-md-6 col-lg-4 you-like-element">
                                        <div class="smallBlock br-4 maskShadow">
                                            @php
                                                $path = "";
                                                if ($postLike['getCategory']->full_url) {
                                                $path .= "/{$postLike['getCategory']->full_url}";
                                                }
                                                $path .= "/{$postLike['getCategory']->friendly_url}/{$postLike->friendly_url}/";
                                                $path = preg_replace('|([/]+)|s', '/', $path);
                                            @endphp
                                            <a href="{{ $path }}" class="noMaskImg">
                                            <img src="{{asset($postLike->title_image)}}" alt="news3-q"  class="pull-left"/></a>
                                            <div class="titleLinkBlock">
                                            <div class="titleBlock">
                                            <a href="{{ $path }}">{{str_limit(Translate::getValue($postLike->title_lang_key), $limit = 80, $end = '...')}}</a>
                                            </div>
                                            <div class="bottomInform">
                                                <div class="pull-left">
                                                    <span class="dateBlock">{{date('d F', strtotime($postLike->created_at))}}</span>
                                                    <span class="separator"> / by </span>
                                                    <span class="authorName"><a href="/author/{{$postLike->getAuthor->url}}/">{{Translate::getValue($postLike->getAuthor->first_name_lang_key)}} {{Translate::getValue($postLike->getAuthor->last_name_lang_key)}}</a></span>
                                                </div>
                                                <div class="pull-right">
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>                        
                        <!-- end test blocks -->
                        <div class="col-12 col-md-12 col-lg-8 articleBlock">
                        <div class="open-comments">
                            @php($countComments = $post->getComments->where('status_id', 2)->count())

                             <button class="btn open-comments-btn btn-primary col-12 col-md-4 col-lg-4 pull-right" id = 'openComments' data-count = '{{$countComments}}'>Comments ({{$countComments}})</button>
                        </div>
                            <div class="articleFooter" style="display: none;">
                            <div class="commentsBlock" id="commentsBlock">
                                <div class="titleCommentsBlock">comments</div>
                                <div class="commentsForm">
                                    <form data-toggle="validator" action="/_getNewComment" method="POST" role="form" class="form-inline row m--8" id="commentsForm">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="postId" id="postId" value="{{$post->id}}">
                                        <div class="form-group has-feedback col-12 col-md-6 col-lg-6 p--8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><img src="{{asset('images/svg/person.svg')}}" /></span>
                                                <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Name" data-minlength="3" required>
                                            </div>
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
                                        <div class="col-12 p--8 pull-right" style="text-align: -webkit-right;">
                                            {!! NoCaptcha::display() !!}
                                        </div>
                                        <div class="col-12 p--8">
                                            <button class="btn btn-primary col-12 col-md-4 col-lg-4 pull-right" style="margin-top: 15px;">Add comment</button>
                                        </div>
                                    </form>
                                    {!! NoCaptcha::renderJs() !!}
                                </div>
                                <div class="commentsList">
                                    <div class="row">
                                        <div class="col-12">
                                            @if ($post->getComments)
                                                @foreach($post->getComments as $comment)
                                                    @if($comment->status_id == 2)
                                                        <div class="commentsItem br-4">
                                                            <div class="itemName">{{$comment->writer_name}}</div>
                                                                <div class="itemDate">{{date('H:m', strtotime(time() - strtotime($comment->created_at)))}} ago</div>
                                                                <div class="itemDescription">{{$comment->content}}</div>
                                                                {{--<div class="itemDate">{{date('H:m', strtotime(time() - strtotime($comment->created_at)))}} ago</div>--}}
                                                                {{--<div class="itemDescription"><h5>Thanks, your comment sent to approval!</h5></div>--}}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!-- </div> -->




