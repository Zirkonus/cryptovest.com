<?php

namespace App\Http\Controllers;

use App\City;
use App\ICOPromotion;
use Illuminate\Http\Request;
use App\Event;
use Image;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $promotions = ICOPromotion::where('is_active', 1)->pluck('name', 'id');
        $cities = City::orderBy('name')->get();
        return view('admin.events.create', compact('promotions', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $country_id = City::findOrFail($request->city_id)->country_id;
        $event = new Event();
        $event->name = $request->name;
        $event->friendly_url = $request->friendly_url;
        $event->short_description = $request->short_description;
        $event->link = $request->link_but_explore_more;
        $event->date_start = $request->date_start;
        $event->city_id = $request->city_id;
        $event->country_id = $country_id;
        if ($request->input('ico_promotion')) {
            $event->ico_promotion_id = $request->input('ico_promotion');
        }
        if ($request->is_widget) {
            $event->top_featured = 1;
        }
        if ($request->is_active) {
            $event->is_active = 1;
        }
        $event->save();
        return redirect('/admin/events');
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
        $event = Event::findOrFail($id);
        $cities = City::all();
        $promotions = ICOPromotion::where('is_active', 1)->pluck('name', 'id');
        return view('admin.events.edit', compact('event', 'cities', 'promotions'));
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
        $event = Event::findOrFail($id);
        $country_id = City::findOrFail($request->city_id)->country_id;
        $event->name = $request->name;
        $event->friendly_url = $request->friendly_url;
        $event->short_description = $request->short_description;
        $event->link = $request->link_but_explore_more;
        $event->date_start = $request->date_start;
        $event->city_id = $request->city_id;
        $event->country_id = $country_id;
        if ($request->input('ico_promotion')) {
            $event->ico_promotion_id = $request->input('ico_promotion');
        } else {
            $event->ico_promotion_id = 10;
        }
        $request->is_widget ? $event->top_featured = 1: $event->top_featured = 0;
        $request->is_active ? $event->is_active = 1: $event->is_active = 0;
        $event->save();
        return back();
        return redirect('/admin/events')->with('success', 'The event was edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return back();
    }
}
