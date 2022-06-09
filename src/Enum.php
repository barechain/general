<?php

declare(strict_types=1);

namespace Barechain\General;

use Illuminate\Support\Collection;
use ReflectionClass;

abstract class Enum
{
    protected static array $cache = [];

    /**
     * To array
     */
    final public static function toArray(): array
    {
        if (!empty(static::$cache[static::class])) {
            return static::$cache[static::class];
        }

        return static::$cache[static::class] = (new ReflectionClass(static::class))->getConstants();
    }

    /**
     * Search value and return key if successful
     *
     * @param mixed $value
     */
    final public static function search($value): ?string
    {
        return array_search($value, static::toArray(), true) ?: null;
    }

    /**
     * Create collection
     */
    final public static function collect(): Collection
    {
        return new Collection(static::toArray());
    }
}
