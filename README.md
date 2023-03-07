# Rapid Pages

# Install

```
composer require crankd/rapid-pages
```

```
php artisan vendor:publish --provider="Crankd\RapidPages\RapidPagesProvider"
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

# Views

## views/admin/page/index.blade.php

```

```

## resources/views/admin/page/section-crud.blade.php

```
<x-rapid-pages::section-index :sections="$sections" />
```

## views/frontend/page/edit.blade.php

```
	<x-rapid-pages::edit-page :page="$page"
			route="{{ route('admin.pages.update', $page) }}" />

```

## views/frontend/page/edit.blade.php

```


```

# Components

## page-index

```
<x-rapid-pages::page-index :pages="$pages" />
```

## page-edit

```
<x-rapid-pages::edit-page :page="$page" />
```

## section-index

```
<x-rapid-pages::section-index :sections="$sections" />
```

## section-crud

```
<x-rapid-pages::section-crud :section="$section" />
```
