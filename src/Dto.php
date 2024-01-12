<?php

declare(strict_types=1);

namespace Barechain\General;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

abstract class Dto implements Arrayable
{
    /**
     * Get all items in the Dto
     */
    final public function all(): array
    {
        return get_object_vars($this);
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
     * Make new Dto with named arguments
     */
    final public function with(...$values): self
    {
        $data = [];

        foreach ($this->all() as $field => $oldValue) {
            $data[$field] = array_key_exists($field, $values) ? $values[$field] : $oldValue;
        }

        return new static(...$data);
    }
}
