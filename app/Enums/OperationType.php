<?php

namespace App\Enums;

class OperationType
{

    // Payment Section
    const MONEY_PAID = 'money_paid';
    const MONEY_RECEIVED = 'money_received';

    // Salary Section
    const PAYSLIP = 'paylip'; // Only People Account Statement Will change
    const PAY_SALARY = 'salary'; // Money Account and Stakeholder Account Will Change.

    const MONEY_ACCOUNT_TRANSFER = "money_account_transfer";
    const MONEY_ACCOUNT_TRANSFER_FROM = "money_account_transfer_from";
    const MONEY_ACCOUNT_TRANSFER_TO = "money_account_transfer_to";

    const EXPENSE = 'expense';
    const INVOICE_EXPENSE = 'invoice_expense';
    const INVOICE_EXPENSE_PAYMENT = 'invoice_expense_payment';


    
    const OUT_BOUND_LAB = 'out_bound_lab';
    const IN_BOUND_LAB = 'in_bound_lab';
    const CURE_CYLCE = 'cure_cycle';

    const OUT_BOUND_LAB_PAYMENT = 'out_bound_lab_payment';
    const BILL_EXPENSE_PAYMENT = 'bill_expense_payment';
    const IN_BOUND_LAB_PAYMNET = 'in_bound_lab_payment';
    const CURE_CYLCE_PAYMENT = 'cure_cycle_payment';


    public static function getValues()
    {
        return [
            self::MONEY_PAID,
            self::MONEY_RECEIVED,
            self::PAYSLIP,
            self::PAY_SALARY,
            self::MONEY_ACCOUNT_TRANSFER,
            self::EXPENSE,
            self::INVOICE_EXPENSE,
            self::INVOICE_EXPENSE_PAYMENT,
            self::OUT_BOUND_LAB,
            self::IN_BOUND_LAB,
            self::CURE_CYLCE,
            self::OUT_BOUND_LAB_PAYMENT,
            self::IN_BOUND_LAB_PAYMNET,
            self::CURE_CYLCE_PAYMENT
        ];
    }

}
