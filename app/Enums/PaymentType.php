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

            case OperationType::PURCHASE:
                return PaymentType::RECEIVED;
            case OperationType::PURCHASE_PAYMENT:
                return PaymentType::PAID;
            default:
                throw new InvalidArgumentException("Invalid operation type: $operationType");
        }
    }

}
