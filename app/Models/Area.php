<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Area extends Model
{
    /** @use HasFactory<\Database\Factories\AreaFactory> */
    use HasFactory, SoftDeletes;

   protected $fillable = [
    'area',
    'governorate'
   ];

   public function restaurants()
   {
       return $this->hasMany(RestaurantBranch::class);
   }
}
