<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'services_group_id', 'first_value', 'second_value', 'description'
    ];

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ServicesGroup::class, 'services_group_id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ServicesGroup::class, 'services_group_id');
    }
}
