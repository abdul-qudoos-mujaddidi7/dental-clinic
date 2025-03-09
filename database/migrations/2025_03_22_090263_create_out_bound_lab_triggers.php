<?php


use App\Models\Expense;
use App\Enums\PaymentType;
use App\Enums\OperationType;
use App\Enums\TransactionType;
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

        $table = (new Expense())->getTable();

        // Create INSERT trigger
        // DB::unprepared("
        //     CREATE TRIGGER after_out_bound_lab_insert
        //     AFTER INSERT ON $table
        //     FOR EACH ROW
        //     BEGIN
        //         CALL InsertMoneyAccountTransaction(
        //             NEW." . Expense::COLUMN_ID . ",
        //             NEW." . Expense::COLUMN_MONEY_ACCOUNT_ID . ",
        //             null,
        //             '" . OperationType::EXPENSE . "',
        //             '" . PaymentType::PAID . "',
        //             NEW." . Expense::COLUMN_AMOUNT . ",
        //             NEW." . Expense::COLUMN_DESCRIPTION . ",
        //             NEW." . Expense::COLUMN_DATE . "
        //         );
        //     END;
        // ");

        // Create UPDATE trigger
        // DB::unprepared("
        //     CREATE TRIGGER after_out_bound_lab_update
        //     AFTER UPDATE ON $table
        //     FOR EACH ROW
        //     BEGIN
        //         CALL UpdateMoneyAccountTransaction(
        //             NEW." . Expense::COLUMN_ID . ",
        //             NEW." . Expense::COLUMN_MONEY_ACCOUNT_ID . ",
        //             null,
        //             '" . OperationType::EXPENSE . "',
        //             '" . PaymentType::PAID . "',
        //             NEW." . Expense::COLUMN_AMOUNT . ",
        //             NEW." . Expense::COLUMN_DESCRIPTION . ",
        //             NEW." . Expense::COLUMN_DATE . ",
        //             NEW.deleted_at
        //         );
        //     END;
        // ");

        // Create DELETE trigger
        // DB::unprepared("
        //     CREATE TRIGGER after_out_bound_lab_delete
        //     AFTER DELETE ON $table
        //     FOR EACH ROW
        //     BEGIN
        //         CALL DeleteMoneyAccountTransaction(OLD.id,'" . OperationType::EXPENSE . "');
        //     END;
        // ");
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
