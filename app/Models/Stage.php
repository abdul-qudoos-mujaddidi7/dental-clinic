<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    public const COLUMN_NAME = 'name';

    protected $table = 'stages';

    protected $fillable = [
        self::COLUMN_NAME
    ];

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where(self::COLUMN_NAME, 'LIKE', '%' . $search . '%');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
