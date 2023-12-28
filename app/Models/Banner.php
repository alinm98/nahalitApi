<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'image'
    ];

    public function deleteImage()
    {
        $image = str_replace('http://127.0.0.1:8000/storage', 'public',$this->image);
        Storage::delete($image);
    }
}
