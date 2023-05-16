<?php

declare(strict_types=1);

namespace Barechain\General;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        IterationComplete::class => [
            FlushSentryEvents::class
        ]
    ];

    /**
     * Register any events for your application
     */
    public function boot(): void
    {
        parent::boot();
    }
}