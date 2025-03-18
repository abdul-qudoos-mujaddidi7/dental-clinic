<?php

use App\Enums\PaymentType;
use App\Enums\TransferType;
use App\Enums\OperationType;
use App\Enums\TransactionType;
use App\Models\MoneyTransfer;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyTransferTriggers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        $transferTable = (new MoneyTransfer())->getTable();

        // Create the insert trigger
        DB::unprepared("
            CREATE TRIGGER after_money_transfer_insert
            AFTER INSERT ON $transferTable
            FOR EACH ROW
            BEGIN

                CALL InsertMoneyAccountTransaction(
                    NEW.". MoneyTransfer::COLUMN_ID. ",
                    NEW.". MoneyTransfer::COLUMN_FROM_ACCOUNT_ID. ",null,
                    '". OperationType::MONEY_ACCOUNT_TRANSFER."',
                    '". PaymentType::PAID."',
                    NEW.". MoneyTransfer::COLUMN_AMOUNT. ",
                    NEW.". MoneyTransfer::COLUMN_DESCRIPTION. ",
                    NEW.". MoneyTransfer::COLUMN_DATE. "
                );

                CALL InsertMoneyAccountTransaction(
                    NEW.". MoneyTransfer::COLUMN_ID. ",
                    NEW.". MoneyTransfer::COLUMN_TO_ACCOUNT_ID. ",null,
                    '". OperationType::MONEY_ACCOUNT_TRANSFER."',
                    '". PaymentType::RECEIVED."',
                    NEW.". MoneyTransfer::COLUMN_AMOUNT. ",
                    NEW.". MoneyTransfer::COLUMN_DESCRIPTION. ",
                    NEW.". MoneyTransfer::COLUMN_DATE. "
                );
            END;
        ");

        // Create the update trigger
        DB::unprepared("
            CREATE TRIGGER after_money_transfer_update
            AFTER UPDATE ON $transferTable
            FOR EACH ROW
            BEGIN

                CALL DeleteMoneyAccountTransaction(OLD.". MoneyTransfer::COLUMN_ID. ",'". OperationType::MONEY_ACCOUNT_TRANSFER."');

                IF NEW.deleted_at IS NULL THEN
                    CALL InsertMoneyAccountTransaction(
                        NEW.". MoneyTransfer::COLUMN_ID. ",
                        NEW.". MoneyTransfer::COLUMN_FROM_ACCOUNT_ID. ",
                        '". OperationType::MONEY_ACCOUNT_TRANSFER."',
                        '". PaymentType::PAID."',
                        NEW.". MoneyTransfer::COLUMN_AMOUNT. ",
                        NEW.". MoneyTransfer::COLUMN_DESCRIPTION. ",
                        NEW.". MoneyTransfer::COLUMN_DATE. "
                    );

                    CALL InsertMoneyAccountTransaction(
                        NEW.". MoneyTransfer::COLUMN_ID. ",
                        NEW.". MoneyTransfer::COLUMN_TO_ACCOUNT_ID. ",
                        '". OperationType::MONEY_ACCOUNT_TRANSFER."',
                        '". PaymentType::RECEIVED."',
                        NEW.". MoneyTransfer::COLUMN_AMOUNT. ",
                        NEW.". MoneyTransfer::COLUMN_DESCRIPTION. ",
                        NEW.". MoneyTransfer::COLUMN_DATE. "
                    );
                END IF;
            END;
        ");

        // Create the delete trigger
        DB::unprepared("
            CREATE TRIGGER before_money_transfer_delete
            BEFORE DELETE ON $transferTable
            FOR EACH ROW
            BEGIN
                CALL DeleteMoneyAccountTransaction(OLD.". MoneyTransfer::COLUMN_ID. ",'". OperationType::MONEY_ACCOUNT_TRANSFER."');
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop triggers
        DB::unprepared("DROP TRIGGER IF EXISTS after_money_transfer_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_money_transfer_update");
        DB::unprepared("DROP TRIGGER IF EXISTS before_money_transfer_delete");

    }
}
