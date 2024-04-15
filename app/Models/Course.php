<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'stage', 'description'];

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
}
