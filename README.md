# Rapid Pages

composer require crankd/rapid-pages

## LOAD JS FILES

php artisan vendor:publish --provider="Crankd\RapidPages\RapidPagesProvider"

import "../../packages/crankd/rapid-pages/resources/js/rapid-pages";
import "../../packages/crankd/rapid-pages/resources/css/rapid-ui.css";

## routes/web.php

Route::resource('pages', PageController::class);

Route::get('sections/create', [PageController::class, 'sections_create'])->name('sections.create');
Route::post('sections/store', [PageController::class, 'sections_store'])->name('sections.store');
Route::get('sections/{section}/edit', [PageController::class, 'sections_edit'])->name('sections.edit');
Route::patch('sections/{section}/update', [PageController::class, 'sections_update'])->name('sections.update');
Route::delete('sections/{section}/destroy', [PageController::class, 'sections_destroy'])->name('sections.destroy');

<pre>
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/",
            "Crankd\\RapidPages\\": "packages/crankd/rapid-pages/src"
        }
    },
    </pre>
