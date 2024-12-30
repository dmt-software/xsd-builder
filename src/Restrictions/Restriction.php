<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Restrictions;

use DOMDocument;
use DOMElement;
use DOMException;

interface Restriction
{
    /**
     * Get restriction as element.
     *
     * @throws DOMException on error creating element
     */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement;
}
