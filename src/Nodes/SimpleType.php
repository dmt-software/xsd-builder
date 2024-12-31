<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Nodes;

use DMT\XsdBuilder\DataType;
use DMT\XsdBuilder\Restrictions\Restriction;
use DMT\XsdBuilder\Schema;
use DOMDocument;
use DOMElement;

class SimpleType implements TypeNode
{
    public function __construct(
        public readonly string|null $name,
        public readonly DataType|null $type,
        public readonly Restriction|null $restriction = null
    ) {
    }

    /** @inheritDoc */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement
    {
        $type = $document->createElementNS(Schema::namespace, 'simpleType');

        if ($this->name) {
            $type->setAttribute('name', $this->name);
        }

        if ($this->restriction) {
            $type->appendChild($this->restriction->toNode($document));
        } elseif ($this->type) {
            $type->setAttribute('type', $this->type->type());
        }

        return $type;
    }
}
