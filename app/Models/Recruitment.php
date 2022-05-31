<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id','name', 'description','jobdesc','qualification','image','date','address','type'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function participant()
    {
        return $this->hasMany(Participant::class);
    }
}
