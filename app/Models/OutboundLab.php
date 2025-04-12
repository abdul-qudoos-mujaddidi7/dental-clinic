<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutboundLab extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const COLUMN_ID = 'id';
    public const COLUMN_PAID = 'paid';
    public const COLUMN_SUPPLIER_ID='supplier_id';
    public const COLUMN_GRAND_TOTAL = 'grand_total';
    public const COLUMN_RETURN_DATE = 'return_date';
    public const COLUMN_ISSUED_AT = 'issue_at';
    public const COLUMN_DESCRIPTION = 'description';
    public const COLUMN_PEOPLE_ACCOUNT_ID='people_account_id';
    public const COLUMN_MONEY_ACCOUNT_ID='money_account_id';



    protected $table = 'outbound_labs';

    protected $fillable = [
        self::COLUMN_GRAND_TOTAL,
        self::COLUMN_DESCRIPTION,
        self::COLUMN_ISSUED_AT,
        self::COLUMN_PAID,
        self::COLUMN_SUPPLIER_ID,
        self::COLUMN_RETURN_DATE,
        self::COLUMN_MONEY_ACCOUNT_ID,
        self::COLUMN_PEOPLE_ACCOUNT_ID
    ];

    protected $casts = [
        self::COLUMN_GRAND_TOTAL => 'double'
    ];

   
    public function laboratoryDetails()
    {
        return $this->hasMany(LaboratoryDetail::class);
    }
    public function scopeSearch($query,$search){
        if(!$search){
            return $query;
        }

        return $query->where('name','LIKE','%'. $search .'%');


    }

    public function supplier()
    {
        return $this->belongsTo(People::class, 'supplier_id');
    }
    
}