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
            case OperationType::PAY_SALARY:
                return self::PAYMENT;
            case OperationType::PAYSLIP:
                return self::OPERATION;
            default:
                throw new InvalidArgumentException("Invalid operation type: $operationType");
        }
    }

}
