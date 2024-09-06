<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static find($id)
 */
class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function book(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
