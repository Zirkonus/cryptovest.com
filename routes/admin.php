<?php
use App\User;

Route::group(array('prefix' => 'admin', 'middleware' => 'auth.admin'), function ()
{
    Route::get('/', 'AdminController@showDashboard');
    Route::get('/site-statistics', 'AdminController@showStatistic');
});

Route::group(array('prefix' => 'admin', 'middleware' => 'auth.admin'), function () {
	Route::post('post-load-image', 'PostsController@loadImage');
    Route::get('get-table-with-keywords', 'PostsController@returnTablePostsWithKeywords');

	Route::get('categories/{id}/delete', array('as' => 'categories.delete', 'uses' => 'CategoriesController@getDelete'));
	Route::get('categories/{id}/confirm-delete', array('as' => 'categories.confirm-delete', 'uses' => 'CategoriesController@getModalDelete'));

//--- Tags part ---
    Route::get('tags/{id}/delete', array('as' => 'tags.delete', 'uses' => 'TagsController@getDelete'));
    Route::get('tags/{id}/confirm-delete', array('as' => 'tags.confirm-delete', 'uses' => 'TagsController@getModalDelete'));

    Route::get('coins/{id}/delete', array('as' => 'coins.delete', 'uses' => 'CoinsController@getDelete'));
    Route::get('coins/{id}/confirm-delete', array('as' => 'coins.confirm-delete', 'uses' => 'CoinsController@getModalDelete'));

//--- Languages part ---
	Route::resource('languages', 'LanguagesController');
	Route::get('languages/{id}/delete', array('as' => 'languages.delete', 'uses' => 'LanguagesController@getDelete'));
	Route::get('languages/{id}/confirm-delete', array('as' => 'languages.confirm-delete', 'uses' => 'LanguagesController@getModalDelete'));
	Route::get('language-keys/', array('as' => 'language-keys.index', 'uses' => 'LanguagesController@getLanguageKeys'));
	Route::get('language-keys/create', array('as' => 'language-keys.create', 'uses' => 'LanguagesController@storeLanguageKeys'));
	Route::post('language-keys/create', array('uses' => 'LanguagesController@createLanguageKeys'));

//--- Pages part ---
	Route::resource('pages', 'PagesController');
	Route::get('pages/{id}/delete', array('as' => 'pages.delete', 'uses' => 'PagesController@getDelete'));
	Route::get('pages/{id}/confirm-delete', array('as' => 'pages.confirm-delete', 'uses' => 'PagesController@getModalDelete'));

//--- Banner part ---
	Route::get('banner', 'BannersController@index');
	Route::post('banner', 'BannersController@update');

});

Route::group(array('prefix' => 'admin', 'middleware' => 'auth'), function () {
    Route::resource('categories', 'CategoriesController');
    Route::resource('tags', 'TagsController');
    Route::resource('labels', 'LabelsController');
    Route::resource('posts', 'PostsController');
});

//--- Avavailable for Editor Admin ---

Route::group(array('prefix' => 'admin', 'middleware' => 'auth.admin-editor'), function () {

    //--- Tags part ---
    Route::get('tags/{id}/delete', array('as' => 'tags.delete', 'uses' => 'TagsController@getDelete'));
    Route::get('tags/{id}/confirm-delete', array('as' => 'tags.confirm-delete', 'uses' => 'TagsController@getModalDelete'));

    //--- Posts part ---
    Route::get('posts/{id}/delete', array('as' => 'posts.delete', 'uses' => 'PostsController@getDelete'));
    Route::get('posts/{id}/confirm-delete', array('as' => 'posts.confirm-delete', 'uses' => 'PostsController@getModalDelete'));

    //--- Glossary part ---
    // Words
    Route::get('glossary/words', 'GlossaryController@listWords')->name('glossary.words');
    Route::get('glossary/words/create', 'GlossaryController@createWords')->name('glossary.words.create');
    Route::post('glossary/words/create', 'GlossaryController@saveWords');
    Route::get('glossary/words/edit/{id}', 'GlossaryController@editWords')->name('glossary.words.edit');
    Route::post('glossary/words/edit/{id}', 'GlossaryController@updateWords');
    Route::get('glossary/words/delete/{id}', 'GlossaryController@deleteWords')->name('glossary.words.delete');

    // Categories
    Route::get('glossary/categories', 'GlossaryController@listCategories')->name('glossary.category');
    Route::get('glossary/categories/create', 'GlossaryController@createCategory')->name('glossary.category.create');
    Route::post('glossary/categories/create', 'GlossaryController@saveCategory');
    Route::get('glossary/categories/edit/{id}', 'GlossaryController@editCategory')->name('glossary.category.edit');
    Route::post('glossary/categories/edit/{id}', 'GlossaryController@updateCategory');
    Route::get('glossary/categories/delete/{id}', 'GlossaryController@deleteCategory')->name('glossary.category.delete');

    // Items
    Route::get('glossary/items', 'GlossaryController@listItems')->name('glossary.items');
    Route::get('glossary/items/create', 'GlossaryController@createItems')->name('glossary.items.create');
    Route::post('glossary/items/create', 'GlossaryController@saveItems');
    Route::get('glossary/items/edit/{id}', 'GlossaryController@editItems')->name('glossary.items.edit');
    Route::post('glossary/items/edit/{id}', 'GlossaryController@updateItems');
    Route::get('glossary/items/delete/{id}', 'GlossaryController@deleteItems')->name('glossary.items.delete');

    //--- locations part ---
    Route::resource('locations', 'LocationsController');

    //--- events part ---
    Route::resource('events', 'EventsController');

    //--- ICO part ---
    Route::get('ico/project-types', ['as' => 'project-type.index', 'uses' => 'ICOController@listOfProjectTypes']);
    Route::get('ico/project-types/create', [ 'as' => 'project-type.create', 'uses' => 'ICOController@createProjectType']);
    Route::post('ico/project-types/create', ['uses' => 'ICOController@storeProjectType']);
    Route::get('ico/project-types/edit/{id}', ['as' => 'project-type.edit', 'uses' => 'ICOController@editProjectType']);
    Route::post('ico/project-types/edit/{id}', ['uses' => 'ICOController@updateProjectType']);
    Route::get('ico/project-types/{id}/delete', ['as' => 'project-type.delete', 'uses' => 'ICOController@getTypeDelete']);
    Route::get('ico/project-types/{id}/confirm-delete', ['as' => 'project-type.confirm-delete', 'uses' => 'ICOController@getModalTypeDelete']);

    Route::get('ico/money', ['as' => 'money.index', 'uses' => 'ICOController@listOfMoney']);
    Route::get('ico/money/create', [ 'as' => 'money.create', 'uses' => 'ICOController@createMoney']);
    Route::post('ico/money/create', ['uses' => 'ICOController@storeMoney']);
    Route::get('ico/money/edit/{id}', ['as' => 'money.edit', 'uses' => 'ICOController@editMoney']);
    Route::post('ico/money/edit/{id}', ['uses' => 'ICOController@updateMoney']);
    Route::get('ico/money/{id}/delete', ['as' => 'money.delete', 'uses' => 'ICOController@getMoneyDelete']);
    Route::get('ico/money/{id}/confirm-delete', ['as' => 'money.confirm-delete', 'uses' => 'ICOController@getModalMoneyDelete']);

    Route::get('ico/category', ['as' => 'ico.category.index', 'uses' => 'ICOController@listOfCategory']);
    Route::get('ico/category/create', [ 'as' => 'ico.category.create', 'uses' => 'ICOController@createCategory']);
    Route::post('ico/category/create', ['uses' => 'ICOController@storeCategory']);
    Route::get('ico/category/edit/{id}', ['as' => 'ico.category.edit', 'uses' => 'ICOController@editCategory']);
    Route::post('ico/category/edit/{id}', ['uses' => 'ICOController@updateCategory']);
    Route::get('ico/category/{id}/delete', ['as' => 'ico.category.delete', 'uses' => 'ICOController@getCategoryDelete']);
    Route::get('ico/category/{id}/confirm-delete', ['as' => 'ico.category.confirm-delete', 'uses' => 'ICOController@getModalCategoryDelete']);

    Route::get('ico/platform', ['as' => 'platform.index', 'uses' => 'ICOController@listOfPlatform']);
    Route::get('ico/platform/create', [ 'as' => 'platform.create', 'uses' => 'ICOController@createPlatform']);
    Route::post('ico/platform/create', ['uses' => 'ICOController@storePlatform']);
    Route::get('ico/platform/edit/{id}', ['as' => 'platform.edit', 'uses' => 'ICOController@editPlatform']);
    Route::post('ico/platform/edit/{id}', ['uses' => 'ICOController@updatePlatform']);
    Route::get('ico/platform/{id}/delete', ['as' => 'platform.delete', 'uses' => 'ICOController@getPlatformDelete']);
    Route::get('ico/platform/{id}/confirm-delete', ['as' => 'platform.confirm-delete', 'uses' => 'ICOController@getModalPlatformDelete']);

    Route::get('ico/promotion', ['as' => 'promotion.index', 'uses' => 'ICOController@listOfPromotion']);
    Route::get('ico/promotion/create', [ 'as' => 'promotion.create', 'uses' => 'ICOController@createPromotion']);
    Route::post('ico/promotion/create', ['uses' => 'ICOController@storePromotion']);
    Route::get('ico/promotion/edit/{id}', ['as' => 'promotion.edit', 'uses' => 'ICOController@editPromotion']);
    Route::post('ico/promotion/edit/{id}', ['uses' => 'ICOController@updatePromotion']);
    Route::get('ico/promotion/{id}/delete', ['as' => 'promotion.delete', 'uses' => 'ICOController@getPromotionDelete']);
    Route::get('ico/promotion/{id}/confirm-delete', ['as' => 'promotion.confirm-delete', 'uses' => 'ICOController@getModalPromotionDelete']);

    Route::get('ico/members', ['as' => 'ico.members.index', 'uses' => 'ICOController@listOfMember']);
    Route::get('ico/members/create', [ 'as' => 'ico.members.create', 'uses' => 'ICOController@createMember']);
    Route::post('ico/members/create', ['uses' => 'ICOController@storeMember']);
    Route::get('ico/members/edit/{id}', ['as' => 'ico.members.edit', 'uses' => 'ICOController@editMember']);
    Route::post('ico/members/edit/{id}', ['uses' => 'ICOController@updateMember']);
    Route::get('ico/members/{id}/delete', ['as' => 'ico.members.delete', 'uses' => 'ICOController@getMemberDelete']);
    Route::get('ico/members/{id}/confirm-delete', ['as' => 'ico.members.confirm-delete', 'uses' => 'ICOController@getModalMemberDelete']);

    Route::get('ico/comments', ['as' => 'ico.comments.index', 'uses' => 'ICOController@listOfComments']);
    Route::get('ico/comments/edit/{id}', ['as' => 'ico.comments.edit', 'uses' => 'ICOController@editComment']);
    Route::post('ico/comments/edit/{id}', ['uses' => 'ICOController@updateComment']);
    Route::get('ico/comments/{id}/delete', ['as' => 'ico.comments.delete', 'uses' => 'ICOController@getCommentDelete']);
    Route::get('ico/comments/{id}/confirm-delete', ['as' => 'ico.comments.confirm-delete', 'uses' => 'ICOController@getModalCommentDelete']);

    Route::get('ico/projects', ['as' => 'ico.project.index', 'uses' => 'ICOController@listOfProjects']);
    Route::get('ico/projects/create', [ 'as' => 'ico.project.create', 'uses' => 'ICOController@createProject']);
    Route::post('ico/projects/create', ['uses' => 'ICOController@storeProject']);
    Route::get('ico/projects/edit/{id}', ['as' => 'ico.project.edit', 'uses' => 'ICOController@editProject']);
    Route::post('ico/projects/edit/{id}', ['uses' => 'ICOController@updateProject']);
    Route::get('ico/projects/{id}/delete', ['as' => 'ico.project.delete', 'uses' => 'ICOController@getProjectDelete']);
    Route::get('ico/projects/{id}/confirm-delete', ['as' => 'ico.project.confirm-delete', 'uses' => 'ICOController@getModalProjectDelete']);

//--- Glossary part ---
    // Words
    Route::get('glossary/words', 'GlossaryController@listWords')->name('glossary.words');
    Route::get('glossary/words/create', 'GlossaryController@createWords')->name('glossary.words.create');
    Route::post('glossary/words/create', 'GlossaryController@saveWords');
    Route::get('glossary/words/edit/{id}', 'GlossaryController@editWords')->name('glossary.words.edit');
    Route::post('glossary/words/edit/{id}', 'GlossaryController@updateWords');
    Route::get('glossary/words/delete/{id}', 'GlossaryController@deleteWords')->name('glossary.words.delete');

    // Categories
    Route::get('glossary/categories', 'GlossaryController@listCategories')->name('glossary.category');
    Route::get('glossary/categories/create', 'GlossaryController@createCategory')->name('glossary.category.create');
    Route::post('glossary/categories/create', 'GlossaryController@saveCategory');
    Route::get('glossary/categories/edit/{id}', 'GlossaryController@editCategory')->name('glossary.category.edit');
    Route::post('glossary/categories/edit/{id}', 'GlossaryController@updateCategory');
    Route::get('glossary/categories/delete/{id}', 'GlossaryController@deleteCategory')->name('glossary.category.delete');

    // Items
    Route::get('glossary/items', 'GlossaryController@listItems')->name('glossary.items');
    Route::get('glossary/items/create', 'GlossaryController@createItems')->name('glossary.items.create');
    Route::post('glossary/items/create', 'GlossaryController@saveItems');
    Route::get('glossary/items/edit/{id}', 'GlossaryController@editItems')->name('glossary.items.edit');
    Route::post('glossary/items/edit/{id}', 'GlossaryController@updateItems');
    Route::get('glossary/items/delete/{id}', 'GlossaryController@deleteItems')->name('glossary.items.delete');
});

Route::group(array('prefix' => 'admin', 'middleware' => 'auth'), function () {
    Route::resource('posts', 'PostsController');
    Route::resource('categories', 'CategoriesController');
    Route::resource('tags', 'TagsController');
    Route::resource('labels', 'LabelsController');
    Route::resource('events', 'EventsController');
    Route::resource('locations', 'LocationsController');
    Route::resource('coins', 'CoinsController');

    //--- Avavailable for Editor Admin ---

    Route::get('tags/{id}/delete', array('as' => 'tags.delete', 'uses' => 'TagsController@getDelete'));
    Route::get('tags/{id}/confirm-delete', array('as' => 'tags.confirm-delete', 'uses' => 'TagsController@getModalDelete'));

    Route::get('posts/{id}/delete', array('as' => 'posts.delete', 'uses' => 'PostsController@getDelete'));
    Route::get('posts/{id}/confirm-delete', array('as' => 'posts.confirm-delete', 'uses' => 'PostsController@getModalDelete'));
});


Route::group(array('prefix' => 'admin', 'middleware' => 'auth.admin'), function () {
	Route::resource('comments', 'CommentsController');
	Route::get('comments/{id}/delete', array('as' => 'comments.delete', 'uses' => 'CommentsController@getDelete'));
	Route::get('comments/{id}/confirm-delete', array('as' => 'comments.confirm-delete', 'uses' => 'CommentsController@getModalDelete'));
});

Route::group(array('prefix' => 'admin', 'middleware' => 'auth.admin'), function () {
	Route::resource('users', 'UsersController');
	Route::get('users/{id}/delete', array('as' => 'users.delete', 'uses' => 'UsersController@getDelete'));
	Route::get('users/{id}/confirm-delete', array('as' => 'users.confirm-delete', 'uses' => 'UsersController@getModalDelete'));
});

//--- Executives part ---
$executiveAvailableForRoles = [USER::USER_EXECUTIVE_EDITOR, USER::USER_EDITOR, USER::USER_SUPER_ADMIN, User::USER_ADMIN ];
Route::group(array('prefix' => 'admin', 'middleware' => 'auth.check-role:'.implode(',', $executiveAvailableForRoles) ), function () {
    Route::get('executives/roles/', [ 'as' => 'executives.roles.index', 'uses' => 'ExecutivesController@listRoles']);
    Route::get('executives/roles/create', ['as' => 'executives.roles.create', 'uses' => 'ExecutivesController@createRole']);
    Route::post('executives/roles/create', ['uses' => 'ExecutivesController@storeRole']);
    Route::get('executives/roles/edit/{id}', ['as' => 'executives.roles.edit', 'uses' => 'ExecutivesController@editRole']);
    Route::post('executives/roles/edit/{id}', ['uses' => 'ExecutivesController@saveRole']);
    Route::get('executives/roles/delete/{id}', ['as' => 'executives.roles.delete', 'uses' => 'ExecutivesController@deleteRole']);
    Route::get('executives/supports/', [ 'as' => 'executives.supports.index', 'uses' => 'ExecutivesController@listSupports']);
    Route::get('executives/supports/create', ['as' => 'executives.supports.create', 'uses' => 'ExecutivesController@createSupports']);
    Route::post('executives/supports/create', ['uses' => 'ExecutivesController@storeSupports']);
    Route::get('executives/supports/edit/{id}', ['as' => 'executives.supports.edit', 'uses' => 'ExecutivesController@editSupports']);
    Route::post('executives/supports/edit/{id}', ['uses' => 'ExecutivesController@saveSupports']);
    Route::get('executives/supports/delete/{id}', ['as' => 'executives.supports.delete', 'uses' => 'ExecutivesController@deleteSupports']);

    Route::resource('executives', 'ExecutivesController');
    Route::get('executives/{id}/delete', array('as' => 'executives.delete', 'uses' => 'ExecutivesController@getDelete'));
    Route::get('executives/{id}/confirm-delete', array('as' => 'executives.confirm-delete', 'uses' => 'ExecutivesController@getModalDelete'));
});

Route::group(array('prefix' => 'admin', 'middleware' => 'auth.admin'), function () {
	Route::get('subscribers', ['uses' => 'AdminController@showIndexSubscribers']);
	Route::get('subscribers/{id}/delete', array('as' => 'subscribers.delete', 'uses' => 'AdminController@getDeleteSubscriber'));
	Route::get('subscribers/{id}/confirm-delete', array('as' => 'subscribers.confirm-delete', 'uses' => 'AdminController@getModalDeleteSubscriber'));

	Route::get('contact-form', ['uses' => 'AdminController@showIndexContactForm']);
	Route::get('contact-form/{id}/delete', array('as' => 'contact-form.delete', 'uses' => 'AdminController@getDeleteFromContactForm'));
	Route::get('contact-form/{id}/confirm-delete', array('as' => 'contact-form.confirm-delete', 'uses' => 'AdminController@getModalDeleteFromContactForm'));

});

Route::group(array('prefix' => 'admin', 'middleware' => 'auth.admin'), function () {
    Route::resource('redirects', 'RedirectController');
});

Auth::routes();