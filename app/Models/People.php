<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $table = 'people';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'type',
        'date_of_birth',
        'gender',
        'medical_record',
        'dental_record',
        // 'status',
        // 'image',
        // 'share'
    ];

    protected $casts = [
        'medical_record' => 'array',
        'dental_record' => 'array',
    ];

    public function scopeSearch($query, $search)
    {
        if (!empty($search)) {
            return $query->where('name', 'like', "%$search%");
        }

        return $query;
    }

    public function cures()
    {
        return $this->hasMany(Cure::class,'patient_id');
    }
    
    // Relationships
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }
}
