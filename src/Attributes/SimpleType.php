<?php

namespace DMT\XsdBuilder\Attributes;

use Attribute;
use DMT\XsdBuilder\Types\DataType;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
#[NamedArgumentConstructor]
class SimpleType extends Type
{
    public function __construct(
        string $name = null,
        public null|string|DataType $dataType = null,
        public null|Restriction $restriction = null,
    ) {
        parent::__construct($name);

        if ($this->restriction) {
            $this->restriction->base = $this->dataType;
        }
    }
}