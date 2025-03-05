<?php

use App\Enums\TransferType;
use App\Models\MoneyTransfer;
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
        Schema::create((new MoneyTransfer())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->bigInteger(MoneyTransfer::COLUMN_FROM_ACCOUNT_ID);
            $table->bigInteger(MoneyTransfer::COLUMN_TO_ACCOUNT_ID);
            $table->bigInteger(MoneyTransfer::COLUMN_AMOUNT);
            $table->dateTime(MoneyTransfer::COLUMN_DATE);
            $table->string(MoneyTransfer::COLUMN_DESCRIPTION);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new MoneyTransfer())->getTable());
    }
};
