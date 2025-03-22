<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $table = 'people';

    // Define constants for column names
    const COLUMN_NAME = 'name';
    const COLUMN_PHONE = 'phone';
    const COLUMN_EMAIL = 'email';
    const COLUMN_ADDRESS = 'address';
    const COLUMN_TYPE = 'type';
    const COLUMN_DATE_OF_BIRTH = 'date_of_birth';
    const COLUMN_GENDER = 'gender';
    const COLUMN_MEDICAL_RECORD = 'medical_record';
    const COLUMN_DENTAL_RECORD = 'dental_record';
    const COLUMN_SALARY = 'salary';
    const COLUMN_POSITION = 'position';


    protected $fillable = [
        self::COLUMN_NAME,
        self::COLUMN_PHONE,
        self::COLUMN_EMAIL,
        self::COLUMN_ADDRESS,
        self::COLUMN_TYPE,
        self::COLUMN_DATE_OF_BIRTH,
        self::COLUMN_GENDER,
        self::COLUMN_MEDICAL_RECORD,
        self::COLUMN_DENTAL_RECORD,
        self::COLUMN_SALARY,
        self::COLUMN_POSITION,
    ];

    protected $casts = [
        self::COLUMN_MEDICAL_RECORD => 'array',
        self::COLUMN_DENTAL_RECORD => 'array',
    ];

    public function scopeSearch($query, $search)
    {
        if (!empty($search)) {
            return $query->where(self::COLUMN_NAME, 'like', "%$search%");
        }
        return $query;
    }

    public function cures()
    {
        return $this->hasMany(Cure::class, 'patient_id');
    }

    // Relationships
    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function dentistAppointments()
    {
        return $this->hasMany(Appointment::class, 'dentist_id');
    }

    public function laboratoryOrders()
    {
        return $this->hasMany(Laboratory::class, 'dentist_id');
    }
    
    public function laboratoryOrdersForCustomer()
    {
        return $this->hasMany(Laboratory::class, 'customer_id');
    }
    
}
