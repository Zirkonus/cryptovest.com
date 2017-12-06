<h3>Buyer info</h3>
<p>Buyer name: {{ $buyer->name }}</p>
<p>Buyer email: {{ $buyer->email }}</p>

{!! $buyer->company ? "<p> Buyer company: " . $buyer->company . "</p>" : "" !!}
{!! $buyer->mobile ? "<p> Buyer mobile: " . $buyer->mobile . "</p>" : "" !!}

<h3>Project info</h3>
<p>Project title: {{ $project->title }}</p>
<p>Industry: {{$project->getCategory->name or $project->ico_category_other}}</p>
<p>Platform: {{$project->getPlatform->name or $project->ico_platform_other}}</p>
<p>Description: {{$project->short_description}}</p>
<p>Project coin:
    @foreach($project->getMoney as $money)
        <span>{{$money->name}}</span>
    @endforeach
</p>
<p>Short token: {{$project->short_token}}</p>
<p>Total supply: {{$project->total_supply}}</p>
<p>Number of coin: {{$project->number_coins}}</p>
<p>Start date: {{$project->data_start}}</p>
<p>End date: {{$project->data_end}}</p>
{!! $project->link_website ?  "<p> Website link: " . $project->link_website. "</p>" : "" !!}
{!! $project->link_whitepaper ?  "<p> Whitepaper link: " . $project->link_whitepaper. "</p>" : "" !!}
{!! $project->link_announcement ? "<p> Announcement link: " . $project->link_announcement . "</p>" : "" !!}
{!! $project->link_youtube ? "<p> Youtube link: " . $project->link_youtube . "</p>" : "" !!}
{!! $project->link_facebook ? "<p> Facebook link: " . $project->link_facebook . "</p>" : "" !!}
{!! $project->link_telegram ? "<p> Telegram link: " . $project->link_telegram . "</p>" : "" !!}
{!! $project->link_instagram ? "<p> Instagram link: " . $project->link_instagram . "</p>" : "" !!}
{!! $project->link_linkedin ? "<p> Linkedin link: " . $project->link_linkedin . "</p>" : "" !!}
{!! $project->link_twitter ? "<p> Twitter link: " . $project->link_twitter . "</p>" : "" !!}
{!! $project->link_slack ? "<p> Slack link: " . $project->link_slack . "</p>" : "" !!}

<h3>Deal info</h3>
<p>Payment type: {{ \App\ICOPaymentType::find($deal->payment_type_id)->name }}</p>
<p>Payment option: {{ $deal->payment_option }}</p>
<p>Total coast: {{ $deal->total_coast }}</p>