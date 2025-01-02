<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Restrictions;

use DMT\XsdBuilder\Elements\Schema;
use DMT\XsdBuilder\Types\DataType;
use DOMDocument;
use DOMElement;

/**
 * Create restriction based on a regular expression.
 *
 * <xs:restriction base="xs:string">
 *     <xs:pattern value="[0-9]"/>
 * </xs:restriction>
 */
class Expression implements Restriction
{
    public function __construct(
        private readonly DataType $base,
        private readonly string $expression,
    ) {
    }

    /** @inheritDoc */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement
    {
        $pattern = $document->createElementNS(Schema::namespace, 'pattern');
        $pattern->setAttribute('value', $this->expression);

        $restriction = $document->createElementNS(Schema::namespace, 'restriction');
        $restriction->setAttribute('base', $this->base->type());
        $restriction->appendChild($pattern);

        return $restriction;
    }
}
