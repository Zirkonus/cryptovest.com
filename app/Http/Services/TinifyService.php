<?php

namespace App\Http\Services;

use Tinify\Tinify;

class TinifyService
{
    public function __construct()
    {
        Tinify::setKey(env("TINIFY_KEY"));
    }

    public function getFromUrl($url)
    {
        return \Tinify\fromUrl($url);
    }

    public function getFromBuffer($string)
    {
        return \Tinify\fromBuffer($string);
    }
    public function getFromFile($file)
    {
        return \Tinify\fromFile($file);
    }
}