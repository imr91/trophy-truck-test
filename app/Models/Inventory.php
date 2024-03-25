<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table='user_vehicle';
    public $timestamps = false;
    protected $fillable = ['user_id', 'vehicle_id'];
}
