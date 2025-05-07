<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Attributes;

use Attribute;
use DMT\XsdBuilder\Types\DataType;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

#[Attribute(Attribute::TARGET_PROPERTY)]
#[NamedArgumentConstructor]
class Element extends Node
{
    /**
     * @template T
     * @param null|string|class-string<T>|DataType $type
     */
    public function __construct(
        string|null $name = null,
        string|DataType|SimpleType|null $type = null,
        public int $minOccurs = 1,
        public int|null $maxOccurs = null,
        bool|float|int|string $default = null
    ) {
        parent::__construct($name, $type, $default);
    }
}
