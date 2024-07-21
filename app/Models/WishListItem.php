<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WishListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'wishlist_id',
        'book_id',
    ];

    public function wishlist():BelongsTo
    {
        return $this->belongsTo(WishList::class);
    }

    public function book():BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

}
