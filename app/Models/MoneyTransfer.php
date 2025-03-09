<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoneyTransfer extends Model
{

    use SoftDeletes;

    public const COLUMN_ID = 'id';
    public const COLUMN_FROM_ACCOUNT_ID = 'from_account_id';
    public const COLUMN_TO_ACCOUNT_ID = 'to_account_id';
    public const COLUMN_AMOUNT = 'amount';
    public const COLUMN_DESCRIPTION = 'description';
    public const COLUMN_DATE = "date";



    protected $table = 'money_transfers';

    protected $fillable = [
        self::COLUMN_FROM_ACCOUNT_ID,
        self::COLUMN_TO_ACCOUNT_ID,
        self::COLUMN_AMOUNT,
        self::COLUMN_DESCRIPTION,
        self::COLUMN_DATE
    ];

    protected $casts = [
        self::COLUMN_ID => 'integer',
        self::COLUMN_FROM_ACCOUNT_ID => 'integer',
        self::COLUMN_TO_ACCOUNT_ID => 'integer',
        self::COLUMN_AMOUNT => 'float',
        self::COLUMN_DESCRIPTION => 'string',
        self::COLUMN_DATE => 'datetime'
    ];

    protected $dates = ['deleted_at'];

    public function fromAccount()
    {
        return $this->belongsTo(MoneyAccount::class, self::COLUMN_FROM_ACCOUNT_ID, 'id');
    }

    public function toAccount()
    {
        return $this->belongsTo(MoneyAccount::class, self::COLUMN_TO_ACCOUNT_ID, 'id');
    }

}
