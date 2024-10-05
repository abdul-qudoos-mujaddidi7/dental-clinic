<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable=['name','phone','address','email'];

    public function billExpenses(){
        return $this->hasMany(BillExpense::class);

    }

    public function scopeSearch($query,$search){
        if(!$search){
            return $query;
        }

        return $query->where('name','like','%'.$search.'%');
    }
}
