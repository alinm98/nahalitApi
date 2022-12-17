<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'title',
        'body',
        'status',
        'user_id',
        'product_id',
    ];

    /* User Comments Relation */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /* User Comments Relation */

    /* Product Comments Relation */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    /* Product Comments Relation */

}
