<?php

declare(strict_types=1);

namespace Barechain\General;

use Illuminate\Contracts\Container\Container;
use Sentry\Laravel\Integration;

class FlushSentryEvents
{
    /**
     * Create the event listener
     */
    public function __construct(private Container $container)
    {
    }

    /**
     * Handle the event
     */
    public function handle(): void
    {
        if ($this->container->bound('sentry')) {
            $sentry = $this->container->make('sentry');
            $sentry->getClient()->getIntegration(Integration::class)->flushEvents();

            // todo debug
            echo 'Flushing events to sentry complete' . PHP_EOL;
        }
    }
}