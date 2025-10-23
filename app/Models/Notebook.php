<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'date',
        'story',
        'processional',
        'life_reflection',
        'song_selection',
        'life_scriptures',
        'prayer',
        'resolution',
        'acknowledgment',
        'expression',
        'invitation_of_discipleship',
        'recessional',
        'honorary_pallbearers',
        'grateful_hearts',
        'interment',
        'final_arrangement_entrusted_to',
    ];

    public function images()
    {
        return $this->hasMany(NotebookImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
