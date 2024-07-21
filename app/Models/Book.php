<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'publisher_id',
        'genre_id',
    ];


    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'book_authors', 'book_id', 'author_id');
    }

    public function order(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items', 'book_id', 'order_id');
    }

    public function reviews():HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cart():BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'cart_items', 'book_id', 'cart_id');
    }

    public function wishList():BelongsToMany
    {
        return $this->belongsToMany(WishList::class, 'wish_list_items', 'book_id', 'wishlist_id');
    }
}

