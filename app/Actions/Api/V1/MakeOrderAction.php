<?php

namespace App\Actions\Api\V1;

use App\Models\Order;

class MakeOrderAction extends ApiAction
{
    public function __construct(
        private Order $order,
    )
    {
    }


    public function execute(array $data)
    {
        $this->order->create($data);

        $this->successResponse(msg: "Order placed Successfully", statusCode: 201);
    }
}
