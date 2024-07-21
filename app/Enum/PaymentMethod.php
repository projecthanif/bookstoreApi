<?php

namespace App\Enum;

enum PaymentMethod: string
{
    case CREDIT_CARD = 'credit_card';
    case CASH = 'cash';

}
