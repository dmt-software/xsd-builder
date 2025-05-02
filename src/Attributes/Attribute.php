<?php

namespace DMT\XsdBuilder\Attributes;


use DMT\XsdBuilder\Types\DataType;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
#[NamedArgumentConstructor]
class Attribute extends Node
{
    public function __construct(
        null|string $name = null,
        null|string|DataType $type = null,
        public string $use,
        bool|float|int|string $default = null,
    ) {
        parent::__construct($name, $type, $use);
    }
}
