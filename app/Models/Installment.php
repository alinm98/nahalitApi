<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [ 'price','description','number_of_installment','status','payments','deadline','user_id','order_id' ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

