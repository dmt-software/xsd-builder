<?php

namespace DMT\XsdBuilder\Attributes;

use Attribute;
use DMT\XsdBuilder\Types\DataType;

#[Attribute(Attribute::TARGET_CLASS)]
class Expression extends Restriction
{
    public function __construct(public string $value, DataType $base = DataType::String)
    {
        $this->base = $base;
    }
}
