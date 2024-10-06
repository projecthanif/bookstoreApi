<?php

namespace App\Enum;

enum PaymentMethod: string
{
    case CREDITCARD = 'credit card';
    case CASH = 'cash';

}
