<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo'];
    public function course() :HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function roadmap(): HasOne
    {
        return $this->hasOne(Roadmap::class);
    }
}
