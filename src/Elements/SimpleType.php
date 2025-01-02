<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Elements;

use DMT\XsdBuilder\Restrictions\Restriction;
use DMT\XsdBuilder\Types\DataType;
use DOMDocument;
use DOMElement;

class SimpleType implements Type
{
    public function __construct(
        private readonly string|null $name,
        private readonly DataType|null $type,
        private readonly Restriction|null $restriction = null
    ) {
    }

    /** @inheritDoc */
    public function getNodeName(): string|null
    {
        return $this->name;
    }

    /** @inheritDoc */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement
    {
        $type = $document->createElementNS(Schema::NAMESPACE, 'simpleType');

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
