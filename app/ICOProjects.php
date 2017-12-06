<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ICOProjects extends Model
{
    protected $table = 'ico_projects';

    protected $fillable = [

        'ico_category_id',
        'ico_platform_id',
        'ico_project_type_id',
        'ico_promotion_id',

        'title',
        'short_description',
        'description',
        'friendly_url',
        'image',
        'presale_condition',
        'total_supply',
        'raised_field',

        'data_start',
        'data_end',

        'link_whitepaper',
        'link_announcement',
        'link_youtube',
        'link_facebook',
        'link_telegram',
        'link_instagram',
        'link_website',

//need add to admin panel
        'link_linkedin',
        'link_twitter',
        'link_slack',

        'link_but_join_presale',
        'link_but_explore_more',
        'link_but_join_token_sale',
        'link_but_exchange',

        'is_top',
        'is_active',
        'is_fraud',

        'ico_platform_other',
        'ico_category_other',

        'ico_screenshot',
        'ico_deal_id'
    ];

    public function getPlatform()
    {
        return $this->hasOne('App\ICOPlatform', 'id', 'ico_platform_id');
    }

    public function getProjectType()
    {
        return $this->hasOne('App\ICOProjectTypes', 'id', 'ico_project_type_id');
    }

    public function getCategory()
    {
        return $this->hasOne('App\ICOCategory', 'id', 'ico_category_id');
    }

    public function getPromotion()
    {
        return $this->hasOne('App\ICOPromotion', 'id', 'ico_promotion_id');
    }

    public function getMoney()
    {
        return $this->belongsToMany('App\ICOMoney', 'icoprojects_money', 'ico_id', 'money_id');
    }

    public function getMembers()
    {
        return $this->hasMany('App\ICOMembers', 'ico_id', 'id');
    }

    public function getComments()
    {
        return $this->hasMany('App\ICOComments', 'ico_id');
    }

    public function getICODeal()
    {
        return $this->hasOne(ICODeal::class, "ico_projects_id", "id");
    }
}
