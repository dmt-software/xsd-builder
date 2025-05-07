<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
abstract class Type
{
    public function __construct(public null|string $name = null)
    {
    }
}
