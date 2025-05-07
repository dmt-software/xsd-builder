<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Attributes;


use DMT\XsdBuilder\Types\DataType;
use DMT\XsdBuilder\Types\UseType;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
#[NamedArgumentConstructor]
class Attribute extends Node
{
    public function __construct(
        null|string $name = null,
        null|string|DataType $type = null,
        public UseType|null $use,
        bool|float|int|string $default = null,
    ) {
        parent::__construct($name, $type, $default);
    }
}
