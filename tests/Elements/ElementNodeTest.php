<?php

declare(strict_types=1);

namespace DMT\Test\XsdBuilder\Elements;

use DMT\XsdBuilder\Elements\ComplexType;
use DMT\XsdBuilder\Elements\ElementNode;
use DMT\XsdBuilder\Elements\SimpleType;
use DMT\XsdBuilder\Types\DataType;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ElementNodeTest extends TestCase
{
    public function testElementToNode(): void
    {
        $element = new ElementNode('firstname', DataType::String, '0', 'unbounded', '*unknown*');

        $node = $element->toNode();

        $this->assertSame('element', $node->localName);
        $this->assertSame('firstname', $node->getAttribute('name'));
        $this->assertSame(DataType::String->type(), $node->getAttribute('type'));
        $this->assertSame('0', $node->getAttribute('minOccurs'));
        $this->assertSame('unbounded', $node->getAttribute('maxOccurs'));
        $this->assertSame('*unknown*', $node->getAttribute('default'));
    }

    public function testElementForSimpleTypeToNode(): void
    {
        $element = new ElementNode('title', new SimpleType(null, DataType::String), default: 'none');

        $node = $element->toNode();

        $this->assertSame('title', $node->getAttribute('name'));
        $this->assertSame('simpleType', $node->childNodes[0]->localName);
        $this->assertSame(DataType::String->type(), $node->childNodes[0]->getAttribute('type'));
        $this->assertSame('none', $node->getAttribute('default'));
    }

    public function testElementForComplexTypeToNode(): void
    {
        $element = new ElementNode('title', new ComplexType());

        $node = $element->toNode();

        $this->assertSame('title', $node->getAttribute('name'));
        $this->assertSame('complexType', $node->childNodes[0]->localName);
    }

    public function testElementWithInvalidArguments(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ElementNode('error', new ComplexType('foo'), default: 'true');
    }
}
