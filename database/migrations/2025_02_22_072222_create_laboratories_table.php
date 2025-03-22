<?php

use App\Models\Laboratory;
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
        Schema::create((new Laboratory())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(People::class, Laboratory::COLUMN_DENTIST_ID)->nullable();
            $table->foreignIdFor(People::class, Laboratory::COLUMN_DENTIST_ID)->nullable();
            $table->decimal(Laboratory::COLUMN_GRAND_TOTAL, 10, 2);
            $table->date(Laboratory::COLUMN_ISSUED_AT);
            $table->date(Laboratory::COLUMN_RETURN_DATE)->nullable();
            $table->decimal(Laboratory::COLUMN_PAID,10,2)->default(0);
            $table->enum(Laboratory::COLUMN_TYPE, ['in', 'out']);
            $table->text(Laboratory::COLUMN_DESCRIPTION)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new Laboratory())->getTable());
    }
};
