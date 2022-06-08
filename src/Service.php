<?php

declare(strict_types=1);

namespace Barechain\General;

use Illuminate\Foundation\Application;

abstract class Service
{
    protected Application $app;

    /**
     * Service constructor
     */
    public function __construct()
    {
        $this->app = self::getAppInstance();
    }

    /**
     * Get app instance
     */
    protected static function getAppInstance(): Application
    {
        return Application::getInstance();
    }
}
