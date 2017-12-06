<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Redirect;

class RedirectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redirects = Redirect::all();
        return view('admin.redirects.index', compact('redirects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.redirects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'old_link' => 'required',
            'new_link' => 'required'
        ]);
        Redirect::create(['old_link' => $request->old_link, 'new_link' => $request->new_link]);
        return redirect('/admin/redirects');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $redirect = Redirect::findOrFail($id);
        return view('admin.redirects.edit', compact('redirect'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'old_link' => 'required',
            'new_link' => 'required'
        ]);
        $redirect = Redirect::findOrFail($id);
        $redirect->old_link = $request->old_link;
        $redirect->new_link = $request->new_link;
        $redirect->save();
        return redirect('/admin/redirects')->with('success', 'The redirect was edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $redirect = Redirect::findOrFail($id);
        $redirect->delete();
        return back();
    }
}
