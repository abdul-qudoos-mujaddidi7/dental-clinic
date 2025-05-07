<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tooth extends Model
{
    use HasFactory;

    public const COLUMN_ID = 'id';
    public const COLUMN_NAME = 'name';
    public const COLUMN_DESCRIPTION = 'description';

    // The table associated with the model
    protected $table = 'tooths';

    // Mass assignable attributes
    protected $fillable = [
        self::COLUMN_NAME,
        self::COLUMN_DESCRIPTION,
    ];
    
    // Timestamps for created_at and updated_at
    public $timestamps = true;


    public function scopeSearch($query,$search){
        if(!$search){
            return $query;
        }

        return $query->where('name','LIKE','%'. $search .'%');


    }
}
