<?php

namespace App\Http\Controllers;

use App\Language;
use App\LanguageValue;
use Illuminate\Http\Request;
use Validator;
use Lang;

class LanguagesController extends Controller
{
	public function index()
	{
		$languages = Language::get();
		return view('admin.languages.index', compact('languages'));
	}

	public function create(Request $request)
	{
		return view('admin.languages.create');
	}

	public function store(Request $request)
	{
		$rules = [
			"name"          => "required|unique:languages,name",
			"country_code"  => "required",
			"language_code" => "required",
		];
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$lang = Language::create([
			'country_code'  => $request->input('country_code'),
			'language_code' => $request->input('language_code'),
			'name'          => $request->input('name'),
		]);

		if ($request->input('is_active')) {
			$lang->is_active = 1;
		}
		if ($request->input('is_english')) {
			Language::where('is_english', 1)->update(['is_english' => 0]);
			$lang->is_english = 1;
		}
		if ($request->input('is_main')) {
			Language::where('is_main', 1)->update(['is_main' => 0]);
			$lang->is_main = 1;
		}
		$lang->save();

		return redirect('admin/languages')->with('success', 'Created success.');
	}

	public function edit($id, Request $request)
	{
		$lang = Language::find($id);

		return view('admin.languages.edit', compact('lang'));
	}

	public function update($id, Request $request)
	{
		$rules = [
			"name"          => "required",
			"country_code"  => "required",
			"language_code" => "required",
		];
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$lang = Language::find($id);

		if ($request->input('name') != $lang->name) {
			$l = Language::where('name', $request->input('name'))->first();
			if ($l) {
				return redirect()->back()->withErrors('The name already in use!')->withInput();
			} else {
				$lang->name = $request->input('name');
			}
		}
		$lang->country_code = $request->input('country_code');
		$lang->language_code = $request->input('language_code');
		if ($request->input('is_active')) {
			$lang->is_active = 1;
		} else {
			if ($lang->is_active == 1 && ($lang->is_english == 1 || $lang->is_main == 1)) {
				return redirect()->back()->withErrors("The main or english language can't be dissables!")->withInput();
			} else {
				$lang->is_active = 0;
			}
		}
		if ($request->input('is_english') && $lang->is_english == 0) {
			$l = Language::where('is_english', 1)->update(['is_english' => 0]);
			$lang->is_english = 1;
		}
		if ($request->input('is_main') && $lang->is_main == 0) {
			$l = Language::where('is_main', 1)->update(['is_main' => 0]);
			$lang->is_main = 1;
		}
		$lang->save();

		return redirect('admin/languages')->with('success', 'edited success.');
	}

	public function getModalDelete($id = null)
	{
		$error          = '';
		$model          = '';
		$confirm_route  =  route('languages.delete',['id'=>$id]);
		return View('admin/layouts/modal_confirmation', compact('error','model', 'confirm_route'));
	}

	public function getDelete($id = null)
	{
		$lang = Language::find($id);
		if ($lang->is_main == 1 || $lang->is_english == 1) {
			return redirect('admin/languages')->with('error','First you should disable language');
		}
		Language::destroy($id);
		return redirect('admin/languages')->with('success', 'Language was deleted success.');
	}

	public function getLanguageKeys()
	{
		$languages = Language::get();
		$langVal = LanguageValue::get();

		return view('admin.languages.langval', compact('langVal', 'languages'));
	}

	public function storeLanguageKeys()
	{
		$languages = Language::get();
		return view('admin.languages.langval-create', compact('languages'));
	}

	public function createLanguageKeys(Request $request)
	{
		$languages = Language::get();
		foreach ($languages as $lang) {
			if ((is_null($request->input('key_'.$lang->id)) && !is_null($request->input('value_'.$lang->id))) ||
				(!is_null($request->input('key_'.$lang->id)) && is_null($request->input('value_'.$lang->id)))) {
				return redirect()->back()->withErrors("The key and value is important!")->withInput();
			}
			$key = Translate::storeKey($request->input('key_'.$lang->id));
			if ($request->input('key_'.$lang->id) && $request->input('value_'.$lang->id) &&
				!is_null($request->input('key_'.$lang->id)) && !is_null($request->input('value_'.$lang->id))) {

					$testval = LanguageValue::where(['language_id' => $lang->id, 'key' => $key])->first();
					if ($testval) {
						return redirect()->back()->withErrors("This key is used!")->withInput();
					} else {
						LanguageValue::create([
								'language_id'   => $lang->id,
								'key'           => $key,
								'value'         => $request->input('value_'.$lang->id)
						]);
					}
			}
		}
		return redirect('admin/language-keys')->with('success', 'Language key was added success.');
	}
}
