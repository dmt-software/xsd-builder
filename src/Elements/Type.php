<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Elements;

use DOMDocument;
use DOMElement;
use DOMException;

interface Type
{
    /**
     * Get the name of the type.
     *
     * @return string|null
     */
    public function getNodeName(): string|null;

    /**
     * Get type as element.
     *
     * @throws DOMException on error creating element
     */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement;
}
