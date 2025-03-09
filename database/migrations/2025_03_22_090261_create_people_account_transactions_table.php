<?php

use App\Models\People;
use App\Enums\PaymentType;
use App\Enums\OperationType;
use App\Models\MoneyAccount;
use App\Models\PeopleAccount;
use App\Enums\TransactionType;
use Illuminate\Support\Facades\Schema;
use App\Models\PeopleAccountTransaction;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


return new class extends Migration
{

    public function up(): void
    {
        Schema::create((new PeopleAccountTransaction())->getTable(), function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger(PeopleAccountTransaction::COLUMN_PARENT_RECORD_ID)->nullable();

            $table->foreignId(PeopleAccountTransaction::COLUMN_PEOPLE_ID)->nullable()
            ->constrained((new People())->getTable())
            ->restrictOnDelete()->restrictOnUpdate();

            $table->foreignId(PeopleAccountTransaction::COLUMN_MONEY_ACCOUNT_ID)->nullable()
            ->constrained((new MoneyAccount())->getTable())
            ->restrictOnDelete()
            ->restrictOnUpdate();

            $table->foreignId(PeopleAccountTransaction::COLUMN_PEOPLE_ACCOUNT_ID)->nullable()
            ->constrained((new PeopleAccount())->getTable())
            ->restrictOnDelete()
            ->restrictOnUpdate();

            $table->enum(PeopleAccountTransaction::COLUMN_TRANSACTION_TYPE,TransactionType::getValues());
            $table->enum(PeopleAccountTransaction::COLUMN_OPERATION_TYPE,OperationType::getValues());
            $table->enum(PeopleAccountTransaction::COLUMN_PAYMENT_TYPE, PaymentType::getValues());

            $table->decimal(PeopleAccountTransaction::COLUMN_AMOUNT, 16, 2);
    
            $table->string(PeopleAccountTransaction::COLUMN_DESCRIPTION)->nullable();
            $table->dateTime(PeopleAccountTransaction::COLUMN_DATE);
            $table->softDeletes();
            $table->timestamps();

        });

        }

    public function down(): void
    {

        Schema::dropIfExists((new PeopleAccountTransaction())->getTable());
    }
};
