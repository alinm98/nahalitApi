<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = [
        'coupon_type',
        'coupon_value',
        'user_id',
    ];

    /* User Coupons Relation */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /* User Coupons Relation */

}
