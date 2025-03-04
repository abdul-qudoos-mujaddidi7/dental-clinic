<?php

use App\Models\Category;
use App\Models\Lead;
use App\Models\Stage;
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
        Schema::create((new Lead())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string(Lead::COLUMN_NAME);
            $table->string(Lead::COLUMN_PHONE)->nullable();
            $table->enum(Lead::COLUMN_GENDER, ['Male', 'Female']);
            $table->string(Lead::COLUMN_ADDRESS)->nullable();
            $table->date(Lead::COLUMN_DATE);
            $table->foreignId(Lead::COLUMN_CATEGORY_ID)->constrained(); // Foreign key to Category table
            $table->foreignId(Lead::COLUMN_STAGE_ID)->constrained(); // Foreign key to Stage table
            $table->text(Lead::COLUMN_NOTE)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
