<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StorePublisherRequest;
use App\Http\Requests\Api\V1\UpdatePublisherRequest;
use App\Http\Resources\V1\PublisherCollection;
use App\Http\Resources\V1\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * Store a newly created resource in storage.
     */
    public function store(StorePublisherRequest $request)
    {
        $data = $request->validated();
        DB::transaction(static function () use ($data) {
            $data['user_id'] = auth()->user()->id;

            $user = auth()->user()->update([
                'role' => UserRole::Publisher->value
            ]);

            return new PublisherResource(Publisher::create($data));
        });

//        return new PublisherResource($publisher);
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
     */
    public function destroy(string $id)
    {
//        Publisher::find($id)->delete();
    }
}
