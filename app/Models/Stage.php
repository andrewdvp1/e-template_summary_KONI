<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    protected $fillable = [
        'name',
        'sort_order',
    ];

    public function machines(): HasMany
    {
        return $this->hasMany(Machine::class);
    }
}


