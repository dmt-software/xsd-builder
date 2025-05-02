<?php

namespace DMT\XsdBuilder\Attributes;

use Attribute;
use DMT\XsdBuilder\Types\DataType;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

#[Attribute(Attribute::TARGET_PROPERTY)]
#[NamedArgumentConstructor]
class Element extends Node
{
    public null|string $default = null;

    /**
     * @template T
     * @param null|string|class-string<T>|DataType $type
     */
    public function __construct(
        null|string $name = null,
        null|string|DataType $type = null,
        public int $minOccurs = 1,
        public int $maxOccurs = 1,
        bool|float|int|string $default = null
    ) {
        parent::__construct($name, $type, $default);
    }
}
