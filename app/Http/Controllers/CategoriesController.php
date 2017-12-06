<?php namespace App\Http\Controllers;


use App\Categories;
use App\Language;
use App\LanguageValue;
use App\MetaContentForCategory;
use App\Page;
use App\Post;
use Illuminate\Http\Request;
use Validator;
use App\Http\Translate\Translate;

class CategoriesController extends Controller {

	public function index()
	{
		$languages = Language::get();
		$categories = Categories::get();
		return view('admin.categories.index', compact('categories', 'languages'));
	}

	public function create(Request $request)
	{
		$languages  = Language::get();
		$categories = Categories::get();

		return view('admin.categories.create', compact('languages', 'categories'));
	}

	public function store(Request $request)
	{
		$languages  = Language::get();
		$englId     = $languages->where('is_english', 1)->first();

		if (!$request->input('name_'.$englId->id)) {
			return redirect()->back()->withErrors('Name for English Language is Important!')->withInput();
		}
		$url    = Translate::storeKey($request->input('name_'.$englId->id));
		$lvl    = intval($request->get('parent_category'));
		$categ  = Categories::create([
			'parent_id'	=> $lvl
		]);

		if ($lvl) {
			$checkInCat     = Categories::where(['friendly_url' => $url, 'parent_id' => $lvl])->first();
			$checkInPost    = Post::whereHas('getCategory' , function ($q) use ($lvl) {
				$q->where('category_id', $lvl);
			})->where('friendly_url', $url)->first();
			if ($checkInCat || $checkInPost) {
				$url .= $url . '-cat-'.$categ->id;
			}
		} else {
			$checkInCat     = Categories::where(['friendly_url' => $url, 'parent_id' => $lvl])->first();
			$checkInPage    = Page::where('friendly_url', $url)->first();
			if ($checkInCat || $checkInPage) {
				$url .= $url . '-cat-'.$categ->id;
			}
		}
		$categ->name_lang_key           = 'category-name_'.$categ->id;
		$categ->description_lang_key    = 'category-description_'.$categ->id;
		$categ->friendly_url            = $url;
		$categ->save();

		$path = $this->getAllParents($categ);
		$categ->full_url = $path;

		if ($request->input('is_active')) {
			$categ->is_active = 1;
		}
		if ($request->input('is_menu')) {
			$categ->is_menu = 1;
		}
		$categ->save();

		foreach ($languages as $lang) {
			if ($request->input('name_'.$lang->id) && !is_null($request->input('name_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $categ->name_lang_key,
					'value'         => $request->input('name_'.$lang->id)
				]);
			}
			if ($request->input('description_'.$lang->id) && !is_null($request->input('description_'.$lang->id))) {
				LanguageValue::create([
					'language_id'   => $lang->id,
					'key'           => $categ->description_lang_key,
					'value'         => $request->input('description_'.$lang->id)
				]);
			}
			if ($request->input('meta-title_'.$lang->id) && !is_null($request->input('meta-title_'.$lang->id))) {
				MetaContentForCategory::create([
					'language_id'   => $lang->id,
					'meta_type_id'  => 1,
					'category_id'   => $categ->id,
					'content'       => $request->input('meta-title_'.$lang->id),
				]);
			}
			if ($request->input('meta-description_'.$lang->id) && !is_null($request->input('meta-description_'.$lang->id))) {
				MetaContentForCategory::create([
					'language_id'   => $lang->id,
					'meta_type_id'  => 2,
					'category_id'   => $categ->id,
					'content'       => $request->input('meta-description_'.$lang->id),
				]);
			}
		}
		return redirect('admin/categories')->with('success', 'Category created.');
	}

	public function edit($id, Request $request)
	{
		$languages  = Language::get();
		$category   = Categories::with('getMetaContent')->find($id);
		$cat        = Categories::where('id','!=', $id)->pluck('name_lang_key', 'id');
		$categories = $cat->where('parent_id', '!=', $id);
		$cats       = [];
		$cats[0]    = 'Choose Parent Category';
		foreach($categories as $key => $val) {
			$cats[$key] = Translate::getValue($val);
		}
		return view('admin.categories.edit', compact('languages', 'category', 'cats'));
	}

	public function update($id, Request $request)
	{
		$languages  = Language::get();
		$englId     = $languages->where('is_english', 1)->first();
		$categ      = Categories::find($id);

		if (!$request->input('name_'.$englId->id)) {
			return redirect()->back()->withErrors('Name for English Language is Important!')->withInput();
		}

		$categ = $this->editAllFullPath($categ , $request->input('parent_category'), $request->input('friendly_url'));

		if ($categ->is_menu == 1 && !$request->input('is_menu')) {
			$categ->is_menu = 0;
		}
		if ($categ->is_active == 1 && !$request->input('is_active')) {
			$categ->is_active = 0;
		}
		$categ->save();

		foreach ($languages as $lang) {
			$langValName = LanguageValue::where(['language_id' => $lang->id, 'key' => $categ->name_lang_key])->first();
			$langValDesc = LanguageValue::where(['language_id' => $lang->id, 'key' => $categ->description_lang_key])->first();
			if ($request->input('name_'.$lang->id) && $langValName) {
				if ($request->input('name_'.$lang->id) != $langValName->value) {
					$langValName->value = $request->input('name_'.$lang->id);
					$langValName->save();
				}
			}
			if ($request->input('description_'.$lang->id) && $langValDesc) {
				if ($request->input('description_' . $lang->id) != $langValDesc->value) {
					$langValDesc->value = $request->input('description_' . $lang->id);
					$langValDesc->save();
				}
			}
			$metaTitle = MetaContentForCategory::where([
				'language_id'   => $lang->id,
				'category_id'   => $categ->id,
				'meta_type_id'  => 1
			])->first();
			$metaDesc = MetaContentForCategory::where([
				'language_id'   => $lang->id,
				'category_id'   => $categ->id,
				'meta_type_id'  => 2
			])->first();
			if ($request->input('meta-title_'.$lang->id) && $metaTitle) {
				if ($request->input('meta-title_'.$lang->id) != $metaTitle->content) {
					$metaTitle->content = $request->input('meta-title_'.$lang->id);
					$metaTitle->save();
				}
			}
			if ($request->input('meta-description_'.$lang->id) && $metaDesc) {
				if ($request->input('meta-description_'.$lang->id) != $metaDesc->content) {
					$metaDesc->content = $request->input('meta-description_'.$lang->id);
					$metaDesc->save();
				}
			}
		}
		return redirect('admin/categories')->with('success', 'Category was changed and saved.');
	}

	public function getModalDelete($id = null)
	{
		$error          = '';
		$model          = '';
		$confirm_route  =  route('categories.delete',['id'=>$id]);
		return View('admin/layouts/modal_confirmation', compact('error','model', 'confirm_route'));
	}

	public function getDelete($id = null)
	{
		$categ = Categories::find($id);
		MetaContentForCategory::where('category_id', $categ->id)->delete();
		LanguageValue::where('key', $categ->name_lang_key)->delete();
		LanguageValue::where('key', $categ->description_lang_key)->delete();
		$categ->delete();
		return redirect('admin/categories')->with('success', 'Category was deleted success.');
	}

	protected function editAllFullPath(Categories $categ , $parent_id, $url)
	{
		$str        = '';
		$urlCheck   = Translate::storeKey($url);
		if ($parent_id != $categ->parent_id) {
			$check                  = $this->checkOnSamesUrl($categ, $parent_id, $urlCheck);
			if (!$check) {
				return false;
			}
			$categ->friendly_url    = $urlCheck;
			$categ->parent_id       = $parent_id;
			$categ->save();

			if ($categ->getParentCateg) {
				if ($categ->getParentCateg->full_url) {
					$str .= $categ->getParentCateg->full_url . '/';
				}
				$str .= $categ->getParentCateg->friendly_url;
			}
			$categ->full_url    = $str;
			$categ->save();

		} else if ($urlCheck != $categ->friendly_url) {
			$check = $this->checkOnSamesUrl($categ, $categ->parent_id, $urlCheck);
			if (!$check) {
				return false;
			}
			$categ->friendly_url = $urlCheck;
			$categ->save();
		}
		$arrChild               = [];
		if ($categ->getChildrens) {
			foreach($categ->getChildrens as $ch) {
				$arrChild[] = $ch->id;
			}
		}
		if (count($arrChild) > 0) {
			$this->editAllURLCateg($arrChild);
		}
		return $categ;
	}

	protected function editAllURLCateg($arr) {
		$array  = [];
		$cats   = Categories::wherein('id', $arr)->get();
		foreach($cats as $child) {
			if ($child) {
				if ($child->getParentCateg->full_url) {
					$child->full_url = $child->getParentCateg->full_url . '/'. $child->getParentCateg->friendly_url;
				} else {
					$child->full_url = $child->getParentCateg->friendly_url ;
				}
				$child->save();
				if ($child->getChildrens) {
					$ch = $child->getChildrens;
					foreach ($ch as $c) {
						$array[] = $c->id;
					}
				}
			}
		}
		if (count($array) > 0) {
			return $this->editAllURLCateg($array);
		}
		return true;
	}

	protected function checkOnSamesUrl($category, $parent_id, $url) {
		if ($parent_id == 0) {
			$page = Page::where('friendly_url', $url)->first();
			if ($page) {
				return false;
			}
			$categTest = Categories::where('id', '!=', $category->id)->where(['friendly_url' => $url, 'parent_id' => 0])->first();
			if ($categTest) {
				return false;
			}
		} else {
			$categTest = Categories::where('id', '!=', $category->id)->where(['friendly_url' => $url, 'parent_id' => $parent_id])->first();
			$postTest = Post::where(['category_id' => $category->id, 'friendly_url' => $url])->first();
			if ($categTest || $postTest) {
				return false;
			}
		}
		return true;
	}

	protected function getAllParents(Categories $categ, $str = null)
	{
		$link = $str;
		if ($categ->getParentCateg) {
			$link = $categ->getParentCateg->friendly_url . '/' . $str;
			return $this->getAllParents($categ->getParentCateg, $link);
		}
		return $link;
	}
}
