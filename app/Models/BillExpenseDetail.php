<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillExpenseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'bill_expense_id',
        'quantity',
        'cost',
        'total',
    ];

    public function billExpense(){
        return $this->belongsTo(BillExpense::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
