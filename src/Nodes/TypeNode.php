<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Nodes;

use DOMDocument;
use DOMElement;
use DOMException;

interface TypeNode
{
    /**
     * Get type as element.
     *
     * @throws DOMException on error creating element
     */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement;
}
