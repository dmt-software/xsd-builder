<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Elements;

use DMT\XsdBuilder\Types\DataType;
use DMT\XsdBuilder\Types\UseType;
use DOMDocument;
use DOMElement;
use DOMException;

class AttributeNode implements Node
{
    public function __construct(
        private readonly string  $name,
        private readonly DataType|SimpleType|string $type,
        private readonly string|null $default = null,
        private readonly UseType|null $use = null
    ) {
    }

    /** @throws DOMException */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement
    {
        $attribute = $document->createElementNS(Schema::namespace, 'attribute');
        $attribute->setAttribute('name', $this->name);

        if ($this->type instanceof SimpleType) {
            $attribute->appendChild($this->type->toNode($document));
        } else {
            $attribute->setAttribute('type', $this->type instanceof DataType ? $this->type->type() : $this->type);
        }

        if ($this->default) {
            $attribute->setAttribute('default', $this->default);
        }

        if ($this->use) {
            $attribute->setAttribute('use', $this->use->value);
        }

        return $attribute;
    }
}
