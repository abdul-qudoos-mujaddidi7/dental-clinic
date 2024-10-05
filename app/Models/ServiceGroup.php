<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceGroup extends Model
{
    use HasFactory;
    protected $fillable=['name','description'];
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_service_groups');
    }


    public function scopeSearch($query,$search){
        if(!$search){
            return $query;
        }

        $search= trim($search);
        $query->where('name','LIKE','%'.$search.'%');
    }
}
