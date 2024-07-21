<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

test('url exist', function(){
//    $url = url()->route('user.index');

    expect('https://bookstoreApi.com/')->toBeUrl();
});
