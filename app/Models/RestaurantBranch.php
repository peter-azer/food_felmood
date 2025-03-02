<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RestaurantBranch extends Model
{
    /** @use HasFactory<\Database\Factories\RestaurantBranchFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'area_id',
        'branch_code',
        'phone_number',
        'optional_phone_number',
        'location',
        'address',
        'menu',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
