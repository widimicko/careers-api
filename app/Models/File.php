<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id ', 'foto','cv','fortofolio', 'certificate'
    ];


    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
