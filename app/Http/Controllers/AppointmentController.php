<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    private $model = Appointment::class;
    private $resource = AppointmentResource::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $appointments = $this->listRecord($request, $this->model, ['people_id'], ['patient', 'dentist', 'user']);
        return $this->resource::collection($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request)
    {
        
        $appointment = $this->storeRecord($request, $this->model);
        return new $this->resource($appointment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return new $this->resource($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentRequest $request, Appointment $appointment)
    {

        
        $appointment = $this->updateRecord($request, $appointment);
        return new $this->resource($appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $this->deleteRecord($appointment);
        return new $this->resource($appointment);
    }
}
