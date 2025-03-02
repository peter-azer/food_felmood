<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    /** @use HasFactory<\Database\Factories\RestaurantFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'food_type_ids',
        'name',
        'name_ar',
        'logo',
        'thumbnail',
        'description',
        'description_ar',
        'slug',
        'slug_ar',
        'Rank',
        'recommendation',
        'cost',
        'restaurant_code',
        'images',
        'hotline',
    ];

    protected $casts = [
        'food_type_ids' => 'array', // Automatically convert JSON to array
    ];

    public function branches()
    {
        return $this->hasMany(RestaurantBranch::class);
    }

    public function foodTypes()
    {
        return $this->belongsToMany(FoodType::class);
    }

    public function socialMediaURL(){
        return $this->hasOne(RestaurantUrl::class);
    }

    public function visits(){
        return $this->hasMany(VisitorAction::class);
    }

    public function weeklySchedule(){
        return $this->hasMany(WeeklySchedule::class);
    }
}
