<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $table = 'leads';

    public const COLUMN_NAME = 'name';
    public const COLUMN_PHONE = 'phone';
    public const COLUMN_GENDER = 'gender';
    public const COLUMN_ADDRESS = 'address';
    public const COLUMN_DATE = 'date';
    public const COLUMN_CATEGORY_ID = 'category_id';
    public const COLUMN_STAGE_ID = 'stage_id';
    public const COLUMN_NOTE = 'note';

    protected $fillable = [
        self::COLUMN_NAME,
        self::COLUMN_PHONE,
        self::COLUMN_GENDER,
        self::COLUMN_ADDRESS,
        self::COLUMN_DATE,
        self::COLUMN_CATEGORY_ID,
        self::COLUMN_STAGE_ID,
        self::COLUMN_NOTE
    ];



    public function scopeSearch($query, $search)
    {

        if (!$search) {
            return $query;
        }
        return $query->where('name', 'LIKE', '%' . $search . '%');
    }

    // Relationship with the Stage model
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    //Relationship with the Category model
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
