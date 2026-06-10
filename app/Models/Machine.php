<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Machine extends Model
{
    protected $fillable = [
        'stage_id',
        'name',
        'sort_order',
    ];

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }
}


