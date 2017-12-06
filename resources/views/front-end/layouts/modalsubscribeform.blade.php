<div id="FormModalSubscribeThanks" class="modal">
    <div class="container subscribeBlock upToDateForm popupForm">
        <div class="row">
            <div class="col-12">
                @if (session('successSendMessage') and session('successSendMessage') != 'subscribe')
                <h3 class="formTitle">{{session('successSendMessage')}}</h3>
                @else
                    <h4 style="text-align: center;font-size: 2rem; line-height: 2;">Thanks for subscribing!</h4>
                    <p style="text-align: center; margin-bottom: 0">You're one step away from getting industry's latest news and updates.</br>
                        Please check your inbox/spam for a confirmation email and click on the link to confirm your subscription.</p>
                @endif
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">x</button>
                </div>
            </div>
        </div>
    </div>
</div>