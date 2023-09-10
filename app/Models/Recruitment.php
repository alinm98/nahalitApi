<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'birthday', 'martial_status', 'address', 'phone', 'activity', 'eduction_status',
         'ability_description', 'shaba_number', 'status'
    ];
}
