<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Topic extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class);
    }

}
