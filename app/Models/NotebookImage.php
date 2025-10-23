<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotebookImage extends Model
{
    use HasFactory;

    protected $fillable = ['notebook_id', 'image_path'];

    public function notebook()
    {
        return $this->belongsTo(Notebook::class);
    }
}

