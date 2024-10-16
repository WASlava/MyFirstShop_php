<?php

namespace App\Models;

class OrderStatus
{
    const NEW = 0;
    const IN_PROGRESS = 1;
    const COMPLETED = 2;
    const CANCELED = 3;
    const PAID = 4;
    const SHIPPED = 5;

}
