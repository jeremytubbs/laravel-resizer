<?php

return [
    'destination_path' => public_path('images'),
    'image_sizes' => [
        'thumb'   => [165, null],
        'preview' => [360, 420]
    ],
    'image_driver' => 'imagick',
    'image_2x' => true,
    'image_format' => 'jpg',
];
