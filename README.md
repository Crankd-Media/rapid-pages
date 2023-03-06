# Rapid Pages

```
composer require crankd/rapid-pages
```

## LOAD JS FILES

```
php artisan vendor:publish --provider="Crankd\RapidPages\RapidPagesProvider"
```

```
import "../../packages/crankd/rapid-pages/resources/js/rapid-pages.js";
```

## routes/web.php

```

use Crankd\RapidPages\Http\Controllers\PageController;


Route::resource('pages', PageController::class);
Route::get('sections/create', [PageController::class, 'sections_create'])->name('sections.create');
Route::post('sections/store', [PageController::class, 'sections_store'])->name('sections.store');
Route::get('sections/{section}/edit', [PageController::class, 'sections_edit'])->name('sections.edit');
Route::patch('sections/{section}/update', [PageController::class, 'sections_update'])->name('sections.update');
Route::delete('sections/{section}/destroy', [PageController::class, 'sections_destroy'])->name('sections.destroy');
```

## views/frontend/page/edit.blade.php

```
	<x-rapid-pages::edit-page :page="$page"
			route="{{ route('admin.pages.update', $page) }}" />

```

## views/frontend/page/edit.blade.php

```


```

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
