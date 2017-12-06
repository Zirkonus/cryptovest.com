<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Language;
use App\LanguageValue;
use Validator;
use Illuminate\Http\Request;
use Image;

class BannersController extends Controller
{
    public function index()
    {
        $banner = Banner::first();
        return view('admin.banners.index', compact('banner'));
    }

    public function update(Request $request)
    {
        $rules = [
            'title' => 'required',
            'url' => 'required'
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $banner = Banner::first();
        if ($request->input('url') != $banner->url) {
            $banner->url = $request->input('url');
        }
        if ($file = $request->file('image')) {
            $image = Image::make($file);
            $image->save(storage_path('app/public/upload/images/banner' . $banner->id . '_origin.jpg'));
            $fileExtension = $file->getClientOriginalExtension();
            $this->imageOptimization($file, "banner", $image, $banner, "image", $banner->id . "_origin." . $fileExtension);
            if (!($image->width() < 736) || !($image->height() < 415)) {
                $image->resize(736, 415);
            }
            $this->imageOptimization($file, "banner", $image, $banner, "image", $banner->id . "." . $fileExtension);
        }
        $banner->save();

        $lang = Language::where('is_english', 1)->first();
        $val = LanguageValue::where([
            'key' => $banner->title_lang_key,
            'language_id' => $lang->id
        ])->first();
        if ($val) {
            $val->value = $request->input('title');
            $val->save();
        } else {
            LanguageValue::create([
                'key' => $banner->title_lang_key,
                'language_id' => $lang->id,
                'value' => $request->input('title')
            ]);
        }
        return view('admin.banners.index', compact('banner'));
    }
}
