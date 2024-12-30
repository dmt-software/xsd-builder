<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Nodes;

use DMT\XsdBuilder\DataType;
use DMT\XsdBuilder\Schema;
use DOMDocument;
use DOMElement;
use DOMException;
use InvalidArgumentException;

class Element implements Node
{
    public function __construct(
        private readonly string|null $name,
        private readonly DataType|TypeNode|string $type,
        private readonly int|null $minOccurs = null,
        private readonly int|string|null $maxOccurs = null,
        private readonly string|null $default = null
    ) {
        if (is_string($maxOccurs) && $maxOccurs !== 'unbounded') {
            throw new InvalidArgumentException('Value of maxOccurs must be an integer or "unbounded"');
        }

        if ($default !== null && $type instanceof ComplexType) {
            throw new InvalidArgumentException('Can not set default for ComplexType');
        }
    }

    /** @throws DOMException */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement
    {
        $element = $document->createElementNS(Schema::namespace, 'element');

        if ($this->name !== null) {
            $element->setAttribute('name', $this->name);
        }

        $type = $this->type instanceof DataType ? $this->type->type() : $this->type;
        if ($type instanceof TypeNode) {
            $element->appendChild($type->toNode($document));
        } else {
            $element->setAttribute('type', $type);
        }

        if ($this->default !== null && $this->default !== '') {
            $element->setAttribute('default', $this->default);
        }

        if ($this->minOccurs !== null && (int)$this->minOccurs >= 0) {
            $element->setAttribute('minOccurs', (string)$this->minOccurs);
        }

        if ($this->maxOccurs !== null && (is_string($this->maxOccurs) || (int)$this->maxOccurs >= 0)) {
            $element->setAttribute('maxOccurs', (string)$this->maxOccurs);
        }

        return $element;
    }
}