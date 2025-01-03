<?php

namespace DMT\Test\XsdBuilder\Factories;

use DMT\XsdBuilder\Elements\ElementNode;
use DMT\XsdBuilder\Factories\ComplexTypeFactory;
use DMT\XsdBuilder\Types\DataType;
use DMT\XsdBuilder\Types\ListType;
use DMT\XsdBuilder\Types\SchemaType;
use PHPUnit\Framework\TestCase;

class ComplexTypeFactoryTest extends TestCase
{
    public function testCreateComplexType(): void
    {
        $complexType = ComplexTypeFactory::create('userType', null)->build();
        $complexType->addElement(new ElementNode('name', DataType::String));

        $node = $complexType->toNode();

        $this->assertSame('complexType', $node->localName);
        $this->assertSame('userType', $node->getAttribute('name'));
        $this->assertSame(ListType::Sequence->value, $node->firstChild->localName);
    }

    public function testCreateComplexTypeWithAllListType(): void
    {
        $complexType = ComplexTypeFactory::create('userType', ListType::All)->build();
        $complexType->addElement(new ElementNode('name', DataType::String));

        $node = $complexType->toNode();

        $this->assertSame('complexType', $node->localName);
        $this->assertSame('userType', $node->getAttribute('name'));
        $this->assertSame(ListType::All->value, $node->firstChild->localName);
    }

    public function testCreateComplexTypeWithRussianDollDesign(): void
    {
        $complexType = ComplexTypeFactory::create('userType', null, SchemaType::RussianDoll)->build();
        $complexType->addElement(new ElementNode('name', DataType::String));

        $node = $complexType->toNode();

        $this->assertSame('complexType', $node->localName);
        $this->assertEmpty($node->getAttribute('name'));
        $this->assertSame('sequence', $node->firstChild->localName);
    }
}
