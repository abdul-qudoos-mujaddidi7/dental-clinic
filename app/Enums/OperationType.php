<?php

namespace App\Enums;

class OperationType
{


    // Expense Section
    const EXPENSE_PAYMENT = 'expense_payment'; // Only Money Account Will change // Transaction Type = Payment

    // Payment Section
    const MONEY_PAID = 'money_paid';
    const MONEY_RECEIVED = 'money_received';

    // Salary Section
    const PAYSLIP = 'paylip'; // Only People Account Statement Will change
    const PAY_SALARY = 'salary'; // Money Account and Stakeholder Account Will Change.


    const MONEY_ACCOUNT_TRANSFER = "money_account_transfer";

    public static function getValues()
    {
        return [
            self::PAYSLIP,
            self::PAY_SALARY,
            self::MONEY_ACCOUNT_TRANSFER,
        ];
    }

}
