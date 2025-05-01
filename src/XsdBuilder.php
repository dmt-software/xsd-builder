<?php

namespace DMT\XsdBuilder;

use DMT\XsdBuilder\Builders\Builder;
use DMT\XsdBuilder\Elements\ParentNode;
use DMT\XsdBuilder\Elements\ParentType;
use DMT\XsdBuilder\Elements\Schema;
use DMT\XsdBuilder\Elements\Type;
use DMT\XsdBuilder\Restrictions\Restriction;
use DMT\XsdBuilder\Types\ListType;
use DOMDocument;
use DOMException;
use InvalidArgumentException;

class XsdBuilder implements Builder
{
    public function __construct(
        private readonly Builder $builder,
    ) {
    }

    /**
     * Add simple type to schema or current element.
     *
     * @param string $name The name of the simple type.
     * @param mixed $type The type of the simple type.
     * @param Restriction|null $restriction The restriction of the simple type [optional].
     *
     * @throws InvalidArgumentException
     */
    public function addSimpleType(string $name, mixed $type, Restriction|null $restriction = null): void
    {
        $this->builder->addSimpleType($name, $type, $restriction);
    }

    /**
     * Add complex type to schema or current element.
     *
     * @param string $name The name of the complex type.
     * @param ListType|string|null $type The container type of the complex type [sequence|all].
     *
     * @throws InvalidArgumentException
     */
    public function addComplexType(string $name, mixed $type = null): void
    {
        $this->builder->addComplexType($name, $type);
    }

    /**
     * Add element to schema or current node.
     *
     * @param string $name The name of the element.
     * @param Type|string $type The type of the element.
     * @param array<string, mixed> $attributes Extra attributes for the element (minOccurs, maxOccurs, default).
     *
     * @throws InvalidArgumentException
     */
    public function addElement(string $name, mixed $type, array $attributes = []): void
    {
        $this->builder->addElement($name, $type, $attributes);
    }

    /**
     * Add attribute to schema or current node.
     *
     * @param string $name The name of the attribute.
     * @param Type|string $type The type of the attribute.
     * @param array<string, mixed> $attributes Extra attributes for the attribute (use, default).
     *
     * @throws InvalidArgumentException
     */
    public function addAttribute(string $name, mixed $type, array $attributes = []): void
    {
        $this->builder->addAttribute($name, $type, $attributes);
    }

    /**
     * Render and return schema.
     *
     * @throws DOMException
     */
    public function build(): DOMDocument
    {
        return $this->builder->build();
    }
}
