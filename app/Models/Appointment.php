<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    private $model = Appointment::class;

    // Define constants for column names
    const COLUMN_DATETIME = 'date_time';
    const COLUMN_STATUS = 'status';
    const COLUMN_DENTIST_ID = 'dentist_id';
    const COLUMN_USER_ID = 'user_id';
    const COLUMN_PEOPLE_ID = 'people_id';


    protected $fillable = [
        self::COLUMN_DATETIME,
        self::COLUMN_STATUS,
        self::COLUMN_DENTIST_ID,
        self::COLUMN_USER_ID,
        self::COLUMN_PEOPLE_ID,
    ];

    /**
     * Relationship with User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Patient.
     */
    public function patient()
    {
        return $this->belongsTo(People::class, self::COLUMN_PEOPLE_ID);
    }

    /**
     * Relationship with Dentist.
     */
    public function dentist()
    {
        return $this->belongsTo(People::class, self::COLUMN_DENTIST_ID);
    }

    /**
     * Scope to search appointments.
     */
    // public function scopeSearch($query, $search)
    // {
    //     if (!$search) {
    //         return $query;
    //     }
    //     $search = trim($search);
    //     return $query->where(self::COLUMN_DATE, 'LIKE', '%' . $search . '%')
    //                  ->orWhere(self::COLUMN_TIME, 'LIKE', '%' . $search . '%')
    //                  ->orWhere(self::COLUMN_STATUS, 'LIKE', '%' . $search . '%');
    // }
}
