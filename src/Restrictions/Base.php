<?php

namespace DMT\XsdBuilder\Restrictions;

use DMT\XsdBuilder\Elements\Schema;
use DMT\XsdBuilder\Types\DataType;
use DOMDocument;
use DOMElement;

class Base implements Restriction
{
    public function __construct(private readonly DataType $base,)
    {
    }

    /**
     * @inheritDoc
     */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement
    {
        $restriction = $document->createElementNS(Schema::NAMESPACE, 'restriction');
        $restriction->setAttribute('base', $this->base->type());

        return $restriction;
    }
}