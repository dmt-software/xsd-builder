<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Restrictions;

use DMT\XsdBuilder\DataType;
use DMT\XsdBuilder\Schema;
use DOMDocument;
use DOMElement;

/**
 * Create restriction for a list of values
 *
 * <xs:restriction base="xs:string">
 *      <xs:enumeration value="alpha"/>
 *      <xs:enumeration value="beta"/>
 *  </xs:restriction>
 */
class Enumeration implements Restriction
{
    /**
     * @param array<int, string> $values
     */
    public function __construct(
        private readonly DataType $base,
        private readonly array $values
    ) {
    }

    /** @inheritDoc */
    public function toNode(DOMDocument $document = new DOMDocument()): DOMElement
    {
        $restriction = $document->createElementNS(Schema::namespace, 'restriction');
        $restriction->setAttribute('base', $this->base->type());

        array_map(fn(mixed $value) => $this->addEnumerationForValue($restriction, (string)$value), $this->values);

        return $restriction;
    }

    private function addEnumerationForValue(DOMElement $restriction, string $value): void
    {
        $enumeration = $restriction->ownerDocument->createElementNS(Schema::namespace, 'enumeration');
        $enumeration->setAttribute('value', $value);

        $restriction->appendChild($enumeration);
    }
}
