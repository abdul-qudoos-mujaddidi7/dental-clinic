<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CureCycle extends Model
{
    use HasFactory;
    protected $fillable = ['cure_id','appointment_id'];

    public function cure(){
        return $this->belongsTo(Cure::class);
    }

    public function scopeSearch($query, $search, $cure){
        if(!$search  && !$cure){
            return $query;
    }
    if($cure){
         return $query->where("cure_id",$cure);
    }

    return $query->where("name","LIKE","%".$search."%");
}
}
