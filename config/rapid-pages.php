<?php

return [
    'routes' => [
        'admin' => [
            'prefix' => 'admin',
            'middleware' => ['web', 'auth'],
            'pages' => [
                'index' => 'admin.pages.index',
                'create' => 'admin.pages.create',
                'edit' => 'admin.pages.edit',
            ],
            'sections' => [
                'index' => null,
                'create' => 'admin.sections.create',
                'edit' => 'admin.sections.edit',
                'store' => 'admin.sections.store',
                'update' => 'admin.sections.update',
                'destroy' => 'admin.sections.destroy',
            ],
        ],
        'app' => [
            'prefix' => '',
            'middleware' => ['web'],
            'pages' => [
                'show' => 'pages.show',
            ],
        ],
    ],
    'views' => [
        'admin' => [
            'pages' => [
                'index' => 'admin.page.index',
                'create' => 'admin.page.create',
                'edit' => 'frontend.page.edit',
            ],
            'sections' => [
                'index' => 'admin.section-index',
                'create' => 'admin.section-create',
                'edit' => 'admin.section-edit',
            ],
        ],
        'app' => [
            'page' => [
                'show' => 'frontend.page.show',
            ],
        ],
    ],
];
