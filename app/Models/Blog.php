<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'image',
        'slug',
        'body',
        'is_active',
        'user_id',
    ];

    /* User Blogs Relationships */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /* User Blogs Relationships */

    public function search($parameter): \Illuminate\Database\Eloquent\Collection|array
    {
        return Blog::query()->where('title' ,'like', '%'.$parameter.'%')->get();
    }

}
