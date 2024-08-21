<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoadMap extends Model
{
    protected $table = 'roadmaps';
    protected $guarded = ['id'];
    use HasFactory;


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function level(): HasMany
    {
        return $this->hasMany(Level::class, 'roadmap_id');
    }
}
