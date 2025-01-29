<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlant extends Model
{
    use HasFactory;

    protected $table = 'user_plant';

    protected $fillable = ['user_id', 'plant_id', 'city'];
}
