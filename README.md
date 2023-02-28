# Rapid UI

## LOAD JS FILES

Crankd\RapidPages\RapidPagesProvider::class,

php artisan vendor:publish --provider="Crankd\RapidPages\RapidPagesProvider"

import "../../packages/crankd/rapid-pages/resources/js/rapid-pages";
import "../../packages/crankd/rapid-pages/resources/css/rapid-css.css";

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
