<?php


use App\Enums\PaymentType;
use App\Models\MoneyAccount;
use App\Models\CreditAccount;
use App\Models\PeopleAccount;
use Illuminate\Support\Facades\DB;
use App\Models\MoneyAccountTransaction;
use App\Models\CreditAccountTransaction;
use App\Models\PeopleAccountTransaction;
use Illuminate\Database\Migrations\Migration;

class CreateProcedures extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop existing stored procedure if it exists
        DB::unprepared("DROP PROCEDURE IF EXISTS InsertMoneyAccountTransaction");
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateMoneyAccountTransaction");
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteMoneyAccountTransaction");

        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateMoneyAccountBalance");
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdatePeopleAccountBalance");


        $moneyAccountTransactionTable = (new MoneyAccountTransaction())->getTable();
        $moneyAccountTable = (new MoneyAccount())->getTable();
        $peopleAccountTransactionTable = (new PeopleAccountTransaction())->getTable();
        $peopleAccountTable = (new PeopleAccount())->getTable();


        // Create stored procedure to update money account balance
        DB::unprepared("
            CREATE PROCEDURE UpdateMoneyAccountBalance(IN account_id INT)
            BEGIN
                DECLARE received_total DECIMAL(15,2) DEFAULT 0;
                DECLARE paid_total DECIMAL(15,2) DEFAULT 0;
                DECLARE new_balance DECIMAL(15,2);

                SELECT
                    COALESCE(SUM(CASE WHEN " . MoneyAccountTransaction::COLUMN_PAYMENT_TYPE . " = '" . PaymentType::RECEIVED . "' THEN " . PeopleAccountTransaction::COLUMN_AMOUNT . " ELSE 0 END), 0),
                    COALESCE(SUM(CASE WHEN " . MoneyAccountTransaction::COLUMN_PAYMENT_TYPE . " = '" . PaymentType::PAID . "' THEN " . PeopleAccountTransaction::COLUMN_AMOUNT . " ELSE 0 END), 0)
                INTO received_total, paid_total
                FROM $moneyAccountTransactionTable
                WHERE " . MoneyAccountTransaction::COLUMN_MONEY_ACCOUNT_ID . " = account_id AND deleted_at IS NULL;

                -- Calculate new balance
                SET new_balance = received_total - paid_total;

                -- Update money account balance
                UPDATE $moneyAccountTable SET " . MoneyAccount::COLUMN_BALANCE . " = new_balance WHERE id = account_id;
            END;
        ");

        // Create stored procedure to update people account balance
        DB::unprepared("
            CREATE PROCEDURE UpdatePeopleAccountBalance(IN account_id INT)
            BEGIN
                DECLARE received_total DECIMAL(15,2) DEFAULT 0;
                DECLARE paid_total DECIMAL(15,2) DEFAULT 0;
                DECLARE new_balance DECIMAL(15,2);

                -- Optimize by using a single query with conditional aggregation
                SELECT
                    COALESCE(SUM(CASE WHEN " . PeopleAccountTransaction::COLUMN_PAYMENT_TYPE . " = '" . PaymentType::RECEIVED . "' THEN " . PeopleAccountTransaction::COLUMN_AMOUNT . " ELSE 0 END), 0),
                    COALESCE(SUM(CASE WHEN " . PeopleAccountTransaction::COLUMN_PAYMENT_TYPE . " = '" . PaymentType::PAID . "' THEN " . PeopleAccountTransaction::COLUMN_AMOUNT . " ELSE 0 END), 0)
                INTO received_total, paid_total
                FROM $peopleAccountTransactionTable
                WHERE " . PeopleAccountTransaction::COLUMN_PEOPLE_ACCOUNT_ID . " = account_id
                AND deleted_at IS NULL;

                -- Calculate new balance
                SET new_balance = paid_total - received_total;

                -- Update money account balance
                UPDATE $peopleAccountTable SET " . PeopleAccount::COLUMN_ACCOUNT_BALANCE. " = new_balance
                WHERE " . PeopleAccount::COLUMN_ID. " = account_id;
            END;
        ");

     
        // INSERT MONEY AMMOUNT TRANSACTION
        DB::unprepared("
            CREATE PROCEDURE InsertMoneyAccountTransaction(
                IN p_parent_record_id INT,
                IN p_money_account_id INT,
                IN p_people_id INT,
                IN p_operation_type VARCHAR(255),
                IN p_payment_type VARCHAR(10),
                IN p_amount DECIMAL(20,2),
                IN p_description TEXT,
                IN p_date DATE
            )
            BEGIN
                -- Insert the money transaction for the sender (debit)
                INSERT INTO $moneyAccountTransactionTable (
                    " . MoneyAccountTransaction::COLUMN_PARENT_RECORD_ID . ",
                    " . MoneyAccountTransaction::COLUMN_MONEY_ACCOUNT_ID . ",
                    " . MoneyAccountTransaction::COLUMN_PEOPLE_ID . ",
                    " . MoneyAccountTransaction::COLUMN_OPERATION_TYPE . ",
                    " . MoneyAccountTransaction::COLUMN_PAYMENT_TYPE . ",
                    " . MoneyAccountTransaction::COLUMN_AMOUNT . ",
                    " . MoneyAccountTransaction::COLUMN_DESCRIPTION . ",
                    " . MoneyAccountTransaction::COLUMN_DATE . ",
                    created_at,
                    updated_at
                )
                VALUES (p_parent_record_id,p_money_account_id,p_people_id, p_operation_type,p_payment_type,p_amount,
                    p_description, p_date, NOW(), NOW()
                );
            END;
        ");

        // UPDATE MONEY ACCOUNT TRANSACTION
        DB::unprepared("
            CREATE PROCEDURE UpdateMoneyAccountTransaction(
                IN p_parent_record_id INT,
                IN p_money_account_id INT,
                IN p_people_id INT,
                IN p_operation_type VARCHAR(255),
                IN p_payment_type VARCHAR(20),
                IN p_amount DECIMAL(20,2),
                IN p_description TEXT,
                IN p_date DATETIME,
                IN p_deleted_at DATETIME
            )
            BEGIN

                UPDATE $moneyAccountTransactionTable SET
                    " . MoneyAccountTransaction::COLUMN_MONEY_ACCOUNT_ID . " = p_money_account_id,
                    " . MoneyAccountTransaction::COLUMN_PEOPLE_ID . " = p_people_id,
                    " . MoneyAccountTransaction::COLUMN_OPERATION_TYPE . " = p_operation_type,
                    " . MoneyAccountTransaction::COLUMN_PAYMENT_TYPE . " = p_payment_type,
                    " . MoneyAccountTransaction::COLUMN_AMOUNT . " = p_amount,
                    " . MoneyAccountTransaction::COLUMN_DESCRIPTION . " = p_description,
                    " . MoneyAccountTransaction::COLUMN_DATE . " = p_date,
                    updated_at = NOW(),
                    deleted_at = p_deleted_at
                WHERE " . MoneyAccountTransaction::COLUMN_PARENT_RECORD_ID . " = p_parent_record_id
                AND " . MoneyAccountTransaction::COLUMN_OPERATION_TYPE . " = p_operation_type;

            END;
        ");

        // DELETE MONEY ACCOUNT TRANSACTION
        DB::unprepared("
            CREATE PROCEDURE DeleteMoneyAccountTransaction(IN p_parent_record_id INT, IN p_operation_type VARCHAR(20))
            BEGIN
                UPDATE $moneyAccountTransactionTable SET deleted_at = NOW()
                WHERE " . MoneyAccountTransaction::COLUMN_PARENT_RECORD_ID . " = p_parent_record_id
                AND " . MoneyAccountTransaction::COLUMN_OPERATION_TYPE . " = p_operation_type;
            END;
        ");


        // INSERT PEOPLE ACCOUNT TRANSACTION
        DB::unprepared("
            CREATE PROCEDURE InsertPeopleAccountTransaction(
                IN p_parent_record_id INT,
                IN p_people_acc_id INT,
                IN p_money_account_id INT,
                IN p_people_id INT,
                IN p_transaction_type VARCHAR(255),
                IN p_operation_type VARCHAR(255),
                IN p_payment_type VARCHAR(10),
                IN p_amount DECIMAL(20,2),
                IN p_description TEXT,
                IN p_date DATE
            )
            BEGIN
        
                INSERT INTO $peopleAccountTransactionTable (
                    " . PeopleAccountTransaction::COLUMN_PARENT_RECORD_ID . ",
                    " . PeopleAccountTransaction::COLUMN_PEOPLE_ID . ",
                    " . PeopleAccountTransaction::COLUMN_PEOPLE_ACCOUNT_ID . ",
                    " . PeopleAccountTransaction::COLUMN_MONEY_ACCOUNT_ID . ",
                    " . PeopleAccountTransaction::COLUMN_TRANSACTION_TYPE . ",
                    " . PeopleAccountTransaction::COLUMN_OPERATION_TYPE . ",
                    " . PeopleAccountTransaction::COLUMN_PAYMENT_TYPE . ",
                    " . PeopleAccountTransaction::COLUMN_AMOUNT . ",
                    " . PeopleAccountTransaction::COLUMN_DESCRIPTION . ",
                    " . PeopleAccountTransaction::COLUMN_DATE . ",
                    created_at
                ) VALUES (
                    p_parent_record_id,p_people_id, p_people_acc_id, p_money_account_id, p_transaction_type, p_operation_type,
                    p_payment_type, p_amount, p_description, p_date, NOW()
                );
            END;
        ");

        // Update PEOPLE ACCOUNT TRANSACTION
        DB::unprepared("
            CREATE PROCEDURE UpdatePeopleAccountTransaction(
                IN p_parent_record_id INT,
                IN p_people_acc_id INT,
                IN p_money_account_id INT,
                IN p_people_id INT,
                IN p_transaction_type VARCHAR(255),
                IN p_operation_type VARCHAR(255),
                IN p_payment_type VARCHAR(10),
                IN p_amount DECIMAL(20,2),
                IN p_description TEXT,
                IN p_date DATETIME,
                IN p_deleted_at DATETIME
            )
            BEGIN
                UPDATE $peopleAccountTransactionTable SET
                    " . PeopleAccountTransaction::COLUMN_PEOPLE_ID . " = p_people_id,
                    " . PeopleAccountTransaction::COLUMN_PEOPLE_ACCOUNT_ID . " = p_people_acc_id,
                    " . PeopleAccountTransaction::COLUMN_MONEY_ACCOUNT_ID . " = p_money_account_id,
                    " . PeopleAccountTransaction::COLUMN_TRANSACTION_TYPE . " = p_transaction_type,
                    " . PeopleAccountTransaction::COLUMN_OPERATION_TYPE . " = p_operation_type,
                    " . PeopleAccountTransaction::COLUMN_PAYMENT_TYPE . " = p_payment_type,
                    " . PeopleAccountTransaction::COLUMN_AMOUNT . " = p_amount,
                    " . PeopleAccountTransaction::COLUMN_DESCRIPTION . " = p_description,
                    " . PeopleAccountTransaction::COLUMN_DATE . " = p_date,
                    deleted_at = p_deleted_at,
                    updated_at = NOW()
                WHERE " . PeopleAccountTransaction::COLUMN_PARENT_RECORD_ID . " = p_parent_record_id
                AND " . PeopleAccountTransaction::COLUMN_OPERATION_TYPE . " = p_operation_type;
            END;
        ");

        // Delete PEOPLE ACCOUNT TRANSACTION
        DB::unprepared("
            CREATE PROCEDURE DeletePeopleAccountTransaction(IN p_parent_record_id INT, IN p_operation_type VARCHAR(255))
            BEGIN
                UPDATE $peopleAccountTransactionTable SET deleted_at = NOW()
                WHERE " . PeopleAccountTransaction::COLUMN_PARENT_RECORD_ID . " = p_parent_record_id
                AND " . PeopleAccountTransaction::COLUMN_OPERATION_TYPE . " = p_operation_type;
            END;
        ");
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop existing stored procedure if it exists
        DB::unprepared("DROP PROCEDURE IF EXISTS InsertMoneyAccountTransaction");
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateMoneyAccountTransaction");
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteMoneyAccountTransaction");

        DB::unprepared("DROP PROCEDURE IF EXISTS InsertPeopleAccountTransaction");
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdatePeopleAccountTransaction");
        DB::unprepared("DROP PROCEDURE IF EXISTS DeletePeopleAccountTransaction");


        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateMoneyAccountBalance");
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdatePeopleAccountBalance");     

    }
}
