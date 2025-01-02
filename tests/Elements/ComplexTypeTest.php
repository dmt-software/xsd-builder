<?php

declare(strict_types=1);

namespace DMT\Test\XsdBuilder\Elements;

use DMT\XsdBuilder\Elements\AttributeNode;
use DMT\XsdBuilder\Elements\ComplexType;
use DMT\XsdBuilder\Elements\ElementNode;
use DMT\XsdBuilder\Types\DataType;
use DMT\XsdBuilder\Types\ListType;
use PHPUnit\Framework\TestCase;

class ComplexTypeTest extends TestCase
{
    public function testToNode(): void
    {
        $complexType = new ComplexType('foo');
        $complexType->addElement(new ElementNode('bar', DataType::String));
        $complexType->addAttribute(new AttributeNode('baz', DataType::Integer));

        $node = $complexType->toNode();

        $this->assertSame('complexType', $node->localName);
        $this->assertSame(ListType::Sequence->value, $node->childNodes[0]->localName);
        $this->assertSame('element', $node->childNodes[0]->childNodes[0]->localName);
        $this->assertSame('bar', $node->childNodes[0]->childNodes[0]->getAttribute('name'));
        $this->assertSame(DataType::String->type(), $node->childNodes[0]->childNodes[0]->getAttribute('type'));
        $this->assertSame('attribute', $node->childNodes[1]->localName);
    }

    public function testToNodeWithAllContainer(): void
    {
        $complexType = new ComplexType('foo', ListType::All);
        $complexType->addElement(new ElementNode('bar', DataType::String));

        $node = $complexType->toNode();

        $this->assertSame('complexType', $node->localName);
        $this->assertSame(ListType::All->value, $node->childNodes[0]->localName);
        $this->assertSame('element', $node->childNodes[0]->childNodes[0]->localName);
    }
}
