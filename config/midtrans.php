<?php

return [
    'serverKey'     => env('MIDTRANS_SERVER_KEY', null),
    'isProcution'   => env('MIDTRANS_IS_PRODUCTION', false),
    'isSanitized'   => env('MIDTRANS_IS_SANITIZED', true),
    'is3ds'         => env('MIDTRANS_IS_3DS', true),
];

// nanti bisa manggil kyk gini
// config('midtrans.serverKey')
// jangan lupa jalankan php artisan config:clear