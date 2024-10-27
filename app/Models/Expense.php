<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'amount',
        'user_id',
        'expense_category_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($expense) {
            $expense->reference = 'EXP' . (self::max('id') + 1);
        });
    }


    public function expenseCategory(){
        return $this->belongsTo(ExpenseCategory::class);
    }


    public function scopeSearch($query, $search)
    {
        if (!$search){
            return $query;
        }
        
        return $query->where('date', 'like', "%" . $search . "%");
    }
}
