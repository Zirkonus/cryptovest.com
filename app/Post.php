<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const STATUS_PENDING_APPROVAL = 1;
    const STATUS_APPROVED = 2;
    const STATUS_DRAFT = 3;
    const STATUS_PUBLISHED = 4;
    const STATUS_SCHEDULE = 5;

    protected static $maxListItemDashboardByPeriod = array(
        "week" => 4
    );

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'category_id',
        'status_id',
        'friendly_url',
        'full_url',
        'title_lang_key',
        'title_image',
        'short_image',
        'category_image',
        'description_lang_key',
        'content_lang_key',
        'is_keep_featured',
        'submited_at',
        'label_id'
    ];

    public function getMetaContent()
    {
        return $this->hasMany('App\MetaContentForPost', 'post_id');
    }

    public function getCategory()
    {
        return $this->hasOne('App\Categories', 'id', 'category_id');
    }

    public function getUser()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function getStatus()
    {
        return $this->hasOne('App\Status', 'id', 'status_id');
    }

    public function getAuthor()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function getComments()
    {
        return $this->hasMany('App\Comments', 'post_id');
    }

    public function getLabel()
    {
        return $this->hasOne('App\Label', 'id', 'label_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public static function getGroupedPostWithUserByPeriodAndRole($endDate, $startDate, $userRoles, $period = 'W')
    {
        $postByPeriod =  Post::whereBetween('created_at', [$endDate, $startDate])
            ->with(['getUser' =>  function($query) use ($userRoles) {
                $query->whereIn('is_admin', $userRoles);
            }])
            ->latest()
            ->get()
            ->groupBy(function($date) use ($period) {
                return $date->created_at->format($period);
            });

        return $postByPeriod;
    }

    public static function getmaxListItemDashboardByPeriod($period)
    {
        return isset(self::$maxListItemDashboardByPeriod[$period])
            ? self::$maxListItemDashboardByPeriod[$period]
            : 1;
    }

    public static function scopeGetLatestPost( $query )
    {
        return $query->orderBy('created_at', 'asc')->first();
    }
    
    public function executives()
    {
        return $this->belongsToMany(Executive::class, 'post_executive', 'post_id', 'executive_id');
    }
}
