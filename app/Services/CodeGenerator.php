<?php

namespace App\Services;

use App\Models\Restaurant;

class CodeGenerator
{
    public static function generateCode()
    {
        $latest = Restaurant::latest('id')->first();
        $number = $latest ? intval(substr($latest->restaurant_code, 5)) + 1 : 1;
        return 'RESTO-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}