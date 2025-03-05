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
}
