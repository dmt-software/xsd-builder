<?php

declare(strict_types=1);

namespace DMT\Test\XsdBuilder\Nodes;

use DMT\XsdBuilder\DataType;
use DMT\XsdBuilder\Nodes\ComplexType;
use DMT\XsdBuilder\Nodes\Element;
use DMT\XsdBuilder\Nodes\SimpleType;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class ElementTest extends TestCase
{
    public function testElementToNode(): void
    {
        $element = new Element('firstname', DataType::String, 0, 'unbounded', '*unknown*');

        $element = $element->toNode();

        $this->assertSame('element', $element->localName);
        $this->assertSame('firstname', $element->getAttribute('name'));
        $this->assertSame(DataType::String->type(), $element->getAttribute('type'));
        $this->assertSame('0', $element->getAttribute('minOccurs'));
        $this->assertSame('unbounded', $element->getAttribute('maxOccurs'));
        $this->assertSame('*unknown*', $element->getAttribute('default'));
    }

    public function testElementForSimpleTypeToNode(): void
    {
        $element = new Element('title', new SimpleType(null, DataType::String), default: 'none');

        $element = $element->toNode();

        $this->assertSame('title', $element->getAttribute('name'));
        $this->assertSame('simpleType', $element->childNodes[0]->localName);
        $this->assertSame(DataType::String->type(), $element->childNodes[0]->getAttribute('type'));
        $this->assertSame('none', $element->getAttribute('default'));
    }

    public function testElementForComplexTypeToNode(): void
    {
        $element = new Element('title', new ComplexType());

        $element = $element->toNode();

        $this->assertSame('title', $element->getAttribute('name'));
        $this->assertSame('complexType', $element->childNodes[0]->localName);
    }

    #[TestWith([['default' => 'true']])]
    #[TestWith([['maxOccurs' => '123']])]
    public function testElementWithInvalidArguments(array $arguments = []): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Element('error', new ComplexType('foo'), ...$arguments);
    }
}
