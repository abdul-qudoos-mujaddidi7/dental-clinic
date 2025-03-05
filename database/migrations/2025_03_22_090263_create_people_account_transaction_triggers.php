<?php


use App\Enums\TransactionType;
use Illuminate\Support\Facades\DB;
use App\Models\PeopleAccountTransaction;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleAccountTransactionTriggers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // Drop existing triggers if they exist
        DB::unprepared("DROP TRIGGER IF EXISTS after_people_account_transaction_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_people_account_transaction_update");
        DB::unprepared("DROP TRIGGER IF EXISTS after_people_account_transaction_delete");

            // Create INSERT trigger
            DB::unprepared("
                CREATE TRIGGER after_people_account_transaction_insert
                AFTER INSERT ON " . (new PeopleAccountTransaction())->getTable(). "
                FOR EACH ROW
                BEGIN
                    CALL UpdatePeopleAccountBalance(NEW.people_account_id);

                    IF NEW." . PeopleAccountTransaction::COLUMN_TRANSACTION_TYPE . " <> '" . TransactionType::OPERATION . "' THEN
                        CALL InsertMoneyAccountTransaction(
                            NEW." . PeopleAccountTransaction::COLUMN_ID . ",
                            NEW." . PeopleAccountTransaction::COLUMN_MONEY_ACCOUNT_ID . ",
                            NEW." . PeopleAccountTransaction::COLUMN_OPERATION_TYPE . ",
                            NEW." . PeopleAccountTransaction::COLUMN_PAYMENT_TYPE . ",
                            NEW." . PeopleAccountTransaction::COLUMN_AMOUNT . ",
                            NEW." . PeopleAccountTransaction::COLUMN_DESCRIPTION . ",
                            NEW." . PeopleAccountTransaction::COLUMN_DATE . "
                        );
                    END IF;
                END;
            ");

            // Create UPDATE trigger
            DB::unprepared("
                CREATE TRIGGER after_people_account_transaction_update
                AFTER UPDATE ON " . (new PeopleAccountTransaction())->getTable(). "
                FOR EACH ROW
                BEGIN
                    -- If the account ID changed, update both old and new account balances
                    IF OLD.people_account_id != NEW.people_account_id THEN
                        CALL UpdatePeopleAccountBalance(OLD.people_account_id);
                        CALL UpdatePeopleAccountBalance(NEW.people_account_id);
                    ELSE
                        CALL UpdatePeopleAccountBalance(NEW.people_account_id);
                    END IF;

                    IF NEW." . PeopleAccountTransaction::COLUMN_TRANSACTION_TYPE . " <> '" . TransactionType::OPERATION . "' THEN
                        CALL UpdateMoneyAccountTransaction(
                            NEW." . PeopleAccountTransaction::COLUMN_ID . ",
                            NEW." . PeopleAccountTransaction::COLUMN_MONEY_ACCOUNT_ID . ",
                            NEW." . PeopleAccountTransaction::COLUMN_OPERATION_TYPE . ",
                            NEW." . PeopleAccountTransaction::COLUMN_PAYMENT_TYPE . ",
                            NEW." . PeopleAccountTransaction::COLUMN_AMOUNT . ",
                            NEW." . PeopleAccountTransaction::COLUMN_DESCRIPTION . ",
                            NEW." . PeopleAccountTransaction::COLUMN_DATE . ",
                            NEW.deleted_at
                        );
                    END IF;
                END;
            ");

            // Create DELETE trigger
            DB::unprepared("
                CREATE TRIGGER after_people_account_transaction_delete
                AFTER DELETE ON " . (new PeopleAccountTransaction())->getTable(). "
                FOR EACH ROW
                BEGIN
                    CALL UpdatePeopleAccountBalance(OLD.people_account_id);

                    IF OLD." . PeopleAccountTransaction::COLUMN_TRANSACTION_TYPE . " <> '" . TransactionType::OPERATION . "' THEN
                        CALL DeleteMoneyAccountTransaction(OLD.id, OLD." . PeopleAccountTransaction::COLUMN_OPERATION_TYPE . ");
                    END IF;
                END;
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop triggers
        DB::unprepared("DROP TRIGGER IF EXISTS after_people_account_transaction_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_people_account_transaction_update");
        DB::unprepared("DROP TRIGGER IF EXISTS after_people_account_transaction_delete");
    }
}
