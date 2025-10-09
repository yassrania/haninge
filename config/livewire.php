<?php

return [
    'temporary_file_upload' => [
        'disk' => 'local',
        'directory' => 'livewire-tmp',
        'rules' => null,
        'middleware' => null,
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4', 'mov', 'avi', 'wmv', 'mp3', 'midi', 'webm', 'jpg', 'jpeg', 'webp',
        ],
        'max_upload_time' => 90,
    ],
];
