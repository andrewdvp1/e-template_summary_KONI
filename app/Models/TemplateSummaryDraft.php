<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateSummaryDraft extends Model
{
    protected $fillable = [
        'draft_type',
        'title',
        'payload',
        'last_saved_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'last_saved_at' => 'datetime',
    ];
}

