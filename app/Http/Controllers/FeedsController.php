<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Post;
use App\Http\Translate\Translate;

class FeedsController extends Controller
{
    public function getFeed()
    {
        $feed = App::make("feed");
        $posts = $this->getFeedData();
        $feed->title = "Cryptovest";
        $feed->description = 'Cryptovest rss';
        $feed->link = url('feed') . '/';
        $feed->setDateFormat('datetime');
        $feed->lang = 'en';
        $feed->setShortening(true);
        $feed->setTextLimit(250);

        if (!empty($posts)) {
            $feed->pubdate = $posts[0]->created_at;
            foreach ($posts as $post) {
                $link = url('/') . '/' . $post->getCategory->friendly_url . '/' . $post->friendly_url . '/';
                $author = "";
                if(!empty($post->getUser)){
                    $author = Translate::getValue($post->getUser->first_name_lang_key) . ' ' . Translate::getValue($post->getUser->last_name_lang_key);
                }
                $title = Translate::getValue($post->title_lang_key);
                $description = Translate::getValue($post->description_lang_key);
                $category = Translate::getValue($post->getCategory->name_lang_key);
                // set item's title, author, url, pubdate, description, content, enclosure, category
                $feed->add($title, $author, $link, $post->created_at, $description, null, null , $category);
            }
        }


        return $feed->render('rss');
    }

    /**
     * Creating rss feed with our most recent posts.
     * The size of the feed is defined in feed.php config.
     *
     * @return mixed
     */
    private function getFeedData()
    {
        $maxSize = 20;
        $posts = Post::with('getAuthor')->where('status_id', 4)->orderBy('created_at', 'desc')->limit($maxSize)->get();
        return $posts;
    }
}