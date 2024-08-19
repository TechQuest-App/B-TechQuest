<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'course_id'];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_certificates');
    }
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
