<?php

use App\Providers\AppServiceProvider;
use App\Providers\PaymentGatewayServiceProvider;
use App\Providers\EventServiceProvider;

return [
    AppServiceProvider::class,
    PaymentGatewayServiceProvider::class,
    EventServiceProvider::class,
];
