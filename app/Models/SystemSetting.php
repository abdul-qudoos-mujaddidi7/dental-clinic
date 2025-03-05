<?php

namespace App\Models;

use Hamcrest\SelfDescribing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;
    public const COLUMN_NAME='name';
    public const COLUMN_EMAIL='email';
    public const COLUMN_PHONE='phone';
    public const COLUMN_IMAGE='image';
    public  const COLUMN_ADDRESS='address';

    protected $table='system_settings';


    protected $fillable = [
        self::COLUMN_NAME,
        self::COLUMN_EMAIL,
        self::COLUMN_PHONE,
        self::COLUMN_IMAGE,
        self::COLUMN_ADDRESS
    ];

    public $images = [ 
        self::COLUMN_IMAGE
    ];


}
