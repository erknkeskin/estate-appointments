<?php

namespace App\Http\Controllers;

use App\Http\Resources\Office\OfficeResource;
use App\Model\Office;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficeController extends Controller
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
        return Office::all();
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $office = new Office;
        $office->title = $request->title;
        $office->address = $request->address;
        $office->latitude = $request->latitude;
        $office->longitude = $request->longitude;
        $office->status = $request->status;
        $office->save();

        return response()->json([
            'data' => new OfficeResource($office)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Model\Office $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        return new OfficeResource($office);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\Office $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Office $office
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {
        $office->update($request->all());

        return response([
            'data' => new HomeResource($office)
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\Office $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        $office->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
