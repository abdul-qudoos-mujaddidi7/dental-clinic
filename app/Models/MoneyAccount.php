<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoneyAccount extends Model
{
    use SoftDeletes;

    public const COLUMN_ID = 'id';
    public const COLUMN_NAME = 'name';
    public const COLUMN_BALANCE = 'balance';
  

    protected $table = 'money_accounts';

    protected $fillable = [
        self::COLUMN_NAME,
        self::COLUMN_BALANCE,
    ];

    protected $casts = [
        self::COLUMN_ID => 'integer',
        self::COLUMN_NAME => 'string',
        self::COLUMN_BALANCE => 'double',
  
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function transactions()
    {
        return $this->hasMany(MoneyAccountTransaction::class, MoneyAccountTransaction::COLUMN_MONEY_ACCOUNT_ID, self::COLUMN_ID);
    }

}
