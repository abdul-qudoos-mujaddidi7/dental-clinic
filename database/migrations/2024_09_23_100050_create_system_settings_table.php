<?php

use App\Models\SystemSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Event\Telemetry\System;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create((new SystemSetting())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string(SystemSetting::COLUMN_NAME);
            $table->string(SystemSetting::COLUMN_EMAIL)->unique();
            $table->string(SystemSetting::COLUMN_PHONE,15)->nullable();
            $table->string(SystemSetting::COLUMN_IMAGE)->nullable();
            $table->text(SystemSetting::COLUMN_ADDRESS);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new SystemSetting())->getTable());
    }
};
