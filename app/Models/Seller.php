<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $table = 'sellers';

    protected $fillable = [
        'card_number',
        'code_meli',
        'status',
        'user_id',
    ];

    /* Seller Products Relationships */
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }
    /* Seller Products Relationships */

}
