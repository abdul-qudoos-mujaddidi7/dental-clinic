<?php

use App\Models\Cure;
use App\Models\Service;
use App\Models\ServiceGroup;
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
        Schema::create('cure_services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cure::class)->constrained();
            $table->foreignIdFor(Service::class)->constrained();
            $table->decimal('cost',10,2);
            $table->decimal('discount',10,2);
            $table->decimal('total',10,2);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cure_services');
    }
};
