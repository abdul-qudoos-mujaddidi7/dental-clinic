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

    public static function getPaymentType($operationType)
    {   
        switch ($operationType) {

            case OperationType::PAY_SALARY:
                return self::PAID;
            case OperationType::PAYSLIP:
                return self::RECEIVED;
            default:
                throw new InvalidArgumentException("Invalid operation type: $operationType");
        }
    }

}
