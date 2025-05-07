<?php

use App\Models\InboundLab;
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
        Schema::create((new InboundLab())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(People::class, InboundLab::COLUMN_DENTIST_ID);
            $table->foreignIdFor(People::class, InboundLab::COLUMN_CUSTOMER_ID);
            $table->integer('people_account_id');
            $table->integer('money_account_id');
            $table->decimal(InboundLab::COLUMN_GRAND_TOTAL, 10, 2);
            $table->date(InboundLab::COLUMN_ISSUED_AT);
            $table->date(InboundLab::COLUMN_RETURN_DATE)->nullable();
            $table->decimal(InboundLab::COLUMN_PAID,10,2)->default(0);
            $table->text(InboundLab::COLUMN_DESCRIPTION)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new InboundLab())->getTable());
    }
};
