<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'jobdesc', 'kualification', 'image', 'date'];

    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'lowongan_id', 'id');
    }
}
