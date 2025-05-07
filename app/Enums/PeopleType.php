<?php

namespace App\Enums;

class PeopleType
{
    const CUSTOMER   = 'Customer';
    const AGENT = 'Agent';
    const EMPLOYEE = 'Employee';
    const OWNER = 'Owner';
    const SUPPLIER = 'Supplier';


    public static function getValues()
    {
        return [
            self::CUSTOMER,
            self::AGENT,
            self::EMPLOYEE,
            self::OWNER,
            self::SUPPLIER
        ];
    }

}
