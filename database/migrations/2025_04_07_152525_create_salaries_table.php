<?php

use App\Models\People;
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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id(); 
            $table->foreignIdFor(People::class);
            $table->decimal('amount', 10, 2); 
            $table->date('paid_at')->nullable(); // Date the salary was paid
            $table->string('description')->nullable(); // Optional notes or description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
