<?php


use App\Models\Cure;
use App\Models\Expense;
use App\Enums\PaymentType;
use App\Enums\OperationType;
use App\Enums\TransactionType;
use Illuminate\Support\Facades\DB;
use App\Models\PeopleAccountTransaction;
use Illuminate\Database\Migrations\Migration;

class CreateCureCycleTriggers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // Drop existing triggers if they exist
        DB::unprepared("DROP TRIGGER IF EXISTS after_cure_cycle_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_cure_cycle_update");
        DB::unprepared("DROP TRIGGER IF EXISTS after_cure_cycle_delete");

        $table = (new Cure())->getTable();

        // Create INSERT trigger
        DB::unprepared("
            CREATE TRIGGER after_cure_cycle_insert
            AFTER INSERT ON $table
            FOR EACH ROW
            BEGIN
            
                CALL InsertPeopleAccountTransaction(
                    NEW.id,
                    NEW.people_account_id,
                    NEW.money_account_id,
                    NEW.patient_id,
                    '" . TransactionType::PAYMENT . "',
                    '" . OperationType::CURE_CYLCE . "',
                    '" . PaymentType::PAID . "',
                    NEW.grand_total - New.paid,
                    NEW.description,
                    NEW.start_date
                );
            END;
        ");

        // Create UPDATE trigger
        DB::unprepared("
            CREATE TRIGGER after_cure_cycle_update
            AFTER UPDATE ON $table
            FOR EACH ROW
            BEGIN
               
                CALL UpdatePeopleAccountTransaction(
                    NEW.id,
                    NEW.people_account_id,
                    NEW.money_account_id,
                    NEW.patient_id,
                    '" . TransactionType::OPERATION . "',
                    '" . OperationType::CURE_CYLCE . "',
                    '" . PaymentType::PAID . "',
                    NEW.grand_total,
                    NEW.description,
                    NEW.start_date,
                    NEW.deleted_at
                );
            END;
        ");

        // Create DELETE trigger
        DB::unprepared("
            CREATE TRIGGER after_cure_cycle_delete
            AFTER DELETE ON $table
            FOR EACH ROW
            BEGIN
                CALL DeletePeopleAccountTransaction(OLD.id,'" . OperationType::CURE_CYLCE . "');
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop triggers
        DB::unprepared("DROP TRIGGER IF EXISTS after_cure_cycle_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_cure_cycle_update");
        DB::unprepared("DROP TRIGGER IF EXISTS after_cure_cycle_delete");
    }
}
