<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['date','amount','bill_expense_id','user_id'];
    use HasFactory;

    public function scopeSearch( $query, $search){
        if( !$search){
            return $query;
    }

    return $query->where('date','LIKE','%'. $search .'%');
}

    public function billExpense(){
        return $this->belongsTo(BillExpense::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
