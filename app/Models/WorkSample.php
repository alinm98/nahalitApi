<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSample extends Model
{
    use HasFactory;

    protected $table = 'work_samples';

    protected $fillable = [
        'title',
        'description',
        'gallery_id',
        'category_id',
        'user_id',
    ];
}
