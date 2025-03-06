<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemSettingRequest;
use App\Http\Resources\SystemSettingResource;
use App\Models\SystemSetting;
use App\Models\User;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; #Storage: For handling file storage operations.
use PHPUnit\Event\Telemetry\System;

class SystemSettingController extends Controller
{
    use ImageHandler;
    private $model = SystemSetting::class;
    private $resource = SystemSettingResource::class;

    public function index(Request $request)
    {
        $setting = SystemSetting::first();
        return new SystemSettingResource($setting);
    }


    public function store(SystemSettingRequest $request)
    {
        $setting = $this->storeRecord($request, $this->model);
        return new SystemSettingResource($setting);
    }




    public function updateSetting(SystemSettingRequest $request, SystemSetting $systemSetting)
    {


        $systemSetting = $this->updateRecord($request, $systemSetting);
        return new SystemSettingResource($systemSetting);
    }
}
