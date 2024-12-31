<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Nodes;

use DMT\XsdBuilder\DataType;
use DMT\XsdBuilder\Schema;
use DMT\XsdBuilder\UseType;
use DOMDocument;
use DOMElement;
use DOMException;

class Attribute implements Node
{
    public function __construct(
        private readonly string  $name,
        private readonly DataType $type,
        private readonly string|null $default = null,
        private readonly UseType|null $use = null
    ) {
    }

    /** @throws DOMException */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement
    {
        $attribute = $document->createElementNS(Schema::namespace, 'attribute');
        $attribute->setAttribute('name', $this->name);
        $attribute->setAttribute('type', $this->type->type());

        if ($this->default) {
            $attribute->setAttribute('default', $this->default);
        }

        if ($this->use) {
            $attribute->setAttribute('use', $this->use->value);
        }

        return $attribute;
    }
}
