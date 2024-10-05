<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'image',
        'share'
    ];

    public function ownerPickups()
    {
        return $this->hasMany(OwnerPickup::class);
    }

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        // Trimming the search input to remove extra spaces
        $search = trim($search);
        return $query->where('first_name', 'LIKE', '%' . $search . '%');
    }
}
