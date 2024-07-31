<?php

namespace App\Enum;

enum UserRole:string
{
    case ADMIN = 'admin';

    case User = 'user';
    case Publisher = 'publisher';
    case SUPER_ADMIN = 'super_admin';


    public static function allRole() :array {
        return [
            self::User,
            self::ADMIN,
        ];
    }
}
