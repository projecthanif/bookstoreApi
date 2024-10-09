<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\MakePublisherAction;
use App\Enum\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StorePublisherRequest;
use App\Http\Requests\Api\V1\UpdatePublisherRequest;
use App\Http\Resources\V1\PublisherCollection;
use App\Http\Resources\V1\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PublisherCollection(Publisher::all());
    }

    /**
     * Create a new Publisher and also update a user role from normal or customer to publisher
     */
    public function store(StorePublisherRequest $request, MakePublisherAction $action)
    {
        $user = auth()->user();

        return $action->execute($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        return new PublisherResource($publisher);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePublisherRequest $request, Publisher $publisher)
    {
        $data = $request->validated();
        $update = $publisher->update($data);

        return new PublisherResource($publisher);
    }

    /**
     * Remove the specified resource from storage.
     * I don't think destroy or delete would be needed
     */
    public function destroy(string $id)
    {
        //        Publisher::find($id)->delete();
    }
}
