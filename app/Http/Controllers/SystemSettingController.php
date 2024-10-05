<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemSettingRequest;
use App\Http\Resources\SystemSettingResource;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Storage; #Storage: For handling file storage operations.


class SystemSettingController extends Controller
{
    public function index()
{
    $setting = SystemSetting::first();

    if (!$setting) {
        return response()->json(['message' => 'System settings not found.'], 404);
    }

    return new SystemSettingResource($setting);
}


 
    public function updateSetting(SystemSettingRequest $request, SystemSetting $systemSetting)
    {
        
        $validated= $request->validated();

        if($request->hasFile('photo')){
            Storage::disk('public')->delete($systemSetting->photo);
            // If it is, the old photo is deleted from the public storage 
            $path = $request->file('photo')->store('images/company', 'public');
            return $path;
            $validated['photo'] = $path;
        }
        
        $systemSetting->update($validated);
        return new SystemSettingResource($systemSetting);
    }

    
   
}
