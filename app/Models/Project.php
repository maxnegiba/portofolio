<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $casts = [
        'title'       => 'array',
        'description' => 'array',
        'tech'        => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}