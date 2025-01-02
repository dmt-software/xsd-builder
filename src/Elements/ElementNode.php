<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Elements;

use DMT\XsdBuilder\Types\DataType;
use DOMDocument;
use DOMElement;
use DOMException;
use InvalidArgumentException;

class ElementNode implements Node
{
    public function __construct(
        private readonly string               $name,
        private readonly DataType|Type|string $type,
        private readonly string|null          $minOccurs = null,
        private readonly string|null          $maxOccurs = null,
        private readonly string|null          $default = null
    ) {
        if ($default !== null && $type instanceof ComplexType) {
            throw new InvalidArgumentException('Can not set default for ComplexType');
        }
    }

    /** @throws DOMException */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement
    {
        $element = $document->createElementNS(Schema::namespace, 'element');
        $element->setAttribute('name', $this->name);

        $type = $this->type instanceof DataType ? $this->type->type() : $this->type;
        if ($type instanceof Type) {
            $element->appendChild($type->toNode($document));
        } else {
            $element->setAttribute('type', $type);
        }

        if ($this->default !== null && $this->default !== '') {
            $element->setAttribute('default', $this->default);
        }

        if ($this->minOccurs !== null && (int)$this->minOccurs >= 0) {
            $element->setAttribute('minOccurs', $this->minOccurs);
        }

        if ($this->maxOccurs !== null && (!is_numeric($this->maxOccurs) || (int)$this->maxOccurs >= 0)) {
            $element->setAttribute('maxOccurs', $this->maxOccurs);
        }

        return $element;
    }
}