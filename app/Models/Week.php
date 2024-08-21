<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Week extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class, 'week_id','id');
    }

    public function topic():HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
}
