<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use function Laravel\Prompts\search;

class BillExpense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'grand_total',
        'paid',
        'bill_number',
        'supplier_id',
        'note',
        'bill_date',
        'user_id'
    ];

    public function billExpenseDetails(){
        return $this->hasMany(BillExpenseDetail::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


    public function scopeSearch($query,$search){
        if(!$search){
            return $query;
        }

        return $query->where('bill_number','like','%'.$search.'%');
    }



    

    
}
