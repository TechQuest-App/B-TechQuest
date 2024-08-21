<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Resource extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function course(): BelongsTo
    {
        return $this->BelongsTo(Course::class, 'course_id', 'id');
    }

    public function week():BelongsTo
    {
        return $this->belongsTo(Week::class, 'week_id', 'id');
    }
}
