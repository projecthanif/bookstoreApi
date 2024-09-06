<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreGenreRequest;
use App\Http\Requests\Api\V1\UpdateGenreRequest;
use App\Http\Resources\V1\BookCollection;
use App\Http\Resources\V1\GenreCollection;
use App\Http\Resources\V1\GenreResource;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        return new GenreCollection(Genre::all());
    }

    /**
     * Display a listing of the resource.
     */
    public function books(Genre $genre, $id)
    {
        return new BookCollection($genre::find($id)?->book);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenreRequest $request)
    {
        $data = $request->validated();
        $data['name'] = strtolower($data['name']);
        $genre = Genre::create($data);

        return new GenreResource($genre);
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        return new GenreResource($genre);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        $data = $request->validated();
        if (array_key_exists('name', $data)) {
            $data['name'] = strtolower($data['name']);
        }
        $genre->update($data);
        return new GenreResource($genre);
    }
}
