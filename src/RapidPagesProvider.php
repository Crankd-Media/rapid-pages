<?php

namespace Crankd\RapidPages;

use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Crankd\RapidPages\View\Components\CodeBlock;


class RapidPagesProvider extends ServiceProvider
{

    private const CONFIG_FILE = __DIR__ . '/../config/rapid-pages.php';

    private const PATH_VIEWS = __DIR__ . '/../resources/views';

    private const PATH_ASSETS = __DIR__ . '/../resources/js';


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->offerPublishing(); // Publish the config file

        $this->loadViewsFrom(self::PATH_VIEWS, 'rapid-pages'); // Load the views

        $this->registerComponents(); // Register the components

        $this->publishes([
            self::PATH_ASSETS => public_path('crankd/rapid-pages/js'), // Publish the assets
        ], 'rapid-pages-publishes');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(self::CONFIG_FILE, 'rapid');
    }

    protected function offerPublishing()
    {
        if (!function_exists('config_path')) {
            // function not available and 'publish' not relevant in Lumen
            return;
        }

        $this->publishes([
            self::CONFIG_FILE => config_path('rapid-pages.php'),
        ], 'rapid-pages-config');
    }


    /**
     * Register the Blade form components.
     *
     * @return $this
     */
    private function registerComponents(): self
    {


        // Blade::component('rapid::page-index', CodeBlock::class);


        // Navigation
        // Blade::component('manage-fields', 'manage-fields');

        // Blade::component('navigation.stacked', Stacked::class);
        // Blade::component('navigation.sidebar', Sidebar::class);

        // Blade::componentNamespace('Crankd\\LaravelPages\\View\\Components\\Navigation', 'stacked');
        // Blade::componentNamespace('Crankd\\LaravelPages\\View\\Components\\Navigation', 'sidebar');
        return $this;
    }
}
