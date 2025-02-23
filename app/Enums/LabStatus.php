<?php
namespace App\Enums;

enum LabStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';

    public static function getValues(): array
    {
        return [
            self::PENDING->value,  // Get the string value of the enum case
            self::COMPLETED->value,
            self::CANCELED->value,
        ];
    }
}

