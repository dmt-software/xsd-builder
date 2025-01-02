<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Elements;

use DMT\XsdBuilder\Types\ListType;
use DOMDocument;
use DOMElement;

class ComplexType implements Type
{
    /** @var array<int, Type> */
    private array $elements = [];
    /** @var array<int, AttributeNode> */
    private array $attributes = [];

    public function __construct(
        private readonly string|null $name = null,
        private readonly ListType $list = ListType::Sequence
    ) {
    }

    /** @inheritDoc */
    public function getNodeName(): string|null
    {
        return $this->name;
    }

    /**
     * Add element to complex type.
     */
    public function addElement(ElementNode $element): self
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * Add attribute to complex type.
     */
    public function addAttribute(AttributeNode $attribute): self
    {
        $this->attributes[] = $attribute;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement
    {
        $type = $document->createElementNS(Schema::NAMESPACE, 'complexType');

        if ($this->name !== null) {
            $type->setAttribute('name', $this->name);
        }

        if ($this->elements) {
            $container = $document->createElementNS(Schema::NAMESPACE, $this->list->value);

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
