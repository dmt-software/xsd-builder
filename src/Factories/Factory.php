<?php

namespace DMT\XsdBuilder\Factories;

use DMT\XsdBuilder\DataType;
use DMT\XsdBuilder\Nodes\Attribute;
use DMT\XsdBuilder\Nodes\Element;
use DMT\XsdBuilder\Nodes\SimpleType;
use DMT\XsdBuilder\Nodes\TypeNode;
use DMT\XsdBuilder\Restrictions\Enumeration;
use DMT\XsdBuilder\Restrictions\Expression;
use DMT\XsdBuilder\UseType;
use InvalidArgumentException;

class Factory
{
    public function createElement(string $name, string $type, array $arguments = []): Element
    {
        return new Element($name, DataType::tryFrom($type) ?? $type, ...$arguments);
    }

    public function createElementForType(TypeNode $type, array $arguments = []): Element
    {
        return new Element(null, $type, ...$arguments);
    }

    public function createSimpleType(string|null $name, string $type): SimpleType
    {
        return new SimpleType($name, DataType::from($type));
    }

    public function createSimpleTypeWithEnumeration(string|null $name, string $type, array $enumerations): SimpleType
    {
        return new SimpleType($name, null, new Enumeration(DataType::from($type), $enumerations));
    }

    public function createSimpleTypeWithExpression(string|null $name, string $type, string $expression): SimpleType
    {
        return new SimpleType($name, null, new Expression(DataType::from($type), $expression));
    }

    public function createAttribute(string $name, string|null $type, mixed $default, string|null $use): Attribute
    {
        if (!is_null($default) && !is_scalar($default)) {
            throw new InvalidArgumentException('Default value must be a boolean, integer, float or string');
        }

        if (is_bool($default)) {
            $default = $default ? 'true' : 'false';
        }

        return new Attribute($name, DataType::from($type), (string)$default, UseType::from($use));
    }
}
