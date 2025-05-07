<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Metadata;

use DMT\XsdBuilder\Types\DataType;
use DMT\XsdBuilder\Types\NodeType;
use DMT\XsdBuilder\Types\UseType;

class PropertyMetadata
{
    /**
     * The name of the property.
     */
    public string $propertyName;

    /**
     * The name of the element/attribute.
     */
    public null|string $name = null;

    /**
     * Type of the element/attribute.
     *
     * @template T
     * @var DataType|class-string<T>|string|null
     */
    public null|DataType|string $type = null;

    /**
     * Type of node: element or attribute.
     *
     * @var NodeType|null
     */
    public null|NodeType $nodeType = NodeType::Element;

    /**
     * Minimal occurrence of the element.
     */
    public null|int $minOccurs = null;

    /**
     * Maximal occurrence of the element.
     */
    public null|int|string $maxOccurs = null;

    /**
     * Use of the attribute.
     */
    public null|UseType $use = null;

    /**
     * Default value for the element.
     */
    public mixed $default = null;
}
