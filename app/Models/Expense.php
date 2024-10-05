<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'amount',
        'user_id',
        'expense_category_id',
    ];

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
