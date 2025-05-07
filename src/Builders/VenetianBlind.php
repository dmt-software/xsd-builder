<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Builders;

use DMT\XsdBuilder\Elements\ParentType;
use DMT\XsdBuilder\Elements\Schema;
use DMT\XsdBuilder\Factories\AttributeFactory;
use DMT\XsdBuilder\Factories\ComplexTypeFactory;
use DMT\XsdBuilder\Factories\ElementFactory;
use DMT\XsdBuilder\Factories\SimpleTypeFactory;
use DMT\XsdBuilder\Restrictions\Base;
use DMT\XsdBuilder\Restrictions\Restriction;
use DMT\XsdBuilder\Types\ListType;
use DOMDocument;

class VenetianBlind implements Builder
{
    private ParentType $current;

    public function __construct(
        private readonly Schema $schema,
        private readonly ListType $listType = ListType::Sequence,
    ) {
        $this->current = $schema;
    }

    /**
     * @inheritDoc
     */
    public function addSimpleType(string $name, mixed $type, Restriction $restriction = null): void
    {
        $factory = SimpleTypeFactory::create($name, $type);
        $factory->setRestriction($restriction ?? new Base($type));

        $this->schema->addSimpleType($factory->build());
    }

    /**
     * @inheritDoc
     */
    public function addComplexType(string $name, mixed $type = null): void
    {
        $this->current = ComplexTypeFactory::create($name, $type ?? $this->listType)->build();

        $this->schema->addComplexType($this->current);
    }

    /**
     * @inheritDoc
     */
    public function addAttribute(string $name, mixed $type, array $attributes = []): void
    {
        $factory = AttributeFactory::create($name, $type);

        if (array_key_exists('use', $attributes)) {
            $factory->setUse($attributes['use']);
        }
        if (array_key_exists('default', $attributes)) {
            $factory->setDefault($attributes['default']);
        }

        $this->current->addAttribute($factory->build());
    }

    /**
     * @inheritDoc
     */
    public function addElement(string $name, mixed $type, array $attributes = []): void
    {
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

        $this->current->addElement($factory->build());
    }

    /**
     * @inheritDoc
     */
    public function build(): DOMDocument
    {
        return $this->schema->renderSchema();
    }
}
