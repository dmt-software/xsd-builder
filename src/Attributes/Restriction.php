<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Attributes;

use Attribute;
use DMT\XsdBuilder\Types\DataType;

#[Attribute(Attribute::TARGET_CLASS)]
class Restriction
{
    public DataType $base;
}
