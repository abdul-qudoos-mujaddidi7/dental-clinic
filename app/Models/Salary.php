<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;


    public const COLUMN_ID = 'id';
    public const COLUMN_AMOUNT = 'amount';
    public const COLUMN_PEOPLE_ID = 'people_id';




    // protected $table = 'salaries';

    protected $fillable = [
        self::COLUMN_PEOPLE_ID,
        self::COLUMN_AMOUNT
    ];

    public function people()
    {
        return $this->belongsTo(people::class, 'people_id');
    }
}
