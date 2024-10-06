<?php

namespace App\Enum;

use App\Traits\EnumToArray;

enum UserRole: string
{
    use EnumToArray;
    case ADMIN = 'admin';

    case User = 'user';

    case Publisher = 'publisher';
    case SUPER_ADMIN = 'super_admin';

    case Author = 'author';
}
