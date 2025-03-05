<?php

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
        Schema::create((new People())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string(People::COLUMN_NAME);
            $table->string(People::COLUMN_PHONE)->nullable();
            $table->string(People::COLUMN_EMAIL)->nullable()->unique();
            $table->string(People::COLUMN_ADDRESS)->nullable();
            $table->enum(People::COLUMN_TYPE, ['patient', 'dentist', 'supplier', 'owner', 'employee', 'customer']);

            // Fields specific to patients
            $table->date(People::COLUMN_DATE_OF_BIRTH)->nullable();
            $table->enum(People::COLUMN_GENDER, ['Male', 'Female'])->nullable();
            $table->json(People::COLUMN_MEDICAL_RECORD)->nullable();
            $table->json(People::COLUMN_DENTAL_RECORD)->nullable();

            // Fields specific to dentists
            // $table->boolean(People::COLUMN_STATUS)->nullable();

            // Fields specific to owners
            // $table->decimal(People::COLUMN_SHARE, 10, 2)->nullable();

            // Fields specific to employees
            $table->decimal(People::COLUMN_SALARY, 10, 2)->nullable();
            $table->string(People::COLUMN_POSITION)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new People())->getTable());
    }
};
