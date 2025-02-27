<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VisitorAction extends Model
{
    /** @use HasFactory<\Database\Factories\VisitorActionFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'action_type',
        'ip_address',
    ];
}
