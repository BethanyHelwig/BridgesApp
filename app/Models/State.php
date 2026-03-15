<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name', 'abbreviation'];

    /** @use HasFactory<\Database\Factories\StateFactory> */
    use HasFactory;

    public function cities() {
        return $this->hasMany(City::class);
    }
}
