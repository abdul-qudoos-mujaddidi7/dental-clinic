<?php

use App\Models\User;
use App\Models\Expense;
use App\Models\MoneyAccount;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id(); 
            $table->date('date');
            $table->string('reference',20);
            $table->decimal('amount', 10, 2); //with precision (10, 2)
            $table->text(Expense::COLUMN_DESCRIPTION)->nullable();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(MoneyAccount::class);
            $table->foreignIdFor(ExpenseCategory::class);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
