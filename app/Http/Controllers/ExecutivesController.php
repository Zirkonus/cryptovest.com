<?php

namespace App\Http\Controllers;

use App\Country;
use App\Executive;
use App\ExecutiveRole;
use App\ExecutiveSupport;
use App\Http\Translate\Translate;
use App\ICOProjects;
use App\Language;
use App\LanguageValue;
use App\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ExecutivesController extends Controller
{
    public function index()
    {
        $languages = Language::get();
        $executives = Executive::get();
        return view('admin.executives.index', compact('executives', 'languages'));
    }

    public function create()
    {
        $languages = Language::get();
        $roles = ExecutiveRole::all()->pluck('name', 'id');
        $countries = Country::all()->pluck('name', 'id');
        $icos = ICOProjects::all();
        $supports = ExecutiveSupport::all()->pluck('name', 'id');

        return view('admin.executives.create', compact('languages', 'roles', 'countries', 'icos', 'supports'));
    }

    public function store(Request $request)
    {
        $mainLangId = Translate::getEnglishId();
        $url = $request->input('name_' . $mainLangId) . ' ' . $request->input('last-name_' . $mainLangId);
        $authUrl = Translate::storeKey($url);
        $executive = Executive::where('url', $authUrl)->first();

        if ($executive) {
            return redirect()->back()->withErrors('Executive with this First and Last name already exist!')->withInput();
        }

        $executive = Executive::create([
            'url'       => $authUrl
        ]);

        $executive->first_name_lang_key = 'executive-first-name-' . $executive->id;
        $executive->last_name_lang_key = 'executive-last-name-' . $executive->id;
        $executive->biography_lang_key = 'executive-biography-' . $executive->id;

        if ($file = $request->file('image')) {
            $image = Image::make($file);
            $fileExtension = $file->getClientOriginalExtension();
            $this->imageOptimization($file, false, $image, $executive, "profile_image", 'profile-executive-' . $executive->id . '_origin.' . $fileExtension);
            if (($image->width() > 352) || ($image->height() > 352)) {
                $image->resize(352, 352);
            }

            $this->imageOptimization($file, false, $image, $executive, "profile_image", 'profile-executive-' . $executive->id . '.' . $fileExtension);
        }
        if ($request->input('is_active')) {
            $executive->is_active = 1;
        }
        if ($roles = $request->input('roles')) {
            $rolesArray = explode(",", $roles);
            $executive->roles()->sync($rolesArray);
        }
        if ($supports = $request->input('supports')) {
            $supportsArray = explode(",", $supports);
            $executive->supports()->sync($supportsArray);
        }
        if ($country = $request->input('country')) {
            $executive->country_id = $country;
        }
        if ($icos = $request->input('icos')) {
            $icosArray = explode(",", $icos);
            $executive->ICOProjects()->sync($icosArray);
        }
        if ($twitter = $request->input('twitter_link')) {
            $executive->twitter_link = $twitter;
        }
        if ($linkedin = $request->input('linkedin_link')) {
            $executive->linkedin_link = $linkedin;
        }
        $executive->save();
        $languages = Language::get();
        foreach ($languages as $lang) {
            if ($request->input('name_' . $lang->id) && !is_null($request->input('name_' . $lang->id))) {
                LanguageValue::create([
                    'language_id' => $lang->id,
                    'key' => $executive->first_name_lang_key,
                    'value' => $request->input('name_' . $lang->id)
                ]);
            }
            if ($request->input('last-name_' . $lang->id) && !is_null($request->input('last-name_' . $lang->id))) {
                LanguageValue::create([
                    'language_id' => $lang->id,
                    'key' => $executive->last_name_lang_key,
                    'value' => $request->input('last-name_' . $lang->id)
                ]);
            }
            if ($request->input('biography_' . $lang->id) && !is_null($request->input('biography_' . $lang->id))) {
                LanguageValue::create([
                    'language_id' => $lang->id,
                    'key' => $executive->biography_lang_key,
                    'value' => $request->input('biography_' . $lang->id)
                ]);
            }
        }
        return redirect('admin/executives')->with('success', 'New executive was created!');
    }

    public function edit($id)
    {
        $executive  = Executive::find($id);
        $languages  = Language::get();
        $executiveCountry = $executive->country() ? $executive->country()->pluck('id') : null;
        $roles = ExecutiveRole::all()->pluck('name', 'id');
        $supports = ExecutiveSupport::all()->pluck('name', 'id');
        $countries = Country::all()->pluck('name', 'id');
        $icos = ICOProjects::all()->pluck('title', 'id');
        $twitterLink = $executive->twitter_link;
        $linkedinLink = $executive->linkedin_link;

        $executiveIcos = $executive->ICOProjects()->get()->pluck("title", "id");
        $resultIcos = [];
        foreach ($executiveIcos as $val => $icoItem) {
            array_push($resultIcos, [
                'text' => $icoItem,
                'val' => (string)$val
                ]);
        }
        $resultIcos = json_encode($resultIcos);

        $executiveRoles = $executive->roles() ? $executive->roles()->get()->pluck("name", "id") : "";
        $resultRoles = [];
        foreach ($executiveRoles as $roleVal => $roleItem) {
            array_push($resultRoles, [
                'text' => $roleItem,
                'val' => (string)$roleVal
            ]);
        }
        $resultRoles = json_encode($resultRoles);

        $executiveSupports = $executive->supports() ? $executive->supports()->get()->pluck("name", "id") : "";
        $resultSupports = [];
        foreach ($executiveSupports as $supportVal => $supportItem) {
            array_push($resultSupports, [
                'text' => $supportItem,
                'val' => (string)$supportVal
            ]);
        }
        $resultSupports = json_encode($resultSupports);

        return view('admin.executives.edit', compact(
            'languages',
            'executive',
            'roles',
            'countries',
            'icos',
            'resultRoles',
            'executiveCountry',
            'twitterLink',
            'linkedinLink',
            'resultIcos',
            'supports',
            'resultSupports'
        ));
    }

    public function update($id, Request $request)
    {
        $executive = Executive::find($id);

        $engLang = Translate::getEnglishId();
        $string = $request->input('name_' . $engLang) . ' ' . $request->input('last-name_' . $engLang);
        $url = Translate::storeKey($string);
        if ($url != $executive->url) {
            $userCheck = Executive::where('url', $url)->first();
            if ($userCheck) {
                return redirect()->back()->withErrors('Name and Last Name already exist!')->withInput();
            }
            $executive->url = $url;
        }

        if ($file = $request->file('new-image')) {
            $image = Image::make($file);
            $fileExtension = $file->getClientOriginalExtension();
            $this->imageOptimization($file, false, $image, $executive, "profile_image", 'profile-executive-' . $executive->id . '_origin.' . $fileExtension);
            if (($image->width() > 352) || ($image->height() > 352)) {
                $image->resize(352, 352);
            }

            $this->imageOptimization($file, false, $image, $executive, "profile_image", 'profile-executive-' . $executive->id . '.' . $fileExtension);
        }

        if ($request->input('is_active')) {
            $executive->is_active = 1;
        } else {
            $executive->is_active = 0;
        }

        if (is_null($executive->first_name_lang_key)) {
            $executive->first_name_lang_key = 'executive-first-name-' . $executive->id;
        }

        if (is_null($executive->last_name_lang_key)) {
            $executive->last_name_lang_key = 'executive-last-name-' . $executive->id;
        }
        if (is_null($executive->biography_lang_key)) {
            $executive->biography_lang_key = 'executive-biography-' . $executive->id;
        }

        $roles = $request->input('roles');
        $rolesArray = $roles ? explode(",", $roles) : null;
        $executive->roles()->sync($rolesArray);

        $supports = $request->input('supports');
        $supportsArray = $supports ? explode(",", $supports) : null;
        $executive->supports()->sync($supportsArray);

        $icos = $request->input('icos');
        $icosArray = $icos ? explode(",", $icos) : null;
        $executive->ICOProjects()->sync($icosArray);

        if ($country = $request->input('country')) {
            $executive->country_id = $country;
        }

        if ($twitter = $request->input('twitter_link')) {
            $executive->twitter_link = $twitter;
        }
        if ($linkedin = $request->input('linkedin_link')) {
            $executive->linkedin_link = $linkedin;
        }
        $executive->save();

        $languages = Language::get();

        foreach ($languages as $lang) {
            if (is_null($request->input('name_' . $lang->id))) {
                $val = LanguageValue::where(['language_id' => $lang->id, 'key' => $executive->first_name_lang_key])->first();
                if ($val) {
                    $val->value = '';
                    $val->save();
                }
            } else {
                $val = LanguageValue::where(['language_id' => $lang->id, 'key' => $executive->first_name_lang_key])->first();
                if ($val) {
                    $val->value = $request->input('name_' . $lang->id);
                    $val->save();
                } else {
                    LanguageValue::create([
                        'language_id' => $lang->id,
                        'key' => $executive->first_name_lang_key,
                        'value' => $request->input('name_' . $lang->id)
                    ]);
                }
            }
            if (is_null($request->input('last-name_' . $lang->id))) {
                $val = LanguageValue::where(['language_id' => $lang->id, 'key' => $executive->last_name_lang_key])->first();
                if ($val) {
                    $val->value = '';
                    $val->save();
                }
            } else {
                $val = LanguageValue::where(['language_id' => $lang->id, 'key' => $executive->last_name_lang_key])->first();
                if ($val) {
                    $val->value = $request->input('last-name_' . $lang->id);
                    $val->save();
                } else {
                    LanguageValue::create([
                        'language_id' => $lang->id,
                        'key' => $executive->last_name_lang_key,
                        'value' => $request->input('last-name_' . $lang->id)
                    ]);
                }
            }
            if (is_null($request->input('biography_' . $lang->id))) {
                $val = LanguageValue::where(['language_id' => $lang->id, 'key' => $executive->biography_lang_key])->first();
                if ($val) {
                    $val->value = '';
                    $val->save();
                }
            } else {
                $val = LanguageValue::where(['language_id' => $lang->id, 'key' => $executive->biography_lang_key])->first();
                if ($val) {
                    $val->value = $request->input('biography_' . $lang->id);
                    $val->save();
                } else {
                    LanguageValue::create([
                        'language_id' => $lang->id,
                        'key' => $executive->biography_lang_key,
                        'value' => $request->input('biography_' . $lang->id)
                    ]);
                }
            }

        }
        return redirect('admin/executives')->with('success', 'Executive was edited!');
    }

    public function getModalDelete($id = null)
    {
        $error = '';
        $model = '';
        $confirm_route = route('executives.delete', ['id' => $id]);

        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        $executive = Executive::find($id);

        LanguageValue::where('key', $executive->first_name_lang_key)->delete();
        LanguageValue::where('key', $executive->last_name_lang_key)->delete();
        LanguageValue::where('key', $executive->biography_lang_key)->delete();
        $executive->ICOProjects()->sync(null);
        $executive->roles()->sync(null);
        $executive->delete();
        return redirect('admin/executives')->with('success', 'Executive was deleted success.');
    }

    public function listRoles()
    {
        $roles = ExecutiveRole::all();
        return view('admin.executives.roles.index', ['roles' => $roles]);
    }
    public function createRole()
    {
        return view('admin.executives.roles.create');
    }

    public function storeRole(Request $request)
    {
        $rules = [
            'name' => 'required'
        ];
        $validator  = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $roles = ExecutiveRole::create([
            'name' => $request->input("name")
            ]);
        return redirect('admin/executives/roles')->with('success', $roles->name . ' role was created');
    }

    public function editRole($id)
    {
        $role = ExecutiveRole::find($id);
        return view('admin.executives.roles.edit', ['role' => $role]);
    }

    public function saveRole(Request $request, $id)
    {
        $rules = [
            'name' => 'required'
        ];
        $validator  = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $roles = ExecutiveRole::find($id);
        $roles->name = $request->input("name");
        $roles->save();
        return redirect('admin/executives/roles')->with('success', $roles->name . ' role was updated');
    }
    public function deleteRole($id)
    {
        $role = ExecutiveRole::find($id);
        $role->delete();
        return redirect('admin/executives/roles')->with('success', 'Executive Role was deleted success.');
    }

    public function listSupports()
    {
        $supports = ExecutiveSupport::all();
        return view('admin.executives.supports.index', ['supports' => $supports]);
    }
    public function createSupports()
    {
        return view('admin.executives.supports.create');
    }

    public function storeSupports(Request $request)
    {
        $rules = [
            'name' => 'required'
        ];
        $validator  = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $supports = ExecutiveSupport::create([
            'name' => $request->input("name")
        ]);
        return redirect('admin/executives/supports')->with('success', $supports->name . ' support was created');
    }

    public function editSupports($id)
    {
        $support = ExecutiveSupport::find($id);
        return view('admin.executives.supports.edit', ['support' => $support]);
    }

    public function saveSupports(Request $request, $id)
    {
        $rules = [
            'name' => 'required'
        ];
        $validator  = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $supports = ExecutiveSupport::find($id);
        $supports->name = $request->input("name");
        $supports->save();
        return redirect('admin/executives/supports')->with('success', $supports->name . ' support was updated');
    }
    public function deleteSupports($id)
    {
        $role = ExecutiveSupport::find($id);
        $role->delete();
        return redirect('admin/executives/supports')->with('success', 'Executive Support was deleted success.');
    }

    public function filteredData(Request $request)
    {
        $roles = $request->input("roles") ? : null;
//        $project = $request->input("project") ? : null;
//        $country = $request->input("country") ? : null;
        $search = $request->input("search") ? : null;
        $executives = Executive::where("is_active", 1);
//        $executives = $country ? $executives->where('country_id', $country) : $executives;
        $executives = $roles ? $executives->whereHas('roles', function ($query) use ($roles) {
            $query->where('role_id', $roles);
        }) : $executives;

//        $executives = $project ? $executives->whereHas('ICOProjects', function ($query) use ($project) {
//            $query->where('ico_projects_id', $project);
//        }) : $executives;
        $executives = $executives->get()->sortBy(function ($executive) {
            return $executive->ICOProjects->count();
        }, 0, true);
        $result = new Collection();
        foreach ($executives as $executive) {
            $roles = [];
            foreach ($executive->roles as $role) {
                array_push($roles, $role->name);
            }
            $result->push([
                'id' => $executive->id,
                'url' => $executive->url,
                'img' => asset($executive->profile_image),
                'name' => Translate::getValue($executive->first_name_lang_key) . " " . Translate::getValue($executive->last_name_lang_key),
                'role' => implode(", ", $roles),
                'location' => $executive->country->name,
//                'involved' => $executive->ICOProjects->count(),
                'twitter' => $executive->twitter_link,
                'linkedin' => $executive->linkedin_link,
            ]);
        }
        $result = $search ? $result->filter(function ($value, $key) use ($search) {
            if (strpos(strtolower($value['name']), $search) !== false) {
                return true;
            }
        }) : $result;
        $customPagination = $this->paginate($result, 20, $request->input("page"));

        return json_encode($customPagination->items());
    }

    protected function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
