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
        'total',
        'status',
        'quantity'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function cure(){
        return $this->belongsTo(Cure::class, 'cure_id', 'id');
    }

    
}
