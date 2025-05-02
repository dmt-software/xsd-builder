<?php

namespace DMT\XsdBuilder\Attributes;

use Attribute;
use DMT\XsdBuilder\Types\ListType;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

#[Attribute(Attribute::TARGET_CLASS)]
#[NamedArgumentConstructor]
class ComplextType extends Type
{
    public function __construct(string $name = null, ListType $list = ListType::Sequence)
    {
        parent::__construct($name);
    }
}
