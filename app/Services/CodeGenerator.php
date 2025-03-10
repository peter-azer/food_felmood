<?php

namespace App\Services;

use App\Models\Restaurant;

class CodeGenerator
{
    public static function generateCode()
    {
        $latest = Restaurant::latest('id')->first();
        $restaurantName = strtoupper(substr($latest->name, 0, 3));
        $uniqueCode = 'RESTO-' . $restaurantName . '-' . strtoupper(substr(uniqid(), -6));
        return $uniqueCode;
    }
}