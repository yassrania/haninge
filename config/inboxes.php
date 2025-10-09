<?php

return [
    // أي خدمة slug معيّن → صندوق افتراضي
    'slug_defaults' => [
        'vigsel'                 => 'vigsel',
        'utbildning-barn'        => 'barn',
        'barn'                   => 'barn',
        'barnstudier'            => 'barn',
        'utbildning-vuxen'       => 'vuxen',
        'vuxen'                  => 'vuxen',
        'vuxenstudier'          => 'vuxen',
        'kontakt'                => 'kontakt',
        'kontakta-oss'           => 'kontakt',
    ],

    // اسم الصندوق → كلاس الموديل
    'targets' => [
        'vigsel'  => \App\Models\Inbox\VigselInquiry::class,
        'vuxen'   => \App\Models\Inbox\AdultStudy::class,
        'barn'    => \App\Models\Inbox\ChildStudy::class,
        'kontakt' => \App\Models\Inbox\ContactMessage::class,
    ],
];
