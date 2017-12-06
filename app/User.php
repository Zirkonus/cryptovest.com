<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Translate\Translate;

class User extends Authenticatable
{
    use Notifiable;

    const USER_SUPER_ADMIN = 2;
    const USER_ADMIN = 1;
    const USER_AUTHOR = 0;
    const USER_EDITOR = 3;
    const USER_EXECUTIVE_EDITOR = 4;
    const USER_DIRECTORY_EDITOR = 5;
    const USER_WITHOUT_ROLE = 100;

    protected $table = 'users';

    protected $fillable = [
        'first_name_lang_key',
        'last_name_lang_key',
        'email',
        'url',
        'password',
        'profile_image',
        'biography_lang_key',
        'twitter_link',
        'facebook_link',
        'twitter_profile_username',
        'is_active',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getPosts()
    {
    	return $this->hasMany('App\Post', 'user_id', 'id');
    }

    public static function scopeGetUsersByRoles( $query , array $userRole)
    {
        return $query->whereIn('is_admin', $userRole);
    }

    public function getTranslateNameAndSurname()
    {
        return Translate::getValue($this->first_name_lang_key) . ' ' . Translate::getValue($this->last_name_lang_key);
    }

    public static function getAllUserByRoleAsKeyArray(array $userRole)
    {
        $allUserAsKeyArray = [];
        $allUsersByRole = self::getUsersByRoles($userRole)->get();

        foreach ($allUsersByRole as $user) {
            $allUserAsKeyArray[] = $user->getTranslateNameAndSurname();
        }

        return array_fill_keys($allUserAsKeyArray, null);
    }

    public function isEditor()
    {
         return $this->is_admin == self::USER_EDITOR;
    }

    public function isAuthor()
    {
        return $this->is_admin == self::USER_AUTHOR;
    }

    public function isAdmin()
    {
        return $this->is_admin == self::USER_ADMIN;
    }

    public function isSuperAdmin()
    {
        return $this->is_admin == self::USER_SUPER_ADMIN;
    }

    public function isActive()
    {
        return $this->is_active;
    }

    public function isEmptyRole()
    {
        return $this->is_admin == self::USER_WITHOUT_ROLE;
    }

    public function isExecutiveEditor()
    {
        return $this->is_admin == self::USER_EXECUTIVE_EDITOR;
    }

    public function isUserDirectoryEditor()
    {
        return $this->is_admin == self::USER_DIRECTORY_EDITOR;
    }

    public function getRole()
    {
        return $this->is_admin;
    }
}
