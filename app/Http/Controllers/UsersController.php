<?php

namespace App\Http\Controllers;

use App\Http\Translate\Translate;
use App\LanguageValue;
use Illuminate\Http\Request;
use App\Language;
use App\User;
use Image;
use Auth;

class UsersController extends Controller
{
	public function index()
	{
		$languages  = Language::get();
		$users      = User::get();
		return view('admin.users.index', compact('users', 'languages'));
	}

	public function create()
	{
		$languages = Language::get();
		return view('admin.users.create', compact('languages'));
	}

	public function store(Request $request)
	{
		$user = User::where('email', $request->input('email'))->first();
		if ($user) {
			return redirect()->back()->withErrors('Email already busy!')->withInput();
		}
		$mainLangId = Translate::getEnglishId();
		$url        = $request->input('name_'.$mainLangId) . ' '. $request->input('last-name_'.$mainLangId);
		$authUrl    = Translate::storeKey($url);
		$user       = User::where('url', $authUrl)->first();
		if ($user) {
			return redirect()->back()->withErrors('User with this First and Last name already exist!')->withInput();
		}

		$user = User::create([
			'email'     => $request->input('email'),
			'password'  => bcrypt($request->input('password')),
			'url'       => $authUrl
		]);

		$user->first_name_lang_key  = 'user-first-name-'. $user->id;
		$user->last_name_lang_key   = 'user-last-name-'. $user->id;
		$user->biography_lang_key   = 'user-biography-'. $user->id;

		if ($request->input('twitter-link') && !is_null($request->input('twitter-link'))) {
			$user->twitter_link = $request->input('twitter-link');
		}
		if ($request->input('facebook-link') && !is_null($request->input('facebook-link'))) {
			$user->facebook_link = $request->input('facebook-link');
		}
		if ($request->input('twitter-profile-user-name') && !is_null($request->input('twitter-profile-user-name'))) {
			$user->twitter_link = $request->input('twitter-profile-user-name');
		}
        if ($file = $request->file('image')) {
            $image = Image::make($file);
            $fileExtension = $file->getClientOriginalExtension();
            $this->imageOptimization($file, false, $image, $user, "profile_image", 'profile-' . $user->id .'_origin.' . $fileExtension);

            if (($image->width() > 352) || ($image->height() > 352)) {
                $image->resize(352, 352);
            }
            $this->imageOptimization($file, false, $image, $user, "profile_image", 'profile-' . $user->id .'.' . $fileExtension);
        }
		if ($request->input('is_active')) {
			$user->is_active = 1;
		}
        $user->is_admin = 100;
        if ($request->input('is_admin')) {
            $user->is_admin = 1;
            if ($request->input('is_author')) {
                $user->is_admin = 2;
            }
        } elseif ($request->input('is_author')) {
            $user->is_admin = 0;
        } elseif ($request->input('is_editor')) {
            $user->is_admin = User::USER_EDITOR;
        } elseif ($request->input('is_executive_editor')) {
            $user->is_admin = User::USER_EXECUTIVE_EDITOR;
        } elseif ($request->input('is_directory_editor')) {
            $user->is_admin = User::USER_DIRECTORY_EDITOR;
        }

		$user->save();
		$languages = Language::get();
		foreach ($languages as $lang) {
			if ($request->input('name_'.$lang->id) && !is_null($request->input('name_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $user->first_name_lang_key,
					'value'         => $request->input('name_'.$lang->id)
				]);
			}
			if ($request->input('last-name_'.$lang->id) && !is_null($request->input('last-name_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $user->last_name_lang_key,
					'value'         => $request->input('last-name_'.$lang->id)
				]);
			}
			if ($request->input('biography_'.$lang->id) && !is_null($request->input('biography_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $user->biography_lang_key,
					'value'         => $request->input('biography_'.$lang->id)
				]);
			}
		}
		return redirect('admin/users')->with('success', 'New user was created!');
	}

	public function edit($id)
	{
		$user       = User::find($id);
		$languages  = Language::get();
		return view('admin.users.edit', compact('languages', 'user'));
	}

	public function update($id, Request $request)
	{
		$user = User::find($id);
		if ($request->input('email') && $request->input('email') != $user->email) {
			$test = User::where('email', $request->input('email'))->first();
			if ($test) {
				return redirect()->back()->withErrors('Email already busy!')->withInput();
			}
			$user->email = $request->input('email');
		}
		$engLang = Translate::getEnglishId();
		$string = $request->input('name_'.$engLang) . ' ' . $request->input('last-name_'.$engLang);
		$url = Translate::storeKey($string);
		if ($url != $user->url) {
			$userCheck = User::where('url', $url)->first();
			if ($userCheck) {
				return redirect()->back()->withErrors('Name and Last Name already exist!')->withInput();
			}
			$user->url = $url;
		}

		if (!is_null($request->input('password'))) {
			$user->password = bcrypt($request->input('password'));
		}
        if ($file = $request->file('new-image')) {
            $image = Image::make($file);
            $fileExtension = $file->getClientOriginalExtension();
            $this->imageOptimization($file, false, $image, $user, "profile_image", 'profile-' . $user->id .'_origin.' . $fileExtension);
			if (($image->width() > 352) || ($image->height() > 352)) {
				$image->resize(352, 352);
			}

            $this->imageOptimization($file, false, $image, $user, "profile_image", 'profile-' . $user->id .'.' . $fileExtension);
		}
		if ($request->input('is_active')) {
			$user->is_active = 1;
		} else {
			$user->is_active = 0;
		}
        $user->is_admin = 100;
        if ($request->input('is_admin') or Auth::user()->id == $user->id) {
            $user->is_admin = 1;
            if ($request->input('is_author')) {
                $user->is_admin = 2;
            }
        } elseif ($request->input('is_author')) {
            $user->is_admin = 0;
        } elseif ($request->input('is_editor')) {
            $user->is_admin = User::USER_EDITOR;
        } elseif ($request->input('is_executive_editor')) {
            $user->is_admin = User::USER_EXECUTIVE_EDITOR;
        } elseif ($request->input('is_directory_editor')) {
            $user->is_admin = User::USER_DIRECTORY_EDITOR;
        }

		if (is_null($user->first_name_lang_key)) {
			$user->first_name_lang_key = 'user-first-name-' . $user->id;
		}
		if ($request->input('facebook-link') != $user->facebook_link) {
			$user->facebook_link = $request->input('facebook-link');
		}

		if ($request->input('twitter-link') != $user->twitter_link) {
			$user->twitter_link = $request->input('twitter-link');
		}
		if (is_null($user->last_name_lang_key)) {
			$user->last_name_lang_key = 'user-last-name-' . $user->id;
		}
		if (is_null($user->biography_lang_key)) {
			$user->biography_lang_key = 'user-biography-' . $user->id;
		}
		$user->save();
		$languages = Language::get();
		foreach($languages as $lang) {
			if (is_null($request->input('name_'. $lang->id))) {
				$val = LanguageValue::where(['language_id' => $lang->id, 'key' => $user->first_name_lang_key])->first();
				if ($val) {
					$val->value = '';
					$val->save();
				}
			} else {
				$val = LanguageValue::where(['language_id' => $lang->id, 'key' => $user->first_name_lang_key])->first();
				if ($val) {
					$val->value = $request->input('name_'. $lang->id);
					$val->save();
				} else {
					LanguageValue::create([
						'language_id'   => $lang->id,
						'key'           => $user->first_name_lang_key,
						'value'         => $request->input('name_'. $lang->id)
					]);
				}
			}
			if (is_null($request->input('last-name_'. $lang->id))) {
				$val = LanguageValue::where(['language_id' => $lang->id, 'key' => $user->last_name_lang_key])->first();
				if ($val) {
					$val->value = '';
					$val->save();
				}
			} else {
				$val = LanguageValue::where(['language_id' => $lang->id, 'key' => $user->last_name_lang_key])->first();
				if ($val) {
					$val->value = $request->input('last-name_'. $lang->id);
					$val->save();
				} else {
					LanguageValue::create([
						'language_id'   => $lang->id,
						'key'           => $user->last_name_lang_key,
						'value'         => $request->input('last-name_'. $lang->id)
					]);
				}
			}
			if (is_null($request->input('biography_'. $lang->id))) {
				$val = LanguageValue::where(['language_id' => $lang->id, 'key' => $user->biography_lang_key])->first();
				if ($val) {
					$val->value = '';
					$val->save();
				}
			} else {
				$val = LanguageValue::where(['language_id' => $lang->id, 'key' => $user->biography_lang_key])->first();
				if ($val) {
					$val->value = $request->input('biography_'. $lang->id);
					$val->save();
				} else {
					LanguageValue::create([
						'language_id'   => $lang->id,
						'key'           => $user->biography_lang_key,
						'value'         => $request->input('biography_'. $lang->id)
					]);
				}
			}

		}
		return redirect('admin/users')->with('success', 'User was edited!');
	}

	public function getModalDelete($id = null)
	{
		$error          = '';
		$model          = '';
		$confirm_route  =  route('users.delete',['id'=>$id]);
		return View('admin/layouts/modal_confirmation', compact('error','model', 'confirm_route'));
	}

	public function getDelete($id = null)
	{
		$user = User::find($id);

		LanguageValue::where('key', $user->first_name_lang_key)->delete();
		LanguageValue::where('key', $user->last_name_lang_key)->delete();
		LanguageValue::where('key', $user->biography_lang_key)->delete();
		$user->delete();
		return redirect('admin/users')->with('success', 'Post was deleted success.');
	}
}
