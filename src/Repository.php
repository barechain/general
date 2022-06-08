<?php

declare(strict_types=1);

namespace Barechain\General;

use Illuminate\Database\Eloquent\{Builder, Model};
use RuntimeException;

abstract class Repository
{
    protected string $model;

    /**
     * Begin querying the model on a given connection
     */
    protected function query(?string $connection = null): Builder
    {
        $this->validateModelProperty();

        return is_null($connection) ? $this->model::query() : $this->model::on($connection);
    }

    /**
     * Get table associated with the model
     */
    protected function getTable(): string
    {
        $this->validateModelProperty();

        return (new $this->model())->getTable();
    }

    /**
     * Validate model property
     *
     * @throws RuntimeException
     */
    private function validateModelProperty(): void
    {
        if (!isset($this->model)) {
            throw new RuntimeException(sprintf('Property "%s::$model" is not defined', static::class));
        }

        if (!is_subclass_of($this->model, Model::class)) {
            throw new RuntimeException(sprintf(
                'Value "%s" in property "%s::$model" must be name of Model class',
                $this->model,
                static::class,
            ));
        }
    }
}
