<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemSettingRequest;
use App\Http\Resources\SystemSettingResource;
use App\Models\SystemSetting;
use App\Models\User;
use App\Traits\ImageHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; #Storage: For handling file storage operations.


class SystemSettingController extends Controller 
{
    use ImageHandler;

    public function index()
    {
        $setting = SystemSetting::first();

        if (!$setting) {
            return response()->json(['message' => 'System settings not found.'], 404);
        }

        return new SystemSettingResource($setting);
    }


    public function store(SystemSettingRequest $request){
        $validated= $request->validated();
        $validated['image'] = $request->hasFile('image') ? $this->storeImage($request,'company'): null;
        $system= SystemSetting::create($validated);

        return new SystemSettingResource($system);
    }



    public function updateSetting(SystemSettingRequest $request, SystemSetting $systemSetting)
    {
        $validated = $request->validated();
        $validated['image'] = $request->hasFile('image') ? $this->updateImage($request, $systemSetting, 'company') : null;        

       
        $systemSetting->update($validated); // Update the system setting
        return new SystemSettingResource($systemSetting);
    }
}
