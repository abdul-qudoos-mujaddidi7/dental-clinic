<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CureService extends Model
{
    use HasFactory;
    protected $fillable = [
        'cure_id',
        'service_id',
        'cost',
        'discount',
        'total',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function cure(){
        return $this->belongsTo(cure::class);
    }

    
}
