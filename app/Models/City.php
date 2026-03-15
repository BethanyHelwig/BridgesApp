<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['county_name', 'zip', 'city_name', 'state_id'];

    /** @use HasFactory<\Database\Factories\CityFactory> */
    use HasFactory;

    public function state() {
        return $this->belongsTo(State::class);
    }
}
