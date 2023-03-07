# Rapid Pages

# Install

```
composer require crankd/rapid-pages
```

```
// all
php artisan vendor:publish --provider="Crankd\RapidPages\RapidPagesProvider"

// or
php artisan vendor:publish --tag=rapid-pages-config
php artisan vendor:publish --tag=rapid-pages-models
php artisan vendor:publish --tag=rapid-pages-migrations
php artisan vendor:publish --tag=rapid-pages-js
php artisan vendor:publish --tag=rapid-pages-css
php artisan vendor:publish --tag=rapid-pages-views

```

# Resources

## Js

```
import "../crankd/rapid/js/rapid-ui.js";
import "../crankd/rapid/js/rapid-pages.js";
```

## Css

```
@import "../crankd/rapid/css/rapid-ui.css";
@import "../crankd/rapid/css/rapid-pages.css";
```

# Routes

## routes/web.php

```
/*
|----------------------------------------------
| Pages
|----------------------------------------------
|
*/

use Crankd\RapidPages\Http\Controllers\PageController;

$page_middleware = config('rapid-pages.routes.admin.middleware');
Route::prefix('admin')->name('admin.')->middleware($page_middleware)->group(function () {
    Route::resource('pages', PageController::class);
    Route::get('sections/create', [PageController::class, 'sections_create'])->name('sections.create');
    Route::post('sections/store', [PageController::class, 'sections_store'])->name('sections.store');
    Route::get('sections/{section}/edit', [PageController::class, 'sections_edit'])->name('sections.edit');
    Route::patch('sections/{section}/update', [PageController::class, 'sections_update'])->name('sections.update');
    Route::delete('sections/{section}/destroy', [PageController::class, 'sections_destroy'])->name('sections.destroy');
});

Route::get('/{page:slug}', [PageController::class, 'show'])->name('pages.show');

```

# Publish Views

admin/page/index.blade.php
admin/page/section-crud.blade.php

app/page/edit.blade.php
app/page/show.blade.php

```
php artisan vendor:publish --tag=rapid-pages-publishes


```

## /admin/page/index.blade.php

```

```

# Components

## page-index

```
<x-rapid-pages::page-index :pages="$pages" />
```

## edit-page

```
<x-rapid-pages::edit-page :page="$page" />
```

## show-page

```
<x-rapid-pages::show-page :page="$page" />
```

## section-index

```
<x-rapid-pages::section-index :sections="$sections" />
```

## section-crud

```
<x-rapid-pages::section-crud :section="$section" />
```

# Config

## get config values

```
$create_page_route = config('rapid-pages.routes.admin.pages.create');
```
