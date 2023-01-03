<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* User Coupons Relation */
    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'user_id');
    }
    /* User Coupons Relation */

    /* User Orders Relation */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    /* User Orders Relation */

    /* User Comments Relation */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
    /* User Comments Relation */

    /* User Installments Relation */
    public function installments()
    {
        return $this->hasMany(Installment::class, 'user_id');
    }
    /* User Installments Relation */

}
