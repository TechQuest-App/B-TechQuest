<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function week(): HasMany
    {
        return $this->hasMany(Week::class);
    }

    public function roadmap(): BelongsTo
    {
        return $this->belongsTo(Roadmap::class, 'roadmap_id');
    }

}
