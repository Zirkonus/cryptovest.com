<?php
/**
 * Created by PhpStorm.
 * User: bohdan.sotnychuk
 * Date: 11/6/2017
 * Time: 11:07 PM
 */
namespace App\Helpers;

use Request;

class ProjectHelpers
{

    public static function routesIsEqual(array $nameUrls)
    {
        foreach ($nameUrls as $nameUrl) {
            if (Request::is($nameUrl)) {
                return true;
            }
        }

        return false;
    }

}