<?php

namespace App\Enums;

class PaymentType
{
    const PAID   = 'paid';
    const RECEIVED = 'received';

    public static function getValues()
    {
        return [
            PaymentType::PAID,
            PaymentType::RECEIVED,
        ];
    }
      // self::MONEY_PAID,
    //         self::MONEY_RECEIVED,
    //         self::PAYSLIP,
    //         self::PAY_SALARY,
    //         self::MONEY_ACCOUNT_TRANSFER,
    //         self::EXPENSE,
    //         self::INVOICE_EXPENSE,
    //         self::INVOICE_EXPENSE_PAYMENT


    public static function getPaymentType($operationType)
    {   
        switch ($operationType) {

            case OperationType::MONEY_PAID:
                return self::PAID;
            case OperationType::MONEY_RECEIVED:
                return self::RECEIVED;
            case OperationType::PAY_SALARY:
                return self::PAID;
            case OperationType::PAYSLIP:
                return self::RECEIVED;

            case OperationType::MONEY_ACCOUNT_TRANSFER_FROM:
                return self::PAID;
            case OperationType::MONEY_ACCOUNT_TRANSFER_TO:
                return self::RECEIVED;
            case OperationType::EXPENSE:
                return self::PAID;
            case OperationType::INVOICE_EXPENSE:
                return self::RECEIVED;

            case OperationType::INVOICE_EXPENSE_PAYMENT:
                return self::PAID;
            case OperationType::OUT_BOUND_LAB:
                return self::RECEIVED;
            case OperationType::IN_BOUND_LAB:
                return self::PAID;
            case OperationType::CURE_CYLCE:
                return self::PAID;
            case OperationType::OUT_BOUND_LAB_PAYMENT:
                return self::PAID;
            case OperationType::IN_BOUND_LAB_PAYMENT:
                return self::RECEIVED;
            case OperationType::CURE_CYLCE_PAYMENT:
                return self::RECEIVED;
            case OperationType::BILL_EXPENSE_PAYMENT:
                return self::PAID;    
            default:
                throw new InvalidArgumentException("Invalid operation type: $operationType");
        }
    }

}
