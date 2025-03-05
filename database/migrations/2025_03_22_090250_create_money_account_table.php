<?php

use App\Enums\Status;
use App\Models\MoneyAccount;
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
        Schema::create((new MoneyAccount())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string(MoneyAccount::COLUMN_NAME)->default("cash");
            $table->decimal(MoneyAccount::COLUMN_BALANCE, 16, 2)->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new MoneyAccount())->getTable());
    }
};
