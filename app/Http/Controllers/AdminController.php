<?php

namespace App\Http\Controllers;

use App\Banner;
use App\ContactForm;
use App\Http\Translate\Translate;
use App\ICOMoney;
use App\ICOPlatform;
use App\ICOProjects;
use App\Post;
use App\Subscriber;
use App\SubscribersCategories;
use App\Traits\QueryTraits;
use App\Traits\AdminTraits;
use App\User;
use Carbon\Carbon;

class AdminController extends Controller
{

    use QueryTraits, AdminTraits;

    protected $chapterForStatisticByPeriod = [
        'App\Post' => 'Published',
        'App\Subscriber' => 'Subscribtions',
        'App\Comments' => 'Comments',
        'App\ContactForm' => 'Contacted',
    ];

    public function showIndexSubscribers()
    {
        $subscribers = Subscriber::with('getCategories')->get();
        return view('admin.subscriber-contact.subscriber', compact('subscribers'));
    }

    public function showIndexContactForm()
    {
        $contacts = ContactForm::get();
        return view('admin.subscriber-contact.contact-form', compact('contacts'));
    }

    public function getModalDeleteSubscriber($id = null)
    {
        $error          = '';
        $model          = '';
        $confirm_route  =  route('subscribers.delete',['id'=>$id]);
        return View('admin/layouts/modal_confirmation', compact('error','model', 'confirm_route'));
    }

    public function getDeleteSubscriber($id = null)
    {
        $sub = Subscriber::find($id);
        SubscribersCategories::where('subscriber_id', $sub->id)->delete();
        Subscriber::destroy($sub->id);
        return redirect('admin/subscribers')->with('success', 'Subscriber was deleted success.');
    }

    public function getModalDeleteFromContactForm($id = null)
    {
        $error          = '';
        $model          = '';
        $confirm_route  =  route('contact-form.delete',['id'=>$id]);
        return View('admin/layouts/modal_confirmation', compact('error','model', 'confirm_route'));
    }

    public function getDeleteFromContactForm($id = null)
    {
        ContactForm::destroy($id);
        return redirect('admin/contact-form')->with('success', 'Post of user was deleted success.');
    }

    public function updateAllPictures()
    {
        $posts = Post::get();
        foreach ($posts as $p) {
            $img = $p->title_image;
            $p->title_image = 'storage/' . $img;
            $img = $p->short_image;
            $p->short_image = 'storage/' . $img;
            $img = $p->category_image;
            $p->category_image = 'storage/' . $img;
            $p->save();
        }
        $auth  = User::get();
            foreach ($auth as $a) {
            $img = $a->profile_image;
            $a->profile_image = 'storage/' . $img;
            $a->save();
        }
        $banner = Banner::first();
        $banner->image = 'storage/' . $banner->image;
        $banner->save();

        return redirect('/');
    }

    public function helpFunc()
    {
        $plat = ICOPlatform::get();
        foreach ($plat as $p) {
            $str = $p->name;
            $p->name = trim($str);
            $p->save();
        }
        $mon = ICOMoney::get();
        foreach ($mon as $m) {
            $str = $m->name;
            $m->name = trim($str);
            $m->save();
        }
    }

	public function showDashboard()
    {
        $endDate = Carbon::today()->addWeek();
        $periodLength = $endDate->diffInWeeks(Post::getLatestPost()->created_at);
        $startDate =  Carbon::today()->subWeek($periodLength);

        $postByPeriod = Post::getGroupedPostWithUserByPeriodAndRole($startDate, $endDate, [User::USER_AUTHOR, User::USER_SUPER_ADMIN]);

        $groupedDataByUserAndPeriod = collect();
        foreach ($postByPeriod as $weekNumber => $userItem) {
            $date = Carbon::now()->setISODate(date('Y'), $weekNumber);
            $dateWeekFormat = $date->startOfWeek()->format('Y-m-d') .'/'. $date->endOfWeek()->format('Y-m-d');
            $groupedDataByUserAndPeriod->put($dateWeekFormat, $userItem->groupBy('user_id'));
        }

        $groupedDateBySpecialPeriod = [];
        foreach ($groupedDataByUserAndPeriod as $datePeriod => $usersData) {
            $groupedDateBySpecialPeriod[$datePeriod] = User::getAllUserByRoleAsKeyArray([User::USER_AUTHOR, User::USER_SUPER_ADMIN]);
            foreach ($usersData as $userData) {
                if (!empty($userData->first()->getUser)) {
                    $userName = $userData->first()->getUser->getTranslateNameAndSurname();
                    $groupedDateBySpecialPeriod[$datePeriod][$userName] =  $userData->groupBy(function($date) {
                        return $date->created_at->format('N');
                    })->map(function ($weekStatistic) {
                        return $weekStatistic->count();
                    })->toArray();
                    $groupedDateBySpecialPeriod[$datePeriod][$userName]['total_item'] = count($userData);
                }
            }

            $dayCounts = [];
            foreach ($groupedDateBySpecialPeriod[$datePeriod] as $userName => $weekStatistic) {
                if (!empty($weekStatistic)) {
                    foreach ($weekStatistic as $dayNumber => $dayStatistic) {
                        $dayCounts[$dayNumber] = isset($dayCounts[$dayNumber]) ? $dayCounts[$dayNumber] + $dayStatistic : $dayStatistic;
                    }
                }
            }

            $groupedDateBySpecialPeriod[$datePeriod]['Total'] = $dayCounts;
        }

        $groupedStatisticByPeriod = collect($groupedDateBySpecialPeriod);
        $paginationItemPerList = $this->paginationItemPerList;
        $filterData = compact('paginationItemPerList');

        return view('admin.dashboard', compact('groupedStatisticByPeriod', 'filterData'));
    }

    public function showStatistic()
    {
        $filterDataWithAllDay = [];
        foreach ($this->chapterForStatisticByPeriod as $chapter => $chapterNameView) {
            $groupedPosts = self::getGroupedByMonthAndDay((new $chapter()));
            $filterDataWithAllDay = $this->addNotExistDayAndGroupByName($groupedPosts, $chapterNameView, $filterDataWithAllDay);
        }

        $filterDataWithNotExistingDayAndCategory = $this->setNotExistingChapter($filterDataWithAllDay, $this->chapterForStatisticByPeriod);

        return view('admin.statistic', compact('filterDataWithNotExistingDayAndCategory'));
    }
}
