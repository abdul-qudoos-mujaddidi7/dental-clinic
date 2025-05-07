<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cure extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const COLUMN_PAID = 'paid';
    protected $fillable = [
        'patient_id',
        'dentist_id',
        'start_date',
        'grand_total',
        'people_account_id',
        'money_account_id',
        self::COLUMN_PAID,
        'status',
        'description',
    ];

    protected $table='cures';

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
