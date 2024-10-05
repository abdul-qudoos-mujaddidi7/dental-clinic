<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceServiceGroup extends Model
{
    use HasFactory;
    protected $fillable = ['service_group_id','service_id'];
}
