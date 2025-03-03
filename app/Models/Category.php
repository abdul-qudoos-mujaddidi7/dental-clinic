<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public const COLUMN_NAME = 'name';

    protected $fillable = [
        self::COLUMN_NAME,
    ];

    protected $table= 'categories';

    /**
     * Relationship: A category has many leads.
     */
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    /**
     * Scope function for searching categories by name.
     */
    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where(self::COLUMN_NAME, 'LIKE', '%' . $search . '%');
    }
}
