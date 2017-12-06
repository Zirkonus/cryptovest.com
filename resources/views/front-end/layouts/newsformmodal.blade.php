<div id="newsFormModal" class="modal">
    <div class="container subscribeBlock upToDateForm popupForm">
        <div class="row">
            <div class="col-12">
                <h3 class="formTitle">Stay up to date with market trends and exclusive news!</h3>
                <form data-toggle="validator" role="form"  method="POST" action="//cryptovest.us16.list-manage.com/subscribe/post?u=d409eae0500b9a0f7813335a2&id=734bab7ff4" class="form-inline row" id="upToDateFormPopup" name="mc-embedded-subscribe-form" target=“_blank”>
                    <input type="hidden" name="categoryName" id="categoryName" value="news">
                    <div class="form-group has-feedback col-12">
                        <div class="input-group">
                            <span class="input-group-addon"><img src="{{asset('images/svg/person.svg')}}" /></span>
                            <input type="text" class="form-control" name="FNAME" id="inputNameModal" placeholder="Name" data-minlength="3" required>
                        </div>
                    </div>
                    <div class="form-group has-feedback col-12">
                        <div class="input-group">
                            <span class="input-group-addon"><img src="{{asset('images/svg/mail.svg')}}" /></span>
                            <input type="email" class="form-control" name="EMAIL" id="inputEmailmodal" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <input type="hidden" name="b_d409eae0500b9a0f7813335a2_734bab7ff4" tabindex="-1" value="">
                        @if(isset($post))
                        <button type="submit" class="btn btn-primary {{($post->getCategory->friendly_url == 'news' or $post->getCategory->parent_id == 2) ? "btn-news-sub": 'btn-reviews-sub'}}" value="Subscribe" name="subscribe">Subscribe</button>
                        @else
                        <button type="submit" class="btn btn-primary" value="Subscribe" name="subscribe">Subscribe</button>
                        @endif
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
                </div>
            </div>
        </div>
    </div>
</div>
