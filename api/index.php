<?php

// โหลด Composer autoload
require __DIR__ . '/../vendor/autoload.php';

// โหลด Laravel Application
$app = require_once __DIR__ . '/../bootstrap/app.php';

// เรียก Kernel และจัดการ Request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
