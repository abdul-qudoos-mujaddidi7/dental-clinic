<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OwnerPickup extends Model
{
    use HasFactory, SoftDeletes;
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
