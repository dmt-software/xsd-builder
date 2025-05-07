<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Metadata\Readers;

use DMT\XsdBuilder\Attributes\Attribute;
use DMT\XsdBuilder\Attributes\ComplexType;
use DMT\XsdBuilder\Attributes\Element;
use DMT\XsdBuilder\Attributes\SimpleType;
use DMT\XsdBuilder\Metadata\ClassMetadata;
use DMT\XsdBuilder\Metadata\PropertyMetadata;
use DMT\XsdBuilder\Types\DataType;
use DMT\XsdBuilder\Types\NodeType;
use ReflectionClass;
use ReflectionProperty;
use Spiral\Attributes\ReaderInterface;

class AttributeReader implements Reader
{
    public function __construct(private ReaderInterface $reader)
    {
    }

    public function readComplexType(ReflectionClass $reflectionClass): ClassMetadata
    {
        $type = $this->reader->firstClassMetadata($reflectionClass, ComplexType::class);

        $metadata = new ClassMetadata();
        $metadata->nodeType = NodeType::ComplexType;
        $metadata->name = $type?->name ?? null;
        $metadata->list = $type?->list ?? null;

        return $metadata;
    }

    public function readSimpleType(ReflectionProperty $reflectionProperty): ClassMetadata
    {
        $type = $this->reader->firstPropertyMetadata($reflectionProperty, SimpleType::class);

        $metadata = new ClassMetadata();
        $metadata->nodeType = NodeType::SimpleType;
        $metadata->name = $type?->name ?? null;
        $metadata->list = null;

        return $metadata;
    }

    public function readElement(ReflectionProperty $reflectionProperty): PropertyMetadata
    {
        $node = $this->reader->firstPropertyMetadata($reflectionProperty, Element::class);

        $typeHint = $reflectionProperty->getType()?->getName();
        if ($typeHint) {
            if (!$node->type && class_exists($typeHint)) {
                $node->type = $typeHint;
            } elseif (!$node->maxOccurs && $typeHint == 'array') {
                $node->maxOccurs = 'unbounded';
            }
        }

        $metadata = new PropertyMetadata();
        $metadata->nodeType = NodeType::Element;
        $metadata->name = $node->name;
        $metadata->type = $node->type;
        $metadata->minOccurs = $node->minOccurs;
        $metadata->maxOccurs = $node->maxOccurs;
        $metadata->default = $node->default;

        return $metadata;
    }

    public function readAttribute(ReflectionProperty $reflectionProperty): PropertyMetadata
    {
        $node = $this->reader->firstPropertyMetadata($reflectionProperty, Attribute::class);

        $typeHint = $reflectionProperty->getType()?->getName();

        if (!$node->type && $typeHint) {
            $node->type = DataType::tryFrom($typeHint);
        }

        $metadata = new PropertyMetadata();
        $metadata->nodeType = NodeType::Attribute;
        $metadata->name = $node->name;
        $metadata->type = $node->type;
        $metadata->minOccurs = $node->use ?? null;
        $metadata->default = $node->default;

        return $metadata;
    }
}
