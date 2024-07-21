<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'rating',
        'review_text',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
