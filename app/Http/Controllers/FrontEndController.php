<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Categories;
use App\City;
use App\Event;
use App\Country;
use App\GlossaryCategory;
use App\GlossaryItem;
use App\Executive;
use App\ExecutiveRole;
use App\Http\Translate\Translate;
use App\ICOComments;
use App\ICOProjects;
use App\LanguageValue;
use App\SubscribersCategories;
use App\Mail\ContactForm as ContactMail;
use App\Comments;
use App\CryptoMoney;
use App\Page;
use App\Post;
use App\Subscriber;
use App\Tag;
use App\User;
use App\ContactForm;
use App\MoneyStatistic;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Log;
use Mail;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use function Sodium\library_version_major;

class FrontEndController extends Controller
{
    public function index(Request $request)
    {
        if ($request->s) {
            return $this->searchPostPaginate($request);
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

        $mainNews = Post::with('getCategory.getChildrens')->whereIn('category_id', $childs['news'])
            ->where(['status_id' => 4, 'is_keep_featured' => 1])->first();
        if (!$mainNews) {
            $mainNews = Post::with('getCategory.getChildrens')->whereIn('category_id', $childs['news'])
                ->where('status_id', 4)->orderBy('created_at', 'desc')->first();
        }

        $mainReviewsSmall = Post::where('status_id', 4)->where('is_ico_review', 1)->orderBy('created_at', 'desc')->limit(4)->get();

        //new
        $mainReviews = Post::with('getCategory')->whereIn('category_id', $childs['reviews'])
            ->where('status_id', 4)->orderBy('created_at', 'desc')->first();
        //endnew

        $mainEducation = Post::with('getCategory.getChildrens')->whereIn('category_id', $childs['education'])
            ->where('status_id', 4)->orderBy('created_at', 'desc')->first();

        $arr = [];

        if ($mainReviewsSmall) {
            foreach ($mainReviewsSmall as $rev) {
                $arr[] = $rev->id;
            }
        }
        if ($mainReviews) {
            $arr[] = $mainReviews->id;
        }
        if ($mainNews) {
            $arr[] = $mainNews->id;
        }
        if ($mainEducation) {
            $arr[] = $mainEducation->id;
        }
        $lastPost = Post::with('getCategory', 'getAuthor', 'getLabel')->where('label_id', '!=', 0)->orderBy('updated_at')->limit(4)->get();
        foreach ($lastPost as $l) {
            $arr[] = $l->id;
        }
        
        if ($lastPost->count() < 4) {
            $lastPostAdd = Post::whereNotIn('id', $arr)->where('status_id', 4)
                ->whereHas('getCategory', function ($query) {
                    $query->where('id', 1);
                    $query->orWhere('parent_id', 1);
                })
                ->orderBy('created_at', 'desc')->limit(4 - $lastPost->count())->get();
            foreach ($lastPostAdd as $l) {
                $lastPost->push($l);
                $arr[] = $l->id;
            }
        }

        $topICOs = [];
        $topICOsactive = ICOProjects::where('data_end', '>', date('Y-m-d H:i:s', time()))
            ->where('is_active', 1)
            ->where('is_widget', 1)
            ->where('is_fraud', 0)
            ->orderBy('ico_promotion_id')
            ->orderBy('data_end')
            ->limit(3)
            ->get();
        if ($topICOsactive) {
            foreach ($topICOsactive as $ico) {
                $topICOs[] = [
                    'diff' => $this->getTimeDiff($ico),
                     'ico' => $ico
                 ];
            }
        }
        $upccoming = ICOProjects::where('data_start', '>', date('Y-m-d H:i:s', time()))
            ->where('data_end', '>', date('Y-m-d H:i:s', time()))
            ->where('is_active', 1)
            ->orderBy('ico_promotion_id')
            ->orderBy('data_start')
            ->limit(7)
            ->get();
        if ($upccoming) {
            foreach ($upccoming as $ico) {
                $upcomingICOs[] = ['diff' => $this->getTimeDiff($ico), 'ico' => $ico];
            }
        }

        $news = Post::with('getCategory', 'getAuthor')->whereIn('category_id', $childs['news'])
            ->whereNotIn('id', $arr)->where('status_id', 4)->orderBy('created_at', 'desc')->limit(6)->get();
        $reviews = Post::with('getCategory', 'getAuthor')->whereIn('category_id', $childs['reviews'])
            ->whereNotIn('id', $arr)->where('status_id', 4)->orderBy('created_at', 'desc')->limit(6)->get();
        $education = Post::with('getCategory', 'getAuthor')->whereIn('category_id', $childs['education'])
            ->whereNotIn('id', $arr)->where('status_id', 4)->orderBy('created_at', 'desc')->limit(6)->get();


        $moneys = MoneyStatistic::where('money_id', '>', 0)->orderBy('created_at', 'desc')->orderBy('price_usd', 'desc')->limit(3)->get();

        $topSixIcos = ICOProjects::where("is_top_six", 1)->where("is_active", 1)->orderBy('ico_promotion_id')->limit(6)->get();

        $topSixIcosResult = [];
        foreach ($topSixIcos as $ico) {
            if (file_exists(public_path() . "/" . $ico->image)) {
                $icoImage = asset($ico->image);
            } else {
                $icoImage = $ico->image;
            }

            $time = $this->getTimeDiff($ico);
            if ($ico->getPromotion->id != 10) {
                $medalStatus = $ico->getPromotion->id < 3 ? "featured" : "normal";
                $medalIcon = asset($ico->getPromotion->icon);
            } else {
                $medalStatus = "";
                $medalIcon = "";
            }

            array_push($topSixIcosResult, [
                'name' => $ico->title,
                'icoImage' => $icoImage,
                'url' => $ico->friendly_url,
                'category' => $ico->getCategory ? $ico->getCategory->name : "",
                'tab' => $time["tab"],
                'diff_days' => $time["diff_days"],
                'short_date' => $time["short_date"],
                'percent' => $time["percent"],
                'medalStatus' => $medalStatus,
                'medalIcon' => $medalIcon
            ]);

        }

        return view('front-end.index', compact('news', 'reviews', 'education', 'lastPost', 'mainEducation', 'mainNews', 'mainReviews', 'bitcoin', 'moneys', 'topICOs', 'upcomingICOs', 'mainReviewsSmall', 'topSixIcosResult'));
    }

    public function contactPage()
    {
	    $page = Page::where('friendly_url', 'contact')->first();
	    return view('front-end.contact', compact('page'));
    }

	public function aboutPage()
	{
		$page = Page::where('friendly_url', 'about')->first();
		$users = User::get();
		return view('front-end.about', compact('users', 'page'));
	}

	public function showPostorCateg(Request $request, $category, $postOrcateg)
	{
		$categ = Categories::with(['getParentCateg' => function ($q) use ($category){
			$q->where(['friendly_url' => $category, 'parent_id' => 0]);
		}])->where('friendly_url', $postOrcateg)->first();

		if ($categ) {
			$takeData = $this->getItemsForCategory($postOrcateg, $category);
			$categ      = $takeData['categ'];
			$topPost    = $takeData['topPost'];
			$posts      = $takeData['posts'];

			$pagination = Post::with(['getCategory', 'getAuthor'])->whereIn('category_id', $takeData['arrayOfId'])->where('status_id', 4)->whereNotIn('id',$takeData['postOnPage'])->orderBy('created_at', 'desc')->paginate(6);

            $topPost = $this->getMainPostsForView($topPost);

			return view('front-end.category', compact('categ', 'topPost', 'posts', 'pagination'));
		}
		$postCheck = $this->getAllForPost($postOrcateg, $category);
		if ($postCheck) {
			$post           = $postCheck['post'];
			$latestPosts    = $postCheck['latestPosts'];
			$otherPosts     = $postCheck['otherPosts'];
            $likesPost = Post::where('status_id', 4)
                ->where('id', '!=', $post->id)
                ->latest()->take(6)->get();

//			return view('front-end.post', compact('post', 'latestPosts', 'otherPosts', 'likesPost'));
            $ampGenerated = $this->getAmpView($request);
            return view($ampGenerated["path"], [
                'post' => $this->parseAmpContent($post, $request),
                'latestPosts' => $latestPosts,
                'otherPosts' => $otherPosts,
                'likesPost' => $likesPost,
                'url' => $ampGenerated["url"],
                'ampUrl' => $ampGenerated["ampUrl"]
            ]);
		}

		return abort('404');
	}

	public function showPostorCategOrPagePaginate(Request $request, $category, $postOrcateg, $page)
    {
        $categ = Categories::with(['getParentCateg' => function ($q) use ($category){
            $q->where(['friendly_url' => $category, 'parent_id' => 0]);
        }])->where('friendly_url', $postOrcateg)->first();

        if ($categ) {
            $takeData = $this->getItemsForCategory($postOrcateg, $category);
            $categ      = $takeData['categ'];
            $topPost    = $takeData['topPost'];
            $posts      = $takeData['posts'];

            $pagination = Post::whereIn('category_id', $takeData['arrayOfId'])->where('status_id', 4)->whereNotIn('id',$takeData['postOnPage'])->orderBy('created_at', 'desc')->paginate(6, null, null, $page);
            $new_pagination = true;
            return view('front-end.category', compact('categ', 'topPost', 'posts', 'pagination', 'new_pagination'));
        }
        $postCheck = $this->getAllForPost($postOrcateg, $category);
        if ($postCheck) {
            $post           = $postCheck['post'];
            $latestPosts    = $postCheck['latestPosts'];
            $otherPosts     = $postCheck['otherPosts'];

//            return view('front-end.post', compact('post', 'latestPosts', 'otherPosts'));
            $ampGenerated = $this->getAmpView($request);
            return view($ampGenerated["path"], [
                'post' => $this->parseAmpContent($post, $request),
                'latestPosts' => $latestPosts,
                'otherPosts' => $otherPosts,
                'url' => $ampGenerated["url"],
                'ampUrl' => $ampGenerated["ampUrl"]
            ]);
        }

        return abort('404');


    }

    public function showParentPost(Request $request, $parent, $categ, $post)
    {
        $postCheck = $this->getAllForPost($post, $categ, $parent);
        if ($postCheck) {
            $post = $postCheck['post'];
            $latestPosts = $postCheck['latestPosts'];
            $otherPosts = $postCheck['otherPosts'];
            $likesPost = Post::where('status_id', 4)
                ->where('id', '!=', $post->id)
                ->latest()->take(6)->get();

//		return view('front-end.post', compact('post', 'latestPosts', 'otherPosts', 'likesPost'));
            $ampGenerated = $this->getAmpView($request);
            return view($ampGenerated["path"], [
                'post' => $this->parseAmpContent($post, $request),
                'latestPosts' => $latestPosts,
                'otherPosts' => $otherPosts,
                'likesPost' => $likesPost,
                'url' => $ampGenerated["url"],
                'ampUrl' => $ampGenerated["ampUrl"]
            ]);
        }
        $cat = Categories::where('friendly_url', $post)->whereHas('getParentCateg', function ($q) use ($categ) {
            $q->where('friendly_url', $categ);
        })->first();
        if ($cat) {
            $takeData = $this->getItemsForCategory($post, $categ);
            $categ = $takeData['categ'];
            $topPost = $takeData['topPost'];
            $posts = $takeData['posts'];

            $pagination = Post::with(['getCategory', 'getAuthor'])->whereIn('category_id', $takeData['arrayOfId'])->where('status_id', 4)->whereNotIn('id', $takeData['postOnPage'])->orderBy('created_at', 'desc')->paginate(6);
            return view('front-end.category', compact('categ', 'topPost', 'posts', 'pagination'));
        }
        return abort('404');
    }

    /**
     * Set view address, generate normal and amp url
     *
     * @param Request $request
     * @return string
     */
    protected function getAmpView(Request $request)
    {
        $path = "front-end.";
        $prefix = $request->route()->getPrefix();
        if ($prefix === "/amp") {
            $path .= "amp.";
            $url = str_replace($prefix, "", $request->url());
            $ampUrl = $request->url();
        } else {
            $url = $request->url();
            $parsedUrl = parse_url($url);
            $parsedUrl["path"] = "/amp" . $parsedUrl["path"];
            $ampUrl = $this->glueUrl($parsedUrl);
        }
        $path .= "post";
        $result = [];
        $result["path"] = $path;
        $result["url"] = $url;
        $result["ampUrl"] = $ampUrl;
        return $result;
    }

    /**
     * Glue Parsed by parse_url url to normal
     *
     * @param array $parsed
     * @return string
     */
    protected function glueUrl(array $parsed)
    {
        $get = function ($key) use ($parsed) {
            return isset($parsed[$key]) ? $parsed[$key] : null;
        };

        $pass = $get('pass');
        $user = $get('user');
        $userinfo = $pass !== null ? "$user:$pass" : $user;
        $port = $get('port');
        $scheme = $get('scheme');
        $query = $get('query');
        $fragment = $get('fragment');
        $authority =
            ($userinfo !== null ? "$userinfo@" : '') .
            $get('host') .
            ($port ? ":$port" : '');

        return
            (strlen($scheme) ? "$scheme:" : '') .
            (strlen($authority) ? "//$authority" : '') .
            $get('path') .
            (strlen($query) ? "?$query" : '') .
            (strlen($fragment) ? "#$fragment" : '');
    }

    protected function parseAmpContent($data, Request $request)
    {
        if ($request->route()->getPrefix() === "/amp") {
            $titleImage = $data->title_image;
            if(file_exists(public_path() . "/" . $titleImage)) {
                $result = substr($titleImage, 0, strrpos($titleImage, '/') + 1) . rawurlencode(substr($titleImage, strrpos($titleImage, '/') + 1));
                $image = getimagesize(public_path() . "/" . $titleImage);
                $data->title_image_width = $image[0];
                $data->title_image_height = $image[1];
                $data->title_image = $result;
            }
            $content = Translate::getValue($data->content_lang_key);
            $postData = preg_replace("/<img\s(.+?)>/is", "<amp-img layout='responsive' $1></amp-img>", $content);
            $postData = preg_replace("/(\<iframe.*<\/iframe\>)/", "", $postData);
            $postData = preg_replace("/<video([\s\S]*?)<\/video>/", "", $postData);
            $data->content = $postData;
        }
        return $data;
    }

	protected function getAllForPost ($link, $categ , $parent = NULL) {

    	$p = Post::where(['friendly_url' => $link, 'status_id' => 4]);
    	if ($categ && $parent == NULL){
			$p->whereHas('getCategory', function($q) use ($categ) {
				$q->where(['friendly_url' => $categ, 'parent_id' => 0]);
			});
	    } else if ($categ && $parent) {
		    $p->whereHas('getCategory', function($q) use ($categ, $parent) {
			    $q->whereHas('getParentCateg', function ($qa) use ($parent) {
			        $qa->where('friendly_url', $parent);
			    })->where('friendly_url' , $categ );
		    });
	    }
		$post = $p->with('tags')
                  ->with(['executives' => function ($query) {
		                    $query->where('is_active', true);
        }])->first();

		if ($post) {
			$p = Post::where('status_id' , 4);
			$p->whereHas('getCategory', function($q) use($categ) {
				$q->where('friendly_url', $categ);
			});
			$p->where('id','!=',$post->id)->orderBy('created_at', 'desc')->limit(3);
			$latestPosts = $p->get();

			$p = Post::where('status_id', 4);
			$p->whereHas('getCategory', function($q) use($categ) {
				$q->where('friendly_url', '!=', $categ);
			});
			$p->orderBy('created_at', 'desc')->limit(2);
			$otherPosts = $p->get();
			return ['post' => $post, 'latestPosts' => $latestPosts, 'otherPosts' => $otherPosts];
		}
		return false;
	}


	public function showAuthorPage($url)
	{
		$user = User::where('url', $url)->first();

		if (!$user) {
			abort('404');
		}
		$posts = Post::where(['user_id' => $user->id, 'status_id' => 4])->orderBy('created_at', 'desc')->paginate(6);

		return view('front-end.author', compact('user', 'posts'));
	}

	public function showTagPage($tag)
    {
        $tag = Tag::where('slug', $tag)->first();

        if (!$tag) {
            abort(404);
        }

        $posts = $tag->posts()->where('status_id', 4)->orderBy('created_at', 'desc')->paginate(6);

        return view('front-end.tag', compact('tag', 'posts'));
    }

	public function getNewComment(Request $request)
	{
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => 'required|captcha',
            'textareaComments' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back();
        }

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

		Comments::create([
			'post_id'       => $request->input('postId'),
			'status_id'     => 1,
			'writer_name'   => $request->input('inputName'),
			'writer_email'  => $request->input('inputEmail'),
			'content'       => $request->input('textareaComments'),
            'ip'            => $ip
		]);
		return redirect()->back()->with('successSendMessage', 'Thanks for your message!');
	}

	public function subscribeCategory(Request $request)
	{
	    if ($request->interests) {
            $sub = session('subscriber');
            $interests = [];
            if ($request->ico) {
                $interests[] = "ICO Opportunities";
            }
            if ($request->news) {
                $interests[] = "News";
            }
            if ($request->reviews) {
                $interests[] = "Reviews";
            }
            $sub->interests = implode(', ', $interests);
            $sub->save();
            $request->session()->forget('subscriber');
            return back()->with('successSendMessage', 'subscribe');
        }
		$categ  = Categories::where('friendly_url', $request->input('categoryName'))->first();
		$test   = $this->getParent($categ);

		if ($test[0] == 'news') {
			$category = Categories::where(['friendly_url' => $test[0], 'parent_id' => 0])->get();
		} else {
			$cats = Categories::where('parent_id', 0)->get();
			$category = $cats->where('friendly_url', '!=','news');
		}
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		foreach ($category as $c) {
			$sub = Subscriber::where([
				'ip'    => $ip,
				'email' => $request->input('inputEmail')
			])->first();

			if (!$sub) {
				$sub = Subscriber::create([
					'name'   => $request->input('inputName'),
					'email'  => $request->input('inputEmail'),
					'ip'     => $ip
				]);
			}
			$check = SubscribersCategories::where(['category_id' => $c->id, 'subscriber_id' => $sub->id])->first();
			if (!$check) {
				SubscribersCategories::create([
					'category_id'   => $c->id,
					'subscriber_id' => $sub->id
				]);
			}
		}
		session(['subscriber' => $sub]);
		return response()->json('success');
	}

    public function getMessageFromContactForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => 'required|captcha',
            'email' => 'required|email',
            'department' => 'required|in:1,2',
        ]);


        $sendto = env("ADMIN_EMAIL");
        if ($request->department == 2) {
            $sendto = env("EDITORIAL_EMAIL");

        }
        $request->department == 1 ? $dep = 'General & Sales' : $dep = 'Editorial';

        if ($validator->fails()) {
            return redirect()->back();
        }

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        ContactForm::create([
            'first_name' => $request->input('first-name') ?: '',
            'last_name' => $request->input('last-name') ?: '',
            'company' => $request->input('company') ?: '',
            'email' => $request->input('email'),
            'phone' => $request->input('phone') ?: '',
            'post_content' => $request->input('content') ?: '',
            'department' => $dep,
            'ip' => $ip
        ]);

        $data = [];
        $data["name"] = $request->input('first-name') . ' ' . $request->input('last-name');
        $data["phone"] = $request->input('phone');
        $data["email"] = $request->input('email');
        $data["company"] = $request->input('company');
        $data["content"] = $request->input('content');

        try {
            Mail::to([$sendto])->send(new ContactMail($data));
            return redirect()->back()->with('successSendMessage', 'Thank you for contacting Cryptovest, we will reply shortly.');
        } catch (Exception $e) {
            return redirect()->back()->with('successSendMessage', 'Thank you for contacting Cryptovest. We have a problem with our mail server, but we will reply shortly');
            logger("errors", [$e]);
        }
//        Mail::raw($message, function ($m) use ($email, $sendto) {
//            $m->from(env("ADMIN_EMAIL"));
//            $m->to($sendto);
//        });
//        mail($sendto, 'Contact', $message);
//        if ($success) {
//            return redirect()->back()->with('successSendMessage', 'Thank you for contacting Cryptovest, we will reply shortly.');
//        }
//        return redirect()->back()->with('successSendMessage', 'Thank you for contacting Cryptovest. We have a problem with our mail server, but we will reply shortly');
    }


	public function getLatestPosts()
	{
		return 123;
	}

	public function showBanner()
	{
		$banner = Banner::first();
		header('Content-Type: image/jpeg');
		$banner->views_count++;
		$banner->save();

		return file_get_contents($banner->image);
	}

	public function clickBanner()
	{
		$banner = Banner::first();
		$banner->clicks_count++;
		$banner->save();
		return redirect($banner->url);
	}

    public function showCateg($link)
    {
        $takeData = $this->getItemsForCategory($link);
        $categ      = $takeData['categ'];
        $topPost    = $takeData['topPost'];
        $posts      = $takeData['posts'];

        $pagination = Post::whereIn('category_id', $takeData['arrayOfId'])->where('status_id', 4)->whereNotIn('id',$takeData['postOnPage'])->orderBy('created_at', 'desc')->paginate(6);

        $topPost = $this->getMainPostsForView($topPost);
        $pagination = $this->getMainPostsForView($pagination);

        return view('front-end.category', compact('categ', 'topPost', 'posts', 'pagination'));
    }

	public function showCategOrPagePaginate($link, $page)
	{
		$categ = Categories::where('friendly_url', $link)->firstOrFail();
		if ($page > 1000) {
		    return redirect("/$link", 301);
        }
		if ($categ->parent_id != 0) {
			$takeData = $this->getItemsForCategory($link, $categ->getParentCateg->friendly_url);
		} else {
			$takeData = $this->getItemsForCategory($link);
		}

		$categ      = $takeData['categ'];
		$topPost    = $takeData['topPost'];
		$posts      = $takeData['posts'];

		$pagination = Post::whereIn('category_id', $takeData['arrayOfId'])->where('status_id', 4)->whereNotIn('id',$takeData['postOnPage'])->orderBy('created_at', 'desc')->paginate(6, null, null, $page);
		$new_pagination = true;
        $pagination = $this->getMainPostsForView($pagination);

		return view('front-end.category', compact('categ', 'topPost', 'posts', 'pagination', 'new_pagination'));
	}

	protected function getItemsForCategory($link , $parent_categ = NULL)
    {
	    $c      = Categories::where('friendly_url', $link);
	    if ($parent_categ) {
	        $c->whereHas('getParentCateg', function ($q) use ($parent_categ){
	        	$q->where('friendly_url', $parent_categ);
	        });
	    }
	    $categ = $c->first();
	    if (!$categ) {
	    	return abort('404');
	    }
	    $categChild = [];
	    foreach($categ->getChildrens as $child) {
		    $categChild[] = $child->id;
	    }
	    $arrayOfId      = $this->getAllChildrens($categChild);
	    $arrayOfId[]    = $categ->id;
	    $topPost        = [];
	    $postOnPage     = [];
	    $nonSub         = [];
		if (count($categChild) > 0) {
			for ($i = 0; $i < 2; $i++) {
				if (isset($categChild[$i]) && $categChild[$i]) {
					$pp = Post::whereIn('category_id', $categChild)->where('status_id', 4);
					if (count($postOnPage) > 0) {
						$pp->whereNotIn('id', $postOnPage);
					}
					if (count($nonSub) > 0) {
						$pp->whereNotIn('category_id', $nonSub);
					}
					$pp->orderBy('created_at', 'desc');
					$p = $pp->first();
					if ($p) {
						if ($p->category_id != $categ->id) {
							$nonSub[]   = $p->category_id;
						}
						$topPost[]      = $p;
						$postOnPage[]   = $p->id;
					} else {
						$p = Post::where(['category_id' => $categ->id, 'status_id' => 4])->whereNotIn('id', $postOnPage)->orderBy('created_at', 'desc')->first();
						if ($p) {
							$topPost[] = $p;
							$postOnPage[] = $p->id;
						}
					}
				} else {
					$p = Post::where(['category_id' => $categ->id, 'status_id' => 4])->whereNotIn('id', $postOnPage)->orderBy('created_at', 'desc')->first();
					if ($p) {
						$topPost[]      = $p;
						$postOnPage[]   = $p->id;
					}
				}
			}
		} else {
			for ($i = 0; $i < 2; $i++) {
				$p = Post::where(['category_id' => $categ->id, 'status_id' => 4])->whereNotIn('id',$postOnPage)->orderBy('created_at', 'desc')->first();
				if ($p) {
					$topPost[]      = $p;
					$postOnPage[]   = $p->id;
				}
			}
		}
	    foreach ($topPost as $k => $val) {
		    if (!$val){
			    $p           = Post::whereIn('category_id', $arrayOfId)->whereNotIn('id', $postOnPage)->where('status_id' , 4)->orderBy('created_at', 'desc')->first();
			    $topPost[$k] = $p;
			    if ($p) {
				    $postOnPage[] = $p;
			    }
		    }
	    }
	    $posts      = Post::whereIn('category_id' , $arrayOfId)->whereNotIn('id', $postOnPage)->where('status_id' , 4)->orderBy('created_at', 'desc')->limit(3)->get();
	    foreach($posts as $pos) {
		    $postOnPage[] = $pos->id;
	    }
	    return ['categ' => $categ, 'topPost' => $topPost, 'posts' => $posts , 'postOnPage' => $postOnPage, 'arrayOfId' => $arrayOfId];
    }

	protected function getParent ($categ, $str = '')
	{
		if ($categ->getParentCateg) {
			$c = $categ->getParentCateg;
			$str = $categ->friendly_url . '/' .$str;
			return $this->getParent($c, $str);
		} else {
			$str = $categ->friendly_url . '/' . $str;
			return [$categ->friendly_url, $str];
		}
	}
	/**
	 * ICOs part
	 */
	 public function showICOsMain()
	 {
	 	$ICOarr         = [];
		$topICO         = ICOProjects::where(['is_top' => 1, 'is_active' => 1])->first();
	 	$upccoming      = ICOProjects::where('data_start', '>', date('Y-m-d H:i:s', time()))
						->where('data_end', '>', date('Y-m-d H:i:s', time()))
						->where('is_active', 1)
	 	                ->orderBy('ico_promotion_id')
		                ->orderBy('data_start');
	    $ICOs           = $upccoming->get();

		if ($topICO->data_end > date('Y-m-d H:i:s', time()) && date('Y-m-d H:i:s', time()) > $topICO->data_start) {
			$start      = date_create($topICO->data_end);
			$now        = date_create();
			$diff       = date_diff($start, $now);
			$IcoTime    = $diff->format("%a-%h-%i-%s");
		} else if ($topICO->data_end > $topICO->data_start && $topICO->data_start > date('Y-m-d H:i:s', time())) {
			$start      = date_create($topICO->data_start);
			$now        = date_create();
			$diff       = date_diff($start, $now);
			$IcoTime    = $diff->format("%a-%h-%i-%s");
		}
		if ($ICOs) {
			 foreach ($ICOs as $ico) {
				 $ICOarr[] = ['diff' => $this->getTimeDiff($ico), 'ico' => $ico];
			 }
		}
		$categ = ICOProjects::where('data_start', '>', date('Y-m-d H:i:s', time()))->select('ico_category_id')->groupBy('ico_category_id')->get();
		return view('front-end.icos-main', compact('topICO', 'ICOarr', 'categ', 'IcoTime'));
	 }

    public function geICOsForMainPage(Request $request)
    {
        $ansver = [];
        $ICOarr = [];
        $catArr = [];
        $icoSearch = 0;
        if ($request->input('search')) {
            $icoSearch = ICOProjects::where(['title' => $request->input('search'), 'is_active' => 1])->first();
        }
        if (!$icoSearch) {
            if ($request->input('tab')) {
                $ico = ICOProjects::where('is_active', 1);
                $categ = ICOProjects::select('ico_category_id');
                switch ($request->input('tab')) {
                    case 'upcoming' :
                        $ico->where('data_start', '>', date('Y-m-d H:i:s', time()))
                            ->where('data_end', '>', date('Y-m-d H:i:s', time()))
                            ->orderBy('ico_promotion_id')
                            ->orderBy('data_start');
                        if ($request->input('category')) {
                            $catPost = $request->input('category');
                            $ico->whereHas('getCategory', function ($q) use ($catPost) {
                                $q->where('name', $catPost);
                            });
                        }
                        if ($request->input('search')) {
                            $ico->where('title', 'LIKE', '%' . $request->input('search') . '%');
                        }
                        $categ->where('data_start', '>', date('Y-m-d H:i:s', time()))
                            ->where('data_end', '>', date('Y-m-d H:i:s', time()));
                        break;
                    case 'live' :
                        $ico->where('data_start', '<', date('Y-m-d H:i:s', time()))
                            ->where('data_end', '>', date('Y-m-d H:i:s', time()))
                            ->orderBy('ico_promotion_id')
                            ->orderBy('data_end');
                        if ($request->input('category')) {
                            $catPost = $request->input('category');
                            $ico->whereHas('getCategory', function ($q) use ($catPost) {
                                $q->where('name', $catPost);
                            });
                        }
                        if ($request->input('search')) {
                            $ico->where('title', 'LIKE', '%' . $request->input('search') . '%');
                        }
                        $categ->where('data_start', '<', date('Y-m-d H:i:s', time()))
                            ->where('data_end', '>', date('Y-m-d H:i:s', time()));
                        break;
                    case 'finished':
                        $ico->where('data_end', '<', date('Y-m-d H:i:s', time()))
                            ->where('data_start', '<', date('Y-m-d H:i:s', time()))
                            ->orderBy('ico_promotion_id')
                            ->orderBy('raised_field', 'DESC');
                        if ($request->input('category')) {
                            $catPost = $request->input('category');
                            $ico->whereHas('getCategory', function ($q) use ($catPost) {
                                $q->where('name', $catPost);
                            });
                        }
                        if ($request->input('search')) {
                            $ico->where('title', 'LIKE', '%' . $request->input('search') . '%');
                        }
                        $categ->where('data_end', '<', date('Y-m-d H:i:s', time()))
                            ->where('data_start', '<', date('Y-m-d H:i:s', time()));
                        break;
                    case 'fraud':
                        $ico->where('is_fraud', 1)
                            ->orderBy('ico_promotion_id')
                            ->orderBy('data_start');
                        if ($request->input('category')) {
                            $catPost = $request->input('category');
                            $ico->whereHas('getCategory', function ($q) use ($catPost) {
                                $q->where('name', $catPost);
                            });
                        }
                        if ($request->input('search')) {
                            $ico->where('title', 'LIKE', '%' . $request->input('search') . '%');
                        }
                        $categ->where('data_end', '<', date('Y-m-d H:i:s', time()))
                            ->where('data_start', '<', date('Y-m-d H:i:s', time()));
                        break;
                }
                $ICOs = $ico->get();
                if ($ICOs) {
                    foreach ($ICOs as $ico) {
                        if ($request->input('tab') == 'finished') {
                            $ICOarr[] = [
                                'diff' => $this->getTimeDiff($ico),
                                'ico' => [
                                    'icon' => (strlen($ico->image) > 200) ? $ico->image : asset($ico->image),
                                    'category' => $ico->getCategory ? $ico->getCategory->name : "",
                                    'is_featch' => ($ico->getPromotion->id < 3) ? 1 : 0,
                                    'medal' => ($ico->getPromotion->id != 10) ? asset($ico->getPromotion->icon) : 0,
                                    //'medalPosition'     => ($ico->getPromotion->id != 10) ? $ico->getPromotion->id : 0,
                                    'data' => date('M dS Y H:i', strtotime($ico->data_end)),
                                    'title' => $ico->title,
                                    'url' => '/ico/' . $ico->friendly_url,
                                    'raised' => $ico->raised_field
                                ]
                            ];
                        } else {
                            $ICOarr[] = [
                                'diff' => $this->getTimeDiff($ico),
                                'ico' => [
                                    'icon' => (strlen($ico->image) > 200) ? $ico->image : asset($ico->image),
                                    'category' => $ico->getCategory ? $ico->getCategory->name : "",
                                    'is_featch' => ($ico->getPromotion->id < 3) ? 1 : 0,
                                    'medal' => ($ico->getPromotion->id != 10) ? asset($ico->getPromotion->icon) : 0,
                                    //'medalPosition'     => ($ico->getPromotion->id != 10) ? $ico->getPromotion->id : 0,
                                    'data' => date('M dS Y H:i', strtotime($ico->data_start)),
                                    'title' => $ico->title,
                                    'url' => '/ico/' . $ico->friendly_url,
                                    'raised' => $ico->raised_field
                                ]
                            ];
                        }
                    }
                }
                $categories = $categ->groupBy('ico_category_id')->get();

                foreach ($categories as $cat) {
                    if ($cat->getCategory) {
                        $catArr[] = $cat->getCategory->name;
                    }
                }
            }
        } else {
            $ICOarr = [
                'diff' => $this->getTimeDiff($icoSearch),
                'ico' => [
                    'icon' => (strlen($icoSearch->image) > 200) ? $icoSearch->image : asset($icoSearch->image),
                    'category' => $icoSearch->getCategory->name,
                    'is_featch' => ($icoSearch->getPromotion->id < 3) ? 1 : 0,
                    'medal' => ($icoSearch->getPromotion->id != 10) ? asset($icoSearch->getPromotion->icon) : 0,
                    'data' => date('M dS Y H:i', strtotime($icoSearch->data_start)),
                    'title' => $icoSearch->title,
                    'url' => '/ico/' . $icoSearch->friendly_url,
                    'raised' => $icoSearch->raised_field
                ]
            ];
        }

        if (count($ICOarr) > 0 || count($catArr) > 0) {
            $ansver = [
                'icos' => $ICOarr,
                'category' => $catArr,
            ];
            return $ansver;
        }
        return $ansver;
    }

    public function showICOsbyTitle($title)
    {
        $project = ICOProjects::where(['friendly_url' => $title, 'is_active' => 1])->first();

        if (!$project) {
            abort('404');
        }
        $relProjects = ICOProjects::where('ico_category_id', $project->ico_category_id)
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->limit(3)->select('title', 'friendly_url', 'image')->get();
        $comments = ICOComments::where('ico_id', $project->id)->orderBy('created_at', 'desc')->get();
        return view('front-end.icos-one', compact('project', 'relProjects', 'comments'));
    }

    public function getNewICOComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => 'required|captcha',
        ]);

        if ($validator->fails()) {
            return redirect()->back();
        }

        if ($request->input('ico_id')) {

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            ICOComments::create([
                'ico_id' => $request->input('ico_id'),
                'status_id' => 1,
                'writer_name' => $request->input('inputName'),
                'writer_email' => $request->input('inputEmail'),
                'content' => $request->input('textareaComments'),
                'ip' => $ip
            ]);
        }
        return redirect()->back()->with('successSendMessage', 'Thanks for your message!');
    }

	 public function showEventsPage()
     {
         $events = Event::where('is_active', 1)->where('date_start', ">=", Carbon::now())->orderBy('ico_promotion_id')->get();
         $top_content = Event::where('is_active', 1)->where('top_featured', 1)->first();
         $cities = City::all();
         return view('front-end.events', compact('events', 'top_content', 'cities'));
     }

    public function searchPostPaginate($request)
    {
        $page = +$request->page ?: 1;
        if (!is_int($page) or $page > 1000) {
            return redirect('/');
        }
        $search = $request->s;
        $search_post_ids = $this->getSearchPostIds($request);
        $paginate_post_ids = array_slice($search_post_ids, ($page-1) * 6, 6);
        $is_end = count($paginate_post_ids) < 6;
        $pagination_raw = Post::whereIn('id', $paginate_post_ids)
            ->where('status_id', 4)
            ->limit(6)
            ->get();
        $pagination = [];
        //order: title, description, post's body
        foreach ($pagination_raw as $p) {
            $pagination[array_search($p->id, $paginate_post_ids)] = $p;
        }
        ksort($pagination);
        return view('front-end.search', compact('pagination', 'page', 'search', 'is_end'));
    }

    protected function getTimeDiff($ico)
    {
        $start = date_create($ico->data_start);
        $now = date_create();
        $end = date_create($ico->data_end);
        $diff = '0 d 00:00:00';
        $resultDate = '';
        $resultDateShort ='';
        $val = 0;
        if ($start < $end && $now < $end && $start < $now) {
            $percent = date_diff($end, $start);
            $interval = date_diff($end, $now);
            $num = $interval->format('%a');
            $max = $percent->format('%a');
            $diff = $interval->format("%a d : %h h : %i m : %s s");
            $val = 100 - ($num * 100 / $max);
            $tab = 'live';
            $dateConvert = $interval->format("day:%a,hour:%h,minute:%i,second:%s");
            $dateShortConvert = $interval->format("d:%a,h:%h,m:%i,s:%s");
            $resultDate = $this->realDate($dateConvert);
            $resultDateShort = $this->realDate($dateShortConvert, false);
        } else if ($now > $end) {
            $diff = '0 d 00:00:00';
            $val = 100;
            $tab = 'finished';
            $diff_days = "finish";
        } else if ($start > $now && $end > $start) {
            $interval = date_diff($start, $now);
            $num = $interval->format('%a');
            $diff = $interval->format("%a d : %h h : %i m : %s s");
            $val = 100 - ($num);
            $tab = 'upcoming';

            $dateConvert = $interval->format("day:%a,hour:%h,minute:%i,second:%s");
            $dateShortConvert = $interval->format("d:%a,h:%h,m:%i,s:%s");
            $resultDate = $this->realDate($dateConvert);
            $resultDateShort = $this->realDate($dateShortConvert, false);
        } else {
            $interval = date_diff($start, $now);
            $num = $interval->format('%a');
            $diff = $interval->format("%a d : %h h : %i m : %s s");
            $val = 100 - ($num);
            $tab = 'upcoming';

            $dateConvert = $interval->format("day:%a,hour:%h,minute:%i,second:%s");
            $dateShortConvert = $interval->format("d:%a,h:%h,m:%i,s:%s");
            $resultDate = $this->realDate($dateConvert);
            $resultDateShort = $this->realDate($dateShortConvert, false);
        }
        $arr = [
            'diff' => $diff,
            'percent' => $val,
            'tab' => $tab,
            'diff_days' => $resultDate,
            'short_date' => $resultDateShort
        ];
        return $arr;
    }

    protected function getAllChildrens($childs, $array = NULL)
    {
        $arr = [];
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

    protected function realDate($data, $multiple = true)
    {
        // Get date in specify format to parsing
        $diffDays = explode(",", $data);
        $parsedDate = array();
        // Parsing string to array
        foreach ($diffDays as $str) {
            list($key, $value) = explode(':', $str);
            $parsedDate[str_replace(" ", "", $key)] = $value;
        }

        $returnKey = "";
        $returnVal = "";

        // Get Key of date "Hour" and value "20"
        foreach ($parsedDate as $key => $item) {
            if ((int)$item !== 0) {
                empty($returnKey) ? $returnKey = $key : "";
                $returnVal .= $item . ",";
            }
        }
        $exploded = explode(",", $returnVal);
        $returnData = "";
        // If current data has child val (if hours has minutes) iterate it
        isset($exploded[1]) && $exploded[1] != "" ? $returnData = $exploded[0] + 1 : $returnData = $exploded[0];
        $returnValue = $returnData . $returnKey;
        if ($multiple) {
            // If current data more than 1 concat "s"
            $returnKey = $returnData > 1 ? $returnKey . "s" : $returnKey;
            $returnValue = $returnData . " " . $returnKey;
        }
        return $returnValue;
    }

    protected function getSearchPostIds($request)
    {
        $search_ids = [];
        $search_title = LanguageValue::where('key', 'like', 'title-posts-%')
            ->where('value', 'like', '%' . $request->s . '%')
            ->select('key')
            ->get();
        foreach ($search_title as $item) {
            $search_ids[] = explode('-', $item->key)[2];
        }
        $search_description = LanguageValue::where('key', 'like', 'description-posts-%')
            ->where('value', 'like', '%' . $request->s . '%')
            ->select('key')
            ->get();
        foreach ($search_description as $item) {
            $post_id = explode('-', $item->key)[2];
            if (in_array($post_id, $search_ids)) {
                continue;
            }
            $search_ids[] = $post_id;
        }
        $search_body = LanguageValue::where('key', 'like', 'content-posts-%')
            ->where('value', 'like', '%' . $request->s . '%')
            ->select('key')
            ->get();
        foreach ($search_body as $item) {
            $post_id = explode('-', $item->key)[2];
            if (in_array($post_id, $search_ids)) {
                continue;
            }
            $search_ids[] = $post_id;
        }
        return $search_ids;
    }

    protected function getMainPostsForView($topPost)
    {
        //For view label
        $listCategories = ['news', 'education', 'reviews'];

        foreach ($topPost as $post) {
            if (isset($post->getCategory->getParentCateg)) {
                if (in_array($post->getCategory->getParentCateg->friendly_url, $listCategories, true)) {
                    $post->selectedCategoryForLabel = $post->getCategory->getParentCateg->friendly_url;
                }
            }
            if (in_array($post->getCategory->friendly_url, $listCategories)) {
                $post->selectedCategoryForLabel = $post->getCategory->friendly_url;
            }
            //Fix with class in frontend
            if ($post->selectedCategoryForLabel == "reviews") {
                $post->selectedCategoryForLabel = "rewiews";
            }
        }

        return $topPost;
    }

    public function glossaryPage()
    {
        $items = GlossaryItem::oldest("title")
            ->paginate(4);
        $result = [];
        foreach($items as $item){
            $firstLetter = strtoupper(substr($item->title, 0, 1));
            if (!isset($result[$firstLetter])) {
                $result[$firstLetter] = [$item];
            } else {
                array_push($result[$firstLetter], $item);
            }
        }

        $categories = GlossaryCategory::all()->pluck('name', 'id');
        return view("front-end.glossary", [
            'items' => $result,
            'categories' => $categories
        ]);
    }


    public function showExecutivesPage()
    {
        $executives = Executive::get()->where("is_active", 1)->sortBy(function ($executive) {
            return $executive->ICOProjects()->where('is_active', 1)->get()->count();
        }, 0, true);
        $executivesResult = (new Paginator($executives, 20))->items();
        $roles = ExecutiveRole::all()->pluck("name", "id");
        $companies = ICOProjects::all()->pluck("title", "id");
        $locations = Country::all()->pluck("name", "id");
        $posts = Post::has("executives")
            ->where('status_id', 4)
            ->latest()
            ->orderBy('created_at','desc')
            ->take(6)
            ->get();
        return view('front-end.executives-list', compact('executivesResult', 'companies', 'locations', 'posts'));
     }

    public function showOneExecutivesPage($url)
    {
        $executive = Executive::where(['url' => $url, 'is_active' => 1])->first();
        $companies = $executive->ICOProjects ? $executive->ICOProjects()->where('is_active', 1)->get() : null;
        $id = $executive->id;
        $location = $executive->country->name;
        $posts = Post::whereHas('executives', function ($query) use ($id) {
            $query->where('id', $id)->where('status_id', 4);
        })->latest()
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        return view('front-end.executives-one', compact('executive', 'companies', 'location', 'posts'));
    }
}

