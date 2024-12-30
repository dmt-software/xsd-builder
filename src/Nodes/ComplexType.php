<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Nodes;

use DMT\XsdBuilder\ListType;
use DMT\XsdBuilder\Schema;
use DOMDocument;
use DOMElement;

class ComplexType implements TypeNode
{
    /** @var array<int, TypeNode> */
    private array $elements = [];
    /** @var array<int, Attribute> */
    private array $attributes = [];

    public function __construct(
        private readonly string|null $name = null,
        private readonly ListType $list = ListType::Sequence
    ) {
    }

    /**
     * Add element to complex type.
     */
    public function addElement(Element $element): self
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * Add attribute to complex type.
     */
    public function addAttribute(Attribute $attribute): self
    {
        $this->attributes[] = $attribute;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement
    {
        $type = $document->createElementNS(Schema::namespace, 'complexType');

        if ($this->name !== null) {
            $type->setAttribute('name', $this->name);
        }

        if ($this->elements) {
            $container = $document->createElementNS(Schema::namespace, $this->list->value);

            foreach ($this->elements as $element) {
                $container->appendChild($element->toNode($container->ownerDocument));
            }

            $type->appendChild($container);
        }

        foreach ($this->attributes as $attribute) {
            $type->appendChild($attribute->toNode($document));
        }

        return $type;
    }
}
