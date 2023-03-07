<?php

namespace Crankd\RapidPages;

use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


class RapidPagesProvider extends ServiceProvider
{

    private const CONFIG_FILE = __DIR__ . '/../config/rapid-pages.php';

    private const RESOURCES_PATH = __DIR__ . '/../resources/';


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->offerPublishing();

        $this->loadViewsFrom(self::RESOURCES_PATH . 'views', 'rapid-pages');

        $this->registerComponents(); // Register the components


    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(self::CONFIG_FILE, 'rapid-pages');
    }

    protected function offerPublishing()
    {
        if (!function_exists('config_path')) {
            // function not available and 'publish' not relevant in Lumen
            return;
        }

        // Config
        $this->publishes([
            self::CONFIG_FILE => config_path('rapid-pages.php'),
        ], 'rapid-pages-config');

        // Models 
        $this->publishes([
            __DIR__ . '/Models' => app_path('Models'),
        ], 'rapid-pages-models');

        // Migrations 
        $this->publishes([
            __DIR__ . '/../database/migrations/create_pages_table.php.stub' => $this->getMigrationFileName('create_pages_table.php'),
        ], 'rapid-pages-migrations');


        // Publish js
        $this->publishes([
            self::RESOURCES_PATH . 'js' => resource_path('crankd/rapid/js'), // Publish the assets
        ], 'rapid-pages-js');

        // Publish css
        $this->publishes([
            self::RESOURCES_PATH . 'css' => resource_path('crankd/rapid/css'), // Publish the assets
        ], 'rapid-pages-css');

        $this->publishes([
            self::RESOURCES_PATH . 'views/publish/admin' => resource_path('views/admin/page'),
            self::RESOURCES_PATH . 'views/publish/app' => resource_path('views/app/page'),
        ], 'rapid-pages-views');
    }


    /**
     * Register the Blade form components.
     *
     * @return $this
     */
    private function registerComponents(): self
    {
        return $this;
    }



    protected function getMigrationFileName($migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');

        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make($this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem, $migrationFileName) {
                return $filesystem->glob($path . '*_' . $migrationFileName);
            })
            ->push($this->app->databasePath() . "/migrations/{$timestamp}_{$migrationFileName}")
            ->first();
    }
}
