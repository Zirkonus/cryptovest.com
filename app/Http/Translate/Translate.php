<?php

namespace App\Http\Translate;

use App\Language;
use App\LanguageValue;
use phpDocumentor\Reflection\Types\Null_;
use Session;

class Translate
{
    static private $languageValues = null;

    public static function getValue($key, $langId = null)
    {
        if (!Session::has('lang_id')) {
            $lang = Language::where('is_main', 1)->select('id')->first();
            Session::put('lang_id', strtoupper($lang->id));
        }
        if (is_null($langId)) {
            $id = Session::get('lang_id');
        } else {
            $id = $langId;
        }

        if (!isset(self::$languageValues)) {
            self::$languageValues = LanguageValue::where('language_id', $id)->pluck('value', 'key')->all();
        }

        $value = self::$languageValues[$key] ?? null;

        if ($value) {
            return $value;
        }

        return $key;
    }

    public static function getEnglishId()
    {
        if (!Session::has('english_id')) {
            $lang = Language::where('is_english', 1)->select('id')->first();
            Session::put('english_id', $lang->id);
        }
        return Session::get('english_id');
    }

    public static function storeKey($key)
    {
        $key    = trim(strtolower($key));
        $key    = preg_replace('/\s+/', ' ', $key);
        $key    = str_replace(' ', '-', $key);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $key);
    }
}
