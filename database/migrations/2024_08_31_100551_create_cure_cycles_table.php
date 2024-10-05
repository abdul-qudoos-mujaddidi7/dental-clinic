<?php

use App\Models\Appointment;
use App\Models\Cure;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cure_cycles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Appointment::class)->constrained();
            $table->foreignIdFor(Cure::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cure_cycles');
    }
};
