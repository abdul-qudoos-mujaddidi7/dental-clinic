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
            -- Service cost (non-editable system record)
            CALL InsertPeopleAccountTransaction(
                NEW.id,
                NEW.people_account_id,
                NEW.money_account_id,
                NEW.patient_id,
                '" . TransactionType::OPERATION . "', 
                '" . OperationType::CURE_CYLCE . "',
                '" . PaymentType::PAID . "',
                NEW.grand_total,
                NEW.description,
                NEW.start_date
            );
    
            -- Patient payment (editable record)
            IF NEW.paid > 0 THEN
                CALL InsertPeopleAccountTransaction(
                    NEW.id,
                    NEW.people_account_id,
                    NEW.money_account_id,
                    NEW.patient_id,
                    '" . TransactionType::PAYMENT . "', 
                    '" . OperationType::CURE_CYLCE_PAYMENT . "',
                    '" . PaymentType::RECEIVED . "',
                    NEW.paid,
                    NEW.description,
                    NEW.start_date
                );
            END IF;
        END;
    ");

        // Create UPDATE trigger
       // Create UPDATE trigger
DB::unprepared("
    CREATE TRIGGER after_cure_cycle_update
    AFTER UPDATE ON $table
    FOR EACH ROW
    BEGIN
        -- Update the service cost (operation) transaction
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
        
        -- Handle payment transactions
        IF NEW.paid != OLD.paid OR NEW.money_account_id != OLD.money_account_id THEN
            -- Delete old payment transaction if paid amount changed to zero
            IF NEW.paid = 0 THEN
                CALL DeletePeopleAccountTransaction(NEW.id, '" . OperationType::CURE_CYLCE_PAYMENT . "');
            
            -- Update existing payment transaction if paid amount changed
            ELSEIF OLD.paid > 0 THEN
                CALL UpdatePeopleAccountTransaction(
                    NEW.id,
                    NEW.people_account_id,
                    NEW.money_account_id,
                    NEW.patient_id,
                    '" . TransactionType::PAYMENT . "',
                    '" . OperationType::CURE_CYLCE_PAYMENT . "',
                    '" . PaymentType::RECEIVED . "',
                    NEW.paid,
                    NEW.description,
                    NEW.start_date,
                    NEW.deleted_at
                );
            
            -- Insert new payment transaction if paid amount changed from zero to positive
            ELSEIF NEW.paid > 0 THEN
                CALL InsertPeopleAccountTransaction(
                    NEW.id,
                    NEW.people_account_id,
                    NEW.money_account_id,
                    NEW.patient_id,
                    '" . TransactionType::PAYMENT . "', 
                    '" . OperationType::CURE_CYLCE_PAYMENT . "',
                    '" . PaymentType::RECEIVED . "',
                    NEW.paid,
                    NEW.description,
                    NEW.start_date
                );
            END IF;
        END IF;
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


// ✅ grand_total → payment_type = 'paid'
// Because the clinic is giving service (like giving a loan).

// Patient hasn’t paid yet, so the clinic “paid” on behalf of the patient (gave service now, payment comes later
// ✅ paid → payment_type = 'receive'
// Because the clinic is receiving money from the patient.

// This creates a credit in the patient’s account.

// Used when the patient actually makes a payment.


// Final Summary
// Field	    TransactionType	 payment_type	Meaning (Clinic Side)
// grand_total	Debit	         'paid'	        Clinic gave service → patient owes
// paid	        Credit	         'receive'       Clinic received payment from patient