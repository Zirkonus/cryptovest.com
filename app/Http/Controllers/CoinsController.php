<?php

namespace App\Http\Controllers;

use App\Api\ConnectApiGetCoins;
use App\Api\ConnectApiGetExchanges;
use App\Categories;
use App\Coin;
use App\CoinValue;
use App\Http\Translate\Translate;
use App\Language;
use App\LanguageValue;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CoinsController extends Controller
{
    const SHOW_BY_DEFAULT = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::get();
        $coinsList = Coin::orderBy('rank')->get();

        return view('admin.coins.index', compact('coinsList', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $languages = Language::get();
        $coin = Coin::where('slug', $slug)->first();

        return view('admin.coins.edit', compact('languages', 'coin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $this->validate($request, [
            'new-image' => 'image',
        ]);

        $coin = Coin::where('slug', $slug)->first();
        $langId = Translate::getEnglishId();

        $coinValue = CoinValue::where(['key_coin' => $coin->symbol])->first();

        if (!isset($coinValue)) {
            $coinValue = new CoinValue();
            $coinValue->key_coin = $coin->symbol;
            $coinValue->save();
        }

        if ($coinValue->value_link_buy_coin != $request->input('link_buy_coin')) {
            $coinValue->value_link_buy_coin = $request->input('link_buy_coin');
            $coinValue->save();
        }

        if ($request->file('new-image')) {
            $image = Image::make($request->file('new-image'));
            Storage::makeDirectory('public/upload/images/coins/' . $coin->symbol . '/origin');

            $image->save(storage_path('app/public/upload/images/coins/' . $coin->symbol . '/origin/' . $request->file('new-image')->getClientOriginalName()));

            if ($coinValue->value_image != 'storage/upload/images/coins/' . $coin->symbol . '/origin/' . $request->file('new-image')->getClientOriginalName()) {
                $coinValue->value_image = 'storage/upload/images/coins/' . $coin->symbol . '/origin/' . $request->file('new-image')->getClientOriginalName();
                $coinValue->save();
            }
        }

        $coin->save();

        $languages = Language::get();

        foreach ($languages as $lang) {

            $description = $request->input('description_' . $lang->id) ?? 'description-coins_' . $coin->symbol;

                $val = LanguageValue::where(['language_id' => $lang->id, 'key' => $coin->description_lang_key])->first();

                if (isset($val)) {
                    if ($val->value != $description) {
                        $val->value = $description;
                        $val->save();
                    }
                } else {
                    LanguageValue::create([
                        'language_id' => $lang->id,
                        'key' => $coin->description_lang_key,
                        'value' => $description
                    ]);
                }
        }

        return redirect('admin/coins')->with('success', 'Coin was Updated');
    }

    /**
     * Get modal delete
     *
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function getModalDelete($slug = null)
    {
        $error = '';
        $model = '';
        $confirm_route = route('coins.delete', ['slug' => $slug]);

        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    /**
     * Get delete
     *
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    private function getDelete($slug = null)
    {
        $coin = Coin::where('slug', $slug)->first();
        $coin->delete();

        return redirect('admin/coins')->with('success', 'Coin was deleted success.');
    }

    /**
     * Get coins by pagination and search
     *
     * @param Request $request
     */
    public function getCoinsPaginationSearch(Request $request)
    {
        $page = $request->input('page') ?: 1;
        $search = $request->input('search') ?: "";
        $tab = $request->input('tab') ?: 1;

        /* Tabs */

        if ($tab == 1) {
            $coinsId = Coin::take(100)->orderBy('marketcap_usd', 'DESC')->pluck('id');
        } else {
            $coinsId = Coin::take(900)->offset(100)->orderBy('marketcap_usd', 'DESC')->pluck('id');
        }

        $coins = Coin::whereIn('id', $coinsId);

        $coins = $coins->when(!empty($search), function ($query) use ($search) {
            return $query->where('name', 'LIKE', '%' . $search . '%');
        });

        $coins->orderBy('marketcap_usd', 'DESC');

        $coins = $coins->get();

        /* Add images */
        foreach ($coins as $coin) {
            $coin->image =  asset(CoinValue::getValueImage($coin->symbol));
            $coin->marketcap_usd = number_format($coin->marketcap_usd, 2);
        }

        return $coins;
    }

    public function showCoinsListPage()
    {
        $coinsList = Coin::orderBy('marketcap_usd', 'DESC')->take(100)->get();

        foreach ($coinsList as $coin) {
            $coin->marketcap_usd = number_format($coin->marketcap_usd, 2);
        }

        return view("front-end.coins-list", compact('coinsList'));
    }

    protected function showCoinsOnePage($slug)
    {
        $coin = Coin::where('slug', $slug)->first();

        if (!$coin) {
            return abort('404');
        }

        $categs = Categories::with('getChildrens')->get();
        $childs = [];
        foreach ($categs as $catCh) {
            $arr[$catCh->friendly_url] = [];
            if ($catCh->getChildrens) {
                foreach ($catCh->getChildrens as $ch) {
                    $arr[$catCh->friendly_url][] = $ch->id;
                }
            }
        }
        foreach ($arr as $k => $val) {
            $childs[$k] = [];
            if (count($val) > 0) {
                $childs[$k] = $this->getAllChildrens($val);
            }
            foreach ($categs as $c) {
                if ($c->friendly_url == $k) {
                    $childs[$k][] = $c->id;
                }
            }
        }

        $news = Post::with('getCategory', 'getAuthor')->whereIn('category_id', $childs['news'])
            ->where('status_id', 4)->orderBy('created_at', 'desc')->get()->random(6);

        $education = Post::with('getCategory', 'getAuthor')->whereIn('category_id', $childs['education'])
            ->where('status_id', 4)->orderBy('created_at', 'desc')->get()->random(6);


        $exchangesListForView = $this->getExchangesListForView($coin);

        /* Link buy coin*/

        $linkForBuyCoin = "";

        foreach ($exchangesListForView as $exchange) {
            if ($exchange['market'] == "$coin->symbol/BTC") {
                $linkForBuyCoin = $exchange['website'];
                break;
            }
        }

        // For link exchanges, which set in admin panel

        if (!empty(CoinValue::getLinkBuyCoin($coin->symbol))) {
            $linkForBuyCoin = CoinValue::getLinkBuyCoin($coin->symbol);
        }

        return view("front-end.coins-one", compact('coin', 'exchangesList', 'news', 'education', 'exchangesListForView', 'linkForBuyCoin'));
    }

    /**
     * Get all childrens
     * @param $childs
     * @param null $array
     * @return array
     */
    protected function getAllChildrens($childs, $array = null)
    {
        $arr    = [];
        $forUse = [];
        if (!$array) {
            $arr = $childs;
        } else {
            $arr = array_merge($array, $childs);
        }
        $category = Categories::whereIn('parent_id', $childs)->get();
        foreach ($category as $cat) {
            $arr[] = $cat->id;
            if ($cat->getChildrens) {
                foreach ($cat->getChildrens as $ch) {
                    $forUse[] = $ch->id;
                }
            }
        }
        if (count($forUse) > 0) {
            return $this->getAllChildrens($forUse, $arr);
        }
        return $arr;
    }

    /**
     * Get exchanges list for selected coin
     * @param $coin
     * @return array
     */
    protected function getExchangesListForView($coin)
    {
        $exchangesList = ConnectApiGetExchanges::getExchanges();

        $resultExchangesList = [];

        foreach ($exchangesList as $k => $exchange) {
            foreach ($exchange['trading_pairs'] as $key => $pair) {
                if (!preg_match('/^' .$coin->symbol .'\//', $pair['market'])) {
                    unset($exchange['trading_pairs'][$key]);
                }
            }

            if (count($exchange['trading_pairs']) > 0) {
                $resultExchangesList[] = $exchange;
            }

        }

        $exchangesListForView = [];

        $i = 0;
        foreach ($resultExchangesList as $resultExchange) {
            foreach ($resultExchange['trading_pairs'] as $pair) {
                $exchangesListForView[$i]['name'] = $resultExchange['name'];
                $exchangesListForView[$i]['market'] = $pair['market'];
                $exchangesListForView[$i]['price'] = round($pair['price'], 2);
                $exchangesListForView[$i]['volume_btc'] = round($pair['volume_btc'], 2);
                $exchangesListForView[$i]['website'] = $resultExchange['website'];
                $i++;
            }
        }

        usort($exchangesListForView, function ($a, $b) {
            return strnatcmp($a["volume_btc"], $b["volume_btc"]);
        });

        $exchangesListForView = array_reverse($exchangesListForView);

        return $exchangesListForView;
    }
}
