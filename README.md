# Barechain General Library

Library for general Laravel abstract classes

## Requirements
* PHP >= 8.2
* Laravel >= 9.0

## Installation

```
composer require barechain/general
```

### DTO

```php
<?php

use Barechain\General\Dto;

final class User extends Dto
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly bool $isEnabled = true
    ) {
    }
}

# Make new dto
$dto = new User(firstName: 'John', lastName: 'Doe', isEnabled: true);
$dto = new User('John', 'Doe');
$dto = new User(...['firstName' => 'John', 'lastName' => 'Doe', 'isEnabled' => false]);
$dto = new User(...['John', 'Doe', false]);

# Get all items in the Dto
$dto->all();

# Convert to array
$dto->toArray();

# Create collection
$dto->collect();

# Make new Dto with named arguments
$newDto = $dto->with(isEnabled: false, lastName: 'Smith');
```