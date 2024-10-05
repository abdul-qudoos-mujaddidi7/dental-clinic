<?php

use App\Models\Supplier;
use App\Models\User;
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
        Schema::create('bill_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('bill_number')->unique(); 
            $table->date('bill_date'); 
            $table->decimal('paid',10,2);
            $table->decimal('grand_total', 10, 2);
            $table->text('note')->nullable();
            $table->foreignIdFor(Supplier::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_expenses');
    }
};