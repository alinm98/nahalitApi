<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable= [
        'count', 'url'
    ];

    public function subCounts()
    {
        return Visit::query()->sum('count');
    }
}
