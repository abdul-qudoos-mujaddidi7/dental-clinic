<?php

namespace App\Enums;

class TransactionType
{
    const PAYMENT   = 'payment';
    const OPERATION = 'operation'; // only "operation" is not editable and deletable
    const TRANSFER = 'transfer';

    public static function getValues()
    {
        return [
            self::PAYMENT,
            self::OPERATION,
            self::TRANSFER
        ];
    }

  
    public static function getType($operationType)
    {
        switch ($operationType) {
            case OperationType::MONEY_PAID:
                return self::PAYMENT;
            case OperationType::MONEY_RECEIVED:
                return self::PAYMENT;
            case OperationType::PAYSLIP:
                return self::OPERATION;
            case OperationType::PAY_SALARY:
                return self::PAYMENT;
            case OperationType::MONEY_ACCOUNT_TRANSFER:
                return self::PAYMENT;
            case OperationType::EXPENSE:
                return self::PAYMENT;
            case OperationType::INVOICE_EXPENSE:
                return self::OPERATION;
            case OperationType::INVOICE_EXPENSE_PAYMENT:
                return self::PAYMENT;
            case OperationType::OUT_BOUND_LAB:
                return self::OPERATION;
            case OperationType::IN_BOUND_LAB:
                return self::OPERATION;
            case OperationType::CURE_CYLCE:
                return self::OPERATION;
            case OperationType::OUT_BOUND_LAB_PAYMENT:
                return self::PAYMENT;
            case OperationType::IN_BOUND_LAB_PAYMENT:
                return self::PAYMENT;
            case OperationType::CURE_CYLCE_PAYMENT:
                return self::PAYMENT;
             
            default:
                throw new InvalidArgumentException("Invalid operation type: $operationType");
        }
    }

}
