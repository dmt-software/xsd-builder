<?php

namespace DMT\XsdBuilder\Builders;

use DMT\XsdBuilder\Elements\ParentNode;
use DMT\XsdBuilder\Elements\ParentType;
use DMT\XsdBuilder\Restrictions\Restriction;
use InvalidArgumentException;

interface Builder
{
    /**
     * Add an attribute to the complexType or schema.
     *
     * @throws InvalidArgumentException
     */
    public function addAttribute(ParentType $parent, string $name, mixed $type, array $attributes = []): ParentType;

    /**
     * Add a complexType to the schema or element.
     *
     * @throws InvalidArgumentException
     */
    public function addComplexType(ParentNode $parent, string $name, mixed $type): ParentType;

    /**
     * Add an element to the complexType or schema.
     *
     * @throws InvalidArgumentException
     */
    public function addElement(ParentType $parent, string $name, mixed $type, array $attributes = []): ParentType;

    /**
     * Add a simpleType to the schema or element.
     *
     * @throws InvalidArgumentException
     */
    public function addSimpleType(ParentNode $parent, string $name, mixed $type, Restriction $restriction = null): ParentNode;
}
