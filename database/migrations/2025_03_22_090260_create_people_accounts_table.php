<?php

use App\Enums\Status;
use App\Models\Currency;
use App\Models\People;
use App\Models\PeopleAccount;
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
        Schema::create((new PeopleAccount())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string(PeopleAccount::COLUMN_NAME)->default("name");

            $table->foreignId(PeopleAccount::COLUMN_PEOPLE_ID)
            ->constrained((new People())->getTable())
            ->restrictOnDelete()->restrictOnUpdate();

            $table->decimal(PeopleAccount::COLUMN_ACCOUNT_BALANCE, 16, 2)->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new PeopleAccount())->getTable());
    }
};
