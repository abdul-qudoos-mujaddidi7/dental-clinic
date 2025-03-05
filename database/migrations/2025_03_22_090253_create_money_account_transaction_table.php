<?php

use App\Models\People;
use App\Enums\PaymentType;
use App\Enums\OperationType;
use App\Models\MoneyAccount;
use Illuminate\Support\Facades\Schema;
use App\Models\MoneyAccountTransaction;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create((new MoneyAccountTransaction())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->integer(MoneyAccountTransaction::COLUMN_PARENT_RECORD_ID)->nullable();

            $table->foreignId(MoneyAccountTransaction::COLUMN_MONEY_ACCOUNT_ID)
            ->constrained((new MoneyAccount())->getTable())
            ->noActionOnDelete()
            ->noActionOnUpdate();

            $table->foreignId(MoneyAccountTransaction::COLUMN_PEOPLE_ID)
            ->constrained((new People())->getTable())
            ->noActionOnDelete()
            ->noActionOnUpdate();

            $table->decimal(MoneyAccountTransaction::COLUMN_AMOUNT, 10, 2);
            $table->enum(MoneyAccountTransaction::COLUMN_OPERATION_TYPE, OperationType::getValues());
            $table->enum(MoneyAccountTransaction::COLUMN_PAYMENT_TYPE, PaymentType::getValues());

            $table->string(MoneyAccountTransaction::COLUMN_DESCRIPTION)->nullable();
            $table->dateTime(MoneyAccountTransaction::COLUMN_DATE);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new MoneyAccountTransaction())->getTable());
    }
};
