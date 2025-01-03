<?php

namespace DMT\XsdBuilder\Builders;

use DMT\XsdBuilder\Elements\ParentNode;
use DMT\XsdBuilder\Elements\ParentType;
use DMT\XsdBuilder\Elements\Schema;
use DMT\XsdBuilder\Factories\AttributeFactory;
use DMT\XsdBuilder\Factories\ComplexTypeFactory;
use DMT\XsdBuilder\Factories\ElementFactory;
use DMT\XsdBuilder\Factories\SimpleTypeFactory;
use DMT\XsdBuilder\Restrictions\Restriction;

class VenetianBlind implements Builder
{
    private Schema $schema;

    /**
     * @inheritDoc
     */
    public function addSimpleType(ParentNode $parent, string $name, mixed $type, Restriction $restriction = null): ParentNode
    {
        if ($parent instanceof Schema) {
            $this->schema = $parent;
        }

        $factory = SimpleTypeFactory::create($name, $type);

        if ($restriction) {
            $factory->setRestriction($restriction);
        }

        return $this->schema->addSimpleType($factory->build());
    }

    /**
     * @inheritDoc
     */
    public function addComplexType(ParentNode $parent, string $name, mixed $type): ParentType
    {
        if ($parent instanceof Schema) {
            $this->schema = $parent;
        }

        $this->schema->addComplexType($complexType = ComplexTypeFactory::create($name, $type)->build());

        return $complexType;
    }

    /**
     * @inheritDoc
     */
    public function addAttribute(ParentType $parent, string $name, mixed $type, array $attributes = []): ParentType
    {
        if ($parent instanceof Schema) {
            $this->schema = $parent;
        }

        $factory = AttributeFactory::create($name, $type);

        if (array_key_exists('use', $attributes)) {
            $factory->setUse($attributes['use']);
        }
        if (array_key_exists('default', $attributes)) {
            $factory->setDefault($attributes['default']);
        }

        return $parent->addAttribute($factory->build());
    }

    /**
     * @inheritDoc
     */
    public function addElement(ParentType $parent, string $name, mixed $type, array $attributes = []): ParentType
    {
        if ($parent instanceof Schema) {
            $this->schema = $parent;
        }

        $factory = ElementFactory::create($name, $type);

        if (array_key_exists('minOccurs', $attributes)) {
            $factory->setMinOccurs($attributes['minOccurs']);
        }
        if (array_key_exists('maxOccurs', $attributes)) {
            $factory->setMaxOccurs($attributes['maxOccurs']);
        }
        if (array_key_exists('default', $attributes)) {
            $factory->setDefault($attributes['default']);
        }

        return $parent->addElement($factory->build());
    }
}
