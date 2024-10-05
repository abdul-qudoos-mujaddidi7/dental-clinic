<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerPickup extends Model
{
    use HasFactory;
    protected $fillable = ['date','amount','owner_id','description'];

    public function owner(){
        return $this->belongsTo(Owner::class);
    }

    public function scopeSearch($query, $search){
        if(!$search){
            return $query;
        }

        $search= trim($search);
        return $query->where('date','LIKE','%'.$search.'%');
    }

}
