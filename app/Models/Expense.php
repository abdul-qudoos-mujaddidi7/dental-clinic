<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    public const COLUMN_ID = 'id';
    public const COLUMN_AMOUNT = 'amount';
    public const COLUMN_USER_ID = 'user_id';
    public const COLUMN_EXPENSE_CATEGORY_ID = 'expense_category_id';
    public const COLUMN_DESCRIPTION = 'note';
    public const COLUMN_DATE = 'date';
    public const COLUMN_MONEY_ACCOUNT_ID = 'money_account_id';

    protected $fillable = [
        self::COLUMN_ID,
        self::COLUMN_AMOUNT,
        self::COLUMN_USER_ID,
        self::COLUMN_EXPENSE_CATEGORY_ID,
        self::COLUMN_DESCRIPTION,
        self::COLUMN_DATE,
        self::COLUMN_MONEY_ACCOUNT_ID
    ];

    protected $table='expenses';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($expense) {
            $expense->reference = 'EXP_' . (self::max('id') + 1);
        });
    }


    public function expenseCategory(){
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
 public function account()
{
    return $this->belongsTo(MoneyAccount::class,"money_account_id");
}

    public function scopeSearch($query, $search)
    {
        if (!$search){
            return $query;
        }
        
        return $query->where('date', 'like', "%" . $search . "%");
    }
}
