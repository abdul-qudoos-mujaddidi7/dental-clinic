<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cure extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',  
        'start_date',
        'grand_total',
        'paid',
        'status',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cure) {
            $cure->reference = 'CURE' . (self::max('id') + 1);
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function cureCycles()
    {
        return $this->hasMany(CureCycle::class);
    }
    public function cureServices()
    {
        return $this->hasMany(CureService::class);
    }
    public function payments() {
        return $this->hasMany(CurePayment::class);
    }

    public function scopeSearch($query, $search){
        if(!$search){
            return $query;
        }
        return $query->where('name','LIKE','%'.$search. '%');
    }
}
