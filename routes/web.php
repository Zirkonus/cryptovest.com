<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FrontEndController@index')->name('home');
Route::get('/about/', 'FrontEndController@aboutPage');
Route::get('/contact/', 'FrontEndController@contactPage')->name('contact');
Route::get('/education/glossary/', 'FrontEndController@glossaryPage');
Route::get('/_glossary-result', 'GlossaryController@getItemByParams');
Route::get('/_show-banner/', 'FrontEndController@showBanner');
Route::get('/_click-banner/', 'FrontEndController@clickBanner');
Route::post('/_getNewComment', 'FrontEndController@getNewComment');
Route::post('/_categorySubscribe', 'FrontEndController@subscribeCategory');
Route::post('/_postFromContactForm', 'FrontEndController@getMessageFromContactForm');
Route::get('/_test-api', 'ApiController@getList');
Route::get('/_picture-update', 'AdminController@updateAllPictures');
Route::get('/_helpFunc', 'AdminController@helpFunc');
Route::post('/_addICOComment', 'FrontEndController@getNewICOComment');
Route::post('/_getICOsForMainPage', 'FrontEndController@geICOsForMainPage');
Route::post('/_coins-pagination-search', 'CoinsController@getCoinsPaginationSearch');

Route::post('/_ico/get-buyer-data', 'ICOController@getBuyerData');
Route::post('/_ico/get-info', 'ICOController@getICOInformation');
Route::post('/_ico/get-members', 'ICOController@getICOTeam');
Route::post('/_ico/get-deal', 'ICOController@getPayment');
Route::post('/_ico/get-payment-types', 'ICOController@getPaymentTypes');
Route::post('/_ico/send-buyer-email', 'ICOController@sendBuyerEmail');
Route::post('/_ico/upload-screenshot', 'ICOController@uploadScreenshot');
Route::get('/_next-post', 'PostsController@getNextPost');
Route::post('/_executive-filter', 'ExecutivesController@filteredData');

//rss feed
Route::get('/feed', 'FeedsController@getFeed');
//----------------Redirect 301--------------------

Route::get('/news/market-watch/bitconnect-crash-reviewed/', function (){
	return redirect('/news/bitconnect-crash-reviewed/', 301);
});
Route::get('/news/market-watch/', function (){
	return redirect('/news/');
});
Route::get('/news/market-watch/overview-18-25-aug/', function (){
	return redirect('/news/overview-18-25-aug/', 301);
});
Route::get('/news/market-watch/overview-12-18-aug/', function (){
	return redirect('/news/overview-12-18-aug/', 301);
});
Route::get('/education/investing/mitigate-ico-investing-risks/', function (){
	return redirect('/education/mitigate-ico-investing-risks/', 301);
});
Route::get('/education/investing/5-must-dos-when-investing-in-icos/', function (){
	return redirect('/education/5-must-dos-when-investing-in-icos/', 301);
});
Route::get('/education/investing/cryptocurrency-investing-guide/', function (){
	return redirect('/education/cryptocurrency-investing-guide/', 301);
});
Route::get('/education/investing/ethereum-investment-turning-more-heads/', function (){
	return redirect('/education/ethereum-investment-turning-more-heads/', 301);
});

//--New

Route::get('/education/transaction-fees-explained/Austria_cryptocurrencies.docx', function (){
	return redirect('/education/transaction-fees-explained/', 301);
});
Route::get('/education/transaction-fees-explained/poloniex.com', function (){
	return redirect('/reviews/best-hated-exchange-poloniex/', 301);
});
Route::get('/author/christine-b/', function (){
	return redirect('/author/christine-masters/', 301);
});
Route::get('/author/michael-k/', function (){
	return redirect('/author/michael-kimani/', 301);
});
Route::get('/admin/posts/poloniex.com', function (){
	return redirect('/reviews/best-hated-exchange-poloniex/', 301);
});
Route::get('/education/transaction-fees-explained/Austria_cryptocurrencies.docx', function (){
	return redirect('/education/transaction-fees-explained/', 301);
});
Route::get('/education/transaction-fees-explained/poloniex.com', function (){
	return redirect('/reviews/best-hated-exchange-poloniex/', 301);
});

// --- 11.09

Route::get('/special-first-edition-coins-are-now-available/', function (){
    return redirect('/');
});
Route::get('/shop/', function (){
    return redirect('/');
});
Route::get('/contact-us/', function (){
    return redirect('/contact/');
});
Route::get('/shop', function (){
    return redirect('/');
});
Route::get('/product/zinodaur-physical-litecoin', function (){
    return redirect('/');
});
Route::get('/my-account/lost-password', function (){
    return redirect('/');
});
Route::get('/faq/', function (){
    return redirect('/');
});
Route::get('/product/zinodaur-physical-litecoin-replacement-holograms', function (){
    return redirect('/');
});
Route::get('/order-tracking', function (){
    return redirect('/');
});
Route::get('/shop/?orderby=date', function (){
    return redirect('/');
});
Route::get('/reviews/feed/', function (){
    return redirect('/reviews/');
});
Route::get('/news/feed/', function (){
    return redirect('/news/');
});
Route::get('/education/transaction-fees-explained/Austria_cryptocurrencies.docx', function (){
    return redirect('/education/transaction-fees-explained/', 301);
});
Route::get('/education/transaction-fees-explained/poloniex.com', function (){
    return redirect('/reviews/best-hated-exchange-poloniex/', 301);
});
Route::get('/shop/?orderby=rating', function (){
    return redirect('/');
});
Route::get('/author/sales/', function (){
    return redirect('/');
});
Route::get('/education/feed/', function (){
    return redirect('/');
});
Route::get('/ycongcrdcueslj.html', function (){
    return redirect('/');
});
Route::get('/wvuszuqrkqzalv.html', function (){
    return redirect('/');
});
Route::get('/nslievdo.html', function (){
    return redirect('/');
});
Route::get('/dom.webslookup.com', function (){
    return redirect('/');
});
Route::get('/?page_id=10', function (){
    return redirect('/');
});
Route::get('/product-category/physical-litecoins?orderby=date', function (){
    return redirect('/');
});
Route::get('/?page_id=16', function (){
    return redirect('/');
});
Route::get('/?page_id=9', function (){
    return redirect('/');
});
Route::get('/?page_id=62', function (){
    return redirect('/');
});
Route::get('/news/market-watch/bitcoin-cash-watch/', function (){
    return redirect('/news/bitcoin-cash-watch/', 301);
});
Route::get('/news/market-watch/future-of-ethereum/', function (){
    return redirect('/news/future-of-ethereum/', 301);
});
Route::get('/reviews/utrust-ico-review/reviews', function (){
    return redirect('/reviews/utrust-ico-review/', 301);
});
Route::get('/reviews/utrust-ico-review/about', function (){
    return redirect('/reviews/utrust-ico-review/', 301);
});
Route::get('/reviews/utrust-ico-review/contact', function (){
    return redirect('/reviews/utrust-ico-review/', 301);
});
Route::get('/education/ethereum-classic-explained/education', function (){
    return redirect('/education/ethereum-classic-explained/', 301);
});
Route::get('/education/ethereum-classic-explained/reviews', function (){
    return redirect('/education/ethereum-classic-explained/', 301);
});
Route::get('/education/ethereum-classic-explained/contact', function (){
    return redirect('/education/ethereum-classic-explained/', 301);
});
Route::get('/education/ethereum-classic-explained/news', function (){
    return redirect('/education/ethereum-classic-explained/', 301);
});
Route::get('/education/ethereum-classic-explained/about', function (){
    return redirect('/education/ethereum-classic-explained/', 301);
});
Route::get('/reviews/utrust-ico-review/education', function (){
    return redirect('/reviews/utrust-ico-review/', 301);
});
Route::get('/education/ethereum-hard-fork-explained/about', function (){
    return redirect('/education/ethereum-hard-fork-explained/', 301);
});
Route::get('/education/ethereum-hard-fork-explained/education', function (){
    return redirect('/education/ethereum-hard-fork-explained/', 301);
});
Route::get('/education/ethereum-hard-fork-explained/news', function (){
    return redirect('/education/ethereum-hard-fork-explained/', 301);
});
Route::get('/news/investors-worry-recent-ethereum-crash/contact', function (){
    return redirect('/news/investors-worry-recent-ethereum-crash/', 301);
});
Route::get('/news/investors-worry-recent-ethereum-crash/education', function (){
    return redirect('/news/investors-worry-recent-ethereum-crash/', 301);
});
Route::get('/news/investors-worry-recent-ethereum-crash/news', function (){
    return redirect('/news/investors-worry-recent-ethereum-crash/', 301);
});
Route::get('/news/investors-worry-recent-ethereum-crash/reviews', function (){
    return redirect('/news/investors-worry-recent-ethereum-crash/', 301);
});
Route::get('/hunain-naseer/', function (){
    return redirect('/author/hunain-naseer/', 301);
});
Route::get('/education/5-reason-invest-bitcoin/about', function (){
    return redirect('/education/5-reason-invest-bitcoin/', 301);
});
Route::get('/reviews/utrust-ico-review/news', function (){
    return redirect('/reviews/utrust-ico-review/', 301);
});
Route::get('/news/investors-worry-recent-ethereum-crash/about', function (){
    return redirect('/news/investors-worry-recent-ethereum-crash/', 301);
});
Route::get('/education/ethereum-hard-fork-explained/reviews', function (){
    return redirect('/education/ethereum-hard-fork-explained/', 301);
});
Route::get('/education/ethereum-hard-fork-explained/contact', function (){
    return redirect('/education/ethereum-hard-fork-explained/', 301);
});
Route::get('/404', function (){
    return redirect('/');
});
Route::get('/contact/news', function (){
    return redirect('/contact/');
});
Route::get('/news/education', function (){
    return redirect('/news/');
});
Route::get('/tedra-desue/', function (){
    return redirect('/author/tedra-desue/', 301);
});
//22.09
Route::get('/news/croatia-speeds-bitcoin-adoption-with-new-atm/', function (){
    return redirect('/news/zagreb-gets-new-bitcoin-atm-and-cafe/', 301);
});
Route::get('/news/etherereums-next-stage-byzantium-hard-fork-begins-test-run/', function (){
    return redirect('/news/ethereums-next-stage-byzantium-hard-fork-begins-test-run/', 301);
});

//Route::get('', function (){
//	return redirect('');
//});

//---------------------End 301 redirect----------------------------
Route::group(['middleware' => 'check.redirect'], function () {
    Route::get('/events/', 'FrontEndController@showEventsPage');
    Route::get('/coins/', 'CoinsController@showCoinsListPage');
//    Route::get('/coins/{slug}/', 'CoinsController@showCoinsOnePage');
    Route::get('/executives/', 'FrontEndController@showExecutivesPage');
    Route::get('/executives/{url}', 'FrontEndController@showOneExecutivesPage')->name("executive-one");
    Route::get('/author/{url}/', 'FrontEndController@showAuthorPage');
    Route::get('/tag/{tag}', 'FrontEndController@showTagPage');
    Route::get('/ico/', 'FrontEndController@showICOsMain')->name('ico');
    Route::get('/ico/deal-form', 'ICOController@getDealForm');
    Route::get('/ico/{title}', 'FrontEndController@showICOsbyTitle')->middleware('icos');
    Route::get('/{id}/', 'FrontEndController@showCateg');
    Route::get('/{id}/{page}', 'FrontEndController@showCategOrPagePaginate')->where(['page' => '[0-9]+']);
    Route::prefix('amp')->group(function(){
        Route::get('/{category}/{post}/{page}', 'FrontEndController@showPostorCategOrPagePaginate')->where(['page' => '[0-9]+']);
        Route::get('/{parent}/{categ}/{post}/', 'FrontEndController@showParentPost');
        Route::get('/{category}/{post}/', 'FrontEndController@showPostorCateg');
    });
    Route::get('/{category}/{post}/{page}', 'FrontEndController@showPostorCategOrPagePaginate')->where(['page' => '[0-9]+']);
    Route::get('/{parent}/{categ}/{post}/', 'FrontEndController@showParentPost');
    Route::get('/{category}/{post}/', 'FrontEndController@showPostorCateg');
});

Auth::routes();

Route::get('/home', function () {
	return redirect('/');
});
