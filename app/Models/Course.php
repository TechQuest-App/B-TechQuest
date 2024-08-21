<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    protected $fillable =[
        'name',
        'description',
        'image',
        'price',
        'length',
        'category_id',
        'mentor_id'
        ];
    use HasFactory;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function section(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function review(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlist(): BelongsToMany
    {
        return $this->belongsToMany(Wishlist::class, 'wishlists_courses', 'course_id', 'wishlist_id');
    }

    public function cart(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'cart_items', 'course_id', 'cart_id');
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function resource(): HasOne
    {
        return $this->HasOne(Resource::class, 'course_id', 'id');
    }
}
