<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\Api\V1\ReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'isbn' => $this->isbn,
            'publicationDate' => $this->publication_date,
            'price' => $this->price,
            'currency' => $this->currency,
            'quantity' => $this->quantity,
            'publisherId' => $this->publisher_id,
            'genreId' => $this->genre_id,
            'reviews' =>  ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }
}
