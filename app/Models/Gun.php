<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gun extends Model
{
    protected $fillable = [
        'inventory_id',
        'name',
        'caliber',
        'serial_number'
    ];
}
