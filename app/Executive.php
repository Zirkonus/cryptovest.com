<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Executive extends Model
{
    protected $table = 'executives';

    protected $fillable = [
        'first_name_lang_key',
        'last_name_lang_key',
        'country_id',
        'twitter_link',
        'linkedin_link',
        'url',
        'profile_image',
        'biography_lang_key',
        'is_active'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_executive', 'executive_id', 'post_id');
    }

    public function country()
    {
        return $this->hasOne('App\Country', 'id', 'country_id');
    }

    public function ICOProjects()
    {
        return $this->belongsToMany('App\ICOProjects', 'executive_icos', 'executive_id', 'ico_projects_id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\ExecutiveRole', 'roles_executives_mapping', 'executive_id', 'role_id');
    }
    public function supports()
    {
        return $this->belongsToMany('App\ExecutiveSupport', 'executives_supports_mapping', 'executive_id', 'executive_support_id');
    }
}
