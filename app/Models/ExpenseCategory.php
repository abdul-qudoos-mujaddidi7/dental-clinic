<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable=['name','description'];

    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    public function scopeSearch($query, $search)
    {
        if (!$search){
            return $query;
        }
        
        return $query->where('name', 'like', "%" . $search . "%");
    }
}
