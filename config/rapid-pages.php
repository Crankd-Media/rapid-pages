<?php

return [
    'section_path' => 'app.sections.',
    'routes' => [
        'admin' => [
            'prefix' => 'admin',
            'middleware' => ['web', 'auth'],
            'pages' => [
                'index' => 'admin.pages.index',
                'create' => 'admin.pages.create',
                'edit' => 'admin.pages.edit',
                'update' => 'admin.pages.update',
                'destroy' => 'admin.pages.destroy',
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
                'create' => 'admin.section-crud',
                'edit' => 'admin.section-crud',
            ],
        ],
        'app' => [
            'page' => [
                'show' => 'frontend.page.show',
            ],
        ],
    ],
];
