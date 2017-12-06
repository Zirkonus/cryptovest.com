<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    public static $redirectPathForRoleAfterLogin = [
        User::USER_SUPER_ADMIN => '/admin',
        User::USER_ADMIN => '/admin',
        User::USER_AUTHOR => '/admin/posts/create',
        User::USER_EDITOR => '/admin/posts',
        User::USER_EXECUTIVE_EDITOR => '/admin/executives',
        User::USER_DIRECTORY_EDITOR => '/admin/companies',
    ];

    protected $fillable = ['old_link', 'new_link'];

    public static function getRedirectPathAfterLoginByRole($userRole)
    {
        return array_key_exists($userRole, self::$redirectPathForRoleAfterLogin)
            ? self::$redirectPathForRoleAfterLogin[$userRole]
            : self::$redirectPathForRoleAfterLogin[USER::USER_AUTHOR];
    }
}
