@push('head_links')
<style>
    .subscribe-cat-checkbox {
        margin-bottom: 25px;
        font-size: 20px;
    }
    .subscribe-cat-checkbox [type="checkbox"]:checked,
    .subscribe-cat-checkbox [type="checkbox"]:not(:checked) {
        position: absolute;
        left: -9999px;
    }
    .subscribe-cat-checkbox [type="checkbox"]:checked + label,
    .subscribe-cat-checkbox [type="checkbox"]:not(:checked) + label
    {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #666;
    }
    .subscribe-cat-checkbox [type="checkbox"]:checked + label:before,
    .subscribe-cat-checkbox [type="checkbox"]:not(:checked) + label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 18px;
        height: 18px;
        border: 1px solid #ddd;
        background: #fff;
    }
    .subscribe-cat-checkbox [type="checkbox"]:checked + label:after,
    .subscribe-cat-checkbox [type="checkbox"]:not(:checked) + label:after {
        content: '';
        width: 12px;
        height: 12px;
        background-image: linear-gradient(218deg, #ff7e2b, #fbb848);
        position: absolute;
        top: 3px;
        left: 3.9px;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
    }
    .subscribe-cat-checkbox [type="checkbox"]:not(:checked) + label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        transform: scale(0);
    }
    .subscribe-cat-checkbox [type="checkbox"]:checked + label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }
</style>
@endpush
<div id="secondStepModal" class="modal">
    <div class="container subscribeBlock upToDateForm popupForm">
        <div class="row">
            <div class="col-12">
                <h3 class="formTitle">Choose your interests</h3>
                <form role="form"  method="POST" action="/_categorySubscribe" class="form-inline row">
                    <div class="form-group col-12">
                        <div class="input-group subscribe-cat-checkbox">
                            <input type="checkbox" name="ico" id="subscr-cat-ico"><label for="subscr-cat-ico"> ICO Opportunities</label>
                        </div>
                        <div class="input-group subscribe-cat-checkbox">
                            <input type="checkbox" name="news" id="subscr-cat-news"><label for="subscr-cat-news"> News</label>
                        </div>
                        <div class="input-group subscribe-cat-checkbox">
                            <input type="checkbox" name="reviews" id="subscr-cat-reviews"><label for="subscr-cat-reviews"> Reviews</label>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        {{csrf_field()}}
                        <input type="hidden" name="interests" value="true">
                        <button type="submit" class="btn btn-primary" value="Subscribe" name="subscribe">Subscribe</button>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
                </div>
            </div>
        </div>
    </div>
</div>