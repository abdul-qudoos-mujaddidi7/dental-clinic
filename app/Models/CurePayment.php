<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use function Laravel\Prompts\search;

class CurePayment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['cure_id', 'amount', 'date'];
    public function cure()
    {
        return $this->belongsTo(Cure::class);
    }


    public function scopeSearch($query, $search, $cure)
    {
        if (!$search && !$cure) {
            return $query;
        }

        if($cure){
            return $query->where('cure_id',$cure);
        }
        
         return $query->where('name', 'LIKE', '%' . $search . "%");
    }
}
