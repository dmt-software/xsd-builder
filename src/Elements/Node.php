<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Elements;

use DOMDocument;
use DOMElement;
use DOMException;

interface Node
{
    /**
     * Get element/attribute as element.
     *
     * @throws DOMException on error creating element
     */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement;
}
