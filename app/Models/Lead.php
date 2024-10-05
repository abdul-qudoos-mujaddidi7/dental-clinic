<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = ['name','phone','gender','address','date','category_id','stage_id','description'];


    public function scopeSearch($query, $search)
    {

        if (!$search) {
            return $query;
        }
        return $query->where('name', 'LIKE', '%' . $search . '%');
    }

    // Relationship with the Stage model
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    //Relationship with the Category model
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
