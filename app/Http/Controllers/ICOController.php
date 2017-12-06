<?php

namespace App\Http\Controllers;
use App\Http\Services\TinifyService;
use App\ICOBuyer;
use App\ICOCategory;
use App\ICOComments;
use App\ICODeal;
use App\ICOMembers;
use App\ICOMoney;
use App\ICOPaymentType;
use App\ICOPlatform;
use App\ICOPrice;
use App\ICOProjectMember;
use App\ICOProjectMoney;
use App\ICOProjects;
use App\ICOProjectTypes;
use App\ICOPromotion;
use App\Mail\OrderSummary;
use App\Status;
use Faker\Provider\File;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use Validator;
use Image;
use Illuminate\Http\Request;

class ICOController extends Controller
{

    /**
     * --- Types of project part ---
     */
    public function listOfProjectTypes()
    {
        $types = ICOProjectTypes::get();
        return view('admin.ICO.project-types.index', compact('types'));
    }

    public function createProjectType()
    {
        return view('admin.ICO.project-types.create');
    }

    public function storeProjectType(Request $request)
    {
        $active = 0;
        $rule = ['name' => 'unique:ico_project_types,name'];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->input('is_active')) {
            $active = 1;
        }
        ICOProjectTypes::create([
            'name' => $request->input('name'),
            'is_active' => $active
        ]);
        return redirect('admin/ico/project-types')->with('success', 'Type was created');
    }

    public function editProjectType($id)
    {
        $type = ICOProjectTypes::find($id);
        return view('admin.ICO.project-types.edit', compact('type'));
    }

    public function updateProjectType($id, Request $request)
    {
        $type = ICOProjectTypes::find($id);
        if ($type->id != $request->input('name')) {
            $rule = ['name' => 'unique:ico_project_types,name'];
            $validator = Validator::make($request->all(), $rule);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $type->name = $request->input('name');
        }
        if ($request->input('is_active')) {
            $type->is_active = 1;
        } else {
            $type->is_active = 0;
        }
        $type->save();
        return redirect('admin/ico/project-types')->with('success', 'Type was edited success.');
    }

    public function getTypeDelete($id = null)
    {
        ICOProjectTypes::where('id', $id)->delete();
        return redirect('admin/ico/project-types')->with('success', 'Category was deleted success.');
    }

    public function getModalTypeDelete($id = null)
    {
        $error = '';
        $model = '';
        $confirm_route = route('project-type.delete', ['id' => $id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    /**
     * --- End project types part ---
     *
     * --- Money part ---
     */
    public function listOfMoney()
    {
        $money = ICOMoney::get();
        return view('admin.ICO.money.index', compact('money'));
    }

    public function createMoney()
    {
        return view('admin.ICO.money.create');
    }

    public function storeMoney(Request $request)
    {
        $rule = [
            'name' => 'unique:ico_money,name',
            'image' => 'file'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $money = ICOMoney::create([
            'name' => $request->input('name'),
        ]);

        if ($file = $request->file('image')) {
            $image = Image::make($request->file('image'));
            $this->imageOptimization($file, "ICO/money", $image, $money, "icon");
        }
        if ($request->input('is_active')) {
            $money->is_active = 1;
        }
        $money->save();
        return redirect('admin/ico/money')->with('success', 'Money was created');
    }

    public function editMoney($id)
    {
        $money = ICOMoney::find($id);
        return view('admin.ICO.money.edit', compact('money'));
    }

    public function updateMoney($id, Request $request)
    {
        $money = ICOMoney::find($id);
        if ($request->input('name') != $money->name) {
            $rule = [
                'name' => 'unique:ico_money,name',
            ];
            $validator = Validator::make($request->all(), $rule);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $money->name = $request->input('name');
        }
        if ($file = $request->file('image')) {
            $image = Image::make($request->file('image'));
            $this->imageOptimization($file, "ICO/money", $image, $money, "icon");
        }
        if ($request->input('is_active')) {
            $money->is_active = 1;
        } else {
            $money->is_active = 0;
        }
        $money->save();
        return redirect('admin/ico/money')->with('success', 'Money was edited.');
    }

    public function getModalMoneyDelete($id = null)
    {
        $error = '';
        $model = '';
        $confirm_route = route('money.delete', ['id' => $id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getMoneyDelete($id = null)
    {
        ICOMoney::where('id', $id)->delete();
        return redirect('admin/ico/money')->with('success', 'Money was deleted.');
    }

    /**
     * --- End Money part ---
     *
     * --- Category Part ---
     */
    public function listOfCategory()
    {
        $categories = ICOCategory::get();
        return view('admin.ICO.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.ICO.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $active = 0;
        $rule = [
            'name' => 'unique:ico_category,name',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->input('is_active')) {
            $active = 1;
        }
        ICOCategory::create([
            'name' => $request->input('name'),
            'is_active' => $active,
        ]);
        return redirect('admin/ico/category')->with('success', 'Category was created.');
    }

    public function editCategory($id)
    {
        $category = ICOCategory::find($id);
        return view('admin.ICO.categories.edit', compact('category'));
    }

    public function updateCategory($id, Request $request)
    {
        $category = ICOCategory::find($id);

        if ($category->name != $request->input('name')) {
            $rule = [
                'name' => 'unique:ico_category,name',
            ];
            $validator = Validator::make($request->all(), $rule);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $category->name = $request->input('name');
        }
        if ($request->input('is_active')) {
            $category->is_active = 1;
        } else {
            $category->is_active = 0;
        }
        $category->save();
        return redirect('admin/ico/category')->with('success', 'Category was edited.');
    }

    public function getCategoryDelete($id = null)
    {
        ICOCategory::where('id', $id)->delete();
        return redirect('admin/ico/category')->with('success', 'Category was deleted.');
    }

    public function getModalCategoryDelete($id = null)
    {
        $error = '';
        $model = '';
        $confirm_route = route('ico.category.delete', ['id' => $id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    /**
     *  --- End of Category part ---
     *
     *  --- Platform part ---
     */
    public function listOfPlatform()
    {
        $platform = ICOPlatform::get();
        return view('admin.ICO.platforms.index', compact('platform'));
    }

    public function createPlatform()
    {
        return view('admin.ICO.platforms.create');
    }

    public function storePlatform(Request $request)
    {
        $rule = [
            'name' => 'unique:ico_platform,name',
            'image' => 'file'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $platform = ICOPlatform::create([
            'name' => $request->input('name'),
        ]);
        if ($file = $request->file('image')) {
            $image = Image::make($request->file('image'));
            $this->imageOptimization($file, "ICO/platform", $image, $platform, "icon");
        }
        if ($request->input('is_active')) {
            $platform->is_active = 1;
        }
        $platform->save();
        return redirect('admin/ico/platform')->with('success', 'Platform was created');
    }

    public function editPlatform($id)
    {
        $platform = ICOPlatform::find($id);
        return view('admin.ICO.platforms.edit', compact('platform'));
    }

    public function updatePlatform($id, Request $request)
    {
        $platform = ICOPlatform::find($id);
        if ($platform->name != $request->input('name')) {
            $rule = [
                'name' => 'unique:ico_platform,name',
            ];
            $validator = Validator::make($request->all(), $rule);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $platform->name = $request->input('name');
        }
        if ($file = $request->file('image')) {
            $image = Image::make($request->file('image'));
            $this->imageOptimization($file, "ICO/platform", $image, $platform, "icon");
        }

        if ($request->input('is_active')) {
            $platform->is_active = 1;
        } else {
            $platform->is_active = 0;
        }
        $platform->save();
        return redirect('admin/ico/platform')->with('success', 'Platform was Edited');
    }

    public function getPlatformDelete($id = null)
    {
        ICOPlatform::where('id', $id)->delete();
        return redirect('admin/ico/platform')->with('success', 'Platform was deleted.');
    }

    public function getModalPlatformDelete($id = null)
    {
        $error = '';
        $model = '';
        $confirm_route = route('platform.delete', ['id' => $id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    /**
     *
     * --- End Platform part ---
     *
     * --- Start Promotion part ---
     */

    public function listOfPromotion()
    {
        $promotion = ICOPromotion::get();
        return view('admin.ICO.promotion.index', compact('promotion'));
    }

    public function createPromotion()
    {
        return view('admin.ICO.promotion.create');
    }

    public function storePromotion(Request $request)
    {
        $rule = [
            'name' => 'unique:ico_promotion,name',
            'image' => 'file',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $promotion = ICOPromotion::create(['name' => $request->input('name')]);
        if ($file = $request->file('image')) {
            $image = Image::make($request->file('image'));
            $this->imageOptimization($file, "ICO/promotion", $image, $promotion, "icon");

        }
        if ($request->input('is_active')) {
            $promotion->is_active = 1;
        }
        $promotion->save();
        return redirect('admin/ico/promotion')->with('success', 'Promotion was created');
    }

    public function editPromotion($id)
    {
        $promotion = ICOPromotion::find($id);
        return view('admin.ICO.promotion.edit', compact('promotion'));
    }

    public function updatePromotion($id, Request $request)
    {
        $promotion = ICOPromotion::find($id);
        if ($promotion->name != $request->input('name')) {
            $rule = [
                'name' => 'unique:ico_promotion,name',
            ];
            $validator = Validator::make($request->all(), $rule);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $promotion->name = $request->input('name');
        }
        if ($file = $request->file('image')) {
            $image = Image::make($request->file('image'));
            $this->imageOptimization($file, "ICO/promotion", $image, $promotion, "icon");
        }
        if ($request->input('is_active')) {
            $promotion->is_active = 1;
        } else {
            $promotion->is_active = 0;
        }
        $promotion->save();
        return redirect('admin/ico/promotion')->with('success', 'Promotion was created.');
    }

    public function getPromotionDelete($id = null)
    {
        ICOPromotion::where('id', $id)->delete();
        return redirect('admin/ico/promotion')->with('success', 'Promotion was deleted.');
    }

    public function getModalPromotionDelete($id = null)
    {
        $error = '';
        $model = '';
        $confirm_route = route('promotion.delete', ['id' => $id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    /**
     *  --- End part of Promotion ---
     *
     *  --- part of Members ---
     */
    public function listOfMember()
    {
        $members = ICOMembers::with('getICO')->get();
        return view('admin.ICO.members.index', compact('members'));
    }

    public function createMember()
    {
        return view('admin.ICO.members.create');
    }

    public function storeMember(Request $request)
    {
        $member = ICOMembers::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('first_name'),
            'position' => $request->input('position'),
        ]);
        if ($request->input('twitter_link')) {
            $member->twitter_link = $request->input('twitter_link');
        }
        if ($request->input('linkedin_link')) {
            $member->linkedin_link = $request->input('linkedin_link');
        }
        $member->save();
        return redirect('admin/ico/members')->with('success', 'Member was Added.');
    }

    public function editMember($id)
    {
        $member = ICOMembers::find($id);
        return view('admin.ICO.members.edit', compact('member'));
    }

    public function updateMember($id, Request $request)
    {
        $member = ICOMembers::find($id);
        if ($member->first_name != $request->input('first_name')) {
            $member->first_name = $request->input('first_name');
        }
        if ($member->last_name != $request->input('last_name')) {
            $member->last_name = $request->input('last_name');
        }
        if ($member->position != $request->input('position')) {
            $member->position = $request->input('position');
        }
        if ($member->twitter_link != $request->input('twitter_link')) {
            $member->twitter_link = $request->input('twitter_link');
        }
        if ($member->linkedin_link != $request->input('linkedin_link')) {
            $member->linkedin_link = $request->input('linkedin_link');
        }
        $member->save();
        return redirect('admin/ico/members')->with('success', 'Member was edited.');
    }

    public function getMemberDelete($id = null)
    {
        ICOMembers::where('id', $id)->delete();
        return redirect('admin/ico/members')->with('success', 'Member was deleted.');
    }

    public function getModalMemberDelete($id = null)
    {
        $error = '';
        $model = '';
        $confirm_route = route('ico.members.delete', ['id' => $id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    /**
     *  --- End part of Member ---
     *
     *  --- Start part of Comment ---
     */
    //todo
    public function listOfComments()
    {
        $comments = ICOComments::get();
        return view('admin.ICO.comments.index', compact('comments'));
    }

    public function editComment($id)
    {
        $comment = ICOComments::find($id);
        $statuses = Status::where('is_comment', 1)->pluck('name', 'id');
        return view('admin.ICO.comments.edit', compact('comment', 'statuses'));
    }

    public function updateComment($id, Request $request)
    {
        $comment = ICOComments::find($id);
        if ($comment->writer_name != $request->input('name')) {
            $comment->writer_name = $request->input('name');
        }
        if ($comment->writer_email != $request->input('email')) {
            $comment->writer_email = $request->input('email');
        }
        if ($comment->content != $request->input('content')) {
            $comment->content = $request->input('content');
        }
        if ($comment->status_id != $request->input('status')) {
            if ($request->input('status') == 2) {
                $comment->submited_at = date('Y-m-d H:i:s', time());
            } else {
                $comment->submited_at = NULL;
            }
            $comment->status_id = $request->input('status');
        }
        $comment->save();
        return redirect('admin/ico/comments')->with('success', 'Comment was Edited.');
    }

    public function getCommentDelete($id = null)
    {
        ICOComments::where('id', $id)->delete();
        return redirect('admin/ico/comments')->with('success', 'Comment was deleted.');
    }

    public function getModalCommentDelete($id = null)
    {
        $error = '';
        $model = '';
        $confirm_route = route('ico.comments.delete', ['id' => $id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    /**
     *  --- End Comments part ---
     *
     *  --- Start Main part ---
     */
    public function listOfProjects()
    {
        $projects = ICOProjects::get();
        return view('admin.ICO.main.index', compact('projects'));
    }

    public function createProject()
    {
        $platforms = ICOPlatform::where('is_active', 1)->pluck('name', 'id');
        if (count($platforms) == 0) {
            return redirect()->back()->with('error', 'First create at least 1 platform.');
        }
        $types = ICOProjectTypes::where('is_active', 1)->pluck('name', 'id');
        if (count($types) == 0) {
            return redirect()->back()->with('error', 'First create at least 1 type.');
        }
        $money = ICOMoney::where('is_active', 1)->pluck('name', 'id');
        if (count($money) == 0) {
            return redirect()->back()->with('error', 'First create at least 1 money.');
        }
        $categories = ICOCategory::where('is_active', 1)->pluck('name', 'id');
        if (count($categories) == 0) {
            return redirect()->back()->with('error', 'First create at least 1 category.');
        }
        $promotions = ICOPromotion::where('is_active', 1)->pluck('name', 'id');
        $members = ICOMembers::get();
        return view('admin.ICO.main.create', compact('platforms', 'types', 'money', 'categories', 'members', 'promotions'));
    }

    public function storeProject(Request $request)
    {
        $rules = [
            'ico_type' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $project = ICOProjects::create([
            'title' => $request->input('title'),
            'short_description' => $request->input('short_description'),
            'friendly_url' => $request->input('friendly_url'),
            'ico_platform_id' => $request->input('ico_platform'),
            'ico_category_id' => $request->input('ico_category'),
            'ico_project_type_id' => $request->input('ico_type'),
        ]);

        if ($request->input('ico_promotion')) {
            $project->ico_promotion_id = $request->input('ico_promotion');
        }
        if ($request->input('content')) {
            $project->description = $request->input('content');
        }
        if ($file = $request->file('image')) {
            $image = Image::make($request->file('image'));
            $this->imageOptimization($file, "ICO", $image, $project, "image");
        }
        if ($request->input('pre-sale_condition')) {
            $project->presale_condition = $request->input('pre-sale_condition');
        }
        if ($request->input('total_supply')) {
            $project->total_supply = $request->input('total_supply');
        }
        if ($request->input('start')) {
            $project->data_start = date('Y-m-d H:i:s', strtotime($request->input('start')));
        }
        if ($request->input('end')) {
            $project->data_end = date('Y-m-d H:i:s', strtotime($request->input('end')));
        }
        //Money
        if ($request->input('chosen_money') && !empty($request->input('chosen_money'))) {
            $arr = explode(',', $request->input('chosen_money'));
            foreach ($arr as $money) {
                $m = ICOMoney::where('name', $money)->first();
                ICOProjectMoney::create([
                    'ico_id' => $project->id,
                    'money_id' => $m->id
                ]);
            }
        }
        // User money
        if ($shortToken = $request->input('short_token')) {
            $project->short_token = $shortToken;
        }
        if ($numberCoins = $request->input('number_coins')) {
            $project->number_coins = $numberCoins;
        }
        //Members
        if ($request->input('list-of-members') && !empty($request->input('list-of-members'))) {
            $arr = json_decode($request->input('list-of-members'));
            foreach ($arr as $m) {
                if ($m) {
                    $member = ICOMembers::create([
                        'ico_id' => $project->id,
                        'first_name' => ($m->first_name) ? $m->first_name : 'none',
                        'last_name' => ($m->last_name) ? $m->last_name : 'none',
                        'position' => ($m->position) ? $m->position : 'none',
                    ]);
                    if ($m->twitter) {
                        $member->twitter_link = $m->twitter;
                    }
                    if ($m->linkedIn) {
                        $member->linkedin_link = $m->linkedIn;
                    }
                    $member->save();
                }
            }
        }
        // Links
        if ($request->input('link_whitepaper') && !is_null($request->input('link_whitepaper'))) {
            $project->link_whitepaper = $request->input('link_whitepaper');
        }
        if ($request->input('link_announcement') && !is_null($request->input('link_announcement'))) {
            $project->link_announcement = $request->input('link_announcement');
        }
        if ($request->input('link_youtube') && !is_null($request->input('link_youtube'))) {
            $project->link_youtube = $request->input('link_youtube');
        }
        if ($request->input('link_facebook') && !is_null($request->input('link_facebook'))) {
            $project->link_facebook = $request->input('link_facebook');
        }
        if ($request->input('link_telegram') && !is_null($request->input('link_telegram'))) {
            $project->link_telegram = $request->input('link_telegram');
        }
        if ($request->input('link_instagram') && !is_null($request->input('link_instagram'))) {
            $project->link_instagram = $request->input('link_instagram');
        }
        if ($request->input('link_website') && !is_null($request->input('link_website'))) {
            $project->link_website = $request->input('link_website');
        }
        if ($request->input('link_linkedin') && !is_null($request->input('link_linkedin'))) {
            $project->link_linkedin = $request->input('link_linkedin');
        }
        if ($request->input('link_twitter') && !is_null($request->input('link_twitter'))) {
            $project->link_twitter = $request->input('link_twitter');
        }
        if ($request->input('link_slack') && !is_null($request->input('link_slack'))) {
            $project->link_slack = $request->input('link_slack');
        }

        if ($request->input('link_but_join_presale') && !is_null($request->input('link_but_join_presale'))) {
            $project->link_but_join_presale = $request->input('link_but_join_presale');
        }
        if ($request->input('link_but_explore_more') && !is_null($request->input('link_but_explore_more'))) {
            $project->link_but_explore_more = $request->input('link_but_explore_more');
        }
        if ($request->input('link_but_join_token_sale') && !is_null($request->input('link_but_join_token_sale'))) {
            $project->link_but_join_token_sale = $request->input('link_but_join_token_sale');
        }
        if ($request->input('link_but_exchange') && !is_null($request->input('link_but_exchange'))) {
            $project->link_but_exchange = $request->input('link_but_exchange');
        }

        if ($request->input('is_top')) {
            $topProj = ICOProjects::where('is_top', 1)->first();
            if ($topProj) {
                $topProj->is_top = 0;
                $topProj->save();
            }
            $project->is_top = 1;
        }
        if ($request->input('is_widget')) {
            $project->is_widget = 1;
        }
        if ($request->input('is_active')) {
            $project->is_active = 1;
        }
        if ($request->input('is_fraud')) {
            $project->is_fraud = 1;
        }
        if ($request->input('is_top_six')) {
            $project->is_top_six = 1;
        }

        $project->save();
        return redirect('admin/ico/projects')->with('success', 'ICO Project was created.');
    }

    public function editProject($id)
    {
        $project = ICOProjects::find($id);
        $platforms = ICOPlatform::where('is_active', 1)->get();
        if (count($platforms) == 0) {
            return redirect()->back()->with('error', 'First create at least 1 platform.');
        }
        $types = ICOProjectTypes::where('is_active', 1)->pluck('name', 'id');
        if (count($types) == 0) {
            return redirect()->back()->with('error', 'First create at least 1 type.');
        }
        $money = ICOMoney::where('is_active', 1)->pluck('name', 'id');
        if (count($money) == 0) {
            return redirect()->back()->with('error', 'First create at least 1 money.');
        }
        $categories = ICOCategory::where('is_active', 1)->get();
        if (count($categories) == 0) {
            return redirect()->back()->with('error', 'First create at least 1 category.');
        }
        $promotions = ICOPromotion::where('is_active', 1)->pluck('name', 'id');
        $members = ICOMembers::get();
        $icoMoney = '';
        $icoMembers = '';
        foreach ($project->getMoney as $m) {
            $icoMoney .= $m->name . ',';
        }

        if (count($project->getMembers) > 0) {
            $icoMembers = '[';

            foreach ($project->getMembers as $m) {
                $icoMembers .= "{\"first_name\":\"" . $m->first_name . "\",\"last_name\":\"" . $m->last_name . "\",\"position\":\"" . $m->position . "\",\"linkedIn\":\"" . $m->linkedin_link . "\",\"twitter\":\"" . $m->twitter_link . "\"},";
            }
            $icoMembers = substr($icoMembers, 0, -1);
            $icoMembers .= ']';
        }

        return view('admin.ICO.main.edit', compact('project', 'platforms', 'types', 'money', 'categories', 'promotions', 'members', 'icoMoney', 'icoMembers'));
    }

    public function updateProject($id, Request $request)
    {
        $platform = $request->input("ico_platform");
        $platformOther = $request->input("other_platform");
        $category = $request->input("ico_category");
        $categoryOther = $request->input("other_category");


        if (count($platformOther) > 0) {
            $platform = null;
        }
        if (count($categoryOther) > 0) {
            $category = null;
        }
        $rules = [
            'title' => 'required',
            'short_description' => 'required',
            'friendly_url' => 'required',
            'ico_type' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $project = ICOProjects::find($id);

        $project->ico_category_id = $category;
        $project->ico_platform_id = $platform;
        $project->ico_platform_other = $platformOther;
        $project->ico_category_other = $categoryOther;


        if ($request->input('title') != $project->title) {
            $project->title = $request->input('title');
        }
        if ($request->input('friendly_url') != $project->friendly_url) {
            $test = ICOProjects::where('friendly_url', $request->input('friendly_url'))->first();
            if ($test) {
                return redirect()->back()->withErrors('Wrong URL, alrady exist.')->withInput();
            }
            $project->friendly_url = $request->input('friendly_url');
        }
        if ($request->input('ico_type') != $project->ico_project_type_id) {
            $project->ico_project_type_id = $request->input('ico_type');
        }
        if ($request->input('ico_promotion') != $project->ico_promotion_id) {
            $project->ico_promotion_id = $request->input('ico_promotion');
        }
        if ($request->input('short_description') != $project->short_description) {
            $project->short_description = $request->input('short_description');
        }
        if ($request->input('content') != $project->description) {
            $project->description = $request->input('content');
        }
        if ($request->input('total_supply') != $project->total_supply) {
            $project->total_supply = $request->input('total_supply');
        }
        if ($request->input('pre-sale_condition') != $project->presale_condition) {
            $project->presale_condition = $request->input('pre-sale_condition');
        }
        if ($file = $request->file('image')) {
            $image = Image::make($request->file('image'));
            $this->imageOptimization($file, "ICO", $image, $project, "image");

        }
        $start = date('Y-m-d H:i:s', strtotime($request->input('start')));
        $end = date('Y-m-d H:i:s', strtotime($request->input('end')));

        if ($start != $project->data_start) {
            $project->data_start = $start;
        }
        if ($end != $project->data_end) {
            $project->data_end = $end;
        }

        //Money
        ICOProjectMoney::where('ico_id', $project->id)->delete();

        if ($request->input('chosen_money') && !empty($request->input('chosen_money'))) {
            $arr = explode(',', $request->input('chosen_money'));
            foreach ($arr as $money) {
                $m = ICOMoney::where('name', $money)->first();
                ICOProjectMoney::create([
                    'ico_id' => $project->id,
                    'money_id' => $m->id
                ]);
            }
        }

        // User money
        if ($shortToken = $request->input('short_token')) {
            $project->short_token = $shortToken;
        }
        if ($numberCoins = $request->input('number_coins')) {
            $project->number_coins = $numberCoins;
        }

        //Members
        ICOMembers::where('ico_id', $project->id)->delete();
        if ($request->input('list-of-members') && !empty($request->input('list-of-members'))) {
            $arr = json_decode($request->input('list-of-members'));
            if ($arr) {
                foreach ($arr as $m) {
                    if ($m) {
                        $member = ICOMembers::create([
                            'ico_id' => $project->id,
                            'first_name' => ($m->first_name) ? $m->first_name : 'none',
                            'last_name' => ($m->last_name) ? $m->last_name : 'none',
                            'position' => ($m->position) ? $m->position : 'none',
                        ]);
                        if ($m->twitter) {
                            $member->twitter_link = $m->twitter;
                        }
                        if ($m->linkedIn) {
                            $member->linkedin_link = $m->linkedIn;
                        }
                        $member->save();
                    }
                }
            }
        }

        // Links
        if ($request->input('link_whitepaper') != $project->link_whitepaper) {
            $project->link_whitepaper = $request->input('link_whitepaper');
        }
        if ($request->input('link_website') != $project->link_website) {
            $project->link_website = $request->input('link_website');
        }
        if ($request->input('link_announcement') != $project->link_announcement) {
            $project->link_announcement = $request->input('link_announcement');
        }
        if ($request->input('link_youtube') != $project->link_youtube) {
            $project->link_youtube = $request->input('link_youtube');
        }
        if ($request->input('link_facebook') != $project->link_facebook) {
            $project->link_facebook = $request->input('link_facebook');
        }
        if ($request->input('link_telegram') != $project->link_telegram) {
            $project->link_telegram = $request->input('link_telegram');
        }
        if ($request->input('link_instagram') != $project->link_instagram) {
            $project->link_instagram = $request->input('link_instagram');
        }

// New date
        if ($request->input('link_linkedin') != $project->link_linkedin) {
            $project->link_linkedin = $request->input('link_linkedin');
        }
        if ($request->input('raised_field') != $project->raised_field) {
            $project->raised_field = $request->input('raised_field');
        }
        if ($request->input('link_twitter') != $project->link_twitter) {
            $project->link_twitter = $request->input('link_twitter');
        }
        if ($request->input('link_slack') != $project->link_slack) {
            $project->link_slack = $request->input('link_slack');
        }
        if ($request->input('link_but_join_presale') != $project->link_but_join_presale) {
            $project->link_but_join_presale = $request->input('link_but_join_presale');
        }
        if ($request->input('link_but_explore_more') != $project->link_but_explore_more) {
            $project->link_but_explore_more = $request->input('link_but_explore_more');
        }
        if ($request->input('link_but_join_token_sale') != $project->link_but_join_token_sale) {
            $project->link_but_join_token_sale = $request->input('link_but_join_token_sale');
        }
        if ($request->input('link_but_exchange') != $project->link_but_exchange) {
            $project->link_but_exchange = $request->input('link_but_exchange');
        }

        // User screenshot
        if ($file = $request->file('ico_screenshot')) {
            $image = Image::make($request->file('ico_screenshot'));
            $this->imageOptimization($file, "screenshotes", $image, $project, "ico_screenshot");
        }

        if ($end != $project->data_end) {
            $project->data_end = $end;
        }

        if ($request->input('is_active')) {
            $project->is_active = 1;
        } else {
            $project->is_active = 0;
        }

        if ($request->input('is_fraud')) {
            $project->is_fraud = 1;
        } else {
            $project->is_fraud = 0;
        }

        if ($request->input('is_top_six')) {
            $project->is_top_six = 1;
        } else {
            $project->is_top_six = 0;
        }


        if ($request->input('is_widget')) {
            $project->is_widget = 1;
        } else {
            $project->is_widget = 0;
        }

        if ($request->input('is_top')) {
            if ($project->is_top != 1) {
                $pr = ICOProjects::where('is_top', 1)->first();
                if ($pr) {
                    $pr->is_top = 0;
                    $pr->save();
                }
                $project->is_top = 1;
            }
        } else {
            $project->is_top = 0;
        }
        $project->save();
        return redirect('admin/ico/projects')->with('success', 'ICO Project was updated.');
    }


    public function getProjectDelete($id = null)
    {
        $project = ICOProjects::find($id);
        ICOMembers::where('ico_id', $project->id)->delete();
        ICOProjectMoney::where('ico_id', $project->id)->delete();
        $project->delete();
        return redirect('admin/ico/projects')->with('success', 'ICO Project was deleted.');
    }

    public function getModalProjectDelete($id = null)
    {
        $error = '';
        $model = '';
        $confirm_route = route('ico.project.delete', ['id' => $id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }


    public function getDealForm()
    {
        session(['buyerId' => null]);
        session(['icoProject' => null]);
        session(['dealId' => null]);

        $platforms = ICOPlatform::all();
        $category = ICOCategory::all();
        $money = ICOMoney::pluck('name', 'id');
        return view('front-end.ico-forms', compact('platforms', 'category', 'money'));
    }

    /**
     * Geting user data get from ICO adding form,
     * saving ut into data base and return new registered user id
     *
     * @param Request $request
     * @return Response|mixed|string
     */
    public function getBuyerData(Request $request)
    {
        $rules = [
            "name" => "required|max:50",
            "email" => "required|email"
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            $response = json_encode([
                'status' => 'error',
                'message' => $errors
            ]);
            return $response;
        }
        try {
            $buyer = ICOBuyer::firstOrCreate([
                'email' => $request->input('email')
            ], [
                "name" => $request->input('name'),
                "company" => $request->input('companyName'),
                "email" => $request->input('email'),
                "mobile" => $request->input('phone'),
            ]);

            $deal = new ICODeal();
            $project = new ICOProjects();
            $deal->getICOBuyer()->associate($buyer);
            $deal->save();
            $project->save();

            $project->getICODeal()->save($deal);
            $project->save();

            session(['buyerId' => $buyer->id]);
            session(['dealId' => $deal->id]);
            session(['icoProject' => $project->id]);

            $response = json_encode([
                'status' => 'success',
                'buyerId' => $buyer->id
            ]);
            return $response;
        } catch (Exception $e) {
            $errors = $e->getMessage();
            $response = json_encode([
                'status' => 'error',
                'message' => $errors
            ]);
            return $response;
        }
    }

    /**
     * Geting ICO project data get from ICO adding form,
     * saving it into data base and return new ICO project id
     *
     * @param Request $request
     * @return mixed
     */
    public function getICOInformation(Request $request)
    {
        $platform = $request->input("ico_platform");
        $platformOther = $request->input("other_platform");
        $category = $request->input("ico_category");
        $categoryOther = $request->input("other_category");

        if (!session('buyerId') === $request->input("buyer_id")) {
            $response = json_encode([
                'status' => 'error',
                'message' => 'Invalid project or user'
            ]);
            return $response;
        }

        $startDate = $request->input('data_start') ? date('Y-m-d H:i:s', strtotime($request->input('data_start'))) : null;
        $endDate = $request->input('data_end') ? date('Y-m-d H:i:s', strtotime($request->input('data_end'))) : null;

        $project = ICOProjects::find(session("icoProject"));
        $project->ico_project_type_id = 1;
        $project->short_description = $request->input('short_description');
        $project->title = $request->input('title');

        $project->ico_category_id = $category === "null" ? null : $category;
        $project->ico_platform_id = $platform === "null" ? null : $platform;
        $project->ico_platform_other = $platformOther === "null" ? null : $platformOther;
        $project->ico_category_other = $categoryOther === "null" ? null : $categoryOther;
        $project->is_active = 0;
        $project->friendly_url = $request->input('friendly_url');
        $project->total_supply = $request->input('total_supply');
        $project->short_token = $request->input('short_money_id');
        $project->number_coins = $request->input('number_coins');
        $project->data_start = $startDate;
        $project->data_end = $endDate;
        $project->link_whitepaper = $request->input('link_whitepaper');
        $project->link_website = $request->input('link_website');

        $socialLinks = json_decode($request->links_array);
        if ($socialLinks || count($socialLinks) > 0) {
            $table = (new ICOProjects)->getTable();
            // Checking if column exist if exist add to array
            foreach ($socialLinks as $link) {
                $socialKey = "link_" . $link->network;
                if (Schema::hasColumn($table, $socialKey)) {
                    $project->$socialKey = $link->networkLink;
                }
            }
        }

        $project->save();

        if ($request->input('money_id')) {
            ICOProjectMoney::updateOrCreate([
                'ico_id' => $project->id,
                'money_id' => $request->input('money_id')
            ]);
        }
        if ($request->file('image')) {
                $image = Image::make($request->file('image'));
                $image->save(storage_path('app/public/upload/images/ICO/' . $project->id . '.jpg'));
                $project->image = 'storage/upload/images/ICO/' . $project->id . '.jpg';
                $project->save();
        }
        $response = json_encode([
            'status' => 'success',
            'icoId' => $project->id
        ]);
        return $response;
    }
    /**
     * Geting ICO project data get from ICO adding form,
     * saving it into data base and return new ICO project id
     *
     * @param Request $request
     * @return Response|string
     */
    public function getICOTeam(Request $request)
    {
        if (!session('icoProject') === $request->input("ico_id")) {
            $response = json_encode([
                'status' => 'error',
                'message' => 'Invalid project'
            ]);
            return $response;
        }
        try {
            $members = $request->input('members');
            if ($members) {
                foreach ($members as $member) {
                    $fullName = explode(" ", $member["fullName"]);
                    $firstName = $fullName[0];
                    if (isset($fullName[1])) {
                        $lastName = $fullName[1];
                    } else {
                        $lastName = "";
                    }
                    ICOMembers::updateOrCreate([
                        'ico_id' => $request->input('ico_id'),
                        'first_name' => $firstName,
                        'last_name' => $lastName
                    ], [
                        'position' => $member['position'],
                        'twitter_link' => isset($member['twitter']) ? $member['twitter'] : "",
                        'linkedin_link' => isset($member['linkedin']) ? $member['linkedin'] : ""
                    ]);
                }
            }
            $response = json_encode([
                'status' => 'success',
            ]);
            return $response;
        } catch (Exception $e) {
            $response = json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
            return $response;
        }
    }

    /**
     * Geting ICO project, chosen user, payment type and payment option,
     * saving it into data base
     *
     * @param Request $request
     * @return Response|string
     */
    public function getPayment(Request $request)
    {
        $rules = [
            "buyer_id" => "required",
            "ico_id" => "required",
            "payment_type_id" => "required",
            "payment_option" => "required",
            "total_coast" => "required"
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            $response = json_encode([
                'status' => 'error',
                'message' => $errors
            ]);
            return $response;
        }
        if (!session('icoProject') === $request->input("ico_id") ||
            !session('buyerId') === $request->input("buyer_id")) {
            $response = json_encode([
                'status' => 'error',
                'message' => 'Invalid project or user'
            ]);
            return $response;
        }

        try {
            $deal = ICODeal::find(session("dealId"));
            $deal->ip_address = $request->ip();
            $deal->payment_type_id = $request->input('payment_type_id');
            $deal->payment_option = $request->input('payment_option');
            $deal->total_coast = $request->input('total_coast');
            $deal->save();

            $response = json_encode([
                'status' => 'success',
                'buyerId' => $deal->id
            ]);

            return $response;
        } catch (Exception $e) {
            $errors = $e->getMessage();
            $response = json_encode([
                'status' => 'error',
                'message' => $errors
            ]);
            return $response;
        }
    }

    /**
     * Get payment type from database and return it in json type to api
     *
     * @return string
     */
    public function getPaymentTypes()
    {
        $priceType = ICOPaymentType::all();
        $resultTypes = [];
        foreach ($priceType as $type) {
            $options = $type->getOptions;
            $resultTypes[$type->name] = [
                'priceId' => $type->id,
                'shortName' => $type->short_name,
                'link' => $type->link,
                'options' => []
            ];
            $resultOptions = [];
            foreach ($options as $option) {
                $resultOptions[$option->payment_key] = $option->price;
            }
            $resultTypes[$type->name]["options"] = $resultOptions;
        }
        $viewTypes = json_encode($resultTypes);
        return $viewTypes;
    }

    public function sendBuyerEmail()
    {
        $buyer = ICOBuyer::find(session('buyerId'));
        $project = ICOProjects::find(session('icoProject'));
        $deal = ICODeal::find(session('dealId'));
        try {
            Mail::to([$buyer->email, env("ADMIN_EMAIL")])->send(new OrderSummary($buyer, $project, $deal));
        } catch (Exception $e) {
            logger("errors", [$e]);
        }
    }

    /**
     * Uploading screenshots from front end form and save it into databese
     *
     * @param Request $request
     * @return string
     */
    public function uploadScreenshot(Request $request)
    {
        $screenShot = $request->file("screenshot");
        $project = ICOProjects::find(session('icoProject'));

        if ($screenShot) {
            $image = Image::make($screenShot);
            $this->imageOptimization($screenShot, "screenshotes", $image, $project, "ico_screenshot");
        }

        $response = json_encode([
            'status' => 'success',
            'icoId' => $project->id
        ]);
        return $response;
    }
}
