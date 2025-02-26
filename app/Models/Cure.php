<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cure extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'dentist_id',
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
            $cure->reference = 'CURE_' . (self::max('id') + 1);
        });
    }

    public function patient()
    {
        return $this->belongsTo(People::class,'patient_id');
    }
    public function dentist()
{
    return $this->belongsTo(People::class,'dentist_id');
}

    public function cureCycles()
    {
        return $this->hasMany(CureCycle::class);
    }
    public function payments()
    {
        return $this->hasMany(CurePayment::class);
    }

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where('name', 'LIKE', '%' . $search . '%');
    }

    public function getPaymentStatus()
    {
        if ($this->paid >= $this->grand_total) {
            return 'PAID';
        } elseif ($this->paid > 0) {
            return 'PARTIAL';
        } else {
            return 'DUE';
        }
    }

    public function cureServices()
    {
        return $this->hasMany(CureService::class);
    }
}
