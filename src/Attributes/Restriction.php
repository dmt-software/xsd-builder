<?php

namespace DMT\XsdBuilder\Attributes;

use Attribute;
use DMT\XsdBuilder\Types\DataType;

#[Attribute(Attribute::TARGET_CLASS)]
class Restriction
{
    public DataType $base;
}
