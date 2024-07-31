<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function Pest\Laravel\{actingAs, get, post, delete, put, patch};


$uri = "api/v1/user";
it('can create new user', function () use ($uri) {

    $name = fake()->name();
    $email = fake()->email();
    $role = "superadmin";
    $count = \App\Models\User::count();

    $user = post($uri, [
        'name' => $name,
        'email' => $email,
        'role' => $role,
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
        'remember_token' => Str::random(10),
    ]);


    expect($email)->toBe($user['data']['email'])
        ->and($count + 1)
        ->toBe(\App\Models\User::count());
});


it('can delete user from db', function () use ($uri) {
    $count = \App\Models\User::count();
    $id = \App\Models\User::all()->random(1)->first()->id;

    delete("{$uri}/{$id}");

    expect(\App\Models\User::find($id))
        ->toBeNull('User not found')
        ->and($count - 1)
        ->toBe(\App\Models\User::count());
});

it("can update user", function () use ($uri) {
    $email = fake()->email();
    $user = \App\Models\User::all();

    if ($user->first() === null) {
//        expect()->dd('no user found to update');
//        expect()->
    }else {
        $user = $user->random(1);
        $res = patch("{$uri}/{$user->first()->id}", [
            'email' => $email
        ]);
        expect($user->first()->email)->not->toBe($res['data']['email']);
    }

});

test('can user login ?', function () use ($uri) {
    $email = fake()->email();
    $user = [
        'name' => 'projecthanif',
        'email' => $email,
        'password' => 'password',
        'role' => 'superadmin'
    ];

    $user = post((string)$uri, $user);

    expect($email)->toBe($user['data']['email']);

    $res = post('/login', [
        'email' => $email,
        'password' => 'password'
    ]);

    $fromDb = toGetUserTokenForTest($user['data']['id']);
    expect($res['token'])->toBe($fromDb);
});


function toGetUserTokenForTest(int $userId){
    return \Illuminate\Support\Facades\DB::table('personal_access_tokens')->where([
        'tokenable_id' => $userId
    ])->select('token');
}
