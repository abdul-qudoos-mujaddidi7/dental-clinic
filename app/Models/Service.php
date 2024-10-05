<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\search;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['name','description'];

    public function serviceGroups()
    {
        return $this->belongsToMany(ServiceGroup::class, 'service_service_groups');#The pivot table that stores this relationship is
                                                                                   #named service_service_groups, which stores the mapping
                                                                                    #between service_id and service_group_id.
    }

    public function cureDetails()
    {
        return $this->hasMany(CureDetail::class);
    }

    public function scopeSearch($query, $search){
        if(!$search){
            return $query;
        }

        return $query->where('name','LIKE','%'. $search .'%');
    }

}
