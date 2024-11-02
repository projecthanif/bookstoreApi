<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\MakeOrderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        //
    }

    public function store(StoreOrderRequest $request, MakeOrderAction $action)
    {
        $action->execute($request->validated());
    }

    public function destroy(string $id)
    {
        //
    }
}
