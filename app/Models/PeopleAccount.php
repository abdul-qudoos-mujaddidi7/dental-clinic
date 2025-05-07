<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeopleAccount extends Model
{

    public const COLUMN_ID = 'id';
    public const COLUMN_NAME = 'name';
    public const COLUMN_PEOPLE_ID = 'people_id';
    public const COLUMN_ACCOUNT_BALANCE = 'balance';

    protected $table = 'people_accounts';

    protected $fillable = [
        self::COLUMN_PEOPLE_ID,
        self::COLUMN_NAME,
        self::COLUMN_ACCOUNT_BALANCE,
    ];

    protected $casts = [
        self::COLUMN_ID => 'integer',
        self::COLUMN_PEOPLE_ID => 'integer',
        self::COLUMN_NAME => 'string',
        self::COLUMN_ACCOUNT_BALANCE => 'double',
    ];

    public function people()
    {
        return $this->belongsTo(People::class, self::COLUMN_PEOPLE_ID);
    }


}
