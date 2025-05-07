<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Metadata;

use DMT\XsdBuilder\Types\ListType;
use DMT\XsdBuilder\Types\NodeType;

class ClassMetadata
{
    /**
     * The class representing the complex type.
     *
     * @template T
     * @var null|class-string<T>
     */
    public null|string $className = null;

    /**
     * Name of the complex type
     */
    public null|string $name = null;

    /**
     * The type of the container to hold the elements.
     */
    public null|ListType $list = ListType::Sequence;

    /**
     * Type of node: simple or complex type.
     */
    public null|NodeType $nodeType = NodeType::ComplexType;

    /**
     * List of properties for the class.
     *
     * @var array<string, PropertyMetadata>
     */
    public array $properties = [];
}
