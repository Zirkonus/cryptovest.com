<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 22.08.17
 * Time: 6:21
 */

namespace App;

use App\Categories;
use App\Page;

class Helpers
{
	public function getMenu()
	{
		$pages      = Page::pluck('title_lang_key', 'friendly_url');
		$maincateg  = Categories::with('getChildrens')->where(['is_active' => 1, 'is_menu' => 1, 'parent_id' => 0])->get();

		$menu = [$pages, $maincateg];
		return $menu ;
	}

	protected function getMenuItemCateg($arrChild, $arr = NULL)
	{
		$array      = [];
		$childs     = [];
		if ($arr) {
			$array  = $arr;
		} else {
			foreach($arrChild as $a ) {
				$array[$a] = [];
			};
		}
		$categ      = Categories::whereIN('friendly_url', $arrChild)->get();
		foreach($categ as $cat) {
			if ($cat->getChildrens) {
				foreach ($cat->getChildrens as $children) {
					$childs[] = $children->friendly_url;
				}
				$array[$cat->friendly_url] = $childs;
			}
			if (count($childs) > 0) {

				return $this->getMenuItemCateg($childs, $array);
			}
		}
		return $array;
	}
}