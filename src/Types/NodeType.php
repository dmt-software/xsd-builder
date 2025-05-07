<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Types;

enum NodeType
{
    case Attribute;
    case ComplexType;
    case Element;
    case SimpleType;
}
