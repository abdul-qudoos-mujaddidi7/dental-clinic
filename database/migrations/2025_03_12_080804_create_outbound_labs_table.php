<?php

use App\Models\OutboundLab;
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
        Schema::create((new OutboundLab())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(People::class, OutboundLab::COLUMN_SUPPLIER_ID);
            $table->integer('people_account_id');
            $table->integer('money_account_id');
            $table->decimal(OutboundLab::COLUMN_GRAND_TOTAL, 10, 2);
            $table->date(OutboundLab::COLUMN_ISSUED_AT);
            $table->date(OutboundLab::COLUMN_RETURN_DATE)->nullable();
            $table->decimal(OutboundLab::COLUMN_PAID,10,2)->default(0);
            $table->text(OutboundLab::COLUMN_DESCRIPTION)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new OutboundLab())->getTable());
    }
};
