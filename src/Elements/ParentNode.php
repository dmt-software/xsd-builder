<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Elements;

use InvalidArgumentException;

interface ParentNode
{
    /**
     * Add simpleType to schema or element.
     *
     * @throws InvalidArgumentException
     */
    public function addSimpleType(SimpleType $simpleType): ParentNode;

    /**
     * Add complexType to schema or element.
     *
     * @throws InvalidArgumentException
     */
    public function addComplexType(ComplexType $complexType): ParentNode;
}
