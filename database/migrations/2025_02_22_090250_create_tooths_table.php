<?php

use App\Models\Tooth;
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
        Schema::create((new Tooth())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string(Tooth::COLUMN_NAME);
            $table->text(Tooth::COLUMN_DESCRIPTION)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tooth_types');
    }
};
