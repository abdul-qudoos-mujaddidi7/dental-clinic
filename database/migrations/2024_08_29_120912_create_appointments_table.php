<?php

use App\Models\Dentist;
use App\Models\Patient;
use App\Models\People;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Appointment;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create((new Appointment())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->dateTime(Appointment::COLUMN_DATETIME);
            $table->string(Appointment::COLUMN_STATUS);
            $table->foreignIdFor(People::class, Appointment::COLUMN_DENTIST_ID);
            $table->foreignIdFor(User::class, Appointment::COLUMN_USER_ID);
            $table->foreignIdFor(People::class, Appointment::COLUMN_PATIENT_ID);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new Appointment())->getTable());
    }
};
