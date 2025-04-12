<?php


use App\Models\Expense;
use App\Enums\PaymentType;
use App\Enums\OperationType;
use App\Enums\TransactionType;
use App\Models\OutboundLab;
use Illuminate\Support\Facades\DB;
use App\Models\PeopleAccountTransaction;
use Illuminate\Database\Migrations\Migration;

class CreateOutBoundLabTriggers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // Drop existing triggers if they exist
        DB::unprepared("DROP TRIGGER IF EXISTS after_out_bound_lab_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_out_bound_lab_update");
        DB::unprepared("DROP TRIGGER IF EXISTS after_out_bound_lab_delete");

        $table = (new OutboundLab())->getTable();

        // Create INSERT trigger
        DB::unprepared("
        CREATE TRIGGER after_out_bound_lab_insert
        AFTER INSERT ON $table
        FOR EACH ROW
        BEGIN
            CALL InsertPeopleAccountTransaction(
                NEW.id,
                NEW.people_account_id,
                NEW.money_account_id,
                NEW.supplier_id,
                '" . TransactionType::OPERATION . "',
                '" . OperationType::OUT_BOUND_LAB . "',
                '" . PaymentType::RECEIVED . "',
                NEW.grand_total,
                NEW.description,
                NEW.issue_at
            );

            -- Patient payment (editable record)
        IF NEW.paid > 0 THEN
            CALL InsertPeopleAccountTransaction(
                NEW.id,
                NEW.people_account_id,
                NEW.money_account_id,
                NEW.supplier_id,
                '" . TransactionType::PAYMENT . "', 
                '" . OperationType::OUT_BOUND_LAB . "',
                '" . PaymentType::PAID . "',
                NEW.paid,
                NEW.description,
                NEW.issue_at
            );
             END IF;
             END;
    ");

        // Create UPDATE trigger
        DB::unprepared("
            CREATE TRIGGER after_out_bound_lab_update
            AFTER UPDATE ON $table
            FOR EACH ROW
            BEGIN
                CALL UpdatePeopleAccountTransaction(
                    NEW.id,
                    NEW.people_account_id,
                    NEW.money_account_id,
                    NEW.supplier_id,
                    '" . TransactionType::OPERATION . "',
                    '" . OperationType::OUT_BOUND_LAB . "',
                    '" . PaymentType::PAID . "',
                    NEW.grand_total,
                    NEW.description,
                    NEW.issue_at,
                    NEW.deleted_at
                );
            END;
        ");


        // Create DELETE trigger
        DB::unprepared("
            CREATE TRIGGER after_out_bound_lab_delete
            AFTER DELETE ON $table
            FOR EACH ROW
            BEGIN
                CALL DeleteMoneyAccountTransaction(OLD.id,'" . OperationType::EXPENSE . "');
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop triggers
        DB::unprepared("DROP TRIGGER IF EXISTS after_out_bound_lab_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_out_bound_lab_update");
        DB::unprepared("DROP TRIGGER IF EXISTS after_out_bound_lab_delete");
    }
}
