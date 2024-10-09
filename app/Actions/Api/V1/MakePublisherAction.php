<?php

namespace App\Actions\Api\V1;

use App\Enum\UserRole;
use App\Http\Resources\V1\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MakePublisherAction extends ApiAction
{

    public function execute(array $data): JsonResponse
    {
        $user = auth()->user();
        $check = $user?->author?->id === null;

        if (!$check) {
            return $this->clientErrorResponse(msg: 'already a publisher!!');
        }

        $return = DB::transaction(static function () use ($data, $user) {
            $data['user_id'] = $user->id;
            $user->update([
                'role' => UserRole::Publisher->value,
            ]);

            return Publisher::create($data);
        });

        return $this->successResponse(
            '',
            data: new PublisherResource($return),
            statusCode: 201
        );
    }
}
