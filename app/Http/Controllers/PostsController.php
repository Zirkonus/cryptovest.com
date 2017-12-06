<?php

namespace App\Http\Controllers;

use App\Categories;
use App\CategoriesPosts;
use App\Comments;
use App\Executive;
use App\Http\Translate\Translate;
use App\Label;
use App\Language;
use App\LanguageValue;
use App\MetaContentForPost;
use App\Status;
use App\Tag;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Illuminate\View\View;
use Response;
use Image;
use Auth;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PostsController extends Controller
{
    public function index()
    {
        $languages = Language::get();
        if (Auth::user()->is_admin) {
            $posts = Post::orderBy('created_at', 'desc')->with('tags')->get();
        } else {
            $posts = Post::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->with('tags')->get();
        }

        return view('admin.posts.index', compact('posts', 'languages'));
    }

    public function create()
    {
        $categories = Categories::pluck('name_lang_key', 'id');
        $tags = Tag::pluck('name', 'id');
        $executives = Executive::get();
        $c = [];
        foreach ($categories as $key => $val) {
            $c[$key] = Translate::getValue($val);
        }
        $languages = Language::get();
        $statuses = Status::where('is_post', 1)->pluck('name', 'id');
        $authors = [];
        if (Auth::user()->is_admin) {
            $aut = User::get();
            foreach ($aut as $a) {
                $authors[$a->id] = Translate::getValue($a->first_name_lang_key) . ' ' . Translate::getValue($a->last_name_lang_key);
            }
        }
        $labels = Label::pluck('name', 'id');
        return view('admin.posts.create', compact('languages', 'c', 'statuses', 'authors', 'labels', 'tags', 'executives'));
    }

    public function store(Request $request)
    {
        $langmain = Language::where('is_english', 1)->first();

        if (!$request->input('title_' . $langmain->id)) {
            return redirect()->back()->withErrors('Title for English language is important!')->withInput();
        }
        if ($request->input('category') == '0') {
            return redirect()->back()->withErrors('Please choose category.')->withInput();
        }
        if ($request->input('status') == '0') {
            return redirect()->back()->withErrors('Please choose post status.')->withInput();
        }
        $catid = intval($request->input('category'));
        if (Auth::user()->is_admin) {
            $user_id = $request->input('author');
        } else {
            $user_id = Auth::user()->id;
        }
        $post = Post::create([
            'user_id' => $user_id,
            'category_id' => $catid
        ]);
        if ($request->input('keys')) {
            $keys = explode(',', $request->input('keys'));
            foreach ($keys as $val) {
                MetaContentForPost::create([
                    'language_id' => 1,
                    'meta_type_id' => 3,
                    'post_id' => $post->id,
                    'content' => $val
                ]);
            }
        }
        $url = Translate::storeKey($request->input('title_' . $langmain->id));
        $checkUrl = Post::whereHas('getCategory', function ($q) use ($catid) {
            $q->where('category_id', $catid);
        })->where('friendly_url', $url)->first();
        if ($checkUrl) {
            $url .= '-post-' . $post->id;
        }
        $post->friendly_url = $url;
        $post->title_lang_key = 'title-posts-' . $post->id;
        $post->description_lang_key = 'description-posts-' . $post->id;
        $post->content_lang_key = 'content-posts-' . $post->id;
        $post->status_id = intval($request->input('status'));

        if (intval($request->input('status')) == 4) {
            $post->submited_at = date('Y-m-d H:i:s', time());
        }

        //Tags
        if ($request->input('chosen_tag') && !empty($request->input('chosen_tag'))) {
            $arr = explode(',', $request->input('chosen_tag'));
            $selectedTagsId = Tag::whereIn('name', $arr)->pluck('id');
            $post->tags()->sync($selectedTagsId);
        }

        //Executives
        if ($request->input('chosen_executive') && !empty($request->input('chosen_executive'))) {
            $arr = explode(',', $request->input('chosen_executive'));
            $selectedExecutivesId = Executive::whereIn('url', $arr)->pluck('id');
            $post->executives()->sync($selectedExecutivesId);
        }

        if ($request->file('image')->isValid()) {
            $file = $request->file('image');
            $image = Image::make($request->file('image'));
            $fileName = $request->file('image')->getClientOriginalName();
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            Storage::makeDirectory('public/upload/images/posts/' . $post->id . '/origin');
            Storage::makeDirectory('public/upload/images/posts/' . $post->id . '/big');
            Storage::makeDirectory('public/upload/images/posts/' . $post->id . '/cat');
            Storage::makeDirectory('public/upload/images/posts/' . $post->id . '/min');
            Storage::makeDirectory('public/upload/images/posts/' . $post->id . '/small');
            $this->tinify->getFromBuffer((string)$image->encode($fileExtension))->toFile(storage_path("app/" . self::BASE_PATH . "posts/" . $post->id . '/origin/' . $fileName));

            if (!($image->width() < 1500) || !($image->height() < 1000)) {
                $image->resize(1500, 1000);
            }
            $this->imageOptimization($file, "posts/" . $post->id . "/big", $image, $post, "title_image", $fileName);

            $image = Image::make($request->file('image'))->resize(736, 480);

            $this->imageOptimization($file, "posts/" . $post->id . "/cat", $image, $post, "category_image", $fileName);

            $image = Image::make($request->file('image'))->resize(368, 240);
            $this->imageOptimization($file, "posts/" . $post->id . "/min", $image, $post, "short_image", $fileName);

            $image = Image::make($request->file('image'))->fit(120);
            $this->imageOptimization($file, "posts/" . $post->id . "/small", $image, $post, "small_image", $fileName);
        }

        if ($request->input('is_keep_featured')) {
            $p = Post::where('is_keep_featured' , 1)->first();
            if ($p) {
                $p->is_keep_featured = 0;
                $p->save();
            }
            $post->is_keep_featured = 1;
        }

        if ($request->label) {
            $post->label_id = $request->input('label');
        } else {
            $post->label_id = 0;
        }
        $request->is_exclusive ? $post->is_exclusive = 1 : $post->is_exclusive = 0;
        $request->hide_image ? $post->hide_image = 1 : $post->hide_image = 0;
        $request->is_ico_review ? $post->is_ico_review = 1 : $post->is_ico_review = 0;
        $post->save();

        $languages = Language::get();
        foreach ($languages as $lang) {
            if ($request->input('title_' . $lang->id) && !is_null($request->input('title_' . $lang->id))) {
                LanguageValue::create([
                    'language_id' => $lang->id,
                    'key' => $post->title_lang_key,
                    'value' => $request->input('title_' . $lang->id)
                ]);
            }
            if ($request->input('description_' . $lang->id) && !is_null($request->input('description_' . $lang->id))) {
                LanguageValue::create([
                    'language_id' => $lang->id,
                    'key' => $post->description_lang_key,
                    'value' => $request->input('description_' . $lang->id)
                ]);
            }
            if ($request->input('content_' . $lang->id) && !is_null($request->input('content_' . $lang->id))) {
                LanguageValue::create([
                    'language_id' => $lang->id,
                    'key' => $post->content_lang_key,
                    'value' => $request->input('content_' . $lang->id)
                ]);
            }
            if ($request->input('meta-title_' . $lang->id) && !is_null($request->input('meta-title_' . $lang->id))) {
                MetaContentForPost::create([
                    'language_id' => $lang->id,
                    'meta_type_id' => 1,
                    'post_id' => $post->id,
                    'content' => $request->input('meta-title_' . $lang->id)
                ]);
            }
            if ($request->input('meta-description_' . $lang->id) && !is_null($request->input('meta-description_' . $lang->id))) {
                MetaContentForPost::create([
                    'language_id' => $lang->id,
                    'meta_type_id' => 2,
                    'post_id' => $post->id,
                    'content' => $request->input('meta-description_' . $lang->id)
                ]);
            }
        }
        $this->createXML();
        return redirect('admin/posts')->with('success', 'Post was created');
    }

    public function edit($id)
    {
        $post = Post::with('getMetaContent', 'tags')->find($id);
        if (!Auth::user()->is_admin) {
            if ($post->user_id != Auth::user()->id) {
                return redirect()->back()->withErrors('error', 'Wrong User!');
            }
        }

        $languages = Language::get();
        $categories = Categories::get();
        $tags = Tag::pluck('name', 'id');
        $executives = Executive::get();
        $cat = [];

        foreach ($categories as $c) {
            $cat[$c->id] = Translate::getValue($c->name_lang_key);
        }
        $statuses = Status::where('is_post', 1)->pluck('name', 'id');
        $authors = [];
        if (Auth::user()->is_admin) {
            $users = User::get();
            foreach ($users as $u) {
                $authors[$u->id] = Translate::getValue($u->first_name_lang_key) . ' ' . Translate::getValue($u->last_name_lang_key);
            }
        }
        $labels = Label::pluck('name', 'id');
        return view('admin.posts.edit', compact('languages', 'categories', 'statuses', 'post', 'cat', 'authors', 'labels', 'tags', 'executives'));
    }

    public function update($id, Request $request)
    {
        $post = Post::find($id);
        $langId = Translate::getEnglishId();

        if ($post->friendly_url != $request->input('friendly_url')) {
            $url = Translate::storeKey($request->input('friendly_url'));

            $posttest = Post::where(['friendly_url' => $url, 'category_id' => $request->input('category')])->first();

            if ($posttest) {
                return redirect()->back()->withErrors('This URL used!')->withInput();
            }
            $post->friendly_url = $url;
        }

        if ($request->input('keys')) {
            MetaContentForPost::where([
                'post_id' => $post->id,
                'meta_type_id' => 3,
            ])->delete();
            $keys = explode(',', $request->input('keys'));
            foreach ($keys as $val) {
                MetaContentForPost::create([
                    'post_id' => $post->id,
                    'language_id' => $langId,
                    'meta_type_id' => 3,
                    'content' => $val
                ]);
            }
        }

        $post->category_id = $request->input('category');
        //Tags
        if ($request->input('chosen_tag') && !empty($request->input('chosen_tag'))) {
            $arr = explode(',', $request->input('chosen_tag'));
            $selectedTagsId = Tag::whereIn('name', $arr)->pluck('id');
            $post->tags()->sync($selectedTagsId);
        }

        //Executives
        if ($request->input('chosen_executive') && !empty($request->input('chosen_executive'))) {
            $arr = explode(',', $request->input('chosen_executive'));
            $selectedExecutivesId = Executive::whereIn('url', $arr)->pluck('id');
            $post->executives()->sync($selectedExecutivesId);
        }

        $post->user_id = $request->input('author') ?: Auth::user()->id;
        if ($request->label) {
            $post->label_id = $request->input('label');
        } else {
            $post->label_id = 0;
        }

        $request->is_exclusive ? $post->is_exclusive = 1: $post->is_exclusive = 0;
        $request->hide_image ? $post->hide_image = 1: $post->hide_image = 0;
        $request->is_ico_review ? $post->is_ico_review = 1: $post->is_ico_review = 0;
		if ($post->status_id != $request->input('status')) {
			$post->status_id = $request->input('status');
		}
        if ($request->file('new-image')) {
            $file = $request->file('new-image');
            $image = Image::make($request->file('new-image'));
            $fileName = $request->file('new-image')->getClientOriginalName();
            $fileExtension = $request->file('new-image')->getClientOriginalExtension();
            Storage::makeDirectory('public/upload/images/posts/' . $post->id . '/origin');
            Storage::makeDirectory('public/upload/images/posts/' . $post->id . '/big');
            Storage::makeDirectory('public/upload/images/posts/' . $post->id . '/cat');
            Storage::makeDirectory('public/upload/images/posts/' . $post->id . '/min');
            Storage::makeDirectory('public/upload/images/posts/' . $post->id . '/small');

            $this->tinify->getFromBuffer((string)$image->encode($fileExtension))->toFile(storage_path("app/" . self::BASE_PATH . "posts/" . $post->id . '/origin/' . $fileName));

            if (!($image->width() < 1500) || !($image->height() < 1000)) {
                $image->resize(1500, 1000);
            }
            $this->imageOptimization($file, "posts/" . $post->id . "/big", $image, $post, "title_image", $fileName);
            $image = Image::make($request->file('new-image'))->resize(736, 480);

            $this->imageOptimization($file, "posts/" . $post->id . "/cat", $image, $post, "category_image", $fileName);

            $image = Image::make($request->file('new-image'))->resize(368, 240);
            $this->imageOptimization($file, "posts/" . $post->id . "/min", $image, $post, "short_image", $fileName);

            $image = Image::make($request->file('new-image'))->fit(120);
            $this->imageOptimization($file, "posts/" . $post->id . "/small", $image, $post, "small_image", $fileName);
        }

		if ($request->input('created_at')) {
			$post->created_at =  strtotime($request->input('created_at'));
		}
		if ($request->input('is_keep_featured')) {
			if ($post->is_keep_featured == 0) {
				$p = Post::where('is_keep_featured', 1)->first();
				if ($p) {
					$p->is_keep_featured = 0;
					$p->save();
				}
				$post->is_keep_featured = 1;
			}
		} else {
			$post->is_keep_featured = 0;
		}
		$post->save();

		$languages = Language::get();
		foreach ($languages as $lang) {
			if (!is_null($request->input('title_' . $lang->id))) {
				$val = LanguageValue::where(['language_id' => $lang->id, 'key' => $post->title_lang_key])->first();
				if ($val->value != $request->input('title_' . $lang->id)) {
					$val->value = $request->input('title_' . $lang->id);
					$val->save();
				}
			}
			if (!is_null($request->input('description_' . $lang->id))) {
				$val = LanguageValue::where(['language_id' => $lang->id, 'key' => $post->description_lang_key])->first();
				if ($val->value != $request->input('description_' . $lang->id)) {
					$val->value = $request->input('description_' . $lang->id);
					$val->save();
				}
			}
			if (!is_null($request->input('content_' . $lang->id))) {
				$val = LanguageValue::where(['language_id' => $lang->id, 'key' => $post->content_lang_key])->first();
				if ($val->value != $request->input('content_' . $lang->id)) {
					$val->value = $request->input('content_' . $lang->id);
					$val->save();
				}
			}
			if (!is_null($request->input('meta-title_' . $lang->id))) {
				$val = MetaContentForPost::where(['language_id' => $lang->id, 'post_id' => $post->id, 'meta_type_id' => 1])->first();
				if ($val->content != $request->input('meta-title_' . $lang->id)) {
					$val->content = $request->input('meta-title_' . $lang->id);
					$val->save();
				}
			}
			if (!is_null($request->input('meta-description_' . $lang->id))) {
				$val = MetaContentForPost::where(['language_id' => $lang->id, 'post_id' => $post->id, 'meta_type_id' => 2])->first();
				if ($val->content != $request->input('meta-description_' . $lang->id)) {
					$val->content = $request->input('meta-description_' . $lang->id);
					$val->save();
				}
			}
		}

        $this->createXML();
        return redirect('admin/posts')->with('success', 'Post was Updated');
    }

    public function getModalDelete($id = null)
    {
        $error = '';
        $model = '';
        $confirm_route = route('posts.delete', ['id' => $id]);

        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        $post = Post::find($id);

        foreach ($post->tags as $tag) {
            $post->tags()->detach($tag);
        }

        if ($post->user_id != Auth::user()->id) {
            if (!Auth::user()->is_admin) {
                return redirect()->back()->withErrors('Wrong User Post');
            }
        }

        Comments::where('post_id', $post->id)->delete();
        MetaContentForPost::where('post_id', $post->id)->delete();
        LanguageValue::where('key', $post->title_lang_key)->delete();
        LanguageValue::where('key', $post->content_lang_key)->delete();
        LanguageValue::where('key', $post->description_lang_key)->delete();
        $post->delete();
        return redirect('admin/posts')->with('success', 'Post was deleted success.');
    }

    protected function createXML()
    {
        // create new sitemap object
        $sitemap = App::make("sitemap");

        // get all posts from db
        $posts = Post::whereHas('getCategory', function ($query) {
            $query->where('friendly_url', 'news');
            $query->orWhere('parent_id', 1);
        })
            ->where('status_id', 4)
            ->whereDate('created_at', '>', date('Y-m-d', strtotime('-2days')))
            ->orderBy('created_at', 'desc')
            ->get();
        // add every post to the sitemap
        foreach ($posts as $post) {
            $googlenews = [];
            $googlenews['sitename'] = 'Cryptovest';
            $googlenews['language'] = 'en';
            $googlenews['publication_date'] = $post->created_at;
            if ($post->getCategory->parent_id) {
                $googlenews['genres'][] = $post->getCategory->friendly_url;
            }
            $keywords = MetaContentForPost::where('post_id', $post->id)->where('meta_type_id', 3)->pluck('content')->toArray();
            $keywords = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $keywords);
            if (count($keywords)) {
                $googlenews['keywords'] = $keywords;
            }
            $loc = url('/') . '/' . $post->getCategory->full_url . $post->getCategory->friendly_url . '/' . $post->friendly_url . '/';
            $title = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', Translate::getValue($post->title_lang_key));
            $sitemap->add($loc, null, null, null, [], $title, [], [], $googlenews);
        }

        // generate your sitemap (format, filename)
        $sitemap->store('google-news', 'news-sitemap');
        // this will generate file mysitemap.xml to your public folder
    }


    public function getNextPost(Request $request)
    {
        $postId = $request->input("id");
        $postCategory = $request->input("category");
        if ($postId) {
            if ($postCategory) {
                $post = Post::where('id', '<', $postId)->where('category_id', $postCategory)->orderBy("id", "desc")->first();
            } else {
                $post = Post::where('id', '<', $postId)->orderBy("id", "desc")->first();
            }
            $post = $post === null ? null : $post;

            if (count($post) > 0) {
                $posts = Post::where('status_id', 4);
                $posts->whereHas('getCategory', function ($q) use ($postCategory) {
                    $q->where('id', $postCategory);
                });
                $posts->where('id', '!=', $postId)->orderBy('created_at', 'desc')->limit(3);
                $latestPosts = $posts->get();

                $posts = Post::where('status_id', 4);
                $posts->whereHas('getCategory', function ($q) use ($postCategory) {
                    $q->where('id', '!=', $postCategory);
                });
                $posts->orderBy('created_at', 'desc')->limit(2);
                $otherPosts = $posts->get();
                $likesPost = Post::where('status_id', 4)
                    ->where('id', '!=', $postId)
                    ->whereHas('getAuthor', function ($query) use ($post) {
                        $query->where('id', $post->getAuthor->id);
                    })
                    ->orderBy('created_at', 'DESC')->take(6)->get();
                $content = view('front-end.post-template', compact('post', 'latestPosts', 'otherPosts', 'likesPost'))->render();
            } else {
                $content = [];
            }
            return $content;
        }
    }

    public function returnTablePostsWithKeywords()
    {
        $allKeyWords = MetaContentForPost::keywordType()->get()->groupBy('content');

        $returnData = 'Keyword, Posts' . PHP_EOL;
        foreach ($allKeyWords as $keyWord => $posts) {
            $postIds = $posts->pluck('post_id')->implode('\\');
            $returnData .= trim(str_replace(',', ' ', $keyWord)) . ', ' . $postIds . PHP_EOL;
        }

        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="KeywordBindWithPosts.csv"',
        );

        return Response::make(rtrim($returnData, "\n"), 200, $headers);

    }


}
