<?php

declare(strict_types=1);

namespace Barechain\General;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;

abstract class Dto implements Arrayable
{
    protected static array $propertiesCache = [];

    /**
     * Dto constructor
     */
    public function __construct(array $data)
    {
        $this->setProperties($data);
    }

    /**
     * Deny set dynamic properties
     *
     * @param mixed $value
     */
    final public function __set(string $name, $value): void
    {
        throw new RuntimeException(sprintf('Forbidden to define dynamic property %s::$%s', static::class, $name));
    }

    /**
     * Get all items in the Dto
     */
    final public function all(): array
    {
        foreach ($this->getProperties() as $property) {
            $array[$property] = $this->{$property};
        }

        return $array ?? [];
    }

    /**
     * Convert to array
     */
    final public function toArray(): array
    {
        return array_map(
            fn ($value) => $value instanceof Arrayable ? $value->toArray() : $value,
            $this->all()
        );
    }

    /**
     * Create collection
     */
    final public function collect(): Collection
    {
        return new Collection($this->all());
    }

    /**
     * Set properties
     */
    private function setProperties(array $data): void
    {
        $defaultProperties = get_object_vars($this);

        foreach ($this->getProperties() as $property) {
            if (array_key_exists($property, $data)) {
                $this->{$property} = $data[$property];
                unset($data[$property]);

                continue;
            }

            if (array_key_exists($property, $defaultProperties)) {
                continue;
            }

            throw new RuntimeException(sprintf('Required property %s::$%s', static::class, $property));
        }

        if (count($data)) {
            throw new RuntimeException(sprintf(
                'Unknown properties provided to %s: %s',
                static::class,
                json_encode(array_keys($data))
            ));
        }
    }

    /**
     * Get properties
     */
    private function getProperties(): array
    {
        if (isset(static::$propertiesCache[static::class])) {
            return static::$propertiesCache[static::class];
        }

        return static::$propertiesCache[static::class] = $this->getReflectionProperties();
    }

    /**
     * Get properties by Reflection API
     */
    private function getReflectionProperties(): array
    {
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $keys[] = $property->name;
            }
        }

        return $keys ?? [];
    }
}
