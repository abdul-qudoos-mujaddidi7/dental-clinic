<?php

namespace App\Models;

use App\Services\WhatsappService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeopleAccountTransaction extends Model
{

    use SoftDeletes;

    public const COLUMN_ID = 'id';
    public const COLUMN_PARENT_RECORD_ID = 'parent_record_id';
    public const COLUMN_PEOPLE_ID = 'people_id';
    public const COLUMN_PEOPLE_ACCOUNT_ID = 'people_account_id';
    public const COLUMN_MONEY_ACCOUNT_ID = 'money_account_id';
    public const COLUMN_TRANSACTION_TYPE = 'transaction_type';
    public const COLUMN_OPERATION_TYPE = 'operation_type';
    public const COLUMN_PAYMENT_TYPE = 'payment_type';
    public const COLUMN_AMOUNT = 'amount';
    public const COLUMN_DESCRIPTION = 'description';
    public const COLUMN_DATE = 'date';
    public const COLUMN_BALANCE = 'balance';


    protected $table = 'people_account_transactions';

    protected $fillable = [
        self::COLUMN_PARENT_RECORD_ID,
        self::COLUMN_PEOPLE_ID,
        self::COLUMN_PEOPLE_ACCOUNT_ID,
        self::COLUMN_MONEY_ACCOUNT_ID,
        self::COLUMN_TRANSACTION_TYPE,
        self::COLUMN_OPERATION_TYPE,
        self::COLUMN_PAYMENT_TYPE,
        self::COLUMN_AMOUNT,
        self::COLUMN_DESCRIPTION,
        self::COLUMN_DATE,
        self::COLUMN_BALANCE,


    ];

    protected $casts = [
        self::COLUMN_ID => 'integer',
        self::COLUMN_PEOPLE_ACCOUNT_ID => 'integer',
        self::COLUMN_PEOPLE_ID => 'integer',
        self::COLUMN_PARENT_RECORD_ID => 'integer',
        self::COLUMN_MONEY_ACCOUNT_ID => 'integer',
        self::COLUMN_BALANCE => 'double',
        self::COLUMN_TRANSACTION_TYPE => 'string',
        self::COLUMN_OPERATION_TYPE => 'string',
        self::COLUMN_PAYMENT_TYPE => 'string',
        self::COLUMN_AMOUNT => 'double',
        self::COLUMN_DESCRIPTION => 'string',
        self::COLUMN_DATE => 'datetime',
    ];

    protected $datas = [
        'created_at','updated_at','deleted_at'
    ];
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function peopleAccount()
    {
        return $this->belongsTo(PeopleAccount::class, self::COLUMN_PEOPLE_ACCOUNT_ID);
    }


    public function moneyAccount()
    {
        return $this->belongsTo(MoneyAccount::class, self::COLUMN_MONEY_ACCOUNT_ID);
    }

    public function people()
    {
        return $this->belongsTo(People::class, self::COLUMN_PEOPLE_ID);
    }

    public static function booted()
    {
        static::created(function ($model) {
            
        });
    }
}

