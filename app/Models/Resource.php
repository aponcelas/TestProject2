<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'visibility'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
