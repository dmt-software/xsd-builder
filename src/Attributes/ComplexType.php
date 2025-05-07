<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Attributes;

use Attribute;
use DMT\XsdBuilder\Types\ListType;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

#[Attribute(Attribute::TARGET_CLASS)]
#[NamedArgumentConstructor]
class ComplexType extends Type
{
    public function __construct(string $name = null, ListType $list = ListType::Sequence)
    {
        parent::__construct($name);
    }
}
