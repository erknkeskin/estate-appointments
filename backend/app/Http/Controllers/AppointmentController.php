<?php

namespace App\Http\Controllers;

use App\Http\Resources\Appointment\AppointmentResource;
use App\Model\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
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
        return DB::table('appointments')
            ->select('appointments.title as appointment_title', 'homes.title as home_title', 'customers.fullname as customer_name')
            ->leftJoin('homes', 'homes.id','=', 'appointments.home_id')
            ->leftJoin('customers', 'customers.id', '=', 'appointments.customer_id')
            ->where('appointments.status', '=', 1)
            ->where('homes.status', '=', 1)
            ->where('customers.status', '=', 1)
            ->get()->toJson();
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
        $appointment = new Appointment;
        $appointment->customer_id = $request->customer_id;
        $appointment->user_id = $request->user_id;
        $appointment->home_id = $request->home_id;
        $appointment->title = $request->title;
        $appointment->note = $request->note;
        $appointment->start = strtotime($request->start);
        $appointment->save();

        return response()->json([
            'data' => new AppointmentResource($appointment)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Model\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        return new AppointmentResource($appointment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $appointment->update($request->all());

        return response()->json([
            'data' => new AppointmentResource($appointment)
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
