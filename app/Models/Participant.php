<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'recruitment_id ', 'name', 'gender', 'place_birth', 'date_birth','email','age','address','city',
        'education','major','univercity','media_social','information'
    ];

    public function recruitment()
    {
        return $this->belongsTo(Recruitment::class);
    }
}
