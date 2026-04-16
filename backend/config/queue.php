<?php

return [
    'driver' => env('QUEUE_CONNECTION', 'database'),
    'connection' => env('QUEUE_CONNECTION', 'database'),
    'queue' => env('QUEUE_QUEUE', 'default'),
    'retry_after' => (int) env('QUEUE_RETRY_AFTER', 90),
    'after_commit' => false,
];
