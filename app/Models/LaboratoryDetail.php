<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryDetail extends Model
{
    use HasFactory;

    public const COLUMN_ID = 'id';
    public const COLUMN_INBOUND_LAB_ID = 'inbound_lab_id';
    public const COLUMN_OUTBOUND_LAB_ID = 'outbound_lab_id';
    public const COLUMN_TOOTH_ID = 'tooth_id';
    public const COLUMN_TOOTH_TYPE = 'tooth_type';
    public const COLUMN_COST = 'cost';
    public const COLUMN_QUANTITY = 'quantity';
    public const COLUMN_TOTAL = 'total';

    protected $table = 'laboratory_details';

    protected $fillable = [
        self::COLUMN_INBOUND_LAB_ID,
        self::COLUMN_OUTBOUND_LAB_ID,
        self::COLUMN_TOOTH_ID ,
        self::COLUMN_TOOTH_TYPE,
        self::COLUMN_COST,
        self::COLUMN_QUANTITY,
        self::COLUMN_TOTAL,
    ];



    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class);
    }
    public function tooth()
    {
        return $this->belongsTo(Tooth::class);
    }
}
