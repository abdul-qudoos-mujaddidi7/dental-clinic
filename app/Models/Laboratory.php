<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    use HasFactory;

    public const COLUMN_ID = 'id';
    public const COLUMN_PAID = 'paid';
    public const COLUMN_DENTIST_ID = 'dentist_id';
    public const COLUMN_GRAND_TOTAL = 'grand_total';
    public const COLUMN_RETURN_DATE = 'return_date';
    public const COLUMN_ISSUED_AT = 'issue_at';
    public const COLUMN_TYPE = 'type';
    public const COLUMN_DESCRIPTION = 'description';


    protected $table = 'laboratories';

    protected $fillable = [
        self::COLUMN_GRAND_TOTAL,
        self::COLUMN_DESCRIPTION,
        self::COLUMN_ISSUED_AT,
        self::COLUMN_PAID,
        self::COLUMN_TYPE,
        self::COLUMN_DENTIST_ID,
        self::COLUMN_RETURN_DATE
    ];

    protected $casts = [
        self::COLUMN_GRAND_TOTAL => 'double'
    ];

   
    public function details()
    {
        return $this->hasMany(LaboratoryDetail::class);
    }
    public function scopeSearch($query,$search){
        if(!$search){
            return $query;
        }

        return $query->where('name','LIKE','%'. $search .'%');


    }

    public function dentist()
    {
        return $this->belongsTo(People::class, 'dentist_id');
    }
}
