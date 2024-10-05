<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage= $request->input("perPage");
        $search= $request->input("search");

        $appointments= Appointment::with(['patient','dentist','user'])->search($search)->latest()->paginate($perPage);
        return AppointmentResource::collection($appointments);
    }

  
    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request)
    {
        
        $validated= $request->validated();
        $validated['user_id'] = Auth::id()?? 1;
        $appointment = Appointment::create($validated);
        return new AppointmentResource($appointment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return AppointmentResource::make($appointment);
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated= $request->validated();
        $validated['user_id'] = Auth::id()?? 1;
        $appointment->update($validated);
        return new AppointmentResource($appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return new AppointmentResource($appointment);
    }
}
