<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable =[
        'title' , 'category_id'
    ];


    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class , 'category_id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class , 'category_id');
    }

    public function subChildren(): array
    {
        $categories = $this->all();
        foreach ($categories as $category){
            foreach ($category->children as $childCategory){
                foreach ($childCategory->children as $subCategory){
                    $array[] = $subCategory;
                }
            }
        }
        return $array;
    }

    public function propertyGroup(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(PropertyGroup::class);
    }
}
