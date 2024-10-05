<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'last_name',
        'date_of_birth',
        'gender',
        'diseases_history',
        'particular_to_female',
        'doctor_warning',
        'phone',
    ];
    protected $casts = [
        'diseases_history' => 'array',
        'particular_to_female'=>'array' // To cast as JSON array
    ];
        // Casting means converting data from one format to another.
        // The disease_history field is stored as JSON in the database,
        // but when you retrieve it in your code, Laravel automatically
        // converts it to a PHP array.Similarly, when you save a PHP array
        //  to the disease_history field, Laravel automatically converts it 
        //  to JSON format before saving it to the database.

        // Before Casting:
        //     You would need to manually decode and encode the data to work with it.
            
        //     Without casting:
        //     Retrieve: $patient->disease_history = json_decode($dataFromDB)
        //     Save: $patient->disease_history = json_encode($arrayToSave)
        //     After Casting:
        //     With casting, Laravel does the encoding/decoding automatically:
            
        //     Retrieve: $patient->disease_history (Already a PHP array)
        //     Save: $patient->disease_history = $yourArray (Laravel saves it as JSON automatically)
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function cure()
    {
        return $this->hasMany(Cure::class);
    }

    public function scopeSearch($query, $search){
        if(!$search){
            return $query;
        }
        return $query->where('name','LIKE','%'. $search .'%');
    }
}
