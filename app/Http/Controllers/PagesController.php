<?php

namespace App\Http\Controllers;

use App\Categories;
use App\LanguageValue;
use App\MetaContentForPage;
use App\Page;
use Illuminate\Http\Request;
use App\Language;
use Translate;

class PagesController extends Controller
{
	public function index()
	{
		$languages  = Language::get();
		$pages      = Page::get();

		return view('admin.pages.index', compact('pages', 'languages'));
	}

	public function create(Request $request)
	{
		$languages  = Language::get();
		return view('admin.pages.create', compact('languages'));
	}

	public function store(Request $request)
	{
		$mainLang   = Language::where('is_english', 1)->first();
		$key        = Translate::storeKey($request->input('title_'.$mainLang->id));
		$page       = Page::create();

		$page->title_lang_key               = 'pages-title-' . $page->id;
		$page->description_lang_key         = 'pages-description-' . $page->id;
		$page->content_lang_key             = 'pages-content-' . $page->id;

		$page->title_main_block_lang_key          = 'title-main-' . $page->id;
        $page->title_first_block_lang_key   = 'title-first-block-' . $page->id;
        $page->text_first_block_lang_key    = 'text-first-block-' . $page->id;
	    $page->title_second_block_lang_key  = 'title-second-block-' . $page->id;
	    $page->text_second_block_lang_key   = 'text-second-block-' . $page->id;
        $page->reserve_text_block_lang_key  = 'reserve-text-block-' . $page->id;

		$checkPage  = Page::where('friendly_url', $key)->first();
		$checkCateg = Categories::where(['friendly_url' => $key, 'parent_id' => 0])->first();
		if ($checkPage || $checkCateg) {
			$key .= '-page-'.$page->id;
		}
		$page->friendly_url = $key;
		$page->save();
		$language = Language::get();
		foreach ($language as $lang) {
			if ($request->input('title_'.$lang->id) && !is_null($request->input('title_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $page->title_lang_key,
					'value'         => $request->input('title_'.$lang->id)
				]);
				MetaContentForPage::create([
					'language_id'   => $lang->id,
					'meta_type_id'  => 1,
					'page_id'       => $page->id,
					'content'       => $request->input('title_'.$lang->id)
				]);
			}
			if ($request->input('description_'.$lang->id) && !is_null($request->input('description_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $page->description_lang_key,
					'value'         => $request->input('description_'.$lang->id)
				]);
				MetaContentForPage::create([
					'language_id'   => $lang->id,
					'meta_type_id'  => 2,
					'page_id'       => $page->id,
					'content'       => $request->input('description_'.$lang->id)
				]);
			}
			if ($request->input('content_'.$lang->id) && !is_null($request->input('content_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $page->content_lang_key,
					'value'         => $request->input('content_'.$lang->id)
				]);
			}
			if ($request->input('main-block-title_'.$lang->id) && !is_null($request->input('main-block-title_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $page->title_main_block_lang_key,
					'value'         => $request->input('main-block-title_'.$lang->id)
				]);
			}
			if ($request->input('first-block-title_'.$lang->id) && !is_null($request->input('first-block-title_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $page->title_first_block_lang_key,
					'value'         => $request->input('first-block-title_'.$lang->id)
				]);
			}
			if ($request->input('first-block-content_'.$lang->id) && !is_null($request->input('first-block-content_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $page->text_first_block_lang_key,
					'value'         => $request->input('first-block-content_'.$lang->id)
				]);
			}
			if ($request->input('second-block-title_'.$lang->id) && !is_null($request->input('second-block-title_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $page->title_second_block_lang_key,
					'value'         => $request->input('second-block-title_'.$lang->id)
				]);
			}
			if ($request->input('second-block-content_'.$lang->id) && !is_null($request->input('second-block-content_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $page->text_second_block_lang_key,
					'value'         => $request->input('second-block-content_'.$lang->id)
				]);
			}
			if ($request->input('reserve-block-content_'.$lang->id) && !is_null($request->input('reserve-block-content_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $page->reserve_text_block_lang_key,
					'value'         => $request->input('reserve-block-content_'.$lang->id)
				]);
			}
		}
		return redirect('admin/pages')->with('success', 'Page was created');
	}

	public function edit($id)
	{
		$languages = Language::get();
		$page = Page::with('getMetaContent')->find($id);
		return view('admin.pages.edit', compact('languages', 'page'));
	}

	public function update($id, Request $request)
	{
		$page   = Page::find($id);
		$url    = Translate::storeKey($request->input('friendly_url'));
		if ($url != $page->friendly_url) {
			$checkPage  = Page::where('friendly_url', $url)->first();
			$checkCateg = Categories::where(['friendly_url' => $url, 'parent_id' => 0])->first();
			if ($checkPage || $checkCateg) {
				return redirect()->back()->withErrors('This URL is used!')->withInput();
			} else {
				$page->friendly_url = $url;
			}
		}
		$languages = Language::get();

		foreach ($languages as $lang) {
			if ($request->input('title_'.$lang->id) && !is_null($request->input('title_'.$lang->id))) {
				$valTitle = LanguageValue::where(['language_id' => $lang->id, 'key' => $page->title_lang_key])->first();
				if ($valTitle != $request->input('title_'.$lang->id)) {
					$valTitle->value = $request->input('title_'.$lang->id);
					$valTitle->save();
				}
			}
			if ($request->input('description_'.$lang->id) && !is_null($request->input('description_'.$lang->id))) {
				$valDesc = LanguageValue::where(['language_id' => $lang->id, 'key' => $page->description_lang_key])->first();
				if ($valDesc != $request->input('description_'.$lang->id)) {
					$valDesc->value = $request->input('description_'.$lang->id);
					$valDesc->save();
				}
			}
			if ($request->input('content_'.$lang->id) && !is_null($request->input('content_'.$lang->id))) {
				$valCont = LanguageValue::where(['language_id' => $lang->id, 'key' => $page->content_lang_key])->first();
				if ($valCont != $request->input('content_'.$lang->id)) {
					$valCont->value = $request->input('content_'.$lang->id);
					$valCont->save();
				}
			}
			if ($request->input('main-block-title_'.$lang->id) && !is_null($request->input('main-block-title_'.$lang->id))) {
				$valCont = LanguageValue::where(['language_id' => $lang->id, 'key' => $page->title_main_block_lang_key])->first();
				if ($valCont) {
					if ($valCont != $request->input('main-block-title_' . $lang->id)) {
						$valCont->value = $request->input('main-block-title_' . $lang->id);
						$valCont->save();
					}
				} else {
					LanguageValue::create([
						'language_id'   => $lang->id,
						'key'           => $page->title_main_block_lang_key,
						'value'         => $request->input('main-block-title_'.$lang->id)
					]);
				}
			}
			if ($request->input('first-block-title_'.$lang->id) && !is_null($request->input('first-block-title_'.$lang->id))) {
				$valCont = LanguageValue::where(['language_id' => $lang->id, 'key' => $page->title_first_block_lang_key])->first();
				if ($valCont) {
					if ($valCont != $request->input('first-block-title_'.$lang->id)) {
						$valCont->value = $request->input('first-block-title_'.$lang->id);
						$valCont->save();
					}
				} else {
					LanguageValue::create([
						'language_id'   => $lang->id,
						'key'           => $page->title_first_block_lang_key,
						'value'         => $request->input('first-block-title_'.$lang->id)
					]);
				}
			}
			if ($request->input('first-block-content_'.$lang->id) && !is_null($request->input('first-block-content_'.$lang->id))) {
				$valCont = LanguageValue::where(['language_id' => $lang->id, 'key' => $page->text_first_block_lang_key])->first();
				if ($valCont) {
					if ($valCont != $request->input('first-block-content_'.$lang->id)) {
						$valCont->value = $request->input('first-block-content_'.$lang->id);
						$valCont->save();
					}
				} else {
					LanguageValue::create([
						'language_id'   => $lang->id,
						'key'           => $page->text_first_block_lang_key,
						'value'         => $request->input('first-block-content_'.$lang->id)
					]);
				}
			}
			if ($request->input('second-block-title_'.$lang->id) && !is_null($request->input('second-block-title_'.$lang->id))) {
				$valCont = LanguageValue::where(['language_id' => $lang->id, 'key' => $page->title_second_block_lang_key])->first();
				if ($valCont) {
					if ($valCont != $request->input('second-block-title_'.$lang->id)) {
						$valCont->value = $request->input('second-block-title_'.$lang->id);
						$valCont->save();
					}
				} else {
					LanguageValue::create([
						'language_id'   => $lang->id,
						'key'           => $page->title_second_block_lang_key,
						'value'         => $request->input('second-block-title_'.$lang->id)
					]);
				}
			}
			if ($request->input('second-block-content_'.$lang->id) && !is_null($request->input('second-block-content_'.$lang->id))) {
				$valCont = LanguageValue::where(['language_id' => $lang->id, 'key' => $page->text_second_block_lang_key])->first();
				if ($valCont) {
					if ($valCont != $request->input('second-block-content_'.$lang->id)) {
						$valCont->value = $request->input('second-block-content_'.$lang->id);
						$valCont->save();
					}
				} else {
					LanguageValue::create([
						'language_id'   => $lang->id,
						'key'           => $page->text_second_block_lang_key,
						'value'         => $request->input('second-block-content_'.$lang->id)
					]);
				}
			}
			if ($request->input('reserve-block-content_'.$lang->id) && !is_null($request->input('reserve-block-content_'.$lang->id))) {
				$valCont = LanguageValue::where(['language_id' => $lang->id, 'key' => $page->reserve_text_block_lang_key])->first();
				if ($valCont) {
					if ($valCont != $request->input('reserve-block-content_'.$lang->id)) {
						$valCont->value = $request->input('reserve-block-content_'.$lang->id);
						$valCont->save();
					}
				} else {
					LanguageValue::create([
						'language_id'   => $lang->id,
						'key'           => $page->reserve_text_block_lang_key,
						'value'         => $request->input('reserve-block-content_'.$lang->id)
					]);
				}
			}
			if ($request->input('meta-title_'.$lang->id) && !is_null($request->input('meta-title_'.$lang->id))) {
				$valMetTitle = MetaContentForPage::where(['language_id' => $lang->id, 'meta_type_id' => 1, 'page_id' => $page->id])->first();
				if ($valMetTitle->content != $request->input('meta-title_'.$lang->id)) {
					$valMetTitle->content = $request->input('meta-title_'.$lang->id);
					$valMetTitle->save();
				}
			}
			if ($request->input('meta-description_'.$lang->id) && !is_null($request->input('meta-description_'.$lang->id))) {
				$valMetDescr = MetaContentForPage::where(['language_id' => $lang->id, 'meta_type_id' => 2, 'page_id' => $page->id])->first();
				if ($valMetDescr->content != $request->input('meta-description_'.$lang->id)) {
					$valMetDescr->content = $request->input('meta-description_'.$lang->id);
					$valMetDescr->save();
				}
			}
		}
		return redirect('admin/pages')->with('success', 'The page was Edited');
	}

	public function getModalDelete($id = null)
	{
		$error          = '';
		$model          = '';
		$confirm_route  =  route('pages.delete',['id'=>$id]);
		return View('admin/layouts/modal_confirmation', compact('error','model', 'confirm_route'));
	}

	public function getDelete($id = null)
	{
		$page = Page::find($id);
		MetaContentForPage::where('page_id', $page->id)->delete();
		LanguageValue::where('key', $page->title_lang_key)->delete();
		LanguageValue::where('key', $page->description_lang_key)->delete();
		LanguageValue::where('key', $page->content_lang_key)->delete();
		$page->delete();

		return redirect('admin/pages')->with('success', 'Page was deleted success.');
	}

}
