<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'isbn',
        'publication_date',
        'price',
        'currency',
        'quantity',
        'author',
        'genre_id',
    ];

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_books',
            'book_id',
            'user_id'
        );
    }

    public function order(): BelongsToMany
    {
        return $this->belongsToMany(
            Order::class,
            'order_items',
            'book_id',
            'order_id'
        );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function wishList(): BelongsToMany
    {
        return $this->belongsToMany(WishList::class, 'wish_list_items', 'book_id', 'wishlist_id');
    }
}
