<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class FoodType extends Model
{
    /** @use HasFactory<\Database\Factories\FoodTypeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type'
    ];

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'food_type_restaurant');
    }
}
