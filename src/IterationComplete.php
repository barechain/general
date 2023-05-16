<?php

declare(strict_types=1);

namespace Barechain\General;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IterationComplete
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
}