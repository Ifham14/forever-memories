<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JourneyImage extends Model
{
    use HasFactory;

    protected $fillable = ['journey_id', 'image_path'];

    public function journey()
    {
        return $this->belongsTo(Journey::class);
    }
}

