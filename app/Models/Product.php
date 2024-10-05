<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=['name','unit'];

    public function billExpenseDetails()
    {
        return $this->hasMany(BillExpenseDetail::class);
    }

    public function scopeSearch($query,$search){
        if(!$search){
            return $query;
        }

        return $query->where('name','like','%'.$search.'%');
    }
}
