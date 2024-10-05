<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function scopeSearch($query,$search){

        if(!$search){
            return $query;
        }
        return $query->where('name','LIKE','%'.$search.'%');
    }

    public function leads(){
        return $this->hasMany(Lead::class);
    }
}
