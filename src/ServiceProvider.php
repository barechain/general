<?php

declare(strict_types=1);

namespace Barechain\General;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the provided classes
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
    }
}