<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'base_url' => env('MIDTRANS_SANDBOX_BASE_URL'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false)
];
