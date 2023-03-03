<?php

namespace Crankd\RapidPages\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait PageTrait
{
    // boot when creating a new page
    public static function bootPageTrait()
    {

        static::creating(function ($page) {
            // when creating a page first check if slug is set if not set it
            if (!$page->slug) {
                $page->slug = Str::slug($page->title);
            }

            // if slug is set check if it is unique if not make it unique
            if (static::where('slug', $page->slug)->exists()) {
                $page->slug = $page->slug . '-' . Str::random(5);
            }
        });
    }

    /**
     * Scope a query to only include pages with a given status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        // use congif to set route key
        return config('laravel-pages.route_key', 'slug');
    }
}
