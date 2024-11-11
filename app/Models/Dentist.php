<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dentist extends Model
{
    use HasFactory;
    protected $fillable = ['first_name','phone'];
    // ,'last_name',

    // 'address',
    // 'email',
    // 'image',
    // 'status',
    // 'hire_date'


    public function scopeSearch($query,$search){
        if(!$search){
            return $query;
        }

        return $query->where('first_name','like','%'. $search. '%');
    }
    
}
