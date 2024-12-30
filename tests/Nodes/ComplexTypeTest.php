<?php

declare(strict_types=1);

namespace DMT\Test\XsdBuilder\Nodes;

use DMT\XsdBuilder\DataType;
use DMT\XsdBuilder\ListType;
use DMT\XsdBuilder\Nodes\Attribute;
use DMT\XsdBuilder\Nodes\ComplexType;
use DMT\XsdBuilder\Nodes\Element;
use PHPUnit\Framework\TestCase;

class ComplexTypeTest extends TestCase
{
    public function testToNode(): void
    {
        $complexType = new ComplexType('foo');
        $complexType->addElement(new Element('bar', DataType::String));
        $complexType->addAttribute(new Attribute('baz', DataType::Integer));

        $element = $complexType->toNode();

        $this->assertSame('complexType', $element->localName);
        $this->assertSame(ListType::Sequence->value, $element->childNodes[0]->localName);
        $this->assertSame('element', $element->childNodes[0]->childNodes[0]->localName);
        $this->assertSame('bar', $element->childNodes[0]->childNodes[0]->getAttribute('name'));
        $this->assertSame(DataType::String->type(), $element->childNodes[0]->childNodes[0]->getAttribute('type'));
        $this->assertSame('attribute', $element->childNodes[1]->localName);
    }

    public function testToNodeWithAllContainer(): void
    {
        $complexType = new ComplexType('foo', ListType::All);
        $complexType->addElement(new Element('bar', DataType::String));

        $element = $complexType->toNode();

        $this->assertSame('complexType', $element->localName);
        $this->assertSame(ListType::All->value, $element->childNodes[0]->localName);
        $this->assertSame('element', $element->childNodes[0]->childNodes[0]->localName);
    }
}
