<?php

use App\Enums\LabStatus;
use App\Models\Laboratory;
use App\Models\LaboratoryDetail;
use App\Models\Tooth;
use App\Models\ToothType;
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
        Schema::create((new LaboratoryDetail())->getTable(), function (Blueprint $table) {
            $table->id(); 
            $table->foreignIdFor(Laboratory::class);
            $table->foreignIdFor(Tooth::class);
            $table->decimal(LaboratoryDetail::COLUMN_COST, 10, 2);
            $table->integer(LaboratoryDetail::COLUMN_QUANTITY);
            $table->decimal(LaboratoryDetail::COLUMN_TOTAL, 10, 2);
            $table->enum(LaboratoryDetail::COLUMN_STATUS,LabStatus::getValues())->default(LabStatus::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratory_details');
    }
};
