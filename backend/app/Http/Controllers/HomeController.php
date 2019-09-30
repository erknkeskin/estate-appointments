<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeRequest;
use App\Http\Resources\Home\HomeResource;
use App\Model\Home;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Home::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeRequest $request)
    {
        $home = new Home;
        $home->title = $request->title;
        $home->note = $request->note;
        $home->latitude = $request->latitude;
        $home->longitude = $request->longitude;
        $home->save();

        return response([
            'data' => new HomeResource($home)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function show(Home $home)
    {
        return new HomeResource($home);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Home $home)
    {
        $home->update($request->all());

        return response([
            'data' => new HomeResource($home)
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function destroy(Home $home)
    {
        $home->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
