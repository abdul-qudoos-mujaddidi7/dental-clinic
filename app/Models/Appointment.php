<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'time',
        'status',
        'dentist_id', // Make sure to use the foreign key
        'user_id',    // Make sure to use the foreign key
        'patient_id', // Make sure to use the foreign key
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function dentist(){
        return $this->belongsTo(Dentist::class);
    }

    public function scopeSearch($query, $search){
        if(!$search ){
            return $query;
        }
        $search = trim($search);
        $query->where('','LIKE','%'.$search.'%');
    }
}
