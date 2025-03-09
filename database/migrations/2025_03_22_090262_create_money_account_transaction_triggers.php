<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateMoneyAccountTransactionTriggers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // Drop existing triggers if they exist
        DB::unprepared("DROP TRIGGER IF EXISTS after_money_account_transaction_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_money_account_transaction_update");
        DB::unprepared("DROP TRIGGER IF EXISTS after_money_account_transaction_delete");

        // Create INSERT trigger
        DB::unprepared("
            CREATE TRIGGER after_money_account_transaction_insert
            AFTER INSERT ON money_account_transactions
            FOR EACH ROW
            BEGIN
                CALL UpdateMoneyAccountBalance(NEW.money_account_id);
            END;
        ");

        // Create UPDATE trigger
        DB::unprepared("
            CREATE TRIGGER after_money_account_transaction_update
            AFTER UPDATE ON money_account_transactions
            FOR EACH ROW
            BEGIN
                CALL UpdateMoneyAccountBalance(OLD.money_account_id);
                CALL UpdateMoneyAccountBalance(NEW.money_account_id);
            END;
        ");

        // Create DELETE trigger
        DB::unprepared("
            CREATE TRIGGER after_money_account_transaction_delete
            AFTER DELETE ON money_account_transactions
            FOR EACH ROW
            BEGIN
                CALL UpdateMoneyAccountBalance(OLD.money_account_id);
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop triggers
        DB::unprepared("DROP TRIGGER IF EXISTS after_money_account_transaction_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_money_account_transaction_update");
        DB::unprepared("DROP TRIGGER IF EXISTS after_money_account_transaction_delete");

    }
}
