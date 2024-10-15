<?php

namespace App\Actions\Api\V1;

use App\Enum\UserRole;
use App\Http\Resources\V1\AuthorResource;
use Illuminate\Support\Facades\DB;

class BecomeAuthorAction extends ApiAction
{
    public function execute(array $validatedData)
    {
        $user = auth()->user();

        if ($user->role === UserRole::Author->value) {
            return $this->clientErrorResponse(msg: 'Already an author!!');
        }

        $author = DB::transaction(static function () use ($validatedData, $user) {
            $user->update([
                'role' => UserRole::Author->value,
            ]);

            return $user->author()->create($validatedData);
        });

        return $this->successResponse(
            msg: 'Congrats! you have  become an author',
            data: new AuthorResource($author),
            statusCode: 201
        );
    }
}
