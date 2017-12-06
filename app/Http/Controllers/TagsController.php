<?php

namespace App\Http\Controllers;

use App\Http\Translate\Translate;
use App\Language;
use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index()
    {
        $languages = Language::get();
        $tags = Tag::get();
        return view('admin.tags.index', compact('tags', 'languages'));
    }

    public function create(Request $request)
    {
        $languages  = Language::get();

        return view('admin.tags.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $languages  = Language::get();
        $englId     = $languages->where('is_english', 1)->first();

        if (!$request->input('name_'.$englId->id)) {
            return redirect()->back()->withErrors('Name for English Language is Important!')->withInput();
        }

        $url    = Translate::storeKey($request->input('name_'.$englId->id));

        $tag = new Tag();
        $tag->name = $request->input('name_'.$englId->id);
        $tag->slug = $url;
        $tag->save();

        return redirect('admin/tags')->with('success', 'Tag created.');
    }

    public function edit($id, Request $request)
    {
        $languages  = Language::get();
        $tag = Tag::find($id);

        return view('admin.tags.edit', compact('languages', 'tag'));
    }

    public function update($id, Request $request)
    {
        $languages  = Language::get();
        $englId     = $languages->where('is_english', 1)->first();
        $tag      = Tag::find($id);

        if (!$request->input('name_'.$englId->id)) {
            return redirect()->back()->withErrors('Name for English Language is Important!')->withInput();
        }

        $url    = Translate::storeKey($request->input('name_'.$englId->id));

        $tag->name = $request->input('name_'.$englId->id);
        $tag->slug = $url;
        $tag->save();

        return redirect('admin/tags')->with('success', 'Tag was changed and saved.');
    }

    public function getModalDelete($id = null)
    {
        $error          = '';
        $model          = '';
        $confirm_route  =  route('tags.delete',['id'=>$id]);
        return View('admin/layouts/modal_confirmation', compact('error','model', 'confirm_route'));
    }

    public function getDelete($id = null)
    {
        $tag = Tag::find($id);
        $tag->delete();
        return redirect('admin/tags')->with('success', 'Tag was deleted success.');
    }
}